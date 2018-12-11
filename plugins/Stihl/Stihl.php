<?php

require_once "classes/ThemeBase.php";
require_once "classes/ThemeWoo.php";
require_once "classes/StihlFilters.php";
require_once "classes/StihlCompare.php";

class Stihl extends ThemeBase
{

    public $compare, $filter;
    public $woo;

    public function __construct()
    {
        parent::__construct();
        $this->registerTaxonomies();
        $this->registerPostTypes();
        add_action('plugins_loaded', function () {
            $this->woo = new ThemeWoo();
        });
        $this->compare = new StihlCompare();
        $this->filter = new StihlFilters();
    }

    private function registerTaxonomies()
    {
        add_action('init', function () {
            /*   register_taxonomy('equipment_type', ['equipment'], [
                   'label' => '', // определяется параметром $labels->name
                   'labels' => [
                       'name' => 'Тип',
                       'singular_name' => 'Тип',
                       'search_items' => 'Search Категорія',
                       'all_items' => 'All Категорія',
                       'view_item ' => 'View Категорія',
                       'parent_item' => 'Parent Категорія',
                       'parent_item_colon' => 'Parent Категорія:',
                       'edit_item' => 'Edit Категорія',
                       'update_item' => 'Update Категорія',
                       'add_new_item' => 'Add New Категорія',
                       'new_item_name' => 'New Genre Категорія',
                       'menu_name' => 'Тип',
                   ],
                   'description' => '', // описание таксономии
                   'public' => true,
                   'show_ui' => true, // равен аргументу public
                   'show_in_menu' => true, // равен аргументу show_ui
               ]);*/
        });
    }

    private function registerPostTypes()
    {
        add_action('init', function () {
            register_post_type('equipment', [
                'label' => null,
                'labels' => [
                    'name' => 'Оснащення', // основное название для типа записи
                    'singular_name' => 'Оснащення', // название для одной записи этого типа
                    'add_new' => 'Додати оснащення', // для добавления новой записи
                    'add_new_item' => 'Додавання оснащення', // заголовка у вновь создаваемой записи в админ-панели.
                    'edit_item' => 'Редагування оснащення', // для редактирования типа записи
                    'new_item' => '', // текст новой записи
                    'view_item' => 'Переглянути оснащення', // для просмотра записи этого типа.
                    'search_items' => 'Шукати оснащення', // для поиска по этим типам записи
                    'not_found' => 'Не знайдено', // если в результате поиска ничего не было найдено
                    'not_found_in_trash' => 'Не знайдено у корзині', // если не было найдено в корзине
                    'menu_name' => 'Оснащення', // название меню
                ],
                'public' => true,
                'publicly_queryable' => false, // зависит от public
                'rest_base' => null, // $post_type. C WP 4.7
                'menu_position' => 57,
                'menu_icon' => 'dashicons-admin-generic',
                'supports' => array('title', 'editor', 'thumbnail'), // 'title','editor','author','thumbnail','excerpt','trackbacks','custom-fields','comments','revisions','page-attributes','post-formats'
                'has_archive' => false,
            ]);
        });
    }

    public function servicesBanner()
    {
        get_template_part('views/services-banner');
    }

    public function seoText()
    {
        get_template_part('views/seo-text');
    }
}