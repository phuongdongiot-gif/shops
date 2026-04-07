<?php
/**
 * Pre-footer Template
 * Displays Top Selling Products, Latest Products, and Latest News.
 */
?>
<div class="pre-footer bg-white py-12 border-t border-gray-200">
    <div class="container mx-auto px-6">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-10">
            
            <!-- Column 1: Sản phẩm bán chạy -->
            <div class="widget-col">
                <h3 class="text-[16px] font-heading font-bold text-dark mb-5 uppercase tracking-wide">Sản Phẩm Bán Chạy</h3>
                <ul class="flex flex-col">
                    <?php
                    if ( class_exists( 'WooCommerce' ) ) {
                        $args = array(
                            'post_type'      => 'product',
                            'posts_per_page' => 3,
                            'post_status'    => 'publish',
                            'meta_key'       => 'total_sales',
                            'orderby'        => 'meta_value_num',
                            'order'          => 'DESC'
                        );
                        $top_selling = new WP_Query( $args );

                        if ( $top_selling->have_posts() ) {
                            while ( $top_selling->have_posts() ) : $top_selling->the_post();
                                ?>
                                <li class="flex gap-4 py-3.5 border-b border-gray-100 last:border-0 items-center">
                                    <a href="<?php the_permalink(); ?>" class="shrink-0 w-16 h-16 block border border-gray-100 p-0.5">
                                        <?php 
                                        if ( has_post_thumbnail() ) {
                                            the_post_thumbnail('thumbnail', array('class' => 'w-full h-full object-cover'));
                                        } else {
                                            echo '<div class="w-full h-full bg-gray-50 flex items-center justify-center text-[10px] text-gray-400">No Img</div>';
                                        }
                                        ?>
                                    </a>
                                    <div class="flex-1">
                                        <a href="<?php the_permalink(); ?>" class="text-[13px] font-semibold text-dark hover:text-primary transition-colors leading-snug uppercase block">
                                            <?php echo wp_trim_words( get_the_title(), 10, '...' ); ?>
                                        </a>
                                    </div>
                                </li>
                                <?php
                            endwhile;
                            wp_reset_postdata();
                        } else {
                            echo '<li class="text-[13px] text-gray-500 py-2">Đang cập nhật...</li>';
                        }
                    } else {
                        echo '<li class="text-[13px] text-gray-500 py-2">WooCommerce chưa được kích hoạt.</li>';
                    }
                    ?>
                </ul>
            </div>

            <!-- Column 2: Sản phẩm mới -->
            <div class="widget-col">
                <h3 class="text-[16px] font-heading font-bold text-dark mb-5 uppercase tracking-wide">Sản Phẩm Mới</h3>
                <ul class="flex flex-col">
                    <?php
                    if ( class_exists( 'WooCommerce' ) ) {
                        $args2 = array(
                            'post_type'      => 'product',
                            'posts_per_page' => 3,
                            'post_status'    => 'publish',
                            'orderby'        => 'date',
                            'order'          => 'DESC'
                        );
                        $latest_products = new WP_Query( $args2 );

                        if ( $latest_products->have_posts() ) {
                            while ( $latest_products->have_posts() ) : $latest_products->the_post();
                                ?>
                                <li class="flex gap-4 py-3.5 border-b border-gray-100 last:border-0 items-center">
                                    <a href="<?php the_permalink(); ?>" class="shrink-0 w-16 h-16 block border border-gray-100 p-0.5">
                                        <?php 
                                        if ( has_post_thumbnail() ) {
                                            the_post_thumbnail('thumbnail', array('class' => 'w-full h-full object-cover'));
                                        } else {
                                            echo '<div class="w-full h-full bg-gray-50 flex items-center justify-center text-[10px] text-gray-400">No Img</div>';
                                        }
                                        ?>
                                    </a>
                                    <div class="flex-1">
                                        <a href="<?php the_permalink(); ?>" class="text-[13px] font-semibold text-dark hover:text-primary transition-colors leading-snug uppercase block">
                                            <?php echo wp_trim_words( get_the_title(), 10, '...' ); ?>
                                        </a>
                                    </div>
                                </li>
                                <?php
                            endwhile;
                            wp_reset_postdata();
                        } else {
                            echo '<li class="text-[13px] text-gray-500 py-2">Đang cập nhật...</li>';
                        }
                    } else {
                        echo '<li class="text-[13px] text-gray-500 py-2">WooCommerce chưa được kích hoạt.</li>';
                    }
                    ?>
                </ul>
            </div>

            <!-- Column 3: Tin tức mới nhất -->
            <div class="widget-col">
                <h3 class="text-[16px] font-heading font-bold text-dark mb-5 uppercase tracking-wide">Tin Tức Mới Nhất</h3>
                <ul class="flex flex-col">
                    <?php
                    $args3 = array(
                        'post_type'      => 'post',
                        'posts_per_page' => 3,
                        'post_status'    => 'publish',
                        'orderby'        => 'date',
                        'order'          => 'DESC'
                    );
                    $latest_news = new WP_Query( $args3 );

                    if ( $latest_news->have_posts() ) {
                        while ( $latest_news->have_posts() ) : $latest_news->the_post();
                            ?>
                            <li class="py-3.5 border-b border-gray-100 last:border-0">
                                <a href="<?php the_permalink(); ?>" class="text-[13px] font-semibold text-dark hover:text-primary transition-colors leading-snug uppercase block">
                                    <?php echo get_the_title(); ?>
                                </a>
                            </li>
                            <?php
                        endwhile;
                        wp_reset_postdata();
                    } else {
                        echo '<li class="text-[13px] text-gray-500 py-2">Đang cập nhật...</li>';
                    }
                    ?>
                </ul>
            </div>

        </div>
    </div>
</div>
