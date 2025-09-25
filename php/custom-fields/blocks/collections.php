<?php
    $enable = get_field('enable');

    if( !$enable ) {
        return;
    }

    $label = get_field('label');
    $heading = get_field('heading');
    $button = get_field('button');
    $collection = get_field('collections');
    $ui = new HY_UI();

?>

<section class="text-center py-[108px] px-4">
    <div class="max-w-screen-2xl mx-auto">
        <?php if( $label ) : ?>
            <p class="uppercase text-base font-secondary text-[#27221E] tracking-widest"
               data-aos="fade-up" data-aos-delay="50"><?= $label; ?></p>
        <?php endif; ?>

        <?php if( $heading ) : ?>
            <div class="font-primary font-light sm:my-6 my-0 flex justify-center" data-aos="fade-up" data-aos-delay="100">
                <?= $ui->main_heading(  $heading ); ?>
            </div>
        <?php endif; ?>

        <?php if( $button ) : ?>
            <a href="<?= $button['url']; ?>" 
               class="inline-block px-6 py-3 border border-black sm:text-base text-sm font-medium font-secondary rounded-[12px] uppercase tracking-wider hover:bg-black hover:text-white transition"
               target="<?= esc_attr($button['target']); ?>"
               data-aos="fade-up" data-aos-delay="150">
                <?= $button['title']; ?>
            </a>
        <?php endif; ?>

        <!-- Flex Layout with Gap -->
        <div class="sm:mt-16 mt-12 flex flex-wrap justify-center gap-[16px]">
        <?php if( $collection ) :
            foreach( $collection as $i => $collect ) :
            if( $collect ) :
                $thumbnail_id = get_term_meta( $collect, 'thumbnail_id', true );
                $term = get_term( $collect );
                $term_link = get_term_link( $term );
                $delay = 200 + ($i * 100); // Stagger animation
                ?>

                <a href="<?= esc_url($term_link); ?>" 
                   class="relative sm:w-[48%] md:w-[30%] lg:w-[362px] lg:h-[550px] h-auto w-full group overflow-hidden block"
                   data-aos="zoom-in-up" data-aos-duration="700" data-aos-delay="<?= $delay; ?>">
                    <?= get_image( $thumbnail_id, 'w-full h-full object-cover transition-transform duration-500 group-hover:scale-110 group-hover:-translate-y-2' ); ?>

                    <div class="absolute inset-0 bg-black/30 hover:bg-black/0 transition-all duration-400 z-10 w-full h-full"></div>

                    <?php if( $term->name ) : ?>
                        <div class="absolute bottom-0 text-white text-left px-4 py-2 z-20 w-full">
                            <div class="flex flex-col items-start">
                                <div class="mb-3 border-t border-white w-full max-w-[320px]"></div>
                                <span class="text-3xl font-primary font-normal tracking-wider"><?= $term->name; ?></span>
                            </div>
                        </div>
                    <?php endif; ?>
                </a>

            <?php endif;
            endforeach;
        endif; ?>
        </div>
    </div>
</section>