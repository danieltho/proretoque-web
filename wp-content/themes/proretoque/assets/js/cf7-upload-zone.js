/**
 * CF7 Upload Zone — Visual drag-and-drop wrapper for CF7 file inputs.
 * Wraps each file input inside .cf7-upload-col with a styled drop zone
 * matching the Figma design (dashed border, plus icon, label text).
 */
(function () {
  'use strict';

  var PLUS_SVG =
    '<svg viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">' +
    '<circle cx="16" cy="16" r="12" stroke="currentColor" stroke-width="1.5"/>' +
    '<line x1="16" y1="10" x2="16" y2="22" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>' +
    '<line x1="10" y1="16" x2="22" y2="16" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>' +
    '</svg>';

  function init() {
    var cols = document.querySelectorAll('.cf7-upload-col .wpcf7-form-control-wrap');
    if (!cols.length) return;

    cols.forEach(function (wrap) {
      var input = wrap.querySelector('input[type="file"]');
      if (!input || wrap.querySelector('.cf7-upload-zone')) return;

      // Create the visual zone
      var zone = document.createElement('div');
      zone.className = 'cf7-upload-zone';
      zone.innerHTML =
        PLUS_SVG +
        '<span class="cf7-upload-text">Arrastra o Selecciona tus archivos</span>';

      // Insert zone before the input
      wrap.insertBefore(zone, input);

      // Drag states
      zone.addEventListener('dragenter', function () {
        zone.classList.add('is-dragover');
      });
      zone.addEventListener('dragleave', function () {
        zone.classList.remove('is-dragover');
      });
      zone.addEventListener('drop', function () {
        zone.classList.remove('is-dragover');
      });

      // Show file name on change
      input.addEventListener('change', function () {
        var textEl = zone.querySelector('.cf7-upload-text');
        if (input.files && input.files.length > 0) {
          textEl.textContent = input.files[0].name;
          zone.classList.add('has-file');
        } else {
          textEl.textContent = 'Arrastra o Selecciona tus archivos';
          zone.classList.remove('has-file');
        }
      });
    });
  }

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', init);
  } else {
    init();
  }
})();
