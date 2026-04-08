<?php
/**
 * Shopping theme functions and definitions
 */

if ( ! defined( '_S_VERSION' ) ) {
	// Replace the version number of the theme on each release.
	define( '_S_VERSION', '1.0.0' );
}

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

// 1. Tắt khả năng mua hàng nếu giá bằng 0 (Ngăn chặn thanh toán 0 đồng) HOẶC Tắt toàn bộ giỏ hàng (Chế độ Catalog)
add_filter( 'woocommerce_is_purchasable', '__return_false' );

// 2. Chuyển đổi hiển thị giá 0đ thành chữ "Liên hệ" ở mọi trang
add_filter( 'woocommerce_get_price_html', 'shopping_zero_price_html', 100, 2 );
function shopping_zero_price_html( $price, $product ) {
    if ( empty( $product->get_price() ) || $product->get_price() == 0 ) {
        return '<span class="price-contact font-bold text-red-600">' . esc_html__( 'Liên hệ', 'shopping' ) . '</span>';
    }
    return $price;
}

// 3. Thay đổi nút Add to Cart ngoài vòng lặp (Trang danh mục/Shop) thành nút Liên hệ hoặc Xem chi tiết
add_filter( 'woocommerce_loop_add_to_cart_link', 'shopping_zero_price_contact_button', 10, 3 );
function shopping_zero_price_contact_button( $button, $product, $args = array() ) {
    if ( empty( $product->get_price() ) || $product->get_price() == 0 ) {
        $phone = get_theme_mod( 'topbar_phone', '0947 464 464' );
        $tel = str_replace( array(' ', '.', '-'), '', $phone );
        
        $button = sprintf(
            '<a href="tel:%s" class="button block w-full text-center py-2.5 rounded-lg font-semibold transition-all duration-300 text-white bg-primary hover:bg-primary-hover mt-auto">%s</a>',
            esc_attr( $tel ),
            esc_html__( 'Liên hệ ngay', 'shopping' )
        );
    } else {
        // Tạm thời bỏ giỏ hàng => biến thành nút xem chi tiết
        $button = sprintf(
            '<a href="%s" class="button block w-full text-center py-2.5 rounded-lg font-semibold transition-all duration-300 text-primary bg-secondary border border-primary/20 hover:bg-primary hover:text-white mt-auto">%s</a>',
            esc_url( $product->get_permalink() ),
            esc_html__( 'Xem chi tiết', 'shopping' )
        );
    }
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
