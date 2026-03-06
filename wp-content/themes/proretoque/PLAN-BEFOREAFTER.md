# Plan de implementación — Sección Before & After

## Resumen

Sección con slider comparativo de imágenes antes/después. Tiene dos niveles de navegación:

1. **Página principal**: lista de categorías, cada una muestra 1 slider de preview + nombre. Fondo blanco.
2. **Vista de categoría**: al hacer click en una categoría se abre un overlay oscuro con todos los pares before/after de esa categoría apilados verticalmente, cada uno con su propio slider.

### Flujo de navegación

```
Página "Before & After" (fondo blanco)
├── [Retoque de Moda]  → click → overlay oscuro con N sliders de esa categoría
├── [Retoque de Joyería] → click → overlay oscuro con N sliders de esa categoría
├── [Retoque de Producto] → click → ...
└── ...
```

La vista de categoría incluye:
- "← Before & After" arriba a la izquierda para volver a la lista principal
- Título de la categoría centrado
- Múltiples sliders apilados verticalmente con scroll
- Fondo oscuro/negro

## Estructura

### Taxonomía custom

```
Taxonomía: ba_categoria
├── "Retoque de Moda"
├── "Retoque de Joyería"
├── "Retoque de Producto"
└── ...
```

Se registra con `register_taxonomy( 'ba_categoria', 'before_after' )`.
Administrable desde wp-admin. Cada categoría agrupa múltiples pares before/after.

### CPT

```
CPT: before_after
├── Título: nombre descriptivo del par (opcional, para identificar en admin)
├── Featured image: imagen BEFORE
├── Meta field custom: imagen AFTER (ID de attachment)
├── Taxonomía: ba_categoria (ej: "Retoque de Moda")
└── Orden: menu_order para controlar el orden dentro de la categoría
```

### Relación

```
ba_categoria: "Retoque de Moda"
├── before_after #1 (before.jpg / after.jpg)
├── before_after #2 (before.jpg / after.jpg)
└── before_after #3 (before.jpg / after.jpg)

ba_categoria: "Retoque de Joyería"
├── before_after #4 (before.jpg / after.jpg)
└── before_after #5 (before.jpg / after.jpg)
```

En la página principal se muestra 1 slider por categoría (el primer post de cada una).
Al hacer click se muestran todos los posts de esa categoría en el overlay.

## Pasos

### Paso 1: Registrar el Custom Post Type + Taxonomía

- [ ] Agregar `register_post_type( 'before_after' )` en `functions.php`
- [ ] Habilitar: título, thumbnail, page-attributes (para menu_order)
- [ ] Slug: `/before-after/`
- [ ] Icono en admin: `dashicons-image-flip-horizontal`
- [ ] Registrar taxonomía `ba_categoria` asociada al CPT
- [ ] Taxonomía jerárquica (como categorías, no tags) para que sea dropdown en admin
- [ ] Slug de taxonomía: `/before-after/categoria/`

### Paso 2: Meta box para imagen "After"

- [ ] Registrar meta box custom en `functions.php` con `add_meta_box()`
- [ ] Botón "Seleccionar imagen After" que abre el media uploader de WordPress
- [ ] Guardar el ID del attachment en `post_meta` con key `_proretoque_after_image`
- [ ] Mostrar preview de la imagen seleccionada en el meta box
- [ ] Botón "Quitar imagen" para eliminar la selección
- [ ] Todo en PHP puro, sin ACF ni plugins

### Paso 3: Registrar el shortcode

- [ ] Crear shortcode `[proretoque_before_after]` en `functions.php`
- [ ] El shortcode incluye `parts/before-after.php`
- [ ] Parámetros opcionales: `limit` (cantidad de items), `orderby`

### Paso 4: Crear los templates

**Página principal — `parts/before-after.php`**
- [ ] Título de sección "Before & After" (H1 o H2)
- [ ] Obtener todas las `ba_categoria` con `get_terms()`
- [ ] Por cada categoría: obtener el primer `before_after` post (preview)
- [ ] Renderizar 1 slider por categoría con el primer par de imágenes
- [ ] Nombre de la categoría debajo del slider
- [ ] Cada item es clickeable → abre el overlay de esa categoría
- [ ] Data attributes en cada item: `data-categoria="slug"` para que JS sepa qué abrir

**Vista de categoría (overlay) — `parts/before-after-overlay.php`**
- [ ] Overlay fullscreen con fondo oscuro (oculto por defecto)
- [ ] Header del overlay: "← Before & After" a la izquierda + título de categoría centrado
- [ ] Contenedor scrolleable con todos los sliders de la categoría
- [ ] Cada slider tiene su propio handle independiente
- [ ] Se carga dinámicamente via JS (data attributes o AJAX) al hacer click en una categoría

### Paso 5: JavaScript del slider comparativo

- [ ] Crear `assets/js/before-after-slider.js`
- [ ] Lógica del slider:
  - Imagen BEFORE como fondo completo
  - Imagen AFTER recortada con `clip-path` o `overflow:hidden` + ancho variable
  - Handle draggable en el centro (línea vertical + círculo con flechas)
  - Evento `mousedown` / `touchstart` para iniciar drag
  - Evento `mousemove` / `touchmove` para mover el handle y ajustar el clip
  - Evento `mouseup` / `touchend` para soltar
  - Posición inicial: 50% (mitad)
- [ ] Registrar el script en `functions.php` con `wp_enqueue_script`
- [ ] Sin dependencias de librerías externas (JS puro)
- [ ] Lógica del overlay:
  - Click en item de la grilla → abrir overlay con los sliders de esa categoría
  - Cargar datos via data attributes (URLs de imágenes before/after por categoría)
  - "← Before & After" cierra el overlay y vuelve a la página principal
  - Tecla Escape cierra el overlay
  - Inicializar handles de todos los sliders dentro del overlay al abrirlo

### Paso 6: Estilos CSS

- [ ] Agregar en `style.css` la sección "Before & After"
- [ ] Contenedor del slider:
  - Posición relativa, overflow hidden
  - Aspect ratio acorde al diseño de Figma
- [ ] Imágenes: posición absoluta, mismas dimensiones, object-fit cover
- [ ] Handle:
  - Línea vertical 2px, altura 100%
  - Círculo centrado ~40px con borde, fondo blanco, flechas `< >`
  - Cursor: ew-resize
- [ ] Título debajo: centrado, Raleway, tamaño según Figma
- [ ] Responsive:
  - Desktop: ancho según diseño Figma
  - Tablet: ancho completo con padding
  - Mobile: ancho completo, handle más grande para touch

### Paso 7: Crear contenido de prueba

- [ ] Crear 3-4 items de ejemplo via wp-admin
- [ ] Subir pares de imágenes before/after como placeholder
- [ ] Asignar featured image (before) y meta field (after) a cada item
- [ ] Ordenar con menu_order

### Paso 8: Insertar en una página

- [ ] Crear/editar la página "Before & After"
- [ ] Insertar `[proretoque_before_after]` en el contenido
- [ ] Verificar que funcione tanto en editor de bloques como en Elementor

### Paso 9: Verificar contra Figma

- [ ] Comparar screenshot del resultado con el diseño de Figma
- [ ] Ajustar proporciones del slider, tamaño del handle, gaps
- [ ] Probar drag en desktop (mouse) y mobile (touch)
- [ ] Validar responsive

## Archivos a crear/modificar

| Archivo | Acción |
|---------|--------|
| `functions.php` | Modificar — agregar CPT + taxonomía + meta box + shortcode + enqueue JS |
| `parts/before-after.php` | Crear — template página principal (grilla de categorías) |
| `parts/before-after-overlay.php` | Crear — template del overlay con sliders por categoría |
| `assets/js/before-after-slider.js` | Crear — lógica drag del slider + overlay de categoría |
| `style.css` | Modificar — estilos del slider + handle + overlay + responsive |

## Notas

- No se necesitan plugins extra. Meta box en PHP puro para la imagen After.
- El slider es JS puro (~50 líneas), sin librerías externas.
- Funciona con mouse (desktop) y touch (mobile).
- Cada item se administra independientemente desde wp-admin.
- El orden de aparición se controla con menu_order (drag en admin con plugin opcional, o campo numérico).
