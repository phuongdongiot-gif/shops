<?php
/**
 * Template Part: Khóa Học Liên Quan — Sidebar của single course
 * Hiển thị tối đa 5 khóa học cùng danh mục
 *
 * @package shopping
 */
defined('ABSPATH') || exit;

global $post;
$course_id = get_the_ID();

// Lấy danh mục của khóa học hiện tại
$terms = get_the_terms($course_id, 'course_category');
$tax_query = [];

if ($terms && !is_wp_error($terms)) {
    $term_ids = wp_list_pluck($terms, 'term_id');
    $tax_query = [
        [
            'taxonomy' => 'course_category',
            'field'    => 'term_id',
            'terms'    => $term_ids,
        ],
    ];
}

$related = new WP_Query([
    'post_type'      => 'lp_course',
    'posts_per_page' => 5,
    'post_status'    => 'publish',
    'post__not_in'   => [$course_id],
    'orderby'        => 'rand',
    'tax_query'      => $tax_query ?: '',
]);

// Nếu cùng danh mục không đủ, fallback lấy bất kỳ
if (!$related->have_posts() || $related->found_posts < 2) {
    $related = new WP_Query([
        'post_type'      => 'lp_course',
        'posts_per_page' => 5,
        'post_status'    => 'publish',
        'post__not_in'   => [$course_id],
        'orderby'        => 'date',
        'order'          => 'DESC',
    ]);
}

if (!$related->have_posts()) return;
?>

<div class="lp-related-courses">
    <div class="lp-related-courses__header">
        <span class="lp-related-courses__accent"></span>
        <h3 class="lp-related-courses__title">Khóa Học Liên Quan</h3>
    </div>

    <ul class="lp-related-courses__list">
        <?php while ($related->have_posts()) : $related->the_post(); ?>
            <?php
            $course      = learn_press_get_course(get_the_ID());
            $thumb_id    = get_post_thumbnail_id();
            $thumb_url   = $thumb_id ? wp_get_attachment_image_url($thumb_id, 'medium') : '';
            // Fallback to bypass function
            if (!$thumb_url && function_exists('shopping_get_bypass_thumbnail_url')) {
                $thumb_url = shopping_get_bypass_thumbnail_url(get_the_ID());
            }
            ?>
            <li class="lp-related-courses__item">
                <a href="<?php the_permalink(); ?>" class="lp-related-courses__link">
                    <div class="lp-related-courses__img-wrap">
                        <?php if ($thumb_url) : ?>
                            <img src="<?php echo esc_url($thumb_url); ?>"
                                 alt="<?php echo esc_attr(get_the_title()); ?>"
                                 class="lp-related-courses__img">
                        <?php else : ?>
                            <div class="lp-related-courses__img-placeholder">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                          d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                            </div>
                        <?php endif; ?>
                    </div>

                    <div class="lp-related-courses__meta">
                        <h4 class="lp-related-courses__name"><?php the_title(); ?></h4>
                        <?php if ($course) : ?>
                            <span class="lp-related-courses__price">
                                <?php
                                $price = $course->get_price_html();
                                echo $price
                                    ? wp_kses_post($price)
                                    : '<span class="lp-related-courses__free">Miễn phí</span>';
                                ?>
                            </span>
                        <?php endif; ?>
                    </div>
                </a>
            </li>
        <?php endwhile; wp_reset_postdata(); ?>
    </ul>
</div>
