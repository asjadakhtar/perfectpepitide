<?php
    $enable = get_field('enable');

    if( !$enable ) {
        return;
    }

    $label = get_field('label');
    $heading = get_field('heading');
    $button = get_field('button');
    $name = get_field('collection_name');
    $collection = get_field('collections');
    $ui = new HY_UI();
?>

<section class="sm:py-32 py-16">
  <div class="container mx-auto px-4">

    <div class="text-center">
      <?php if( $label ) : ?>
        <?= $ui->label( $label, 'text-[#27221E] mb-4 text-center' ) ?>
      <?php endif; ?>

      <?php if( $heading ) : ?>
        <?= $ui->section_heading(  $heading, 'text-[#27221E] max-w-[530px] mx-auto text-center' ); ?>
      <?php endif; ?>

      <?php if( $button ) : ?>
        <div class="mt-6">
          <?= $ui->black_button( $button['title'], $button['url'], $button['target'] ); ?>
        </div>
      <?php endif; ?>
    </div>

    <!-- Scroll Wrapper -->
    <div class="overflow-x-auto xl:overflow-visible scroll-smooth touch-auto sm:touch-none">
      
      <!-- Flex Layout -->
      <div class="flex xl:justify-center gap-[16px] mt-[50px] w-max xl:w-full">

        <?php if( $collection ) :
          foreach( $collection as $i => $collect ) :
            if( $collect ) :
              $term = get_term( $collect, 'product_cat' );

              $args = array(
                'post_type' => 'product',
                'posts_per_page' => -1,
                'tax_query' => array(
                  array(
                    'taxonomy' => 'product_cat',
                    'field'    => 'term_id',
                    'terms'    => $collect,
                  ),
                ),
              );
              $products = get_posts( $args );
              $delay = 200 + ($i * 100); // stagger delay
        ?>

              <div class="relative group overflow-hidden sm:w-[425px] w-[290px] sm:h-[619px] h-[500px] shrink-0"
                   data-aos="zoom-in"
                   data-aos-delay="<?= $delay; ?>">

                <div class="swiper card-swiper-1 h-full pointer-events-none xl:pointer-events-auto">
                  <div class="swiper-wrapper">
                    <?php if ( $products ) :
                      foreach ( $products as $product ) :
                        $thumbnail_id = get_post_thumbnail_id( $product->ID );
                        $product_url = get_permalink( $product->ID );
                        echo '<div class="swiper-slide">';
                          echo '<a href="' . $product_url . '" class="block w-full h-full cursor-pointer relative z-10">';
                            echo get_image( $thumbnail_id, 'w-full h-full object-cover' );
                          echo '</a>';
                        echo '</div>';
                      endforeach;
                    endif; ?>
                  </div>

                  <div class="absolute inset-0 bg-black/20 z-5 pointer-events-none"></div>

                  <div class="absolute bottom-5 left-5 text-white z-20 pointer-events-none">
                    <?php if( $name ) : ?>
                      <h5 class="uppercase sm:text-base text-sm font-medium font-secondary tracking-widest"><?= $name; ?></h5>
                    <?php endif; ?>

                    <?php if( $term->name ) : ?>
                      <h2 class="sm:text-[40px] text-[32px] font-primary font-normal mb-2"><?= $term->name; ?></h2>
                    <?php endif; ?>
                  </div>

                  <div class="swiper-pagination absolute bottom-3 left-0 w-full z-30 flex justify-start pl-4 mb-2"></div>
                </div>
              </div>

        <?php
            endif;
          endforeach;
        endif; ?>
      </div>

      <!-- Scroll Arrows for mobile -->
      <div class="m">
        <button id="scroll-arrow-left" class="absolute mt-5 right-16 xl:hidden z-4">
          <!-- SVG Left -->
          <svg width="28px" height="28px" viewBox="0 0 15 15" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path fill-rule="evenodd" clip-rule="evenodd" d="M6.85355 3.14645C7.04882 3.34171 7.04882 3.65829 6.85355 3.85355L3.70711 7H12.5C12.7761 7 13 7.22386 13 7.5C13 7.77614 12.7761 8 12.5 8H3.70711L6.85355 11.1464C7.04882 11.3417 7.04882 11.6583 6.85355 11.8536C6.65829 12.0488 6.34171 12.0488 6.14645 11.8536L2.14645 7.85355C1.95118 7.65829 1.95118 7.34171 2.14645 7.14645L6.14645 3.14645C6.34171 2.95118 6.65829 2.95118 6.85355 3.14645Z" fill="#000000"/>
          </svg>
        </button>

        <button id="scroll-arrow-right" class="absolute mt-5 right-4 xl:hidden z-4">
          <!-- SVG Right -->
          <svg width="28px" height="28px" viewBox="0 0 15 15" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path fill-rule="evenodd" clip-rule="evenodd" d="M8.14645 3.14645C8.34171 2.95118 8.65829 2.95118 8.85355 3.14645L12.8536 7.14645C13.0488 7.34171 13.0488 7.65829 12.8536 7.85355L8.85355 11.8536C8.65829 12.0488 8.34171 12.0488 8.14645 11.8536C7.95118 11.6583 7.95118 11.3417 8.14645 11.1464L11.2929 8H2.5C2.22386 8 2 7.77614 2 7.5C2 7.22386 2.22386 7 2.5 7H11.2929L8.14645 3.85355C7.95118 3.65829 7.95118 3.34171 8.14645 3.14645Z" fill="#000000"/>
          </svg>
        </button>
      </div>

    </div>
  </div>
</section>
