<?php
/**
 * Template for displaying course content within the loop.
 *
 * This template can be overridden by copying it to yourtheme/learnpress/content-course.php
 *
 * @author  ThimPress
 * @package  Learnpress/Templates
 * @version  4.0.0
 */

defined( 'ABSPATH' ) || exit();

/**
 * @var LP_Course $course
 */
$course = learn_press_get_course();
if ( ! $course ) {
	return;
}

// Remove default LearnPress CSS classes that interfere with our Tailwind Card
$classes = array(
	'group',
	'bg-white',
	'border',
	'border-gray-100',
	'rounded-2xl',
	'overflow-hidden',
	'shadow-sm',
	'hover:shadow-xl',
	'transition-all',
	'duration-300',
	'!flex',
	'!flex-col',
	'relative',
    '!w-full',
    '!h-full',
    '!p-0',
    '!m-0',
    '!float-none'
);

$post_class = join( ' ', get_post_class( $classes, $course->get_id() ) );
?>

<li id="post-<?php echo esc_attr( $course->get_id() ); ?>" class="<?php echo esc_attr( $post_class ); ?> !list-none">

	<div class="relative overflow-hidden aspect-[4/3] bg-gray-50 border-b border-gray-100">
		<a href="<?php echo esc_url( get_the_permalink() ); ?>" class="block w-full h-full">
			<?php
			$course_id = $course->get_id();
			$image_url = shopping_get_bypass_thumbnail_url( $course_id );

			// Nếu có URL chuẩn
			if ( $image_url ) {
				echo '<img src="' . esc_url( $image_url ) . '" alt="' . esc_attr( get_the_title() ) . '" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">';
			} else {
				// Nếu không có, thử lấy hàm ảnh mặc định của LearnPress (phòng trường hợp dùng ảnh Placeholder của hệ thống)
				$lp_image = $course->get_image( 'course_thumbnail' );
				if ( $lp_image ) {
					echo str_replace( '<img ', '<img class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" ', $lp_image );
				} else {
					// Mặc định cuối cùng
					echo '<div class="w-full h-full flex items-center justify-center bg-gray-100 text-gray-300 group-hover:scale-105 transition-transform duration-500">
						<svg class="w-16 h-16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
					</div>';
				}
			}
			?>

			// Nếu có URL chuẩn
			if ( $image_url ) {
				echo '<img src="' . esc_url( $image_url ) . '" alt="' . esc_attr( get_the_title() ) . '" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">';
			} else {
				// Nếu không có, thử lấy hàm ảnh mặc định của LearnPress (phòng trường hợp dùng ảnh Placeholder của hệ thống)
				$lp_image = $course->get_image( 'course_thumbnail' );
				if ( $lp_image ) {
					echo str_replace( '<img ', '<img class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" ', $lp_image );
				} else {
					// Mặc định cuối cùng
					echo '<div class="w-full h-full flex items-center justify-center bg-gray-100 text-gray-300 group-hover:scale-105 transition-transform duration-500">
						<svg class="w-16 h-16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
					</div>';
				}
			}
			?>
		</a>
		
		<!-- Giá khóa học -->
		<div class="absolute top-3 right-3 bg-white/95 backdrop-blur-sm px-3 py-1 rounded-full shadow-md font-bold text-sm text-[var(--lp-primary-color)]">
			<?php 
			$price = $course->get_price_html();
			if ( $price ) {
				echo wp_kses_post( $price );
			} else {
				echo '<span class="text-green-600">Miễn phí</span>';
			}
			?>
		</div>
	</div>

	<div class="p-5 flex flex-col flex-grow">
		<!-- Tên khóa học -->
		<h3 class="text-[17px] font-heading font-bold text-gray-900 mb-3 line-clamp-2 leading-[1.4]">
			<a href="<?php echo esc_url( get_the_permalink() ); ?>" class="hover:text-primary transition-colors">
				<?php the_title(); ?>
			</a>
		</h3>

		<!-- Danh mục -->
		<div class="mb-4 text-xs font-semibold text-gray-500 uppercase tracking-wider flex items-center gap-1.5 line-clamp-1">
			<svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path></svg>
			<?php
			$terms = get_the_terms( get_the_ID(), 'course_category' );
			if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) {
				$term_names = wp_list_pluck( $terms, 'name' );
				echo esc_html( implode( ', ', $term_names ) );
			} else {
				echo 'Chung';
			}
			?>
		</div>

		<!-- Thông tin Meta -->
		<div class="flex items-center gap-4 text-[13px] font-semibold text-gray-600 mb-5 mt-auto">
			<div class="flex items-center gap-1.5" title="Số bài học">
				<svg class="w-[18px] h-[18px] text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
				<?php echo esc_html( $course->get_count_items() ); ?> Bài
			</div>
			<div class="flex items-center gap-1.5" title="Số lượng học viên">
				<svg class="w-[18px] h-[18px] text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
				<?php echo esc_html( $course->get_users_enrolled() ); ?>
			</div>
		</div>

		<!-- Nút hành động -->
		<hr class="border-gray-100 mb-4">
		<div class="flex items-center justify-between">
			<!-- Tác giả -->
			<div class="flex items-center gap-2">
				<?php echo get_avatar( get_post_field( 'post_author', get_the_ID() ), 30, '', '', array( 'class' => 'rounded-full' ) ); ?>
				<span class="text-[13px] font-semibold text-gray-700"><?php echo get_the_author(); ?></span>
			</div>
			
			<a href="<?php echo esc_url( get_the_permalink() ); ?>" class="text-[13px] font-bold text-primary hover:text-white hover:bg-primary px-3.5 py-1.5 rounded-lg border-2 border-primary transition-colors flex items-center gap-1">
				Chi tiết
				<svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
			</a>
		</div>
	</div>
</li>
