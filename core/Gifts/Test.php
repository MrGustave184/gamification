<?php

namespace Shocklogic\Gamification\Gifts;

class Test
{
    public function register()
    {
        add_action('wp_enqueue_scripts', [$this, 'zumper_widget']);
    }

    public function zumper_widget()
    {   
        wp_enqueue_script( 'daemon', BASE_URL . 'core/Gifts/js/testeo.js' );
    }
}