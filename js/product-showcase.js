/**
 * Product showcase – simple image lightbox for "Available Sizes"
 * (replaces Elementor's lightbox). Click to open, click / X / Esc to close.
 */
(function () {
  'use strict';

  var links = document.querySelectorAll('.js-ws-image-lightbox');
  if (!links.length) { return; }

  var box = document.createElement('div');
  box.className = 'ws-img-lightbox';
  box.hidden = true;
  box.setAttribute('role', 'dialog');
  box.setAttribute('aria-modal', 'true');
  box.setAttribute('aria-label', 'Product image');
  box.innerHTML = '<button type="button" class="ws-img-lightbox__close" aria-label="Close">&times;</button><img alt="">';
  document.body.appendChild(box);

  var img = box.querySelector('img');
  var closeBtn = box.querySelector('button');
  var last = null;

  function open(link) {
    last = link;
    img.src = link.getAttribute('href');
    var inner = link.querySelector('img');
    img.alt = inner ? inner.alt : '';
    box.hidden = false;
    document.documentElement.style.overflow = 'hidden';
    closeBtn.focus();
  }

  function close() {
    if (box.hidden) { return; }
    box.hidden = true;
    img.removeAttribute('src');
    document.documentElement.style.overflow = '';
    if (last) { last.focus(); }
  }

  for (var i = 0; i < links.length; i++) {
    links[i].addEventListener('click', function (e) {
      e.preventDefault();
      open(this);
    });
  }

  box.addEventListener('click', close);
  document.addEventListener('keydown', function (e) {
    if (e.key === 'Escape' || e.key === 'Esc') { close(); }
  });
})();
