<?php
/**
 * The template for displaying all single posts
 *
 * @package shopping
 */

get_header();
?>

<main id="primary" class="site-main container mx-auto px-4 py-4 md:py-6 lg:py-10">
	<div class="flex flex-col lg:flex-row gap-5 lg:gap-8">
		
		<!-- Cột Nội dung chính -->
		<div class="lg:w-2/3 xl:w-[72%]">
			<?php
			while ( have_posts() ) :
				the_post();

				get_template_part( 'template-parts/content', get_post_type() );

				$prev_post = get_previous_post();
				$next_post = get_next_post();
				if ( $prev_post || $next_post ) :
				?>
				<div class="post-navigation border-t border-gray-100 pt-8 mt-8 mb-8">
					<div class="flex flex-col sm:flex-row gap-4 justify-between">
						<?php if ( $prev_post ) : ?>
						<a href="<?php echo get_permalink( $prev_post->ID ); ?>" class="group flex-1 p-4 rounded-2xl border border-gray-100 hover:border-primary/30 hover:shadow-lg hover:shadow-primary/5 transition-all duration-300 bg-white flex flex-col items-start text-left">
							<span class="flex items-center gap-2 text-sm text-gray-400 font-medium mb-2 group-hover:text-primary transition-colors">
								<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
								<?php esc_html_e( 'Bài trước', 'shopping' ); ?>
							</span>
							<h4 class="font-bold text-gray-800 line-clamp-2 group-hover:text-primary transition-colors"><?php echo get_the_title( $prev_post->ID ); ?></h4>
						</a>
						<?php else : ?>
						<div class="flex-1"></div>
						<?php endif; ?>

						<?php if ( $next_post ) : ?>
						<a href="<?php echo get_permalink( $next_post->ID ); ?>" class="group flex-1 p-4 rounded-2xl border border-gray-100 hover:border-primary/30 hover:shadow-lg hover:shadow-primary/5 transition-all duration-300 bg-white flex flex-col items-end text-right">
							<span class="flex items-center gap-2 text-sm text-gray-400 font-medium mb-2 group-hover:text-primary transition-colors">
								<?php esc_html_e( 'Bài sau', 'shopping' ); ?>
								<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
							</span>
							<h4 class="font-bold text-gray-800 line-clamp-2 group-hover:text-primary transition-colors"><?php echo get_the_title( $next_post->ID ); ?></h4>
						</a>
						<?php else : ?>
						<div class="flex-1"></div>
						<?php endif; ?>
					</div>
				</div>
				<?php 
				endif;

				// Carousel Bài Viết Mới Nhất (Chỉ Mobile)
				?>
				<div class="mt-8 mb-8 lg:hidden">
					<h3 class="text-lg font-heading font-bold text-dark mb-4 flex items-center gap-2 uppercase tracking-wide border-b border-gray-100 pb-2">
						<svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path></svg>
						Bài viết mới nhất
					</h3>
					
					<div class="flex overflow-x-auto snap-x snap-mandatory gap-4 pb-4 -mx-4 px-4 scrollbar-hide">
						<?php
						$latest_args = array(
							'post_type'      => 'post',
							'posts_per_page' => 6,
							'post__not_in'   => array( get_the_ID() ),
							'ignore_sticky_posts' => 1
						);
						$latest_query = new WP_Query( $latest_args );
						
						if( $latest_query->have_posts() ) {
							while( $latest_query->have_posts() ) {
								$latest_query->the_post();
								?>
								<article class="snap-start shrink-0 w-[260px] bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden group">
									<a href="<?php the_permalink(); ?>" class="block h-[150px] relative overflow-hidden">
										<?php if ( has_post_thumbnail() ) : ?>
											<?php the_post_thumbnail( 'medium', array( 'class' => 'w-full h-full object-cover group-hover:scale-110 transition-transform duration-500' ) ); ?>
										<?php else: ?>
											<div class="w-full h-full bg-gray-100 flex items-center justify-center">
												<svg class="w-8 h-8 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
											</div>
										<?php endif; ?>
										<div class="absolute inset-0 bg-black/5 group-hover:bg-transparent transition-colors"></div>
									</a>
									<div class="p-4">
										<h4 class="font-semibold text-sm leading-snug mb-2">
											<a href="<?php the_permalink(); ?>" class="text-gray-800 hover:text-primary transition-colors line-clamp-2">
												<?php the_title(); ?>
											</a>
										</h4>
										<div class="text-[12px] text-gray-400 font-medium flex items-center gap-1">
											<svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
											<?php echo get_the_date(); ?>
										</div>
									</div>
								</article>
								<?php
							}
							wp_reset_postdata();
						} else {
							echo '<p class="text-sm text-gray-500 italic">Không có bài viết nào.</p>';
						}
						?>
					</div>
				</div>
				<?php



			endwhile; // End of the loop.
			?>
		</div>

		<!-- Cột Tin Tức Liên Quan (Sidebar) -->
		<aside class="lg:w-1/3 xl:w-[28%]">
			<div class="sticky top-28">
				<div class="bg-white rounded-xl p-4 md:p-5 border border-gray-100 shadow-sm">
					<h3 class="text-base md:text-lg font-heading font-bold text-dark mb-4 md:mb-5 flex items-center gap-2 uppercase tracking-wide border-b border-gray-100 pb-2 md:pb-3">
						<svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path></svg>
						Tin tức liên quan
					</h3>
					
					<div class="space-y-4 md:space-y-6">
						<?php
						$categories = get_the_category();
						if ( $categories ) {
							$category_ids = array();
							foreach( $categories as $individual_category ) {
								$category_ids[] = $individual_category->term_id;
							}
							
							$args = array(
								'category__in'     => $category_ids,
								'post__not_in'     => array( get_the_ID() ),
								'posts_per_page'   => 5, // Hiển thị 5 bài
								'ignore_sticky_posts' => 1
							);
							
							$related_query = new WP_Query( $args );
							
							if( $related_query->have_posts() ) {
								while( $related_query->have_posts() ) {
									$related_query->the_post();
									?>
									<article class="group flex gap-3 items-start">
										<a href="<?php the_permalink(); ?>" class="shrink-0 w-20 h-20 rounded-lg overflow-hidden shadow-sm relative">
											<?php if ( has_post_thumbnail() ) : ?>
												<?php the_post_thumbnail( 'thumbnail', array( 'class' => 'w-full h-full object-cover group-hover:scale-110 transition-transform duration-500' ) ); ?>
											<?php else: ?>
												<div class="w-full h-full bg-gray-200 flex items-center justify-center">
													<svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
												</div>
											<?php endif; ?>
											<div class="absolute inset-0 bg-black/5 group-hover:bg-transparent transition-colors"></div>
										</a>
										<div class="flex-1 min-w-0">
											<h4 class="font-semibold text-sm leading-snug mb-1.5">
												<a href="<?php the_permalink(); ?>" class="text-gray-800 hover:text-primary transition-colors line-clamp-2">
													<?php the_title(); ?>
												</a>
											</h4>
											<div class="text-[12px] text-gray-400 font-medium flex items-center gap-1">
												<svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
												<?php echo get_the_date(); ?>
											</div>
										</div>
									</article>
									<?php
								}
								wp_reset_postdata();
							} else {
								echo '<p class="text-sm text-gray-500 italic">Không có tin tức liên quan nào.</p>';
							}
						}
						?>
					</div>
				</div>
			</div>
		</aside>

	</div>
</main><!-- #main -->

<?php
get_footer();
