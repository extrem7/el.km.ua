<?php

require_once plugin_dir_path(__FILE__) . "../includes/Walker_Catalog.php";

class ThemeWoo
{
    private $stihlID = 19;
    private $vikingID = 20;

    public function __construct()
    {
        add_action('after_setup_theme', function () {
            add_theme_support('woocommerce');
        });
        add_action('init', function () {
            remove_action('wp_footer', array(WC()->structured_data, 'output_structured_data'), 10); // Frontend pages
            remove_action('woocommerce_email_order_details', array(WC()->structured_data, 'output_email_structured_data'), 30); // Emails
        });
        add_action('pre_get_posts', function ($query) {
            if ($query->is_archive && !$query->is_tax && !is_admin() && $query->is_main_query() && !is_search()) {
                $query->set('tax_query', [
                    [
                        'taxonomy' => 'product_cat',
                        'terms' => $this->stihlID,
                        'field' => 'id',
                        'include_children' => true,
                        'operator' => 'IN'
                    ]
                ]);
            }
        });
        add_action('wp_enqueue_scripts', function () {
            //remove generator meta tag
            remove_action('wp_head', array($GLOBALS['woocommerce'], 'generator'));

            //first check that woo exists to prevent fatal errors
            if (function_exists('is_woocommerce')) {
                //dequeue scripts and styles
                if (!is_woocommerce() && !is_cart() && !is_checkout()) {
                    wp_dequeue_style('woocommerce_frontend_styles');
                    wp_dequeue_style('woocommerce_fancybox_styles');
                    wp_dequeue_style('woocommerce_chosen_styles');
                    wp_dequeue_style('woocommerce_prettyPhoto_css');
                    wp_dequeue_script('wc_price_slider');
                    wp_dequeue_script('wc-single-product');
                    wp_dequeue_script('wc-add-to-cart');
                    wp_dequeue_script('wc-cart-fragments');
                    wp_dequeue_script('wc-checkout');
                    wp_dequeue_script('wc-add-to-cart-variation');
                    wp_dequeue_script('wc-single-product');
                    wp_dequeue_script('wc-cart');
                    wp_dequeue_script('wc-chosen');
                    wp_dequeue_script('woocommerce');
                    wp_dequeue_script('prettyPhoto');
                    wp_dequeue_script('prettyPhoto-init');
                    wp_dequeue_script('jquery-blockui');
                    wp_dequeue_script('jquery-placeholder');
                    wp_dequeue_script('jqueryui');
                }
            }
        }, 99);
        remove_action('woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10);
        remove_action('woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10);
        add_filter('woocommerce_enqueue_styles', '__return_empty_array');

        add_filter('woocommerce_checkout_fields', function ($fields) {
            $fields['billing']['billing_last_name']['required'] = false;
            //  $fields['billing']['billing_address_1']['required'] = false;
            $fields['billing']['billing_country']['required'] = false;
            $fields['billing']['billing_city']['required'] = false;
            $fields['billing']['billing_postcode']['required'] = false;
            $fields['billing']['billing_address_2']['required'] = false;
            $fields['billing']['billing_state']['required'] = false;
            $fields['billing']['billing_email']['required'] = false;
            $fields['order']['order_comments']['type'] = 'text';
            $fields['billing']['billing_postcode']['label'] = 'Квартира';
            $fields['billing']['billing_state']['label'] = 'Корпус';
            //unset($fields['billing']['billing_last_name']);
            //unset($fields['billing']['billing_company']);
            //unset( $fields['billing']['billing_postcode'] );
            //unset( $fields['billing']['billing_state'] );
            //unset( $fields['billing']['billing_email'] );
            //unset($fields['billing']['billing_country']);
            //unset($fields['billing']['billing_address_2']);
            //unset($fields['billing']['billing_state']);

            $phone = $fields['billing']['billing_phone'];
            unset($fields['billing']['billing_phone']);
            array_splice_assoc($fields['billing'], 1, 0, ['billing_phone' => $phone]);

            return $fields;
        });
        add_filter('woocommerce_add_error', function ($error) {
            if (strpos($error, 'Оплата ') !== false) {
                $error = str_replace("Оплата ", "", $error);
            }
            return $error;
        });
        add_filter('woocommerce_currency_symbol', function ($currency_symbol, $currency) {

            switch ($currency) {
                case 'UAH':
                    $currency_symbol = ' грн.';
                    break;
            }

            return $currency_symbol;
        }, 10, 2);
        add_filter('default_checkout_billing_country', function () {
            return 'UA'; // country code
        });

        add_action('wp_ajax_ajax_add_to_cart', [$this, 'ajaxAddToCart']);
        add_action('wp_ajax_nopriv_ajax_add_to_cart', [$this, 'ajaxAddToCart']);
    }

    public function ajaxAddToCart()
    {
        ob_start();

        $product_id = apply_filters('woocommerce_add_to_cart_product_id', absint($_POST['product_id']));

        if (WC()->cart->add_to_cart($product_id)) {
            do_action('woocommerce_ajax_added_to_cart', $product_id);
            $category = '';
            $allTax = get_the_terms($product_id, 'product_cat');
            if (!is_wp_error($allTax)) {
                $category = array_reverse($allTax)[0]->description;
                if (!$category) {
                    $category = array_reverse($allTax)[0]->name;
                }
            }
            $name = $category . " " . get_the_title($product_id);
            $cart = wc_get_cart_url();
            wc_print_notice('<a href="' . $cart . '" class="button wc-forward">Переглянути резерв</a> “' . $name . '” додано в резерв.');
        } else {
            $this->json_headers();
            $data = array(
                'error' => true,
                'product_url' => apply_filters('woocommerce_cart_redirect_after_error', get_permalink($product_id), $product_id));
            echo json_encode($data);
        }
        die();
    }

    public function getParentCategory($currentCategory)
    {
        if (!in_array($currentCategory->term_id, [$this->stihlID(), $this->vikingID()])) {
            return array_reverse(get_ancestors($currentCategory->term_id, 'product_cat'))[0];
        } else {
            return $currentCategory->term_id;
        }
    }

    public function stihlID()
    {
        return $this->stihlID;
    }

    public function vikingID()
    {
        return $this->vikingID;
    }

    public function getHomeProducts()
    {
        $products = get_field('товари');
        $exclude = [];
        foreach ($products as $product) {
            array_push($exclude, $product->ID);
        }
        $additionalProducts = get_posts([
            'posts_per_page' => 12 - count($products),
            'post_type' => 'product',
            'post_status' => 'publish',
            'meta_key' => 'total_sales',
            'exclude' => $exclude,
            'orderby' => [
                'meta_value_num' => 'DESC'
            ],
            'meta_query' => [
                [
                    'key' => '_stock_status',
                    'value' => 'instock'
                ]
            ]
        ]);

        return array_merge($products, $additionalProducts);
    }

    public function printAttributes($product)
    {
        $attributes = $product->get_attributes();

        $additional = get_field('пояснення_характеристик');
        if (!empty($additional)) {
            for ($i = 0; $i < count($additional); $i++) {
                $additional[$i]['список_атрибутів'] = explode(',', $additional[$i]['список_атрибутів']);
            }
        }

        $i = 1;
        foreach ($attributes as $attribute):
            $sup = '';

            if (!empty($additional)) {
                for ($k = 0; $k < count($additional); $k++) {
                    if ($i == $additional[$k]['список_атрибутів'] || in_array($i, $additional[$k]['список_атрибутів'])) {
                        $sup = $k + 1 . ')';
                        break;
                    }
                }
            }

            if ($attribute->get_visible()) :
                ?>
                <tr>
                    <td><?= wc_attribute_label($attribute->get_name()) ?><sup> <?= $sup ?> </sup></td>
                    <td>
                        <?
                        $values = [];
                        if ($attribute->is_taxonomy()) {
                            $attribute_taxonomy = $attribute->get_taxonomy_object();
                            $attribute_values = wc_get_product_terms($product->get_id(), $attribute->get_name(), array('fields' => 'all'));
                            foreach ($attribute_values as $attribute_value) {
                                $value_name = esc_html($attribute_value->name);
                                $values[] = $value_name;
                            }
                        } else {
                            $values = $attribute->get_options();
                            foreach ($values as &$value) {
                                $value = make_clickable(esc_html($value));
                            }
                        }

                        echo implode(', ', $values) ?>
                    </td>
                </tr>
            <? endif;
            $i++;
        endforeach;
    }

    public function comments($comments)
    {

        echo '<ul class="reviews">';
        foreach ($comments as $comment) {
            $author = $comment->comment_author;
            echo '<li class="reviews-item">';
            echo "<div class='user-name'>$author</div>";
            echo $comment->comment_content;
            $children = $comment->get_children();
            if ($children) {
                $this->comments($children);
            }
            echo '</li>';
        }
        echo '</ul>';
    }
}