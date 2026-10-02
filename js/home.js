/**
 * Windset Farms – homepage video lightbox
 * Click a .ws-video-trigger[data-video-id] to open #ws-video-lightbox with a
 * 16:9 YouTube embed. Close via the X, the backdrop or Esc; the iframe is
 * removed on close so playback always stops.
 */
(function () {
  'use strict';

  var lightbox = document.getElementById('ws-video-lightbox');
  if (!lightbox) { return; }

  var frame = lightbox.querySelector('.ws-lightbox__frame');
  var closeBtn = lightbox.querySelector('.ws-lightbox__close');
  var lastTrigger = null;

  function open(videoId, trigger) {
    lastTrigger = trigger || null;

    var iframe = document.createElement('iframe');
    iframe.src = 'https://www.youtube.com/embed/' + encodeURIComponent(videoId) +
      '?autoplay=1&rel=0&modestbranding=1&playsinline=1';
    iframe.title = 'Windset Farms video';
    iframe.allow = 'accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture';
    iframe.setAttribute('allowfullscreen', '');
    iframe.setAttribute('frameborder', '0');

    frame.innerHTML = '';
    frame.appendChild(iframe);

    lightbox.hidden = false;
    void lightbox.offsetWidth; // force a reflow so the fade-in transition runs
    lightbox.classList.add('is-open');
    document.documentElement.classList.add('ws-lightbox-open');
    closeBtn.focus();
  }

  function close() {
    if (lightbox.hidden) { return; }
    lightbox.classList.remove('is-open');
    document.documentElement.classList.remove('ws-lightbox-open');
    frame.innerHTML = ''; // stops the video
    window.setTimeout(function () { lightbox.hidden = true; }, 200);
    if (lastTrigger) { lastTrigger.focus(); }
  }

  document.addEventListener('click', function (e) {
    var trigger = e.target.closest('.ws-video-trigger');
    if (trigger && trigger.getAttribute('data-video-id')) {
      e.preventDefault();
      open(trigger.getAttribute('data-video-id'), trigger);
      return;
    }
    if (e.target.closest('[data-ws-close]') && lightbox.contains(e.target)) {
      e.preventDefault();
      close();
    }
  });

  document.addEventListener('keydown', function (e) {
    if (e.key === 'Escape' || e.key === 'Esc') { close(); }
    // keep focus inside the dialog while open
    if (e.key === 'Tab' && !lightbox.hidden) {
      e.preventDefault();
      closeBtn.focus();
    }
  });
})();

/**
 * Homepage slider – Slick (loaded by the theme). Swipe/drag on touch,
 * autoplay that pauses on hover/focus, arrows on desktop, dots everywhere.
 */
(function ($) {
  'use strict';
  if (!$ || !$.fn || !$.fn.slick) { return; }

  $(function () {
    $('.js-ws-slider').slick({
      dots: true,
      arrows: true,
      infinite: true,
      speed: 600,
      autoplay: true,
      autoplaySpeed: 6000,
      pauseOnHover: true,
      pauseOnFocus: true,
      swipeToSlide: true,
      adaptiveHeight: false,
      lazyLoad: 'ondemand',
      prevArrow: '<button type="button" class="slick-prev slick-arrow" aria-label="Previous slide"><i class="fa fa-chevron-left" aria-hidden="true"></i></button>',
      nextArrow: '<button type="button" class="slick-next slick-arrow" aria-label="Next slide"><i class="fa fa-chevron-right" aria-hidden="true"></i></button>',
      responsive: [
        { breakpoint: 601, settings: { arrows: false } }
      ]
    });
  });
})(window.jQuery);
