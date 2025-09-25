<?php
function get_image($image_id, $class = "", $img="w-full h-full object-cover transition-opacity duration-300") {
    if (!$image_id) {
        return '<div class="' . esc_attr($class) . ' bg-gray-200 animate-pulse rounded"></div>';
    }
    
    $image = wp_get_attachment_image_src($image_id, 'full');
    if (!$image) {
        return '<div class="' . esc_attr($class) . ' bg-gray-200 rounded flex items-center justify-center text-gray-400">No Image</div>';
    }
    
    $alt = get_post_meta($image_id, '_wp_attachment_image_alt', true) ?: '';
    
    return sprintf(
        '<div class="image-with-skeleton relative %s" data-image-id="%d">
            <div class="skeleton-loader absolute inset-0 bg-gray-200 animate-pulse rounded"></div>
            <img src="%s" alt="%s" class="%s" 
                 loading="lazy" style="opacity: 0;" />
        </div>',
        esc_attr($class),
        $image_id,
        esc_url($image[0]),
        esc_attr($alt),
        esc_attr($img)
    );
}

// Minimal skeleton handler
add_action('wp_footer', function() {
    static $script_added = false;
    if (!$script_added) {
        echo '<script>
            function hideImageSkeleton(id) {
                const img = document.getElementById(id);
                const skeleton = document.getElementById("skeleton_" + id);
                if (img && skeleton) {
                    img.style.opacity = "1";
                    skeleton.style.display = "none";
                }
            }
        </script>';
        $script_added = true;
    }
});

// Shared Button Function
function hy_shared_btn( $title, $url, $text = 'Check out this amazing content!', $share = 'Share' ) {
    if ( ! $title ) {
        return '';
    }
    if ( ! $url ) {
        return '';
    }
    ?>
    <button class="hy-share-button flex items-center gap-2 text-base font-medium text-black cursor-pointer"
            data-title="<?= esc_attr( $title ); ?>"
            data-url="<?= esc_url( $url ); ?>"
            data-text="<?= esc_attr( $text ); ?>">

        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.367 2.684 3 3 0 00-5.367-2.684z"></path>
        </svg>
        <?php if ( $share ) {
            echo esc_html( $share );
        } ?>
    </button>
    <?php
}

// Modal Container Function
function hy_share_modal_container() {
    ?>
    <div id="hy-share-modal" class="fixed inset-0 z-50 bg-black/75 hidden">
        <div class="w-full h-full flex items-center justify-center p-4">
            <div id="hy-share-modal-overlay" class="absolute inset-0"></div>
    
            <div class="relative bg-white rounded-lg shadow-xl w-full max-w-md m-4">
                <div class="flex items-start justify-between p-4 border-b rounded-t">
                    <h3 class="text-xl font-semibold text-gray-900">
                        Share this content
                    </h3>
                    <button type="button" id="hy-share-modal-close" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                
                <div class="p-6">
                    <p class="text-sm font-normal text-gray-500 mb-4">Choose a platform to share this content.</p>
                    <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                        <!-- Facebook -->
                        <a href="#" data-platform="facebook" class="hy-share-link inline-flex items-center justify-center p-3 text-center text-white bg-[#1877F2] rounded-lg hover:bg-[#166eab] transition-colors">
                            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                            </svg>
                            Facebook
                        </a>
                        
                        <!-- Twitter/X -->
                        <a href="#" data-platform="twitter" class="hy-share-link inline-flex items-center justify-center p-3 text-center text-white bg-[#000000] rounded-lg hover:bg-[#333333] transition-colors">
                            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/>
                            </svg>
                            X
                        </a>
                        
                        <!-- LinkedIn -->
                        <a href="#" data-platform="linkedin" class="hy-share-link inline-flex items-center justify-center p-3 text-center text-white bg-[#0077B5] rounded-lg hover:bg-[#00669c] transition-colors">
                            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.143 0 2.064.925 2.064 2.063 0 1.139-.92 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.225 0z"/>
                            </svg>
                            LinkedIn
                        </a>
                        
                        <!-- WhatsApp -->
                        <a href="#" data-platform="whatsapp" class="hy-share-link inline-flex items-center justify-center p-3 text-center text-white bg-[#25D366] rounded-lg hover:bg-[#20b954] transition-colors">
                            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893A11.821 11.821 0 0020.484 3.488"/>
                            </svg>
                            WhatsApp
                        </a>
                        
                        <!-- Telegram -->
                        <a href="#" data-platform="telegram" class="hy-share-link inline-flex items-center justify-center p-3 text-center text-white bg-[#0088cc] rounded-lg hover:bg-[#0077b3] transition-colors">
                            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M11.944 0A12 12 0 0 0 0 12a12 12 0 0 0 12 12 12 12 0 0 0 12-12A12 12 0 0 0 12 0a12 12 0 0 0-.056 0zm4.962 7.224c.1-.002.321.023.465.14a.506.506 0 0 1 .171.325c.016.093.036.306.02.472-.18 1.898-.962 6.502-1.36 8.627-.168.9-.499 1.201-.82 1.23-.696.065-1.225-.46-1.9-.902-1.056-.693-1.653-1.124-2.678-1.8-1.185-.78-.417-1.21.258-1.91.177-.184 3.247-2.977 3.307-3.23.007-.032.014-.15-.056-.212s-.174-.041-.249-.024c-.106.024-1.793 1.14-5.061 3.345-.48.33-.913.49-1.302.48-.428-.008-1.252-.241-1.865-.44-.752-.245-1.349-.374-1.297-.789.027-.216.325-.437.893-.663 3.498-1.524 5.83-2.529 6.998-3.014 3.332-1.386 4.025-1.627 4.476-1.635z"/>
                            </svg>
                            Telegram
                        </a>
                        
                        <!-- Email -->
                        <a href="#" data-platform="email" class="hy-share-link inline-flex items-center justify-center p-3 text-center text-white bg-[#7E8E94] rounded-lg hover:bg-[#6c7a80] transition-colors">
                            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M20 4H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z"/>
                            </svg>
                            Email
                        </a>
                    </div>
                    
                    <!-- Copy Link Button -->
                    <div class="mt-4">
                        <button id="hy-copy-link-button" class="w-full inline-flex items-center justify-center p-3 text-center text-gray-900 bg-gray-200 rounded-lg hover:bg-gray-300 transition-colors">
                            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M16 1H4c-1.1 0-2 .9-2 2v14h2V3h12V1zm3 4H8c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h11c1.1 0 2-.9 2-2V7c0-1.1-.9-2-2-2zm0 16H8V7h11v14z"/>
                            </svg>
                            <span id="hy-copy-link-text">Copy Link</span>
                        </button>
                    </div>
                    
                    <p class="text-xs text-center text-gray-400 mt-4">
                        * Some platforms may require additional permissions or may not support all features on mobile devices.
                    </p>
                </div>
            </div>
        </div>
    </div>
    <?php
}

class HY_UI {
    public function button( $title, $url, $target = '', $class = '' ) {
        $title = esc_html( $title );
        $url = esc_url( $url );
        $class = esc_attr( $class );
        
        return sprintf(
            '<div class="btn-aware-wrapper relative inline-block">
                <a href="%s" target="%s" class="btn-aware btn-aware-white relative inline-block px-8 py-3 text-base font-medium border border-white rounded-xl overflow-hidden backdrop-blur-[2px] z-10 %s">
                    %s
                    <span class="btn-aware-circle"></span>
                </a>
            </div>',
            $url,
            $target,
            $class,
            $title
        );
    }
    public function black_button( $title, $url, $target = '', $class = '' ) {
        $title = esc_html( $title );
        $url = esc_url( $url );
        $class = esc_attr( $class );
        
        return sprintf(
            '<div class="btn-aware-wrapper relative inline-block">
                <a href="%s" target="%s" class="btn-aware btn-aware-black relative inline-block px-8 py-3 text-base font-medium border border-black rounded-xl overflow-hidden backdrop-blur-[2px] z-10 %s">
                    %s
                    <span class="btn-aware-circle"></span>
                </a>
            </div>',
            $url,
            $target,
            $class,
            $title
        );
    }

    // Headings
    public function main_heading( $text, $class = '' ) {
        $text = esc_html( $text );
        $class = esc_attr( $class );
        
        return sprintf(
            '<h1 class="sm:text-5xl text-4xl text-center font-primary font-normal max-w-[490px] lh-normal italic %s">%s</h1>',
            $class,
            $text
        );
    }
    public function section_heading( $text, $class = '' ) {
        $text = esc_html( $text );
        $class = esc_attr( $class );
        
        return sprintf(
            '<h2 class="sm:text-[40px] text-4xl leading-[1.21em] font-primary italic %s">%s</h2>',
            $class,
            $text
        );
    }
    public function title( $text, $class = '' ) {
        $text = esc_html( $text );
        $class = esc_attr( $class );
        
        return sprintf(
            '<h3 class="text-2xl font-medium %s">%s</h3>',
            $class,
            $text
        );
    }
    public function small_title( $text, $class = '' ) {
        $text = esc_html( $text );
        $class = esc_attr( $class );
        
        return sprintf(
            '<h4 class="text-xl font-medium %s">%s</h4>',
            $class,
            $text
        );
    }
    public function label( $text, $class = '' ) {
        $text = esc_html( $text );
        $class = esc_attr( $class );
        
        return sprintf(
            '<h5 class="uppercase tracking-widest text-sm %s">%s</h5>',
            $class,
            $text
        );
    }

    // Paragraph
    public function paragraph( $text, $class = '' ) {
        $text = esc_html( $text );
        $class = esc_attr( $class );
        
        return sprintf(
            '<p class="sm:text-xl text-base max-w-[490px] %s">%s</p>',
            $class,
            $text
        );
    }
    public function large_paragraph( $text, $class = '' ) {
        $text = esc_html( $text );
        $class = esc_attr( $class );
        
        return sprintf(
            '<p class="sm:text-2xl text-lg mb-6 max-w-[648px] %s">%s</p>',
            $class,
            $text
        );
    }
    public function small_paragraph( $text, $class = '' ) {
        $text = esc_html( $text );
        $class = esc_attr( $class );
        
        return sprintf(
            '<p class="text-base font-light %s">%s</p>',
            $class,
            $text
        );
    }
}