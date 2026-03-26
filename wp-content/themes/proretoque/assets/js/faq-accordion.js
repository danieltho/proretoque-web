/**
 * FAQ Accordion — toggle items open/closed.
 */
(function () {
  document.addEventListener('DOMContentLoaded', function () {
    var items = document.querySelectorAll('[data-faq-item]');

    items.forEach(function (item) {
      var header = item.querySelector('.faq__item-header');
      if (!header) return;

      header.addEventListener('click', function () {
        toggleItem(item);
      });

      header.addEventListener('keydown', function (e) {
        if (e.key === 'Enter' || e.key === ' ') {
          e.preventDefault();
          toggleItem(item);
        }
      });
    });

    function toggleItem(item) {
      var isOpen = item.classList.contains('is-open');
      var header = item.querySelector('.faq__item-header');
      var body = item.querySelector('.faq__item-body');

      // Close all items first.
      items.forEach(function (other) {
        other.classList.remove('is-open');
        var otherHeader = other.querySelector('.faq__item-header');
        var otherBody = other.querySelector('.faq__item-body');
        if (otherHeader) otherHeader.setAttribute('aria-expanded', 'false');
        if (otherBody) otherBody.setAttribute('aria-hidden', 'true');
      });

      // Open the clicked item (unless it was already open).
      if (!isOpen) {
        item.classList.add('is-open');
        if (header) header.setAttribute('aria-expanded', 'true');
        if (body) body.setAttribute('aria-hidden', 'false');
      }
    }

    // Tab switching.
    var tabs = document.querySelectorAll('.faq__tab');
    tabs.forEach(function (tab) {
      tab.addEventListener('click', function () {
        tabs.forEach(function (t) {
          t.classList.remove('is-active');
          t.setAttribute('aria-selected', 'false');
        });
        tab.classList.add('is-active');
        tab.setAttribute('aria-selected', 'true');
      });
    });
  });
})();
