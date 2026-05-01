<?php
// Template Part: Left Sidebar (Trang chủ)
?>
<!-- Left Sidebar -->
<aside class="hidden md:block w-full lg:w-1/4 space-y-8 shrink-0 relative">

    <!-- Product Categories Widget -->
    <div class="bg-white border-t border-x border-gray-200 shadow-sm">
        <ul class="flex flex-col text-[14px] font-semibold text-[#004d40]">
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
                            echo '<li class="border-b border-gray-200/60">';
                            echo '<a href="' . esc_url(get_term_link($category)) . '" class="flex items-center justify-between px-4 py-[13px] hover:bg-primary hover:text-white transition-all group">';

                            // Left flex: Icon + Name
                            echo '<div class="flex items-center gap-2.5">';
                            echo '<svg class="w-3.5 h-3.5 text-gray-800 group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M9 5l7 7-7 7"></path></svg>';
                            echo '<span class="group-hover:translate-x-1 transition-transform duration-300">' . esc_html($category->name) . '</span>';
                            echo '</div>';

                            // Right Icon (Square/Card)
                            echo '<svg class="w-[15px] h-[15px] text-primary group-hover:text-white transition-colors opacity-80" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect></svg>';

                            echo '</a></li>';
                        }
                    }
                } else {
                    echo '<li class="px-6 py-4 text-gray-500 border-b border-gray-100">Chưa có danh mục nào.</li>';
                }
            } else {
                echo '<li class="px-6 py-4 text-gray-500 border-b border-gray-100">Vui lòng cài đặt WooCommerce.</li>';
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
            if (class_exists('WooCommerce')):
                $latest_products = new WP_Query(array(
                    'post_type' => 'product',
                    'posts_per_page' => 3,
                    'post_status' => 'publish',
                    'orderby' => 'date',
                    'order' => 'DESC'
                ));

                if ($latest_products->have_posts()):
                    while ($latest_products->have_posts()):
                        $latest_products->the_post();
                        ?>
                        <div class="flex gap-4 items-center">
                            <a href="<?php the_permalink(); ?>"
                                class="shrink-0 rounded-lg overflow-hidden border border-gray-100 shadow-sm block relative group">
                                <?php
                                if (has_post_thumbnail()) {
                                    the_post_thumbnail('thumbnail', array('class' => 'w-20 h-20 object-cover group-hover:scale-105 transition-transform duration-300'));
                                } else {
                                    echo '<div class="w-20 h-20 bg-gray-50 flex items-center justify-center text-[10px] text-gray-400">No Img</div>';
                                }
                                ?>
                            </a>
                            <div class="flex-1 flex flex-col justify-center">
                                <h4
                                    class="text-[13px] font-bold text-dark leading-snug mb-1.5 hover:text-primary transition-colors">
                                    <a href="<?php the_permalink(); ?>"><?php echo wp_trim_words(get_the_title(), 10, '...'); ?></a>
                                </h4>
                                <?php
                                global $product;
                                if ($product):
                                    ?>
                                    <div
                                        class="text-primary font-bold text-[14px] flex items-center gap-1.5 [&>del]:text-[11px] [&>del]:text-gray-400 [&>del]:font-normal [&>ins]:no-underline [&>ins]:text-primary">
                                        <?php
                                        $price = $product->get_price();
                                        echo (empty($price) || $price == 0) ? 'Liên hệ' : $product->get_price_html();
                                        ?>
                                    </div>
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

    <!-- Latest News Widget -->
    <div class="bg-white border border-gray-200">
        <div class="py-4 px-6 border-b border-gray-200">
            <h3 class="text-lg font-heading font-bold text-dark uppercase tracking-wide">Tin Tức Mới Nhất</h3>
        </div>
        <div class="p-6 space-y-6">
            <?php
            $widget_news = new WP_Query(array(
                'post_type' => 'post',
                'posts_per_page' => 2,
                'post_status' => 'publish',
            ));
            if ($widget_news->have_posts()):
                while ($widget_news->have_posts()):
                    $widget_news->the_post();
                    ?>
                    <div class="flex gap-4 items-start">
                        <?php if (has_post_thumbnail()): ?>
                            <a href="<?php the_permalink(); ?>"
                                class="shrink-0"><?php the_post_thumbnail('thumbnail', array('class' => 'w-16 h-16 object-cover border border-gray-100 p-1')); ?></a>
                        <?php else: ?>
                            <a href="<?php the_permalink(); ?>"
                                class="w-16 h-16 bg-gray-200 shrink-0 border border-gray-100 p-1 block"></a>
                        <?php endif; ?>
                        <div>
                            <h4
                                class="text-[13px] font-bold uppercase text-dark leading-tight hover:text-primary transition-colors">
                                <a href="<?php the_permalink(); ?>"><?php echo wp_trim_words(get_the_title(), 12, '...'); ?></a>
                            </h4>
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