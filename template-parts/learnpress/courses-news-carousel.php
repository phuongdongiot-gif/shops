<?php
/**
 * Template Part: Tin Tức Mới Nhất — Carousel dưới trang /courses
 * Mobile: scroll ngang (carousel)   |   Desktop (≥1024px): grid 4 cột cố định
 *
 * @package shopping
 */
defined('ABSPATH') || exit;

$news_query = new WP_Query(array(
    'post_type'      => 'post',
    'posts_per_page' => 8,
    'post_status'    => 'publish',
    'orderby'        => 'date',
    'order'          => 'DESC',
));

if (!$news_query->have_posts()) return;

$blog_page_id = get_option('page_for_posts');
$blog_url     = $blog_page_id ? get_permalink($blog_page_id) : home_url('/');
?>

<section class="lp-courses-news-section">
    <div class="lp-courses-news-inner">

        <!-- Header -->
        <div class="lp-courses-news-header">
            <div class="lp-courses-news-title-wrap">
                <span class="lp-courses-news-accent"></span>
                <h2 class="lp-courses-news-title">Tin Tức Mới Nhất</h2>
            </div>
            <a href="<?php echo esc_url($blog_url); ?>" class="lp-courses-news-viewall lp-courses-news-viewall--desktop">
                Xem tất cả
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
            </a>
        </div>

        <!-- Track — scroll ngang mobile / grid 4 cột desktop -->
        <div class="lp-courses-news-track" id="lp-news-track">
            <?php while ($news_query->have_posts()) : $news_query->the_post(); ?>
                <article class="lp-courses-news-card">
                    <?php if (has_post_thumbnail()) : ?>
                        <a href="<?php the_permalink(); ?>" class="lp-courses-news-card__img-wrap">
                            <?php the_post_thumbnail('medium_large', ['class' => 'lp-courses-news-card__img']); ?>
                        </a>
                    <?php else : ?>
                        <a href="<?php the_permalink(); ?>" class="lp-courses-news-card__img-wrap lp-courses-news-card__img-wrap--placeholder">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        </a>
                    <?php endif; ?>

                    <div class="lp-courses-news-card__body">
                        <span class="lp-courses-news-card__date">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            <?php echo get_the_date(); ?>
                        </span>

                        <h3 class="lp-courses-news-card__title">
                            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                        </h3>

                        <p class="lp-courses-news-card__excerpt">
                            <?php echo wp_trim_words(wp_strip_all_tags(get_the_excerpt()), 15, '…'); ?>
                        </p>

                        <div class="lp-courses-news-card__footer">
                            <a href="<?php the_permalink(); ?>" class="lp-courses-news-card__link">
                                Xem chi tiết
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                            </a>
                        </div>
                    </div>
                </article>
            <?php endwhile; wp_reset_postdata(); ?>
        </div>

        <!-- Nút xem tất cả mobile -->
        <div class="lp-courses-news-viewall-mobile">
            <a href="<?php echo esc_url($blog_url); ?>" class="lp-courses-news-viewall">
                Xem tất cả tin tức
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
            </a>
        </div>

    </div>
</section>
