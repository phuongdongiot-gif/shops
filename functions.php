<?php
/**
 * Shopping theme functions and definitions
 */

if ( ! defined( '_S_VERSION' ) ) {
	// Replace the version number of the theme on each release.
	define( '_S_VERSION', '1.0.0' );
}

// Require Custom Assets
require_once get_template_directory() . '/inc/enqueue-assets.php';
require_once get_template_directory() . '/inc/branches-cpt.php';

/**
 * Sets up theme defaults and registers support for various WordPress features.
 */
function shopping_setup() {
	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	// Let WordPress manage the document title.
	add_theme_support( 'title-tag' );

	// Enable support for Post Thumbnails on posts and pages.
	add_theme_support( 'post-thumbnails' );

    // Enable LearnPress Theme Support so our custom templates in /learnpress/ are loaded
    add_theme_support( 'learnpress' );
    add_theme_support( 'learnpress_custom_template' );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus(
		array(
			'menu-1' => esc_html__( 'Primary', 'shopping' ),
			'footer' => esc_html__( 'Footer Menu', 'shopping' ),
		)
	);

	// Switch default core markup for search form, comment form, and comments to output valid HTML5.
	add_theme_support(
		'html5',
		array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
			'style',
			'script',
		)
	);

	// Custom Background
	add_theme_support(
		'custom-background',
		apply_filters(
			'shopping_custom_background_args',
			array(
				'default-color' => 'F9FAFB',
				'default-image' => '',
			)
		)
	);

	// Add theme support for selective refresh for widgets.
	add_theme_support( 'customize-selective-refresh-widgets' );

	// Add support for core custom logo.
	add_theme_support(
		'custom-logo',
		array(
			'height'      => 100,
			'width'       => 300,
			'flex-width'  => true,
			'flex-height' => true,
		)
	);

	// WooCommerce Support
	add_theme_support( 'woocommerce', array(
        'thumbnail_image_width' => 300,
        'gallery_thumbnail_image_width' => 100,
        'single_image_width' => 600,
    ) );
	add_theme_support( 'wc-product-gallery-zoom' );
	add_theme_support( 'wc-product-gallery-lightbox' );
	add_theme_support( 'wc-product-gallery-slider' );
	add_theme_support( 'align-wide' );
	add_theme_support( 'responsive-embeds' );
	
	// Khai báo hỗ trợ LearnPress tương tự WooCommerce
	add_theme_support( 'learnpress' );
}
add_action( 'after_setup_theme', 'shopping_setup' );

/**
 * Vô hiệu hóa hoàn toàn sự can thiệp của Polylang vào các bài đăng của LearnPress
 * Đảm bảo khóa học hiển thị ở tất cả các ngôn ngữ
 */
add_filter( 'pll_get_post_types', 'shopping_disable_polylang_lp', 10, 2 );
function shopping_disable_polylang_lp( $post_types, $is_settings ) {
    $lp_types = array( 'lp_course', 'lp_lesson', 'lp_quiz', 'lp_question' );
    foreach ( $lp_types as $type ) {
        if ( isset( $post_types[ $type ] ) ) {
            unset( $post_types[ $type ] );
        }
    }
    return $post_types;
}

/**
 * Kích hoạt WP REST API (show_in_rest) cho các Custom Post Type của LearnPress
 * Để NextJS hoặc các ứng dụng Frontend có thể fetch dữ liệu qua /wp-json/wp/v2/lp_course
 */
add_filter( 'register_post_type_args', 'shopping_enable_rest_learnpress', 10, 2 );
function shopping_enable_rest_learnpress( $args, $post_type ) {
    if ( in_array( $post_type, array( 'lp_course', 'lp_lesson', 'lp_quiz', 'lp_question' ) ) ) {
        $args['show_in_rest'] = true;
    }
    return $args;
}

/**
 * Hàm lấy ảnh cực mạnh: Bỏ qua toàn bộ cơ chế chặn của Polylang và RankMath bằng cách truy vấn thẳng vào Database (Raw SQL)
 */
function shopping_get_bypass_thumbnail_url( $post_id ) {
    global $wpdb;
    
    // 1. Thử lấy từ Rank Math trước
    $rm_fb = get_post_meta( $post_id, 'rank_math_facebook_image', true );
    if ( ! empty( $rm_fb ) ) return $rm_fb;
    
    $rm_tw = get_post_meta( $post_id, 'rank_math_twitter_image', true );
    if ( ! empty( $rm_tw ) ) return $rm_tw;

    // 2. Lấy ID ảnh đại diện thực tế (Bỏ qua filter get_post_meta bị chặn)
    $thumb_id = $wpdb->get_var( $wpdb->prepare( "SELECT meta_value FROM {$wpdb->postmeta} WHERE post_id = %d AND meta_key = '_thumbnail_id'", $post_id ) );
    if ( $thumb_id ) {
        // Lấy link gốc từ Database (bỏ qua wp_get_attachment_image bị chặn)
        $url = $wpdb->get_var( $wpdb->prepare( "SELECT guid FROM {$wpdb->posts} WHERE ID = %d", $thumb_id ) );
        if ( $url ) return $url;
    }
    return '';
}

/**
 * Enqueue scripts and styles.
 */
function shopping_scripts() {
	wp_enqueue_style( 'shopping-style', get_stylesheet_uri(), array(), _S_VERSION );
	// Optionally add a custom JS file here
}
add_action( 'wp_enqueue_scripts', 'shopping_scripts' );

/**
 * Register widget area.
 */
function shopping_widgets_init() {
	register_sidebar(
		array(
			'name'          => esc_html__( 'Footer 1', 'shopping' ),
			'id'            => 'footer-1',
			'description'   => esc_html__( 'Add widgets here.', 'shopping' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title text-white text-xl font-heading font-bold mb-6">',
			'after_title'   => '</h2>',
		)
	);
	register_sidebar(
		array(
			'name'          => esc_html__( 'Footer 2', 'shopping' ),
			'id'            => 'footer-2',
			'description'   => esc_html__( 'Add widgets here.', 'shopping' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title text-white text-xl font-heading font-bold mb-6">',
			'after_title'   => '</h2>',
		)
	);
	register_sidebar(
		array(
			'name'          => esc_html__( 'Footer 3', 'shopping' ),
			'id'            => 'footer-3',
			'description'   => esc_html__( 'Add widgets here.', 'shopping' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title text-white text-xl font-heading font-bold mb-6">',
			'after_title'   => '</h2>',
		)
	);
}
add_action( 'widgets_init', 'shopping_widgets_init' );

/**
 * Ensure cart contents update when products are added to the cart via AJAX
 */
function shopping_woocommerce_cart_link_fragment( $fragments ) {
	ob_start();
	?>
	<div class="header-cart-count"><?php echo WC()->cart->get_cart_contents_count(); ?></div>
	<?php
	$fragments['div.header-cart-count'] = ob_get_clean();
	return $fragments;
}
add_filter( 'woocommerce_add_to_cart_fragments', 'shopping_woocommerce_cart_link_fragment' );

/**
 * Register Polylang strings for translation
 */
function shopping_pll_register_strings() {
	if ( function_exists( 'pll_register_string' ) ) {
		// Front page
		pll_register_string( 'Hero Title', 'Experience the Future of Shopping', 'Shopping Theme' );
		pll_register_string( 'Hero Desc', 'Discover our premium collections designed to elevate your everyday lifestyle with stunning quality and elegant aesthetics.', 'Shopping Theme' );
		pll_register_string( 'Hero Btn 1', 'Shop Now', 'Shopping Theme' );
		pll_register_string( 'Hero Btn 2', 'Discover More', 'Shopping Theme' );
		pll_register_string( 'Trending Title', 'Trending Now', 'Shopping Theme' );
		pll_register_string( 'Trending Desc', 'Explore our most popular pieces handpicked just for you.', 'Shopping Theme' );
		pll_register_string( 'Trending Btn', 'View All Products', 'Shopping Theme' );
		pll_register_string( 'Benefit 1 Title', 'Premium Quality', 'Shopping Theme' );
		pll_register_string( 'Benefit 1 Desc', 'Crafted with excellence and top-tier materials.', 'Shopping Theme' );
		pll_register_string( 'Benefit 2 Title', 'Secure Payments', 'Shopping Theme' );
		pll_register_string( 'Benefit 2 Desc', '100% secure checkout via advanced encryption.', 'Shopping Theme' );
		pll_register_string( 'Benefit 3 Title', 'Fast Lighting Shipping', 'Shopping Theme' );
		pll_register_string( 'Benefit 3 Desc', 'Free, fast, and reliable shipping worldwide.', 'Shopping Theme' );
		
		// News
		pll_register_string( 'News Title', 'Latest News', 'Shopping Theme' );
		pll_register_string( 'News Desc', 'Stay updated with our latest news and tips.', 'Shopping Theme' );
		pll_register_string( 'News Read More', 'Read More', 'Shopping Theme' );
		pll_register_string( 'News None', 'No news found.', 'Shopping Theme' );
		pll_register_string( 'News View All', 'View All News', 'Shopping Theme' );

		// Footer
		pll_register_string( 'Footer About', 'About Us', 'Shopping Theme' );
		pll_register_string( 'Footer About Desc', 'Provide the best products at the best prices with premium services.', 'Shopping Theme' );
		pll_register_string( 'Footer Links', 'Quick Links', 'Shopping Theme' );
		pll_register_string( 'Footer Shop', 'Shop', 'Shopping Theme' );
		pll_register_string( 'Footer About Link', 'About', 'Shopping Theme' );
		pll_register_string( 'Footer Contact', 'Contact', 'Shopping Theme' );
		pll_register_string( 'Footer Social', 'Follow Us', 'Shopping Theme' );
		pll_register_string( 'Footer Copyright', 'All rights reserved.', 'Shopping Theme' );
	}
}
add_action( 'init', 'shopping_pll_register_strings' );

/**
 * Helper function for translating strings safely
 */
function shopping_e( $string ) {
	if ( function_exists( 'pll_e' ) ) {
		pll_e( $string );
	} else {
		echo $string;
	}
}

/**
 * Integrate Tailwind CSS CDN
 */
function shopping_add_tailwind_cdn() {
    // Lấy màu từ Customizer do người dùng gán, nếu chưa có thì dùng màu gốc.
    $primary_color = get_theme_mod('shopping_primary_color', '#ea580c');
    ?>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Outfit:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
      tailwind.config = {
        theme: {
          extend: {
            colors: {
              primary: '<?php echo esc_js($primary_color); ?>', /* Màu động lấy từ Customizer */
              'primary-hover': '#c2410c', // orange-700
              secondary: '#fff7ed', // orange-50
              accent: '#166534', // green-800
              dark: '#111827',
              body: '#4B5563',
              bordercol: '#E5E7EB',
            },
            fontFamily: {
              base: ['Inter', 'sans-serif'],
              heading: ['Outfit', 'sans-serif'],
            }
          }
        }
      }
    </script>
    <?php
}
add_action( 'wp_head', 'shopping_add_tailwind_cdn', 5 );

/**
 * Customizer settings cho Header & Topbar
 */
function shopping_customize_register( $wp_customize ) {
    // Thêm Panel Cấu hình Header
    $wp_customize->add_panel( 'shopping_header_options', array(
        'title'       => __( 'Cấu hình Header', 'shopping' ),
        'description' => __( 'Tùy chỉnh thông tin Topbar màu xanh và các khung Cam kết', 'shopping' ),
        'priority'    => 20,
    ) );

    // Box: Topbar
    $wp_customize->add_section( 'shopping_topbar_section', array(
        'title' => __( 'Topbar Liên hệ (Nền xanh)', 'shopping' ),
        'panel' => 'shopping_header_options',
    ) );

    $wp_customize->add_setting( 'topbar_email', array( 'default' => 'phanphoihoachat1@gmail.com' ) );
    $wp_customize->add_control( 'topbar_email', array(
        'label' => 'Email Liên Hệ', 'section' => 'shopping_topbar_section', 'type' => 'text',
    ) );

    $wp_customize->add_setting( 'topbar_phone', array( 'default' => '0947 464 464' ) );
    $wp_customize->add_control( 'topbar_phone', array(
        'label' => 'Số Điện Thoại (Hotline)', 'section' => 'shopping_topbar_section', 'type' => 'text',
    ) );

    // Box: Cam kết (Benefits)
    $wp_customize->add_section( 'shopping_benefits_section', array(
        'title' => __( 'Các Cam Kết (Mặt tiền)', 'shopping' ),
        'panel' => 'shopping_header_options',
    ) );

    $default_benefits = array(
        1 => array('GIAO HÀNG NHANH', '60p Nội thành & Ngoại thành 24h'),
        2 => array('SP CHẤT LƯỢNG CAO', 'Chất lượng ưu tiên số 1'),
        3 => array('ƯU TIÊN MUA HÀNG ONLINE', 'Nhận hàng theo yêu cầu')
    );

    for ($i = 1; $i <= 3; $i++) {
        $wp_customize->add_setting( 'benefit_'.$i.'_title', array( 'default' => $default_benefits[$i][0] ) );
        $wp_customize->add_control( 'benefit_'.$i.'_title', array(
            'label' => 'Tiêu đề Cam Kết '.$i, 'section' => 'shopping_benefits_section', 'type' => 'text',
        ) );

        $wp_customize->add_setting( 'benefit_'.$i.'_sub', array( 'default' => $default_benefits[$i][1] ) );
        $wp_customize->add_control( 'benefit_'.$i.'_sub', array(
            'label' => 'Phụ đề Cam Kết '.$i, 'section' => 'shopping_benefits_section', 'type' => 'text',
        ) );
    }

    // ==========================================
    // FOOTER OPTIONS
    // ==========================================
    $wp_customize->add_panel( 'shopping_footer_options', array(
        'title'       => __( 'Cấu hình Footer (Chân trang)', 'shopping' ),
        'description' => __( 'Quản lý thông tin 4 cột Chi nhánh đại diện và Các dòng thông tin bản quyền.', 'shopping' ),
        'priority'    => 21,
    ) );

    // 4 Cột Chi Nhánh
    $wp_customize->add_section( 'shopping_footer_cols', array(
        'title' => __( 'Nội dung 4 Cột Chi nhánh', 'shopping' ),
        'panel' => 'shopping_footer_options',
    ) );

    for ($i = 1; $i <= 4; $i++) {
        $wp_customize->add_setting( 'footer_col_'.$i, array( 'default' => '' ) );
        $wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'footer_col_'.$i, array(
            'label'   => 'Nội dung Cột '.$i.' (Hỗ trợ HTML)',
            'section' => 'shopping_footer_cols',
            'type'    => 'textarea',
        ) ) );
    }

    // Tùy biến Màu Sắc & Font
    $wp_customize->add_section( 'shopping_theme_colors', array(
        'title' => __( 'Màu Chủ Đạo', 'shopping' ),
        'priority' => 30,
    ) );

    $wp_customize->add_setting( 'shopping_primary_color', array(
        'default' => '#ea580c',
        'sanitize_callback' => 'sanitize_hex_color',
    ) );
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'shopping_primary_color', array(
        'label' => __( 'Màu Nhận Diện Thương Hiệu', 'shopping' ),
        'section' => 'shopping_theme_colors',
    ) ) );

    // Thông tin bản quyền / Đáy trang
    $wp_customize->add_section( 'shopping_footer_bottom', array(
        'title' => __( 'Thông tin Đáy trang', 'shopping' ),
        'panel' => 'shopping_footer_options',
    ) );

    $wp_customize->add_setting( 'footer_links', array( 'default' => 'Hướng dẫn mua online | Chính sách giao hàng | Bảo hành & đổi trả sản phẩm | Chính sách bảo mật | Cam kết chất lượng sản phẩm | Khách hàng chia sẻ' ) );
    $wp_customize->add_control( 'footer_links', array(
        'label' => 'Dải Liên Kết', 'section' => 'shopping_footer_bottom', 'type' => 'textarea',
    ) );

    $wp_customize->add_setting( 'footer_company', array( 'default' => 'CÔNG TY PHỤ GIA VIỆT MỸ' ) );
    $wp_customize->add_control( 'footer_company', array(
        'label' => 'Tên Công Ty', 'section' => 'shopping_footer_bottom', 'type' => 'text',
    ) );

    $wp_customize->add_setting( 'footer_slogan', array( 'default' => 'DẪN ĐẦU TRONG LĨNH VỰC HÓA CHẤT, THIẾT BỊ CÔNG NGHIỆP & SẢN PHẨM LIÊN QUAN' ) );

    // Cột Thông Tin & Bản Tin
    $wp_customize->add_section( 'shopping_footer_info_section', array(
        'title' => __( 'Thông Tin Thêm & Nhận Bản Tin', 'shopping' ),
        'panel' => 'shopping_footer_options',
    ) );

    $wp_customize->add_setting( 'footer_info_title', array( 'default' => 'Thông tin' ) );
    $wp_customize->add_control( 'footer_info_title', array(
        'label' => 'Tiêu đề cột thông tin', 'section' => 'shopping_footer_info_section', 'type' => 'text',
    ) );

    $wp_customize->add_setting( 'footer_info_content', array( 'default' => "<ul><li><a href='#'>Về chúng tôi</a></li><li><a href='#'>Chính sách bảo mật</a></li><li><a href='#'>Quy định sử dụng</a></li><li><a href='#'>Thông tin giao hàng</a></li></ul>" ) );
    $wp_customize->add_control( 'footer_info_content', array(
        'label' => 'Nội dung HTML cột thông tin', 'section' => 'shopping_footer_info_section', 'type' => 'textarea',
    ) );

    // Cột Chính sách (Cột mới)
    $wp_customize->add_setting( 'footer_policy_title', array( 'default' => 'CHÍNH SÁCH' ) );
    $wp_customize->add_control( 'footer_policy_title', array(
        'label' => 'Tiêu đề cột Chính sách', 'section' => 'shopping_footer_info_section', 'type' => 'text',
    ) );

    $wp_customize->add_setting( 'footer_policy_content', array( 'default' => "<ul><li><a href='#'>Chính sách bảo mật</a></li><li><a href='#'>Quy định sử dụng</a></li><li><a href='#'>Thông tin giao hàng</a></li><li><a href='#'>Bảo hành & Đổi trả</a></li></ul>" ) );
    $wp_customize->add_control( 'footer_policy_content', array(
        'label' => 'Nội dung HTML cột Chính sách', 'section' => 'shopping_footer_info_section', 'type' => 'textarea',
    ) );

    $wp_customize->add_setting( 'footer_newsletter_title', array( 'default' => 'NHẬN BẢN TIN' ) );
    $wp_customize->add_control( 'footer_newsletter_title', array(
        'label' => 'Tiêu đề Nhận Bản Tin', 'section' => 'shopping_footer_info_section', 'type' => 'text',
    ) );

    $wp_customize->add_setting( 'footer_newsletter_desc', array( 'default' => 'Đăng ký email để nhanh chóng nhận được các thông báo về khuyến mại, chương trình giảm giá của chúng tôi' ) );
    $wp_customize->add_control( 'footer_newsletter_desc', array(
        'label' => 'Mô tả Nhận Bản Tin', 'section' => 'shopping_footer_info_section', 'type' => 'textarea',
    ) );
}

// Dịch thuật các nút bấm của LearnPress sang tiếng Việt
add_filter( 'gettext', 'shopping_translate_learnpress', 20, 3 );
function shopping_translate_learnpress( $translated_text, $text, $domain ) {
    if ( 'learnpress' === $domain || 'shopping' === $domain ) {
        switch ( $text ) {
            case 'Start Now':
                $translated_text = 'Bắt đầu ngay';
                break;
            case 'Continue':
                $translated_text = 'Tiếp tục';
                break;
            case 'Enroll':
            case 'Enroll Now':
                $translated_text = 'Tham gia khóa học';
                break;
        }
    }
    return $translated_text;
}

// --------- ĐÈ BẸP CSS LIST VIEW CỦA LEARNPRESS ĐỂ LUÔN ĐẸP VÀ RỘNG ---------
add_action( 'wp_head', 'shopping_dynamic_course_layout' );
function shopping_dynamic_course_layout() {
    if ( is_post_type_archive( 'lp_course' ) || is_tax( 'course_category' ) || is_tax( 'course_tag' ) ) {
        ?>
        <style>
            /* Ép buộc tất cả ul dù có class lp-list-view hay không đều thành Grid */
            ul.learn-press-courses {
                display: grid !important;
                grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)) !important;
                gap: 2rem !important;
                width: 100% !important;
            }
            ul.learn-press-courses li.course {
                width: 100% !important;
                display: flex !important;
                flex-direction: column !important;
                margin-bottom: 0 !important;
            }
            /* Ẩn nút chuyển đổi Grid/List vì Grid đã hoàn hảo */
            .lp-courses-bar .courses-switch-view { display: none !important; }
            
            /* Mở rộng toàn bộ trang Courses cho rộng rãi */
            .lp-archive-courses { width: 100% !important; max-width: 1200px !important; margin: 0 auto !important; }
            #lp-archive-courses { max-width: 100% !important; }
        </style>
        <?php
    }
}

// Dịch Thuật Tab Đánh Giá (Reviews) sang Tiếng Việt bằng Hook gettext
add_filter( 'gettext', 'shopping_translate_reviews', 20, 3 );
function shopping_translate_reviews( $translated_text, $text, $domain ) {
    if ( 'woocommerce' === $domain ) {
        switch ( $text ) {
            case 'Reviews':
                $translated_text = 'Đánh Giá';
                break;
            case 'There are no reviews yet.':
                $translated_text = 'Chưa có đánh giá nào. Hãy là người đầu tiên!';
                break;
            case 'Be the first to review &ldquo;%s&rdquo;':
                $translated_text = 'Hãy là người đầu tiên đánh giá &ldquo;%s&rdquo;';
                break;
            case 'Submit':
                $translated_text = 'Gửi đánh giá';
                break;
            case 'Your rating':
                $translated_text = 'Chất lượng';
                break;
            case 'Your review':
            case 'Your review *':
                $translated_text = 'Nhận xét của bạn';
                break;
            case 'Name':
            case 'Name *':
                $translated_text = 'Họ và tên';
                break;
            case 'Email':
            case 'Email *':
                $translated_text = 'Địa chỉ Email';
                break;
            case 'Save my name, email, and website in this browser for the next time I comment.':
                $translated_text = 'Lưu thông tin của tôi cho lần bình luận sau.';
                break;
            // Dịch thuật bộ lọc Cửa hàng (Shop Sorting)
            case 'Showing the single result':
                $translated_text = 'Hiển thị 1 kết quả';
                break;
            case 'Showing all %d results':
                $translated_text = 'Hiển thị tất cả %d kết quả';
                break;
            case 'Showing %1$d&ndash;%2$d of %3$d results':
                $translated_text = 'Hiển thị %1$d&ndash;%2$d trong %3$d kết quả';
                break;
            case 'Default sorting':
                $translated_text = 'Sắp xếp mặc định';
                break;
            case 'Sort by popularity':
                $translated_text = 'Sắp xếp theo độ phổ biến';
                break;
            case 'Sort by average rating':
                $translated_text = 'Xếp theo điểm đánh giá';
                break;
            case 'Sort by latest':
                $translated_text = 'Sắp xếp theo mới nhất';
                break;
            case 'Sort by price: low to high':
                $translated_text = 'Xếp theo giá: thấp đến cao';
                break;
            case 'Sort by price: high to low':
                $translated_text = 'Xếp theo giá: cao đến thấp';
                break;
        }
    }
    return $translated_text;
}

// 8. Tính năng "Gấp Gọn / Xem Thêm" cho phần Mô tả sản phẩm
add_action( 'wp_footer', 'shopping_collapsible_description' );
function shopping_collapsible_description() {
    if ( is_product() ) {
        ?>
        <style>
            #tab-description, .woocommerce-Tabs-panel--description {
                position: relative;
                overflow: hidden;
            }
            #tab-description.collapsed, .woocommerce-Tabs-panel--description.collapsed {
                max-height: 400px; /* Chiều cao tối đa khi thu gọn */
            }
            /* Hiệu ứng bóng mờ (gradient) khi thu gọn */
            #tab-description.collapsed::after, .woocommerce-Tabs-panel--description.collapsed::after {
                content: '';
                position: absolute;
                bottom: 0; left: 0;
                width: 100%; height: 120px;
                background: linear-gradient(to bottom, rgba(255,255,255,0), rgba(255,255,255,1));
            }
            .collapse-toggle-btn {
                display: block;
                width: max-content;
                margin: 20px auto;
                padding: 10px 24px;
                background-color: #ea580c; /* Màu Primary */
                color: white;
                border-radius: 8px;
                font-weight: 600;
                font-size: 14px;
                cursor: pointer;
                transition: background-color 0.3s ease;
                border: none;
                box-shadow: 0 4px 6px -1px rgba(234, 88, 12, 0.2);
            }
            .collapse-toggle-btn:hover {
                background-color: #c2410c; /* Hover primary */
            }
        </style>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                var descTabs = document.querySelectorAll('#tab-description, .woocommerce-Tabs-panel--description');
                descTabs.forEach(function(descTab) {
                    // Nếu nội dung dài hơn 450px mới kích hoạt gấp gọn
                    if (descTab && descTab.scrollHeight > 450) {
                        descTab.classList.add('collapsed');
                        
                        var toggleBtn = document.createElement('button');
                        toggleBtn.className = 'collapse-toggle-btn';
                        toggleBtn.innerHTML = 'Xem Thêm Nội Dung ▾';
                        
                        // Chèn nút nhấn bên dưới description div
                        descTab.parentNode.insertBefore(toggleBtn, descTab.nextSibling);
                        
                        toggleBtn.addEventListener('click', function(e) {
                            e.preventDefault();
                            if (descTab.classList.contains('collapsed')) {
                                descTab.classList.remove('collapsed');
                                toggleBtn.innerHTML = 'Thu Gọn Nội Dung ▴';
                                toggleBtn.style.backgroundColor = '#4b5563'; // Đổi màu nút khi thu gọn
                            } else {
                                descTab.classList.add('collapsed');
                                toggleBtn.innerHTML = 'Xem Thêm Nội Dung ▾';
                                toggleBtn.style.backgroundColor = '#ea580c';
                                
                                // Cuộn mượt mà lên đầu tab mô tả
                                var tabOffset = descTab.getBoundingClientRect().top + window.pageYOffset - 120;
                                window.scrollTo({ top: tabOffset, behavior: 'smooth' });
                            }
                        });
                    }
                });
            });
        </script>
        <?php
    }
}

// 9. Chia lại layout Grid cho phần đếm số lượng và sắp xếp sản phẩm ở trang Shop (Shop Header)
add_action( 'woocommerce_before_shop_loop', 'shopping_wrapper_before_shop_loop_start', 15 );
function shopping_wrapper_before_shop_loop_start() {
    // Priority 15 ensures it fires after notices (10) but before result_count (20) and catalog_ordering (30).
    echo '<div class="shop-controls-wrapper flex flex-col md:flex-row justify-between items-center bg-white p-4 rounded-xl shadow-sm mb-8 border border-gray-100 gap-4">';
}
add_action( 'woocommerce_before_shop_loop', 'shopping_wrapper_before_shop_loop_end', 35 );
function shopping_wrapper_before_shop_loop_end() {
    // Priority 35 ensures it fires after result_count (20) and catalog_ordering (30).
    echo '</div>';
}
add_action( 'customize_register', 'shopping_customize_register' );

/**
 * ==========================================
 * CHỨC NĂNG LIÊN HỆ KHI GIÁ = 0 HOẶC TRỐNG
 * ==========================================
 */

// 1. Mở lại cơ chế mua hàng để có thể thêm vào danh sách tư vấn (Kể cả giá 0đ)
add_filter( 'woocommerce_is_purchasable', '__return_true' );

// 2. Chuyển đổi hiển thị giá 0đ thành chữ "Liên hệ" ở mọi trang
add_filter( 'woocommerce_get_price_html', 'shopping_zero_price_html', 100, 2 );
function shopping_zero_price_html( $price, $product ) {
    if ( empty( $product->get_price() ) || $product->get_price() == 0 ) {
        return '<span class="price-contact font-bold text-red-600">' . esc_html__( 'Liên hệ', 'shopping' ) . '</span>';
    }
    return $price;
}

// 3. Thay đổi nút Add to Cart ngoài vòng lặp thành Icon Danh Sách Tư Vấn
add_filter( 'woocommerce_loop_add_to_cart_link', 'shopping_add_to_list_icon_button', 10, 3 );
function shopping_add_to_list_icon_button( $button, $product, $args = array() ) {
    $icon = '<svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>';
    
    $classes = isset( $args['class'] ) ? $args['class'] : 'button';
    // Thêm class bắt buộc để AJAX WooCommerce lấy dữ liệu Add To Cart không load lại trang
    if ( $product->is_purchasable() && $product->supports( 'ajax_add_to_cart' ) ) {
        $classes .= ' add_to_cart_button ajax_add_to_cart product_type_' . $product->get_type();
    }
    
    // Nút thiết kế dạng Icon vuông tròn thả trôi
    $custom_class = 'flex items-center justify-center w-10 h-10 rounded-full bg-orange-50 text-primary hover:bg-primary hover:text-white transition-colors custom-add-list-btn mx-auto mt-auto';

    $button = sprintf(
        '<a href="%s" data-quantity="%s" class="%s %s" %s data-product_id="%s" title="%s">%s</a>',
        esc_url( $product->add_to_cart_url() ),
        esc_attr( isset( $args['quantity'] ) ? $args['quantity'] : 1 ),
        esc_attr( $classes ),
        esc_attr( $custom_class ),
        isset( $args['attributes'] ) ? wc_implode_html_attributes( $args['attributes'] ) : '',
        esc_attr( $product->get_id() ),
        esc_attr__( 'Thêm vào danh sách', 'shopping' ),
        $icon
    );

    return $button;
}

// 4. Bổ sung nút Liên Hệ to rõ ở trang chi tiết sản phẩm (Single Product)
add_action( 'woocommerce_single_product_summary', 'shopping_zero_price_single_contact', 31 );
function shopping_zero_price_single_contact() {
    global $product;
    if ( empty( $product->get_price() ) || $product->get_price() == 0 ) {
        $phone = get_theme_mod( 'topbar_phone', '0947 464 464' );
        $tel = str_replace( array(' ', '.', '-'), '', $phone );
        
        echo sprintf(
            '<div class="mt-4"><a href="tel:%s" class="btn block w-full text-center py-3.5 rounded-lg font-bold transition-all duration-300 text-white bg-primary hover:bg-primary-hover shadow-md text-lg uppercase">%s</a></div>',
            esc_attr( $tel ),
            esc_html__( 'Liên hệ mua hàng', 'shopping' )
        );
    }
}

// =========================================================
// MỤC LỤC TỰ ĐỘNG CHO BÀI VIẾT (TABLE OF CONTENTS)
// =========================================================
add_filter( 'the_content', 'shopping_auto_toc' );
function shopping_auto_toc( $content ) {
    // Chỉ áp dụng cho trang chi tiết bài viết (Single Post), nằm trong vòng lặp chính
    if ( ! is_singular( 'post' ) || ! in_the_loop() || ! is_main_query() ) {
        return $content;
    }

    // Đếm số heading H2 và H3 (hỗ trợ tiếng Việt và các định dạng)
    preg_match_all('/<h([2-3])([^>]*)>(.*?)<\/h\1>/si', $content, $matches, PREG_SET_ORDER);
    if ( count( $matches ) < 2 ) {
        // Phải có ít nhất 2 heading mới tạo mục lục
        return $content;
    }

    // Cấu trúc box Mục Lục (nổi bật, bo góc đẹp, style Tailwind)
    $toc = '<div class="shopping-toc bg-[#f8fafc] border border-gray-200 rounded-xl p-5 mb-10 mt-4 shadow-[0_2px_10px_rgb(0,0,0,0.03)] w-full block box-border">';
    $toc .= '<div class="toc-header flex justify-between items-center cursor-pointer select-none" onclick="document.getElementById(\'shopping-toc-list\').classList.toggle(\'hidden\'); document.getElementById(\'toc-icon\').classList.toggle(\'rotate-180\');">';
    $toc .= '<h3 class="text-[17px] font-heading font-bold text-dark m-0 flex items-center gap-2 uppercase tracking-wide">';
    $toc .= '<svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7"></path></svg>';
    $toc .= 'Mục Lục Bài Viết';
    $toc .= '</h3>';
    $toc .= '<svg id="toc-icon" class="w-5 h-5 text-gray-500 transition-transform duration-300 transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"></path></svg>';
    $toc .= '</div>';
    
    // Danh sách các mục
    $toc .= '<ul id="shopping-toc-list" class="space-y-3 text-[15px] list-none pl-0 m-0 mt-5 transition-all duration-300 ease-in-out">';
    
    $counter2 = 0;
    $counter3 = 0;
    
    // Sử dụng biến cục bộ để pass vào closure
    $GLOBALS['shopping_toc_index'] = 0;
    $GLOBALS['shopping_toc_items'] = array();

    // Callback thay thế heading cũ bằng heading mới gắn ID
    $content = preg_replace_callback( '/<h([2-3])([^>]*)>(.*?)<\/h\1>/svi', function( $match ) use ( &$counter2, &$counter3 ) {
        $level = $match[1];
        $attributes = $match[2];
        $text = strip_tags($match[3]);
        $text_clean = html_entity_decode( $text, ENT_QUOTES, 'UTF-8' );
        
        // Tạo ID slug cho heading
        $slug = sanitize_title( $text_clean );
        if ( empty($slug) ) {
            $slug = 'section-' . $GLOBALS['shopping_toc_index'];
        }
        // Thêm index để đảm bảo slug là duy nhất
        $slug .= '-' . $GLOBALS['shopping_toc_index'];

        if ( $level == '2' ) {
            $counter2++;
            $counter3 = 0;
            $num = $counter2;
        } else {
            $counter3++;
            $num = $counter2 . '.' . $counter3;
        }

        $GLOBALS['shopping_toc_items'][] = array(
            'level' => $level,
            'title' => trim( $match[3] ), // Giữ lại cả định dạng HTML nhẹ trong title (như b, i)
            'slug'  => $slug,
            'num'   => $num
        );

        $GLOBALS['shopping_toc_index']++;

        // Trả về heading mới (thêm scroll-mt-24 để bù trừ fixed header nếu có)
        return sprintf( '<h%1$s%2$s id="%3$s" style="scroll-margin-top: 100px;">%4$s</h%1$s>', $level, $attributes, $slug, $match[3] );
    }, $content );

    // Render HTML cho từng mục
    foreach ( $GLOBALS['shopping_toc_items'] as $item ) {
        $is_h3 = ($item['level'] == '3');
        $padding = $is_h3 ? 'pl-6 text-[14px] text-gray-600' : 'font-semibold text-gray-800';
        $border_top = ( !$is_h3 && $item['num'] !== 1 ) ? 'pt-3 mt-3 border-t border-gray-200/60' : '';
        
        $toc .= '<li class="' . $padding . ' ' . $border_top . ' leading-snug">';
        $toc .= '<a href="#' . $item['slug'] . '" class="flex items-start gap-2.5 no-underline hover:text-primary transition-colors group">';
        $toc .= '<span class="text-primary/90 shrink-0 font-bold group-hover:text-primary">' . $item['num'] . '.</span>';
        $toc .= '<span class="flex-1">' . strip_tags($item['title']) . '</span>';
        $toc .= '</a>';
        $toc .= '</li>';
    }

    $toc .= '</ul>';
    
    // Styles mượt mà CSS
    $toc .= '<style>html { scroll-behavior: smooth; }</style>';
    
    $toc .= '</div>';

    // Xóa biến global tránh xung đột
    unset( $GLOBALS['shopping_toc_index'], $GLOBALS['shopping_toc_items'] );

    // Thêm mục lục vào ngay đầu bài viết
    return $toc . $content;
}

// =========================================================
// FLOATING ACTION BUTTONS & STICKY MOBILE BAR
// =========================================================

// Thêm cấu hình Zalo, Messenger vào Customizer
add_action( 'customize_register', 'shopping_floating_contact_customize' );
function shopping_floating_contact_customize( $wp_customize ) {
    $wp_customize->add_section( 'shopping_floating_contact_section', array(
        'title' => __( 'Nút Liên Hệ (Zalo/Messenger)', 'shopping' ),
        'priority' => 35,
    ) );

    $wp_customize->add_setting( 'contact_zalo', array( 'default' => 'https://zalo.me/0799036842' ) );
    $wp_customize->add_control( 'contact_zalo', array(
        'label' => 'Link Zalo (VD: https://zalo.me/0799036842)',
        'section' => 'shopping_floating_contact_section',
        'type' => 'text',
    ) );

    $wp_customize->add_setting( 'contact_messenger', array( 'default' => 'https://m.me/yourfanpage' ) );
    $wp_customize->add_control( 'contact_messenger', array(
        'label' => 'Link Messenger (VD: https://m.me/abc)',
        'section' => 'shopping_floating_contact_section',
        'type' => 'text',
    ) );

    // Khối Đặc quyền (Lợi ích) Trang Chủ
    $wp_customize->add_section( 'shopping_home_benefits_section', array(
        'title' => __( 'Trang Chủ - 3 Lợi ích', 'shopping' ),
        'priority' => 36,
    ) );

    for ($i = 1; $i <= 3; $i++) {
        $defaults = [
            1 => ['Chất Lượng Cao Cấp', 'Từng sản phẩm đều được kiểm định khắt khe và đạt chuẩn.'],
            2 => ['Thanh Toán An Toàn', 'Hệ thống bảo mật thông tin tuyệt đối qua mã hóa.'],
            3 => ['Giao Hàng Nhanh', 'Xử lý đơn linh hoạt, giao hàng siêu tốc toàn quốc.']
        ];
        
        $wp_customize->add_setting( 'home_benefit_' . $i . '_title', array( 'default' => $defaults[$i][0] ) );
        $wp_customize->add_control( 'home_benefit_' . $i . '_title', array(
            'label' => 'Lợi ích ' . $i . ' - Tiêu đề',
            'section' => 'shopping_home_benefits_section',
            'type' => 'text',
        ) );

        $wp_customize->add_setting( 'home_benefit_' . $i . '_desc', array( 'default' => $defaults[$i][1] ) );
        $wp_customize->add_control( 'home_benefit_' . $i . '_desc', array(
            'label' => 'Lợi ích ' . $i . ' - Mô tả',
            'section' => 'shopping_home_benefits_section',
            'type' => 'textarea',
        ) );
    }
}

// In mã HTML vào Footer
add_action( 'wp_footer', 'shopping_floating_action_buttons', 99 );
function shopping_floating_action_buttons() {
    $phone = get_theme_mod( 'topbar_phone', '0947 464 464' );
    $tel = str_replace( array(' ', '.', '-'), '', $phone );
    $zalo = get_theme_mod( 'contact_zalo', 'https://zalo.me/0947464464' );
    $messenger = get_theme_mod( 'contact_messenger', 'https://m.me/yourfanpage' );
    
    ?>
    <style>
        /* Floating Buttons CSS */
        .fab-container { position: fixed; bottom: 24px; right: 24px; z-index: 9999; display: flex; flex-direction: column; gap: 14px; align-items: flex-end; }
        .fab-btn { display: flex; align-items: center; justify-content: center; width: 44px; height: 44px; border-radius: 50%; box-shadow: 0 4px 15px rgba(0,0,0,0.15); transition: all 0.3s; position: relative; text-decoration: none; }
        .fab-btn:hover { transform: translateY(-4px); }
        .fab-zalo { background-color: #0068ff; }
        .fab-mess { background-color: #0084ff; }
        .fab-phone { background-color: #ef4444; background: linear-gradient(135deg, #ef4444, #dc2626); animation: pulse-ring 2s infinite; }
        .fab-btn svg { width: 24px; height: 24px; fill: white; object-fit: contain; }
        
        @keyframes pulse-ring {
            0% { box-shadow: 0 0 0 0 rgba(239, 68, 68, 0.6); }
            70% { box-shadow: 0 0 0 15px rgba(239, 68, 68, 0); }
            100% { box-shadow: 0 0 0 0 rgba(239, 68, 68, 0); }
        }

        /* Sticky Mobile Bar */
        .sticky-mobile-bar {
            display: none; position: fixed; bottom: 0; left: 0; width: 100%; background: #fff; z-index: 9998;
            box-shadow: 0 -4px 12px rgba(0,0,0,0.08); padding: 10px 12px;
            padding-bottom: calc(10px + env(safe-area-inset-bottom));
        }
        @media (max-width: 767px) {
            .sticky-mobile-bar.active { display: flex; gap: 10px; }
            .fab-container { bottom: 85px; right: 16px; transform: scale(0.9); transform-origin: bottom right; } /* Lift up so it doesnt overlap sticky bar */
        }
    </style>

    <!-- Floating Buttons (Zalo, Messenger, Call) -->
    <div class="fab-container">
        <?php if ($messenger) : ?>
        <a href="<?php echo esc_url($messenger); ?>" target="_blank" rel="noopener" class="fab-btn fab-mess" title="Messenger">
            <svg viewBox="0 0 36 36"><path d="M18 2C9.16 2 2 8.7 2 17c0 4.67 2.3 8.85 5.8 11.66V34l5.31-2.92c1.55.43 3.18.66 4.89.66 8.84 0 16-6.7 16-15S26.84 2 18 2zm1.63 20.12l-4.13-4.4-8.06 4.4 8.82-9.39 4.14 4.4 8.05-4.4-8.82 9.39z"/></svg>
        </a>
        <?php endif; ?>
        
        <?php if ($zalo) : ?>
        <a href="<?php echo esc_url($zalo); ?>" target="_blank" rel="noopener" class="fab-btn fab-zalo" title="Zalo" style="color: white; font-family: sans-serif; font-weight: bold; font-size: 14px;">
            Zalo
        </a>
        <?php endif; ?>

        <a href="tel:<?php echo esc_attr($tel); ?>" class="fab-btn fab-phone" title="Gọi Ngay" style="color: white;">
            <svg viewBox="0 0 24 24"><path d="M20.01 15.38c-1.23 0-2.42-.2-3.53-.56M16.48 14.82c-.38-.13-.81-.05-1.07.2l-2.2 2.2c-2.83-1.44-5.15-3.75-6.59-6.59l2.2-2.21c.28-.26.36-.65.25-1.03M7.22 8.52C6.86 7.41 6.66 6.22 6.66 4.99M6.66 4.99h-3.4M20.01 15.38v3.4" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
        </a>
    </div>

    <!-- Sticky Bottom Bar for Mobile (Products Only) -->
    <?php if ( function_exists('is_product') && is_product() ) : ?>
    <div class="sticky-mobile-bar active">
        <a href="tel:<?php echo esc_attr($tel); ?>" class="flex-1 bg-[#f3f4f6] text-gray-800 text-center py-2.5 rounded-lg border border-gray-200 font-bold flex items-center justify-center gap-2 hover:bg-gray-200 transition-colors">
            <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
            Gọi Ngay
        </a>
        <a href="<?php echo esc_url($zalo ? $zalo : ($messenger ? $messenger : 'tel:'.$tel)); ?>" target="_blank" rel="noopener" class="flex-1 bg-[#ea580c] text-white text-center py-2.5 rounded-lg font-bold flex items-center justify-center gap-2 shadow-sm hover:opacity-90 transition-opacity">
            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
            Chat Tư Vấn
        </a>
    </div>
    <?php endif; ?>
    <?php
}

// =========================================================
// CUSTOM POST TYPE: ĐỐI TÁC & KHÁCH HÀNG
// =========================================================
add_action( 'init', 'shopping_register_partner_cpt' );
function shopping_register_partner_cpt() {
    // 1. Đăng ký Taxonomy (Danh mục)
    register_taxonomy(
        'partner_group',
        'shopping_partner',
        array(
            'label' => __( 'Nhóm (Đối tác/Khách hàng)', 'shopping' ),
            'rewrite' => array( 'slug' => 'partner_group' ),
            'hierarchical' => true,
            'show_admin_column' => true,
        )
    );

    // 2. Đăng ký Custom Post Type
    register_post_type( 'shopping_partner',
        array(
            'labels' => array(
                'name' => __( 'KH & Đối Tác', 'shopping' ),
                'singular_name' => __( 'Khách hàng / Đối tác', 'shopping' ),
                'add_new' => __( 'Thêm mới', 'shopping' ),
                'add_new_item' => __( 'Thêm mới', 'shopping' ),
                'edit_item' => __( 'Sửa', 'shopping' ),
            ),
            'public' => true,
            'publicly_queryable' => false, // Chỉ hiển thị query, ko cần trang chi tiết
            'show_ui' => true,
            'has_archive' => false,
            'menu_icon' => 'dashicons-groups',
            'supports' => array( 'title', 'editor', 'thumbnail', 'excerpt' ),
            'taxonomies' => array( 'partner_group' )
        )
    );
}

// Gợi ý cho Meta Box (Trích dẫn dùng làm Chức vụ)
add_action('admin_head', 'shopping_partner_custom_css');
function shopping_partner_custom_css() {
    global $post_type;
    if ($post_type == 'shopping_partner') {
        echo '<style>
            #postexcerpt .hndle span { content: "Chức vụ / Công ty (Dành cho Ý kiến Khách hàng)"; font-size:0; }
            #postexcerpt .hndle span:after { content: "Chức vụ / Công ty (Nhập chức vụ vào phần Tóm tắt này)"; font-size:14px; }
            #postimagediv .hndle span:after { content: " (Dùng Logo cho Đối tác, Avatar cho Khách hàng)"; font-size:12px; font-weight:normal; }
        </style>';
    }
}

// =========================================================
// AJAX LIVE SEARCH (ƯU TIÊN SẢN PHẨM)
// =========================================================

add_action('wp_ajax_shopping_live_search', 'shopping_ajax_live_search');
add_action('wp_ajax_nopriv_shopping_live_search', 'shopping_ajax_live_search');

function shopping_ajax_live_search() {
    // Kiểm tra keyword
    $keyword = isset($_REQUEST['keyword']) ? sanitize_text_field($_REQUEST['keyword']) : '';
    if ( strlen($keyword) < 2 ) {
        wp_send_json_success(array('html' => ''));
    }

    $args = array(
        's'              => $keyword,
        'post_type'      => class_exists('WooCommerce') ? 'product' : 'post',
        'post_status'    => 'publish',
        'posts_per_page' => 5,
    );

    $search_query = new WP_Query($args);
    $html = '';

    if ( $search_query->have_posts() ) {
        while ( $search_query->have_posts() ) {
            $search_query->the_post();
            global $product;
            
            $price_html = '';
            if ( class_exists('WooCommerce') && $product ) {
                $price = $product->get_price();
                if ( empty($price) || $price == 0 ) {
                    $price_html = '<span class="text-red-500 font-bold text-[12px]">Liên hệ</span>';
                } else {
                    $price_html = '<span class="text-primary font-bold text-[13px]">' . $product->get_price_html() . '</span>';
                }
            }
            
            $thumb = has_post_thumbnail() ? get_the_post_thumbnail_url(get_the_ID(), 'thumbnail') : (function_exists('wc_placeholder_img_src') ? wc_placeholder_img_src() : '');
            if (!$thumb) $thumb = 'https://ui-avatars.com/api/?name=' . urlencode(get_the_title()) . '&background=f3f4f6&color=9ca3af';

            $html .= '<li class="border-b border-gray-50 last:border-0">';
            $html .= '<a href="' . esc_url(get_permalink()) . '" class="flex items-center gap-3 p-3 hover:bg-orange-50 transition-colors group">';
            $html .= '<img src="' . esc_url($thumb) . '" class="w-10 h-10 object-cover rounded shadow-[0_2px_8px_rgb(0,0,0,0.05)] shrink-0 border border-gray-100" alt="">';
            $html .= '<div class="flex-1 min-w-0 flex flex-col justify-center">';
            $html .= '<h4 class="text-[13px] font-bold text-dark group-hover:text-primary truncate mb-0.5 leading-tight">' . get_the_title() . '</h4>';
            $html .= '<div class="[&>del]:text-[10px] [&>del]:text-gray-400 [&>del]:font-normal [&>ins]:no-underline">' . $price_html . '</div>';
            $html .= '</div>';
            $html .= '</a></li>';
        }
    } else {
        $html .= '<li class="p-5 text-center text-[13px] text-gray-500 font-semibold">' . esc_html__('Không tìm thấy kết quả nào trùng khớp!', 'shopping') . '</li>';
    }

    wp_reset_postdata();

    wp_send_json_success(array('html' => $html));
}

// Nhúng file JS xử lý Live Search
add_action( 'wp_footer', 'shopping_live_search_script', 100 );
function shopping_live_search_script() {
    ?>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('live-search-input');
        const resultsContainer = document.getElementById('live-search-results');
        const resultsList = resultsContainer ? resultsContainer.querySelector('.results-list') : null;
        const loader = resultsContainer ? resultsContainer.querySelector('.loading-indicator') : null;
        const viewAllBtn = document.getElementById('view-all-results');
        let searchTimeout;

        if (!searchInput || !resultsContainer) return;

        // Xử lý khi gõ phím
        searchInput.addEventListener('input', function(e) {
            const keyword = this.value.trim();
            
            clearTimeout(searchTimeout);

            if (keyword.length < 2) {
                // Ẩn kết quả nếu chưa đủ chữ
                resultsContainer.classList.add('hidden', 'opacity-0', 'scale-y-95');
                resultsContainer.classList.remove('flex');
                return;
            }

            // Hiển thị dropdown và loading
            resultsContainer.classList.remove('hidden', 'opacity-0', 'scale-y-95');
            resultsContainer.classList.add('flex', 'opacity-100', 'scale-y-100');
            resultsList.innerHTML = '';
            loader.classList.remove('hidden');
            viewAllBtn.classList.add('hidden');

            searchTimeout = setTimeout(function() {
                const url = '<?php echo admin_url('admin-ajax.php'); ?>?action=shopping_live_search&keyword=' + encodeURIComponent(keyword);
                
                fetch(url)
                    .then(response => response.json())
                    .then(data => {
                        loader.classList.add('hidden');
                        if (data.success && data.data.html !== '') {
                            resultsList.innerHTML = data.data.html;
                            if (resultsList.innerHTML.indexOf('Không tìm thấy') === -1) {
                                viewAllBtn.classList.remove('hidden');
                                viewAllBtn.href = '<?php echo home_url('/'); ?>?s=' + encodeURIComponent(keyword) + '<?php echo class_exists('WooCommerce') ? '&post_type=product' : ''; ?>';
                            }
                        }
                    })
                    .catch(error => {
                        console.error('Lỗi tìm kiếm:', error);
                        loader.classList.add('hidden');
                    });
            }, 500); // Đợi 500ms sau khi ngừng gõ
        });

        // Ẩn khi click ra ngoài
        document.addEventListener('click', function(e) {
            if (!e.target.closest('.live-search-container')) {
                resultsContainer.classList.add('hidden', 'opacity-0', 'scale-y-95');
                resultsContainer.classList.remove('flex');
            }
        });
        
        // Hiện lại list khi focus
        searchInput.addEventListener('focus', function() {
            if (this.value.trim().length >= 2 && resultsList.innerHTML.trim() !== '') {
                resultsContainer.classList.remove('hidden', 'opacity-0', 'scale-y-95');
                resultsContainer.classList.add('flex', 'opacity-100', 'scale-y-100');
            }
        });
    });
        });
    });
    </script>
    <?php
}

// =========================================================
// WOOCOMMERCE: CUSTOM LOGIC
// =========================================================
if ( class_exists('WooCommerce') ) {
    require_once get_template_directory() . '/inc/woocommerce-custom.php';
}

/**
 * Customizer settings cho Banners (Trang chủ)
 */
function shopping_hero_customize_register( $wp_customize ) {
    $wp_customize->add_section( 'shopping_hero_section', array(
        'title' => __( 'Cấu hình Banner Trang Chủ', 'shopping' ),
        'priority' => 30,
    ) );

    // Slide 1
    $wp_customize->add_setting( 'hero_img_1', array( 'default' => 'https://images.unsplash.com/photo-1441984904996-e0b6ba687e04?auto=format&fit=crop&w=1920&q=80' ) );
    $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'hero_img_1', array(
        'label' => 'Hình ảnh Banner 1', 'section' => 'shopping_hero_section', 'settings' => 'hero_img_1',
    ) ) );

    $wp_customize->add_setting( 'hero_title_1', array( 'default' => 'Trải Nghiệm Dịch Vụ Hoàn Hảo' ) );
    $wp_customize->add_control( 'hero_title_1', array(
        'label' => 'Tiêu đề Banner 1', 'section' => 'shopping_hero_section', 'type' => 'text',
    ) );

    $wp_customize->add_setting( 'hero_desc_1', array( 'default' => 'Khám phá bộ sưu tập cao cấp với chất lượng tuyệt hảo, mang đến giá trị đích thực cho cuộc sống.' ) );
    $wp_customize->add_control( 'hero_desc_1', array(
        'label' => 'Mô tả Banner 1', 'section' => 'shopping_hero_section', 'type' => 'textarea',
    ) );

    $wp_customize->add_setting( 'hero_btn_text_1', array( 'default' => 'Yêu Cầu Tư Vấn' ) );
    $wp_customize->add_control( 'hero_btn_text_1', array(
        'label' => 'Chữ nút bấm 1', 'section' => 'shopping_hero_section', 'type' => 'text',
    ) );

    $wp_customize->add_setting( 'hero_btn_link_1', array( 'default' => '#' ) );
    $wp_customize->add_control( 'hero_btn_link_1', array(
        'label' => 'Link nút bấm 1', 'section' => 'shopping_hero_section', 'type' => 'url',
    ) );

    // Slide 2
    $wp_customize->add_setting( 'hero_img_2', array( 'default' => 'https://images.unsplash.com/photo-1464226184884-fa280b87c399?auto=format&fit=crop&w=1920&q=80' ) );
    $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'hero_img_2', array(
        'label' => 'Hình ảnh Banner 2', 'section' => 'shopping_hero_section', 'settings' => 'hero_img_2',
    ) ) );

    $wp_customize->add_setting( 'hero_title_2', array( 'default' => 'Hương Vị Đồng Quê Đích Thực' ) );
    $wp_customize->add_control( 'hero_title_2', array(
        'label' => 'Tiêu đề Banner 2', 'section' => 'shopping_hero_section', 'type' => 'text',
    ) );

    $wp_customize->add_setting( 'hero_desc_2', array( 'default' => 'Chiết xuất hữu cơ từ thiên nhiên, đem lại hương vị đậm đà và an toàn tuyệt đối cho mọi bữa ăn gia đình.' ) );
    $wp_customize->add_control( 'hero_desc_2', array(
        'label' => 'Mô tả Banner 2', 'section' => 'shopping_hero_section', 'type' => 'textarea',
    ) );

    $wp_customize->add_setting( 'hero_btn_text_2', array( 'default' => 'Tìm hiểu chi tiết' ) );
    $wp_customize->add_control( 'hero_btn_text_2', array(
        'label' => 'Chữ nút bấm 2', 'section' => 'shopping_hero_section', 'type' => 'text',
    ) );

    $wp_customize->add_setting( 'hero_btn_link_2', array( 'default' => '#' ) );
    $wp_customize->add_control( 'hero_btn_link_2', array(
        'label' => 'Link nút bấm 2', 'section' => 'shopping_hero_section', 'type' => 'url',
    ) );
}
add_action( 'customize_register', 'shopping_hero_customize_register' );

add_action('rest_api_init', function () {
    $meta_keys = [
        'rank_math_title',
        'rank_math_description',
        'rank_math_focus_keyword',
        'rank_math_robots'
    ];
    foreach ($meta_keys as $meta_key) {
        register_meta('post', $meta_key, [
            'type'         => 'string',
            'single'       => true,
            'show_in_rest' => true,
            'auth_callback' => function() {
                return current_user_can('edit_posts');
            }
        ]);
    }
});


