<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php wp_title(); ?></title>
    <?php wp_head(); ?>
</head>
<body>
    <img src="<?php echo get_template_directory_uri(); ?>/img/Frame 4.svg" class="img" alt="Top news">

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <?php
                wp_nav_menu(array(
                    'theme_location' => 'primary',
                    'container' => false,
                    'menu_class' => 'navbar-nav me-auto',
					'walker' => new Custom_Walker_Nav_Menu(),
                ));
                ?>
                <form class="d-flex search-form" role="search" method="get" action="<?php echo home_url('/'); ?>">
                    <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search" name="s">
                    <button class="btn search-btn" type="submit"><i class="fas fa-search"></i></button>
                </form>
            </div>
        </div>
    </nav>

    <?php wp_footer(); ?>
</body>
</html>