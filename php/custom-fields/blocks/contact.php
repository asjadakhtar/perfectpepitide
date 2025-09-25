<?php
    $heading = get_field('heading');
    $editor = get_field('editor');
    $location = get_field('location');
    $address = $location['address'];
    $email = $location['email'];
    $phone = $location['phone'];

    $map = get_field('map');
    $stocklist = get_field('stocklist');
?>

<section class="lg:my-24 my-12">
    <div class="max-w-[1300px] mx-auto px-5">
        <?php if( $heading ) : ?>
            <h2 class="font-primary text-center text-4xl italic font-medium text-[#27221E] mb-12" data-aos="fade-in"><?= $heading; ?></h2>
        <?php endif; ?>

        <div class="flex flex-wrap gap-y-12">
            <?php if( $address) : ?>
                <div class="md:w-1/3 w-full md:px-5">
                    <div class="shadow w-full px-5 py-7" data-aos="fade-up" data-aos-delay="200">
                        <h3 class="text-2xl mb-5 font-medium text-center">Our Address</h3>
                        <p class="text-lg text-center"><?= $address; ?></p>
                    </div>
                </div>
            <?php endif; ?>

            <?php if( $email) : ?>
                <div class="md:w-1/3 w-full md:px-5">
                    <div class="shadow w-full px-5 py-7" data-aos="fade-up" data-aos-delay="400">
                        <h3 class="text-2xl mb-5 font-medium text-center">Our Email</h3>
                        <p class="text-lg text-center"><?= $email; ?></p>
                    </div>
                </div>
            <?php endif; ?>
            
            <?php if( $phone) : ?>
                <div class="md:w-1/3 w-full md:px-5">
                    <div class="shadow w-full px-5 py-7" data-aos="fade-up" data-aos-delay="600">
                        <h3 class="text-2xl mb-5 font-medium text-center">Our Phone</h3>
                        <p class="text-lg text-center"><?= $phone; ?></p>
                    </div>
                </div>
            <?php endif; ?>
        </div>

        <?php if( $map ) : ?>
            <div class="mt-12 md:px-5" id="hy-contact-map">
                <?= $map; ?>
            </div>
        <?php endif; ?>

        <?php if( $stocklist) : ?>
            <div class="flex flex-wrap lg:mt-24 mt-12" id="hy-contact-stock">
                <?php foreach( $stocklist as $i => $place ) :
                    if( $place['editor'] ) : ?>
                        <?php
                        if( $i != 0 ) {
                            echo '<div class="md:hidden block w-full h-px bg-[#D1D1D1] my-6"></div>';
                        }
                        ?>
                        <div class="md:w-1/3 w-full <?= $i !== 0 ? 'md:border-l border-[#D1D1D1]' : ''; ?>">
                            <div data-aos="fade-up" data-aos-delay="<?= $i * 200; ?>">
                                <?= $place['editor']; ?>
                            </div>
                        </div>
                    <?php endif;
                endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</section>