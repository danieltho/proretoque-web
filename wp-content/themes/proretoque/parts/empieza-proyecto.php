<?php
/**
 * Empieza tu proyecto — Page template.
 * Displays project info + CF7 form side by side over a background image.
 */
?>

<section class="proyecto">
    <div class="proyecto__inner">
        <!-- Heading -->
        <div class="proyecto__heading">
            <h1 class="proyecto__title">Empieza tu proyecto</h1>
            <div class="proyecto__subtitle">
                <p>Cuéntanos de qué se trata tu proyecto y qué necesitamos trabajar.</p>
                <p>Estamos listos para ponernos en marcha y potenciar tus imágenes desde el primer momento.</p>
            </div>
            <hr class="proyecto__divider">
        </div>

        <!-- Form area with background image -->
        <div class="proyecto__area">
            <!-- Left: project info -->
            <div class="proyecto__info">
                <!-- Background image + white overlay -->
                <div class="proyecto__info-bg" aria-hidden="true">
                    <div class="proyecto__info-overlay"></div>
                </div>

                <div class="proyecto__block">
                    <h3 class="proyecto__block-title">Si necesitas asesoramiento</h3>
                    <p class="proyecto__block-text">Te ayudamos a definir el acabado, el nivel de retoque y el enfoque visual que mejor encaja con tu marca y tu tipo de producto.</p>
                </div>

                <div class="proyecto__block">
                    <h3 class="proyecto__block-title">Si ya lo tienes claro</h3>
                    <p class="proyecto__block-text">Seguimos tus indicaciones al detalle y respetamos tu protocolo para que el resultado sea exactamente como lo tienes en mente.</p>
                </div>

                <div class="proyecto__block">
                    <h3 class="proyecto__block-title">Horario</h3>
                    <div class="proyecto__horario">
                        <div class="proyecto__horario-col">
                            <span class="proyecto__horario-day">Lunes - Jueves</span>
                            <span class="proyecto__horario-time">09:00 - 18:00</span>
                        </div>
                        <div class="proyecto__horario-col">
                            <span class="proyecto__horario-day">Viernes</span>
                            <span class="proyecto__horario-time">09:00 - 17:00</span>
                        </div>
                    </div>
                </div>

                <!-- Teléfono callback -->
                <div class="proyecto__block">
                    <p class="proyecto__phone-label">¿Prefieres consultarlo por teléfono?</p>
                    <div class="proyecto__callback">
                        <input type="tel" class="proyecto__callback-input" placeholder="Introducir tu teléfono">
                        <button class="proyecto__callback-btn" type="button">Te llamamos</button>
                    </div>
                </div>

                <!-- Contact links -->
                <div class="proyecto__links">
                    <a href="mailto:candidatos@proretoque.photo" class="proyecto__link">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none"><circle cx="12" cy="12" r="9" stroke="currentColor" stroke-width="1.5"/><line x1="8" y1="12" x2="16" y2="12" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/></svg>
                        candidatos@proretoque.photo
                    </a>
                    <a href="tel:+34911966268" class="proyecto__link">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none"><circle cx="12" cy="12" r="9" stroke="currentColor" stroke-width="1.5"/><line x1="8" y1="12" x2="16" y2="12" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/></svg>
                        +34 911 966 268
                    </a>
                    <a href="tel:+34614174214" class="proyecto__link">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none"><circle cx="12" cy="12" r="9" stroke="currentColor" stroke-width="1.5"/><line x1="8" y1="12" x2="16" y2="12" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/></svg>
                        +34 614 174 214
                    </a>
                </div>
            </div>

            <!-- Right: CF7 form -->
            <div class="proyecto__form-wrap">
                <div class="proyecto__form-header">
                    <p class="proyecto__form-title">¿Tienes un proyecto en mente?</p>
                    <p class="proyecto__form-subtitle">Estamos aquí para ayudarte a simplificar el desarrollo de tu idea.</p>
                </div>
                <?php echo do_shortcode( '[contact-form-7 id="96" title="Empieza tu Proyecto"]' ); ?>
            </div>
        </div>
    </div>
</section>
