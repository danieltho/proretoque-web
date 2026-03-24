<?php
/**
 * Marcas Detail — inline detail view (replaces the grid when active).
 */
?>
<div class="marcas-detail" id="marcasDetail" aria-hidden="true">
    <div class="marcas-detail__content">
        <div class="marcas-detail__view" id="marcasDetailView">
            <div class="marcas-detail__carousel">
                <button class="marcas-detail__arrow marcas-detail__arrow--prev" id="marcasDetailPrev" aria-label="Anterior">
                    <svg width="48" height="48" viewBox="0 0 48 48" fill="none"><path d="M30 12L18 24L30 36" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                </button>
                <div class="marcas-detail__image-wrapper">
                    <img class="marcas-detail__image" id="marcasDetailImage" src="" alt="">
                </div>
                <button class="marcas-detail__arrow marcas-detail__arrow--next" id="marcasDetailNext" aria-label="Siguiente">
                    <svg width="48" height="48" viewBox="0 0 48 48" fill="none"><path d="M18 12L30 24L18 36" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                </button>
            </div>
            <span class="marcas-detail__counter" id="marcasDetailCounter">1/3</span>
            <h2 class="marcas-detail__title" id="marcasDetailTitle"></h2>
        </div>

        <div class="marcas-detail__desc-view" id="marcasDescPanel" aria-hidden="true">
            <h2 class="marcas-detail__title" id="marcasDescTitle"></h2>
            <p class="marcas-detail__desc-text" id="marcasDescText"></p>
        </div>

        <div class="marcas-detail__bar">
            <button class="marcas-detail__bar-btn" id="marcasDetailClose">
                <svg width="16" height="16" viewBox="0 0 48 48" fill="none"><path d="M30 12L18 24L30 36" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/></svg>
                Inicio
            </button>
            <button class="marcas-detail__bar-btn" id="marcasDetailDescToggle">Descripción</button>
        </div>
    </div>
</div>
