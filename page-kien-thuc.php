<?php
/**
 * Template Name: Trang Kiến Thức
 * 
 * Template hiển thị nội dung Khóa học LearnPress thuộc danh mục "Kiến thức"
 */

get_header(); ?>

<div class="bg-gray-50 py-12">
    <div class="container mx-auto px-4 max-w-7xl">
        
        <header class="mb-10 text-center">
            <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4"><?php echo esc_html( get_the_title() ); ?></h1>
            <div class="w-24 h-1 bg-yellow-400 mx-auto rounded-full"></div>
        </header>

        <div class="w-full">
            <?php
            // Lấy trang hiện tại để phân trang
            $paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;

            // Truy vấn lấy TẤT CẢ lp_course thuộc danh mục "kien-thuc"
            $args = array(
                'post_type'      => 'lp_course',
                'post_status'    => 'publish',
                'posts_per_page' => 12, // Số lượng bài muốn hiển thị
                'paged'          => $paged,
                'tax_query'      => array(
                    array(
                        'taxonomy' => 'course_category',
                        'field'    => 'slug',
                        'terms'    => 'kien-thuc', // Chú ý: Đây phải là slug của danh mục "Kiến thức" trong LearnPress
                    ),
                ),
            );

            $kien_thuc_query = new WP_Query( $args );

            if ( $kien_thuc_query->have_posts() ) :
                ?>
                <!-- Khung Lưới CSS được lấy từ Tailwind để đồng nhất với khóa học -->
                <ul class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8 py-8 w-full learn-press-courses" style="list-style: none; padding: 0; margin: 0;">
                    <?php
                    while ( $kien_thuc_query->have_posts() ) : $kien_thuc_query->the_post();
                        
                        // Lấy ảnh đại diện khóa học (hoặc fallback)
                        $image_url = get_the_post_thumbnail_url( get_the_ID(), 'full' );
                        if ( ! $image_url ) {
                            $image_url = esc_url( get_theme_mod( 'shopping_default_course_image', get_template_directory_uri() . '/assets/images/default-course.jpg' ) );
                        }
                        ?>
                        
                        <!-- Thiết kế Thẻ Giống Hệt Courses -->
                        <li id="post-<?php the_ID(); ?>" <?php post_class( 'group bg-white border border-gray-100 rounded-2xl overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 !flex !flex-col relative !w-full !h-full !p-0 !m-0 !list-none' ); ?>>
                            
                            <div class="relative overflow-hidden aspect-[4/3] bg-gray-50 border-b border-gray-100">
                                <a href="<?php echo esc_url( get_the_permalink() ); ?>" class="block w-full h-full">
                                    <img src="<?php echo esc_url( $image_url ); ?>" alt="<?php echo esc_attr( get_the_title() ); ?>" class="w-full h-full object-cover transform group-hover:scale-105 transition-transform duration-500">
                                </a>
                            </div>

                            <div class="p-6 flex flex-col flex-grow">
                                <a href="<?php echo esc_url( get_the_permalink() ); ?>" class="block mb-2">
                                    <h3 class="text-xl font-bold text-gray-900 group-hover:text-yellow-600 transition-colors line-clamp-2">
                                        <?php the_title(); ?>
                                    </h3>
                                </a>
                                
                                <div class="text-gray-600 mb-6 line-clamp-3 text-sm">
                                    <?php echo wp_trim_words( get_the_excerpt(), 20, '...' ); ?>
                                </div>
                                
                                <div class="mt-auto pt-4 border-t border-gray-100 flex items-center justify-between text-sm text-gray-500">
                                    <div class="flex items-center">
                                        <svg class="w-4 h-4 mr-1 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                        <?php echo get_the_date( 'd/m/Y' ); ?>
                                    </div>
                                    <a href="<?php echo esc_url( get_the_permalink() ); ?>" class="text-yellow-600 font-medium hover:text-yellow-700 transition-colors flex items-center group/btn">
                                        Đọc tiếp
                                        <svg class="w-4 h-4 ml-1 transform group-hover/btn:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                                    </a>
                                </div>
                            </div>
                        </li>
                    <?php endwhile; ?>
                </ul>

                <!-- Phân trang -->
                <div class="mt-12 flex justify-center">
                    <?php
                    echo paginate_links( array(
                        'total'     => $kien_thuc_query->max_num_pages,
                        'current'   => $paged,
                        'prev_text' => '&laquo; Trước',
                        'next_text' => 'Sau &raquo;',
                        'class'     => 'pagination-links flex gap-2'
                    ) );
                    ?>
                </div>

                <?php
                wp_reset_postdata();
            else :
                ?>
                <div class="text-center py-16 bg-white rounded-2xl shadow-sm border border-gray-100">
                    <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                    <h2 class="text-xl font-medium text-gray-900 mb-2">Chưa có bài viết / khóa học nào</h2>
                    <p class="text-gray-500">Mục kiến thức hiện đang trống. Xin vui lòng quay lại sau.</p>
                </div>
                <?php
            endif;
            ?>
        </div>
    </div>
</div>

<?php get_footer(); ?>
