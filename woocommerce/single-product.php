<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$current_id = get_queried_object_id();

get_header( 'shop' ); ?>

<section class="my-8 lg:my-16">
    <div class="container mx-auto px-4 mt-[160px]">

        <?php while ( have_posts() ) : the_post(); ?>
            <?php
                global $product;
                $product_id = $product->get_id();
                $gallery_ids = $product->get_gallery_image_ids();
                $main_image = get_post_thumbnail_id( $product_id );
            ?>

            <div class="text-sm text-[#797878] mb-6 font-medium font-secondary">
                <a href="<?php echo home_url(); ?>" class="hover:underline">Home</a> / 
                <a href="<?php echo get_permalink( wc_get_page_id( 'shop' ) ); ?>" class="hover:underline">Shop</a> / 
                <span><?php the_title(); ?></span>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-16">

                <div class="flex flex-col">

                    <div class="flex gap-3 flex-col-reverse sm:flex-row">
                        <!-- Vertical Thumbnail Swiper -->
                        <div class="swiper hy-swiper-product w-full max-h-[750px] sm:max-w-[90px]">
                            <div class="swiper-wrapper">
                                <?php if ( $main_image ) : ?>
                                    <div class="swiper-slide">
                                        <?= get_image($main_image, 'thumbnail object-cover cursor-pointer opacity-100 bg-[#F5F5F5] w-[90px] h-[131px]'); ?>
                                    </div>
                                <?php endif; ?>

                                <?php foreach ( $gallery_ids as $gallery_id ) : ?>
                                    <div class="swiper-slide">
                                        <?= get_image($gallery_id, 'thumbnail object-cover cursor-pointer opacity-60 bg-[#F5F5F5] w-[90px] h-[131px]'); ?>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>

                        <!-- Main Image Swiper -->
                        <div class="swiper hy-swiper-main main-product-image overflow-hidden w-full sm:h-[750px]">
                            <div class="swiper-wrapper">
                                <?php if ( $main_image ) : ?>
                                    <div class="swiper-slide">
                                        <div id="mainImage">
                                            <?php 
                                            $image_html = get_image($main_image, 'object-cover w-full h-auto sm:max-w-[550px] sm:h-[750px]');
                                            $image_html = str_replace('<img', '<img onclick="openModal(this)" style="cursor: pointer;"', $image_html);
                                            echo $image_html;
                                            ?>
                                        </div>
                                    </div>
                                <?php endif; ?>

                                <?php foreach ( $gallery_ids as $gallery_id ) : ?>
                                    <div class="swiper-slide">
                                        <?php 
                                        $image_html = get_image($gallery_id, 'object-cover w-full h-auto sm:max-w-[550px] sm:h-[750px]');
                                        $image_html = str_replace('<img', '<img onclick="openModal(this)" style="cursor: pointer;"', $image_html);
                                        echo $image_html;
                                        ?>
                                    </div>
                                <?php endforeach; ?>

                            </div>
                        </div>

                        <!-- Modal -->
                        <div id="imageModal" class="modal">
                            <span class="close" onclick="closeModal()">&times;</span>
                            <div class="modal-content">
                                <img id="modalImage" class="modal-image" src="" alt="Zoomed Image">
                            </div>
                        </div>
                    </div>


                    <!-- Product Description -->
                    <div class="mt-18 hidden lg:block">
                        <div class="max-w-[660px] text-[#252525] font-secondary" id="faqAccordion">

                        <?php if( get_the_content() ) : ?>
                            <div class="py-4">
                                <button type="button" class="faq-toggle flex justify-between items-center w-full text-left sm:text-[24px] text-[20px] font-medium text-black cursor-pointer">
                                    Description
                                <span class="toggle-icon text-[24px] width-[24px] height-[24px] transition-transform duration-300">+</span>
                                </button>
                                <div class="faq-content overflow-hidden max-h-0 transition-all duration-500 ease-in-out text-base leading-[1.2] text-black font-normal">
                                <div class="pt-4 sm:text-xl text-lg">
                                    <?php the_content(); ?>
                                </div>
                                </div>
                            </div>
                        <?php endif; ?>

                        <?php $global_product_page_content = get_field('global_product_page_content', 'option'); ?>

                        <?php if( $global_product_page_content && !empty($global_product_page_content['delivery_policy']) ) : ?>

                            <div class="py-4">
                                <button type="button" class="faq-toggle flex justify-between items-center w-full text-left sm:text-[24px] text-[20px] font-medium text-black cursor-pointer">
                                    Delivery Policy
                                    <span class="toggle-icon text-[24px] transition-transform duration-300">+</span>
                                </button>
                                <div class="faq-content overflow-hidden max-h-0 transition-all duration-500 ease-in-out text-base leading-[1.2] text-black font-normal">
                                    <div class="pt-4 sm:text-xl text-lg">
                                        <?= $global_product_page_content['delivery_policy']; ?>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>

                        <?php if( $global_product_page_content && !empty($global_product_page_content['how_it_works']) ) : ?>
                            <div class="py-4">
                                <button type="button" class="faq-toggle flex justify-between items-center w-full text-left sm:text-[24px] text-[20px] font-medium cursor-pointer">
                                    How it works
                                    <span class="toggle-icon text-[24px] transition-transform duration-300">+</span>
                                </button>
                                <div class="faq-content overflow-hidden max-h-0 transition-all duration-500 ease-in-out text-base leading-[1.2] text-black font-normal">
                                    <div class="pt-4 sm:text-xl text-lg">
                                        <?= $global_product_page_content['how_it_works']; ?>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>

                        <div class="py-4 flex justify-between items-center cursor-pointer" id="sizeGuideBtn2">
                            <span class="sm:text-[24px] text-[20px] font-medium text-black">Size Guide</span>
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                            </svg>
                        </div>

                        </div>
                    </div>
                </div>

                

                <div class="space-y-6">
                    <h1 class="text-[32px] font-medium text-[#27221E] font-secondary"><?php the_title(); ?></h1>

                    <?php if ( $product->get_short_description() ) : ?>
                        <div class="text-gray-600 sm:text-xl text-lg leading-relaxed max-w-[470px]">
                            <?php echo $product->get_short_description(); ?>
                        </div>
                    <?php endif; ?>

                    <div class="space-y-3">
                        <!-- Woocommerce Variable form -->
                        <?php woocommerce_template_single_add_to_cart(); ?>
                    </div>

                    <div class="flex sm:items-center sm:flex-row flex-col gap-6 text-sm">
                        <div class="hover:bg-[rgba(0,0,0,0.05)] transition-all duration-300 p-2 rounded">
                            <?php hy_shared_btn( get_the_title(), get_permalink() ); ?>
                        </div>

                        <div class="my-wishlist-btn hover:bg-[rgba(0,0,0,0.05)] transition-all duration-300 p-2 rounded">
                            <?php echo do_shortcode('[yith_wcwl_add_to_wishlist]'); ?>
                        </div>

                    </div>

                    <?php
                        $features = get_field('features');

                        $material_and_content = $features['material_and_content'] ?? null;
                        $care = $features['care'] ?? null;
                        $size_and_fit = $features['size_and_fit'] ?? null;
                        $made_to_order = $features['made_to_order'] ?? null;
                        $rush_orders = $features['rush_orders'] ?? null;
                    ?>

                    <div class="mt-12 max-w-[424px]">
                        <?php if( $material_and_content ) : ?>
                            <div class="mb-[24px]">
                                <h3 class="text-[20px] text-[#252525] font-medium mb-2 font-secondary">Material and Content</h3>
                                <p class="text-base text-[#252525] font-normal font-secondary"><?= $material_and_content; ?></p>
                            </div>
                        <?php endif; ?>

                        <?php if( $care ) : ?>
                            <div class="mb-[24px]">
                                <h3 class="text-[20px] text-[#252525] font-medium mb-2 font-secondary">Care</h3>
                                <p class="text-base text-[#252525] font-normal font-secondary"><?= $care; ?></p>
                            </div>
                        <?php endif; ?>

                        <?php if( $size_and_fit ) : ?>
                            <div class="mb-[24px]">
                                <h3 class="text-[20px] text-[#252525] font-medium mb-2 font-secondary">Size and Fit</h3>
                                <p class="text-base text-[#252525] font-normal font-secondary"><?= $size_and_fit; ?></p>
                            </div>
                        <?php endif; ?>

                        <?php if( $made_to_order ) : ?>
                            <div class="mb-[24px]">
                                <h3 class="text-[20px] text-[#252525] font-medium mb-2 font-secondary">Made to Order</h3>
                                <p class="text-base text-[#252525] font-normal font-secondary"><?= $made_to_order; ?></p>
                            </div>
                        <?php endif; ?>

                        <?php if( $rush_orders ) : ?>
                            <div class="mb-[24px]">
                                <h3 class="text-[20px] text-[#252525] font-medium mb-2 font-secondary">Rush Orders</h3>
                                <p class="text-base text-[#252525] font-normal font-secondary"><?= $rush_orders; ?></p>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>


            </div>
        <?php endwhile; ?>

         <!-- Product Description -->
        <div class="pt-4 lg:hidden block">
            <div class="max-w-[610px] text-[#252525] font-secondary" id="faqAccordion">

            <?php if( get_the_content() ) : ?>
                <div class="py-4">
                    <button type="button" class="faq-toggle flex justify-between items-center w-full text-left sm:text-[24px] text-[20px] font-medium text-black cursor-pointer">
                        Description
                    <span class="toggle-icon text-[24px] width-[24px] height-[24px] transition-transform duration-300">+</span>
                    </button>
                    <div class="faq-content overflow-hidden max-h-0 transition-all duration-500 ease-in-out text-base leading-[1.2] text-black font-normal">
                    <div class="pt-4 sm:text-xl text-lg">
                        <?php the_content(); ?>
                    </div>
                    </div>
                </div>
            <?php endif; ?>

            <?php $global_product_page_content = get_field('global_product_page_content', 'option'); ?>

            <?php if( $global_product_page_content && !empty($global_product_page_content['delivery_policy']) ) : ?>

                <div class="py-4">
                    <button type="button" class="faq-toggle flex justify-between items-center w-full text-left sm:text-[24px] text-[20px] font-medium text-black cursor-pointer">
                        Delivery Policy
                        <span class="toggle-icon text-[24px] transition-transform duration-300">+</span>
                    </button>
                    <div class="faq-content overflow-hidden max-h-0 transition-all duration-500 ease-in-out text-base leading-[1.2] text-black font-normal">
                        <div class="pt-4 sm:text-xl text-lg">
                            <?= $global_product_page_content['delivery_policy']; ?>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <?php if( $global_product_page_content && !empty($global_product_page_content['how_it_works']) ) : ?>
                <div class="py-4">
                    <button type="button" class="faq-toggle flex justify-between items-center w-full text-left sm:text-[24px] text-[20px] font-medium cursor-pointer">
                        How it works
                        <span class="toggle-icon text-[24px] transition-transform duration-300">+</span>
                    </button>
                    <div class="faq-content overflow-hidden max-h-0 transition-all duration-500 ease-in-out text-base leading-[1.2] text-black font-normal">
                        <div class="pt-4 sm:text-xl text-lg">
                            <?= $global_product_page_content['how_it_works']; ?>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <div class="py-4 flex justify-between items-center cursor-pointer" id="sizeGuideBtn2">
                <span class="sm:text-[24px] text-[20px] font-medium text-black">Size Guide</span>
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                </svg>
            </div>

            </div>
        </div>
    </div>
</section>



<section class="mt-44 pb-14">
    <div class="container mx-auto px-4">
        <h2 class="text-3xl font-medium text-[#27221E] mb-8">You May Also Like</h2>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8">
            <?php $args = array(
                'post_type' => 'product',
                'posts_per_page' => 4,
                'orderby' => 'rand',
                'post_status' => 'publish',
                'post_not_in' => array( $current_id ),
            );

            $product_cats = wp_get_post_terms( $current_id, 'product_cat' );
            if ( $product_cats && ! is_wp_error( $product_cats ) ) {
                $cat_ids = array();
                foreach( $product_cats as $cat ) {
                    $cat_ids[] = $cat->term_id;
                }
                
                $args = array(
                    'post_type' => 'product',
                    'posts_per_page' => 4,
                    'post_status' => 'publish',
                    'post_not_in' => array( $current_id ),
                    'tax_query' => array(
                        array(
                            'taxonomy' => 'product_cat',
                            'field'    => 'term_id',
                            'terms'    => $cat_ids,
                        ),
                    ),
                );
            }

            $related_products = new WP_Query( $args );

            if( $related_products->have_posts() ) : 
                while( $related_products->have_posts() ) : 
                    $related_products->the_post(); 

                    global $product;
                    $product_id = $product->get_id();
                    $product_link = get_permalink( $product_id );
                    $product_image = get_post_thumbnail_id( $product_id ); ?>
    
                    <div class="group w-full">
                        <!-- Product Image -->
                        <a href="<?php echo esc_url( $product_link ); ?>" class="block overflow-hidden">
                            <?php if ( $product_image ) : ?>
                                <?= get_image($product_image, 'object-cover w-full h-full sm:h-[350px] md:h-[400px] lg:h-[435px]'); ?>
                            <?php else : ?>
                                <div class="w-full h-full sm:h-[350px] md:h-[400px] lg:h-[435px] bg-gray-200 flex items-center justify-center text-gray-500">
                                    No Image
                                </div>
                            <?php endif; ?>
                        </a>
        
                        <!-- Product Title -->
                        <h3 class="mt-4 text-[#27221E] font-medium text-[20px] leading-tight">
                            <a href="<?php echo esc_url( $product_link ); ?>" class="hover:underline">
                                <?php the_title(); ?>
                            </a>
                        </h3>
        
                        <!-- Product Price -->
                        <div class="mt-2">
                            <?php echo $product->get_price_html(); ?>
                        </div>
                    </div>
    
                <?php endwhile; ?>
            <?php else : ?>
                <div class="col-span-full text-center pb-4">
                    <p class="text-gray-500">No products found.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>



<!-- Size Guide Off-canvas - Working Version -->
<div id="sizeGuideOffcanvas" class="offcanvas-container">
    <!-- Overlay -->
    <div class="offcanvas-overlay" id="sizeGuideOverlay"></div>
    
    <!-- Off-canvas Panel -->
    <div class="offcanvas-panel" id="sizeGuidePanel">
        
        <!-- Header -->
        <div class="offcanvas-header">
            <h2 class="text-2xl font-medium text-[#252525] font-secondary">Size Guide</h2>
            <button id="closeSizeGuide" class="close-btn">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
        
        <!-- Content -->
        <div class="offcanvas-content">
            <?php $global_product_page_size_chart = get_field('global_product_page_size_chart', 'option');
            $chart_img = $global_product_page_size_chart['image_1'];
            $chart_img_2 = $global_product_page_size_chart['image_2'];

            if( $chart_img ) : ?>
                <div class="content-section">
                    <h3 class="text-xl font-medium text-[#252525] font-secondary">Size Chart</h3>
                    <div class="bg-gray-50 mt-6 mb-6 rounded-lg">
                        <?= get_image($chart_img, 'w-full h-auto rounded-md') ?>
                    </div>
                </div>
            <?php endif; ?>
            
            <?php if( $chart_img_2 ) : ?>
                <div class="content-section">
                    <h3 class="text-xl font-medium text-[#252525] font-secondary">How to Measure</h3>
                    <div class="bg-gray-50 mt-6">
                        <?= get_image($chart_img_2, 'w-full h-auto') ?>
                    </div>
                </div>
            <?php endif; ?>
            
        </div>
    </div>
</div>


<?php get_footer( 'shop' ); ?>