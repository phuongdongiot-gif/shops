<?php
// Template Part: Category Carousel (Trang chủ)
	if (taxonomy_exists('product_cat')) {
		$product_categories = get_terms(array(
			'taxonomy' => 'product_cat',
			'hide_empty' => false,
			'orderby' => 'name',
			'order' => 'ASC'
		));

		$valid_categories = array();
		if (!empty($product_categories) && !is_wp_error($product_categories)) {
			foreach ($product_categories as $category) {
				if (!in_array($category->slug, array('uncategorized', 'chua-phan-loai')) && $category->name !== 'Chưa phân loại') {
					$valid_categories[] = $category;
				}
			}
		}

		if (!empty($valid_categories)):
			?>
			<section class="category-carousel-section mt-10 md:mt-16 bg-white overflow-hidden">
				<div class="container mx-auto px-6">
					<div class="swiper categorySwiper pb-12">
						<div class="swiper-wrapper">
							<?php foreach ($valid_categories as $category): ?>
								<?php
								$thumbnail_id = get_term_meta($category->term_id, 'thumbnail_id', true);
								if ($thumbnail_id) {
									$image_url = wp_get_attachment_image_url($thumbnail_id, 'medium_large');
								} else {
									$image_url = function_exists('wc_placeholder_img_src') ? wc_placeholder_img_src() : 'https://images.unsplash.com/photo-1555529771-835f59fc5efe?auto=format&fit=crop&w=400&q=80';
								}
								?>
								<div class="swiper-slide h-auto">
									<a href="<?php echo esc_url(get_term_link($category)); ?>"
										class="block group text-center cursor-pointer h-full">
										<div
											class="w-full aspect-square rounded-2xl overflow-hidden mb-5 shadow-[0_4px_20px_rgb(0,0,0,0.06)] border border-gray-100/50 flex items-center justify-center bg-gray-50 relative">
											<img src="<?php echo esc_url($image_url); ?>"
												alt="<?php echo esc_attr($category->name); ?>"
												class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700 ease-out">
											<div
												class="absolute inset-0 bg-gradient-to-t from-black/40 via-black/5 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300">
											</div>
										</div>
										<h3
											class="text-[15px] font-heading font-bold text-dark group-hover:text-primary transition-colors uppercase leading-tight">
											<?php echo esc_html($category->name); ?>
										</h3>
										<p class="text-[12px] text-gray-500 mt-1.5 font-medium"><?php echo $category->count; ?> sản
											phẩm</p>
									</a>
								</div>
							<?php endforeach; ?>
						</div>
						<!-- Pagination -->
						<div class="category-swiper-pagination w-full mt-6 flex justify-center !static"></div>
					</div>
				</div>
			</section>
		<?php endif;
	}
?>
