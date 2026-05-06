<?php
/**
 * Quản lý nhúng CSS và JavaScript
 */

function shopping_enqueue_assets() {
    $theme_version = wp_get_theme()->get('Version');

    // Enqueue file chính đã có (style.css, hay tailwind) nếu cần
    // ...

    // Chỉ load CSS/JS giao diện trang chủ khi người dùng đang ở front-page (Home)
    if ( is_front_page() || is_home() ) {
        // Enqueue Trang chủ CSS
        wp_enqueue_style(
            'shopping-home-css', 
            get_template_directory_uri() . '/assets/css/home.css', 
            array(), 
            filemtime(get_template_directory() . '/assets/css/home.css') // Tự động version theo thời gian sửa file
        );

        // Enqueue Trang chủ JS (Để ở Footer -> true)
        wp_enqueue_script(
            'shopping-home-js', 
            get_template_directory_uri() . '/assets/js/home.js', 
            array(), 
            filemtime(get_template_directory() . '/assets/js/home.js'), 
            true 
        );
    }
}
add_action('wp_enqueue_scripts', 'shopping_enqueue_assets', 20);

/**
 * ======== TỐI ƯU HÓA TỐC ĐỘ VÀ CHUẨN HTML SEO ========
 */

// 1. Gỡ bỏ Emojis (Tăng tốc tải trang vì không load file wp-emoji-release.min.js)
remove_action('wp_head', 'print_emoji_detection_script', 7);
remove_action('wp_print_styles', 'print_emoji_styles');
remove_action('admin_print_scripts', 'print_emoji_detection_script');
remove_action('admin_print_styles', 'print_emoji_styles');

// 2. Gỡ bỏ các thẻ meta không cần thiết trong <head> (Bảo mật + Dọn rác SEO)
remove_action('wp_head', 'wp_generator'); // Xóa phiên bản wp
remove_action('wp_head', 'rsd_link'); // Xóa Windows Live Writer
remove_action('wp_head', 'wlwmanifest_link');

// 3. Vô hiệu hóa wp-embed (nếu không dùng tính năng nhúng link trang khác vào bài viết)
function shopping_disable_embeds_code_init() {
    remove_action('rest_api_init', 'wp_oembed_register_route');
    add_filter('embed_oembed_discover', '__return_false');
    remove_filter('oembed_dataparse', 'wp_filter_oembed_result', 10);
    remove_action('wp_head', 'wp_oembed_add_discovery_links');
    remove_action('wp_head', 'wp_oembed_add_host_js');
}
add_action('init', 'shopping_disable_embeds_code_init', 9999);

// 4. Xóa query string (?ver=) khỏi các file tĩnh JS/CSS để tăng khả năng Cache của trình duyệt
function shopping_remove_query_strings_1( $src ){	
	$rqs = explode( '?ver', $src );
        return $rqs[0];
}
if ( is_admin() ) {
// Remove query strings from static resources disabled in admin
} else {
add_filter( 'script_loader_src', 'shopping_remove_query_strings_1', 15, 1 );
add_filter( 'style_loader_src', 'shopping_remove_query_strings_1', 15, 1 );
}
