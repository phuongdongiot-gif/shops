<?php
/**
 * Template for displaying thumbnail of single course.
 *
 * This template can be overridden by copying it to yourtheme/learnpress/single-course/thumbnail.php.
 */

defined( 'ABSPATH' ) || exit();

$course = learn_press_get_course();
if ( ! $course ) {
	return;
}

$course_id = $course->get_id();
$image_url = shopping_get_bypass_thumbnail_url( $course_id );
?>

<div class="course-thumbnail mb-8 rounded-2xl overflow-hidden shadow-lg border border-gray-100 bg-gray-50 aspect-video relative">
	<?php if ( $image_url ) : ?>
		<img src="<?php echo esc_url( $image_url ); ?>" alt="<?php echo esc_attr( get_the_title() ); ?>" class="w-full h-full object-cover">
	<?php else : ?>
		<!-- Ảnh mặc định nếu không truy xuất được từ DB -->
		<div class="w-full h-full flex flex-col items-center justify-center text-gray-400 bg-gray-100">
			<svg class="w-20 h-20 mb-3 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
		</div>
	<?php endif; ?>
</div>
