<?php
/**
 * The main index template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 *
 * @package YourThemeName
 * @since 1.0.0
 */

get_header(); ?>

<main id="site-main" class="main-content overflow-hidden <?php echo esc_attr(get_post_field('post_name', get_post())); ?>">
        <?php the_content(); ?>
</main>

<?php get_footer(); ?>