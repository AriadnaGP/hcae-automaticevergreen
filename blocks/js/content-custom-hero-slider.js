jQuery(document).ready(function ($) {
  var $sliderFor = $(".slider-block .slider-for");
  var $sliderNav = $(".slider-block .slider-nav");

  $sliderFor.slick({
    slidesToShow: 1,
    slidesToScroll: 1,
    arrows: false,
    fade: true,
    asNavFor: ".slider-nav",
    mobileFirst: true,
    adaptiveHeight: true,
    lazyLoad: "ondemand",
    responsive: [
      {
        breakpoint: 1024,
        settings: {
          adaptiveHeight: false,
        },
      },
    ],
  });

  $sliderNav.slick({
    mobileFirst: true,
    slidesToShow: 1,
    slidesToScroll: 1,
    asNavFor: ".slider-for",
    focusOnSelect: true,
    centerMode: true,
    arrows: false,
    lazyLoad: "ondemand",

    responsive: [
      {
        breakpoint: 669,
        settings: {
          dots: false,
          arrows: false,
          slidesToShow: 2,
        },
      },
      {
        breakpoint: 1023,
        settings: {
          arrows: false,
          dots: false,
          slidesToShow: 4,
        },
      },
    ],
  });

  if ($(window).width() <= 1023) {
    // Event handler to move the .slick-current and .slick-active classes to the next item in the navigation carousel on mobile
    $sliderFor.on("afterChange", function (event, slick, currentSlide) {
      var $currentSlide = $sliderNav.find(
        ".slick-slide[data-slick-index='" + currentSlide + "']"
      );
      var $nextSlide = $currentSlide.next();

      if ($nextSlide.length === 0) {
        $nextSlide = $sliderNav.find(".slick-slide").first().show();
      }
      $sliderNav.find(".slick-slide").first().hide();
      $currentSlide.removeClass("slick-current slick-active");
      // $nextSlide.addClass("slick-current");
    });

    // Trigger the initial afterChange event to set the classes correctly
    var initialSlide = $sliderFor.slick("slickCurrentSlide");
    $sliderFor.trigger("afterChange", [null, initialSlide]);
  }

  $(document).ready(function () {
    // Check if the element is in the viewport
    function isElementInViewport(el) {
      var rect = el.getBoundingClientRect();
      return (
        rect.bottom >= 0 &&
        rect.right >= 0 &&
        rect.top <=
          (window.innerHeight || document.documentElement.clientHeight) &&
        rect.left <= (window.innerWidth || document.documentElement.clientWidth)
      );
    }

    // Lazy load background images
    function lazyLoadBackgroundImages() {
      $(".lazy-load-bg").each(function () {
        if (isElementInViewport(this)) {
          var background_image = $(this).data("background-image");
          $(this).css("background-image", "url(" + background_image + ")");
          $(this).removeClass("lazy-load-bg");
        }
      });
    }

    // Initial lazy load
    lazyLoadBackgroundImages();

    // Attach an event listener for scrolling
    $(window).on("scroll", function () {
      lazyLoadBackgroundImages();
    });
  });
});
