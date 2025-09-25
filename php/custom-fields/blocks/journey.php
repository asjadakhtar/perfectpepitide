<?php
    $enable = get_field('enable');

    if( !$enable ) {
        return;
    }

    $label = get_field('label');
    $heading = get_field('heading');
    $cards = get_field('cards');
    $ui = new HY_UI();
?>

<section class="bg-[#F5F5F3] py-24">
    <div class="container mx-auto px-4">

        <?php if( $label ) : ?>
            <?= $ui->label( $label, 'text-[#27221E] mb-4 text-center' ) ?>
        <?php endif; ?>

        <?php if( $heading ) : ?>
            <?= $ui->section_heading(  $heading, 'sm:mb-8 mb-8 text-[#27221E] max-w-[530px] mx-auto text-center' ); ?>
        <?php endif; ?>

        <div class="flex flex-col md:flex-row justify-center items-stretch gap-8">
            <?php if( $cards ) :
                foreach( $cards as $i => $card ) :
                    if( $card ) :
                        $title = $card['title'];
                        $paragraph = $card['paragraph'];
                        $button = $card['button'];
                        $delay = 200 + ($i * 100); // 200ms, 300ms, 400ms...
                        ?>

                        <div class="bg-[#FFFFFF] border border-[#D1D1D1] sm:py-[55px] sm:px-[60px] p-[32px] w-full max-w-[560px]"
                             data-aos="fade-up"
                             data-aos-delay="<?= $delay; ?>">
                             
                            <?php if( $title ) : ?>
                                <?= $ui->title( $title, 'mb-5' ); ?>
                            <?php endif; ?>

                            <?php if( $paragraph ) : ?>
                                <?= $ui->small_paragraph( $paragraph, 'text-black text-lg mb-5' ); ?>
                            <?php endif; ?>

                            <?php if( $button ) : ?>
                                <?= $ui->black_button( $button['title'], $button['url'], $button['target'] ); ?>
                            <?php endif; ?>
                        </div>

                    <?php endif; 
                endforeach; 
            endif; ?>
        </div>
    </div>
</section>