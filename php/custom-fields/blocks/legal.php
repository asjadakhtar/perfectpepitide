<?php
    $sections = get_field('sections');

    if( empty( $sections ) ) {
        return;
    }

    $last_key = array_key_last($sections);
?>

<section class="lg:mt-[120px] mt-12 py-12">
    <div class="max-w-[1024px] mx-auto px-5">
        <div class="flex gap-x-6 gap-y-12 sm:flex-row flex-col">
            <div class="sm:w-2/6 w-full">
                <?php foreach( $sections as $i => $single ) :
                    if( $single ) :
                        $title = $single['content']['title'];
                        if( !$title ) { return; } ?>
                        <a href="<?= '#legal-link-' . $i; ?>" data-aos="fade-in" data-aos-delay="<?= $i * 200; ?>">
                            <h2 class="text-xl font-medium py-3 sm:px-4 hover:bg-neutral-50 rounded-sm"><?= $title; ?></h2>
                        </a>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>

            <div class="sm:w-4/6 w-full">
                <div class="mt-2">
                    <?php foreach( $sections as $i => $single ) :
                        if( $single ) :
                            $title = $single['content']['title'];
                            $editor = $single['editor'];
                            if( !$title ) { return; } ?>
    
                                <div id="<?= 'legal-link-' . $i; ?>" data-aos="fade-in">
                                    <h2 class="text-2xl font-medium"><?= $title; ?></h2>
            
                                    <div class="flex gap-x-10 legal-image-editor">
                                        <?php if( $editor ) : ?>
                                            <div id="col-legal-page">
                                                <?= $editor; ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
    
                                <?= $i !== $last_key ? '<div class="my-8 h-px bg-gray-300 w-full"></div>' : ''; ?>
    
                        <?php endif; ?>
                    <?php endforeach; ?>

                </div>
            </div>
        </div>
    </div>
</section>