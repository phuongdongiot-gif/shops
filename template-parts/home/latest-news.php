<?php
// Template Part: Latest News (Trang chủ)
?>
<section class="latest-news bg-gray-50 py-12 md:py-16">
    <div class="container mx-auto px-4 md:px-6">
        <div class="mb-8 md:mb-10 flex items-center justify-between border-b-2 border-gray-200 pb-4">
            <h2 class="text-2xl md:text-3xl font-heading font-extrabold text-dark uppercase tracking-tight relative">
                <?php shopping_e('Tin Tức Mới Nhất'); ?>
                <span class="absolute -bottom-[18px] left-0 w-1/2 md:w-24 h-1 bg-primary"></span>
            </h2>
            <?php $blog_page_id = get_option('page_for_posts'); ?>
            <a href="<?php echo $blog_page_id ? esc_url(get_permalink($blog_page_id)) : esc_url(home_url('/')); ?>" class="hidden sm:flex text-sm font-bold text-gray-500 hover:text-primary items-center gap-1.5 transition-colors uppercase tracking-wider bg-white px-4 py-2 rounded-full border border-gray-100 shadow-sm">
                <?php shopping_e('Xem tất cả'); ?> <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
            </a>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 md:gap-8">
            <?php
            $news_query = new WP_Query(array(
                'post_type'      => 'post',
                'posts_per_page' => 3,
                'post_status'    => 'publish',
                'orderby'        => 'date',
                'order'          => 'DESC'
            ));

            if ($news_query->have_posts()):
                while ($news_query->have_posts()):
                    $news_query->the_post();
                    ?>
                    <article
                        class="bg-white rounded-2xl border border-gray-100 overflow-hidden hover:shadow-[0_8px_30px_rgb(0,0,0,0.08)] transition-all duration-300 flex flex-col group transform hover:-translate-y-1">
                        <?php if (has_post_thumbnail()): ?>
                            <a href="<?php the_permalink(); ?>" class="block overflow-hidden relative aspect-[16/10] sm:aspect-[4/3]">
                                <?php the_post_thumbnail('medium_large', array('class' => 'w-full h-full object-cover group-hover:scale-105 transition-transform duration-700 ease-out')); ?>
                                <div class="absolute inset-0 bg-gradient-to-t from-black/40 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                            </a>
                        <?php endif; ?>
                        <div class="p-5 md:p-6 flex-1 flex flex-col relative z-10">
                            <div class="text-[12px] text-gray-400 font-semibold mb-3 flex items-center gap-1.5 uppercase tracking-wider">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                <?php echo get_the_date(); ?>
                            </div>
                            <h3 class="text-[17px] md:text-[19px] font-heading font-extrabold text-dark mb-3 leading-snug line-clamp-2">
                                <a href="<?php the_permalink(); ?>" class="hover:text-primary transition-colors"><?php the_title(); ?></a>
                            </h3>
                            <div class="text-[14px] text-gray-500 mb-5 leading-relaxed line-clamp-2 flex-1">
                                <?php echo wp_trim_words( wp_strip_all_tags( get_the_excerpt() ), 15, '...' ); ?>
                            </div>
                            <div class="mt-auto pt-4 border-t border-gray-100">
                                <a href="<?php the_permalink(); ?>"
                                    class="text-primary font-bold hover:text-primary-hover inline-flex items-center gap-1.5 text-[13px] uppercase tracking-wider transition-colors">
                                    <?php shopping_e('Xem Chi Tiết'); ?> 
                                    <svg class="w-4 h-4 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
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
        
        <!-- Nút Xem tất cả cho mobile -->
        <div class="mt-8 flex justify-center sm:hidden">
            <a href="<?php echo $blog_page_id ? esc_url(get_permalink($blog_page_id)) : esc_url(home_url('/')); ?>" class="text-sm font-bold text-gray-600 hover:text-primary items-center gap-1.5 transition-colors uppercase tracking-wider bg-white px-6 py-2.5 rounded-full border border-gray-200 shadow-sm flex">
                <?php shopping_e('Xem tất cả tin tức'); ?> <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
            </a>
        </div>
    </div>
</section>
