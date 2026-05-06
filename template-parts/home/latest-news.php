<?php
// Template Part: Latest News (Trang chủ)
?>
<section class="latest-news">
    <div class="mb-6 border-b-2 border-primary pb-2 flex justify-between items-end">
        <h2 class="text-xl font-heading font-bold text-dark uppercase tracking-wide">
            <?php shopping_e('Tin Tức Mới Nhất'); ?>
        </h2>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <?php
        $news_query = new WP_Query(array(
            'post_type' => 'post',
            'posts_per_page' => 3,
            'post_status' => 'publish',
        ));

        if ($news_query->have_posts()):
            while ($news_query->have_posts()):
                $news_query->the_post();
                ?>
                <article
                    class="bg-white rounded border border-gray-200 overflow-hidden hover:shadow-md transition-shadow flex flex-col group">
                    <?php if (has_post_thumbnail()): ?>
                        <a href="<?php the_permalink(); ?>" class="block overflow-hidden h-40">
                            <?php the_post_thumbnail('medium_large', array('class' => 'w-full h-full object-cover group-hover:scale-105 transition-transform duration-500')); ?>
                        </a>
                    <?php endif; ?>
                    <div class="p-4 flex-1 flex flex-col">
                        <div class="text-[11px] text-gray-500 font-semibold mb-2 uppercase">
                            <?php echo get_the_date(); ?>
                        </div>
                        <h3 class="text-sm font-heading font-bold text-dark mb-2 leading-snug"><a
                                href="<?php the_permalink(); ?>"
                                class="hover:text-primary transition-colors"><?php echo wp_trim_words(get_the_title(), 12, '...'); ?></a>
                        </h3>
                        <div class="mt-4">
                            <a href="<?php the_permalink(); ?>"
                                class="text-primary font-bold hover:underline inline-flex items-center gap-1 text-[13px]">
                                <?php shopping_e('Chi Tiết'); ?> &rarr;
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
</section>
