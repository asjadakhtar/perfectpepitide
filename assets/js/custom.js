"use strict";

/* JQUERY FUNCTIONS */
jQuery(document).ready(function ($) {
    // Legal link smooth scrolling
    $('a[href^="#legal-link-"]').on("click", function (e) {
        e.preventDefault();
        const target = $(this).attr("href");
        const offset = $(target).offset()?.top;
        if (offset !== undefined) {
            $("html, body").animate(
                {
                    scrollTop: offset - 28,
                },
                600
            );
        }
    });

    // Quantity controller for single page
    $(".qty-minus").on("click", function () {
        var $input = $(this).siblings(".quantity").find("input.qty");
        var val = parseInt($input.val()) || 1;
        if (val > 1) {
            $input.val(val - 1).trigger("change");
        }
    });

    $(".qty-plus").on("click", function () {
        var $input = $(this).siblings(".quantity").find("input.qty");
        var val = parseInt($input.val()) || 1;
        $input.val(val + 1).trigger("change");
    });

    // Button aware hover effect
    $(".btn-aware").on("mouseenter", function (e) {
        const $circle = $(this).find(".btn-aware-circle")[0];
        const rect = this.getBoundingClientRect();
        const relX = e.clientX - rect.left;
        const relY = e.clientY - rect.top;

        $(this)
            .find(".btn-aware-circle")
            .css({
                top: relY + "px",
                left: relX + "px",
                transform: "translate(-50%, -50%) scale(1)",
            });
    });

    $(".btn-aware").on("mouseleave", function () {
        $(this).find(".btn-aware-circle").css({
            transform: "translate(-50%, -50%) scale(0)",
        });
    });

    // Custom variation buttons
    $(".hy-variation-button").on("click", function () {
        var $button = $(this);
        var value = $button.data("value");
        var $wrapper = $button.closest(".hy-variation-buttons");
        var attribute = $wrapper.data("attribute_name");

        var $select = $('select[name="' + attribute + '"]');
        $select.val(value).trigger("change");

        $wrapper.find(".hy-variation-button").removeClass("selected");
        $button.addClass("selected");
    });
});

/* HEADER & NAVIGATION */
function toggleMobileMenu() {
    const mobileMenu = document.getElementById("mobile-menu");
    if (mobileMenu.style.display === "none" || mobileMenu.style.display === "") {
        mobileMenu.style.display = "block";
        mobileMenu.classList.remove("hidden");
    } else {
        mobileMenu.style.display = "none";
        mobileMenu.classList.add("hidden");
    }
}

document.addEventListener("click", function (event) {
    const mobileMenu = document.getElementById("mobile-menu");
    const toggleButton = document.getElementById("mobile-menu-toggle");
    if (
        mobileMenu &&
        toggleButton &&
        !toggleButton.contains(event.target) &&
        !mobileMenu.contains(event.target)
    ) {
        mobileMenu.style.display = "none";
        mobileMenu.classList.add("hidden");
    }
});







document.addEventListener("DOMContentLoaded", () => {
    // Share Button
    const shareBtn = document.getElementById("hy-share-button");
    shareBtn?.addEventListener("click", async () => {
        try {
            await navigator.share({ title: shareBtn.dataset.title, url: shareBtn.dataset.url });
        } catch (err) {
            console.error("Share failed:", err.message);
        }
    });

    // Image Gallery: Manual Fallback (in case Swiper isn't used)
    const thumbnails = document.querySelectorAll(".thumbnail");
    const mainImg = document.querySelector("#mainImage img");

    if (mainImg && thumbnails.length) {
        const setActive = (el) => {
            mainImg.src = el.src;
            mainImg.alt = el.alt;
            thumbnails.forEach(t => t.classList.replace("border-black", "border-gray-300"));
            thumbnails.forEach(t => t.classList.replace("opacity-100", "opacity-60"));
            el.closest(".thumbnail").classList.replace("border-gray-300", "border-black");
            el.closest(".thumbnail").classList.replace("opacity-60", "opacity-100");
        };

        setActive(thumbnails[0].querySelector("img"));
        thumbnails.forEach(t => t.addEventListener("click", () => setActive(t.querySelector("img"))));
    }

    // Function to update thumbnail active state
    const updateThumbnailActive = (activeIndex) => {
        const thumbSlides = document.querySelectorAll(".hy-swiper-product .swiper-slide img");
        
        thumbSlides.forEach((img, index) => {
            // Force remove all border and opacity classes first
            img.classList.remove("border-gray-300", "border-black", "opacity-60", "opacity-100");
            
            if (index === activeIndex) {
                // Active thumbnail styling
                img.classList.add("border-black", "opacity-100");
                // Also add border-2 if not present
                if (!img.classList.contains("border-2")) {
                    img.classList.add("border-2");
                }
            } else {
                // Inactive thumbnail styling
                img.classList.add("border-gray-300", "opacity-60");
                // Also add border-2 if not present
                if (!img.classList.contains("border-2")) {
                    img.classList.add("border-2");
                }
            }
        });
    };

    // Swiper for Thumbnails & Main Image
    const thumbSwiper = new Swiper(".hy-swiper-product", {
        spaceBetween: 10,
        slidesPerView: 'auto',
        direction: window.innerWidth < 640 ? 'horizontal' : 'vertical', // sm: breakpoint Tailwind style
        freeMode: true,
        watchSlidesProgress: true,
        mousewheel: true,
        breakpoints: {
            640: { direction: 'vertical' }, // sm and up = vertical
            0: { direction: 'horizontal' }, // xs = horizontal
        },
    });

    const mainSwiper = new Swiper(".hy-swiper-main", {
        spaceBetween: 10,
        thumbs: {
            swiper: thumbSwiper,
        },
        // Add slide change event listener
        on: {
            slideChange: function() {
                // Add small delay to ensure swiper has updated
                setTimeout(() => {
                    updateThumbnailActive(this.activeIndex);
                    // Also sync thumbnail swiper to show the active thumbnail
                    thumbSwiper.slideTo(this.activeIndex);
                }, 10);
            },
            init: function() {
                // Set initial active thumbnail with delay
                setTimeout(() => {
                    updateThumbnailActive(this.activeIndex);
                }, 100);
            }
        }
    });

    // Sync thumbnail swiper with main swiper clicks
    thumbSwiper.on('tap', function(swiper, event) {
        const clickedSlide = event.target.closest('.swiper-slide');
        if (clickedSlide) {
            const slideIndex = Array.from(clickedSlide.parentNode.children).indexOf(clickedSlide);
            // Update main swiper to show corresponding image
            mainSwiper.slideTo(slideIndex);
            // Update thumbnail styling
            updateThumbnailActive(slideIndex);
        }
    });

    // Also handle direct thumbnail clicks (for better compatibility)
    document.querySelectorAll('.hy-swiper-product .swiper-slide img').forEach((img, index) => {
        img.addEventListener('click', () => {
            mainSwiper.slideTo(index);
            updateThumbnailActive(index);
        });
    });

    // Product Slider with Arrow Scroll
    const slider = document.getElementById("product-slider");
    const leftBtn = document.getElementById("scrollLeftBtn");
    const rightBtn = document.getElementById("scrollRightBtn");
    const scrollAmt = 328;

    if (slider && leftBtn && rightBtn) {
        const update = () => {
            const max = slider.scrollWidth - slider.clientWidth;
            leftBtn.style.opacity = slider.scrollLeft <= 0 ? "0.5" : "1";
            rightBtn.style.opacity = slider.scrollLeft >= max ? "0.5" : "1";
        };

        leftBtn.onclick = () => slider.scrollBy({ left: -scrollAmt, behavior: "smooth" });
        rightBtn.onclick = () => slider.scrollBy({ left: scrollAmt, behavior: "smooth" });
        slider.addEventListener("scroll", update);
        update();

        let isDown = false, startX, scrollLeftStart;
        slider.addEventListener("mousedown", e => {
            isDown = true;
            startX = e.pageX - slider.offsetLeft;
            scrollLeftStart = slider.scrollLeft;
        });
        ["mouseleave", "mouseup"].forEach(e => slider.addEventListener(e, () => isDown = false));
        slider.addEventListener("mousemove", e => {
            if (!isDown) return;
            e.preventDefault();
            const x = e.pageX - slider.offsetLeft;
            slider.scrollLeft = scrollLeftStart - (x - startX) * 2;
        });
    }

    // Horizontal Card Scroll (Generic Cards)
    const scrollWrap = document.querySelector(".overflow-x-auto");
    document.getElementById("scroll-arrow-right")?.addEventListener("click", () => scrollWrap?.scrollBy({ left: 320, behavior: "smooth" }));
    document.getElementById("scroll-arrow-left")?.addEventListener("click", () => scrollWrap?.scrollBy({ left: -320, behavior: "smooth" }));
});






/* MODAL FUNCTIONALITY */
function openModal(imageElement) {
    const modal = document.getElementById("imageModal");
    const modalImage = document.getElementById("modalImage");
    modalImage.src = imageElement.src;
    modalImage.alt = imageElement.alt;
    modal.style.display = "block";
    document.body.style.overflow = "hidden";
}

function closeModal() {
    const modal = document.getElementById("imageModal");
    modal.style.display = "none";
    document.body.style.overflow = "auto";
}

document.getElementById("imageModal")?.addEventListener("click", function (event) {
    if (event.target === this) {
        closeModal();
    }
});

document.addEventListener("keydown", function (event) {
    if (event.key === "Escape") {
        closeModal();
    }
});



/* IMAGE & LOADING FUNCTIONALITY */
document.addEventListener("DOMContentLoaded", function () {
    // AOS initialization
    AOS.init({
        duration: 1500,
        once: true,
    });

    // Image skeleton loader
    const containers = document.querySelectorAll(".image-with-skeleton");
    containers.forEach((container) => {
        const img = container.querySelector("img");
        const skeleton = container.querySelector(".skeleton-loader");

        function hideSkeletonShowImage() {
            img.style.opacity = "1";
            skeleton.style.opacity = "0";
            setTimeout(() => (skeleton.style.display = "none"), 300);
        }

        if (img.complete && img.naturalHeight !== 0) {
            hideSkeletonShowImage();
        } else {
            img.addEventListener("load", hideSkeletonShowImage);
            img.addEventListener("error", () => {
                skeleton.innerHTML =
                    '<div class="flex items-center justify-center h-full text-gray-400 text-sm">Image failed to load</div>';
                skeleton.classList.remove("animate-pulse");
            });
        }
    });
});

/* UI INTERACTIONS */
document.addEventListener("DOMContentLoaded", function () {
    // Read more toggle with smooth animation
    const toggleBtn = document.getElementById("toggleBtn");
    const toggleTitle = document.querySelector(".readme-title");
    const paragraph = document.getElementById("secondPara");
    let expanded = false;

    toggleBtn?.addEventListener("click", function () {
        if (expanded) {
            // Collapsing
            paragraph.classList.add("truncate-4");
            paragraph.classList.remove("expanded");
            toggleTitle.innerText = "Read More";
        } else {
            // Expanding
            paragraph.classList.remove("truncate-4");
            paragraph.classList.add("expanded");
            toggleTitle.innerText = "Read Less";
        }
        expanded = !expanded;
    });

    // FAQ Accordion
    const toggles = document.querySelectorAll("#faqAccordion .faq-toggle");
    toggles.forEach((button) => {
        button.addEventListener("click", () => {
            const content = button.nextElementSibling;
            const icon = button.querySelector(".toggle-icon");
            const isOpen = content.classList.contains("max-h-[500px]");

            document.querySelectorAll("#faqAccordion .faq-content").forEach((el) => {
                el.style.maxHeight = null;
                el.classList.remove("max-h-[500px]");
            });
            document
                .querySelectorAll("#faqAccordion .toggle-icon")
                .forEach((i) => (i.textContent = "+"));

            if (!isOpen) {
                content.style.maxHeight = content.scrollHeight + "px";
                content.classList.add("max-h-[500px]");
                icon.textContent = "−";
            }
        });
    });
});


/* OFFCANVAS FUNCTIONALITY */
document.addEventListener("DOMContentLoaded", function () {
    const sizeGuideBtn = document.getElementById("sizeGuideBtn");
    const sizeGuideBtn2 = document.getElementById("sizeGuideBtn2");
    const offcanvas = document.getElementById("sizeGuideOffcanvas");
    const overlay = document.getElementById("sizeGuideOverlay");
    const closeBtn = document.getElementById("closeSizeGuide");

    function openOffcanvas() {
        offcanvas.classList.add("visible");
        document.body.classList.add("no-scroll");
        setTimeout(() => {
            offcanvas.classList.add("show-panel");
        }, 10);
    }

    function closeOffcanvas() {
        offcanvas.classList.remove("show-panel");
        setTimeout(() => {
            offcanvas.classList.remove("visible");
            document.body.classList.remove("no-scroll");
        }, 300);
    }

    sizeGuideBtn?.addEventListener("click", openOffcanvas);
    sizeGuideBtn2?.addEventListener("click", openOffcanvas);
    closeBtn?.addEventListener("click", closeOffcanvas);
    overlay?.addEventListener("click", closeOffcanvas);

    document.addEventListener("keydown", function (e) {
        if (e.key === "Escape" && offcanvas?.classList.contains("visible")) {
            closeOffcanvas();
        }
    });
});

/* SWIPER CONFIGURATIONS */
const swiper = new Swiper(".hy-swiper-product", {
    direction: "horizontal",
    slidesPerView: "auto",
    spaceBetween: 10,
    freeMode: true,
    mousewheel: true,
    grabCursor: true,
    scrollbar: {
        el: ".swiper-scrollbar",
        draggable: true,
    },
    breakpoints: {
        640: {
            direction: "vertical",
        },
    },
});

const swiperCollection = new Swiper(".hy-collection-swiper", {
    slidesPerView: 1.2,
    spaceBetween: 20,
    breakpoints: {
        560: { slidesPerView: 2 },
        768: { slidesPerView: 3 },
        1275: { slidesPerView: 4.5 },
    },
    navigation: {
        nextEl: ".hy-arrow-right",
        prevEl: ".hy-arrow-left",
    },
});

const bannerSwiper = new Swiper(".swiper-banner", {
    loop: true,
    speed: 1500,
    autoplay: {
        delay: 4000,
        disableOnInteraction: false,
    },
    pagination: {
        el: ".banner-pagination",
        clickable: true,
        renderBullet: function (index, className) {
            return `<span class="${className}"><span class="progress"></span></span>`;
        },
    },
});

const progressSelectors = document.querySelectorAll(".banner-pagination");

if (progressSelectors.length > 0) {
    setTimeout(() => {
        progressSelectors.forEach((progress) => {
            progress.classList.add("changed");
        });
    }, 4000);
}

document.addEventListener("DOMContentLoaded", function () {
    const swiperConfigs = [
        { selector: ".card-swiper-1", delay: 0 },
        { selector: ".card-swiper-2", delay: 1500 },     // 1.5 second baad
        { selector: ".card-swiper-3", delay: 3000 },     // 3 second baad
    ]

    swiperConfigs.forEach(({ selector, delay }) => {
        setTimeout(() => {
            const swiperEl = document.querySelector(selector);
            if (!swiperEl) return;

            new Swiper(selector, {
                loop: true,
                autoplay: {
                    delay: 5000,
                    disableOnInteraction: false,
                },
                pagination: {
                    el: `${selector} .swiper-pagination`,
                    clickable: true,
                },
                on: {
                    init: () => {
                        swiperEl.classList.add("initialized");
                    },
                },
            });
        }, delay);
    });
});


// Testimonials Swiper with fade effect
document.addEventListener('DOMContentLoaded', function() {
  const swiper = new Swiper('.testimonials-swiper', {
    slidesPerView: 1,
    spaceBetween: 30,
    loop: false,
    speed: 800,
    effect: 'slide',
    autoplay: {
      delay: 5000,
      disableOnInteraction: false,
    },
    on: {
      slideChangeTransitionStart: function () {
        // Reset all slides to initial state
        const allSlides = this.slides;
        allSlides.forEach(slide => {
          const image = slide.querySelector('.slide-image');
          const content = slide.querySelector('.slide-content');
          
          if (image) {
            image.style.transform = 'scale(0.8)';
            image.style.opacity = '0';
            image.style.transitionDelay = '0s';
          }
          if (content) {
            content.style.transform = 'translateX(50px)';
            content.style.opacity = '0';
            content.style.transitionDelay = '0s';
          }
        });
      },
      slideChangeTransitionEnd: function () {
        // Animate active slide with AOS-like timing
        const activeSlide = this.slides[this.activeIndex];
        if (activeSlide) {
          const image = activeSlide.querySelector('.slide-image');
          const content = activeSlide.querySelector('.slide-content');
          
          // Image zoom-in animation (like AOS zoom-in with delay 200ms)
          setTimeout(() => {
            if (image) {
              image.style.transform = 'scale(1)';
              image.style.opacity = '1';
            }
          }, 200);
          
          // Text fade-left animation (like AOS fade-left with delay 300ms)
          setTimeout(() => {
            if (content) {
              content.style.transform = 'translateX(0)';
              content.style.opacity = '1';
            }
          }, 300);
        }
      }
    }
  });

  // Arrow click handlers
  document.addEventListener('click', function(e) {
    if (e.target.closest('#testimonial-arrow-left')) {
      e.preventDefault();
      
      const arrow = e.target.closest('#testimonial-arrow-left');
      arrow.style.transform = 'scale(0.9)';
      setTimeout(() => {
        arrow.style.transform = 'scale(1)';
      }, 150);
      
      swiper.slidePrev();
    }
    
    if (e.target.closest('#testimonial-arrow-right')) {
      e.preventDefault();
      
      const arrow = e.target.closest('#testimonial-arrow-right');
      arrow.style.transform = 'scale(0.9)';
      setTimeout(() => {
        arrow.style.transform = 'scale(1)';
      }, 150);
      
      swiper.slideNext();
    }
  });

  // Initialize first slide with AOS-like animations
  setTimeout(() => {
    const firstSlide = document.querySelector('.swiper-slide-active');
    if (firstSlide) {
      const image = firstSlide.querySelector('.slide-image');
      const content = firstSlide.querySelector('.slide-content');
      
      // Image zoom-in with delay 200ms
      setTimeout(() => {
        if (image) {
          image.style.transform = 'scale(1)';
          image.style.opacity = '1';
        }
      }, 200);
      
      // Text fade-left with delay 300ms  
      setTimeout(() => {
        if (content) {
          content.style.transform = 'translateX(0)';
          content.style.opacity = '1';
        }
      }, 300);
    }
  }, 100);
});




// legal page editor
 document.addEventListener("DOMContentLoaded", function () {
    // Select all images inside .legal-image-editor
    const images = document.querySelectorAll(".legal-image-editor img");

    images.forEach(function (img) {
        // Create a wrapper div
        const wrapper = document.createElement("div");

        // Add styling to wrapper
        wrapper.style.backgroundColor = "#F5F5F0";
        wrapper.style.display = "flex";
        wrapper.style.justifyContent = "center";
        wrapper.style.alignItems = "center";

        // Set image width
        img.style.width = "380px";
        img.style.height = "auto";

        // Wrap the image
        img.parentNode.insertBefore(wrapper, img);
        wrapper.appendChild(img);
    });
});