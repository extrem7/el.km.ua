<?php

class ThemeBase
{
    public function __construct()
    {
        $this->themeSetup();
        $this->enqueueStyles();
        $this->enqueueScripts();
        $this->customHooks();
        $this->registerWidgets();
        $this->registerNavMenus();
        add_action('plugins_loaded', function () {
            $this->ACF();
            $this->GPSI();
        });
    }

    private function themeSetup()
    {
        add_theme_support('post-thumbnails');
        add_theme_support('menus');
        add_theme_support('widgets');
        show_admin_bar(true);
    }

    private function enqueueStyles()
    {
        add_action('wp_print_styles', function () {
            wp_register_style('main', path() . 'assets/css/main.css');
            wp_enqueue_style('main');
        });
    }

    private function enqueueScripts()
    {
        add_action('wp_enqueue_scripts', function () {
            wp_deregister_script('jquery');
            wp_register_script('jquery', 'https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js');
            wp_enqueue_script('jquery');
            wp_register_script('popper', 'https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js');
            wp_enqueue_script('popper');
            wp_register_script('bootstrap', path() . 'assets/node_modules/bootstrap/dist/js/bootstrap.min.js');
            wp_enqueue_script('bootstrap');
            wp_register_script('fontawesome', path() . 'assets/node_modules/@fortawesome/fontawesome-free/js/all.min.js');
            wp_enqueue_script('fontawesome');
            wp_register_script('fancybox', path() . 'assets/node_modules/@fancyapps/fancybox/dist/jquery.fancybox.min.js');
            wp_enqueue_script('fancybox');
            wp_register_script('owl.carousel', path() . 'assets/node_modules/owl.carousel/dist/owl.carousel.min.js');
            wp_enqueue_script('owl.carousel');
            wp_register_script('swiper', path() . 'assets/node_modules/jquery-touchswipe/jquery.touchSwipe.min.js');
            wp_enqueue_script('swiper');
            if (is_archive()) {
                wp_register_script('wNumb', path() . 'assets/js/wNumb.js');
                wp_enqueue_script('wNumb');
                wp_register_script('nouislider', path() . 'assets/node_modules/nouislider/distribute/nouislider.js');
                wp_enqueue_script('nouislider');
                wp_register_script('filter', path() . 'assets/js/filter.js');
                wp_enqueue_script('filter');
            }
            wp_register_script('main', path() . 'assets/js/main.js');
            wp_enqueue_script('main');
        });
        add_action('wp_enqueue_scripts', function () {
            wp_localize_script('main', 'StihlAjaxUrl',
                admin_url('admin-ajax.php')
            );
        }, 99);
    }

    private function customHooks()
    {
        add_action('admin_menu', function () {
            //remove_menu_page( 'edit-comments.php' );
        });
        add_filter('wpcf7_form_elements', function ($content) {
            $content = preg_replace('/<(span).*?class="\s*(?:.*\s)?wpcf7-form-control-wrap(?:\s[^"]+)?\s*"[^\>]*>(.*)<\/\1>/i', '\2', $content);

            return $content;
        });
        add_filter('wpcf7_autop_or_not', '__return_false');
        add_filter('wp_list_categories', function ($output, $args) {

            if (is_single()) {
                global $post;

                $terms = get_the_terms($post->ID, $args['taxonomy']);
                foreach ($terms as $term)
                    if (preg_match('#cat-item-' . $term->term_id . '#', $output))
                        $output = str_replace('cat-item-' . $term->term_id, 'cat-item-' . $term->term_id . ' current-cat', $output);
            }

            return $output;
        }, 10, 2);
    }

    private function registerWidgets()
    {
        add_action('widgets_init', function () {
            register_sidebar([
                'name' => "Правая боковая панель сайта",
                'id' => 'right-sidebar',
                'description' => 'Эти виджеты будут показаны в правой колонке сайта',
                'before_title' => '<h1>',
                'after_title' => '</h1>'
            ]);
        });
    }

    private function registerNavMenus()
    {
        add_action('after_setup_theme', function () {
            register_nav_menus(array(
                'header_menu' => 'Меню в шапці',
                'footer_menu' => 'Меню в підваді'
            ));
        });
        function wp_nav_menu_remove_attributes($menu)
        {
            return $menu = preg_replace('/nav-link/', '', $menu);
        }

        add_filter('wp_nav_menu', 'wp_nav_menu_remove_attributes');

        add_filter('nav_menu_link_attributes', function ($atts, $item, $args) {
            $atts['itemprop'] = 'url';
            return $atts;
        }, 10, 3);

        if (!file_exists(plugin_dir_path(__FILE__) . '../includes/wp-bootstrap-navwalker.php')) {
            return new WP_Error('wp-bootstrap-navwalker-missing', __('It appears the wp-bootstrap-navwalker.php file may be missing.', 'wp-bootstrap-navwalker'));
        } else {
            require_once plugin_dir_path(__FILE__) . '../includes/wp-bootstrap-navwalker.php';
        }

    }

    private function ACF()
    {
        if (function_exists('acf_add_options_page')) {
            $main = acf_add_options_page([
                'page_title' => 'Налаштування теми',
                'menu_title' => 'Налаштування теми',
                'menu_slug' => 'theme-general-settings',
                'capability' => 'edit_posts',
                'redirect' => false,
                'position' => 2,
                'icon_url' => 'dashicons-admin-customizer',
            ]);
        }
    }

    private function GPSI()
    {
        add_action('after_setup_theme', function () {
            remove_action('wp_head', 'wp_print_scripts');
            remove_action('wp_head', 'wp_print_head_scripts', 9);
            remove_action('wp_head', 'wp_enqueue_scripts', 1);
            add_action('wp_footer', 'wp_print_scripts', 5);
            add_action('wp_footer', 'wp_enqueue_scripts', 5);
            add_action('wp_footer', 'wp_print_head_scripts', 5);
        });

        add_action('after_setup_theme', function () {
            remove_action('wp_head', 'wp_generator');                // #1
            remove_action('wp_head', 'wlwmanifest_link');            // #2
            remove_action('wp_head', 'rsd_link');                    // #3
            remove_action('wp_head', 'wp_shortlink_wp_head');        // #4
            remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10);    // #5
            add_filter('the_generator', '__return_false');            // #6
            add_filter('show_admin_bar', '__return_false');            // #7
            remove_action('wp_head', 'print_emoji_detection_script', 7);  // #8
            remove_action('wp_print_styles', 'print_emoji_styles');
        });

        remove_action('wp_head', 'wp_oembed_add_discovery_links');
        remove_action('wp_head', 'wp_oembed_add_host_js');
    }
}