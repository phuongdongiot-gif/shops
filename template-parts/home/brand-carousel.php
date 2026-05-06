<?php
// Template Part: Brand 60 Carousel
if (class_exists('WooCommerce')) {
    $taxonomies_to_check = array('product_cat', 'pwb-brand', 'product_brand', 'brand', 'yith_product_brand');
    $tax_query = array('relation' => 'OR');
    
    foreach ($taxonomies_to_check as $tax) {
        if (taxonomy_exists($tax)) {
            $tax_query[] = array(
                'taxonomy' => $tax,
                'field'    => 'term_id',
                'terms'    => 60,
            );
        }
    }

    $args = array(
        'post_type' => 'product',
        'posts_per_page' => 24, // 24 products = 12 slides (2 per slide)
        'tax_query' => count($tax_query) > 1 ? $tax_query : array(),
    );
    $brand_query = new WP_Query($args);

    if ($brand_query->have_posts()):
        $term_name = 'Sản Phẩm Thương Hiệu';
        $term_60 = get_term(60);
        if ($term_60 && !is_wp_error($term_60)) {
            $term_name = $term_60->name;
        }
        ?>
        <style>
            .brandSwiper:not(.swiper-initialized) {
                overflow: hidden;
            }
            .brandSwiper:not(.swiper-initialized) .swiper-wrapper {
                display: flex;
                gap: 24px;
            }
            .brandSwiper:not(.swiper-initialized) .swiper-slide {
                flex: 0 0 auto;
                width: 250px;
            }
            .brandSwiper .products.grid-rows-2 {
                display: flex !important;
                flex-direction: column !important;
                gap: 1.5rem !important; /* 24px */
                grid-template-columns: none !important;
            }
            /* Reset some wc stuff inside swiper */
            .brandSwiper .products.grid-rows-2 li.product {
                width: 100% !important;
                margin: 0 !important;
            }
        </style>
        <section class="brand-carousel-section mt-10 md:mt-16 bg-white overflow-hidden woocommerce">
            <div class="container mx-auto px-6 border-t border-gray-100 pt-10 relative">
                <div class="flex flex-col md:flex-row md:items-end justify-between mb-10 gap-5 border-b border-gray-100 pb-5">
                    <div class="flex items-start gap-4">
                        <div class="w-12 h-12 bg-orange-50 rounded-xl flex items-center justify-center text-primary shrink-0 shadow-sm border border-orange-100/50">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"></path>
                            </svg>
                        </div>
                        <div>
                            <span class="text-[11px] font-bold text-primary uppercase tracking-widest block mb-1.5">Sản Phẩm Khuyên Dùng</span>
                            <h2 class="text-2xl md:text-3xl font-heading font-bold text-dark uppercase m-0 leading-tight"><?php echo esc_html($term_name); ?></h2>
                        </div>
                    </div>
                    <a href="<?php echo esc_url(get_term_link(60)); ?>" class="group inline-flex items-center gap-2 px-5 py-2 bg-white border border-gray-200 text-[13px] text-gray-600 font-semibold rounded-full hover:border-primary hover:text-primary transition-all shadow-sm w-max">
                        Xem tất cả
                        <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                    </a>
                </div>
                <div class="swiper brandSwiper pb-12">
                    <div class="swiper-wrapper">
                        <?php 
                        $products = $brand_query->get_posts();
                        $chunks = array_chunk($products, 2); // 2 rows -> 2 products per slide
                        foreach ($chunks as $chunk) : 
                        ?>
                            <div class="swiper-slide h-auto">
                                <ul class="products grid-rows-2 h-full w-full m-0 p-0">
                                    <?php foreach ($chunk as $post) : 
                                        $GLOBALS['post'] = $post;
                                        setup_postdata($post);
                                        wc_get_template_part('content', 'product');
                                    ?>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <!-- Pagination -->
                    <div class="brand-swiper-pagination w-full mt-6 flex justify-center !static"></div>
                    <!-- Navigation Arrows -->
                    <div class="swiper-button-next brand-next text-primary !w-10 !h-10 bg-white rounded-full shadow-md border border-gray-100 after:!text-[18px] !right-0 md:!-right-4"></div>
                    <div class="swiper-button-prev brand-prev text-primary !w-10 !h-10 bg-white rounded-full shadow-md border border-gray-100 after:!text-[18px] !left-0 md:!-left-4"></div>
                </div>
            </div>
        </section>
    <?php
    endif;
    if (!$brand_query->have_posts()) {
        echo '<!-- No products found for term ID 60 in product_cat or pwb-brand -->';
    }
    wp_reset_postdata();
}
?>
