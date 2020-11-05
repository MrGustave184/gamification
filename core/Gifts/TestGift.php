<?php

namespace Shocklogic\Gamification\Gifts;

class TestGift
{
    public function register()
    {
        add_action('wp_enqueue_scripts', [$this, 'test_this_gift']);
    }

    public function test_this_gift()
    {   
        wp_enqueue_script( 'test_js_script', BASE_URL . 'core/Gifts/js/test_script.js' );
    }
}