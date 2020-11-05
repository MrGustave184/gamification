<?php

namespace Shocklogic\Gamification\PostTypes;

class Categories 
{
    public function register() 
    {
        add_action('init', [$this, 'categories_post_type']);
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
}