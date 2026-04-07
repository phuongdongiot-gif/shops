<?php
/**
 * The template for displaying comments
 *
 * @package shopping
 */

if ( post_password_required() ) {
	return;
}
?>

<div id="comments" class="comments-area mt-12 pt-8 border-t border-gray-200">

	<?php
	if ( have_comments() ) :
		?>
		<h2 class="comments-title text-2xl font-bold mb-6">
			<?php
			$shopping_comment_count = get_comments_number();
			if ( '1' === $shopping_comment_count ) {
				printf(
					/* translators: 1: title. */
					esc_html__( 'One thought on &ldquo;%1$s&rdquo;', 'shopping' ),
					'<span>' . wp_kses_post( get_the_title() ) . '</span>'
				);
			} else {
				printf( 
					/* translators: 1: comment count number, 2: title. */
					esc_html( _nx( '%1$s thought on &ldquo;%2$s&rdquo;', '%1$s thoughts on &ldquo;%2$s&rdquo;', $shopping_comment_count, 'comments title', 'shopping' ) ),
					number_format_i18n( $shopping_comment_count ),
					'<span>' . wp_kses_post( get_the_title() ) . '</span>'
				);
			}
			?>
		</h2><!-- .comments-title -->

		<?php the_comments_navigation(); ?>

		<ol class="comment-list list-none pl-0">
			<?php
			wp_list_comments(
				array(
					'style'      => 'ol',
					'short_ping' => true,
					'avatar_size'=> 60,
				)
			);
			?>
		</ol><!-- .comment-list -->

		<?php
		the_comments_navigation();

		// If comments are closed and there are comments, let's leave a little note, shall we?
		if ( ! comments_open() ) :
			?>
			<p class="no-comments text-gray-500 italic mt-4"><?php esc_html_e( 'Comments are closed.', 'shopping' ); ?></p>
			<?php
		endif;

	endif; // Check for have_comments().

	comment_form(
		array(
			'class_submit'  => 'submit bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded cursor-pointer',
			'class_form'    => 'comment-form flex flex-col gap-4 max-w-2xl',
		)
	);
	?>

</div><!-- #comments -->
