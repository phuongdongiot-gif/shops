<?php
/**
 * Template Part: Danh Mục Khóa Học — Sidebar trang /courses
 *
 * @package shopping
 */
defined('ABSPATH') || exit;

// Lấy tất cả danh mục khóa học có bài đăng
$categories = get_terms([
    'taxonomy'   => 'course_category',
    'hide_empty' => true,
    'orderby'    => 'count',
    'order'      => 'DESC',
]);

if (empty($categories) || is_wp_error($categories)) return;

// Lấy term đang active (nếu đang ở trong taxonomy archive)
$current_term = is_tax('course_category') ? get_queried_object() : null;
$archive_url  = get_post_type_archive_link('lp_course');
?>

<aside class="lp-archive-category-sidebar">

    <!-- Widget: Danh mục -->
    <div class="lp-archive-cat-widget">
        <div class="lp-archive-cat-widget__header">
            <span class="lp-archive-cat-widget__accent"></span>
            <h3 class="lp-archive-cat-widget__title">Danh Mục Khóa Học</h3>
        </div>

        <ul class="lp-archive-cat-widget__list">
            <!-- Tất cả -->
            <li class="lp-archive-cat-widget__item <?php echo !$current_term ? 'is-active' : ''; ?>">
                <a href="<?php echo esc_url($archive_url); ?>" class="lp-archive-cat-widget__link">
                    <span class="lp-archive-cat-widget__icon">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                        </svg>
                    </span>
                    <span class="lp-archive-cat-widget__name">Tất cả khóa học</span>
                    <span class="lp-archive-cat-widget__count">
                        <?php echo (int) array_sum(array_map(fn($t) => $t->count, $categories)); ?>
                    </span>
                </a>
            </li>

            <?php foreach ($categories as $cat) :
                $is_active = $current_term && $current_term->term_id === $cat->term_id;
                $cat_url   = get_term_link($cat, 'course_category');
            ?>
                <li class="lp-archive-cat-widget__item <?php echo $is_active ? 'is-active' : ''; ?>">
                    <a href="<?php echo esc_url($cat_url); ?>" class="lp-archive-cat-widget__link">
                        <span class="lp-archive-cat-widget__dot"></span>
                        <span class="lp-archive-cat-widget__name"><?php echo esc_html($cat->name); ?></span>
                        <span class="lp-archive-cat-widget__count"><?php echo (int) $cat->count; ?></span>
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>

</aside>
