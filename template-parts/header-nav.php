<?php
/**
 * Template part for displaying header navigation
 *
 * @package shopping
 */
?>
<nav id="site-navigation" class="main-navigation w-full lg:w-auto static lg:relative">
	<!-- Mobile Menu Toggle Button -->
	<button id="menu-toggle-btn" class="menu-toggle lg:hidden flex items-center gap-2 px-3 py-2 border rounded text-dark border-gray-300 hover:text-primary hover:border-primary transition-colors bg-white font-heading" aria-controls="primary-menu" aria-expanded="false">
		<svg class="w-5 h-5 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
			<path fill-rule="evenodd" d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd"></path>
		</svg>
		<span class="text-sm font-semibold"><?php esc_html_e( 'Menu', 'shopping' ); ?></span>
	</button>

	<!-- Nav Menu Wrap (Hidden on Mobile by default, Flex on Desktop) -->
	<div id="primary-menu-wrap" class="hidden absolute left-0 right-0 top-full mt-4 lg:mt-0 bg-white lg:bg-transparent shadow-lg lg:shadow-none p-4 lg:p-0 z-50 lg:relative lg:flex lg:items-center">
		<?php
		wp_nav_menu(
			array(
				'theme_location' => 'menu-1',
				'menu_id'        => 'primary-menu',
				'menu_class'     => 'flex flex-col lg:flex-row flex-wrap gap-4 lg:gap-6 items-start lg:items-center w-full font-semibold text-[14px] text-gray-700',
				'container'      => false,
				'fallback_cb'    => function() {
					echo '<ul id="primary-menu" class="flex flex-col lg:flex-row flex-wrap gap-4 lg:gap-8 items-start lg:items-center w-full font-bold text-[14px] text-gray-800 uppercase">';
					echo '<li><a href="' . esc_url( home_url( '/' ) ) . '" class="hover:text-primary transition-colors">Trang chủ</a></li>';
					
					// Menu Danh mục (Dropdown)
					if ( taxonomy_exists( 'product_cat' ) ) {
						echo '<li class="relative group cursor-pointer">';
						echo '<a href="' . esc_url( home_url( '/cua-hang/' ) ) . '" class="hover:text-primary transition-colors flex items-center gap-1">Danh mục <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg></a>';
						
						// Fetch root categories
						$product_categories = get_terms( array( 'taxonomy' => 'product_cat', 'hide_empty' => false, 'parent' => 0, 'number' => 17 ) );
						if ( ! empty( $product_categories ) && ! is_wp_error( $product_categories ) ) {
							// Update to use opacity/visibility instead of display to avoid WP core CSS conflicts
							echo '<ul class="absolute left-0 lg:-left-16 xl:-left-32 top-full mt-2 w-[280px] sm:w-[450px] md:w-[600px] lg:w-[750px] bg-white border border-gray-100 shadow-xl rounded-md p-4 invisible opacity-0 pointer-events-none group-hover:visible group-hover:opacity-100 group-hover:pointer-events-auto transition-all duration-300 transform translate-y-2 group-hover:translate-y-0 z-[60] grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-2">';
							$count = 0;
							foreach ( $product_categories as $category ) {
								if ( ! in_array( $category->slug, array( 'uncategorized', 'chua-phan-loai' ) ) && $category->name !== 'Chưa phân loại' ) {
									if ( $count >= 15 ) break;
									echo '<li><a href="' . esc_url( get_term_link( $category ) ) . '" class="block px-3 py-2 text-[13px] font-semibold text-gray-700 hover:bg-orange-50 hover:text-primary transition-colors capitalize rounded border border-transparent hover:border-orange-100 truncate" title="' . esc_attr( $category->name ) . '">' . esc_html( $category->name ) . '</a></li>';
									$count++;
								}
							}
							echo '</ul>';
						}
						echo '</li>';
					}

					// Menu Sản phẩm (Mega Dropdown)
					if ( post_type_exists( 'product' ) ) {
						echo '<li class="relative group cursor-pointer">';
						echo '<a href="' . esc_url( home_url( '/cua-hang/' ) ) . '" class="hover:text-primary transition-colors flex items-center gap-1">Sản phẩm <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg></a>';
						
						echo '<div class="absolute left-0 lg:-left-32 xl:-left-48 top-full mt-2 w-[280px] sm:w-[450px] md:w-[600px] lg:w-[750px] bg-white border border-gray-100 shadow-xl rounded-md p-4 invisible opacity-0 pointer-events-none group-hover:visible group-hover:opacity-100 group-hover:pointer-events-auto transition-all duration-300 transform translate-y-2 group-hover:translate-y-0 z-[60]">';
						
						$product_args = array(
							'post_type'      => 'product',
							'posts_per_page' => 15,
							'meta_query'     => array(
								array(
									'key'     => '_thumbnail_id',
									'compare' => 'EXISTS'
								)
							),
							'post_status'    => 'publish',
						);
						$product_query = new WP_Query( $product_args );
						
						if ( $product_query->have_posts() ) {
							echo '<div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-3">';
							while ( $product_query->have_posts() ) {
								$product_query->the_post();
								echo '<a href="' . esc_url( get_permalink() ) . '" class="block group/item relative overflow-hidden rounded border border-gray-100 hover:border-primary transition-colors bg-gray-50">';
								echo get_the_post_thumbnail( get_the_ID(), 'medium', array( 'class' => 'w-full aspect-square object-cover group-hover/item:scale-105 transition-transform duration-300' ) );
								echo '<div class="absolute inset-x-0 bottom-0 bg-gradient-to-t from-black/80 to-transparent p-2 pt-8 flex items-end justify-center"><span class="text-white text-[11px] leading-snug font-semibold text-center line-clamp-2 drop-shadow-md">' . get_the_title() . '</span></div>';
								echo '</a>';
							}
							wp_reset_postdata();
							echo '</div>';
							echo '<div class="mt-4 text-center border-t border-gray-100 pt-3"><a href="' . esc_url( home_url( '/cua-hang/' ) ) . '" class="inline-block text-xs font-bold text-primary hover:text-dark transition-colors uppercase tracking-wider">Xem tất cả sản phẩm &rarr;</a></div>';
						} else {
							echo '<p class="text-sm text-gray-500">Chưa có sản phẩm nào.</p>';
						}
						
						echo '</div>';
						echo '</li>';
					}

					echo '<li><a href="' . esc_url( home_url( '/tin-tuc/' ) ) . '" class="hover:text-primary transition-colors">Tin tức</a></li>';
					// Menu Kiến thức & Khóa học (Dropdown)
					echo '<li class="relative group cursor-pointer">';
					echo '<a href="#" class="hover:text-primary transition-colors flex items-center gap-1">Kiến thức & Khóa học <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg></a>';
					echo '<ul class="absolute left-0 lg:left-auto lg:right-0 top-full mt-2 w-64 bg-white border border-gray-100 shadow-xl rounded-md py-2 invisible opacity-0 pointer-events-none group-hover:visible group-hover:opacity-100 group-hover:pointer-events-auto transition-all duration-300 transform translate-y-2 group-hover:translate-y-0 z-50">';
					echo '<li><a href="' . esc_url( home_url( '/kien-thuc/' ) ) . '" class="block px-5 py-2.5 text-[14px] font-semibold text-gray-700 hover:bg-orange-50 hover:text-primary transition-colors">📖 Kiến thức</a></li>';
					if ( class_exists( 'LearnPress' ) ) {
					    $courses_link = get_post_type_archive_link( 'lp_course' ) ? get_post_type_archive_link( 'lp_course' ) : home_url( '/courses/' );
					    echo '<li><a href="' . esc_url( $courses_link ) . '" class="block px-5 py-2.5 text-[14px] font-semibold text-gray-700 hover:bg-orange-50 hover:text-primary transition-colors">🎓 Các khóa học</a></li>';
					}
					echo '</ul>';
					echo '</li>';

					echo '<li><a href="' . esc_url( home_url( '/he-thong-chi-nhanh/' ) ) . '" class="hover:text-primary transition-colors flex items-center gap-1 text-primary"><svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5a2.5 2.5 0 010-5 2.5 2.5 0 010 5z"/></svg> Chi nhánh</a></li>';
					echo '<li><a href="' . esc_url( home_url( '/lien-he/' ) ) . '" class="hover:text-primary transition-colors">Liên hệ</a></li>';
					echo '</ul>';
				}
			)
		);
		?>
	</div>
</nav><!-- #site-navigation -->

<script>
document.addEventListener('DOMContentLoaded', function() {
    const toggleBtn = document.getElementById('menu-toggle-btn');
    const menuWrap = document.getElementById('primary-menu-wrap');

    if (toggleBtn && menuWrap) {
        toggleBtn.addEventListener('click', function(e) {
            e.preventDefault();
            // Toggle visibility classes
            menuWrap.classList.toggle('hidden');
            menuWrap.classList.toggle('flex');
            
            // Update aria attribute
            const isExpanded = toggleBtn.getAttribute('aria-expanded') === 'true' || false;
            toggleBtn.setAttribute('aria-expanded', !isExpanded);
        });
    }
});
</script>
