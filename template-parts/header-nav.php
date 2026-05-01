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
						$product_categories = get_terms( array( 'taxonomy' => 'product_cat', 'hide_empty' => false, 'parent' => 0, 'number' => 12 ) );
						if ( ! empty( $product_categories ) && ! is_wp_error( $product_categories ) ) {
							$filtered_cats = array();
							foreach ( $product_categories as $category ) {
								if ( ! in_array( $category->slug, array( 'uncategorized', 'chua-phan-loai' ) ) && $category->name !== 'Chưa phân loại' ) {
									$filtered_cats[] = $category;
									if ( count($filtered_cats) >= 10 ) break;
								}
							}
							
							echo '<div class="fixed inset-0 lg:absolute lg:inset-auto lg:left-0 lg:-left-16 xl:-left-32 lg:top-full mt-0 lg:mt-2 w-full lg:w-[850px] h-screen lg:h-auto bg-white border border-gray-100 shadow-xl lg:rounded-md invisible opacity-0 pointer-events-none group-hover:visible group-hover:opacity-100 group-hover:pointer-events-auto transition-all duration-300 lg:transform lg:translate-y-2 lg:group-hover:translate-y-0 z-[100] flex flex-col lg:flex-row overflow-hidden lg:min-h-[300px]">';
							
							// Nút đóng trên Mobile
							echo '<div class="lg:hidden flex items-center justify-between p-4 border-b border-gray-100 bg-white flex-shrink-0 shadow-sm z-20">';
							echo '<span class="font-bold text-lg text-primary">Danh mục sản phẩm</span>';
							echo '<button type="button" onclick="this.closest(\'.group\').classList.toggle(\'pointer-events-none\'); setTimeout(() => this.closest(\'.group\').classList.remove(\'pointer-events-none\'), 300)" class="text-gray-500 hover:text-red-500 p-2"><svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg></button>';
							echo '</div>';

							// Cột Trái (Hiển thị Hình ảnh / Sản phẩm)
							echo '<div class="w-full lg:w-2/3 bg-gray-50 p-4 relative order-2 lg:order-1 flex-1 overflow-y-auto lg:overflow-visible" id="cat-mega-left">';
							
							// Hình ảnh mặc định
							$default_img = has_custom_logo() ? wp_get_attachment_image_src( get_theme_mod( 'custom_logo' ), 'full' )[0] : 'https://ui-avatars.com/api/?name=Shopping&background=ea580c&color=fff&size=400';
							echo '<div class="cat-default-content absolute inset-0 p-4 flex items-center justify-center transition-opacity duration-300 opacity-100 z-10">';
							echo '<img src="' . esc_url($default_img) . '" class="w-full h-full object-cover rounded-lg shadow-sm border border-gray-200" alt="Default Category Image">';
							echo '</div>';
							
							// Sản phẩm từng danh mục
							foreach ( $filtered_cats as $category ) {
								echo '<div class="cat-prods-content absolute inset-0 p-4 transition-opacity duration-300 opacity-0 pointer-events-none bg-gray-50" id="cat-prods-' . esc_attr($category->term_id) . '">';
								echo '<h4 class="text-sm font-bold text-primary mb-3 uppercase border-b border-gray-200 pb-2">' . esc_html($category->name) . '</h4>';
								
								$cat_args = array(
									'post_type'      => 'product',
									'posts_per_page' => 4,
									'post_status'    => 'publish',
									'tax_query'      => array(
										array(
											'taxonomy' => 'product_cat',
											'field'    => 'term_id',
											'terms'    => $category->term_id,
										)
									)
								);
								$cat_query = new WP_Query($cat_args);
								if ($cat_query->have_posts()) {
									echo '<div class="grid grid-cols-2 gap-3 h-[calc(100%-40px)]">';
									while ($cat_query->have_posts()) {
										$cat_query->the_post();
										echo '<a href="' . esc_url(get_permalink()) . '" class="block group/item relative overflow-hidden rounded border border-gray-100 hover:border-primary transition-colors bg-white h-[120px] lg:h-[150px]">';
										echo get_the_post_thumbnail(get_the_ID(), 'medium', array('class' => 'w-full h-full object-cover group-hover/item:scale-105 transition-transform duration-300'));
										echo '<div class="absolute inset-x-0 bottom-0 bg-gradient-to-t from-black/80 to-transparent p-2 pt-6 flex items-end justify-center"><span class="text-white text-[11px] leading-snug font-semibold text-center line-clamp-2 drop-shadow-md">' . get_the_title() . '</span></div>';
										echo '</a>';
									}
									echo '</div>';
								} else {
									echo '<p class="text-sm text-gray-500 mt-4">Chưa có sản phẩm.</p>';
								}
								wp_reset_postdata();
								echo '</div>';
							}
							echo '</div>'; // End Cột Trái
							
							// Cột Phải (Danh sách danh mục)
							echo '<div class="w-full lg:w-1/3 p-3 lg:p-4 bg-white lg:border-l border-gray-100 flex flex-col gap-1 overflow-y-auto lg:max-h-[400px] order-1 lg:order-2 flex-shrink-0 h-[40vh] lg:h-auto shadow-md lg:shadow-none z-10">';
							echo '<div class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-2 px-3">Danh Mục</div>';
							echo '<ul class="list-none m-0 p-0 flex flex-col gap-1">';
							foreach ( $filtered_cats as $category ) {
								echo '<li><a href="' . esc_url( get_term_link( $category ) ) . '" class="cat-hover-link block px-3 py-2.5 text-[13px] font-semibold text-gray-700 hover:bg-orange-50 hover:text-primary transition-colors capitalize rounded border border-transparent" data-target="cat-prods-' . esc_attr($category->term_id) . '">' . esc_html( $category->name ) . '</a></li>';
							}
							echo '</ul>';
							echo '<div class="mt-auto pt-4 text-center"><a href="' . esc_url( home_url( '/cua-hang/' ) ) . '" class="text-xs font-bold text-primary hover:underline">Xem tất cả &rarr;</a></div>';
							echo '</div>'; // End Cột Phải
							echo '</div>'; // End dropdown container
							?>
							<script>
							document.addEventListener('DOMContentLoaded', function() {
								const catLinks = document.querySelectorAll('.cat-hover-link');
								const defaultImg = document.querySelector('.cat-default-content');
								const allProds = document.querySelectorAll('.cat-prods-content');
								
								catLinks.forEach(link => {
									link.addEventListener('mouseenter', function() {
										if (defaultImg) {
											defaultImg.classList.remove('opacity-100', 'z-10');
											defaultImg.classList.add('opacity-0', '-z-10');
										}
										allProds.forEach(prod => {
											prod.classList.remove('opacity-100', 'pointer-events-auto', 'z-10');
											prod.classList.add('opacity-0', 'pointer-events-none', '-z-10');
										});
										
										const targetId = this.getAttribute('data-target');
										const targetProd = document.getElementById(targetId);
										if (targetProd) {
											targetProd.classList.remove('opacity-0', 'pointer-events-none', '-z-10');
											targetProd.classList.add('opacity-100', 'pointer-events-auto', 'z-10');
										}
									});
								});
								
								const megaMenu = defaultImg ? defaultImg.closest('.absolute') : null;
								if (megaMenu) {
									megaMenu.addEventListener('mouseleave', function() {
										if (defaultImg) {
											defaultImg.classList.remove('opacity-0', '-z-10');
											defaultImg.classList.add('opacity-100', 'z-10');
										}
										allProds.forEach(prod => {
											prod.classList.remove('opacity-100', 'pointer-events-auto', 'z-10');
											prod.classList.add('opacity-0', 'pointer-events-none', '-z-10');
										});
									});
								}
							});
							</script>
							<?php
						}
						echo '</li>';
					}

					// Menu Sản phẩm (Mega Dropdown)
					if ( post_type_exists( 'product' ) ) {
						echo '<li class="relative group cursor-pointer">';
						echo '<a href="' . esc_url( home_url( '/cua-hang/' ) ) . '" class="hover:text-primary transition-colors flex items-center gap-1">Sản phẩm <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg></a>';
						
						echo '<div class="fixed inset-0 lg:absolute lg:inset-auto lg:left-0 lg:-left-32 xl:-left-48 lg:top-full mt-0 lg:mt-2 w-full lg:w-[750px] h-screen lg:h-auto bg-white border border-gray-100 shadow-xl lg:rounded-md invisible opacity-0 pointer-events-none group-hover:visible group-hover:opacity-100 group-hover:pointer-events-auto transition-all duration-300 lg:transform lg:translate-y-2 lg:group-hover:translate-y-0 z-[100] flex flex-col lg:block overflow-hidden">';
						
						// Nút đóng trên Mobile
						echo '<div class="lg:hidden flex items-center justify-between p-4 border-b border-gray-100 bg-white sticky top-0 z-10">';
						echo '<span class="font-bold text-lg text-primary">Sản phẩm</span>';
						echo '<button type="button" onclick="this.closest(\'.group\').classList.toggle(\'pointer-events-none\'); setTimeout(() => this.closest(\'.group\').classList.remove(\'pointer-events-none\'), 300)" class="text-gray-500 hover:text-red-500 p-2"><svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg></button>';
						echo '</div>';
						echo '<div class="p-4 flex-1 overflow-y-auto">';
						
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
						
						echo '</div>'; // End p-4 flex-1
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
