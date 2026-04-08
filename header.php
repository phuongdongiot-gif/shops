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
	<header id="masthead" class="site-header static lg:sticky top-0 z-50 bg-white/95 backdrop-blur shadow-sm transition-all duration-300">
		<div class="container mx-auto px-6 min-h-[56px] flex flex-col lg:flex-row items-center justify-between gap-4 py-2 lg:py-0">
			<div class="main-navigation-wrapper w-full lg:w-auto h-full flex items-center">
				<?php get_template_part( 'template-parts/header-nav' ); ?>
			</div><!-- .main-navigation-wrapper -->

			<div class="header-actions flex flex-wrap justify-center items-center gap-6 mt-2 lg:mt-0">
				<?php if ( function_exists( 'pll_the_languages' ) ) : ?>
					<ul class="polylang-switcher flex items-center gap-3 list-none m-0 p-0 pr-6 border-r border-gray-200">
						<?php pll_the_languages( array( 'dropdown' => 0, 'show_flags' => 1, 'show_names' => 0 ) ); ?>
					</ul>
				<?php endif; ?>

				<?php /* TẠM THỜI BỎ GIỎ HÀNG
                if ( class_exists( 'WooCommerce' ) ) : ?>
					<a class="header-cart relative flex items-center text-dark font-medium group" href="<?php echo esc_url( wc_get_cart_url() ); ?>" title="<?php esc_attr_e( 'View your shopping cart', 'shopping' ); ?>">
						<svg class="header-cart-icon w-6 h-6 mr-2 text-gray-700 group-hover:text-primary transition-colors" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round">
							<circle cx="9" cy="21" r="1"></circle>
							<circle cx="20" cy="21" r="1"></circle>
							<path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path>
						</svg>
						<span class="header-cart-text hidden"><?php echo wp_kses_data( WC()->cart->get_cart_subtotal() ); ?></span>
						<div class="header-cart-count absolute -top-2 -right-2 bg-primary text-white text-xs font-bold w-5 h-5 flex items-center justify-center rounded-full shadow-sm"><?php echo WC()->cart->get_cart_contents_count(); ?></div>
					</a>
				<?php endif; 
                */ ?>
			</div><!-- .header-actions -->
		</div><!-- .container -->
	</header><!-- #masthead -->
