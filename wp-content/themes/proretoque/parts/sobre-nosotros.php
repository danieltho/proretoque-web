<?php
/**
 * Sobre Nosotros — Page template.
 * Hero + dual tabs (Proretoque/Clientes) + accordion + stats.
 */

$features = [
    [ 'title' => 'IA AL SERVICIO DE TU MARCA',          'text' => 'Optimizamos procesos y ampliamos posibilidades visuales sin perder tu identidad.' ],
    [ 'title' => 'CAPACIDAD REAL EN MOMENTOS CRÍTICOS', 'text' => 'Gestionamos urgencias y lanzamientos sin que tengas que preocuparte por el retoque.' ],
    [ 'title' => 'CALIDAD COMO OBJETIVO',               'text' => 'Absorbemos presión operativa sin que el resultado visual lo acuse.' ],
];

$accordion_items = [
    [ 'title' => 'EXPERIENCIA',         'text' => 'Retoque de imágenes para marcas exigentes que quieren que el retoque sea una parte estratégica del proceso.' ],
    [ 'title' => 'ATENCIÓN AL DETALLE', 'text' => 'Cuidamos color, acabado y coherencia visual con el mismo rigor con el que una marca cuida su identidad.' ],
    [ 'title' => 'COMUNICACIÓN',        'text' => 'Clara, resolutiva y visual.' ],
    [ 'title' => 'SERVICIO AL CLIENTE', 'text' => 'Nos adaptamos a tu forma de trabajar y respondemos cuando más lo necesitas, como parte real de tu equipo.' ],
];

$stats = [
    [ 'num' => '50k+', 'label' => 'Trabajos Completados' ],
    [ 'num' => '2M+',  'label' => 'Imágenes Procesadas' ],
    [ 'num' => '3k+',  'label' => 'Clientes Registrados' ],
];

// Logos del carrusel (visibles). Reemplazar <span> por <img> cuando haya assets.
$brands = [ 'ZARA', 'Massimo Dutti', 'LOEWE', 'SILBON', 'TOUS', 'POLO CLUB', 'LEFTIES', 'PARFOIS', 'sklum', 'MANGO', 'SEPHORA', 'PULL&BEAR' ];

$brands_prose = 'Massimo Dutti, Zara, Loewe, Silbon, Mango, Álvaro Moreno, Lefties, Polo Club, Laagam, Blue Banana, Tous, Parfois, Décimas, Camper, Salerm, 3ina, Sklum, Plátano Melón, El Corte Inglés, Ysabel Mora, El Ganso, Bobol, Eroski, Harper & Neyer, Bassols, Dia, Hispanitas, Kave Home, Stradivarius, Santa Eulalia, Scalpers, Sephora, Correos, Westwing, Create, Jimmy Lion, Deporvillage, Unisa, Wonders, Pull & Bear.';
?>

<section class="sobre-nosotros">
    <div class="sobre-nosotros__inner">

        <!-- Hero -->
        <div class="sobre-nosotros__hero">
            <h1 class="sobre-nosotros__title">Sobre nosotros</h1>
            <p class="sobre-nosotros__subtitle">Somos una plataforma de retoque fotográfico profesional especializada en ecommerce y editorial, apoyada en un equipo dedicado y una tecnología propia con IA creativa integrada, que optimiza procesos y amplía las posibilidades visuales bajo decisión del cliente.</p>
            <hr class="sobre-nosotros__divider">
        </div>

        <!-- Dual tabs: Proretoque / Clientes -->
        <div class="sobre-nosotros__dual" data-sn-dual>
            <div class="sobre-nosotros__dual-top">

                <!-- Visual (izquierda) -->
                <div class="sobre-nosotros__dual-visual is-active" data-sn-visual="proretoque">
                    <!-- TODO: reemplazar por mockup real (/assets/images/sobre-nosotros-mockup.png) -->
                    <div class="sobre-nosotros__visual-placeholder"></div>
                </div>
                <div class="sobre-nosotros__dual-visual" data-sn-visual="clientes" hidden>
                    <div class="sobre-nosotros__brands-cloud">
                        <div class="sobre-nosotros__brands-bg" aria-hidden="true">
                            <?php foreach ( $brands as $b ) : ?>
                                <span class="sobre-nosotros__brands-bg-item"><?php echo esc_html( $b ); ?></span>
                            <?php endforeach; ?>
                        </div>
                        <div class="sobre-nosotros__brands-title">Brands we have<br>Worked with.</div>
                    </div>
                </div>

                <!-- Tabs + contenido (derecha) -->
                <div class="sobre-nosotros__dual-text">
                    <div class="sobre-nosotros__dual-tabs" role="tablist">
                        <button type="button" class="sobre-nosotros__dual-tab is-active" role="tab" aria-selected="true" data-sn-tab="proretoque">Proretoque</button>
                        <button type="button" class="sobre-nosotros__dual-tab" role="tab" aria-selected="false" data-sn-tab="clientes">Clientes</button>
                    </div>

                    <div class="sobre-nosotros__dual-panel is-active" role="tabpanel" data-sn-panel="proretoque">
                        <p>ProRetoque nace de una realidad compartida por empresas y fotógrafos: cuando el volumen aumenta y los plazos se acortan, la edición puede convertirse en un punto crítico.</p>
                        <p>Por eso desarrollamos, al ritmo del sector, un modelo híbrido que combina retoque profesional, tecnología con IA integrada y un trato personalizado adaptado a cada dinámica de trabajo.</p>
                        <p>No se trata solo de retocar, sino de aportar estructura, continuidad y calidad.</p>
                        <a href="#contacto" class="sobre-nosotros__btn sobre-nosotros__btn--outline">Contáctanos</a>
                    </div>

                    <div class="sobre-nosotros__dual-panel" role="tabpanel" data-sn-panel="clientes" hidden>
                        <p class="sobre-nosotros__dual-panel-lead">Algunos de nuestros clientes:</p>
                        <p class="sobre-nosotros__dual-panel-prose"><?php echo esc_html( $brands_prose ); ?></p>
                        <a href="#contacto" class="sobre-nosotros__btn sobre-nosotros__btn--outline">Contáctanos</a>
                    </div>
                </div>
            </div>

            <!-- Bloque inferior: cards (Proretoque) / carrusel (Clientes) -->
            <div class="sobre-nosotros__dual-below is-active" data-sn-below="proretoque">
                <div class="sobre-nosotros__cards">
                    <?php foreach ( $features as $f ) : ?>
                        <div class="sobre-nosotros__card">
                            <h3 class="sobre-nosotros__card-title"><?php echo esc_html( $f['title'] ); ?></h3>
                            <p class="sobre-nosotros__card-text"><?php echo esc_html( $f['text'] ); ?></p>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <div class="sobre-nosotros__dual-below" data-sn-below="clientes" hidden>
                <div class="sobre-nosotros__carousel" data-sn-carousel>
                    <button type="button" class="sobre-nosotros__carousel-nav sobre-nosotros__carousel-nav--prev" aria-label="Anterior" data-sn-prev>&lsaquo;</button>
                    <div class="sobre-nosotros__carousel-track" data-sn-track>
                        <?php foreach ( $brands as $b ) : ?>
                            <div class="sobre-nosotros__carousel-item">
                                <!-- TODO: swap <span> por <img src="/assets/images/brands/<slug>.svg"> -->
                                <span class="sobre-nosotros__brand-logo"><?php echo esc_html( $b ); ?></span>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <button type="button" class="sobre-nosotros__carousel-nav sobre-nosotros__carousel-nav--next" aria-label="Siguiente" data-sn-next>&rsaquo;</button>
                </div>
            </div>
        </div>

        <!-- Por qué elegirnos -->
        <div class="sobre-nosotros__porque">
            <div class="sobre-nosotros__porque-text">
                <h2 class="sobre-nosotros__porque-title">Por qué elegirnos</h2>
                <p>Somos un partner visual. Sostenemos tu identidad y cuidamos cada imagen como parte de un todo.</p>
                <p>La imagen no se delega sin más: se acompaña.<br>Trabajamos desde una visión compartida para que cada entrega mantenga coherencia, calidad y nivel.</p>
                <p>Variedad de retoques.<br>Eficiencia real en el flujo de trabajo.<br>Rentabilidad sin perder calidad.</p>
                <p>Generación de imágenes con IA e IA aplicada al marketing para optimizar procesos.</p>
                <p>Compromiso real en plazos exigentes.</p>
                <p>Nuestro objetivo es claro: que destaques frente a la competencia y que tu imagen siempre esté a la altura.</p>
                <a href="#proyectos" class="sobre-nosotros__btn sobre-nosotros__btn--outline">Proyectos recientes</a>
            </div>

            <div class="sobre-nosotros__accordion">
                <?php foreach ( $accordion_items as $idx => $it ) :
                    $num      = str_pad( $idx + 1, 2, '0', STR_PAD_LEFT );
                    $is_first = ( $idx === 0 );
                ?>
                <div class="sobre-nosotros__acc-item<?php echo $is_first ? ' is-open' : ''; ?>" data-sn-acc>
                    <div class="sobre-nosotros__acc-header" role="button" aria-expanded="<?php echo $is_first ? 'true' : 'false'; ?>" tabindex="0">
                        <span class="sobre-nosotros__acc-number"><?php echo esc_html( $num ); ?></span>
                        <span class="sobre-nosotros__acc-title"><?php echo esc_html( $it['title'] ); ?></span>
                        <span class="sobre-nosotros__acc-icon" aria-hidden="true">
                            <svg width="28" height="28" viewBox="0 0 32 32" fill="none">
                                <circle cx="16" cy="16" r="12" stroke="currentColor" stroke-width="1.5"/>
                                <line x1="10" y1="16" x2="22" y2="16" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                                <line x1="16" y1="10" x2="16" y2="22" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" class="sobre-nosotros__acc-icon-plus"/>
                            </svg>
                        </span>
                    </div>
                    <div class="sobre-nosotros__acc-body" aria-hidden="<?php echo $is_first ? 'false' : 'true'; ?>">
                        <p><?php echo esc_html( $it['text'] ); ?></p>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- Stats -->
        <div class="sobre-nosotros__stats">
            <?php foreach ( $stats as $s ) : ?>
                <div class="sobre-nosotros__stat">
                    <span class="sobre-nosotros__stat-num"><?php echo esc_html( $s['num'] ); ?></span>
                    <span class="sobre-nosotros__stat-label"><?php echo esc_html( $s['label'] ); ?></span>
                </div>
            <?php endforeach; ?>
        </div>

    </div>
</section>
