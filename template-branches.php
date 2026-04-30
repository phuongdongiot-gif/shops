<?php
/**
 * Template Name: Hệ Thống Chi Nhánh
 *
 * Hiển thị danh sách các chi nhánh dưới dạng lưới thẻ
 */

get_header();
?>

<div class="bg-gray-50/50 min-h-screen py-10 lg:py-16">
    <div class="container mx-auto px-6 max-w-6xl">
        
        <header class="mb-12 text-center">
            <h1 class="text-3xl lg:text-4xl font-heading font-bold text-dark uppercase tracking-wide">
                Hệ Thống Chi Nhánh
            </h1>
            <p class="text-gray-500 mt-3 text-lg">Tìm chi nhánh gần bạn nhất để được hỗ trợ trực tiếp</p>
            <div class="w-16 h-1.5 bg-primary mt-5 mx-auto rounded-full"></div>
        </header>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-8 lg:gap-10">
            <?php
            // Lấy danh sách các bài đăng trong CPT Branch
            $branch_query = new WP_Query(array(
                'post_type'      => 'branch',
                'posts_per_page' => -1,
                'orderby'        => 'menu_order title',
                'order'          => 'ASC',
            ));

            if ( $branch_query->have_posts() ) :
                while ( $branch_query->have_posts() ) : $branch_query->the_post();
                    // Lấy ra các trường tùy chỉnh (Custom Meta)
                    $address = get_post_meta( get_the_ID(), '_branch_address', true );
                    $phone   = get_post_meta( get_the_ID(), '_branch_phone', true );
                    $email   = get_post_meta( get_the_ID(), '_branch_email', true );
                    $iframe  = get_post_meta( get_the_ID(), '_branch_map_iframe', true );
                    ?>
                    <div class="bg-white rounded-2xl shadow-[0_10px_40px_rgb(0,0,0,0.06)] border border-gray-100 overflow-hidden flex flex-col hover:-translate-y-1 transition-transform duration-300">
                        
                        <!-- Header thẻ: Tên Chi Nhánh & Icon -->
                        <div class="p-6 lg:p-8 flex-1 bg-white">
                            <h2 class="text-xl font-bold font-heading text-primary mb-5 uppercase tracking-wide flex items-center gap-2">
                                <svg class="w-6 h-6 flex-shrink-0 text-primary" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5a2.5 2.5 0 010-5 2.5 2.5 0 010 5z"/></svg>
                                <?php the_title(); ?>
                            </h2>
                            
                            <!-- Thông tin liên hệ -->
                            <div class="space-y-4 text-[15px] text-gray-600">
                                <?php if ( $address ) : ?>
                                    <div class="flex items-start gap-3">
                                        <svg class="w-5 h-5 mt-0.5 text-gray-400 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                        <span><strong class="text-dark">Địa chỉ:</strong> <?php echo esc_html( $address ); ?></span>
                                    </div>
                                <?php endif; ?>
                                
                                <?php if ( $phone ) : ?>
                                    <div class="flex items-start gap-3">
                                        <svg class="w-5 h-5 mt-0.5 text-gray-400 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                                        <span><strong class="text-dark">Hotline:</strong> <a href="tel:<?php echo esc_attr( str_replace(array(' ','.'), '', $phone) ); ?>" class="text-primary hover:underline font-bold"><?php echo esc_html( $phone ); ?></a></span>
                                    </div>
                                <?php endif; ?>

                                <?php if ( $email ) : ?>
                                    <div class="flex items-start gap-3">
                                        <svg class="w-5 h-5 mt-0.5 text-gray-400 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                                        <span><strong class="text-dark">Email:</strong> <a href="mailto:<?php echo esc_attr( $email ); ?>" class="text-primary hover:underline font-bold"><?php echo esc_html( $email ); ?></a></span>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>

                        <!-- Khu vực Bản đồ -->
                        <?php if ( $iframe ) : ?>
                            <div class="branch-map-container h-[260px] w-full bg-gray-100 border-t border-gray-100 relative">
                                <?php echo $iframe; // Cho phép HTML Iframe hiển thị ở đây ?>
                            </div>
                        <?php else: ?>
                            <!-- Fallback nếu không có bản đồ -->
                            <div class="h-[260px] w-full bg-gray-100 border-t border-gray-100 flex items-center justify-center text-gray-400 flex-col gap-2">
                                <svg class="w-10 h-10 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9.5a2.5 2.5 0 00-2.5-2.5H15M9 11l3 3L22 4"></path></svg>
                                <span class="font-medium text-sm">Bản đồ đang cập nhật</span>
                            </div>
                        <?php endif; ?>
                    </div>
                    <?php
                endwhile;
                wp_reset_postdata();
            else :
                ?>
                <!-- Empty State -->
                <div class="col-span-full text-center py-20 bg-white rounded-2xl shadow-[0_4px_20px_rgb(0,0,0,0.02)] border border-gray-100">
                    <svg class="w-20 h-20 text-gray-200 mx-auto mb-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path></svg>
                    <h3 class="text-xl font-bold text-gray-700 mb-2">Hệ thống đang cập nhật</h3>
                    <p class="text-gray-500">Danh sách các chi nhánh sẽ được quản trị viên cập nhật sớm nhất.</p>
                </div>
                <?php
            endif;
            ?>
        </div>
        
    </div>
</div>

<style>
/* Ép Iframe bản đồ (dù lớn tuỳ ý) vào khít bo viền 100% của khung */
.branch-map-container iframe { 
    width: 100% !important; 
    height: 100% !important; 
    border: none !important; 
    display: block; 
}
</style>

<?php get_footer(); ?>
