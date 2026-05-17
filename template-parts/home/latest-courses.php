<?php
/**
 * Template Part: Khóa Học Mới Nhất (Trang chủ)
 * Layout 4 cột giống Latest News — mobile scroll ngang
 *
 * @package shopping
 */
if (!class_exists('LearnPress')) return;

$courses_query = new WP_Query([
    'post_type'      => 'lp_course',
    'posts_per_page' => 8,
    'post_status'    => 'publish',
    'orderby'        => 'date',
    'order'          => 'DESC',
]);

if (!$courses_query->have_posts()) return;

$courses_url = get_post_type_archive_link('lp_course') ?: home_url('/courses/');
?>

<section class="home-latest-courses py-8 md:py-16">
    <div class="container mx-auto px-4 md:px-6">

        <!-- Header -->
        <div class="mb-6 md:mb-10 flex items-center justify-between border-b-2 border-gray-200 pb-3 md:pb-4">
            <h2 class="text-xl md:text-3xl font-heading font-extrabold text-dark uppercase tracking-tight relative">
                <?php esc_html_e('Khóa Học Mới Nhất', 'shopping'); ?>
                <span class="absolute -bottom-[14px] md:-bottom-[18px] left-0 w-1/2 md:w-24 h-1 bg-primary"></span>
            </h2>
            <a href="<?php echo esc_url($courses_url); ?>"
               class="hidden sm:flex text-sm font-bold text-gray-500 hover:text-primary items-center gap-1.5 transition-colors uppercase tracking-wider bg-white px-4 py-2 rounded-full border border-gray-100 shadow-sm">
                Xem tất cả
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                </svg>
            </a>
        </div>

        <!-- Grid / Carousel -->
        <div class="flex overflow-x-auto snap-x snap-mandatory gap-4 md:grid md:grid-cols-2 lg:grid-cols-4 md:gap-6 pb-4 -mx-4 px-4 md:mx-0 md:px-0 md:pb-0 scrollbar-hide">
            <?php while ($courses_query->have_posts()) : $courses_query->the_post();
                $course    = learn_press_get_course(get_the_ID());
                $thumb_url = get_the_post_thumbnail_url(get_the_ID(), 'medium_large');
                $price_html = $course ? $course->get_price_html() : '';
                // Số học viên — dùng meta trực tiếp để tránh lỗi LP version
                $students = (int) get_post_meta(get_the_ID(), '_lp_students', true);
            ?>
            <article class="snap-start shrink-0 w-[240px] md:w-auto bg-white rounded-2xl border border-gray-100 overflow-hidden hover:shadow-[0_8px_30px_rgb(0,0,0,0.08)] transition-all duration-300 flex flex-col group transform hover:-translate-y-1">

                <!-- Thumbnail -->
                <a href="<?php the_permalink(); ?>" class="block overflow-hidden relative aspect-[16/10] sm:aspect-[4/3] bg-gray-100">
                    <?php if ($thumb_url) : ?>
                        <img src="<?php echo esc_url($thumb_url); ?>"
                             alt="<?php echo esc_attr(get_the_title()); ?>"
                             class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700 ease-out">
                    <?php else : ?>
                        <div class="w-full h-full flex items-center justify-center text-gray-300">
                            <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                      d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                            </svg>
                        </div>
                    <?php endif; ?>
                    <div class="absolute inset-0 bg-gradient-to-t from-black/40 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>

                    <!-- Badge giá nổi trên ảnh -->
                    <div class="absolute top-2 right-2">
                        <?php if ($price_html) : ?>
                            <span class="bg-primary text-white text-[11px] font-bold px-2.5 py-1 rounded-full shadow">
                                <?php echo wp_kses_post($price_html); ?>
                            </span>
                        <?php else : ?>
                            <span class="bg-green-500 text-white text-[11px] font-bold px-2.5 py-1 rounded-full shadow">
                                Miễn phí
                            </span>
                        <?php endif; ?>
                    </div>
                </a>

                <!-- Body -->
                <div class="p-4 md:p-5 flex-1 flex flex-col gap-2 relative z-10">

                    <!-- Meta: danh mục -->
                    <?php $cats = get_the_terms(get_the_ID(), 'course_category');
                    if ($cats && !is_wp_error($cats)) : ?>
                        <span class="text-[10px] font-bold text-primary uppercase tracking-wider">
                            <?php echo esc_html($cats[0]->name); ?>
                        </span>
                    <?php endif; ?>

                    <!-- Title -->
                    <h3 class="text-[15px] md:text-[17px] font-heading font-extrabold text-dark leading-snug line-clamp-2">
                        <a href="<?php the_permalink(); ?>" class="hover:text-primary transition-colors">
                            <?php the_title(); ?>
                        </a>
                    </h3>

                    <!-- Excerpt -->
                    <div class="text-[13px] text-gray-500 leading-relaxed line-clamp-2 flex-1">
                        <?php echo wp_trim_words(wp_strip_all_tags(get_the_excerpt()), 15, '...'); ?>
                    </div>

                    <!-- Footer: học viên + nút -->
                    <div class="mt-auto pt-3 border-t border-gray-100 flex items-center justify-between">
                        <?php if ($students > 0) : ?>
                            <span class="text-[12px] text-gray-400 flex items-center gap-1">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                                <?php echo number_format($students); ?> học viên
                            </span>
                        <?php else : ?>
                            <span></span>
                        <?php endif; ?>

                        <a href="<?php the_permalink(); ?>"
                           class="text-primary font-bold hover:text-primary-hover inline-flex items-center gap-1 text-[12px] uppercase tracking-wider transition-colors">
                            Xem khóa
                            <svg class="w-3.5 h-3.5 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                            </svg>
                        </a>
                    </div>
                </div>
            </article>
            <?php endwhile; wp_reset_postdata(); ?>
        </div>

        <!-- Nút Xem tất cả — mobile -->
        <div class="mt-6 md:mt-8 flex justify-center sm:hidden">
            <a href="<?php echo esc_url($courses_url); ?>"
               class="text-sm font-bold text-gray-600 hover:text-primary flex items-center gap-1.5 transition-colors uppercase tracking-wider bg-white px-6 py-2.5 rounded-full border border-gray-200 shadow-sm">
                Xem tất cả khóa học
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                </svg>
            </a>
        </div>

    </div>
</section>
