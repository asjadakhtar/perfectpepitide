<?php 
/*
 * Template Name: Container Template
 *
 */
get_header(); ?>

<main id="container-template" class="<?php echo esc_attr(get_post_field('post_name', get_post())); ?> mt-20 lg:pt-14 pt-6 lg:pb-10 pb-0">
    <div class="container mx-auto px-4">
        <?php the_content(); ?>
    </div>
</main>

<?php get_footer(); ?>