<?php
    $enable = get_field('enable');

    if( !$enable ) {
        return;
    }

    $image = get_field('image');
    $label = get_field('label');
    $heading = get_field('heading');
    $sub_heading = get_field('sub_heading');
    $first = get_field('paragraph')['first'];
    $second = get_field('paragraph')['second'];
    $ui = new HY_UI();
?>

<section class="sm:py-24 py-[54px] w-full">
  <div class="container mx-auto px-4 flex flex-col lg:flex-row items-center lg:justify-between gap-12">

    <!-- Image (left) -->
    <div class="sm:flex justify-center hidden" data-aos="zoom-in" data-aos-delay="100">
      <?php if( $image ) {
        echo get_image($image, 'sm:w-[527px] sm:h-[738px] w-[345px] h-[434px] object-cover');
      } ?>
    </div>

    <!-- Text Area -->
    <div class="w-full xl:basis-2/6 text-left">
      <?php if( $label ) : ?>
        <div class="sm:text-sm text-[12px] text-[#6D6D6D] font-secondary mb-6"
             data-aos="fade-up" data-aos-delay="50">
          <?= $ui->label( $label ) ?>
        </div>
      <?php endif; ?>

      <?php if( $heading ) : ?>

        <?= $ui->section_heading(  $heading, 'text-[40px] font-primary font-normal max-w-[517px]' ); ?>
      <?php endif; ?>

      <?php if( $sub_heading ) : ?>
        <h3 class="text-2xl text-black leading-[1.43] font-light font-secondary mt-[19px] max-w-[235px] sm:max-w-[100%]"
            data-aos="fade-up" data-aos-delay="150">
          <?= $sub_heading; ?>
        </h3>
      <?php endif; ?>

      <!-- Image shown on mobile -->
      <div class="justify-center sm:hidden mt-[24px]" data-aos="zoom-in" data-aos-delay="100">
        <?php if( $image ) {
          echo get_image($image, 'sm:w-[527px] sm:h-[738px] w-full h-[434px] object-cover');
        } ?>
      </div>

      <!-- Paragraphs and Button -->
      <div id="readMoreContainer">
        <?php if( $first ) : ?>
          <div class="text-[#27221E] font-light leading-[1.3] font-secondary mt-[18px] max-w-[517px]" data-aos="fade-up" data-aos-delay="200">
            <?= $ui->paragraph( $first ); ?>
          </div>
        <?php endif; ?>

        <?php if( $second ) : ?>
          <div id="secondPara" class="text-[#27221E] font-light leading-[1.3] font-secondary max-w-[517px] truncate-4" data-aos="fade-up" data-aos-delay="250">
            <?= $ui->paragraph( $second ); ?>
          </div>
        <?php endif; ?>


        <div data-aos="fade-up" data-aos-delay="300">
            <div class="btn-aware-wrapper relative inline-block">
                <button id="toggleBtn" class="btn-aware btn-aware-black relative inline-block px-8 py-3 text-base font-medium border border-black rounded-xl overflow-hidden backdrop-blur-[2px] z-10 cursor-pointer mt-4">
                    <span class="readme-title">Read More</span>
                    <span class="btn-aware-circle"></span>
                </button>
            </div>
        </div>

      </div>
    </div>
    <!-- Col 1: Empty space on large screens -->
    <div class="hidden xl:block xl:basis-1/10"></div>

  </div>
</section>