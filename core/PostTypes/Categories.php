<?php

namespace Shocklogic\Gamification\PostTypes;

class Categories 
{
    public function register() 
    {
        add_action('init', [$this, 'categories_post_type']);
        $this->add_ACF();
    }

    public function categories_post_type()
    {
        register_post_type('gamif_categories', [
            'supports' => array('title'),
            'has_archive' => TRUE,
            'public' => TRUE,
            'show_ui' => TRUE,
            'show_in_rest' => true,
            'labels' => [
                'name' => 'Gamification Categories', 
                'singular_name' => 'Gamification Category',
                'add_new_item' => 'Add New Gamification Category',
                'edit_item' => 'Edit Gamification Category',
                'all_items' => 'All Gamification Categories'
            ],
            'menu_icon' => 'dashicons-games'
        ]);
    }

    private function add_ACF()
    {
        if( function_exists('acf_add_local_field_group') ):

            acf_add_local_field_group(array(
                'key' => 'group_5fa2f9305bc68',
                'title' => 'gamification categories',
                'fields' => array(
                    array(
                        'key' => 'field_5fa2f93bb17d6',
                        'label' => 'category',
                        'name' => 'category',
                        'type' => 'text',
                        'instructions' => '',
                        'required' => 0,
                        'conditional_logic' => 0,
                        'wrapper' => array(
                            'width' => '',
                            'class' => '',
                            'id' => '',
                        ),
                        'default_value' => '',
                        'placeholder' => '',
                        'prepend' => '',
                        'append' => '',
                        'maxlength' => '',
                    ),
                    array(
                        'key' => 'field_5fa2f951b17d7',
                        'label' => 'points',
                        'name' => 'points',
                        'type' => 'number',
                        'instructions' => '',
                        'required' => 0,
                        'conditional_logic' => 0,
                        'wrapper' => array(
                            'width' => '',
                            'class' => '',
                            'id' => '',
                        ),
                        'default_value' => '',
                        'placeholder' => '',
                        'prepend' => '',
                        'append' => '',
                        'min' => '',
                        'max' => '',
                        'step' => '',
                    ),
                ),
                'location' => array(
                    array(
                        array(
                            'param' => 'post_type',
                            'operator' => '==',
                            'value' => 'gamif_categories',
                        ),
                    ),
                ),
                'menu_order' => 0,
                'position' => 'normal',
                'style' => 'default',
                'label_placement' => 'top',
                'instruction_placement' => 'label',
                'hide_on_screen' => '',
                'active' => true,
                'description' => '',
            ));
            
            endif;
    }
}