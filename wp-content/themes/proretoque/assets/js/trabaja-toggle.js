/**
 * Trabaja con Nosotros — Toggle between "Soy Retocador" and "No soy Retocador" forms.
 */
(function () {
  'use strict';

  function init() {
    var buttons = document.querySelectorAll('.trabaja__toggle-btn');
    if (!buttons.length) return;

    buttons.forEach(function (btn) {
      btn.addEventListener('click', function () {
        var target = btn.getAttribute('data-target');

        // Update toggle buttons
        buttons.forEach(function (b) {
          b.classList.remove('is-active');
          b.setAttribute('aria-selected', 'false');
        });
        btn.classList.add('is-active');
        btn.setAttribute('aria-selected', 'true');

        // Switch panels
        var panels = document.querySelectorAll('.trabaja__form-panel');
        panels.forEach(function (panel) {
          if (panel.getAttribute('data-panel') === target) {
            panel.classList.add('is-active');
          } else {
            panel.classList.remove('is-active');
          }
        });
      });
    });
  }

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', init);
  } else {
    init();
  }
})();
