<?php
    $site_logo = get_field('site_logo', 'option');
    $column_2 = get_field('column_2', 'option') ?: [];
    $column_3 = get_field('column_3', 'option') ?: [];
    $column_4 = get_field('column_4', 'option') ?: [];
    $bottom = get_field('bottom', 'option') ?: [];

    $global_social_media = get_field('global_social_media', 'option') ?: [];
    $facebook = $global_social_media['facebook'] ?? '';
    $instagram = $global_social_media['instagram'] ?? '';
    $twitter = $global_social_media['twitter'] ?? '';
    $linkedin = $global_social_media['linkedin'] ?? '';
?>

<footer id="footer" class="lg:mt-24 mt-12 mb-9">
    <?php if( !is_checkout() ) : ?>
    <div class="container mx-auto px-5">
        <div class="grid grid-cols-12 gap-x-6 gap-y-12">
            <!-- Logo -->
            <div class="xl:col-span-3 sm:col-span-4 col-span-12 flex justify-start">
                <?php $image_url = wp_get_attachment_image_src($site_logo, 'full'); ?>
                <img src="<?php echo esc_url($image_url[0]); ?>" alt="Site logo" class="w-50 lg:w-40" style="height: fit-content;">
            </div>

            <!-- Column 2 -->
            <div class="xl:col-span-2 sm:col-span-4 col-span-12">
                <?php
                    if (!empty($column_2['heading'])) {
                        echo '<h3 class="text-2xl font-medium italic mb-6 font-primary">' . esc_html($column_2['heading']) . '</h3>';
                    }
                    if( $column_2['enable'] ) {
                        wp_nav_menu(array('theme_location' => 'brand-menu'));
                    }
                ?>
            </div>

            <!-- Column 3 -->
            <div class="xl:col-span-2 sm:col-span-4 col-span-12">
                <?php
                    if (!empty($column_3['heading'])) {
                        echo '<h3 class="text-2xl font-medium italic mb-6 font-primary">' . esc_html($column_3['heading']) . '</h3>';
                    }
                    if( $column_3['enable'] ) {
                        wp_nav_menu(array('theme_location' => 'service-menu'));
                    }
                ?>
            </div>

            <!-- Spacer -->
            <div class="col-span-1 xl:block hidden"></div>

            <!-- Column 4 -->
            <div class="xl:col-span-4 sm:col-span-6 col-span-12">
                <?php
                    if (!empty($column_4['heading'])) {
                        echo '<h3 class="text-2xl font-medium italic mb-3 font-primary">' . esc_html($column_4['heading']) . '</h3>';
                    }
                    if (!empty($column_4['content'])) {
                        echo '<p class="mb-6">' . esc_html($column_4['content']) . '</p>';
                    }
                    if (!empty($column_4['enable'])) {
                        echo do_shortcode('[contact-form-7 id="242b998" title="Newsletter"]');
                    }
                ?>
            </div>
        </div>
    </div>
    <?php endif; ?>

    <div class="border-b border-gray-300 my-6"></div>

    <div class="container mx-auto px-5">
        <div class="flex flex-col sm:flex-row justify-between items-center gap-4">
            <!-- Copyright -->
            <?php
                $alignment = is_checkout() ? 'text-center w-full' : 'sm:text-left';
                if (!empty($bottom['copywrite'])) {
                    echo '<p class="text-center ' . $alignment . '">' . esc_html($bottom['copywrite']) . '</p>';
                }
            ?>

            <!-- Social Icons -->
            <?php if( !is_checkout() ) : ?>
                <div class="flex items-center justify-between gap-4">
                    <?php
                        if (!empty($bottom['social_media'])) :
                            foreach ($bottom['social_media'] as $item) : ?>
                                <?php if ($item === 'fb' && $facebook) : ?>
                                    <a href="<?= esc_url($facebook); ?>" target="_blank" rel="noopener noreferrer">
                                        <?= get_svg('footer_facebook', 'facebook', 'w-6 h-6'); ?>
                                    </a>
                                <?php endif; ?>

                                <?php if ($item === 'in' && $instagram) : ?>
                                    <a href="<?= esc_url($instagram); ?>" target="_blank" rel="noopener noreferrer">
                                        <?= get_svg('footer_instagram', 'instagram', 'w-6 h-6'); ?>
                                    </a>
                                <?php endif; ?>

                                <?php if ($item === 'x' && $twitter) : ?>
                                    <a href="<?= esc_url($twitter); ?>" target="_blank" rel="noopener noreferrer">
                                        <?= get_svg('footer_twitter', 'twitter', 'w-6 h-6'); ?>
                                    </a>
                                <?php endif; ?>

                                <?php if ($item === 'li' && $linkedin) : ?>
                                    <a href="<?= esc_url($linkedin); ?>" target="_blank" rel="noopener noreferrer">
                                        <?= get_svg('footer_linkedin', 'linkedin', 'w-6 h-6'); ?>
                                    </a>
                                <?php endif; ?>
                            <?php endforeach;
                        endif;
                    ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</footer>