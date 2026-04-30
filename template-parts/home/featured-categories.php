<?php
// Template Part: Featured Categories (Trang chủ)
?>
<section class="featured-products">
    <div
        class="mb-8 flex flex-col md:flex-row md:justify-between md:items-end gap-5 border-b-2 border-primary pb-3">

        <?php
        // Lấy danh mục có nhiều sản phẩm nhất
        $featured_terms = get_terms(array(
            'taxonomy' => 'product_cat',
            'hide_empty' => true,
            'orderby' => 'count',
            'order' => 'DESC',
            'number' => 4
        ));

        // Lọc bỏ category rác
        $tab_terms = array();
        if (!is_wp_error($featured_terms)) {
            foreach ($featured_terms as $term) {
                if (!in_array($term->slug, array('uncategorized', 'chua-phan-loai')) && $term->name !== 'Chưa phân loại') {
                    $tab_terms[] = $term;
                }
            }
        }
        ?>

        <!-- Stacked Categories -->


        <div class="stacked-categories-container flex flex-col gap-10">
            <?php
            foreach ($tab_terms as $tab_term):
                $args = array(
                    'post_type' => 'product',
                    'posts_per_page' => 8,
                    'post_status' => 'publish',
                    'orderby' => 'date',
                    'order' => 'DESC',
                    'tax_query' => array(
                        array(
                            'taxonomy' => 'product_cat',
                            'field' => 'slug',
                            'terms' => $tab_term->slug,
                        ),
                    ),
                );

                $tab_query = new WP_Query($args);
                if ($tab_query->have_posts()):
                    ?>
                    <!-- Category Block -->
                    <div class="category-block bg-white relative">
                        <!-- Header Bar -->
                        <div class="header-bar flex flex-row items-stretch rounded-t-xl overflow-hidden cursor-pointer select-none group border-b-[3px] border-primary shadow-sm hover:shadow transition-shadow bg-white"
                            onclick="toggleCategoryCollapse('cat-<?php echo esc_attr($tab_term->slug); ?>', this)">
                            <!-- Tiêu đề (Màu nổi bật) -->
                            <h2
                                class="text-white bg-primary py-3 md:py-3.5 px-4 md:px-6 font-heading font-bold uppercase tracking-wide text-[14px] md:text-[18px] flex items-center shrink-0">
                                <svg class="w-4 h-4 md:w-5 md:h-5 mr-2 md:mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10">
                                    </path>
                                </svg>
                                <span class="truncate max-w-[120px] sm:max-w-none"><?php echo esc_html($tab_term->name); ?></span>
                            </h2>

                            <!-- Phần nền mờ bên phải và Nút Xem thêm -->
                            <div class="flex-1 flex justify-end items-center pr-3 md:pr-6 py-0 space-x-2 md:space-x-4">
                                <a href="<?php echo esc_url(get_term_link($tab_term)); ?>"
                                    class="text-[11px] md:text-[13px] font-bold text-primary hover:text-primary-hover uppercase tracking-wider flex items-center gap-1 z-10 whitespace-nowrap"
                                    onclick="event.stopPropagation(); window.location.href=this.href;">
                                    <span class="hidden sm:inline">Xem tất cả</span>
                                    <span class="sm:hidden">Xem</span>
                                    <svg class="w-3.5 h-3.5 md:w-4 md:h-4 transform group-hover:translate-x-1 transition-transform"
                                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 5l7 7-7 7"></path>
                                    </svg>
                                </a>
                                <!-- Nút Dấu Gập -->
                                <div
                                    class="ml-1 md:ml-6 w-6 h-6 md:w-8 md:h-8 rounded-full bg-white border border-primary/20 flex items-center justify-center text-primary shadow-sm toggle-icon transition-transform duration-300">
                                    <svg class="w-4 h-4 md:w-5 md:h-5 transition-transform duration-300" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 9l-7 7-7-7"></path>
                                    </svg>
                                </div>
                            </div>
                        </div>

                        <!-- Lưới Sản Phẩm -->
                        <div id="cat-<?php echo esc_attr($tab_term->slug); ?>"
                            class="category-grid-content grid transition-[grid-template-rows] duration-500 ease-in-out"
                            style="grid-template-rows: 1fr;">
                            <div
                                class="overflow-hidden grid-inner-wrapper transition-opacity duration-300 ease-out">
                                <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-4 py-8">
                                    <?php
                                    while ($tab_query->have_posts()):
                                        $tab_query->the_post();
                                        global $product;
                                        ?>
                                        <div
                                            class="group bg-white rounded-xl border border-gray-100 overflow-hidden hover:shadow-[0_8px_30px_rgb(0,0,0,0.08)] transition-all duration-300 flex flex-col h-full transform hover:-translate-y-1">
                                            <div class="relative overflow-hidden shrink-0">
                                                <a href="<?php the_permalink(); ?>" class="block">
                                                    <?php
                                                    if (has_post_thumbnail()) {
                                                        the_post_thumbnail('woocommerce_thumbnail', array('class' => 'w-full h-[200px] object-cover transform group-hover:scale-105 transition-transform duration-700 ease-out'));
                                                    } else {
                                                        echo '<div class="w-full h-[200px] bg-gray-50 flex items-center justify-center text-gray-400 text-xs">Không có ảnh</div>';
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

                                            <div
                                                class="p-4 flex flex-col flex-1 bg-white relative z-10 border-t border-gray-50">
                                                <?php
                                                $terms = get_the_terms($product->get_id(), 'product_cat');
                                                if ($terms && !is_wp_error($terms)) {
                                                    $first_term = $terms[0];
                                                    echo '<div class="mb-1.5"><a href="' . esc_url(get_term_link($first_term)) . '" class="inline-block px-2 py-0.5 bg-orange-50 text-primary text-[10px] font-bold uppercase rounded hover:bg-primary hover:text-white transition-colors">' . esc_html($first_term->name) . '</a></div>';
                                                }
                                                ?>
                                                <h3
                                                    class="text-[13px] font-heading font-bold text-dark mb-1.5 leading-tight uppercase">
                                                    <a href="<?php the_permalink(); ?>"
                                                        class="hover:text-primary transition-colors line-clamp-2">
                                                        <?php the_title(); ?>
                                                    </a>
                                                </h3>

                                                <?php
                                                $short_desc = wp_trim_words(wp_strip_all_tags(get_the_excerpt()), 16, '...');
                                                if (!empty($short_desc)):
                                                    ?>
                                                    <div
                                                        class="text-[12px] text-gray-500 mb-2 line-clamp-2 leading-relaxed">
                                                        <?php echo $short_desc; ?>
                                                    </div>
                                                <?php endif; ?>

                                                <!-- Add slightly styled price html & Add to list icon -->
                                                <div
                                                    class="mt-auto pt-3 flex flex-wrap md:flex-nowrap items-center justify-between border-t border-gray-50/80">
                                                    <div
                                                        class="text-primary font-bold text-[15px] flex items-center gap-1.5 [&>del]:text-[11px] [&>del]:text-gray-400 [&>del]:font-normal [&>ins]:no-underline [&>ins]:text-primary">
                                                        <?php
                                                        $price = $product->get_price();
                                                        if (empty($price) || $price == 0) {
                                                            echo '<span class="text-red-500">Liên hệ</span>';
                                                        } else {
                                                            echo $product->get_price_html();
                                                        }
                                                        ?>
                                                    </div>

                                                    <div class="shrink-0 mt-2 md:mt-0 relative z-20">
                                                        <?php
                                                        if ($product) {
                                                            echo apply_filters(
                                                                'woocommerce_loop_add_to_cart_link',
                                                                sprintf(
                                                                    '<a href="%s" data-quantity="1" class="button" data-product_id="%s" title="%s">%s</a>',
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
                                        <?php
                                    endwhile;
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                endif;
                wp_reset_postdata();
            endforeach;
            ?>
        </div>


</section>
