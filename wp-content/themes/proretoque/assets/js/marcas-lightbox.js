(function () {
  'use strict';

  const lightbox       = document.getElementById('marcasLightbox');
  if (!lightbox) return;

  const image          = document.getElementById('marcasLightboxImage');
  const title          = document.getElementById('marcasLightboxTitle');
  const counter        = document.getElementById('marcasLightboxCounter');
  const btnPrev        = document.getElementById('marcasLightboxPrev');
  const btnNext        = document.getElementById('marcasLightboxNext');
  const btnClose       = document.getElementById('marcasLightboxClose');
  const btnDescToggle  = document.getElementById('marcasLightboxDescToggle');
  const descPanel      = document.getElementById('marcasDescriptionPanel');
  const descTitle      = document.getElementById('marcasDescTitle');
  const descText       = document.getElementById('marcasDescText');
  const bgGrid         = document.getElementById('marcasLightboxBgGrid');

  let images = [];
  let currentIndex = 0;

  function open(item) {
    const marca = item.dataset.marcaTitle || '';
    const desc  = item.dataset.marcaDescription || '';
    images      = JSON.parse(item.dataset.marcaImages || '[]');
    currentIndex = 0;

    title.textContent = marca;
    descTitle.textContent = marca;
    descText.innerHTML = desc;

    // Build background grid.
    bgGrid.innerHTML = '';
    images.forEach(function (src) {
      var img = document.createElement('img');
      img.src = src;
      img.alt = '';
      bgGrid.appendChild(img);
    });

    if (images.length > 0) {
      showImage(0);
    }

    lightbox.setAttribute('aria-hidden', 'false');
    document.body.style.overflow = 'hidden';
    descPanel.setAttribute('aria-hidden', 'true');
  }

  function close() {
    lightbox.setAttribute('aria-hidden', 'true');
    document.body.style.overflow = '';
    image.src = '';
  }

  function showImage(index) {
    if (images.length === 0) return;
    currentIndex = (index + images.length) % images.length;
    image.src = images[currentIndex];
    counter.textContent = (currentIndex + 1) + '/' + images.length;
  }

  function toggleDescription() {
    var hidden = descPanel.getAttribute('aria-hidden') === 'true';
    descPanel.setAttribute('aria-hidden', hidden ? 'false' : 'true');
  }

  // Event listeners.
  document.querySelectorAll('.marcas-grid__item').forEach(function (item) {
    item.addEventListener('click', function () {
      open(item);
    });
  });

  btnClose.addEventListener('click', close);
  btnPrev.addEventListener('click', function () { showImage(currentIndex - 1); });
  btnNext.addEventListener('click', function () { showImage(currentIndex + 1); });
  btnDescToggle.addEventListener('click', toggleDescription);

  lightbox.querySelector('.marcas-lightbox__overlay').addEventListener('click', close);

  document.addEventListener('keydown', function (e) {
    if (lightbox.getAttribute('aria-hidden') !== 'false') return;

    if (e.key === 'Escape') close();
    if (e.key === 'ArrowLeft') showImage(currentIndex - 1);
    if (e.key === 'ArrowRight') showImage(currentIndex + 1);
  });
})();
