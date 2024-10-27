<?php get_header(); ?>

<div class="container mt-4">
    <h2 class="section-heading">Latest News</h2>
    <div class="row">
        <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
            <div class="col-md-4 mb-3">
                <div class="card">
                    <?php the_post_thumbnail('medium', ['class' => 'card-img-top']); ?>
                    <div class="card-body">
                        <h5 class="card-title"><?php the_title(); ?></h5>
                        <p class="card-text"><?php the_excerpt(); ?></p>
                        <a href="<?php the_permalink(); ?>" class="btn btn-primary">Read More</a>
                    </div>
                </div>
            </div>
        <?php endwhile; else : ?>
            <p><?php _e('No posts found.', 'my-news-theme'); ?></p>
        <?php endif; ?>
    </div>
</div>