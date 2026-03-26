(function () {
  'use strict';

  // --- Slider logic (reusable) ---

  function initSlider(slider) {
    var wrapper   = slider.querySelector('.beaf__slider-wrapper');
    var clip      = slider.querySelector('.beaf__clip');
    var beforeImg = slider.querySelector('.beaf__image--before');
    var divider   = slider.querySelector('.beaf__divider');
    var handle    = slider.querySelector('.beaf__handle');
    var dragging  = false;

    function syncBeforeWidth() {
      if (wrapper.offsetWidth > 0) {
        beforeImg.style.width = wrapper.offsetWidth + 'px';
      }
    }

    function setPosition(x) {
      var rect = wrapper.getBoundingClientRect();
      var pct  = ((x - rect.left) / rect.width) * 100;
      pct = Math.max(0, Math.min(100, pct));
      clip.style.width = pct + '%';
      divider.style.left = pct + '%';
    }

    function onStart(e) {
      e.preventDefault();
      dragging = true;
      wrapper.classList.add('beaf__slider-wrapper--active');
    }

    function onMove(e) {
      if (!dragging) return;
      var clientX = e.touches ? e.touches[0].clientX : e.clientX;
      setPosition(clientX);
    }

    function onEnd() {
      dragging = false;
      wrapper.classList.remove('beaf__slider-wrapper--active');
    }

    handle.addEventListener('mousedown', onStart);
    divider.addEventListener('mousedown', onStart);
    window.addEventListener('mousemove', onMove);
    window.addEventListener('mouseup', onEnd);

    handle.addEventListener('touchstart', onStart, { passive: false });
    divider.addEventListener('touchstart', onStart, { passive: false });
    window.addEventListener('touchmove', onMove, { passive: true });
    window.addEventListener('touchend', onEnd);

    wrapper.addEventListener('click', function (e) {
      if (!dragging) {
        setPosition(e.clientX);
      }
    });

    syncBeforeWidth();
    window.addEventListener('resize', syncBeforeWidth);

    clip.style.width = '50%';
    divider.style.left = '50%';
  }

  // --- Init grid sliders ---

  document.querySelectorAll('.beaf__container .beaf__slider').forEach(initSlider);

  // --- Detail view logic ---

  var grid        = document.getElementById('beafGrid');
  var detail      = document.getElementById('beafDetail');
  if (!grid || !detail) return;

  var detailTitle = document.getElementById('beafDetailTitle');
  var detailSliders = document.getElementById('beafDetailSliders');
  var detailDesc  = document.getElementById('beafDetailDescription');
  var btnBack     = document.getElementById('beafDetailBack');

  var sliderTemplate =
    '<div class="beaf__slider">' +
      '<div class="beaf__slider-wrapper">' +
        '<img class="beaf__image beaf__image--after" src="" alt="After" draggable="false">' +
        '<div class="beaf__clip">' +
          '<img class="beaf__image beaf__image--before" src="" alt="Before" draggable="false">' +
        '</div>' +
        '<div class="beaf__divider">' +
          '<div class="beaf__handle">' +
            '<svg width="9" height="17" viewBox="0 0 9 17" fill="none"><path d="M7 1L1 8.5L7 16" stroke="#000" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>' +
            '<svg width="9" height="17" viewBox="0 0 9 17" fill="none"><path d="M2 1L8 8.5L2 16" stroke="#000" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>' +
          '</div>' +
        '</div>' +
      '</div>' +
    '</div>';

  // --- Hash helpers ---

  function updateHash(slug) {
    history.replaceState(null, '', '#' + slug);
  }

  function clearHash() {
    history.replaceState(null, '', window.location.pathname + window.location.search);
  }

  function parseHash() {
    var hash = window.location.hash.replace('#', '');
    return hash || null;
  }

  // --- Open detail ---

  function openDetail(item) {
    var title   = item.dataset.beafTitle || '';
    var slug    = item.dataset.beafSlug || '';
    var descEl  = item.querySelector('.beaf__description');
    var pairs   = JSON.parse(item.dataset.beafPairs || '[]');

    detailTitle.textContent = title;

    // Copy description HTML into detail view.
    if (descEl) {
      detailDesc.innerHTML = descEl.innerHTML;
      detailDesc.style.display = '';
    } else {
      detailDesc.innerHTML = '';
      detailDesc.style.display = 'none';
    }

    // Build sliders for all pairs.
    detailSliders.innerHTML = '';
    pairs.forEach(function (pair) {
      var tmp = document.createElement('div');
      tmp.innerHTML = sliderTemplate;
      var sl = tmp.firstChild;
      sl.querySelector('.beaf__image--after').src = pair.after;
      sl.querySelector('.beaf__image--before').src = pair.before;
      detailSliders.appendChild(sl);
    });

    // Hide grid, show detail.
    grid.setAttribute('aria-hidden', 'true');
    detail.setAttribute('aria-hidden', 'false');
    updateHash(slug);

    // Init sliders after they're in DOM.
    detail.querySelectorAll('.beaf__slider').forEach(initSlider);

    detail.scrollIntoView({ behavior: 'smooth', block: 'start' });
  }

  // --- Close detail ---

  function closeDetail() {
    detail.setAttribute('aria-hidden', 'true');
    grid.setAttribute('aria-hidden', 'false');
    detailSliders.innerHTML = '';
    clearHash();
    grid.scrollIntoView({ behavior: 'smooth', block: 'start' });
  }

  // --- Event listeners ---

  // Click grid items to open detail (but not when dragging slider).
  document.querySelectorAll('.beaf__item').forEach(function (item) {
    item.querySelector('.beaf__info').addEventListener('click', function () {
      openDetail(item);
    });
    item.querySelector('.beaf__info').style.cursor = 'pointer';
  });

  btnBack.addEventListener('click', closeDetail);

  document.addEventListener('keydown', function (e) {
    if (detail.getAttribute('aria-hidden') !== 'false') return;
    if (e.key === 'Escape') closeDetail();
  });

  // --- Hash navigation ---

  function findItemBySlug(slug) {
    return document.querySelector('.beaf__item[data-beaf-slug="' + CSS.escape(slug) + '"]');
  }

  window.addEventListener('hashchange', function () {
    var slug = parseHash();
    if (!slug) {
      if (detail.getAttribute('aria-hidden') === 'false') {
        closeDetail();
      }
      return;
    }
    var item = findItemBySlug(slug);
    if (item && detail.getAttribute('aria-hidden') === 'true') {
      openDetail(item);
    }
  });

  // Open from hash on page load.
  var initialSlug = parseHash();
  if (initialSlug) {
    var item = findItemBySlug(initialSlug);
    if (item) {
      openDetail(item);
    }
  }
})();
