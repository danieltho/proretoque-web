# Plan de implementación — Sección Marcas/Clientes

## Resumen

Grilla asimétrica de marcas/clientes. Cada item tiene imagen de portada, nombre de marca y cantidad de imágenes en su galería. El layout alterna entre items grandes (2/3) y chicos (1/3).

## Pasos

### Paso 1: Registrar el Custom Post Type

- [ ] Agregar `register_post_type( 'marca' )` en `functions.php`
- [ ] Habilitar: título, editor, thumbnail, excerpt
- [ ] Sin archivo individual por ahora (las marcas se ven solo en la grilla)
- [ ] Slug: `/marcas/`

### Paso 2: Registrar el shortcode

- [ ] Crear shortcode `[proretoque_marcas]` en `functions.php`
- [ ] El shortcode incluye `parts/marcas-grid.php`
- [ ] Permite insertar la grilla en cualquier página (Elementor o FSE)

### Paso 3: Crear el template de la grilla

- [ ] Crear `parts/marcas-grid.php`
- [ ] `WP_Query` que trae todos los posts tipo `marca`
- [ ] Cada item renderiza: imagen destacada + título + conteo de imágenes de la galería
- [ ] El conteo se calcula buscando bloques `gallery` o imágenes adjuntas al post

### Paso 4: Estilos CSS de la grilla

- [ ] Agregar en `style.css` la sección "Marcas Grid"
- [ ] CSS Grid de 3 columnas
- [ ] Patrón asimétrico con `nth-child`:
  - Items 1, 4, 7... → `grid-column: span 2` (grande)
  - Items 2, 5, 8... → `grid-column: span 1` (chico)
  - Confirmar patrón exacto contra Figma
- [ ] Responsive: en mobile todo a 1 columna

### Paso 5: Lightbox / Visor de galería

Al hacer click en una marca de la grilla se abre un visor fullscreen con las imágenes de esa marca.

**Elementos del lightbox:**
- Overlay fullscreen con fondo negro/oscuro
- Imagen principal centrada (grande)
- Flechas ← → para navegar entre imágenes de la galería
- Nombre de la marca debajo de la imagen
- Barra inferior con 3 elementos:
  - Izquierda: "← Inicio" — cierra el lightbox y vuelve a la grilla
  - Centro: "1/3" — contador de imagen actual / total
  - Derecha: "Descripción" — toggle que muestra info/descripción de la marca
- De fondo (detrás del overlay) se ven las demás imágenes de la galería en grid, oscurecidas

**Implementación:**
- [ ] Crear `parts/marcas-lightbox.php` — markup HTML del lightbox (oculto por defecto)
- [ ] Crear `assets/js/marcas-lightbox.js` — JS para:
  - Abrir lightbox al click en un item de la grilla
  - Cargar las imágenes de la galería de esa marca (via data attributes o AJAX)
  - Navegación con flechas (click + teclado ← →)
  - Contador de imagen actual
  - Toggle de descripción
  - Cerrar con "Inicio" o tecla Escape
  - Toggle "Descripción": muestra/oculta panel de texto sobre las imágenes
- [ ] Agregar estilos del lightbox en `style.css`:
  - Overlay fixed fullscreen, z-index alto
  - Imagen centrada con max-width/max-height
  - Flechas posicionadas a los lados
  - Barra inferior con flexbox justify-between
  - Transiciones suaves al cambiar imagen
- [ ] Registrar el script en `functions.php` con `wp_enqueue_script`
- [ ] En `parts/marcas-grid.php`, cada item debe incluir data attributes con las URLs de las imágenes de la galería para que el JS las pueda leer

**Panel de descripción (toggle):**
- Se activa al hacer click en "Descripción" de la barra inferior
- Overlay de texto sobre el fondo oscuro con las imágenes detrás (oscurecidas)
- Nombre de la marca centrado como título (blanco)
- Debajo: texto descriptivo (contenido del post, blanco, centrado horizontal)
- Si el texto es largo: scroll vertical dentro del panel
- Al volver a hacer click en "Descripción" o en otra acción, se oculta y vuelve al visor de imágenes
- El contenido se toma del campo `post_content` del CPT marca

**Datos que necesita el lightbox por cada marca:**
- Nombre de la marca (`the_title()`)
- Descripción (`the_content()` del post)
- Array de URLs de imágenes de la galería
- Imagen actual seleccionada

### Paso 6: Crear contenido de prueba

- [ ] Crear 4-6 marcas de ejemplo via wp-admin o WP-CLI
- [ ] Subir imágenes placeholder como featured images
- [ ] Agregar galerías de prueba en el contenido de cada marca

### Paso 6: Insertar en una página

- [ ] Crear/editar la página donde va la grilla
- [ ] Insertar `[proretoque_marcas]` en el contenido

### Paso 7: Verificar contra Figma

- [ ] Comparar screenshot del resultado con el diseño de Figma
- [ ] Ajustar gaps, tamaños, proporciones
- [ ] Validar responsive (tablet y mobile)

## Archivos a crear/modificar

| Archivo | Acción |
|---------|--------|
| `functions.php` | Modificar — agregar CPT + shortcode + enqueue JS |
| `parts/marcas-grid.php` | Crear — template de la grilla |
| `parts/marcas-lightbox.php` | Crear — markup del visor fullscreen |
| `assets/js/marcas-lightbox.js` | Crear — lógica del lightbox (navegación, contador, toggle) |
| `style.css` | Modificar — agregar estilos de la grilla + lightbox |

## Notas

- No se necesitan plugins extra (sin ACF). Se usa la galería nativa de WordPress.
- El conteo de imágenes se obtiene programáticamente del contenido del post.
- La página individual de cada marca se puede implementar en una fase posterior.
