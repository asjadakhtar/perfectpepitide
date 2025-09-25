<?php
$enable = get_field('enable');
$label = get_field('label');
$heading = get_field('heading');
$ui = new HY_UI();

if( !$enable ) return;
?>

<section class="bg-[#F5F5F0] sm:py-48 py-12 sm:my-32 my-16">
  <div class="container mx-auto px-6">

    <!-- Section Heading -->
    <div class="text-center mb-12">
      <?php if( $label ) : ?>
       <?= $ui->label( $label, 'text-[#27221E] mb-4 text-center' ) ?>
      <?php endif; ?>

      <?php if( $heading ) : ?>
        <?= $ui->section_heading(  $heading, 'italic font-primary text-[#27221E] max-w-[290px] m-auto' ); ?>
      <?php endif; ?>
    </div>

    <!-- Query Testimonials -->
    <?php
    $args = array(
      'post_type'      => 'testimonials',
      'posts_per_page' => -1,
      'order'          => 'DESC',
      'meta_query'     => array(
        array(
          'key'     => '_is_featured',
          'value'   => '1',
          'compare' => '='
        )
      )
    );

    $query = new WP_Query($args);
    ?>

    <?php if( $query->have_posts() ) : ?>
      <!-- Swiper Container -->
      <div class="swiper testimonials-swiper">
        <div class="swiper-wrapper">
          <?php while( $query->have_posts() ) : $query->the_post(); ?>
            <?php
            $post_id   = get_the_ID();
            $images    = get_field('gallery', $post_id);
            $section   = get_field('section', $post_id);
            $paragraph = $section['quotation'] ?? '';
            $role      = $section['role'] ?? '';
            $customer  = get_the_title($post_id);
            $permalink = get_permalink($post_id);
             
            ?>

            <!-- Testimonial Slide -->
            <div class="swiper-slide">
              <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center mb-24">
                <!-- Image Side -->
                <div class="relative w-full flex sm:justify-center justify-start slide-image">
                  <div class="relative">
                    <?php if( !empty($images[0]) ) :
                      $image_1 = wp_get_attachment_image_src($images[0], 'full'); ?>
                      <img src="<?= esc_url($image_1[0]); ?>" alt="<?= esc_attr($customer); ?>"
                           class="sm:w-[298px] sm:h-[348px] w-[250px] h-[320px] object-cover"/>
                    <?php endif; ?>

                    <?php if( !empty($images[1]) ) :
                      $image_2 = wp_get_attachment_image_src($images[1], 'full'); ?>
                      <img src="<?= esc_url($image_2[0]); ?>" alt="<?= esc_attr($customer); ?>"
                           class="sm:w-[193px] sm:h-[195px] w-[140px] h-[140px] object-cover absolute sm:bottom-[-100px] sm:right-[-100px] -bottom-[40px] -right-[50px]"/>
                    <?php endif; ?>
                  </div>
                </div>

                <!-- Text Side -->
                <div class="text-left lg:mt-[32px] mt-[64px] slide-content">
                  <?php if( $paragraph ) : ?>
                    <?= $ui->large_paragraph(  $paragraph, 'max-w-[648px] font-normal font-secondary mx-auto lg:mx-0' ); ?>
                  <?php endif; ?>

                  <?php if( $customer ) : ?>
                    <p class="italic font-primary text-2xl font-normal text-[#27221E] mb-1"><?= $customer; ?></p>
                  <?php endif; ?>

                  <?php if( $role ) : ?>
                    <p class="text-base font-medium font-secondary text-[#535353]"><?= $role; ?></p>
                  <?php endif; ?>

                
                  <div class="flex justify-between">
                    <!-- Read More Button -->
                    <div class="mt-5">
                      <?= $ui->black_button( 'Read More', $permalink ); ?>
                    </div>  
                    <!-- Navigation Arrows -->
                    <div class="flex justify-center gap-6 mt-8">
                      <button id="testimonial-arrow-left" class="z-4 hover:opacity-50 transition-all duration-300 hover:scale-110">
                        <!-- SVG Left -->
                        <svg width="28px" height="28px" viewBox="0 0 15 15" fill="none" xmlns="http://www.w3.org/2000/svg">
                          <path fill-rule="evenodd" clip-rule="evenodd" d="M6.85355 3.14645C7.04882 3.34171 7.04882 3.65829 6.85355 3.85355L3.70711 7H12.5C12.7761 7 13 7.22386 13 7.5C13 7.77614 12.7761 8 12.5 8H3.70711L6.85355 11.1464C7.04882 11.3417 7.04882 11.6583 6.85355 11.8536C6.65829 12.0488 6.34171 12.0488 6.14645 11.8536L2.14645 7.85355C1.95118 7.65829 1.95118 7.34171 2.14645 7.14645L6.14645 3.14645C6.34171 2.95118 6.65829 2.95118 6.85355 3.14645Z" fill="#000000"/>
                        </svg>
                      </button>

                      <button id="testimonial-arrow-right" class="z-4 hover:opacity-50 transition-all duration-300 hover:scale-110">
                        <!-- SVG Right -->
                        <svg width="28px" height="28px" viewBox="0 0 15 15" fill="none" xmlns="http://www.w3.org/2000/svg">
                          <path fill-rule="evenodd" clip-rule="evenodd" d="M8.14645 3.14645C8.34171 2.95118 8.65829 2.95118 8.85355 3.14645L12.8536 7.14645C13.0488 7.34171 13.0488 7.65829 12.8536 7.85355L8.85355 11.8536C8.65829 12.0488 8.34171 12.0488 8.14645 11.8536C7.95118 11.6583 7.95118 11.3417 8.14645 11.1464L11.2929 8H2.5C2.22386 8 2 7.77614 2 7.5C2 7.22386 2.22386 7 2.5 7H11.2929L8.14645 3.85355C7.95118 3.65829 7.95118 3.34171 8.14645 3.14645Z" fill="#000000"/>
                        </svg>
                      </button>
                    </div>
                  </div>

                </div>
              </div>
            </div>
          <?php endwhile; wp_reset_postdata(); ?>
        </div>
      </div>

      
    <?php endif; ?>

  </div>
</section>