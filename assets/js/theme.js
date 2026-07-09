(function ($) {
  "use strict";

  var $window = $(window);

  /**
   * Kiểm tra plugin jQuery có tồn tại hay không.
   * Dùng để tránh lỗi khi thư viện chưa được load trên một số trang.
   *
   * Ví dụ:
   * hasPlugin("magnificPopup")
   * hasPlugin("counterUp")
   */
  function hasPlugin(name) {
    return typeof $.fn[name] !== "undefined";
  }

  /**
   * Kiểm tra màn hình mobile theo breakpoint 768px.
   * Dùng cho các xử lý riêng trên mobile.
   */
  function isMobile() {
    return window.matchMedia("(max-width: 768px)").matches;
  }

  /**
   * Ẩn preloader.
   * Có gọi cả khi window load và fallback bằng setTimeout
   * để tránh trường hợp preloader bị treo.
   */
  function hidePreloader() {
    $(".preloader").stop(true, true).fadeOut(600);
  }

  /**
   * Khởi tạo các xử lý UI dùng chung toàn site.
   *
   * Bao gồm:
   * - Gắn text cho custom cursor.
   * - Thêm class reveal cho ảnh cần animation.
   * - Thêm class image-anime cho ảnh bài viết.
   * - Thêm animation cho header.
   * - Dọn class thừa do Flatsome/UX Builder sinh ra.
   */
  function initCommonUI() {
    $(".data-cursor-text-play").attr("data-cursor-text", "Play");
    $(".data-cursor-opaque").attr("data-cursor", "-opaque");

    $(".image-anime.image-reveal").addClass("reveal");
    $(".post .entry-image").addClass("image-anime");
    $("#header").addClass("wow fadeInDown");

    $(".stack.swiper-wrapper").attr("class", "swiper-wrapper");
    $(".stack.img-box10").attr("class", "img-box10");
    $(".stack").removeClass("stack stack-row justify-start items-stretch");
  }

  /**
   * Chuyển class delay của WOW thành attribute data-wow-delay.
   *
   * Ví dụ:
   * data-wow-delay-02 => data-wow-delay="0.2s"
   * data-wow-delay-03 => data-wow-delay="0.3s"
   * data-wow-delay-1  => data-wow-delay="1s"
   *
   * Trên mobile sẽ xóa delay ở section chỉ định
   * để tránh animation bị chậm hoặc rối layout.
   */
  function initWowDelayClass() {
    if (isMobile()) {
      $(".section-1782062925676").removeClass(function (index, className) {
        return (className.match(/\bdata-wow-delay\S*/g) || []).join(" ");
      });
      return;
    }

    $('[class*="data-wow-delay-"]').each(function () {
      var className = this.className.match(/data-wow-delay-(\d+)/);

      if (!className) return;

      var value = className[1];
      var delay = value.startsWith("0")
        ? "0." + value.slice(1) + "s"
        : value + "s";

      $(this).attr("data-wow-delay", delay);
    });
  }

  /**
   * Tự động tạo data-filter từ aria-controls của Flatsome tab.
   *
   * Ví dụ:
   * aria-controls="tab_.architecture" => data-filter=".architecture"
   * aria-controls="tab_*"             => data-filter="*"
   *
   * Dùng cho filter Isotope.
   */
  function initTabFilterAttribute() {
    $('[aria-controls^="tab_"]').each(function () {
      var match = $(this)
        .attr("aria-controls")
        .match(/^tab_(.+)/);

      if (!match) return;

      $(this).attr("data-filter", match[1]);
    });
  }

  /**
   * Xử lý sticky header.
   *
   * Bao gồm:
   * - Set chiều cao cho header chính để layout không bị giật.
   * - Thêm class hide khi scroll qua header.
   * - Thêm class active khi header bắt đầu sticky.
   */
  function initStickyHeader() {
    if (!$("header .header-sticky").length) return;

    function setHeaderHeight() {
      $("header.main-header").css(
        "height",
        $("header .header-sticky").outerHeight(),
      );
    }

    $window.on("resize", setHeaderHeight);

    $window.on("scroll", function () {
      var fromTop = $window.scrollTop();
      var headerHeight;

      setHeaderHeight();
      headerHeight = $("header .header-sticky").outerHeight();

      $("header .header-sticky").toggleClass(
        "hide",
        fromTop > headerHeight + 100,
      );
      $("header .header-sticky").toggleClass("active", fromTop > headerHeight);
    });
  }

  /**
   * Xử lý nút back to top.
   * Áp dụng cho link có href="#top".
   */
  function initBackToTop() {
    if (!$('a[href="#top"]').length) return;

    $(document).on("click", 'a[href="#top"]', function () {
      $("html, body").animate({ scrollTop: 0 }, "slow");
      return false;
    });
  }

  /**
   * Khởi tạo hero slider.
   * Dùng cho section có class .hero-slider-layout.
   */
  function initHeroSlider() {
    if (
      !$(".hero-slider-layout .swiper").length ||
      typeof Swiper === "undefined"
    ) {
      return;
    }

    new Swiper(".hero-slider-layout .swiper", {
      slidesPerView: 1,
      speed: 1000,
      spaceBetween: 0,
      loop: true,
      autoplay: {
        delay: 4000,
      },
      pagination: {
        el: ".hero-pagination",
        clickable: true,
      },
    });
  }

  /**
   * Khởi tạo slider logo đối tác / client logo.
   */
  function initHowWorkCompanySlider() {
    if (
      !$(".how-work-company-slider").length ||
      typeof Swiper === "undefined"
    ) {
      return;
    }

    new Swiper(".how-work-company-slider .swiper", {
      slidesPerView: 2,
      speed: 2000,
      spaceBetween: 30,
      loop: true,
      autoplay: {
        delay: 3000,
      },
      breakpoints: {
        768: {
          slidesPerView: 4,
        },
        991: {
          slidesPerView: 5,
        },
      },
    });
  }

  /**
   * Khởi tạo testimonial slider chung.
   * Đồng thời thêm data-cursor-text="Drag" cho swiper-wrapper.
   */
  function initTestimonialSlider() {
    if (!$(".testimonial-slider").length || typeof Swiper === "undefined") {
      return;
    }

    $(".testimonial-slider.swiper")
      .find(".swiper-wrapper")
      .attr("data-cursor-text", "Drag");

    $(".testimonial-slider.swiper .icon-box-1781348601568")
      .find(".icon-inner")
      .addClass("image-anime");

    new Swiper(".testimonial-slider.swiper", {
      slidesPerView: 1,
      speed: 1000,
      spaceBetween: 60,
      loop: true,
      autoplay: {
        delay: 5000,
      },
      breakpoints: {
        768: {
          slidesPerView: 1,
        },
        991: {
          slidesPerView: 1,
        },
      },
    });
  }

  /**
   * Khởi tạo slider client / logo khách hàng.
   */
  function initOurClientSlider() {
    if (!$(".our-client-slider").length || typeof Swiper === "undefined") {
      return;
    }

    new Swiper(".our-client-slider .swiper", {
      slidesPerView: 2,
      speed: 1000,
      spaceBetween: 60,
      loop: true,
      autoplay: {
        delay: 5000,
      },
      breakpoints: {
        768: {
          slidesPerView: 4,
        },
        991: {
          slidesPerView: 4,
        },
      },
    });
  }

  /**
   * Khởi tạo slider quy trình.
   * Dùng navigation custom: .procedure-button-next / .procedure-button-prev.
   */
  function initProcedureSwiper() {
    if (!$(".procedure-swiper").length || typeof Swiper === "undefined") {
      return;
    }

    new Swiper(".procedure-swiper.swiper", {
      allowTouchMove: false,
      slideToClickedSlide: false,
      slidesPerView: "auto",
      loop: true,
      navigation: {
        nextEl: ".procedure-button-next",
        prevEl: ".procedure-button-prev",
      },
      breakpoints: {
        0: {
          slidesPerView: 1,
          slidesPerGroup: 1,
          centeredSlides: false,
          spaceBetween: 16,
        },
        768: {
          slidesPerView: "auto",
          centeredSlides: false,
          spaceBetween: 20,
        },
        1024: {
          slidesPerView: "auto",
          centeredSlides: false,
          spaceBetween: 26,
        },
      },
    });
  }

  /**
   * Khởi tạo skill bar.
   * Lấy phần trăm từ .skill-no rồi animate width của .count-bar.
   */
  function initSkillbar() {
    $(".skillbar").each(function () {
      var $skillbar = $(this);
      var percentText = $skillbar.find(".skill-no").first().text().trim();
      var match = percentText.match(/\d+%/);
      var percent;

      if (!match) return;

      percent = match[0];
      $skillbar.attr("data-percent", percent);
      $skillbar.find(".count-bar").animate({ width: percent }, 2000);
    });
  }

  /**
   * Khởi tạo video background bằng YTPlayer.
   */
  function initYoutubeBackground() {
    if (!$("#herovideo").length || !hasPlugin("YTPlayer")) return;

    $("#herovideo").YTPlayer();
  }

  /**
   * Khởi tạo counter number.
   */
  function initCounter() {
    if (!$(".counter").length || !hasPlugin("counterUp")) return;

    $(".counter").counterUp({ delay: 5, time: 2000 });
  }

  /**
   * Khởi tạo hiệu ứng reveal ảnh bằng GSAP + ScrollTrigger.
   *
   * Yêu cầu:
   * - Có class .reveal.
   * - Trong .reveal có thẻ img.
   * - Đã load gsap và ScrollTrigger.
   */
  function initImageRevealAnimation() {
    if (
      !$(".reveal").length ||
      typeof gsap === "undefined" ||
      typeof ScrollTrigger === "undefined"
    ) {
      return;
    }

    gsap.registerPlugin(ScrollTrigger);

    document.querySelectorAll(".reveal").forEach(function (container) {
      var image = container.querySelector("img");
      var tl;

      if (!image) return;

      tl = gsap.timeline({
        scrollTrigger: {
          trigger: container,
          toggleActions: "play none none none",
        },
      });

      tl.set(container, { autoAlpha: 1 });

      tl.from(container, 1, {
        xPercent: -100,
        ease: Power2.out,
      });

      tl.from(image, 1, {
        xPercent: 100,
        scale: 1,
        delay: -1,
        ease: Power2.out,
      });
    });
  }

  /**
   * Text animation style 1.
   * Tách chữ bằng SplitText và animate theo words.
   */
  function initTextAnimationStyle1() {
    if (
      !$(".text-anime-style-1").length ||
      typeof gsap === "undefined" ||
      typeof SplitText === "undefined"
    ) {
      return;
    }

    document
      .querySelectorAll(".text-anime-style-1")
      .forEach(function (element) {
        var animationSplitText = new SplitText(element, {
          type: "chars, words",
        });

        gsap.from(animationSplitText.words, {
          duration: 1,
          delay: 0.5,
          x: 20,
          autoAlpha: 0,
          stagger: 0.05,
          scrollTrigger: {
            trigger: element,
            start: "top 85%",
          },
        });
      });
  }

  /**
   * Text animation style 2.
   * Tách chữ bằng SplitText và animate theo từng ký tự.
   */
  function initTextAnimationStyle2() {
    if (
      !$(".text-anime-style-2").length ||
      typeof gsap === "undefined" ||
      typeof SplitText === "undefined"
    ) {
      return;
    }

    document
      .querySelectorAll(".text-anime-style-2")
      .forEach(function (element) {
        var animationSplitText = new SplitText(element, {
          type: "chars, words",
        });

        gsap.from(animationSplitText.chars, {
          duration: 1,
          delay: 0.1,
          x: 20,
          autoAlpha: 0,
          stagger: 0.03,
          ease: "power2.out",
          scrollTrigger: {
            trigger: element,
            start: "top 85%",
          },
        });
      });
  }

  /**
   * Text animation style 3.
   * Tách text thành lines, words, chars rồi animate từng ký tự.
   */
  function initTextAnimationStyle3() {
    if (
      !$(".text-anime-style-3").length ||
      typeof gsap === "undefined" ||
      typeof SplitText === "undefined"
    ) {
      return;
    }

    document
      .querySelectorAll(".text-anime-style-3")
      .forEach(function (element) {
        if (element.animation) {
          element.animation.progress(1).kill();
          element.split.revert();
        }

        element.split = new SplitText(element, {
          type: "lines,words,chars",
          linesClass: "split-line",
        });

        gsap.set(element, { perspective: 400 });

        gsap.set(element.split.chars, {
          opacity: 0,
          x: "50",
        });

        element.animation = gsap.to(element.split.chars, {
          scrollTrigger: {
            trigger: element,
            start: "top 90%",
          },
          x: "0",
          y: "0",
          rotateX: "0",
          opacity: 1,
          duration: 1,
          ease: Back.easeOut,
          stagger: 0.02,
        });
      });
  }

  /**
   * Lấy ảnh nền từ .section-bg img của Flatsome
   * rồi gắn thành background-image cho section .parallaxie.
   *
   * Dùng để xử lý trường hợp host/local render background khác nhau.
   */
  function initParallaxSectionBackground() {
    $(".section.parallaxie").each(function () {
      var $section = $(this);
      var imgSrc = $section.find(".section-bg img").attr("src");

      if (!imgSrc) return;

      $section.css({
        backgroundImage:
          "linear-gradient(to right, rgba(0, 0, 0, 0.95) 0%, rgba(0, 0, 0, 0.75) 20%, rgba(0, 0, 0, 0.3) 35%, rgba(0, 0, 0, 0) 100%), " +
          "linear-gradient(to top, rgba(12, 12, 14, 0.95) 0%, rgba(12, 12, 14, 0.4) 17%, rgba(0, 0, 0, 0) 40%), " +
          "url('" +
          imgSrc +
          "')",
      });
    });
  }

  /**
   * Khởi tạo popup gallery ảnh bằng Magnific Popup.
   */
  function initGalleryPopup() {
    if (!$(".gallery-items").length || !hasPlugin("magnificPopup")) return;

    $(".gallery-items").magnificPopup({
      delegate: "a",
      type: "image",
      closeOnContentClick: false,
      closeBtnInside: false,
      mainClass: "mfp-with-zoom",
      image: {
        verticalFit: true,
      },
      gallery: {
        enabled: true,
      },
      zoom: {
        enabled: true,
        duration: 300,
        opener: function (element) {
          return element.find("img");
        },
      },
    });
  }

  /**
   * Khởi tạo filter project bằng Isotope.
   *
   * Dùng:
   * - .project-item-boxes là container.
   * - .project-item-box là item.
   * - .our-Project-nav li a là nút filter.
   */
  function initProjectFilter() {
    if (!$(".project-item-boxes").length || !hasPlugin("isotope")) return;

    var $menuitem = $(".project-item-boxes").isotope({
      itemSelector: ".project-item-box",
      layoutMode: "masonry",
      masonry: {
        columnWidth: 1,
      },
    });

    var $menudisesnav = $(".our-Project-nav li a");

    $(".our-Project-nav li.active a").addClass("active-btn");

    $menudisesnav.on("click", function (e) {
      var filterValue = $(this).attr("data-filter");

      $menuitem.isotope({ filter: filterValue });

      $menudisesnav.removeClass("active-btn");
      $(this).addClass("active-btn");

      e.preventDefault();
    });

    $menuitem.isotope({ filter: "*" });
  }

  /**
   * Khởi tạo WOW animation.
   */
  function initWow() {
    if (typeof WOW === "undefined") return;

    new WOW().init();
  }

  /**
   * Khởi tạo popup video iframe bằng Magnific Popup.
   *
   * Cấu trúc:
   * .popup-video
   *   a[href="youtube-url"]
   */
  function initPopupVideo() {
    if (!hasPlugin("magnificPopup")) return;

    $(".popup-video").each(function () {
      var $wrap = $(this);
      var $link = $wrap.find("a[href]").first();

      if (!$link.length) return;

      $link.magnificPopup({
        type: "iframe",
        mainClass: "mfp-fade",
        removalDelay: 160,
        preloader: false,
        fixedContentPos: true,
      });
    });
  }

  /**
   * Khởi tạo swiper bác sĩ ở trang chủ.
   * Scope theo section .row-1778944461520 để tránh ảnh hưởng swiper khác.
   */
  function initDoctorHomeSwiper() {
    var $doctorSectionHome = $(".row-1778944461520");

    if (
      !$doctorSectionHome.length ||
      !$doctorSectionHome.find(".doctor-swiper").length ||
      typeof Swiper === "undefined"
    ) {
      return;
    }

    new Swiper($doctorSectionHome.find(".doctor-swiper")[0], {
      slidesPerView: 1,
      spaceBetween: 20,
      grabCursor: true,
      speed: 450,
      navigation: {
        prevEl: $doctorSectionHome.find("button").eq(0)[0],
        nextEl: $doctorSectionHome.find("button").eq(1)[0],
      },
      breakpoints: {
        640: {
          slidesPerView: 2,
          spaceBetween: 20,
        },
        768: {
          slidesPerView: 3,
          spaceBetween: 20,
        },
        1024: {
          slidesPerView: 5,
          spaceBetween: 20,
        },
      },
      observer: true,
      observeParents: true,
      resizeObserver: true,
      watchOverflow: true,
    });
  }

  /**
   * Khởi tạo testimonial swiper ở trang chủ.
   * Scope theo section .row-1779014766554.
   */
  function initTestimonialHomeSwiper() {
    var $testimonialSectionHome = $(".row-1779014766554");

    if (
      !$testimonialSectionHome.length ||
      !$testimonialSectionHome.find(".testimonial-swiper").length ||
      typeof Swiper === "undefined"
    ) {
      return;
    }

    new Swiper($testimonialSectionHome.find(".testimonial-swiper")[0], {
      slidesPerView: 1,
      spaceBetween: 24,
      loop: true,
      watchOverflow: true,
      autoplay: {
        delay: 3500,
        disableOnInteraction: false,
        pauseOnMouseEnter: true,
      },
      pagination: {
        el: ".testimonial-pagination",
        clickable: true,
      },
      breakpoints: {
        768: {
          slidesPerView: 2,
          spaceBetween: 24,
        },
        1024: {
          slidesPerView: 3,
          spaceBetween: 28,
        },
      },
    });
  }

  /**
   * Khởi tạo swiper danh sách bác sĩ dạng grid.
   * Dùng class .doctor-grid.swiper.
   */
  function initDoctorGridSwiper() {
    var $doctorGridSection = $(".row-1779004873583");

    if (
      !$doctorGridSection.length ||
      !$(".doctor-grid.swiper").length ||
      typeof Swiper === "undefined"
    ) {
      return;
    }

    new Swiper(".doctor-grid.swiper", {
      loop: true,
      speed: 600,
      spaceBetween: 20,
      slidesPerView: 1,
      navigation: {
        prevEl: ".doctor-prev",
        nextEl: ".doctor-next",
      },
      breakpoints: {
        640: {
          slidesPerView: 2,
          spaceBetween: 20,
        },
        1024: {
          slidesPerView: 5,
          spaceBetween: 20,
        },
      },
    });
  }

  /**
   * Khởi tạo testimonial list swiper cho section cụ thể.
   * Có kiểm tra .swiper-initialized để tránh init trùng.
   */
  function initSectionTestimonialListSwiper() {
    var $testimonialSwiperEl = $(".section-1782561049285 .testimonial-list");

    if (
      !$testimonialSwiperEl.length ||
      typeof Swiper === "undefined" ||
      $testimonialSwiperEl.hasClass("swiper-initialized")
    ) {
      return;
    }

    new Swiper($testimonialSwiperEl[0], {
      slidesPerView: 1,
      slidesPerGroup: 1,
      spaceBetween: 18,
      speed: 650,
      loop: false,
      autoplay: false,
      watchOverflow: false,
      observer: true,
      observeParents: true,
      resizeObserver: true,
      pagination: {
        el: ".section-1782561049285 .testimonial-pagination",
        clickable: true,
      },
      breakpoints: {
        768: {
          slidesPerView: 2,
          slidesPerGroup: 1,
          spaceBetween: 22,
        },
        1025: {
          slidesPerView: 4,
          slidesPerGroup: 1,
          spaceBetween: 24,
        },
      },
    });
  }

  /**
   * Khởi tạo FAQ accordion.
   *
   * Khi click một câu hỏi:
   * - Đóng các item khác trong cùng .faq-list.
   * - Toggle item hiện tại.
   */
  function initFaqAccordion() {
    $(".section-1782563529147 .faq-question").on("click", function () {
      var $button = $(this);
      var $item = $button.closest(".faq-item");
      var $list = $button.closest(".faq-list");

      if (!$item.length || !$list.length) return;

      $list.find(".faq-item").not($item).removeClass("is-active");
      $item.toggleClass("is-active");
    });
  }

  /**
   * ==============================
   * RUN INIT
   * ==============================
   */

  $window.on("load", hidePreloader);
  setTimeout(hidePreloader, 300);

  /**
   * Các function có thể chạy ngay.
   */
  initCommonUI();
  initWowDelayClass();
  initTabFilterAttribute();
  initStickyHeader();
  initBackToTop();
  initHeroSlider();
  initHowWorkCompanySlider();
  initTestimonialSlider();
  initOurClientSlider();
  initProcedureSwiper();
  initSkillbar();
  initYoutubeBackground();
  initCounter();
  initImageRevealAnimation();
  initTextAnimationStyle1();
  initTextAnimationStyle2();
  initTextAnimationStyle3();
  initParallaxSectionBackground();
  initGalleryPopup();
  initWow();
  initPopupVideo();

  /**
   * Isotope nên chạy sau khi window load
   * để ảnh/layout đã có kích thước đầy đủ.
   */
  $window.on("load", initProjectFilter);

  /**
   * Các function liên quan DOM section cụ thể.
   * Chạy sau khi DOM ready.
   */
  $(function () {
    initDoctorHomeSwiper();
    initTestimonialHomeSwiper();
    initDoctorGridSwiper();
    initSectionTestimonialListSwiper();
    initFaqAccordion();
  });
})(jQuery);
