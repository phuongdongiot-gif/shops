<?php
// Template Part: Left Sidebar (Trang chủ)
?>
<!-- Left Sidebar -->
<aside class="w-full lg:w-1/4 space-y-8 shrink-0 relative hidden lg:block">

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
                'post_type'      => 'post',
                'posts_per_page' => 8,
                'post_status'    => 'publish',
                'orderby'        => 'date',
                'order'          => 'DESC',
            ));
            if ($widget_news->have_posts()):
                while ($widget_news->have_posts()):
                    $widget_news->the_post();
                    ?>
                    <div class="flex gap-3 items-start border-b border-gray-100 pb-4 last:border-0 last:pb-0">
                        <?php if (has_post_thumbnail()): ?>
                            <a href="<?php the_permalink(); ?>" class="shrink-0 rounded overflow-hidden block">
                                <?php the_post_thumbnail('thumbnail', array('class' => 'w-14 h-14 object-cover hover:scale-105 transition-transform duration-300')); ?>
                            </a>
                        <?php else: ?>
                            <a href="<?php the_permalink(); ?>" class="w-14 h-14 bg-gray-100 shrink-0 rounded block"></a>
                        <?php endif; ?>
                        <div class="flex-1 min-w-0">
                            <span class="text-[11px] text-gray-400 font-medium"><?php echo get_the_date('d/m/Y'); ?></span>
                            <h4 class="text-[12.5px] font-semibold text-dark leading-snug hover:text-primary transition-colors mt-0.5">
                                <a href="<?php the_permalink(); ?>"><?php echo wp_trim_words(get_the_title(), 10, '...'); ?></a>
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

    <?php if (class_exists('LearnPress')) :
        $courses_url = get_post_type_archive_link('lp_course') ?: home_url('/courses/');
        $sidebar_courses = new WP_Query(array(
            'post_type'      => 'lp_course',
            'posts_per_page' => 6,
            'post_status'    => 'publish',
            'orderby'        => 'date',
            'order'          => 'DESC',
        ));
        if ($sidebar_courses->have_posts()) : ?>
    <!-- Courses Widget -->
    <div class="bg-white border border-gray-200">
        <div class="py-4 px-6 border-b border-gray-200 flex items-center justify-between">
            <h3 class="text-lg font-heading font-bold text-dark uppercase tracking-wide">Khóa Học</h3>
            <a href="<?php echo esc_url($courses_url); ?>" class="text-[11px] font-bold text-primary hover:text-primary-hover uppercase tracking-wider transition-colors">Xem tất cả →</a>
        </div>
        <div class="p-4 flex flex-col gap-0">
            <?php while ($sidebar_courses->have_posts()) : $sidebar_courses->the_post();
                $course    = learn_press_get_course(get_the_ID());
                $thumb_url = function_exists('shopping_get_bypass_thumbnail_url') ? shopping_get_bypass_thumbnail_url(get_the_ID()) : get_the_post_thumbnail_url(get_the_ID(), 'thumbnail');
            ?>
            <a href="<?php the_permalink(); ?>" class="flex gap-3 items-center py-3 border-b border-gray-100 last:border-0 group">
                <div class="w-14 h-14 shrink-0 rounded overflow-hidden bg-gray-100">
                    <?php if ($thumb_url) : ?>
                        <img src="<?php echo esc_url($thumb_url); ?>"
                             alt="<?php echo esc_attr(get_the_title()); ?>"
                             class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                    <?php else : ?>
                        <div class="w-full h-full flex items-center justify-center text-gray-300">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="flex-1 min-w-0">
                    <h4 class="text-[12.5px] font-semibold text-dark leading-snug group-hover:text-primary transition-colors">
                        <?php echo wp_trim_words(get_the_title(), 9, '...'); ?>
                    </h4>
                    <?php if ($course) :
                        $price = $course->get_price_html();
                    ?>
                    <span class="text-[11px] font-bold <?php echo $price ? 'text-primary' : 'text-green-600'; ?>">
                        <?php echo $price ? wp_kses_post($price) : 'Miễn phí'; ?>
                    </span>
                    <?php endif; ?>
                </div>
            </a>
            <?php endwhile; wp_reset_postdata(); ?>
        </div>
    </div>
    <?php endif; endif; ?>

</aside>