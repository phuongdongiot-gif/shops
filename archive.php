<?php
/**
 * The template for displaying archive pages
 *
 * @package shopping
 */

get_header();
?>

<main id="primary" class="site-main container mx-auto px-4 py-6 md:py-12">

	<?php if ( have_posts() ) : ?>

		<header class="page-header mb-8 md:mb-12 text-center border-b border-gray-100 pb-6 md:pb-8">
			<?php
			the_archive_title( '<h1 class="page-title text-2xl md:text-4xl font-heading font-extrabold mb-3 md:mb-4 uppercase text-dark tracking-tight">', '</h1>' );
			the_archive_description( '<div class="archive-description text-gray-500 max-w-2xl mx-auto text-sm md:text-base">', '</div>' );
			?>
		</header>

		<!-- Top Carousel (Latest Posts of this Archive) -->
		<?php
		$queried_object = get_queried_object();
		$carousel_args = array(
			'posts_per_page'      => 5,
			'ignore_sticky_posts' => 1,
		);
		
		// Apply current archive filters to the carousel
		if ( is_category() || is_tag() || is_tax() ) {
			if (isset($queried_object->taxonomy) && isset($queried_object->term_id)) {
				$carousel_args['tax_query'] = array(
					array(
						'taxonomy' => $queried_object->taxonomy,
						'field'    => 'term_id',
						'terms'    => $queried_object->term_id,
					),
				);
			}
		} elseif ( is_author() ) {
			$carousel_args['author'] = $queried_object->ID;
		} elseif ( is_year() ) {
			$carousel_args['year'] = get_query_var('year');
		} elseif ( is_month() ) {
			$carousel_args['monthnum'] = get_query_var('monthnum');
		}

		$carousel_query = new WP_Query( $carousel_args );
		
		if ( $carousel_query->have_posts() ) :
		?>
			<div class="relative w-full mb-12 md:mb-16 overflow-hidden rounded-2xl md:rounded-3xl shadow-lg group bg-gray-900" id="archive-carousel">
				<div class="flex transition-transform duration-700 ease-out h-[350px] md:h-[500px]" id="archive-carousel-inner">
					<?php while ( $carousel_query->have_posts() ) : $carousel_query->the_post(); ?>
						<div class="w-full shrink-0 relative">
							<?php if ( has_post_thumbnail() ) : ?>
								<?php the_post_thumbnail( 'full', array( 'class' => 'w-full h-full object-cover opacity-80 mix-blend-overlay' ) ); ?>
							<?php else : ?>
								<div class="w-full h-full bg-gray-800"></div>
							<?php endif; ?>
							<div class="absolute inset-0 bg-gradient-to-t from-gray-900 via-gray-900/50 md:via-gray-900/40 to-transparent flex flex-col justify-end p-6 md:p-14">
								<?php
								$cats = get_the_category();
								if ( $cats ) {
									echo '<a href="' . esc_url( get_category_link( $cats[0]->term_id ) ) . '" class="bg-yellow-400 text-gray-900 text-[10px] md:text-xs font-bold uppercase px-2.5 py-1 md:px-3 md:py-1.5 rounded-md w-max mb-3 inline-block hover:bg-yellow-500 transition-colors">' . esc_html( $cats[0]->name ) . '</a>';
								}
								?>
								<a href="<?php the_permalink(); ?>" class="block max-w-4xl">
									<h2 class="text-2xl md:text-5xl font-extrabold text-white mb-3 md:mb-4 hover:text-yellow-400 transition-colors line-clamp-3 md:line-clamp-2 leading-snug md:leading-tight"><?php the_title(); ?></h2>
								</a>
								<div class="text-gray-300 line-clamp-2 hidden md:block max-w-3xl mb-6 text-lg">
									<?php echo wp_trim_words( wp_strip_all_tags( get_the_excerpt() ), 25, '...' ); ?>
								</div>
								<div class="text-gray-400 text-xs md:text-sm flex items-center gap-3 md:gap-4 font-medium uppercase tracking-wider">
									<span class="flex items-center gap-1 md:gap-1.5">
										<svg class="w-3.5 h-3.5 md:w-4 md:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
										<?php echo get_the_date(); ?>
									</span>
									<span class="flex items-center gap-1 md:gap-1.5">
										<svg class="w-3.5 h-3.5 md:w-4 md:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
										<?php the_author(); ?>
									</span>
								</div>
							</div>
						</div>
					<?php endwhile; wp_reset_postdata(); ?>
				</div>

				<!-- Controls -->
				<button id="archive-carousel-prev" aria-label="Previous Slide" class="hidden md:flex absolute top-1/2 left-6 -translate-y-1/2 w-12 h-12 bg-white/20 backdrop-blur-md rounded-full items-center justify-center text-white hover:bg-white hover:text-gray-900 transition-all opacity-0 group-hover:opacity-100 disabled:opacity-50 disabled:cursor-not-allowed">
					<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
				</button>
				<button id="archive-carousel-next" aria-label="Next Slide" class="hidden md:flex absolute top-1/2 right-6 -translate-y-1/2 w-12 h-12 bg-white/20 backdrop-blur-md rounded-full items-center justify-center text-white hover:bg-white hover:text-gray-900 transition-all opacity-0 group-hover:opacity-100 disabled:opacity-50 disabled:cursor-not-allowed">
					<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
				</button>
				
				<!-- Indicators -->
				<div class="absolute bottom-4 md:bottom-6 left-1/2 -translate-x-1/2 flex gap-1.5 md:gap-2" id="archive-carousel-indicators">
					<?php for($i = 0; $i < $carousel_query->post_count; $i++) { ?>
						<button aria-label="Go to slide <?php echo $i; ?>" class="w-2 h-2 md:w-2.5 md:h-2.5 rounded-full bg-white/40 hover:bg-white transition-all duration-300" data-index="<?php echo $i; ?>"></button>
					<?php } ?>
				</div>
			</div>

			<script>
				document.addEventListener('DOMContentLoaded', function() {
					const inner = document.getElementById('archive-carousel-inner');
					if(!inner) return;
					const prev = document.getElementById('archive-carousel-prev');
					const next = document.getElementById('archive-carousel-next');
					const indicators = document.querySelectorAll('#archive-carousel-indicators button');
					let currentIndex = 0;
					const total = inner.children.length;
					let interval;

					function updateIndicators() {
						indicators.forEach((btn, idx) => {
							if(idx === currentIndex) {
								btn.classList.remove('bg-white/40');
								btn.classList.add('bg-white', 'w-4', 'md:w-6');
							} else {
								btn.classList.add('bg-white/40');
								btn.classList.remove('bg-white', 'w-4', 'md:w-6');
							}
						});
					}

					function showSlide(index) {
						if (index < 0) index = total - 1;
						if (index >= total) index = 0;
						currentIndex = index;
						inner.style.transform = `translateX(-${currentIndex * 100}%)`;
						updateIndicators();
					}

					if(prev && next) {
						prev.addEventListener('click', () => { showSlide(currentIndex - 1); resetInterval(); });
						next.addEventListener('click', () => { showSlide(currentIndex + 1); resetInterval(); });
					}
					
					indicators.forEach(btn => {
						btn.addEventListener('click', (e) => {
							showSlide(parseInt(e.target.dataset.index));
							resetInterval();
						});
					});

					// Swipe support for mobile
					let startX = 0;
					let endX = 0;
					inner.addEventListener('touchstart', e => {
						startX = e.changedTouches[0].screenX;
					}, {passive: true});

					inner.addEventListener('touchend', e => {
						endX = e.changedTouches[0].screenX;
						if (startX - endX > 50) {
							showSlide(currentIndex + 1);
							resetInterval();
						} else if (endX - startX > 50) {
							showSlide(currentIndex - 1);
							resetInterval();
						}
					}, {passive: true});

					function startInterval() {
						interval = setInterval(() => { showSlide(currentIndex + 1); }, 5000);
					}
					function resetInterval() {
						clearInterval(interval);
						startInterval();
					}
					
					updateIndicators();
					startInterval();
				});
			</script>
		<?php endif; ?>

		<!-- Collapse Grouped by Categories -->
		<?php
		// Group posts in the current main query by category
		$posts_by_category = array();
		
		while ( have_posts() ) {
			the_post();
			
			$cats = get_the_category();
			$cat_id = 0;
			$cat_name = 'Tin tức khác';
			
			if ( $cats && ! empty( $cats ) ) {
				$cat_id = $cats[0]->term_id;
				$cat_name = $cats[0]->name;
			}
			
			if ( ! isset( $posts_by_category[$cat_id] ) ) {
				$posts_by_category[$cat_id] = array(
					'name' => $cat_name,
					'posts' => array()
				);
			}
			$posts_by_category[$cat_id]['posts'][] = get_post();
		}
		?>

		<div class="space-y-4 md:space-y-6" id="archive-accordion">
			<?php 
			$acc_index = 0;
			foreach ( $posts_by_category as $cat_id => $cat_data ) : 
				$is_first = ($acc_index === 0);
			?>
				<div class="border border-gray-100 rounded-2xl overflow-hidden bg-white shadow-sm transition-all duration-300 group/acc">
					<button class="w-full px-5 py-4 md:px-8 md:py-5 flex items-center justify-between bg-white hover:bg-gray-50 transition-colors focus:outline-none accordion-toggle relative" aria-expanded="<?php echo $is_first ? 'true' : 'false'; ?>">
						<div class="flex items-center gap-3">
							<span class="w-1.5 h-6 bg-yellow-400 rounded-full transition-transform duration-300 group-hover/acc:scale-y-110"></span>
							<h2 class="text-lg md:text-xl font-bold text-gray-900 text-left flex items-center gap-2">
								<?php echo esc_html( $cat_data['name'] ); ?>
								<span class="text-xs font-semibold text-gray-500 bg-gray-100 px-2 py-0.5 rounded-full border border-gray-200"><?php echo count($cat_data['posts']); ?></span>
							</h2>
						</div>
						<div class="w-8 h-8 rounded-full bg-gray-50 flex items-center justify-center border border-gray-200 shadow-sm shrink-0 transition-colors group-hover/acc:bg-white group-hover/acc:border-yellow-400">
							<svg class="w-4 h-4 text-gray-600 transform transition-transform duration-300 accordion-icon <?php echo $is_first ? 'rotate-180 text-yellow-600' : ''; ?>" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
						</div>
					</button>
					<div class="accordion-content grid transition-[grid-template-rows] duration-300 ease-out" style="<?php echo $is_first ? 'grid-template-rows: 1fr;' : 'grid-template-rows: 0fr;'; ?>">
						<div class="overflow-hidden">
							<div class="p-5 md:p-8 bg-gray-50/50 border-t border-gray-100">
								<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 md:gap-8">
									<?php
									global $post;
									foreach ( $cat_data['posts'] as $post ) {
										setup_postdata( $post );
										get_template_part( 'template-parts/content', get_post_type() );
									}
									wp_reset_postdata();
									?>
								</div>
							</div>
						</div>
					</div>
				</div>
			<?php 
			$acc_index++;
			endforeach; 
			?>
		</div>

		<script>
			document.addEventListener('DOMContentLoaded', function() {
				const toggles = document.querySelectorAll('.accordion-toggle');
				toggles.forEach(toggle => {
					toggle.addEventListener('click', function() {
						const content = this.nextElementSibling;
						const icon = this.querySelector('.accordion-icon');
						const isExpanded = this.getAttribute('aria-expanded') === 'true';

						if (isExpanded) {
							this.setAttribute('aria-expanded', 'false');
							content.style.gridTemplateRows = '0fr';
							icon.classList.remove('rotate-180', 'text-yellow-600');
						} else {
							this.setAttribute('aria-expanded', 'true');
							content.style.gridTemplateRows = '1fr';
							icon.classList.add('rotate-180', 'text-yellow-600');
						}
					});
				});
			});
		</script>

		<div class="mt-12 flex justify-center">
			<?php
			the_posts_pagination( array(
				'prev_text' => '&laquo; Trước',
				'next_text' => 'Sau &raquo;',
				'class'     => 'pagination-links flex gap-2',
			) );
			?>
		</div>

	<?php else :

		get_template_part( 'template-parts/content', 'none' );

	endif;
	?>

</main><!-- #main -->

<?php
get_footer();
