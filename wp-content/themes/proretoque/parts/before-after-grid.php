<?php
/**
 * Before & After Grid — renders the vertical list of comparison sliders.
 * Included via [proretoque_before_after] shortcode.
 *
 * Each before_after post = one category (e.g. "Retoques de Moda").
 * Gallery images in post content are ordered as: before1, after1, before2, after2, …
 */

$items = new WP_Query( [
    'post_type'      => 'before_after',
    'posts_per_page' => -1,
    'orderby'        => 'menu_order',
    'order'          => 'ASC',
] );

if ( ! $items->have_posts() ) {
    return;
}
?>
<div class="beaf__container" id="beafGrid">
    <h1 class="beaf__title">Before &amp; After</h1>

    <?php while ( $items->have_posts() ) : $items->the_post();
        $title = get_the_title();
        $slug  = sanitize_title( $title );
        $desc  = get_the_excerpt();

        // Collect gallery image URLs (before/after pairs).
        $gallery_images = [];

        // From attached images.
        $attachments = get_posts( [
            'post_parent'    => get_the_ID(),
            'post_type'      => 'attachment',
            'post_mime_type' => 'image',
            'posts_per_page' => -1,
            'orderby'        => 'menu_order',
            'order'          => 'ASC',
        ] );
        foreach ( $attachments as $att ) {
            $url = wp_get_attachment_image_url( $att->ID, 'large' );
            if ( $url ) {
                $gallery_images[] = $url;
            }
        }

        // Also parse gallery blocks from content.
        $blocks = parse_blocks( get_the_content() );
        foreach ( $blocks as $block ) {
            if ( 'core/gallery' === $block['blockName'] && ! empty( $block['innerBlocks'] ) ) {
                foreach ( $block['innerBlocks'] as $inner ) {
                    if ( 'core/image' === $inner['blockName'] && ! empty( $inner['attrs']['id'] ) ) {
                        $url = wp_get_attachment_image_url( $inner['attrs']['id'], 'large' );
                        if ( $url && ! in_array( $url, $gallery_images, true ) ) {
                            $gallery_images[] = $url;
                        }
                    }
                }
            }
        }

        // Images come in pairs: [before1, after1, before2, after2, ...]
        $pair_count = intdiv( count( $gallery_images ), 2 );
        if ( $pair_count < 1 ) {
            continue;
        }

        // Build pairs array for JS.
        $pairs = [];
        for ( $i = 0; $i < $pair_count; $i++ ) {
            $pairs[] = [
                'before' => $gallery_images[ $i * 2 ],
                'after'  => $gallery_images[ $i * 2 + 1 ],
            ];
        }
    ?>
    <div class="beaf__item"
         data-beaf-slug="<?php echo esc_attr( $slug ); ?>"
         data-beaf-title="<?php echo esc_attr( $title ); ?>"
         data-beaf-pairs="<?php echo esc_attr( wp_json_encode( $pairs ) ); ?>">
        <div class="beaf__slider" data-pair-index="0">
            <div class="beaf__slider-wrapper">
                <img class="beaf__image beaf__image--after" src="<?php echo esc_url( $pairs[0]['after'] ); ?>" alt="After" draggable="false">
                <div class="beaf__clip">
                    <img class="beaf__image beaf__image--before" src="<?php echo esc_url( $pairs[0]['before'] ); ?>" alt="Before" draggable="false">
                </div>
                <div class="beaf__divider">
                    <div class="beaf__handle">
                        <svg width="9" height="17" viewBox="0 0 9 17" fill="none"><path d="M7 1L1 8.5L7 16" stroke="#000" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
                        <svg width="9" height="17" viewBox="0 0 9 17" fill="none"><path d="M2 1L8 8.5L2 16" stroke="#000" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    </div>
                </div>
            </div>
        </div>
        <div class="beaf__info">
            <h2 class="beaf__item-title"><?php echo esc_html( $title ); ?></h2>
            <p class="beaf__item-count"><?php echo esc_html( $pair_count ); ?> <?php echo $pair_count === 1 ? 'imagen' : 'imágenes'; ?></p>
        </div>
        <?php if ( $desc ) : ?>
            <div class="beaf__description" aria-hidden="true">
                <?php echo wp_kses_post( $desc ); ?>
            </div>
        <?php endif; ?>
    </div>
    <?php endwhile; wp_reset_postdata(); ?>
</div>
<?php include get_stylesheet_directory() . '/parts/before-after-detail.php'; ?>
