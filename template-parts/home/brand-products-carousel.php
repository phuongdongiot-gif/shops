<?php
/**
 * Template Part: Brand Products Carousel (2 hàng - Trang chủ)
 * Hiển thị sản phẩm theo brand (taxonomy: product_brand, term_id: 60)
 */

$brand_term_id = 60;

// Thử lấy brand term - hỗ trợ cả 2 taxonomy phổ biến
$brand_term = null;
$brand_taxonomy = '';

foreach (array('product_brand', 'pwb-brand', 'yith_product_brand') as $tax) {
	if (taxonomy_exists($tax)) {
		$term = get_term($brand_term_id, $tax);
		if ($term && !is_wp_error($term)) {
			$brand_term = $term;
			$brand_taxonomy = $tax;
			break;
		}
	}
}

// Fallback: thử lấy term không cần biết taxonomy
if (!$brand_term) {
	$brand_term = get_term($brand_term_id);
	if ($brand_term && !is_wp_error($brand_term)) {
		$brand_taxonomy = $brand_term->taxonomy;
	}
}

if (!$brand_term || is_wp_error($brand_term)) {
	return; // Không tìm thấy brand, thoát
}

// Query sản phẩm theo brand
$args = array(
	'post_type'      => 'product',
	'posts_per_page' => 20,
	'post_status'    => 'publish',
	'orderby'        => 'date',
	'order'          => 'DESC',
	'tax_query'      => array(
		array(
			'taxonomy' => $brand_taxonomy,
			'field'    => 'term_id',
			'terms'    => $brand_term_id,
		),
	),
);

$brand_query = new WP_Query($args);

if (!$brand_query->have_posts()) {
	wp_reset_postdata();
	return;
}

// Lấy thumbnail brand nếu có
$brand_thumb_id = get_term_meta($brand_term_id, 'thumbnail_id', true);
$brand_logo_url = $brand_thumb_id ? wp_get_attachment_image_url($brand_thumb_id, 'medium') : '';

// Link xem tất cả
$brand_link = get_term_link($brand_term);
if (is_wp_error($brand_link)) {
	$brand_link = home_url('/shop/?filter_brand=' . $brand_term_id);
}
?>

<section class="brand-products-carousel-section mt-6 md:mt-10 bg-white overflow-hidden">
	<div class="container mx-auto px-6">

		<!-- Header -->
		<div class="flex items-center justify-between mb-6">
			<div class="flex items-center gap-3">
				<?php if ($brand_logo_url): ?>
					<img src="<?php echo esc_url($brand_logo_url); ?>"
						alt="<?php echo esc_attr($brand_term->name); ?>"
						class="h-8 md:h-10 w-auto object-contain rounded">
				<?php endif; ?>
				<div>
					<h2 class="text-lg md:text-xl font-heading font-bold text-dark uppercase tracking-wide flex items-center gap-2">
						<svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
							<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
								d="M13 10V3L4 14h7v7l9-11h-7z"></path>
						</svg>
						<?php echo esc_html($brand_term->name); ?>
					</h2>
					<p class="text-xs text-gray-400 font-medium mt-0.5">
						<?php echo $brand_term->count; ?> sản phẩm
					</p>
				</div>
			</div>
			<a href="<?php echo esc_url($brand_link); ?>"
				class="group flex items-center gap-1.5 text-xs md:text-sm font-bold text-primary hover:text-primary-hover uppercase tracking-wider transition-colors">
				<span>Xem tất cả</span>
				<svg class="w-4 h-4 transform group-hover:translate-x-1 transition-transform" fill="none"
					stroke="currentColor" viewBox="0 0 24 24">
					<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
				</svg>
			</a>
		</div>

		<!-- Swiper 2 Hàng -->
		<div class="swiper brandProductsSwiper pb-10 relative">
			<div class="swiper-wrapper">
				<?php
				while ($brand_query->have_posts()):
					$brand_query->the_post();
					global $product;
					if (!$product) continue;
					?>
					<div class="swiper-slide">
						<div
							class="group bg-white rounded-xl border border-gray-100 overflow-hidden hover:shadow-[0_8px_30px_rgb(0,0,0,0.08)] transition-all duration-300 flex flex-col h-full transform hover:-translate-y-1">
							<!-- Ảnh sản phẩm -->
							<div class="relative overflow-hidden shrink-0">
								<a href="<?php the_permalink(); ?>" class="block">
									<?php
									if (has_post_thumbnail()) {
										the_post_thumbnail('woocommerce_thumbnail', array(
											'class' => 'w-full h-[160px] md:h-[180px] object-cover transform group-hover:scale-105 transition-transform duration-700 ease-out'
										));
									} else {
										echo '<div class="w-full h-[160px] md:h-[180px] bg-gray-50 flex items-center justify-center text-gray-400 text-xs">Không có ảnh</div>';
									}
									?>
								</a>
								<?php if ($product->is_on_sale()): ?>
									<span
										class="absolute top-2 right-2 bg-red-500 text-white text-[10px] font-bold px-2 py-0.5 rounded-full shadow-sm">
										Sale!
									</span>
								<?php endif; ?>
							</div>

							<!-- Thông tin sản phẩm -->
							<div class="p-3 md:p-4 flex flex-col flex-1 bg-white relative z-10 border-t border-gray-50">
								<?php
								$terms = get_the_terms($product->get_id(), 'product_cat');
								if ($terms && !is_wp_error($terms)) {
									$first_term = $terms[0];
									echo '<div class="mb-1"><a href="' . esc_url(get_term_link($first_term)) . '" class="inline-block px-2 py-0.5 bg-orange-50 text-primary text-[9px] md:text-[10px] font-bold uppercase rounded hover:bg-primary hover:text-white transition-colors">' . esc_html($first_term->name) . '</a></div>';
								}
								?>
								<h3 class="text-[12px] md:text-[13px] font-heading font-bold text-dark mb-1 leading-tight uppercase">
									<a href="<?php the_permalink(); ?>"
										class="hover:text-primary transition-colors line-clamp-2">
										<?php the_title(); ?>
									</a>
								</h3>

								<!-- Giá -->
								<div class="mt-auto pt-2 flex items-center justify-between border-t border-gray-50/80">
									<div
										class="text-primary font-bold text-[13px] md:text-[14px] flex items-center gap-1 [&>del]:text-[10px] [&>del]:text-gray-400 [&>del]:font-normal [&>ins]:no-underline [&>ins]:text-primary">
										<?php
										$price = $product->get_price();
										if (empty($price) || $price == 0) {
											echo '<span class="text-red-500 text-[12px]">Liên hệ</span>';
										} else {
											echo $product->get_price_html();
										}
										?>
									</div>
									<div class="shrink-0 relative z-20">
										<?php
										if ($product) {
											echo apply_filters(
												'woocommerce_loop_add_to_cart_link',
												sprintf(
													'<a href="%s" data-quantity="1" class="button !text-[10px] !px-2 !py-1" data-product_id="%s" title="%s">%s</a>',
													esc_url($product->add_to_cart_url()),
													esc_attr($product->get_id()),
													esc_attr__('Thêm vào danh sách', 'shopping'),
													esc_html($product->add_to_cart_text())
												),
												$product,
												array()
											);
										}
										?>
									</div>
								</div>
							</div>
						</div>
					</div>
				<?php
				endwhile;
				wp_reset_postdata();
				?>
			</div>
			<!-- Navigation & Pagination -->
			<div class="brand-swiper-pagination w-full mt-4 flex justify-center !static"></div>
			<div class="brand-swiper-prev absolute left-0 top-1/2 -translate-y-1/2 z-10 w-9 h-9 md:w-10 md:h-10 bg-white/90 backdrop-blur rounded-full shadow-lg flex items-center justify-center cursor-pointer hover:bg-primary hover:text-white transition-all text-gray-600 -ml-1 md:-ml-2">
				<svg class="w-4 h-4 md:w-5 md:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
					<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
				</svg>
			</div>
			<div class="brand-swiper-next absolute right-0 top-1/2 -translate-y-1/2 z-10 w-9 h-9 md:w-10 md:h-10 bg-white/90 backdrop-blur rounded-full shadow-lg flex items-center justify-center cursor-pointer hover:bg-primary hover:text-white transition-all text-gray-600 -mr-1 md:-mr-2">
				<svg class="w-4 h-4 md:w-5 md:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
					<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
				</svg>
			</div>
		</div>

	</div>
</section>
