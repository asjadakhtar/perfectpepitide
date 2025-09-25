<?php
/*
 * 404 Error Page Template
 * 
 * @package Perfect Pepitide
 * @version 1.0.0
 * @author Asjad
 */

get_header(); ?>

<style>
    .error-404 {
        height: 100vh;
        display: flex;
        align-items: center;
        background: linear-gradient(135deg, #f6f8f9 0%, #e5ebee 100%);
    }
    .error-content {
        text-align: center;
        max-width: 600px;
        margin: 0 auto;
        padding: 2rem;
        background-color: rgba(255, 255, 255, 0.9);
        border-radius: 15px;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
    }
    .error-title {
        font-size: 120px;
        font-weight: 700;
        color: #3a4246;
        line-height: 1;
        text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.1);
    }
    .error-subtitle {
        font-size: 24px;
        color: #6c757d;
        margin-bottom: 1.5rem;
    }
    .btn-return {
        background: linear-gradient(90deg, #F8736C 0%, #BECFD1 100%);
        border: none;
        color: white;
        padding: 12px 30px;
        font-weight: 600;
        border-radius: 50px;
        transition: all 0.3s ease;
    }
    .btn-return:hover {
        transform: translateY(-5px);
        box-shadow: 0 7px 14px rgba(50, 50, 93, 0.1);
    }
    @media (max-width: 768px) {
        .error-title {
            font-size: 80px;
        }
        .error-subtitle {
            font-size: 18px;
        }
    }
</style>

<section class="error-404">
    <div class="container">
        <div class="error-content">
            <h1 class="error-title">404</h1>
            <h2 class="error-subtitle">
                <?php esc_html_e('Oops! Page Not Found', 'your-theme-textdomain'); ?>
            </h2>
            <p class="text-muted mb-4">
                <?php 
                esc_html_e('The page you are looking for might have been removed, had its name changed, or is temporarily unavailable.', 
                'your-theme-textdomain'); 
                ?>
            </p>
            <a href="<?php echo esc_url(home_url('/')); ?>" class="btn btn-return">
                <?php esc_html_e('Return to Homepage', 'your-theme-textdomain'); ?>
            </a>
        </div>
    </div>
</section>

<?php get_footer(); ?>