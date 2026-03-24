(function () {
  'use strict';

  var detail = document.getElementById('marcasDetail');
  if (!detail) return;

  var grid          = document.querySelector('.marcas-grid__container');
  var imageView     = document.getElementById('marcasDetailView');
  var image         = document.getElementById('marcasDetailImage');
  var title         = document.getElementById('marcasDetailTitle');
  var counter       = document.getElementById('marcasDetailCounter');
  var btnPrev       = document.getElementById('marcasDetailPrev');
  var btnNext       = document.getElementById('marcasDetailNext');
  var btnClose      = document.getElementById('marcasDetailClose');
  var btnDescToggle = document.getElementById('marcasDetailDescToggle');
  var descPanel     = document.getElementById('marcasDescPanel');
  var descTitle     = document.getElementById('marcasDescTitle');
  var descText      = document.getElementById('marcasDescText');

  var images = [];
  var currentIndex = 0;
  var currentSlug = '';

  // --- Hash helpers ---

  function updateHash() {
    history.replaceState(null, '', '#' + currentSlug + '/' + (currentIndex + 1));
  }

  function clearHash() {
    history.replaceState(null, '', window.location.pathname + window.location.search);
  }

  function parseHash() {
    var hash = window.location.hash.replace('#', '');
    if (!hash) return null;
    var parts = hash.split('/');
    return {
      slug: parts[0] || '',
      imageIndex: parseInt(parts[1], 10) || 1
    };
  }

  // --- Detail view ---

  function open(item, startIndex) {
    var marca = item.dataset.marcaTitle || '';
    var desc  = item.dataset.marcaDescription || '';
    currentSlug = item.dataset.marcaSlug || '';
    images = JSON.parse(item.dataset.marcaImages || '[]');

    title.textContent = marca;
    descTitle.textContent = marca;
    descText.innerHTML = desc;

    if (images.length > 0) {
      showImage(typeof startIndex === 'number' ? startIndex : 0);
    }

    // Hide grid, show detail (image view active).
    grid.setAttribute('aria-hidden', 'true');
    detail.setAttribute('aria-hidden', 'false');
    imageView.removeAttribute('aria-hidden');
    descPanel.setAttribute('aria-hidden', 'true');

    // Scroll to top of detail.
    detail.scrollIntoView({ behavior: 'smooth', block: 'start' });
  }

  function close() {
    detail.setAttribute('aria-hidden', 'true');
    grid.setAttribute('aria-hidden', 'false');
    image.src = '';
    clearHash();

    // Scroll back to grid.
    grid.scrollIntoView({ behavior: 'smooth', block: 'start' });
  }

  function showImage(index) {
    if (images.length === 0) return;
    currentIndex = (index + images.length) % images.length;
    image.src = images[currentIndex];
    counter.textContent = (currentIndex + 1) + '/' + images.length;
    updateHash();
  }

  function toggleDescription() {
    var descHidden = descPanel.getAttribute('aria-hidden') === 'true';
    if (descHidden) {
      // Show description, hide image view.
      imageView.setAttribute('aria-hidden', 'true');
      descPanel.removeAttribute('aria-hidden');
    } else {
      // Show image view, hide description.
      descPanel.setAttribute('aria-hidden', 'true');
      imageView.removeAttribute('aria-hidden');
    }
  }

  // --- Find item by slug ---

  function findItemBySlug(slug) {
    return document.querySelector('.marcas-grid__item[data-marca-slug="' + CSS.escape(slug) + '"]');
  }

  // --- Event listeners ---

  document.querySelectorAll('.marcas-grid__item').forEach(function (item) {
    item.addEventListener('click', function () {
      open(item);
    });
  });

  btnClose.addEventListener('click', close);
  btnPrev.addEventListener('click', function () { showImage(currentIndex - 1); });
  btnNext.addEventListener('click', function () { showImage(currentIndex + 1); });
  btnDescToggle.addEventListener('click', toggleDescription);

  document.addEventListener('keydown', function (e) {
    if (detail.getAttribute('aria-hidden') !== 'false') return;

    if (e.key === 'Escape') close();
    if (e.key === 'ArrowLeft') showImage(currentIndex - 1);
    if (e.key === 'ArrowRight') showImage(currentIndex + 1);
  });

  // Handle browser back/forward.
  window.addEventListener('hashchange', function () {
    var parsed = parseHash();
    if (!parsed || !parsed.slug) {
      if (detail.getAttribute('aria-hidden') === 'false') {
        detail.setAttribute('aria-hidden', 'true');
        grid.setAttribute('aria-hidden', 'false');
        image.src = '';
      }
      return;
    }
    var item = findItemBySlug(parsed.slug);
    if (item) {
      if (detail.getAttribute('aria-hidden') === 'true') {
        open(item, parsed.imageIndex - 1);
      } else if (parsed.slug === currentSlug) {
        currentIndex = ((parsed.imageIndex - 1) + images.length) % images.length;
        image.src = images[currentIndex];
        counter.textContent = (currentIndex + 1) + '/' + images.length;
      }
    }
  });

  // Open from hash on page load.
  var initial = parseHash();
  if (initial && initial.slug) {
    var item = findItemBySlug(initial.slug);
    if (item) {
      open(item, initial.imageIndex - 1);
    }
  }
})();
