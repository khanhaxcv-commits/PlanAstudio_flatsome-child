(function ($) {
  "use strict";

  var $window = $(window);
  var $body = $("body");

  /* Preloader Effect */
  $window.on("load", function () {
    $(".preloader").fadeOut(600);
  });

  /* Add cursor text to custom elements */
  // $(".data-cursor-text-view").attr("data-cursor-text", "View");
  $(".data-cursor-text-play").attr("data-cursor-text", "Play");
  $(".data-cursor-opaque").attr("data-cursor", "-opaque");

  /**
   * Add reveal class to elements that have both image-anime and image-reveal classes.
   */
  $(".image-anime.image-reveal").addClass("reveal");
  $(".post .entry-image").addClass("image-anime");
  $("#header ").addClass("wow fadeInDown");

  /**
   * Dọn dẹp class: Chỉ giữ lại class swiper-wrapper và xóa tất cả các class bổ trợ khác
   */
  $(".stack.swiper-wrapper").attr("class", "swiper-wrapper");
  $(".stack.img-box10").attr("class", "img-box10");

  /**
   * Convert WOW delay utility class to data-wow-delay attribute.
   *
   * Example:
   * data-wow-delay-02 => data-wow-delay="0.2s"
   * data-wow-delay-03 => data-wow-delay="0.3s"
   * data-wow-delay-1  => data-wow-delay="1s"
   * data-wow-delay-2  => data-wow-delay="2s"
   */
  $('[class*="data-wow-delay-"]').each(function () {
    if (window.matchMedia("(max-width: 768px)").matches) {
      $(".section-1782062925676").removeClass(function (index, className) {
        return (className.match(/\bdata-wow-delay\S*/g) || []).join(" ");
      });
      return;
    }
    var className = this.className.match(/data-wow-delay-(\d+)/);
    console.log("className:", className);

    if (!className) return;

    var value = className[1];
    var delay = value.startsWith("0")
      ? "0." + value.slice(1) + "s"
      : value + "s";

    $(this).attr("data-wow-delay", delay);
  });

  /**
   * Auto-assign data-filter attribute from Flatsome tab aria-controls
   *
   * Usage in HTML:
   *   <a aria-controls="tab_.architecture">  →  <a data-filter=".architecture">
   *   <a aria-controls="tab_*">              →  <a data-filter="*">
   */
  $('[aria-controls^="tab_"]').each(function () {
    var match = $(this)
      .attr("aria-controls")
      .match(/^tab_(.+)/);

    if (!match) return;

    $(this).attr("data-filter", match[1]);
  });

  /* Sticky Header */
  if ($("header .header-sticky").length) {
    $window.on("resize", function () {
      setHeaderHeight();
    });

    function setHeaderHeight() {
      $("header.main-header").css(
        "height",
        $("header .header-sticky").outerHeight(),
      );
    }

    $window.on("scroll", function () {
      var fromTop = $(window).scrollTop();
      setHeaderHeight();
      var headerHeight = $("header .header-sticky").outerHeight();
      $("header .header-sticky").toggleClass(
        "hide",
        fromTop > headerHeight + 100,
      );
      $("header .header-sticky").toggleClass("active", fromTop > headerHeight);
    });
  }

  /* Slick Menu JS */
  //   $("#menu").slicknav({
  //     label: "",
  //     prependTo: ".responsive-menu",
  //   });

  if ($("a[href='#top']").length) {
    $(document).on("click", "a[href='#top']", function () {
      $("html, body").animate({ scrollTop: 0 }, "slow");
      return false;
    });
  }

  /* Hero Slider Layout JS */
  const hero_slider_layout = new Swiper(".hero-slider-layout .swiper", {
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

  /* How We Work Client Logo Slider JS */
  if ($(".how-work-company-slider").length) {
    const how_work_company_slider = new Swiper(
      ".how-work-company-slider .swiper",
      {
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
      },
    );
  }

  /* testimonial Slider JS */
  if ($(".testimonial-slider").length) {
    // Dùng jQuery tìm thẻ .swiper-wrapper bên trong và thêm thuộc tính data-cursor-text
    $(".testimonial-slider.swiper")
      .find(".swiper-wrapper")
      .attr("data-cursor-text", "Drag");
    $(".testimonial-slider.swiper .icon-box-1781348601568")
      .find(".icon-inner")
      .addClass("image-anime");

    const testimonial_slider = new Swiper(".testimonial-slider.swiper", {
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

  /* testimonial Slider JS */
  if ($(".our-client-slider").length) {
    const testimonial_slider = new Swiper(".our-client-slider .swiper", {
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
   * Skill Bar
   * Lấy phần trăm từ .skill-no và animate .count-bar.
   */
  $(".skillbar").each(function () {
    var $skillbar = $(this);
    var percentText = $skillbar.find(".skill-no").first().text().trim();
    var match = percentText.match(/\d+%/);

    if (!match) return;

    var percent = match[0];

    $skillbar.attr("data-percent", percent);

    $skillbar.find(".count-bar").animate(
      {
        width: percent,
      },
      2000,
    );
  });

  /* Youtube Background Video JS */
  if ($("#herovideo").length) {
    var myPlayer = $("#herovideo").YTPlayer();
  }

  /* Init Counter */
  if ($(".counter").length) {
    $(".counter").counterUp({ delay: 5, time: 2000 });
  }

  /* Image Reveal Animation */
  if ($(".reveal").length) {
    gsap.registerPlugin(ScrollTrigger);
    let revealContainers = document.querySelectorAll(".reveal");
    revealContainers.forEach((container) => {
      let image = container.querySelector("img");
      let tl = gsap.timeline({
        scrollTrigger: {
          trigger: container,
          toggleActions: "play none none none",
        },
      });
      tl.set(container, {
        autoAlpha: 1,
      });
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

  /* Text Effect Animation */
  if ($(".text-anime-style-1").length) {
    let staggerAmount = 0.05,
      translateXValue = 0,
      delayValue = 0.5,
      animatedTextElements = document.querySelectorAll(".text-anime-style-1");

    animatedTextElements.forEach((element) => {
      let animationSplitText = new SplitText(element, { type: "chars, words" });
      gsap.from(animationSplitText.words, {
        duration: 1,
        delay: delayValue,
        x: 20,
        autoAlpha: 0,
        stagger: staggerAmount,
        scrollTrigger: { trigger: element, start: "top 85%" },
      });
    });
  }

  if ($(".text-anime-style-2").length) {
    let staggerAmount = 0.03,
      translateXValue = 20,
      delayValue = 0.1,
      easeType = "power2.out",
      animatedTextElements = document.querySelectorAll(".text-anime-style-2");

    animatedTextElements.forEach((element) => {
      let animationSplitText = new SplitText(element, { type: "chars, words" });
      gsap.from(animationSplitText.chars, {
        duration: 1,
        delay: delayValue,
        x: translateXValue,
        autoAlpha: 0,
        stagger: staggerAmount,
        ease: easeType,
        scrollTrigger: { trigger: element, start: "top 85%" },
      });
    });
  }

  if ($(".text-anime-style-3").length) {
    let animatedTextElements = document.querySelectorAll(".text-anime-style-3");

    animatedTextElements.forEach((element) => {
      //Reset if needed
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
        scrollTrigger: { trigger: element, start: "top 90%" },
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

  /* Parallaxie js */
  // var $parallaxie = $(".parallaxie");
  // $parallaxie.parallaxie({
  //   speed: 0.55,
  //   offset: 0,
  // });

  $(".section.parallaxie").each(function () {
    var $section = $(this);
    var imgSrc = $section.find(".section-bg img").attr("src");

    if (imgSrc) {
      $section.css({
        backgroundImage: `linear-gradient(to right, rgba(0, 0, 0, 0.95) 0%, rgba(0, 0, 0, 0.75) 20%, rgba(0, 0, 0, 0.3) 35%, rgba(0, 0, 0, 0) 100%), linear-gradient(to top, rgba(12, 12, 14, 0.95) 0%, rgba(12, 12, 14, 0.4) 17%, rgba(0, 0, 0, 0) 40%), url('${imgSrc}')`,
      });
    }
  });

  /* Zoom Gallery screenshot */
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
      duration: 300, // don't foget to change the duration also in CSS
      opener: function (element) {
        return element.find("img");
      },
    },
  });

  /* Contact form validation */
  //   var $contactform = $("#contactForm");
  //   $contactform.validator({ focus: false }).on("submit", function (event) {
  //     if (!event.isDefaultPrevented()) {
  //       event.preventDefault();
  //       submitForm();
  //     }
  //   });

  //   function submitForm() {
  //     /* Ajax call to submit form */
  //     $.ajax({
  //       type: "POST",
  //       url: "form-process.php",
  //       data: $contactform.serialize(),
  //       success: function (text) {
  //         if (text === "success") {
  //           formSuccess();
  //         } else {
  //           submitMSG(false, text);
  //         }
  //       },
  //     });
  //   }

  //   function formSuccess() {
  //     $contactform[0].reset();
  //     submitMSG(true, "Message Sent Successfully!");
  //   }

  //   function submitMSG(valid, msg) {
  //     if (valid) {
  //       var msgClasses = "h4 text-success";
  //     } else {
  //       var msgClasses = "h4 text-danger";
  //     }
  //     $("#msgSubmit").removeClass().addClass(msgClasses).text(msg);
  //   }
  /* Contact form validation end */

  /* Our Project (filtering) Start */
  $window.on("load", function () {
    if ($(".project-item-boxes").length) {
      /* Init Isotope */
      var $menuitem = $(".project-item-boxes").isotope({
        itemSelector: ".project-item-box",
        layoutMode: "masonry",
        masonry: {
          // use outer width of grid-sizer for columnWidth
          columnWidth: 1,
        },
      });

      /* Set active-btn on first active tab's <a> */
      $(".our-Project-nav li.active a").addClass("active-btn");

      /* Filter items on click */
      var $menudisesnav = $(".our-Project-nav li a");
      $menudisesnav.on("click", function (e) {
        var filterValue = $(this).attr("data-filter");
        $menuitem.isotope({
          filter: filterValue,
        });

        $menudisesnav.removeClass("active-btn");
        $(this).addClass("active-btn");
        e.preventDefault();
      });
      $menuitem.isotope({ filter: "*" });
    }
  });
  /* Our Project (filtering) End */

  /* Animated Wow Js */
  new WOW().init();

  /* Popup Video */
  // if ($(".popup-video").length) {
  //   $(".popup-video").magnificPopup({
  //     type: "iframe",
  //     mainClass: "mfp-fade",
  //     removalDelay: 160,
  //     preloader: false,
  //     fixedContentPos: true,
  //   });
  // }
  $(".popup-video").each(function () {
    var $wrap = $(this);
    var $link = $wrap.find("a[href]").first();

    if (!$link.length || !$.fn.magnificPopup) return;

    $link.magnificPopup({
      type: "iframe",
      mainClass: "mfp-fade",
      removalDelay: 160,
      preloader: false,
      fixedContentPos: true,
    });
  });
})(jQuery);
