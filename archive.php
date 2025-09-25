<?php
/**
 * Archive Template
 *
 * @package YourThemeName
 * @version 1.0.0
 * @author Asjad
 */

get_header(); ?>

<style>
    .archive-section {
        padding: 4rem 0;
        background-color: #f8f9fa;
    }
    .archive-card {
        transition: all 0.3s ease;
        margin-bottom: 2rem;
        box-shadow: 0 4px 6px rgba(0,0,0,0.1);
    }
    .archive-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 15px rgba(0,0,0,0.15);
    }
    .archive-card-img {
        height: 250px;
        object-fit: cover;
    }
    .archive-card-title {
        font-weight: 700;
        color: #2c3e50;
    }
    .archive-card-meta {
        color: #6c757d;
        font-size: 0.9rem;
    }
    .archive-title {
        color: #2c3e50;
        margin-bottom: 2.5rem;
        font-weight: 700;
    }
    .btn-read-more {
        background: linear-gradient(90deg, #F8736C 0%, #BECFD1 100%);
        border: none;
        color: white;
        transition: all 0.3s ease;
    }
    .btn-read-more:hover {
        color: white;
        opacity: 0.9;
    }
    .no-posts-alert {
        max-width: 600px;
        margin: 0 auto;
    }
</style>

<section class="archive-section">
    <div class="container">
        <h1 class="text-center archive-title">
            <?php the_archive_title(); ?>
        </h1>

        <div class="row">
            <?php if (have_posts()) : ?>
                <?php while (have_posts()) : the_post(); ?>
                    <div class="col-md-4">
                        <div class="card archive-card">
                            <?php if (has_post_thumbnail()) : ?>
                                <img 
                                    src="<?php the_post_thumbnail_url('medium'); ?>" 
                                    class="card-img-top archive-card-img" 
                                    alt="<?php the_title_attribute(); ?>"
                                >
                            <?php endif; ?>
                            
                            <div class="card-body">
                                <h5 class="card-title archive-card-title">
                                    <?php the_title(); ?>
                                </h5>
                                
                                <p class="card-text archive-card-meta mb-2">
                                    <small>
                                        <?php 
                                        printf(
                                            __('Published on %s by %s', 'your-theme-textdomain'), 
                                            get_the_date(), 
                                            get_the_author()
                                        ); 
                                        ?>
                                    </small>
                                </p>
                                
                                <p class="card-text">
                                    <?php echo wp_trim_words(get_the_excerpt(), 20); ?>
                                </p>
                                
                                <a 
                                    href="<?php the_permalink(); ?>" 
                                    class="btn btn-read-more"
                                >
                                    <?php esc_html_e('Read More', 'your-theme-textdomain'); ?>
                                </a>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else : ?>
                <div class="col-12">
                    <div class="alert alert-info text-center no-posts-alert" role="alert">
                        <?php esc_html_e('No posts found in this archive.', 'your-theme-textdomain'); ?>
                    </div>
                </div>
            <?php endif; ?>
        </div>

        <!--- Pagination --->
        <div class="row mt-4">
            <div class="col-12 d-flex justify-content-center">
                <?php 
                the_posts_pagination([
                    'mid_size'  => 2,
                    'prev_text' => __('Previous', 'your-theme-textdomain'),
                    'next_text' => __('Next', 'your-theme-textdomain'),
                    'screen_reader_text' => __('Posts navigation', 'your-theme-textdomain')
                ]); 
                ?>
            </div>
        </div>
    </div>
</section>

<?php get_footer(); ?>