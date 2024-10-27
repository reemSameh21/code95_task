<?php get_header(); ?>

<!-- Main Content -->
<div class="container mt-4">
    <div class="row">
        <!-- Top News Section -->
        <div class="col-md-5">
            <?php
            // Retrieve selected top news post IDs from customizer
            $top_news_ids = get_theme_mod('top_news_post_ids');
            $top_news_ids_array = !empty($top_news_ids) ? explode(',', $top_news_ids) : [];

            if (!empty($top_news_ids_array)) :
                // Query for the selected top news posts
                $top_news_query_args = array(
                    'post__in' => $top_news_ids_array,
                    'orderby' => 'post__in',
                    'posts_per_page' => 3,
                );
                $top_news_query = new WP_Query($top_news_query_args);

                if ($top_news_query->have_posts()) :
                    $first_post_displayed = false;
                    $second_column_posts = [];

                    while ($top_news_query->have_posts()) : $top_news_query->the_post();
                        // Display the first post in the first column
                        if (!$first_post_displayed) : ?>
                            <div class="card main-news-card">
                                <?php the_post_thumbnail('large', ['class' => 'card-img-top1']); ?>
                                <div class="card-body">
                                    <span class="badge bg-danger"><?php the_category(', '); ?></span>
                                    <h5 class="card-title"><?php the_title(); ?></h5>
                                </div>
                            </div>
                            <?php $first_post_displayed = true; // Mark the first post as displayed
                        else:
                            // Collect remaining posts for the second column
                            $second_column_posts[] = get_the_ID();
                        endif;
                    endwhile;

                    wp_reset_postdata(); // Reset the post data
                endif;
            endif;
            ?>
        </div>

        <div class="col-md-3">
            <?php
            // Display the two remaining posts in the second column
            if (!empty($second_column_posts)) :
                $second_column_query_args = array(
                    'post__in' => $second_column_posts,
                    'orderby' => 'post__in', // Maintain the order
                    'posts_per_page' => 2,
                );
                $second_column_query = new WP_Query($second_column_query_args);

                if ($second_column_query->have_posts()) :
                    while ($second_column_query->have_posts()) : $second_column_query->the_post(); ?>
                        <div class="card mb-3">
                            <?php the_post_thumbnail('medium', ['class' => 'card-img-top']); ?>
                            <div class="card-body">
                                <span class="badge bg-danger"><?php the_category(', '); ?></span>
                                <h5 class="card-title"><?php the_title(); ?></h5>
                                <p class="card-text"><?php the_excerpt(); ?></p>
                            </div>
                        </div>
                    <?php endwhile;
                    wp_reset_postdata(); // Reset the post data for second column query
                endif;
            endif;
            ?>
        </div>

        <!-- Image Section -->
        <div class="col-md-4">
            <div class="card main-news-card">
                <img src="<?php echo get_template_directory_uri(); ?>/img/Frame.svg" class="card-img-top1" alt="News">
            </div>
        </div>
    </div>
</div>

<!-- EGY News Section -->
<div class="container mt-4">
    <h2 class="section-heading">EGY News</h2>
    <div id="egyNewsCarousel" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-inner">
            <?php
            $egy_news_args = array(
                'category_name' => 'egypt', // Replace with your category slug
                'posts_per_page' => 12, // Fetch 12 posts
            );
            $egy_news_query = new WP_Query($egy_news_args);
            $active = true;
            $post_count = 0; // Initialize a counter for the posts

            // Check if there are posts
            if ($egy_news_query->have_posts()) :
                while ($egy_news_query->have_posts()) : $egy_news_query->the_post();
                    if ($post_count % 4 == 0) { // Start a new carousel item every 4 posts
                        echo $active ? '<div class="carousel-item active"><div class="row">' : '<div class="carousel-item"><div class="row">';
                        $active = false;
                    }

                    // Display the post
                    ?>
                    <div class="col-md-3">
                        <div class="card">
                            <?php the_post_thumbnail('medium', ['class' => 'card-img-top']); ?>
                            <div class="card-body">
                                <p class="card-text"><?php the_excerpt(); ?></p>
                            </div>
                        </div>
                    </div>
                    <?php

                    $post_count++; // Increment post counter

                    // Close the row and item divs after every 4 posts
                    if ($post_count % 4 == 0 || $post_count == $egy_news_query->post_count) {
                        echo '</div></div>'; // Close row and item divs
                    }

                endwhile;
            else :
                echo '<p>No posts found in this category.</p>';
            endif;

            wp_reset_postdata();
            ?>
        </div>

        <!-- Carousel controls -->
        <button class="carousel-control-prev" type="button" data-bs-target="#egyNewsCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#egyNewsCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
        </button>
    </div>
</div>

<!-- Features and Top Stories Section -->
<div class="container mt-4 features">
    <div class="row">
        <div class="col-md-8">
            <h2 class="section-heading">Features</h2>
            <div class="row">
                <?php
                // Retrieve selected features post IDs from customizer
                $features_ids = get_theme_mod('features_post_ids');
                $features_ids_array = !empty($features_ids) ? explode(',', $features_ids) : [];

                if (!empty($features_ids_array)) :
                    // Query for the selected feature posts
                    $features_query_args = array(
                        'post__in' => $features_ids_array,
                        'orderby' => 'post__in',
                        'posts_per_page' => 2,
                    );
                    $features_query = new WP_Query($features_query_args);

                    if ($features_query->have_posts()) :
                        while ($features_query->have_posts()) : $features_query->the_post(); ?>
                            <div class="col-md-6">
                                <div class="card">
                                    <?php the_post_thumbnail('medium', ['class' => 'card-img-top']); ?>
                                    <div class="card-body">
                                        <span class="badge bg-danger"><?php the_category(', '); ?></span>
                                        <p class="card-text"><?php the_excerpt(); ?></p>
                                    </div>
                                </div>
                            </div>
                        <?php endwhile;
                        wp_reset_postdata();
                    endif;
                endif; ?>
            </div>
        </div>

        <div class="col-md-4">
            <h2 class="section-heading">Top Stories</h2>
            <ul class="list-group">
                <?php
                // Update to get the top 5 posts based on views
                $top_stories_args = array(
                    'posts_per_page' => 5,
                    'meta_key' => 'post_views_count',
                    'orderby' => 'meta_value_num',
                    'order' => 'DESC',
                );
                $top_stories_query = new WP_Query($top_stories_args);
                if ($top_stories_query->have_posts()) :
                    while ($top_stories_query->have_posts()) : $top_stories_query->the_post(); ?>
                        <li class="list-group-item">
                            <span class="number"><?php echo $top_stories_query->current_post + 1; ?></span>
                            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                        </li>
                    <?php endwhile; 
                    wp_reset_postdata();
                else : ?>
                    <li class="list-group-item">No top stories found.</li>
                <?php endif; ?>
            </ul>
        </div>            
    </div>
</div>