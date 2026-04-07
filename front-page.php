<?php
/**
 * Template Name: Homepage
 */

get_header();
?>

	<main id="primary" class="site-main flex-1">

		<!-- Swiper CSS & JS via CDN -->
		<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
		<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

		<!-- Hero Section Slider -->
		<section class="hero-section relative overflow-hidden bg-gradient-to-br from-orange-50 to-orange-100">
			<!-- Swiper Container -->
			<div class="swiper heroSwiper w-full h-[600px] lg:h-[700px]">
				<div class="swiper-wrapper">
					
					<!-- Slide 1 -->
					<div class="swiper-slide relative w-full h-full">
						<!-- Full Width Background Image -->
						<img src="https://images.unsplash.com/photo-1441984904996-e0b6ba687e04?auto=format&fit=crop&w=1920&q=80" alt="Premium Shopping" class="absolute inset-0 w-full h-full object-cover">
						<!-- Overlay for text readability -->
						<div class="absolute inset-0 bg-black/50"></div>
						<!-- Content positioned at bottom center -->
						<div class="absolute inset-0 flex flex-col justify-end items-center pb-20 z-10 w-full">
							<div class="container mx-auto px-6 text-center text-white">
								<h1 class="text-3xl md:text-4xl lg:text-5xl font-heading font-extrabold text-white leading-tight mb-4 tracking-tight drop-shadow-lg"><?php shopping_e( 'Trải Nghiệm Mua Sắm Hoàn Hảo' ); ?></h1>
								<p class="text-base text-gray-100 mb-8 max-w-2xl mx-auto drop-shadow-md"><?php shopping_e( 'Khám phá bộ sưu tập cao cấp với chất lượng tuyệt hảo, mang đến giá trị đích thực cho cuộc sống.' ); ?></p>
								<div class="flex flex-col sm:flex-row items-center justify-center gap-4">
									<?php if ( class_exists( 'WooCommerce' ) ) : ?>
										<a href="<?php echo esc_url( wc_get_page_permalink( 'shop' ) ); ?>" class="btn inline-flex justify-center items-center px-8 py-3 bg-primary hover:bg-primary-hover text-white rounded-lg font-semibold shadow border border-primary transition-all duration-300 hover:-translate-y-1"><?php shopping_e( 'Mua Ngay' ); ?></a>
									<?php else : ?>
										<a href="#" class="btn inline-flex justify-center items-center px-8 py-3 bg-primary hover:bg-primary-hover text-white rounded-lg font-semibold shadow border border-primary transition-all duration-300 hover:-translate-y-1"><?php shopping_e( 'Khám Phá' ); ?></a>
									<?php endif; ?>
								</div>
							</div>
						</div>
					</div><!-- End Slide 1 -->

					<!-- Slide 2 (Nông thôn, tự nhiên) -->
					<div class="swiper-slide relative w-full h-full">
						<!-- Full Width Background Image -->
						<img src="https://images.unsplash.com/photo-1464226184884-fa280b87c399?auto=format&fit=crop&w=1920&q=80" alt="Rural Organic Food" class="absolute inset-0 w-full h-full object-cover">
						<!-- Overlay for text readability -->
						<div class="absolute inset-0 bg-black/50"></div>
						<!-- Content positioned at bottom center -->
						<div class="absolute inset-0 flex flex-col justify-end items-center pb-20 z-10 w-full">
							<div class="container mx-auto px-6 text-center text-white">
								<h2 class="text-3xl md:text-4xl lg:text-5xl font-heading font-extrabold text-white leading-tight mb-4 tracking-tight drop-shadow-lg">Hương Vị Đồng Quê Đích Thực</h2>
								<p class="text-base text-gray-100 mb-8 max-w-2xl mx-auto drop-shadow-md">Chiết xuất hữu cơ từ thiên nhiên, đem lại hương vị đậm đà và an toàn tuyệt đối cho mọi bữa ăn gia đình.</p>
								<div class="flex flex-col sm:flex-row items-center justify-center gap-4">
									<a href="#" class="btn inline-flex justify-center items-center px-8 py-3 bg-white text-primary border border-white hover:bg-gray-100 rounded-lg font-semibold shadow transition-all duration-300 hover:-translate-y-1">Tìm hiểu chi tiết</a>
								</div>
							</div>
						</div>
					</div><!-- End Slide 2 -->

				</div>
				<!-- Add Pagination -->
				<div class="swiper-pagination"></div>
			</div>

			<style>
				@keyframes float {
					0% { transform: translateY(0px); }
					50% { transform: translateY(-15px); }
					100% { transform: translateY(0px); }
				}
				.swiper-pagination-bullet-active { background: #ea580c !important; }
				.swiper-pagination { bottom: 20px !important; }
			</style>

			<!-- Initialize Swiper -->
			<script>
				document.addEventListener('DOMContentLoaded', function() {
					var swiper = new Swiper('.heroSwiper', {
						loop: true,
						autoplay: {
							delay: 5000,
							disableOnInteraction: false,
						},
						pagination: {
							el: '.swiper-pagination',
							clickable: true,
						},
						effect: 'fade',
						fadeEffect: {
							crossFade: true
						}
					});
				});
			</script>
		</section>

		<!-- Content Wrapper with Sidebar -->
		<div class="container mx-auto px-6 py-12 lg:py-16 flex flex-col lg:flex-row gap-10 items-start">
			
			<!-- Left Sidebar -->
			<aside class="w-full lg:w-1/4 space-y-8 shrink-0 relative">
				
				<!-- Product Categories Widget -->
				<div class="bg-white border border-gray-200">
					<div class="py-4 px-6 border-b border-gray-200">
						<h3 class="text-lg font-heading font-bold text-dark uppercase tracking-wide">Danh Mục Sản Phẩm</h3>
					</div>
					<ul class="divide-y divide-gray-100 text-[13px] font-semibold text-gray-800">
						<?php
						if ( taxonomy_exists( 'product_cat' ) ) {
							$product_categories = get_terms( array(
								'taxonomy'   => 'product_cat',
								'hide_empty' => false,
								'orderby'    => 'name',
								'order'      => 'ASC'
							) );
							if ( ! empty( $product_categories ) && ! is_wp_error( $product_categories ) ) {
								foreach ( $product_categories as $category ) {
									if ( ! in_array( $category->slug, array( 'uncategorized', 'chua-phan-loai' ) ) && $category->name !== 'Chưa phân loại' ) {
										echo '<li><a href="' . esc_url( get_term_link( $category ) ) . '" class="block px-6 py-3.5 hover:text-primary transition-colors uppercase">' . esc_html( $category->name ) . '</a></li>';
									}
								}
							} else {
								echo '<li class="px-6 py-3.5 text-gray-500">Chưa có danh mục nào.</li>';
							}
						} else {
							echo '<li class="px-6 py-3.5 text-gray-500">Vui lòng cài đặt WooCommerce.</li>';
						}
						?>
					</ul>
				</div>

				<!-- Latest Products Widget -->
				<div class="bg-white border border-gray-200">
					<div class="py-4 px-6 border-b border-gray-200">
						<h3 class="text-lg font-heading font-bold text-dark uppercase tracking-wide">Sản Phẩm Mới Nhất</h3>
					</div>
					<div class="p-6 space-y-6">
						<?php
						if ( class_exists( 'WooCommerce' ) ) :
							$latest_products = new WP_Query( array(
								'post_type'      => 'product',
								'posts_per_page' => 3,
								'post_status'    => 'publish',
								'orderby'        => 'date',
								'order'          => 'DESC'
							) );

							if ( $latest_products->have_posts() ) :
								while ( $latest_products->have_posts() ) : $latest_products->the_post();
									?>
									<div class="flex gap-4 items-start">
										<a href="<?php the_permalink(); ?>" class="shrink-0">
											<?php 
											if ( has_post_thumbnail() ) {
												the_post_thumbnail('thumbnail', array('class' => 'w-16 h-16 object-cover border border-gray-100 p-1'));
											} else {
												echo '<div class="w-16 h-16 bg-gray-100 flex items-center justify-center text-[10px] text-gray-400 border border-gray-200 p-1">No Img</div>';
											}
											?>
										</a>
										<div>
											<h4 class="text-[13px] font-bold uppercase text-dark leading-tight hover:text-primary transition-colors"><a href="<?php the_permalink(); ?>"><?php echo wp_trim_words( get_the_title(), 12, '...' ); ?></a></h4>
										</div>
									</div>
									<?php
								endwhile;
								wp_reset_postdata();
							else:
								echo '<p class="text-[13px] text-gray-500">Đang cập nhật sản phẩm...</p>';
							endif;
						else:
							echo '<p class="text-[13px] text-gray-500">Vui lòng kích hoạt WooCommerce.</p>';
						endif;
						?>
					</div>
				</div>

				<!-- Latest News Widget -->
				<div class="bg-white border border-gray-200">
					<div class="py-4 px-6 border-b border-gray-200">
						<h3 class="text-lg font-heading font-bold text-dark uppercase tracking-wide">Tin Tức Mới Nhất</h3>
					</div>
					<div class="p-6 space-y-6">
						<?php
						$widget_news = new WP_Query( array(
							'post_type'      => 'post',
							'posts_per_page' => 2,
							'post_status'    => 'publish',
						) );
						if ( $widget_news->have_posts() ) :
							while ( $widget_news->have_posts() ) : $widget_news->the_post();
								?>
								<div class="flex gap-4 items-start">
									<?php if ( has_post_thumbnail() ) : ?>
										<a href="<?php the_permalink(); ?>" class="shrink-0"><?php the_post_thumbnail('thumbnail', array('class' => 'w-16 h-16 object-cover border border-gray-100 p-1')); ?></a>
									<?php else: ?>
										<a href="<?php the_permalink(); ?>" class="w-16 h-16 bg-gray-200 shrink-0 border border-gray-100 p-1 block"></a>
									<?php endif; ?>
									<div>
										<h4 class="text-[13px] font-bold uppercase text-dark leading-tight hover:text-primary transition-colors"><a href="<?php the_permalink(); ?>"><?php echo wp_trim_words( get_the_title(), 12, '...' ); ?></a></h4>
									</div>
								</div>
								<?php
							endwhile;
							wp_reset_postdata();
						else:
							echo '<p class="text-[13px] text-gray-500">Đang cập nhật...</p>';
						endif;
						?>
					</div>
				</div>

			</aside>
			
			<!-- Main Content Right -->
			<div class="w-full lg:w-3/4 flex flex-col gap-12">
				
				<!-- Categories / Benefits Section -->
				<section class="benefits grid grid-cols-1 md:grid-cols-3 gap-4">
					<!-- Benefit 1 -->
					<div class="bg-gray-50 border border-gray-200 p-5 rounded text-center hover:shadow transition-shadow">
						<div class="w-10 h-10 bg-secondary text-primary rounded-full flex items-center justify-center mx-auto mb-3">
							<svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path></svg>
						</div>
						<h3 class="text-sm font-heading font-bold text-dark mb-1 uppercase"><?php shopping_e( 'Chất Lượng Cao Cấp' ); ?></h3>
						<p class="text-xs text-gray-600"><?php shopping_e( 'Từng sản phẩm đều được kiểm định khắt khe và đạt chuẩn.' ); ?></p>
					</div>
					<!-- Benefit 2 -->
					<div class="bg-gray-50 border border-gray-200 p-5 rounded text-center hover:shadow transition-shadow">
						<div class="w-10 h-10 bg-secondary text-primary rounded-full flex items-center justify-center mx-auto mb-3">
							<svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 2v20M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path></svg>
						</div>
						<h3 class="text-sm font-heading font-bold text-dark mb-1 uppercase"><?php shopping_e( 'Thanh Toán An Toàn' ); ?></h3>
						<p class="text-xs text-gray-600"><?php shopping_e( 'Hệ thống bảo mật thông tin tuyệt đối qua mã hóa.' ); ?></p>
					</div>
					<!-- Benefit 3 -->
					<div class="bg-gray-50 border border-gray-200 p-5 rounded text-center hover:shadow transition-shadow">
						<div class="w-10 h-10 bg-secondary text-primary rounded-full flex items-center justify-center mx-auto mb-3">
							<svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10 21h4v-2h-4v2zm5-11c0-2.76-2.24-5-5-5S5 7.24 5 10c0 1.95 1.13 3.63 2.8 4.41V16c0 .55.45 1 1 1h2.4c.55 0 1-.45 1-1v-1.59c1.67-.78 2.8-2.46 2.8-4.41z"></path></svg>
						</div>
						<h3 class="text-sm font-heading font-bold text-dark mb-1 uppercase"><?php shopping_e( 'Giao Hàng Nhanh' ); ?></h3>
						<p class="text-xs text-gray-600"><?php shopping_e( 'Xử lý đơn linh hoạt, giao hàng siêu tốc toàn quốc.' ); ?></p>
					</div>
				</section>
				
				<!-- Featured Products Section -->
				<?php if ( class_exists( 'WooCommerce' ) ) : ?>
				<section class="featured-products">
					<div class="mb-6 border-b-2 border-primary pb-2 flex justify-between items-end">
						<h2 class="text-xl font-heading font-bold text-dark uppercase tracking-wide"><?php shopping_e( 'Sản Phẩm Nổi Bật' ); ?></h2>
					</div>
					
					<div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-4">
						<?php
						$trending_args = array(
							'post_type'      => 'product',
							'posts_per_page' => 8,
							'post_status'    => 'publish',
							'orderby'        => 'date',
							'order'          => 'DESC',
						);
						$trending_query = new WP_Query( $trending_args );

						if ( $trending_query->have_posts() ) :
							while ( $trending_query->have_posts() ) : $trending_query->the_post();
								global $product;
								?>
								<div class="group bg-white rounded-xl border border-gray-100 overflow-hidden hover:shadow-[0_8px_30px_rgb(0,0,0,0.08)] transition-all duration-300 flex flex-col h-full transform hover:-translate-y-1">
									<div class="relative overflow-hidden shrink-0">
										<a href="<?php the_permalink(); ?>" class="block">
											<?php 
											if ( has_post_thumbnail() ) {
												the_post_thumbnail('woocommerce_thumbnail', array('class' => 'w-full h-[200px] object-cover transform group-hover:scale-105 transition-transform duration-700 ease-out'));
											} else {
												echo '<div class="w-full h-[200px] bg-gray-50 flex items-center justify-center text-gray-400 text-xs">Không có ảnh</div>';
											}
											?>
										</a>
										<?php if ( $product->is_on_sale() ) : ?>
											<span class="absolute top-2 right-2 bg-red-500 text-white text-[10px] font-bold px-2 py-0.5 rounded-full shadow-sm">
												Sale!
											</span>
										<?php endif; ?>
									</div>
									
									<div class="p-4 flex flex-col flex-1 bg-white relative z-10 border-t border-gray-50">
										<?php
										$terms = get_the_terms( $product->get_id(), 'product_cat' );
										if ( $terms && ! is_wp_error( $terms ) ) {
											$first_term = $terms[0];
											echo '<div class="mb-1.5"><a href="' . esc_url( get_term_link( $first_term ) ) . '" class="inline-block px-2 py-0.5 bg-orange-50 text-primary text-[10px] font-bold uppercase rounded hover:bg-primary hover:text-white transition-colors">' . esc_html( $first_term->name ) . '</a></div>';
										}
										?>
										<h3 class="text-[13px] font-heading font-bold text-dark mb-1.5 leading-tight uppercase">
											<a href="<?php the_permalink(); ?>" class="hover:text-primary transition-colors line-clamp-2">
												<?php the_title(); ?>
											</a>
										</h3>

										<?php 
										$short_desc = wp_trim_words( wp_strip_all_tags( get_the_excerpt() ), 16, '...' );
										if ( ! empty( $short_desc ) ) :
										?>
										<div class="text-[12px] text-gray-500 mb-2 line-clamp-2 leading-relaxed">
											<?php echo $short_desc; ?>
										</div>
										<?php endif; ?>
										
										<!-- Add slightly styled price html -->
										<div class="text-primary font-bold text-base mb-3 flex items-center gap-1.5 [&>del]:text-[11px] [&>del]:text-gray-400 [&>del]:font-normal [&>ins]:no-underline [&>ins]:text-primary">
											<?php 
											$price = $product->get_price();
											if ( empty( $price ) || $price == 0 ) {
												echo 'Liên hệ';
											} else {
												echo $product->get_price_html(); 
											}
											?>
										</div>
										
										<div class="mt-auto pt-2">
											<?php
											if ( $product ) {
												if ( empty( $price ) || $price == 0 ) {
													// Lấy số điện thoại từ Customizer
													$phone = get_theme_mod( 'topbar_phone', '0947 464 464' );
													$tel = str_replace( array(' ', '.', '-'), '', $phone );
													
													echo sprintf(
														'<a href="tel:%s" class="button block w-full text-center py-2 text-[13px] rounded-lg font-bold transition-all duration-300 text-white bg-primary hover:bg-primary-hover">Liên hệ ngay</a>',
														esc_attr( $tel )
													);
												} else {
													// Tạm thời bỏ giỏ hàng => biến thành nút xem chi tiết
													echo sprintf(
														'<a href="%s" class="button block w-full text-center py-2 text-[13px] rounded-lg font-bold transition-all duration-300 text-primary bg-secondary border border-primary/20 hover:bg-primary hover:text-white">%s</a>',
														esc_url( get_permalink() ),
														esc_html__( 'Xem chi tiết', 'shopping' )
													);
												}
											}
											?>
										</div>
									</div>
								</div>
								<?php
							endwhile;
							wp_reset_postdata();
						else :
							echo '<div class="col-span-full py-10 text-center"><p class="text-gray-500">Đang cập nhật sản phẩm...</p></div>';
						endif;
						?>
					</div>
				</section>
				<?php endif; ?>

				<!-- Latest News Section -->
				<section class="latest-news">
					<div class="mb-6 border-b-2 border-primary pb-2 flex justify-between items-end">
						<h2 class="text-xl font-heading font-bold text-dark uppercase tracking-wide"><?php shopping_e( 'Tin Tức Mới Nhất' ); ?></h2>
					</div>
					
					<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
						<?php
						$news_query = new WP_Query( array(
							'post_type'      => 'post',
							'posts_per_page' => 3,
							'post_status'    => 'publish',
						) );

						if ( $news_query->have_posts() ) :
							while ( $news_query->have_posts() ) : $news_query->the_post();
								?>
								<article class="bg-white rounded border border-gray-200 overflow-hidden hover:shadow-md transition-shadow flex flex-col group">
									<?php if ( has_post_thumbnail() ) : ?>
										<a href="<?php the_permalink(); ?>" class="block overflow-hidden h-40">
											<?php the_post_thumbnail( 'medium_large', array( 'class' => 'w-full h-full object-cover group-hover:scale-105 transition-transform duration-500' ) ); ?>
										</a>
									<?php endif; ?>
									<div class="p-4 flex-1 flex flex-col">
										<div class="text-[11px] text-gray-500 font-semibold mb-2 uppercase"><?php echo get_the_date(); ?></div>
										<h3 class="text-sm font-heading font-bold text-dark mb-2 leading-snug"><a href="<?php the_permalink(); ?>" class="hover:text-primary transition-colors"><?php echo wp_trim_words( get_the_title(), 12, '...' ); ?></a></h3>
										<div class="mt-4">
											<a href="<?php the_permalink(); ?>" class="text-primary font-bold hover:underline inline-flex items-center gap-1 text-[13px]">
												<?php shopping_e( 'Chi Tiết' ); ?> &rarr;
											</a>
										</div>
									</div>
								</article>
								<?php
							endwhile;
							wp_reset_postdata();
						endif;
						?>
					</div>
				</section>

			</div><!-- End Main Content -->
		</div><!-- End Content Wrapper -->

	</main><!-- #primary -->

<?php
get_footer();
