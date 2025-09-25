<?php
    $enable = get_field('enable');

    if( !$enable ) {
        return;
    }

    $label = get_field('label');
    $heading = get_field('heading');
    $first = get_field('paragraph')['first'];
    $second = get_field('paragraph')['second'];
    $button = get_field('button');
    $image = get_field('image');
    $ui = new HY_UI();
?>

<section class="sm:py-24 py-12 w-full">
    <div class="container mx-auto sm:px-4">
        <div class="flex flex-wrap gap-y-6 items-center">
          
            <div class="hidden xl:block w-1/12 order-1"></div>

            <div class="xl:w-4/12 lg:w-6/12 w-full lg:order-2 order-2 px-4 sm:px-0">
                <?php if( $label ) : ?>
                    <div data-aos="fade-right">
                        <?= $ui->label( $label, 'text-[#6D6D6D] mb-4' ); ?>
                    </div>
                <?php endif; ?>

                <?php if( $heading ) : ?>
                    <div data-aos="fade-right" data-aos-delay="200">
                        <?= $ui->section_heading( $heading, 'sm:mb-8 mb-8 max-w-[600px]' ); ?>
                    </div>
                <?php endif; ?>

                <?php if( $first ) : ?>
                    <div data-aos="fade-right" data-aos-delay="400">
                        <?= $ui->paragraph( $first, 'text-[#121212] mt-[18px] max-w-[414px]' ); ?>
                    </div>
                <?php endif; ?>

                <?php if( $second ) : ?>
                    <div data-aos="fade-right" data-aos-delay="400">
                        <?= $ui->paragraph( $second, 'text-[#121212] mt-[18px] max-w-[414px]' ); ?>
                    </div>
                <?php endif; ?>

                <?php if( $button ) : ?>
                    <div class="sm:mt-11 mt-6">
                        <div data-aos="fade-right" data-aos-delay="600">
                            <?= $ui->black_button( $button['title'], $button['url'], $button['target'] ); ?>
                        </div>
                    </div>
                <?php endif; ?>
            </div>

            <div class="hidden lg:block xl:w-2/12 w-1/12 order-3"></div>

            <div class="lg:w-5/12 w-full lg:order-4 order-1" data-aos="fade-left" data-aos-delay="300">
                <?php
                    if( $image ) {
                        echo get_image($image, 'w-full h-auto object-cover');
                    }
                ?>
            </div>
        </div>
    </div>
</section>
