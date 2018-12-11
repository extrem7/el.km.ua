<?
global $post;

class Walker_Catalog extends Walker_Category
{
    function start_el(&$output, $category, $depth = 0, $args = array(), $id = 0)
    {
        extract($args);
        $termchildren = get_term_children($category->term_id, $category->taxonomy);

        $thumbnail_id = get_term_meta($category->term_id, 'thumbnail_id', true);
        $image = get_attached_file($thumbnail_id);
        $useSvg = $category->category_parent == 0 && $image;

        $cat_name = esc_attr($category->name);
        $cat_name = apply_filters('list_cats', $cat_name, $category);
        $link = '<a href="' . esc_url(get_term_link($category)) . '" ';
        if ($use_desc_for_title == 0 || empty($category->description))
            $link .= 'title="' . esc_attr(sprintf(__('View all posts filed under %s'), $cat_name)) . '"';
        else
            $link .= 'title="' . esc_attr(strip_tags(apply_filters('category_description', $category->description, $category))) . '"';
        $link .= '>';
        if ($useSvg) {
            $svg = file_get_contents($image);
            $icon = "<div class=\"icon\">$svg</div><span>";
            $link .= $icon;
        }
        $link .= $cat_name;
        if ($useSvg) {
            $link .= '</span>';
        }
        $link .= '</a>';
        if (!empty($show_count))
            $link .= ' (' . intval($category->count) . ')';

        if ('list' == $args['style']) {
            $output .= "\t<li";
            $css_classes = array(
                'cat-item',
                'cat-item-' . $category->term_id,
            );


            if (count($termchildren) > 0) {
                $css_classes [] = 'has-children';
            }
            if (is_product()) {
                $args['current_category'] = get_the_terms($post->ID, $args['taxonomy'])[0]->term_id;
            }
            if (!empty($args['current_category'])) {
                // 'current_category' can be an array, so we use `get_terms()`.
                $_current_terms = get_terms($category->taxonomy, array(
                    'include' => $args['current_category'],
                    'hide_empty' => false,
                ));

                foreach ($_current_terms as $_current_term) {
                    if ($category->term_id == $_current_term->term_id) {
                        $css_classes[] = 'current-cat';
                    } elseif ($category->term_id == $_current_term->parent) {
                        $css_classes[] = 'current-cat-parent';
                    }
                    while ($_current_term->parent) {
                        if ($category->term_id == $_current_term->parent) {
                            $css_classes[] = 'current-cat-ancestor';
                            break;
                        }
                        $_current_term = get_term($_current_term->parent, $category->taxonomy);
                    }
                }
            }

            /**
             * Filters the list of CSS classes to include with each category in the list.
             *
             * @since 4.2.0
             *
             * @see wp_list_categories()
             *
             * @param array $css_classes An array of CSS classes to be applied to each list item.
             * @param object $category Category data object.
             * @param int $depth Depth of page, used for padding.
             * @param array $args An array of wp_list_categories() arguments.
             */
            $css_classes = implode(' ', apply_filters('category_css_class', $css_classes, $category, $depth, $args));


            $output .= ' class="' . $css_classes . '"';
            $output .= ">$link\n";
        } else {
            $output .= "\t$link<br />\n";
        }
    }
}