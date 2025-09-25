<?php
    $enable = get_field('enable');

    if(  !$enable ) {
        return;
    }

    $heading = get_field('heading');
    $button = get_field('button');
    $ui = new HY_UI();

?>

<section class="bg-[#f3f3ef] flex items-center justify-center mb-8 sm:mt-32 mt-16 sm:py-32 py-16">
    <div class="container text-center px-4">
        <?php if( $heading ) : ?>
            <div class="text-[#212121] max-w-[523px] mx-auto" data-aos="fade-up" data-aos-delay="50">
                <?= $ui->main_heading(  $heading ); ?>
            </div>
        <?php endif; ?>

        <?php if( $button ) : ?>
           <div class="mt-8" data-aos="fade-up" data-aos-delay="150">
                <?= $ui->black_button( $button['title'], $button['url'], $button['target'] ); ?>
            </div>
        <?php endif; ?>
    </div>
</section>