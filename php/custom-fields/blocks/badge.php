<?php
    $heading = get_field('heading');
    $cards = get_field('cards');
?>

<section class="lg:my-24 mt-24 mb-12 lg:py-18">
    <div class="container mx-auto px-5">
        <h2 class="font-primary text-[#27221E] text-[40px] italic max-w-xl mx-auto mb-18 text-center" data-aos="fade-up">
            <?= $heading; ?>
        </h2>

        <?php if( $cards ) : ?>
            <div class="flex gap-y-12 flex-wrap">
                <?php foreach( $cards as $i => $card ) :
                    if( $card ) :
                        $title = $card['title'];
                        $paragraph = $card['paragraph']; ?>

                        <div class="xl:w-1/4 sm:w-1/2 w-full">
                            <div class="sm:px-5" data-aos="fade-up" data-aos-delay="<?= $i * 200; ?>">
                                <h3 class="text-[#27221E] text-2xl/tight font-meduim mb-4 text-center mx-auto"><?= $title; ?></h3>
                                <p class="text-[#27221E] text-lg font-light mb-4 text-center"><?= $paragraph; ?></p>
                            </div>
                        </div>

                    <?php endif;
                endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</section>