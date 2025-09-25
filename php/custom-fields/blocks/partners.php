<?php
    $enable = get_field('enable');

    if( !$enable ) {
        return;
    }

    $title = get_field('title');
    $gallery = get_field('gallery');
    $ui = new HY_UI();

?>

<section class="py-8">
    <div class="container mx-auto px-4 text-center">
        <?php if( $title ) : ?>
            <h2 class="text-[#27221E] text-xl font-light mb-[40px]" data-aos="fade-up" data-aos-delay="50">
                <?= $title; ?>
            </h2>
        <?php endif; ?>

        <!-- Responsive layout: scroll below lg, grid on lg and up -->
        <div class="flex lg:grid lg:grid-cols-6 gap-x-10 lg:gap-x-20 gap-y-8 overflow-x-auto lg:overflow-visible pb-2">
            <?php if( $gallery ) :
                foreach( $gallery as $i => $image ) :
                    if( $image ) :
                        $delay = 100 + ($i * 50); ?>
                        <div class="shrink-0 w-[146px] h-[54px] flex items-center justify-center"
                             data-aos="zoom-in" data-aos-delay="<?= $delay; ?>">
                            <?= get_image($image, '', 'h-[54px] max-h-24 w-[146px] object-contain'); ?>
                        </div>
                    <?php endif;
                endforeach;
            endif; ?>
        </div>
    </div>
</section>
