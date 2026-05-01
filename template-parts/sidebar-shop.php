<?php
/**
 * Shop Sidebar Template Part
 * Contains Categories, Latest Products, and Latest News.
 */
?>
<aside class="hidden md:block w-full lg:w-1/4 space-y-8 shrink-0 relative">

    <!-- Product Categories Widget -->
    <div class="bg-white border border-gray-200">
        <div class="py-4 px-6 border-b border-gray-200 bg-gray-50">
            <h3 class="text-lg font-heading font-bold text-dark uppercase tracking-wide">Danh Mục Sản Phẩm</h3>
        </div>
        <div class="p-5 flex flex-wrap gap-2">
            <?php
            if (taxonomy_exists('product_cat')) {
                $product_categories = get_terms(array(
                    'taxonomy' => 'product_cat',
                    'hide_empty' => false,
                    'orderby' => 'name',
                    'order' => 'ASC'
                ));
                if (!empty($product_categories) && !is_wp_error($product_categories)) {
                    foreach ($product_categories as $category) {
                        if (!in_array($category->slug, array('uncategorized', 'chua-phan-loai')) && $category->name !== 'Chưa phân loại') {
                            echo '<a href="' . esc_url(get_term_link($category)) . '" class="inline-block px-3 py-1.5 bg-gray-50 border border-gray-200 text-gray-600 text-[11px] font-bold uppercase rounded-md hover:bg-primary hover:text-white hover:border-primary transition-colors">' . esc_html($category->name) . '</a>';
                        }
                    }
                } else {
                    echo '<span class="text-xs text-gray-500">Chưa có danh mục nào.</span>';
                }
            } else {
                echo '<span class="text-xs text-gray-500">Vui lòng cài đặt WooCommerce.</span>';
            }
            ?>
        </div>
    </div>

    <!-- Latest Products Widget -->
    <div class="bg-white border border-gray-200">
        <div class="py-4 px-6 border-b border-gray-200 bg-gray-50">
            <h3 class="text-lg font-heading font-bold text-dark uppercase tracking-wide">Sản Phẩm Mới</h3>
        </div>
        <div class="p-6 space-y-6">
            <?php
            if (class_exists('WooCommerce')):
                $latest_products = new WP_Query(array(
                    'post_type' => 'product',
                    'posts_per_page' => 5,
                    'post_status' => 'publish',
                    'orderby' => 'date',
                    'order' => 'DESC'
                ));

                if ($latest_products->have_posts()):
                    while ($latest_products->have_posts()):
                        $latest_products->the_post();
                        ?>
                        <div class="flex gap-4 items-start pb-4 border-b border-gray-100 last:border-0 last:pb-0">
                            <a href="<?php the_permalink(); ?>" class="shrink-0">
                                <?php
                                if (has_post_thumbnail()) {
                                    the_post_thumbnail('thumbnail', array('class' => 'w-16 h-16 object-cover border border-gray-100 p-1'));
                                } else {
                                    echo '<div class="w-16 h-16 bg-gray-100 flex items-center justify-center text-[10px] text-gray-400 border border-gray-200 p-1">No Img</div>';
                                }
                                ?>
                            </a>
                            <div>
                                <h4
                                    class="text-[13px] font-bold uppercase text-dark leading-tight hover:text-primary transition-colors mb-1">
                                    <a href="<?php the_permalink(); ?>"><?php echo wp_trim_words(get_the_title(), 8, '...'); ?></a>
                                </h4>
                                <?php if ($price_html = wc_get_product(get_the_ID())->get_price_html()): ?>
                                    <span class="text-primary font-bold text-sm block"><?php echo $price_html; ?></span>
                                <?php endif; ?>
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

</aside>