/**
 * CF7 Radio Tabs — Click handler.
 * CF7 renders radios inside <span> (not <label>), so clicking
 * the visible pill text doesn't toggle the radio. This fixes that.
 */
(function () {
  'use strict';

  document.addEventListener('click', function (e) {
    var label = e.target.closest('.cf7-tabs .wpcf7-list-item-label');
    if (!label) return;

    var item = label.closest('.wpcf7-list-item');
    if (!item) return;

    var radio = item.querySelector('input[type="radio"]');
    if (radio && !radio.checked) {
      radio.checked = true;
      radio.dispatchEvent(new Event('change', { bubbles: true }));
    }
  });
})();
