#!/usr/bin/env bash
#
# Windset Farms – pull the LIVE site down into the LOCAL (Local by Flywheel) site.
#
# Run from Local's Site Shell (right-click the site in Local → "Open site shell"):
#     bash ~/Downloads/sync-live-to-local.sh
#
# Preset for: live windsetfarms (ssh alias) at /home/f442bit/public_html
#             local /Users/ld/Local Sites/ai-test-site/app/public
#
# What it does:
#   1. Backs up the local database (Desktop)
#   2. Exports the live database over SSH and imports it locally
#   3. Search-replaces live URLs → local URL
#   4. Syncs wp-content/uploads and wp-content/plugins from live
#   5. Compares (does NOT overwrite) the windsetv3 theme and saves a report
#   6. Deactivates caching plugins, flushes Elementor CSS, permalinks and cache
#
# Your local theme (our git-tracked work) is never overwritten.

set -euo pipefail

# ---------------------------------------------------------------- settings ---
SSH_ALIAS="${SSH_ALIAS:-windsetfarms}"
REMOTE_PATH="${REMOTE_PATH:-/home/f442bit/public_html}"
LOCAL_PATH="${LOCAL_PATH:-/Users/ld/Local Sites/ai-test-site/app/public}"
LOCAL_URL="${LOCAL_URL:-http://localhost:10008}"
LIVE_DOMAIN="windsetfarms.com"
THEME="windsetv3"
CACHE_PLUGINS="wp-rocket litespeed-cache w3-total-cache wp-super-cache autoptimize"

STAMP="$(date +%Y%m%d-%H%M%S)"
WORK="$HOME/Desktop/windset-sync-$STAMP"

# ----------------------------------------------------------------- helpers ---
say()  { printf '\n\033[1;32m▶ %s\033[0m\n' "$*"; }
warn() { printf '\033[1;33m! %s\033[0m\n' "$*"; }
die()  { printf '\033[1;31m✖ %s\033[0m\n' "$*" >&2; exit 1; }

# ------------------------------------------------------------ pre-flight ---
command -v wp    >/dev/null || die "wp (WP-CLI) not found. Run this from Local's Site Shell."
command -v rsync >/dev/null || die "rsync not found."
cd "$LOCAL_PATH" 2>/dev/null || die "Local site folder not found: $LOCAL_PATH"
[ -f wp-config.php ] || die "Run this from the site's app/public folder (Local's Site Shell opens there)."
wp core is-installed >/dev/null 2>&1 || die "WordPress not reachable – is the site started in Local?"

CURRENT_LOCAL_URL="$(wp option get siteurl)"
case "$CURRENT_LOCAL_URL" in
  *"$LIVE_DOMAIN"*) die "This shell's site URL is $CURRENT_LOCAL_URL – that looks like LIVE. Aborting." ;;
esac

[ -n "$SSH_ALIAS" ]   || read -rp "SSH alias for the live server: " SSH_ALIAS
[ -n "$REMOTE_PATH" ] || read -rp "WordPress path on live [~/public_html]: " REMOTE_PATH
REMOTE_PATH="${REMOTE_PATH:-~/public_html}"

say "Checking SSH + live WordPress…"
LIVE_URL="$(ssh "$SSH_ALIAS" "wp option get siteurl --path=$REMOTE_PATH" 2>/dev/null)" \
  || die "Couldn't run WP-CLI on $SSH_ALIAS at $REMOTE_PATH. Check the alias/path."
case "$LIVE_URL" in
  *"$LIVE_DOMAIN"*) ;;
  *) die "Live siteurl is '$LIVE_URL' – expected $LIVE_DOMAIN. Aborting." ;;
esac

echo
echo "  LIVE : $LIVE_URL   ($SSH_ALIAS:$REMOTE_PATH)"
echo "  LOCAL: $CURRENT_LOCAL_URL  →  will become $LOCAL_URL"
echo "  Backups/reports: $WORK"
echo
warn "This REPLACES the local database, uploads and plugins with live's."
read -rp "Type 'sync' to continue: " ok
[ "$ok" = "sync" ] || die "Cancelled."

mkdir -p "$WORK"

# ---------------------------------------------------- 1. backup local DB ---
say "1/6 Backing up local database…"
wp db export "$WORK/local-before-sync.sql" --quiet
echo "    → $WORK/local-before-sync.sql"

# --------------------------------------------- 2. pull + import live DB ---
say "2/6 Exporting live database…"
ssh "$SSH_ALIAS" "wp db export - --path=$REMOTE_PATH | gzip" > "$WORK/live.sql.gz"
[ -s "$WORK/live.sql.gz" ] || die "Live export is empty."
echo "    → $WORK/live.sql.gz ($(du -h "$WORK/live.sql.gz" | cut -f1))"

say "    Importing into local…"
wp db reset --yes --quiet
gunzip -c "$WORK/live.sql.gz" | wp db import - --quiet

# --------------------------------------------------- 3. search-replace ---
say "3/6 Replacing live URLs with $LOCAL_URL…"
for FROM in "https://www.$LIVE_DOMAIN" "https://$LIVE_DOMAIN" "http://www.$LIVE_DOMAIN" "http://$LIVE_DOMAIN"; do
  wp search-replace "$FROM" "$LOCAL_URL" --all-tables --precise --skip-columns=guid --report-changed-only
done
wp option update home    "$LOCAL_URL" --quiet
wp option update siteurl "$LOCAL_URL" --quiet

# ---------------------------------------------- 4. uploads + plugins ---
say "4/6 Syncing uploads (only new/changed files)…"
rsync -az --progress "$SSH_ALIAS:$REMOTE_PATH/wp-content/uploads/" ./wp-content/uploads/

say "    Syncing plugins (mirror of live)…"
rsync -az --delete --progress "$SSH_ALIAS:$REMOTE_PATH/wp-content/plugins/" ./wp-content/plugins/

# ------------------------------------------- 5. theme comparison only ---
say "5/6 Comparing theme '$THEME' with live (no changes made)…"
rsync -azn --delete --itemize-changes --exclude=.git --exclude=.DS_Store \
  "$SSH_ALIAS:$REMOTE_PATH/wp-content/themes/$THEME/" "./wp-content/themes/$THEME/" \
  > "$WORK/theme-diff.txt" || true
if [ -s "$WORK/theme-diff.txt" ]; then
  warn "Theme differs from live – see $WORK/theme-diff.txt (send it to Claude)."
else
  echo "    Theme matches live."
fi

# ------------------------------------------------------------ 6. tidy ---
say "6/6 Cleaning up…"
for p in $CACHE_PLUGINS; do
  wp plugin is-active "$p" >/dev/null 2>&1 && wp plugin deactivate "$p" --quiet && echo "    deactivated $p"
done
wp elementor flush-css >/dev/null 2>&1 || true
wp rewrite flush --quiet
wp cache flush --quiet || true

say "Done ✔"
echo "  • Log in at $LOCAL_URL/wp-admin with your LIVE username/password."
echo "  • ACF → Field Groups: click 'Sync available' if it appears (restores our theme's fields)."
echo "  • Theme report: $WORK/theme-diff.txt"
echo "  • Undo: wp db import $WORK/local-before-sync.sql"
