<?php
/**
 * Marcas Lightbox — fullscreen image viewer.
 */
?>
<div class="marcas-lightbox" id="marcasLightbox" aria-hidden="true">
    <div class="marcas-lightbox__overlay"></div>

    <div class="marcas-lightbox__bg-grid" id="marcasLightboxBgGrid"></div>

    <div class="marcas-lightbox__main">
        <img class="marcas-lightbox__image" id="marcasLightboxImage" src="" alt="">
        <button class="marcas-lightbox__arrow marcas-lightbox__arrow--prev" id="marcasLightboxPrev" aria-label="Anterior">&#8592;</button>
        <button class="marcas-lightbox__arrow marcas-lightbox__arrow--next" id="marcasLightboxNext" aria-label="Siguiente">&#8594;</button>
        <p class="marcas-lightbox__title" id="marcasLightboxTitle"></p>
    </div>

    <div class="marcas-lightbox__description-panel" id="marcasDescriptionPanel" aria-hidden="true">
        <h2 class="marcas-lightbox__desc-title" id="marcasDescTitle"></h2>
        <div class="marcas-lightbox__desc-text" id="marcasDescText"></div>
    </div>

    <div class="marcas-lightbox__bar">
        <button class="marcas-lightbox__bar-btn" id="marcasLightboxClose">&#8592; Inicio</button>
        <span class="marcas-lightbox__bar-counter" id="marcasLightboxCounter">1/1</span>
        <button class="marcas-lightbox__bar-btn" id="marcasLightboxDescToggle">Descripción</button>
    </div>
</div>
