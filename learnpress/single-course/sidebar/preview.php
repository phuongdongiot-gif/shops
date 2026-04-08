<?php
/**
 * @author  ThimPress
 * @package LearnPress/Templates
 * @version 4.0.1
 */

defined( 'ABSPATH' ) || exit;

$course = learn_press_get_course();
$course_id = $course ? $course->get_id() : get_the_ID();
$image_url = shopping_get_bypass_thumbnail_url( $course_id );
?>

<div class="course-sidebar-preview">
	<div class="media-preview">
		<?php if ( $image_url ) : ?>
			<img src="<?php echo esc_url( $image_url ); ?>" alt="<?php echo esc_attr( get_the_title() ); ?>" class="w-full h-auto object-cover rounded-lg shadow-sm">
		<?php else : ?>
			<!-- Fallback LearnPress preview -->
			<?php LearnPress::instance()->template( 'course' )->course_media_preview(); ?>
		<?php endif; ?>
		
		<?php learn_press_get_template( 'loop/course/badge-featured' ); ?>
	</div>

	<?php
	// Price box.
	LearnPress::instance()->template( 'course' )->course_pricing();

	// Graduation.
	LearnPress::instance()->template( 'course' )->course_graduation();

	// Buttons.
	LearnPress::instance()->template( 'course' )->course_buttons();

	LearnPress::instance()->template( 'course' )->user_time();

	LearnPress::instance()->template( 'course' )->user_progress();
	?>
</div>
