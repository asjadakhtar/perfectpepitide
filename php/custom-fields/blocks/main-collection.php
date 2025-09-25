<?php
    $enable = get_field('enable');

    if( !$enable ) {
        return;
    }

    $category = get_field('category');
    $name = get_the_category_by_ID( $category );
    $description = category_description( $category );
    $link = get_category_link( $category );
?>

<section class="container mx-auto px-4 lg:my-[140px] my-16">
    <div class="flex flex-col lg:flex-row items-start mb-12">
        <?php if( $name ) : ?>
            <h2 class="text-[32px] font-medium text-[#27221E] font-secondary" data-aos="fade-in" data-aos-delay="0">
                <?= $name; ?>
            </h2>
        <?php endif; ?>

        <div class="max-w-[427px] lg:ml-[350px] mb-6 lg:mt-0" data-aos="fade-up" data-aos-delay="300">
            <?php if( $description ) : ?>
                <p class="text-sm text-[#6C6C6C] font-normal font-secondary leading-relaxed mb-4">
                    <?= $description; ?>
                </p>
            <?php endif; ?>

            <?php if( $link ) : ?>
                <a href="<?= $link; ?>" 
                    class="inline-block border border-black px-[22px] py-[12px] rounded-[12px] font-secondary text-base font-medium hover:bg-black hover:text-white transition-all mt-4" data-aos="fade-in" data-aos-delay="1000">
                    Explore Collection
                </a>
            <?php endif; ?>
        </div>
    </div>

    <div class="relative">
        <div class="swiper hy-collection-swiper mobile-overflow-visible">
            <div class="swiper-wrapper">
                <?php $args = array(
                    'post_type'      => 'product',
                    'post_status'    => 'publish',
                    'posts_per_page' => -1,
                    'tax_query'      => array(
                        array(
                            'taxonomy'         => 'product_cat',
                            'field'            => 'id',
                            'terms'            => $category,
                            'include_children' => true,
                            'operator'         => 'IN',
                        ),
                    ),
                );
                $loop = new WP_Query( $args );

                if(  $loop->have_posts() ) :
                    $i = 1;
                    while( $loop->have_posts() ) : $loop->the_post();
                        global $product;
                        $image_id = get_post_thumbnail_id();
                        $link = get_the_permalink();
                        $title = get_the_title();
                        $price = get_post_meta( get_the_ID(), '_regular_price', true );
                        $sale_price = get_post_meta( get_the_ID(), '_sale_price', true );
                        $off = ( $sale_price ) ? $price - $sale_price : ''; ?>

                        <div class="swiper-slide">
                            <div data-aos="zoom-in" data-aos-delay="<?= $i * 400; ?>">
                                <a href="<?= $link; ?>" class="block">
                                    <div class="sm:h-[435px] bg-gray-200 relative group image-container overflow-hidden">
                                        <?php 
                                            if( $image_id ) {
                                                echo get_image($image_id, 'object-cover w-full h-full transition-transform duration-300 group-hover:scale-105');
                                            }
                                        ?>
    
                                        <?php if( $off ) : ?>
                                        <div class="absolute top-4 left-4 bg-white text-[#27221E] text-xs font-semibold px-3 py-1 rounded-full uppercase tracking-wider 
                                                    opacity-0 group-hover:opacity-100 transition-opacity duration-300 shadow-md z-10">
                                            <?= $off . '% off'; ?>
                                        </div>
                                        <?php endif; ?>
    
                                        <div class="absolute top-4 right-4 flex flex-col gap-2 hover-icons">
                                            <div class="p-2 bg-white rounded-full shadow-lg hover:bg-blue-100 transition-colors duration-200">
                                                <?php hy_shared_btn( $title, $link, '', '' ); ?>
                                            </div>
    
                                            <div class="p-2 bg-white rounded-full shadow-lg hover:bg-blue-100 transition-colors duration-200 yith-text-none">
                                                <?php echo do_shortcode('[yith_wcwl_add_to_wishlist]'); ?>
                                            </div>
                                        </div>
                                    </div>
                                </a>
    
                                <h3 class="mt-4 text-[#27221E] font-medium text-[20px] font-secondary">
                                    <a href="#" class="hover:underline"><?= $title; ?></a>
                                </h3>
    
                                <div class="mt-2">
                                    <?php echo $product->get_price_html(); ?>
                                </div>
                            </div>
                        </div>
                    <?php $i++;
                    endwhile;
                endif; ?>
            </div>
        </div>

        <!-- Scroll Arrows -->
        <div class="flex justify-end gap-4 mt-8">
            <!-- Left Arrow -->
            <button class="p-2 hy-arrow-left">
                <svg width="28" height="28" viewBox="0 0 15 15" fill="none">
                    <path fill-rule="evenodd" clip-rule="evenodd"
                        d="M6.85355 3.14645C7.04882 3.34171 7.04882 3.65829 6.85355 3.85355L3.70711 7H12.5C12.7761 7 13 7.22386 13 7.5C13 7.77614 12.7761 8 12.5 8H3.70711L6.85355 11.1464C7.04882 11.3417 7.04882 11.6583 6.85355 11.8536C6.65829 12.0488 6.34171 12.0488 6.14645 11.8536L2.14645 7.85355C1.95118 7.65829 1.95118 7.34171 2.14645 7.14645L6.14645 3.14645C6.34171 2.95118 6.65829 2.95118 6.85355 3.14645Z"
                        fill="#000000" />
                </svg>
            </button>

            <!-- Right Arrow -->
            <button class="p-2 hy-arrow-right">
                <svg width="28" height="28" viewBox="0 0 15 15" fill="none">
                    <path fill-rule="evenodd" clip-rule="evenodd"
                        d="M8.14645 3.14645C8.34171 2.95118 8.65829 2.95118 8.85355 3.14645L12.8536 7.14645C13.0488 7.34171 13.0488 7.65829 12.8536 7.85355L8.85355 11.8536C8.65829 12.0488 8.34171 12.0488 8.14645 11.8536C7.95118 11.6583 7.95118 11.3417 8.14645 11.1464L11.2929 8H2.5C2.22386 8 2 7.77614 2 7.5C2 7.22386 2.22386 7 2.5 7H11.2929L8.14645 3.85355C7.95118 3.65829 7.95118 3.34171 8.14645 3.14645Z"
                        fill="#000000" />
                </svg>
            </button>
        </div>
    </div>
</section>