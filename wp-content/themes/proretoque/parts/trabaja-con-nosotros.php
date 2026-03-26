<?php
/**
 * Trabaja con Nosotros — Page template.
 * Displays job info + CF7 form side by side over a background image.
 * Includes a "Soy Retocador / No soy Retocador" toggle that switches between two CF7 forms.
 */
?>

<section class="trabaja">
    <div class="trabaja__inner">
        <!-- Heading -->
        <div class="trabaja__heading">
            <h1 class="trabaja__title">Trabaja con Nosotros</h1>
            <p class="trabaja__subtitle">Nos mueve el detalle, el criterio y la responsabilidad sobre cada imagen dentro del retoque fotográfico profesional. Si tú también trabajas así, queremos conocerte.</p>
            <hr class="trabaja__divider">
        </div>

        <!-- Form area with background image -->
        <div class="trabaja__area">
            <!-- Background image + white overlay -->
            <div class="trabaja__area-bg" aria-hidden="true">
                <div class="trabaja__area-overlay"></div>
            </div>

            <!-- Left: info -->
            <div class="trabaja__info">
                <!-- Toggle tabs -->
                <div class="trabaja__toggle" role="tablist">
                    <button class="trabaja__toggle-btn is-active" role="tab" aria-selected="true" data-target="retocador">Soy Retocador</button>
                    <button class="trabaja__toggle-btn" role="tab" aria-selected="false" data-target="no-retocador">No soy Retocador</button>
                </div>

                <div class="trabaja__info-text">
                    <p>Rellena el formulario y adjunta la información relevante sobre tu perfil. Evaluaremos tu candidatura lo antes posible.</p>
                    <p>Gracias por tu interés en formar parte de ProRetoque.</p>
                </div>

                <!-- Contact links -->
                <div class="trabaja__links">
                    <a href="mailto:candidatos@proretoque.photo" class="trabaja__link">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none"><circle cx="12" cy="12" r="9" stroke="currentColor" stroke-width="1.5"/><line x1="8" y1="12" x2="16" y2="12" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/></svg>
                        candidatos@proretoque.photo
                    </a>
                    <a href="tel:+34911966268" class="trabaja__link">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none"><circle cx="12" cy="12" r="9" stroke="currentColor" stroke-width="1.5"/><line x1="8" y1="12" x2="16" y2="12" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/></svg>
                        +34 911 966 268
                    </a>
                    <a href="tel:+34614174214" class="trabaja__link">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none"><circle cx="12" cy="12" r="9" stroke="currentColor" stroke-width="1.5"/><line x1="8" y1="12" x2="16" y2="12" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/></svg>
                        +34 614 174 214
                    </a>
                </div>
            </div>

            <!-- Right: CF7 forms (toggled) -->
            <div class="trabaja__form-wrap">
                <!-- Soy Retocador form -->
                <div class="trabaja__form-panel is-active" data-panel="retocador">
                    <div class="trabaja__form-header">
                        <h3 class="trabaja__form-title">Mi área de especialidad es el retoque</h3>
                        <p class="trabaja__form-subtitle">Queremos saber más sobre tí:</p>
                    </div>
                    <?php echo do_shortcode( '[contact-form-7 id="99" title="Trabaja - Soy Retocador"]' ); ?>
                </div>

                <!-- No soy Retocador form -->
                <div class="trabaja__form-panel" data-panel="no-retocador">
                    <div class="trabaja__form-header">
                        <h3 class="trabaja__form-title">Quiero unirme al equipo</h3>
                        <p class="trabaja__form-subtitle">Queremos saber más sobre tí:</p>
                    </div>
                    <?php echo do_shortcode( '[contact-form-7 id="100" title="Trabaja - No soy Retocador"]' ); ?>
                </div>
            </div>
        </div>
    </div>
</section>
