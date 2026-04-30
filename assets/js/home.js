/**
 * HOME PAGE SCRIPTS (Trang chủ)
 * Tối ưu load bằng cách nhét tất cả script vào một file duy nhất
 */

document.addEventListener('DOMContentLoaded', function () {
    // 1. Khởi tạo Category Carousel Swiper
    if (document.querySelector('.categorySwiper') && typeof Swiper !== 'undefined') {
        new Swiper('.categorySwiper', {
            slidesPerView: 2,
            spaceBetween: 16,
            loop: false,
            autoplay: {
                delay: 4000,
                disableOnInteraction: false,
            },
            pagination: {
                el: '.category-swiper-pagination',
                clickable: true,
            },
            breakpoints: {
                480: { slidesPerView: 3, spaceBetween: 16 },
                768: { slidesPerView: 4, spaceBetween: 24 },
                1024: { slidesPerView: 5, spaceBetween: 24 },
                1280: { slidesPerView: 6, spaceBetween: 30 },
            }
        });
    }

    // 2. Khởi tạo Hero Swiper (Banner Chính)
    if (document.querySelector('.heroSwiper') && typeof Swiper !== 'undefined') {
        new Swiper('.heroSwiper', {
            loop: true,
            autoplay: {
                delay: 5000,
                disableOnInteraction: false,
            },
            pagination: {
                el: '.swiper-pagination',
                clickable: true,
            },
            effect: 'fade',
            fadeEffect: {
                crossFade: true
            }
        });
    }

    // 3. Khởi tạo Testimonial Swiper
    if (document.querySelector('.testimonialSwiper') && typeof Swiper !== 'undefined') {
        new Swiper('.testimonialSwiper', {
            loop: true,
            effect: 'fade',
            fadeEffect: { crossFade: true },
            autoplay: { delay: 6000, disableOnInteraction: false },
            navigation: { nextEl: '.testi-next', prevEl: '.testi-prev' },
        });
    }
});

// Hàm gập mở danh mục sản phẩm (Responsive CSS Grid)
function toggleCategoryCollapse(id, el) {
    const content = document.getElementById(id);
    const icon = el.querySelector('.toggle-icon svg');

    if (!content || !icon) return;

    // Kích hoạt class để chạy animation thuần CSS
    if (content.classList.contains('is-collapsed')) {
        content.classList.remove('is-collapsed');
        icon.style.transform = 'rotate(0deg)';
    } else {
        content.classList.add('is-collapsed');
        icon.style.transform = 'rotate(-90deg)';
    }
}
