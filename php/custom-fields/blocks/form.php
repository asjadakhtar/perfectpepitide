<?php
    $heading = get_field('heading');
    $shortcode = get_field('shortcode');
?>

<section class="my-24 lg:py-12">
    <div class="container mx-auto px-5">
        <?php if( $heading ) : ?>
            <h2 class="font-primary text-center text-4xl italic font-medium text-[#27221E] mb-12"data-aos="fade-in"><?= $heading; ?></h2>
        <?php endif; ?>

        <?php if( $shortcode ) : ?>
            <div data-aos="fade-in" data-aos-delay="250">
                <?= do_shortcode($shortcode); ?>
            </div>
        <?php endif; ?>
    </div>
</section>