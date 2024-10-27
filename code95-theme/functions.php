<?php
function my_news_theme_setup() {
    // Enable featured images
    add_theme_support('post-thumbnails');

    // Register menus
    register_nav_menus(array(
        'primary' => __('Primary Menu', 'my-news-theme'),
    ));
}

add_action('after_setup_theme', 'my_news_theme_setup');

// Enqueue styles and scripts
function my_news_theme_enqueue_styles() {
    wp_enqueue_style('bootstrap-css', 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css');
    wp_enqueue_script('bootstrap-js', 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js', array('jquery'), null, true);
    wp_enqueue_style('font-awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css');
    wp_enqueue_style('main-style', get_stylesheet_uri());
}

add_action('wp_enqueue_scripts', 'my_news_theme_enqueue_styles');

class Custom_Walker_Nav_Menu extends Walker_Nav_Menu {
    function start_el(&$output, $item, $depth = 0, $args = null, $current_object_id = 0) {
        $indent = ($depth) ? str_repeat("\t", $depth) : '';
        $classes = empty($item->classes) ? array() : (array) $item->classes;
        $classes[] = 'nav-item';

        if (in_array('menu-item-has-children', $classes) && $depth === 0) {
            $classes[] = 'dropdown';
        }

        // Add Bootstrap margin class
        if ($depth === 0) {
            $classes[] = 'me-2'; // Adds margin for top-level items
        }

        $class_names = join(' ', apply_filters('nav_menu_css_class', array_filter($classes), $item, $args));
        $class_names = $class_names ? ' class="' . esc_attr($class_names) . '"' : '';

        $id = apply_filters('nav_menu_item_id', 'menu-item-' . $item->ID, $item, $args);
        $id = $id ? ' id="' . esc_attr($id) . '"' : '';

        $output .= $indent . '<li' . $id . $class_names .'>';

        $atts = array();
        $atts['class'] = 'nav-link';
        $atts['href'] = !empty($item->url) ? $item->url : '';

        if (in_array('menu-item-has-children', $classes) && $depth === 0) {
            $atts['class'] .= ' dropdown-toggle';
            $atts['data-bs-toggle'] = 'dropdown';
            $atts['aria-expanded'] = 'false';
        }

        $atts = apply_filters('nav_menu_link_attributes', $atts, $item, $args);
        $attributes = '';
        foreach ($atts as $attr => $value) {
            if (!empty($value)) {
                $value = ('href' === $attr) ? esc_url($value) : esc_attr($value);
                $attributes .= ' ' . $attr . '="' . $value . '"';
            }
        }

        $title = apply_filters('the_title', $item->title, $item->ID);
        $item_output = $args->before;
        $item_output .= '<a' . $attributes . '>';
        $item_output .= $args->link_before . $title . $args->link_after;
        $item_output .= '</a>';
        $item_output .= $args->after;

        $output .= apply_filters('walker_nav_menu_start_el', $item_output, $item, $depth, $args);
    }

    function start_lvl(&$output, $depth = 0, $args = null) {
        $indent = str_repeat("\t", $depth);
        $submenu_class = ($depth > 0) ? ' dropdown-submenu' : ' dropdown-menu';
        $output .= "\n$indent<ul class=\"$submenu_class\">\n";
    }

    function end_lvl(&$output, $depth = 0, $args = null) {
        $indent = str_repeat("\t", $depth);
        $output .= "$indent</ul>\n";
    }
}

// Add customizer settings
function code95_customize_register($wp_customize) {
    // Top News Section
    $wp_customize->add_section('top_news_section', array(
        'title'    => __('Top News', 'code95'),
        'priority' => 30,
    ));

    // Top News Post Setting
    $wp_customize->add_setting('top_news_post_ids', array(
        'default' => '',
    ));

    $wp_customize->add_control('top_news_post_ids', array(
        'label'   => __('Select Top News Posts (comma-separated IDs)', 'code95'),
        'section' => 'top_news_section',
        'type'    => 'text',
    ));

    // Features Section
    $wp_customize->add_section('features_section', array(
        'title'    => __('Features', 'code95'),
        'priority' => 31,
    ));

    // Features Post Setting
    $wp_customize->add_setting('features_post_ids', array(
        'default' => '',
    ));

    $wp_customize->add_control('features_post_ids', array(
        'label'   => __('Select Features Posts (comma-separated IDs)', 'code95'),
        'section' => 'features_section',
        'type'    => 'text',
    ));
}
add_action('customize_register', 'code95_customize_register');