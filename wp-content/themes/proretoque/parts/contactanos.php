<?php
/**
 * Contáctanos — Page template.
 * Displays contact info + CF7 form side by side over a background image.
 */
?>

<section class="contactanos">
    <div class="contactanos__inner">
        <!-- Heading -->
        <div class="contactanos__heading">
            <h1 class="contactanos__title">Contáctanos</h1>
            <p class="contactanos__subtitle">Respondemos rápido para ayudarte con cualquier duda sobre precios, entregas, pedidos o sobre cómo podemos trabajar juntos.</p>
            <hr class="contactanos__divider">
        </div>

        <!-- Form area with background image -->
        <div class="contactanos__area">
            <!-- Background image + white overlay -->
            <div class="contactanos__area-bg" aria-hidden="true">
                <div class="contactanos__area-overlay"></div>
            </div>

            <!-- Left: contact info -->
            <div class="contactanos__info">
                <!-- Horario -->
                <div class="contactanos__block">
                    <h3 class="contactanos__block-title">Horario</h3>
                    <div class="contactanos__horario">
                        <div class="contactanos__horario-col">
                            <span class="contactanos__horario-day">Lunes - Jueves</span>
                            <span class="contactanos__horario-time">09:00 - 18:00</span>
                        </div>
                        <div class="contactanos__horario-col">
                            <span class="contactanos__horario-day">Viernes</span>
                            <span class="contactanos__horario-time">09:00 - 17:00</span>
                        </div>
                    </div>
                </div>

                <!-- Teléfono callback -->
                <div class="contactanos__block">
                    <p class="contactanos__phone-label">¿Prefieres consultarlo por teléfono?</p>
                    <div class="contactanos__callback">
                        <input type="tel" class="contactanos__callback-input" placeholder="Introducir tu teléfono">
                        <button class="contactanos__callback-btn" type="button">Te llamamos</button>
                    </div>
                </div>

                <!-- Contact links -->
                <div class="contactanos__links">
                    <a href="mailto:hola@proretoque.photo" class="contactanos__link">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none"><circle cx="12" cy="12" r="9" stroke="currentColor" stroke-width="1.5"/><line x1="8" y1="12" x2="16" y2="12" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/></svg>
                        hola@proretoque.photo
                    </a>
                    <a href="mailto:candidatos@proretoque.photo" class="contactanos__link">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none"><circle cx="12" cy="12" r="9" stroke="currentColor" stroke-width="1.5"/><line x1="8" y1="12" x2="16" y2="12" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/></svg>
                        candidatos@proretoque.photo
                    </a>
                    <a href="tel:+34911966268" class="contactanos__link">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none"><circle cx="12" cy="12" r="9" stroke="currentColor" stroke-width="1.5"/><line x1="8" y1="12" x2="16" y2="12" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/></svg>
                        +34 911 966 268
                    </a>
                    <a href="tel:+34614174214" class="contactanos__link">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none"><circle cx="12" cy="12" r="9" stroke="currentColor" stroke-width="1.5"/><line x1="8" y1="12" x2="16" y2="12" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/></svg>
                        +34 614 174 214
                    </a>
                </div>
            </div>

            <!-- Right: CF7 form -->
            <div class="contactanos__form-wrap">
                <div class="contactanos__form-header">
                    <p class="contactanos__form-title">Dinos qué necesitas</p>
                    <p class="contactanos__form-subtitle">Estamos listos para ayudarte con cada detalle.</p>
                </div>
                <?php echo do_shortcode( '[contact-form-7 id="89" title="Formulario de Contacto"]' ); ?>
            </div>
        </div>
    </div>
</section>
