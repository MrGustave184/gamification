<?php

namespace Shocklogic\Gamification\Classes;

class Tables
{
    public static function users()
    {
        global $wpdb;
        return $wpdb->prefix . 'gamification_users';
    }

    public static function icons()
    {
        global $wpdb;
        return $wpdb->prefix . 'game_icons';
    }
}
