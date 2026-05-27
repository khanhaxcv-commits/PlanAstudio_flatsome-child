<?php

/**
 * Front Page Template
 * File: wp-content/themes/flatsome-child/front-page.php
 */

if (! defined('ABSPATH')) {
    exit;
}

get_header();
?>

<main id="main" class="plana-home bg-[#f7f4ef] text-[#2B2B2B]">

    <!-- Hero Section -->
    <section class="relative min-h-[780px] overflow-hidden bg-[#2B2B2B]">
        <div class="absolute inset-0">
            <img
                src="https://images.unsplash.com/photo-1600585154340-be6161a56a0c"
                alt="Modern interior design"
                class="h-full w-full object-cover opacity-55">
            <div class="absolute inset-0 bg-gradient-to-r from-[#2B2B2B]/90 via-[#2B2B2B]/65 to-[#2B2B2B]/20"></div>
        </div>

        <div class="relative z-10 mx-auto flex min-h-[780px] w-full max-w-[1400px] items-center px-5">
            <div class="max-w-[760px]">
                <span class="mb-5 inline-flex rounded-full border border-white/20 bg-white/10 px-5 py-2 text-sm font-medium uppercase tracking-[0.25em] text-[#D7B46A] backdrop-blur">
                    inspired interiors
                    Designing your dream spaces, one room at a time
                </span>

                <h1 class="mb-7 text-[44px] font-semibold leading-[1.05] tracking-[-0.04em] text-white md:text-[72px] lg:text-[88px]">
                    Thiết kế nội thất hiện đại cho không gian sống tinh tế
                </h1>

                <p class="mb-9 max-w-[580px] text-lg leading-8 text-white/80">
                    inspired interiors
                    Designing your dream spaces, one room at a time
                </p>

                <div class="flex flex-wrap gap-4">
                    <a href="#services" class="inline-flex h-14 items-center justify-center rounded-full bg-[#D7B46A] px-8 text-base font-semibold text-[#2B2B2B] transition hover:bg-white">
                        Xem dịch vụ
                    </a>

                    <a href="#contact" class="inline-flex h-14 items-center justify-center rounded-full border border-white/35 px-8 text-base font-semibold text-white transition hover:bg-white hover:text-[#2B2B2B]">
                        Nhận tư vấn
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Intro Section -->
    <section class="bg-[#f7f4ef] py-24">
        <div class="mx-auto grid w-full max-w-[1400px] gap-12 px-5 lg:grid-cols-[0.9fr_1.1fr] lg:items-end">
            <div>
                <span class="mb-4 inline-block text-sm font-semibold uppercase tracking-[0.22em] text-[#B89555]">
                    Về chúng tôi
                </span>

                <h2 class="text-[36px] font-semibold leading-tight tracking-[-0.03em] text-[#2B2B2B] md:text-[56px]">
                    Không gian đẹp bắt đầu từ sự thấu hiểu nhu cầu sống
                </h2>
            </div>

            <div class="max-w-[660px] lg:ml-auto">
                <p class="text-lg leading-8 text-[#5f5b55]">
                    Mỗi dự án được phát triển dựa trên thói quen sinh hoạt, gu thẩm mỹ, ngân sách và mục tiêu sử dụng thực tế. Chúng tôi không chỉ tạo ra một bản thiết kế đẹp mà còn xây dựng một không gian sống có chiều sâu, dễ dùng và bền vững theo thời gian.
                </p>
            </div>
        </div>
    </section>

    <!-- Services Section -->
    <section id="services" class="bg-white py-24">
        <div class="mx-auto w-full max-w-[1400px] px-5">
            <div class="mb-14 max-w-[760px]">
                <span class="mb-4 inline-block text-sm font-semibold uppercase tracking-[0.22em] text-[#B89555]">
                    Dịch vụ
                </span>

                <h2 class="mb-5 text-[36px] font-semibold leading-tight tracking-[-0.03em] text-[#2B2B2B] md:text-[56px]">
                    Giải pháp thiết kế nội thất theo từng loại không gian
                </h2>

                <p class="text-lg leading-8 text-[#666]">
                    Từ căn hộ, nhà phố đến biệt thự, mỗi không gian đều được định hướng theo công năng, vật liệu, ánh sáng và phong cách riêng.
                </p>
            </div>

            <div class="grid gap-6 md:grid-cols-3">
                <article class="group rounded-[32px] bg-[#f7f4ef] p-8 transition duration-300 hover:-translate-y-2 hover:shadow-2xl">
                    <div class="mb-8 h-[260px] overflow-hidden rounded-[24px]">
                        <img
                            src="https://images.unsplash.com/photo-1618221195710-dd6b41faaea6"
                            alt="Thiết kế căn hộ"
                            class="h-full w-full object-cover transition duration-500 group-hover:scale-105">
                    </div>

                    <h3 class="mb-4 text-2xl font-semibold text-[#2B2B2B]">
                        Thiết kế căn hộ
                    </h3>

                    <p class="leading-7 text-[#666]">
                        Tối ưu diện tích, ánh sáng và công năng để căn hộ trở nên thoáng, tiện nghi và có gu hơn.
                    </p>
                </article>

                <article class="group rounded-[32px] bg-[#f7f4ef] p-8 transition duration-300 hover:-translate-y-2 hover:shadow-2xl">
                    <div class="mb-8 h-[260px] overflow-hidden rounded-[24px]">
                        <img
                            src="https://images.unsplash.com/photo-1600607687939-ce8a6c25118c"
                            alt="Thiết kế nhà phố"
                            class="h-full w-full object-cover transition duration-500 group-hover:scale-105">
                    </div>

                    <h3 class="mb-4 text-2xl font-semibold text-[#2B2B2B]">
                        Thiết kế nhà phố
                    </h3>

                    <p class="leading-7 text-[#666]">
                        Xây dựng bố cục sống hợp lý cho gia đình, cân bằng giữa riêng tư, sinh hoạt chung và thẩm mỹ.
                    </p>
                </article>

                <article class="group rounded-[32px] bg-[#f7f4ef] p-8 transition duration-300 hover:-translate-y-2 hover:shadow-2xl">
                    <div class="mb-8 h-[260px] overflow-hidden rounded-[24px]">
                        <img
                            src="https://images.unsplash.com/photo-1600566753190-17f0baa2a6c3"
                            alt="Thiết kế biệt thự"
                            class="h-full w-full object-cover transition duration-500 group-hover:scale-105">
                    </div>

                    <h3 class="mb-4 text-2xl font-semibold text-[#2B2B2B]">
                        Thiết kế biệt thự
                    </h3>

                    <p class="leading-7 text-[#666]">
                        Kết hợp vật liệu cao cấp, bố cục sang trọng và ngôn ngữ thiết kế tinh tế cho không gian lớn.
                    </p>
                </article>
            </div>
        </div>
    </section>

    <!-- Project Highlight -->
    <section class="bg-[#2B2B2B] py-24 text-white">
        <div class="mx-auto grid w-full max-w-[1400px] gap-12 px-5 lg:grid-cols-2 lg:items-center">
            <div class="overflow-hidden rounded-[36px]">
                <img
                    src="https://images.unsplash.com/photo-1600210492486-724fe5c67fb0"
                    alt="Dự án nội thất nổi bật"
                    class="h-full min-h-[520px] w-full object-cover">
            </div>

            <div class="lg:pl-10">
                <span class="mb-4 inline-block text-sm font-semibold uppercase tracking-[0.22em] text-[#D7B46A]">
                    Dự án nổi bật
                </span>

                <h2 class="mb-6 text-[36px] font-semibold leading-tight tracking-[-0.03em] text-white md:text-[56px]">
                    Modern Luxury Apartment
                </h2>

                <p class="mb-8 text-lg leading-8 text-white/75">
                    Không gian căn hộ được xử lý theo tinh thần hiện đại, sang trọng nhưng vẫn ấm áp. Từng chi tiết từ ánh sáng, vật liệu, đồ rời đến đường nét trần tường đều được cân nhắc để tạo nên trải nghiệm sống liền mạch.
                </p>

                <div class="grid gap-5 sm:grid-cols-3">
                    <div>
                        <div class="text-4xl font-semibold text-[#D7B46A]">120m²</div>
                        <p class="mt-2 text-sm text-white/60">Diện tích</p>
                    </div>

                    <div>
                        <div class="text-4xl font-semibold text-[#D7B46A]">3</div>
                        <p class="mt-2 text-sm text-white/60">Phòng ngủ</p>
                    </div>

                    <div>
                        <div class="text-4xl font-semibold text-[#D7B46A]">45</div>
                        <p class="mt-2 text-sm text-white/60">Ngày hoàn thiện</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact CTA -->
    <section id="contact" class="bg-[#f7f4ef] py-24">
        <div class="mx-auto w-full max-w-[1400px] px-5">
            <div class="rounded-[40px] bg-white p-8 shadow-xl md:p-14 lg:p-16">
                <div class="grid gap-10 lg:grid-cols-[1.1fr_0.9fr] lg:items-center">
                    <div>
                        <span class="mb-4 inline-block text-sm font-semibold uppercase tracking-[0.22em] text-[#B89555]">
                            Liên hệ tư vấn
                        </span>

                        <h2 class="mb-5 text-[34px] font-semibold leading-tight tracking-[-0.03em] text-[#2B2B2B] md:text-[52px]">
                            Sẵn sàng bắt đầu không gian mới của bạn?
                        </h2>

                        <p class="text-lg leading-8 text-[#666]">
                            Hãy chia sẻ nhu cầu, diện tích và phong cách bạn mong muốn. Chúng tôi sẽ tư vấn hướng triển khai phù hợp nhất.
                        </p>
                    </div>

                    <div class="flex flex-col gap-4 rounded-[28px] bg-[#2B2B2B] p-7 text-white">
                        <a href="tel:0900000000" class="rounded-full bg-[#D7B46A] px-7 py-4 text-center font-semibold text-[#2B2B2B] transition hover:bg-white">
                            Gọi tư vấn ngay
                        </a>

                        <a href="#" class="rounded-full border border-white/25 px-7 py-4 text-center font-semibold text-white transition hover:bg-white hover:text-[#2B2B2B]">
                            Xem hồ sơ năng lực
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

</main>

<?php
get_footer();
