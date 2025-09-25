
<!-- Main Container -->
<main class="max-w-[1380px] mx-auto px-6 sm:px-8 py-24 mt-24">

    <!-- Page Header -->
    <div class="text-center mb-16">
        <?php if ($label = get_field('blog_top_label')) : ?>
            <p class="text-sm font-medium text-gray-600 mb-4">
                <?php echo esc_html($label); ?>
            </p>
        <?php endif; ?>

        <?php if ($heading = get_field('blog_heading')) : ?>
            <h1 class="text-4xl sm:text-5xl font-medium text-gray-900 leading-tight mb-6 font-primary">
                <?php echo esc_html($heading); ?>
            </h1>
        <?php endif; ?>

        <?php if ($desc = get_field('blog_description')) : ?>
            <p class="text-xl text-gray-700 max-w-2xl mx-auto">
                <?php echo nl2br(esc_html($desc)); ?>
            </p>
        <?php endif; ?>
    </div>      


    <!-- Blog Cards Container - CSS Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">

        <?php
        // Query for blog posts
        $blog_posts = new WP_Query(array(
            'post_type' => 'post',
            'posts_per_page' => 6,
            'post_status' => 'publish'
        ));

        if ($blog_posts->have_posts()) :
            while ($blog_posts->have_posts()) : $blog_posts->the_post();
        ?>

        <!-- Dynamic Blog Card -->
        <article class="bg-white overflow-hidden">
            <!-- Featured Image -->
            <div class="relative mb-6">
                <?php if (has_post_thumbnail()) : ?>
                    <a href="<?php the_permalink(); ?>">
                        <img src="<?php the_post_thumbnail_url('medium_large'); ?>" 
                             alt="<?php the_title(); ?>" 
                             class="w-full h-64 object-cover group-hover:opacity-95 transition-opacity">
                    </a>
                <?php else : ?>
                    <!-- Default placeholder image if no featured image -->
                    <a href="<?php the_permalink(); ?>">
                        <img src="https://images.unsplash.com/photo-1606800052052-a08af7148866?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80" 
                             alt="<?php the_title(); ?>" 
                             class="w-full h-64 object-cover group-hover:opacity-95 transition-opacity">
                    </a>
                <?php endif; ?>
            </div>
            
            <!-- Content -->
            <div class="px-1">
                <!-- Category as Top Badge -->
                <?php
                $category = get_the_category();
                if ($category && !is_wp_error($category)) :
                ?>
                    <div class="mb-3">
                        <span class="inline-block bg-[#F5F5F0] text-[#535353] text-xs font-medium px-3 py-1 rounded-full uppercase tracking-wide">
                            <?php echo esc_html($category[0]->name); ?>
                        </span>
                    </div>
                <?php endif; ?>

                <!-- Title -->
                <h3 class="text-lg font-medium text-gray-900 mb-3 leading-tight">
                    <a href="<?php the_permalink(); ?>" class="hover:text-gray-700 transition-colors">
                        <?php the_title(); ?>
                    </a>
                </h3>
                
                <!-- Excerpt -->
                <p class="text-base text-[#535353] mb-4 leading-relaxed">
                    <?php 
                    if (has_excerpt()) {
                        echo wp_trim_words(get_the_excerpt(), 25, '...');
                    } else {
                        echo wp_trim_words(get_the_content(), 25, '...');
                    }
                    ?>
                </p>

                <!-- Author & Date at Bottom -->
                <div class="flex items-center justify-between">
                    <span class="text-sm font-medium text-gray-900">
                        <?php echo get_the_author(); ?>
                    </span>
                    <span class="text-sm text-[#535353]">
                        <?php echo get_the_date('j M Y'); ?>
                    </span>
                </div>
            </div>
        </article>

        <?php 
            endwhile;
            wp_reset_postdata();
        else :
        ?>
            <!-- No Posts Found -->
            <div class="col-span-full text-center py-12">
                <p class="text-gray-500 text-lg">No blog posts found.</p>
            </div>
        <?php endif; ?>

    </div>

    <?php
    // Pagination (optional)
    if ($blog_posts->max_num_pages > 1) :
    ?>
    <!-- Load More / Pagination -->
    <div class="text-center mt-16">
        <div class="flex justify-center space-x-4">
            <?php
            echo paginate_links(array(
                'total' => $blog_posts->max_num_pages,
                'prev_text' => '← Previous',
                'next_text' => 'Next →',
                'type' => 'list',
                'end_size' => 2,
                'mid_size' => 1,
            ));
            ?>
        </div>
    </div>
    <?php endif; ?>

</main>