/**
 * Sobre Nosotros — dual tabs (Proretoque/Clientes), multi-open accordion, logo carousel.
 */
(function () {
  document.addEventListener('DOMContentLoaded', function () {
    initDualTabs();
    initAccordion();
    initCarousel();
  });

  function initDualTabs() {
    var root = document.querySelector('[data-sn-dual]');
    if (!root) return;

    var tabs = root.querySelectorAll('[data-sn-tab]');
    tabs.forEach(function (tab) {
      tab.addEventListener('click', function () {
        var key = tab.getAttribute('data-sn-tab');
        tabs.forEach(function (t) {
          var active = t === tab;
          t.classList.toggle('is-active', active);
          t.setAttribute('aria-selected', active ? 'true' : 'false');
        });
        swap('[data-sn-visual]', 'data-sn-visual', key);
        swap('[data-sn-panel]',  'data-sn-panel',  key);
        swap('[data-sn-below]',  'data-sn-below',  key);
      });
    });

    function swap(selector, attr, key) {
      root.querySelectorAll(selector).forEach(function (el) {
        var match = el.getAttribute(attr) === key;
        el.classList.toggle('is-active', match);
        if (match) {
          el.removeAttribute('hidden');
        } else {
          el.setAttribute('hidden', '');
        }
      });
    }
  }

  function initAccordion() {
    var items = document.querySelectorAll('[data-sn-acc]');
    items.forEach(function (item) {
      var header = item.querySelector('.sobre-nosotros__acc-header');
      if (!header) return;

      header.addEventListener('click', function () { toggle(item); });
      header.addEventListener('keydown', function (e) {
        if (e.key === 'Enter' || e.key === ' ') {
          e.preventDefault();
          toggle(item);
        }
      });
    });

    function toggle(item) {
      var open = item.classList.toggle('is-open');
      var header = item.querySelector('.sobre-nosotros__acc-header');
      var body   = item.querySelector('.sobre-nosotros__acc-body');
      if (header) header.setAttribute('aria-expanded', open ? 'true' : 'false');
      if (body)   body.setAttribute('aria-hidden',      open ? 'false' : 'true');
    }
  }

  function initCarousel() {
    var car = document.querySelector('[data-sn-carousel]');
    if (!car) return;

    var track = car.querySelector('[data-sn-track]');
    var prev  = car.querySelector('[data-sn-prev]');
    var next  = car.querySelector('[data-sn-next]');
    if (!track) return;

    function step(dir) {
      var item = track.querySelector('.sobre-nosotros__carousel-item');
      if (!item) return;
      var style = window.getComputedStyle(track);
      var gap   = parseFloat(style.columnGap || style.gap || 0) || 0;
      var slide = (item.getBoundingClientRect().width + gap) * 4 * dir;
      track.scrollBy({ left: slide, behavior: 'smooth' });
    }

    if (prev) prev.addEventListener('click', function () { step(-1); });
    if (next) next.addEventListener('click', function () { step( 1); });
  }
})();
