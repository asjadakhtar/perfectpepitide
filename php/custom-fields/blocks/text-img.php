<?php
    $enable = get_field('enable');

    if( !$enable ) {
        return;
    }

    $image = get_field('content')['image'];
    $label = get_field('content')['text']['label'];
    $editor = get_field('content')['text']['editor'];
?>

<section class="lg:my-24 my-12">
    <div class="container mx-auto px-5">
        <div class="flex flex-col lg:flex-row items-center lg:justify-between gap-12">
            <div data-aos="zoom-in" data-aos-delay="100">
                <?php if( $image ) {
                    echo get_image($image, 'sm:w-[527px] sm:h-[738px] w-[345px] h-[434px] object-cover');
                } ?>
            </div>

            <div class="w-full xl:basis-2/6 text-left">
                <?php if( $label ) : ?>
                    <h5 class="uppercase tracking-wide sm:text-sm text-[12px] text-[#6D6D6D] font-secondary mb-[24px]"
                        data-aos="fade-left" data-aos-delay="0">
                    <?= $label; ?>
                    </h5>
                <?php endif; ?>

                <?php if( $editor ) : ?>
                    <div class="sm:text-[20px] text-[18px] text-[#27221E] font-light leading-[1.3] font-secondary mt-[18px] max-w-[517px]"
                        data-aos="fade-left" data-aos-delay="200" id="text-img-editor">
                        <?= $editor; ?>
                    </div>
                <?php endif; ?>
            </div>

            <div class="hidden xl:block xl:basis-1/10"></div>
        </div>
    </div>
</section>