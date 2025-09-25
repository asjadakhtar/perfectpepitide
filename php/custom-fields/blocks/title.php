<?php
    $enable = get_field('enable');

    if( !$enable ) {
        return;
    }

    $breadcrumbs = get_field('breadcrumbs');
    $title = get_field('title') ?: get_the_title();
?>

<section class="pt-16">
  <div class="container mx-auto px-4">
		<div class="text-sm text-[#797878] mb-4 font-medium mt-16" data-aos="fade-in" data-aos-delay="0">
            <?php if ( !empty($breadcrumbs) ) : ?>
                <?php foreach ( $breadcrumbs as $single ) : ?>
                    <?php if ( !empty($single) ) : ?>
                        <a href="<?= esc_url($single['link']['url']); ?>" class="hover:underline" target="<?= esc_attr($single['link']['target'] ?? '_self'); ?>">
                            <?= esc_html($single['link']['title']); ?>
                        </a>
                        /
                    <?php endif; ?>
                <?php endforeach; ?>
            <?php endif; ?>
            <span><?= esc_html($title); ?></span>
        </div>

		<h1 class="text-3xl font-medium text-[#27221E] mb-[36px]" data-aos="fade-in" data-aos-delay="500"><?= $title; ?></h1>
	</div>
</section>
