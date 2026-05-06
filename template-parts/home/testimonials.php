<?php
// Template Part: Testimonials & Brands (Trang chủ)
?>
<section class="testimonials-brands py-8 mb-10 lg:mb-16">
    <!-- Cấu trúc Flex-col tạo div cực lớn (Full width) -->
    <div class="flex flex-col gap-10">

        <!-- Brands Marquee (Div lớn 1) -->
        <div
            class="brands-section flex flex-col justify-center bg-[#f8fafc] p-8 md:p-12 rounded-[2rem] border border-gray-200/50 overflow-hidden shadow-[inset_0_2px_10px_rgb(0,0,0,0.02)]">
            <h3
                class="text-[14px] font-bold text-gray-400 uppercase tracking-widest mb-10 text-center flex items-center justify-center gap-6">
                <span class="w-16 h-px bg-gray-200"></span>
                ĐỐI TÁC TIÊU BIỂU
                <span class="w-16 h-px bg-gray-200"></span>
            </h3>
            <div class="relative w-full overflow-hidden flex items-center h-24">

                <div class="slider-track">
                    <?php
                    $brand_query = new WP_Query(array(
                        'post_type' => 'shopping_partner',
                        'posts_per_page' => -1,
                        'tax_query' => array(
                            array(
                                'taxonomy' => 'partner_group',
                                'field' => 'slug',
                                'terms' => array('doi-tac', 'brand', 'partner'),
                            )
                        )
                    ));

                    if ($brand_query->have_posts()) {
                        // Nối chuỗi để loop mượt
                        $brands_html = '';
                        while ($brand_query->have_posts()) {
                            $brand_query->the_post();
                            if (has_post_thumbnail()) {
                                $img_url = get_the_post_thumbnail_url(get_the_ID(), 'full');
                                $brands_html .= '<div class="slide-logo"><img src="' . esc_url($img_url) . '" alt="' . esc_attr(get_the_title()) . '"></div>';
                            }
                        }
                        wp_reset_postdata();
                        echo $brands_html . $brands_html; // Gấp đôi để animation loop liên tục
                    } else {
                        // Hiển thị nội dung Mẫu (Demo) nếu Quản trị viện chưa thêm bài viết
                        $logos = [
                            'https://upload.wikimedia.org/wikipedia/commons/a/a9/Amazon_logo.svg',
                            'https://upload.wikimedia.org/wikipedia/commons/2/2f/Google_2015_logo.svg',
                            'https://upload.wikimedia.org/wikipedia/commons/f/fa/Apple_logo_black.svg',
                            'https://upload.wikimedia.org/wikipedia/commons/4/44/Microsoft_logo.svg',
                            'https://upload.wikimedia.org/wikipedia/commons/0/08/Cisco_logo_blue_2016.svg'
                        ];
                        $logos = array_merge($logos, $logos);
                        foreach ($logos as $logo) {
                            echo '<div class="slide-logo"><img src="' . esc_url($logo) . '" alt="Brand Partner Default"></div>';
                        }
                    }
                    ?>
                </div>
            </div>
        </div>

        <!-- Testimonials Swiper (Div lớn 2) -->
        <div
            class="testimonials-wrapper bg-white border border-gray-100 shadow-[0_15px_50px_rgb(0,0,0,0.06)] p-10 md:p-14 rounded-[2rem] relative">
            <svg class="absolute top-8 left-10 w-20 h-20 text-primary/10" fill="currentColor"
                viewBox="0 0 32 32">
                <path
                    d="M10.3 9.4c-3 0-5.4 2.4-5.4 5.4s2.4 5.4 5.4 5.4c.5 0 1-.1 1.4-.2-.5 2.1-2.4 3.7-4.6 3.7-.6 0-1.2-.2-1.7-.5-.4-.3-1-.2-1.3.2-.3.4-.2 1 .2 1.3.8.5 1.7.8 2.7.8 3.5 0 6.4-2.8 6.4-6.4 0-3.5-1.5-6.6-4.1-8.5-1-.7-2.1-1.2-3.3-1.2zM24.3 9.4c-3 0-5.4 2.4-5.4 5.4s2.4 5.4 5.4 5.4c.5 0 1-.1 1.4-.2-.5 2.1-2.4 3.7-4.6 3.7-.6 0-1.2-.2-1.7-.5-.4-.3-1-.2-1.3.2-.3.4-.2 1 .2 1.3.8.5 1.7.8 2.7.8 3.5 0 6.4-2.8 6.4-6.4 0-3.5-1.5-6.6-4.1-8.5-1-.7-2.1-1.2-3.3-1.2z" />
            </svg>

            <div class="swiper testimonialSwiper h-full">
                <div class="swiper-wrapper">
                    <?php
                    $testi_query = new WP_Query(array(
                        'post_type' => 'shopping_partner',
                        'posts_per_page' => 10,
                        'tax_query' => array(
                            array(
                                'taxonomy' => 'partner_group',
                                'field' => 'slug',
                                'terms' => array('khach-hang', 'testimonial', 'review'),
                            )
                        )
                    ));

                    if ($testi_query->have_posts()):
                        while ($testi_query->have_posts()):
                            $testi_query->the_post();
                            $role = get_the_excerpt(); // Sử dụng tóm tắt làm chức vụ
                            $avatar = has_post_thumbnail() ? get_the_post_thumbnail_url(get_the_ID(), 'thumbnail') : '';
                            $name_letter = mb_substr(get_the_title(), 0, 1, 'UTF-8');
                            ?>
                            <div class="swiper-slide cursor-grab">
                                <div
                                    class="text-gray-700 font-medium italic leading-relaxed text-[18px] md:text-[22px] relative z-10 pt-6 pl-6 mb-10 line-clamp-4">
                                    "<?php echo wp_strip_all_tags(get_the_content()); ?>"</div>
                                <div class="flex items-center gap-5 border-t border-gray-100 pt-8 mt-auto">
                                    <?php if ($avatar): ?>
                                        <img src="<?php echo esc_url($avatar); ?>"
                                            class="w-14 h-14 rounded-full object-cover shadow-md" alt="">
                                    <?php else: ?>
                                        <div
                                            class="w-14 h-14 rounded-full bg-primary flex items-center justify-center text-white font-bold text-xl shadow-md">
                                            <?php echo esc_html($name_letter); ?>
                                        </div>
                                    <?php endif; ?>
                                    <div>
                                        <h4 class="font-bold text-dark text-[17px]"><?php the_title(); ?></h4>
                                        <?php if ($role): ?>
                                            <p class="text-[14px] text-gray-500 font-medium mt-1">
                                                <?php echo esc_html($role); ?>
                                            </p><?php endif; ?>
                                    </div>
                                </div>
                            </div>
                            <?php
                        endwhile;
                        wp_reset_postdata();
                    else:
                        ?>
                        <!-- Placeholder Review 1 -->
                        <div class="swiper-slide cursor-grab">
                            <p
                                class="text-gray-700 font-medium italic leading-relaxed text-[18px] md:text-[22px] relative z-10 pt-6 pl-6 mb-10 line-clamp-4">
                                "Chất lượng sản phẩm hóa chất rất ổn định, đáp ứng được tiêu chuẩn sản xuất
                                khắt
                                khe của hệ thống máy móc bên tôi. Giao hàng cực kỳ nhanh chóng."</p>
                            <div class="flex items-center gap-5 border-t border-gray-100 pt-8 mt-auto">
                                <div
                                    class="w-14 h-14 rounded-full bg-[#ea580c] flex items-center justify-center text-white font-bold text-xl shadow-md">
                                    A</div>
                                <div>
                                    <h4 class="font-bold text-dark text-[17px]">
                                        <?php echo esc_html__('Anh Tuấn Khang', 'shopping'); ?>
                                    </h4>
                                    <p class="text-[14px] text-gray-500 font-medium mt-1">
                                        <?php echo esc_html__('Giám đốc Kỹ thuật, TĐ Hòa Phát', 'shopping'); ?>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <!-- Placeholder Review 2 -->
                        <div class="swiper-slide cursor-grab">
                            <p
                                class="text-gray-700 font-medium italic leading-relaxed text-[18px] md:text-[22px] relative z-10 pt-6 pl-6 mb-10 line-clamp-4">
                                "Chúng tôi hợp tác ở đây được 3 năm. Chính sách chiết khấu rất tốt cho khách
                                hàng sỉ. Đội ngũ tư vấn nắm cực kỳ vững chuyên môn ngành."</p>
                            <div class="flex items-center gap-5 border-t border-gray-100 pt-8 mt-auto">
                                <div
                                    class="w-14 h-14 rounded-full bg-[#2563eb] flex items-center justify-center text-white font-bold text-xl shadow-md">
                                    M</div>
                                <div>
                                    <h4 class="font-bold text-dark text-[17px]">
                                        <?php echo esc_html__('Chị Minh Ngọc', 'shopping'); ?>
                                    </h4>
                                    <p class="text-[14px] text-gray-500 font-medium mt-1">
                                        <?php echo esc_html__('Trưởng phòng Mua hàng, ABC JSC', 'shopping'); ?>
                                    </p>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
                <!-- Controls -->
                <div class="absolute bottom-6 right-8 flex gap-3 z-20 hidden md:flex">
                    <button
                        class="testi-prev w-12 h-12 rounded-full border-2 border-gray-100 flex items-center justify-center text-gray-400 hover:text-white hover:bg-primary hover:border-primary transition-all"><svg
                            class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 19l-7-7 7-7"></path>
                        </svg></button>
                    <button
                        class="testi-next w-12 h-12 rounded-full border-2 border-gray-100 flex items-center justify-center text-gray-400 hover:text-white hover:bg-primary hover:border-primary transition-all"><svg
                            class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 5l7 7-7 7"></path>
                        </svg></button>
                </div>
            </div>
        </div>
    </div>
</section>
