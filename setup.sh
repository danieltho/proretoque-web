#!/usr/bin/env bash
# =============================================================================
# ProRetoque — Instalación base completa.
# Ejecutar desde wp/:  ./setup.sh
#
# Requiere:  docker compose up -d  (DB + WordPress corriendo)
# =============================================================================

set -euo pipefail

# ---------------------------------------------------------------------------
# Helpers
# ---------------------------------------------------------------------------
WP="docker compose run --rm wpcli wp"

info()  { printf "\n\033[1;34m→ %s\033[0m\n" "$1"; }
ok()    { printf "  \033[0;32m✔ %s\033[0m\n" "$1"; }
warn()  { printf "  \033[0;33m⚠ %s\033[0m\n" "$1"; }

# Load .env for variables.
set -a; source .env; set +a

# ---------------------------------------------------------------------------
# 1. Wait for DB
# ---------------------------------------------------------------------------
info "Esperando que la base de datos esté lista..."
for i in $(seq 1 30); do
    if $WP db check --quiet 2>/dev/null; then
        ok "Base de datos lista"
        break
    fi
    if [ "$i" -eq 30 ]; then
        echo "ERROR: La base de datos no respondió a tiempo."
        exit 1
    fi
    sleep 2
done

# ---------------------------------------------------------------------------
# 2. Install WordPress core (if not already installed)
# ---------------------------------------------------------------------------
info "Verificando instalación de WordPress..."
if ! $WP core is-installed 2>/dev/null; then
    $WP core install \
        --url="http://localhost:${WP_PORT}" \
        --title="${WP_SITE_TITLE:-ProRetoque}" \
        --admin_user="${WP_ADMIN_USER:-admin}" \
        --admin_password="${WP_ADMIN_PASSWORD:-admin_password}" \
        --admin_email="${WP_ADMIN_EMAIL:-admin@example.com}" \
        --skip-email
    ok "WordPress instalado"
else
    ok "WordPress ya estaba instalado"
fi

# ---------------------------------------------------------------------------
# 3. Basic settings
# ---------------------------------------------------------------------------
info "Configurando ajustes generales..."
$WP option update blogname "ProRetoque"
$WP option update blogdescription "Retoque fotográfico profesional"
$WP option update timezone_string "Europe/Madrid"
$WP option update date_format "d/m/Y"
$WP option update permalink_structure "/%postname%/"
$WP rewrite flush
ok "Ajustes generales configurados"

# ---------------------------------------------------------------------------
# 4. Activate theme
# ---------------------------------------------------------------------------
info "Activando tema ProRetoque..."
$WP theme activate proretoque
ok "Tema proretoque activado"

# ---------------------------------------------------------------------------
# 5. Delete default content
# ---------------------------------------------------------------------------
info "Limpiando contenido por defecto..."
$WP post delete 1 --force 2>/dev/null || true   # Hello World
$WP post delete 2 --force 2>/dev/null || true   # Sample Page
$WP post delete 3 --force 2>/dev/null || true   # Privacy Policy draft
ok "Contenido por defecto eliminado"

# ---------------------------------------------------------------------------
# 6. Create pages
# ---------------------------------------------------------------------------
info "Creando páginas..."

create_page() {
    local slug="$1" title="$2" content="$3"
    if $WP post list --post_type=page --name="$slug" --format=ids | grep -q '[0-9]'; then
        warn "Página '$title' ya existe — se omite"
    else
        $WP post create \
            --post_type=page \
            --post_status=publish \
            --post_title="$title" \
            --post_name="$slug" \
            --post_content="$content"
        ok "Página: $title"
    fi
}

create_page "inicio"             "Inicio"              ""
create_page "marcas"             "Marcas"              "[proretoque_marcas]"
create_page "before-after"       "Before & After"      "[proretoque_before_after]"
create_page "contacto"           "Contacto"            "[proretoque_contactanos]"
create_page "empieza-tu-proyecto" "Empieza tu Proyecto" "[proretoque_empieza_proyecto]"
create_page "trabaja-con-nosotros" "Trabaja con Nosotros" "[proretoque_trabaja]"
create_page "preguntas-frecuentes" "Preguntas Frecuentes" "[proretoque_faq]"

# Set homepage.
HOMEPAGE_ID=$($WP post list --post_type=page --name=inicio --format=ids)
if [ -n "$HOMEPAGE_ID" ]; then
    $WP option update show_on_front page
    $WP option update page_on_front "$HOMEPAGE_ID"
    ok "Página de inicio configurada"
fi

# ---------------------------------------------------------------------------
# 7. Create navigation menus
# ---------------------------------------------------------------------------
info "Creando menús de navegación..."

create_menu_if_missing() {
    local menu_name="$1" location="$2"
    if ! $WP menu list --format=ids --fields=name 2>/dev/null | grep -q "$menu_name"; then
        $WP menu create "$menu_name"
    fi
    $WP menu location assign "$menu_name" "$location"
    ok "Menú: $menu_name → $location"
}

# Header menu
create_menu_if_missing "Header" "header-menu"

add_page_to_menu() {
    local menu="$1" page_slug="$2" title="$3"
    local page_id
    page_id=$($WP post list --post_type=page --name="$page_slug" --format=ids)
    if [ -n "$page_id" ]; then
        $WP menu item add-post "$menu" "$page_id" --title="$title" 2>/dev/null || true
    fi
}

add_custom_to_menu() {
    local menu="$1" title="$2" url="$3"
    $WP menu item add-custom "$menu" "$title" "$url" 2>/dev/null || true
}

# Header items
add_page_to_menu "Header" "before-after" "Before / After"
add_custom_to_menu "Header" "Cómo funciona" "#como-funciona"
add_custom_to_menu "Header" "IA Creativa" "#ia-creativa"
add_custom_to_menu "Header" "Iniciar Sesión" "#login"

# Footer Column 1
create_menu_if_missing "Footer Col 1" "footer-col-1"
add_custom_to_menu "Footer Col 1" "Blog" "#blog"
add_custom_to_menu "Footer Col 1" "Ayuda" "#ayuda"
add_page_to_menu  "Footer Col 1" "contacto" "Contacto"
add_custom_to_menu "Footer Col 1" "Sobre Nosotros" "#sobre-nosotros"
add_page_to_menu  "Footer Col 1" "empieza-tu-proyecto" "Empieza tu proyecto"
add_page_to_menu  "Footer Col 1" "preguntas-frecuentes" "Preguntas frecuentes"

# Footer Column 2
create_menu_if_missing "Footer Col 2" "footer-col-2"
add_custom_to_menu "Footer Col 2" "Registrarse" "#registrarse"
add_custom_to_menu "Footer Col 2" "Iniciar sesión" "#login"
add_custom_to_menu "Footer Col 2" "Recuperar contraseña" "#recuperar"
add_page_to_menu  "Footer Col 2" "trabaja-con-nosotros" "Trabaja con nosotros"

# Footer Legal
create_menu_if_missing "Footer Legal" "footer-legal"
add_custom_to_menu "Footer Legal" "Política y Privacidad" "#privacidad"
add_custom_to_menu "Footer Legal" "Términos y condiciones" "#terminos"
add_custom_to_menu "Footer Legal" "Aviso legal" "#aviso-legal"

# ---------------------------------------------------------------------------
# 8. Create sample FAQ entries
# ---------------------------------------------------------------------------
info "Creando preguntas frecuentes de ejemplo..."

create_faq() {
    local order="$1" title="$2" content="$3"
    if $WP post list --post_type=faq --title="$title" --format=ids | grep -q '[0-9]'; then
        warn "FAQ '$title' ya existe — se omite"
    else
        $WP post create \
            --post_type=faq \
            --post_status=publish \
            --post_title="$title" \
            --post_content="$content" \
            --menu_order="$order"
        ok "FAQ: $title"
    fi
}

create_faq 1 "Experiencia" \
    "Retoque de imágenes para marcas exigentes que quieren que el retoque sea una parte estratégica del proceso."

create_faq 2 "Atención al detalle" \
    "Cuidamos color, acabado y coherencia visual con el mismo rigor con el que una marca cuida su identidad."

create_faq 3 "Comunicación" \
    "Clara, resolutiva y visual."

create_faq 4 "Servicio al cliente" \
    "Nos adaptamos a tu forma de trabajar y respondemos cuando más lo necesitas, como parte real de tu equipo."

# ---------------------------------------------------------------------------
# 9. Activate plugins (if available)
# ---------------------------------------------------------------------------
info "Verificando plugins..."
$WP plugin activate elementor 2>/dev/null && ok "Elementor activado" || warn "Elementor no encontrado"
$WP plugin activate contact-form-7 2>/dev/null && ok "CF7 activado" || warn "CF7 no encontrado"

# ---------------------------------------------------------------------------
# 10. Final flush
# ---------------------------------------------------------------------------
info "Limpieza final..."
$WP rewrite flush
$WP cache flush 2>/dev/null || true
ok "Cache limpiada"

echo ""
echo "============================================"
echo "  ProRetoque instalado correctamente"
echo "  http://localhost:${WP_PORT}"
echo "  Admin: http://localhost:${WP_PORT}/wp-admin"
echo "  Usuario: ${WP_ADMIN_USER:-admin}"
echo "  Password: ${WP_ADMIN_PASSWORD:-admin_password}"
echo "============================================"
echo ""
