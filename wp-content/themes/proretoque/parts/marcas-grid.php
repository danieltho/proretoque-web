<?php
/**
 * Marcas Grid — renders the asymmetric brand grid.
 * Included via [proretoque_marcas] shortcode.
 */

$marcas = new WP_Query( [
    'post_type'      => 'marca',
    'posts_per_page' => -1,
    'orderby'        => 'menu_order',
    'order'          => 'ASC',
] );

if ( ! $marcas->have_posts() ) {
    return;
}
?>
<div class="marcas-grid">
    <?php while ( $marcas->have_posts() ) : $marcas->the_post();
        $thumb_url = get_the_post_thumbnail_url( get_the_ID(), 'large' ) ?: '';
        $title     = get_the_title();
        $content   = apply_filters( 'the_content', get_the_content() );

        // Collect gallery image URLs from attached images.
        $gallery_images = [];
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

        // Also parse gallery blocks from content for image URLs.
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

        $image_count = count( $gallery_images );
    ?>
    <article class="marcas-grid__item"
             data-marca-title="<?php echo esc_attr( $title ); ?>"
             data-marca-description="<?php echo esc_attr( $content ); ?>"
             data-marca-images="<?php echo esc_attr( wp_json_encode( $gallery_images ) ); ?>">
        <?php if ( $thumb_url ) : ?>
            <div class="marcas-grid__image" style="background-image: url('<?php echo esc_url( $thumb_url ); ?>')"></div>
        <?php else : ?>
            <div class="marcas-grid__image marcas-grid__image--placeholder"></div>
        <?php endif; ?>
        <div class="marcas-grid__info">
            <span class="marcas-grid__name"><?php echo esc_html( $title ); ?></span>
            <?php if ( $image_count > 0 ) : ?>
                <span class="marcas-grid__count"><?php echo esc_html( $image_count ); ?> imágenes</span>
            <?php endif; ?>
        </div>
    </article>
    <?php endwhile; wp_reset_postdata(); ?>
</div>

<?php include get_stylesheet_directory() . '/parts/marcas-lightbox.php'; ?>
