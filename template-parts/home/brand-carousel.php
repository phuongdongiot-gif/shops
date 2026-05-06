<?php
// Template Part: Brand 60 Carousel
if (class_exists('WooCommerce')) {
    $args = array(
        'post_type' => 'product',
        'posts_per_page' => 24, // 24 products = 12 slides (2 per slide)
        'tax_query' => array(
            'relation' => 'OR',
            array(
                'taxonomy' => 'product_cat',
                'field'    => 'term_id',
                'terms'    => 60,
            ),
            array(
                'taxonomy' => 'pwb-brand',
                'field'    => 'term_id',
                'terms'    => 60,
            )
        ),
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
            <div class="container mx-auto px-6 border-t border-gray-100 pt-10">
                <div class="flex items-center justify-between mb-8">
                    <h2 class="text-2xl md:text-3xl font-heading font-bold text-dark uppercase m-0"><?php echo esc_html($term_name); ?></h2>
                    <a href="<?php echo esc_url(get_term_link(60)); ?>" class="text-primary font-bold hover:underline hidden md:block">Xem tất cả &rarr;</a>
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
