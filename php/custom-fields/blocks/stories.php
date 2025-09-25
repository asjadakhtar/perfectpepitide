<?php
    $enable = get_field('enable');

    if( !$enable ) {
        return;
    }

    $cards = get_field('cards');
    $ui = new HY_UI();
?>

<section class="py-16 text-center">
    <div class="container mx-auto px-4">
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-y-12 md:gap-y-0 text-[#27221E]">
            <?php if( $cards ) :
                foreach( $cards as $i => $card ) :
                    if( $card ) :
                        $border = $i % 4 !== 0 ? 'md:border-l border-[#D1D1D1]' : '';
                        $delay = 200 * $i; ?>
                        
                        <div class="px-6 md:px-4 flex flex-col items-center <?= $border; ?> <?= $i > 3 ? 'mt-8' : ''; ?>"
                             data-aos="fade-up" 
                             data-aos-delay="<?= $delay; ?>">
                             
                            <?php if( $card['title'] ) : ?>
                                <?= $ui->small_title( $card['title'], 'mb-2' ); ?>
                            <?php endif; ?>

                            <?php if( $card['paragraph'] ) : ?>
                                <?= $ui->small_paragraph( $card['paragraph'] ); ?>
                            <?php endif; ?>
                        </div>

                    <?php endif;
                endforeach;
            endif; ?>
        </div>
    </div>
</section>