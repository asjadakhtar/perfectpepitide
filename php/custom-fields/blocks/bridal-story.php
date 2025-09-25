<?php
    $enable = get_field('enable');

    if( !$enable ) {
        return;
    }

    $image = get_field('background_image');
    $heading = get_field('heading');
    $first = get_field('paragraph')['first'];
    $second = get_field('paragraph')['second'];
    $button = get_field('button');

    $ui = new HY_UI();
?>

<section class="relative h-screen bg-cover bg-center sm:bg-fixed bg-scroll text-white flex items-center justify-center px-4"
    data-aos="fade-in"
    <?php if( $image ) : ?>
        style="background-image: url('<?= $image; ?>');"
    <?php endif; ?> >
  
    <div class="absolute inset-0 sm:bg-black/40 bg-black/60 z-0"></div>

    <div class="relative z-10 max-w-3xl text-center">
        <?php if( $heading ) : ?>
            <div data-aos="fade-up" data-aos-delay="500">
                <?= $ui->section_heading( $heading, 'sm:mb-8 mb-8 max-w-[600px] mx-auto' ); ?>
            </div>
        <?php endif; ?>

        <?php if( $first ) : ?>
            <div data-aos="fade-up" data-aos-delay="600">
                <?= $ui->paragraph( $first, 'text-white/80 mb-[22px] max-w-[650px] mx-auto' ); ?>
            </div>
        <?php endif; ?>

        <?php if( $second ) : ?>
            <div data-aos="fade-up" data-aos-delay="700">
                <?= $ui->paragraph( $second, 'text-white/80 max-w-[650px] mx-auto sm:mb-[44px] mb-[37px]' ); ?>
            </div>
        <?php endif; ?>

        <?php if( $button) : ?>
            <div data-aos="fade-up" data-aos-delay="800">
                <?= $ui->button( $button['title'], $button['url'], $button['target'] ); ?>
            </div>
        <?php endif; ?>
    </div>
</section>
