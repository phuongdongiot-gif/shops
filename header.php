<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">

	<?php wp_head(); ?>
    <style>
        .main-navigation ul { display: flex; flex-wrap: wrap; justify-content: center; gap: 0.75rem 1.5rem; list-style: none; margin: 0; padding: 0; }
        .main-navigation a { color: #4B5563; font-weight: 500; font-size: 0.95rem; position: relative; padding-bottom: 0.25rem; transition: color 0.2s; white-space: nowrap; }
        .main-navigation a:hover { color: #ea580c; }
        .main-navigation a::after { content: ''; position: absolute; bottom: 0; left: 0; height: 2px; width: 0; background: #ea580c; transition: width 0.3s; }
        .main-navigation a:hover::after { width: 100%; }
        
        .polylang-switcher li a { opacity: 0.7; display: block; transition: all 0.2s; }
        .polylang-switcher li a:hover, .polylang-switcher li.current-lang a { opacity: 1; transform: scale(1.1); }
        .polylang-switcher img { width: 24px; border-radius: 4px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
    </style>
</head>

<body <?php body_class('antialiased font-base text-body overflow-x-hidden relative min-h-screen flex flex-col'); ?>>
<?php wp_body_open(); ?>

<div id="page" class="site flex-1 flex flex-col">
	<a class="skip-link screen-reader-text sr-only" href="#primary"><?php esc_html_e( 'Skip to content', 'shopping' ); ?></a>

	<!-- 1. TOPBAR GREEN -->
	<div class="bg-primary text-white py-1.5 hidden md:block">
		<div class="container mx-auto px-6 flex justify-between items-center text-[13px]">
			<div class="flex items-center gap-6">
                <?php $top_email = get_theme_mod('topbar_email', 'phuongdong.3em@gmail.com'); ?>
				<a href="mailto:<?php echo esc_attr($top_email); ?>" class="flex items-center gap-1.5 hover:text-gray-200 transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                    <?php echo esc_html($top_email); ?>
                </a>
				<span class="opacity-50">|</span>
                <?php $top_phone = get_theme_mod('topbar_phone', '0799036842'); ?>
				<a href="tel:<?php echo esc_attr(str_replace(' ', '', $top_phone)); ?>" class="flex items-center gap-1.5 font-bold hover:text-gray-200 transition text-[14px]">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                    <?php 
                    // Format sdt cho dễ đọc
                    $display_phone = preg_replace('/(\d{4})(\d{3})(\d{3})/', '$1 $2 $3', $top_phone);
                    echo esc_html($display_phone); 
                    ?>
                </a>
			</div>
			<div class="flex items-center gap-3">
				<a href="#" aria-label="Facebook" class="hover:text-gray-200 transition"><svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.469h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.469h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg></a>
				<a href="#" aria-label="Twitter" class="hover:text-gray-200 transition"><svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg></a>
				<a href="mailto:<?php echo esc_attr($top_email); ?>" aria-label="Email" class="hover:text-gray-200 transition"><svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M0 3v18h24v-18h-24zm21.518 2l-9.518 7.713-9.518-7.713h19.036zm-19.518 14v-11.817l10 8.104 10-8.104v11.817h-20z"/></svg></a>
			</div>
		</div>
	</div>

	<!-- 2. MIDBAR LOGO + BENEFITS -->
	<div class="bg-white py-4 border-b border-gray-100 relative z-20">
		<div class="container mx-auto px-6 flex flex-col lg:flex-row items-center justify-between gap-6">
			<div class="site-branding flex-shrink-0">
				<?php
                if ( is_front_page() || is_home() ) {
                    echo '<h1 class="site-title font-heading text-3xl font-bold tracking-tight m-0 text-dark">';
                    if ( has_custom_logo() ) {
                        the_custom_logo();
                        echo '<span class="sr-only">' . get_bloginfo('name') . '</span>';
                    } else {
                        echo '<a href="' . esc_url( home_url( '/' ) ) . '" rel="home" class="hover:text-primary transition-colors text-dark">' . get_bloginfo( 'name' ) . '</a>';
                    }
                    echo '</h1>';
                } else {
                    echo '<div class="site-title font-heading text-3xl font-bold tracking-tight m-0 text-dark">';
                    if ( has_custom_logo() ) {
                        the_custom_logo();
                    } else {
                        echo '<a href="' . esc_url( home_url( '/' ) ) . '" rel="home" class="hover:text-primary transition-colors text-dark">' . get_bloginfo( 'name' ) . '</a>';
                    }
                    echo '</div>';
                }
				?>
			</div>

			<div class="header-benefits hidden lg:flex items-center gap-6 pl-8 flex-1 justify-end">
                <?php 
                $default_benefits = array(
                    1 => array('GIAO HÀNG NHANH', '60p Nội thành & Ngoại thành 24h', '<svg class="w-8 h-8 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>'),
                    2 => array('SP CHẤT LƯỢNG CAO', 'Chất lượng ưu tiên số 1', '<svg class="w-8 h-8 text-primary" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>'),
                    3 => array('ƯU TIÊN MUA HÀNG ONLINE', 'Nhận hàng theo yêu cầu', '<svg class="w-8 h-8 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>')
                );
                for($i=1; $i<=3; $i++) {
                    $title = get_theme_mod('benefit_'.$i.'_title', $default_benefits[$i][0]);
                    $sub = get_theme_mod('benefit_'.$i.'_sub', $default_benefits[$i][1]);
                    $icon = $default_benefits[$i][2];
                    echo '<div class="flex items-center gap-3 relative">';
                    if ($i > 1) echo '<div class="absolute -left-4 top-1/2 -translate-y-1/2 h-8 w-px bg-gray-300"></div>'; // Separator line like in image
                    echo '<div class="shrink-0">' . $icon . '</div>';
                    echo '<div>';
                    echo '<div class="text-[13px] font-bold text-dark leading-tight whitespace-nowrap uppercase">' . esc_html($title) . '</div>';
                    echo '<div class="text-[12px] text-gray-500">' . esc_html($sub) . '</div>';
                    echo '</div></div>';
                } 
                ?>
			</div>
		</div>
	</div>

	<!-- 3. BOTTOMBAR NAV -->
	<header id="masthead" class="site-header relative lg:sticky top-0 z-50 bg-white/95 backdrop-blur shadow-sm transition-all duration-300">
		<div class="container mx-auto px-4 md:px-6 min-h-[56px] flex flex-wrap items-center justify-between gap-y-3 py-3 lg:py-0">
			
            <!-- [1] MENU WRAPPER -->
            <div class="main-navigation-wrapper w-auto h-full flex items-center order-1">
				<?php get_template_part( 'template-parts/header-nav' ); ?>
			</div>

            <!-- [2] SEARCH BAR -->
            <!-- Mobile: Tụt xuống hàng 2 (order-3), w-full -->
            <!-- Desktop: Đứng giữa (order-2), canh lề phải tự động (ml-auto) -->
            <div class="live-search-container relative w-full lg:w-64 xl:w-80 order-3 lg:order-2 lg:ml-auto mt-1 lg:mt-0">
                <form role="search" method="get" class="search-form relative z-10 block" action="<?php echo esc_url( home_url( '/' ) ); ?>">
                    <?php if ( class_exists('WooCommerce') ) : ?>
                        <input type="hidden" name="post_type" value="product" />
                    <?php endif; ?>
                    <input type="search" id="live-search-input" class="search-field w-full pl-4 pr-10 py-2.5 text-[13px] text-gray-800 bg-[#f3f4f6] border border-transparent rounded-full focus:bg-white focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all shadow-inner" placeholder="<?php echo esc_attr__( 'Tìm kiếm sản phẩm...', 'shopping' ); ?>" value="<?php echo get_search_query(); ?>" name="s" autocomplete="off" />
                    <button type="submit" class="search-submit absolute right-0 top-0 h-full px-4 text-gray-500 hover:text-primary transition-colors flex items-center justify-center">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </button>
                </form>
                
                <div id="live-search-results" class="absolute top-full left-0 right-0 lg:right-0 lg:left-auto mt-2 bg-white rounded-xl shadow-[0_10px_40px_rgb(0,0,0,0.12)] border border-gray-100 overflow-hidden z-[100] hidden flex-col w-full lg:min-w-[300px] max-h-[70vh] overflow-y-auto transform origin-top transition-all scale-y-95 opacity-0">
                    <div class="p-4 text-center text-sm text-gray-500 loading-indicator hidden">
                        <svg class="animate-spin h-5 w-5 mx-auto text-primary" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                        <span class="block mt-2 font-semibold">Đang tìm kiếm...</span>
                    </div>
                    <ul class="results-list list-none m-0 p-0 text-left"></ul>
                    <a href="#" id="view-all-results" class="hidden block w-full text-center py-3 bg-gray-50 text-[13px] font-bold text-primary hover:bg-orange-50 transition-colors border-t border-gray-100 uppercase tracking-widest">
                        Xem tất cả kết quả &rarr;
                    </a>
                </div>
            </div>

            <!-- [3] RIGHT ACTIONS (Ngôn ngữ + Giỏ hàng) -->
            <!-- Mobile: Nằm cùng dòng bên phải Menu (order-2) -->
            <!-- Desktop: Nằm sát biên phải, bên cạnh Search (order-3) -->
            <div class="header-actions-right w-auto flex items-center justify-end gap-4 lg:gap-6 order-2 lg:order-3 lg:ml-6">
                <!-- Polylang Switcher -->
                <?php if ( function_exists( 'pll_the_languages' ) ) : ?>
                    <ul class="polylang-switcher flex items-center gap-3 list-none m-0 p-0 lg:pr-6 lg:border-r border-gray-200">
                        <?php pll_the_languages( array( 'dropdown' => 0, 'show_flags' => 1, 'show_names' => 0 ) ); ?>
                    </ul>
                <?php endif; ?>

                <!-- Cart / Tư vấn -->
                <?php if ( class_exists( 'WooCommerce' ) ) : ?>
                    <a id="shopping-cart-trigger" class="header-cart relative flex items-center text-dark font-medium group" href="<?php echo esc_url( wc_get_cart_url() ); ?>" title="Xem danh sách cần tư vấn">
                        <svg class="header-cart-icon w-6 h-6 text-gray-700 group-hover:text-primary transition-colors" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                        </svg>
                        <span class="ml-2 text-[14px] hidden lg:block group-hover:text-primary transition-colors">Danh sách</span>
                        <div class="header-cart-count absolute -top-2 lg:-right-2 -right-2 bg-primary text-white text-xs font-bold w-5 h-5 flex items-center justify-center rounded-full shadow-sm"><?php echo WC()->cart->get_cart_contents_count(); ?></div>
                    </a>
                <?php endif; ?>
            </div>

		</div><!-- .container -->
	</header><!-- #masthead -->
