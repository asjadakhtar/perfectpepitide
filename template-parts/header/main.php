<?php 
    // Get header icons from ACF Options page (used in mobile)
    $icons = get_field('header_icons', 'option'); 
    $wishlist = $icons['wishlist'];
    $account = $icons['account']; 
    $cart = $icons['cart']; 

    // Get true/false field from current page
    $white_header = get_field('white_header'); 

    // Dynamic text/icon color classes
    $text_class = $white_header ? 'text-white' : 'text-black';
    $svg_stroke = $white_header ? '#FFFFFF' : '#0F0F0F';
    $header_nav = $white_header ? '' : 'white-nav';
    $header_icon = $white_header ? 'hover:bg-hover' : 'hover:bg-[rgba(0,0,0,0.05)]';

    // Logos from ACF Options
    $logos = get_field('header_logos', 'option');
    $black_logo = $logos['black_logo'];
    $white_logo = $logos['white_logo'];
    $sticky_logo = get_field('sticky_logo', 'option'); // ACF image (array)
    $enable_sticky = get_field('enable_sticky_header'); // From current page

?> 

<!-- ======================================================== -->
<!-- HTML SECTION (Mobile Layout Updated) -->
<!-- ======================================================== -->
<header id="site-header" class="absolute top-0 left-0 right-0 w-full z-50 h-auto py-2 mt-12 header smooth-header-transition <?= $text_class; ?> <?= $header_nav; ?>"> 
     <div class="flex justify-between items-center px-4 lg:pr-23 lg:pl-21 py-2"> 
        
        <!-- Left Menu (Desktop) -->
        <?php if( !is_checkout() ) : ?>
        <div class="hidden lg:block">
            <?php wp_nav_menu(['theme_location' => 'left-header-menu']); ?>
        </div>
        <?php endif; ?>

        <!-- Center Logo -->
        <?php $checkout_align = is_checkout() ? 'my-3' : ''; ?>
        <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 sm:w-[202px] w-[120px] <?= $checkout_align; ?>"> 
            <a href="<?= home_url(); ?>" class="block w-full h-auto">
                <img 
                    src="<?= $white_header ? $white_logo['url'] : $black_logo['url']; ?>"
                    data-white="<?= $white_logo['url']; ?>"
                    data-black="<?= $black_logo['url']; ?>"
                    data-sticky="<?= $sticky_logo['url']; ?>"
                    class="header-logo logo-consistent-dimensions"
                    alt="<?= get_bloginfo('name'); ?>"
                    loading="eager"
                />
            </a>
        </div>

        <!-- Right Menu & Icons (Desktop) -->
        <?php if( !is_checkout() ) : ?>
        <div class="hidden lg:flex flex-row items-center gap-5"> 
            <div> 
                <?php wp_nav_menu(['theme_location' => 'right-header-menu']); ?> 
            </div> 
            <div class="flex flex-row gap-1"> 
                <?php if( $wishlist ) : ?> 
                    <a href="<?= esc_url($wishlist); ?>" class="<?= $header_icon; ?> block p-1.5 rounded smooth-icon-transition"> 
                        <svg width="24" height="25" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg" class="header-icon-svg smooth-svg-transition">
                            <path d="M17.3671 3.84172C16.9415 3.41589 16.4361 3.0781 15.8799 2.84763C15.3237 2.61716 14.7275 2.49854 14.1254 2.49854C13.5234 2.49854 12.9272 2.61716 12.371 2.84763C11.8147 3.0781 11.3094 3.41589 10.8838 3.84172L10.0004 4.72506L9.11709 3.84172C8.25735 2.98198 7.09129 2.49898 5.87542 2.49898C4.65956 2.49898 3.4935 2.98198 2.63376 3.84172C1.77401 4.70147 1.29102 5.86753 1.29102 7.08339C1.29102 8.29925 1.77401 9.46531 2.63376 10.3251L10.0004 17.6917L17.3671 10.3251C17.7929 9.89943 18.1307 9.39407 18.3612 8.83785C18.5917 8.28164 18.7103 7.68546 18.7103 7.08339C18.7103 6.48132 18.5917 5.88514 18.3612 5.32893C18.1307 4.77271 17.7929 4.26735 17.3671 3.84172Z" stroke="<?= $svg_stroke; ?>" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </a> 
                <?php endif; ?> 
                 <?php if( $account ) : ?> 
                    <a href="<?= esc_url($account); ?>" class="<?= $header_icon; ?> block p-1.5 rounded smooth-icon-transition"> 
                        <svg width="24" height="25" viewBox="0 0 24 25" fill="none" xmlns="http://www.w3.org/2000/svg" class="header-icon-svg smooth-svg-transition">
                            <path d="M20 21.5V19.5C20 18.4391 19.5786 17.4217 18.8284 16.6716C18.0783 15.9214 17.0609 15.5 16 15.5H8C6.93913 15.5 5.92172 15.9214 5.17157 16.6716C4.42143 17.4217 4 18.4391 4 19.5V21.5" stroke="<?= $svg_stroke; ?>" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M12 11.5C14.2091 11.5 16 9.70914 16 7.5C16 5.29086 14.2091 3.5 12 3.5C9.79086 3.5 8 5.29086 8 7.5C8 9.70914 9.79086 11.5 12 11.5Z" stroke="<?= $svg_stroke; ?>" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </a> 
                <?php endif; ?> 
                <?php if( $cart ) : ?>
                    <a href="<?= esc_url($cart); ?>" class="<?= $header_icon; ?> block p-1.5 rounded smooth-icon-transition"> 
                        <svg width="24" height="25" viewBox="0 0 24 25" fill="none" xmlns="http://www.w3.org/2000/svg" class="header-icon-svg smooth-svg-transition">
                            <path d="M6 2.5L3 6.5V20.5C3 21.0304 3.21071 21.5391 3.58579 21.9142C3.96086 22.2893 4.46957 22.5 5 22.5H19C19.5304 22.5 20.0391 22.2893 20.4142 21.9142C20.7893 21.5391 21 21.0304 21 20.5V6.5L18 2.5H6Z" stroke="<?= $svg_stroke; ?>" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M3 6.5H21" stroke="<?= $svg_stroke; ?>" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M16 10.5C16 11.5609 15.5786 12.5783 14.8284 13.3284C14.0783 14.0786 13.0609 14.5 12 14.5C10.9391 14.5 9.92172 14.0786 9.17157 13.3284C8.42143 12.5783 8 11.5609 8 10.5" stroke="<?= $svg_stroke; ?>" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </a>
                <?php endif; ?> 
            </div> 
        </div>
        <?php endif; ?>
        
        <!-- Mobile Section -->
        <div class="lg:hidden flex items-center justify-between w-full">
            <!-- Mobile Toggle (Left Side) -->
            <button onclick="toggleMobileMenu()" class="hover:text-gray-300 focus:outline-none align-middle smooth-icon-transition">
                <svg class="w-6 h-6 smooth-svg-transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                </svg>
            </button>

            <!-- Mobile Icons (Right Side) -->
            <div class="flex flex-row gap-1">
                <?php if ($wishlist) : ?>
                    <a href="<?= esc_url($wishlist); ?>" class="p-1 flex items-center smooth-icon-transition">
                        <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg" class="header-icon-svg smooth-svg-transition">
                           <path d="M17.3671 3.84172C16.9415 3.41589 16.4361 3.0781 15.8799 2.84763C15.3237 2.61716 14.7275 2.49854 14.1254 2.49854C13.5234 2.49854 12.9272 2.61716 12.371 2.84763C11.8147 3.0781 11.3094 3.41589 10.8838 3.84172L10.0004 4.72506L9.11709 3.84172C8.25735 2.98198 7.09129 2.49898 5.87542 2.49898C4.65956 2.49898 3.4935 2.98198 2.63376 3.84172C1.77401 4.70147 1.29102 5.86753 1.29102 7.08339C1.29102 8.29925 1.77401 9.46531 2.63376 10.3251L10.0004 17.6917L17.3671 10.3251C17.7929 9.89943 18.1307 9.39407 18.3612 8.83785C18.5917 8.28164 18.7103 7.68546 18.7103 7.08339C18.7103 6.48132 18.5917 5.88514 18.3612 5.32893C18.1307 4.77271 17.7929 4.26735 17.3671 3.84172Z" stroke="<?= $svg_stroke; ?>" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </a>
                <?php endif; ?>
                <?php if ($cart) : ?>
                    <a href="<?= esc_url($cart); ?>" class="p-1 flex items-center smooth-icon-transition">
                        <svg width="24" height="25" viewBox="0 0 24 25" fill="none" xmlns="http://www.w3.org/2000/svg" class="header-icon-svg smooth-svg-transition">
                           <path d="M6 2.5L3 6.5V20.5C3 21.0304 3.21071 21.5391 3.58579 21.9142C3.96086 22.2893 4.46957 22.5 5 22.5H19C19.5304 22.5 20.0391 22.2893 20.4142 21.9142C20.7893 21.5391 21 21.0304 21 20.5V6.5L18 2.5H6Z" stroke="<?= $svg_stroke; ?>" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/><path d="M3 6.5H21" stroke="<?= $svg_stroke; ?>" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/><path d="M16 10.5C16 11.5609 15.5786 12.5783 14.8284 13.3284C14.0783 14.0786 13.0609 14.5 12 14.5C10.9391 14.5 9.92172 14.0786 9.17157 13.3284C8.42143 12.5783 8 11.5609 8 10.5" stroke="<?= $svg_stroke; ?>" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</header>

<!-- ======================================================== -->
<!-- NAYA MOBILE MENU PANEL (YAHAN ADD KIYA GAYA HAI) -->
<!-- ======================================================== -->
<div id="mobile-menu" class="lg:hidden hidden fixed inset-0 z-40 bg-white text-black overflow-y-auto w-full max-w-[300px] shadow-lg">
    <div class="flex justify-end p-4">
        <button onclick="toggleMobileMenu()" class="hover:text-gray-500 text-3xl font-bold">
            &times;
        </button>
    </div>
    <div class="py-4 px-6">
        <!-- Left Menu -->
        <div class="mb-4">
            <?php 
            wp_nav_menu([
                'theme_location' => 'left-header-menu',
                'menu_class'     => 'mobile-nav-menu space-y-2',
                'container'      => false
            ]); 
            ?> 
        </div>

        <!-- Right Menu -->
        <div>
            <?php 
            wp_nav_menu([
                'theme_location' => 'right-header-menu',
                'menu_class'     => 'mobile-nav-menu space-y-2',
                'container'      => false
            ]); 
            ?> 
        </div>
    </div>
</div>


<!-- ======================================================== -->
<!-- STYLE SECTION (MOBILE MENU KE LIYE STYLES ADD KIYE HAIN) -->
<!-- ======================================================== -->
<style>
#site-header {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    will-change: background-color, color, box-shadow;
}

#site-header.is-sticky {
    position: fixed;
    top: 0;
}

.smooth-header-transition {
    transition: background-color 0.6s ease-in-out,
                color 0.6s ease-in-out,
                box-shadow 0.6s ease-in-out;
}

.smooth-icon-transition {
    transition: all 0.4s cubic-bezier(0.25, 0.8, 0.25, 1);
}

.smooth-svg-transition path {
    transition: stroke 0.6s ease-in-out;
}

.smooth-icon-transition:hover {
    transform: translateY(-1px);
}

html {
    scroll-behavior: smooth;
}

#mobile-menu {
    transition: transform 0.5s cubic-bezier(0.4, 0, 0.2, 1);
    transform: translateX(-100%); /* Shuru mein screen se bahar */
}

#mobile-menu:not(.hidden) {
    transform: translateX(0); /* Jab hidden class na ho to screen par layein */
}

/* MOBILE MENU KE LIYE NAYE STYLES */
#mobile-menu .mobile-nav-menu a {
    display: block;
    padding: 8px 0;
    font-size: 1.1rem;
    font-weight: 500;
    transition: color 0.3s ease;
}

#mobile-menu .mobile-nav-menu a:hover {
    color: #555; /* Hover par halka grey color */
}

@media (min-width: 640px) {
    .logo-consistent-dimensions {
        width: 202px !important;
        height: 48px !important; 
    }
}

@media (max-width: 639px) {
    .logo-consistent-dimensions {
        width: 104px !important;
        height: 30px !important; 
    }
}
</style>


<!-- ======================================================== -->
<!-- SCRIPT SECTION (toggleMobileMenu FUNCTION UPDATED) -->
<!-- ======================================================== -->
<script>
document.addEventListener("DOMContentLoaded", function () {
    const header = document.getElementById("site-header");
    const logo = document.querySelector(".header-logo");
    const scrollTrigger = 50; 
    let ticking = false;

    const whiteHeader = <?= $white_header ? 'true' : 'false'; ?>;
    const strokeWhite = "#FFFFFF";
    const strokeBlack = "#0F0F0F";
    const whiteLogoUrl = logo.dataset.white;
    const blackLogoUrl = logo.dataset.black;
    const stickyLogoUrl = logo.dataset.sticky && logo.dataset.sticky !== '' ? logo.dataset.sticky : blackLogoUrl;

    function setStrokeColor(color) {
        document.querySelectorAll(".header-icon-svg path").forEach(path => {
            path.setAttribute("stroke", color);
        });
    }

    function updateHeaderOnScroll() {
        const scrollY = window.scrollY;

        if (scrollY > scrollTrigger) {
            header.classList.add("is-sticky", "bg-white", "shadow-md");
            header.classList.remove("text-white");
            header.classList.add("text-black");
            header.classList.remove("mt-12"); 

            if (logo.src !== stickyLogoUrl) {
                logo.src = stickyLogoUrl;
            }
            setStrokeColor(strokeBlack);

        } else {
            header.classList.remove("is-sticky", "bg-white", "shadow-md");
            header.classList.add("mt-12"); 
            
            if (whiteHeader) {
                header.classList.add("text-white");
                header.classList.remove("text-black");
                if (logo.src !== whiteLogoUrl) logo.src = whiteLogoUrl;
                setStrokeColor(strokeWhite);
            } else {
                header.classList.add("text-black");
                header.classList.remove("text-white");
                if (logo.src !== blackLogoUrl) logo.src = blackLogoUrl;
                setStrokeColor(strokeBlack);
            }
        }
        ticking = false;
    }

    window.addEventListener("scroll", () => {
        if (!ticking) {
            window.requestAnimationFrame(updateHeaderOnScroll);
            ticking = true;
        }
    }, { passive: true });
    
    updateHeaderOnScroll();
});

// WORKING MOBILE MENU FUNCTION
function toggleMobileMenu() {
    const menu = document.getElementById('mobile-menu');
    if (menu) {
        // 'hidden' class ko toggle karein taake CSS transition kaam kare
        menu.classList.toggle('hidden');
    }
}
</script>