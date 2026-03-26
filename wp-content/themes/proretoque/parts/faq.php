<?php
/**
 * FAQ — Preguntas Frecuentes section.
 * Accordion with numbered items + segmented tab buttons.
 * Reads from the "faq" Custom Post Type.
 */

$faqs = new WP_Query( [
    'post_type'      => 'faq',
    'posts_per_page' => -1,
    'orderby'        => 'menu_order',
    'order'          => 'ASC',
] );

if ( ! $faqs->have_posts() ) {
    return;
}
?>

<section class="faq">
    <div class="faq__inner">
        <!-- Left column: title + tabs -->
        <div class="faq__text">
            <div class="faq__heading">
                <h1 class="faq__title">Preguntas Frecuentes</h1>
                <p class="faq__subtitle">Contáctanos si aún tienes alguna pregunta para que tu experiencia sea más fluida.</p>
            </div>

            <div class="faq__tabs" role="tablist">
                <button class="faq__tab is-active" role="tab" aria-selected="true" data-target="servicio">Nuestro Servicio</button>
                <button class="faq__tab" role="tab" aria-selected="false" data-target="retoque">Retoque Profesional</button>
            </div>
        </div>

        <!-- Right column: accordion -->
        <div class="faq__accordion" role="tabpanel" data-panel="servicio">
            <?php $index = 0; ?>
            <?php while ( $faqs->have_posts() ) : $faqs->the_post();
                $index++;
                $number    = str_pad( $index, 2, '0', STR_PAD_LEFT );
                $title     = get_the_title();
                $content   = get_the_content();
                $is_first  = ( $index === 1 );
            ?>
            <div class="faq__item<?php echo $is_first ? ' is-open' : ''; ?>" data-faq-item>
                <div class="faq__item-line"></div>
                <div class="faq__item-header" role="button" aria-expanded="<?php echo $is_first ? 'true' : 'false'; ?>" tabindex="0">
                    <span class="faq__item-number"><?php echo esc_html( $number ); ?></span>
                    <span class="faq__item-title"><?php echo esc_html( strtoupper( $title ) ); ?></span>
                    <span class="faq__item-icon" aria-hidden="true">
                        <svg width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <circle cx="16" cy="16" r="12" stroke="currentColor" stroke-width="1.5"/>
                            <line x1="10" y1="16" x2="22" y2="16" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                            <line x1="16" y1="10" x2="16" y2="22" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" class="faq__icon-plus"/>
                        </svg>
                    </span>
                </div>
                <div class="faq__item-body" aria-hidden="<?php echo $is_first ? 'false' : 'true'; ?>">
                    <?php echo wp_kses_post( $content ); ?>
                </div>
            </div>
            <?php endwhile; wp_reset_postdata(); ?>
        </div>
    </div>
</section>
