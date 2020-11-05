<?php

namespace Shocklogic\Gamification\Api;
use Shocklogic\Gamification\Classes\Tables;

// Implements IApi
class UsersRoute 
{ 
    private $wpdb;

    public function __construct() {
        global $wpdb;
        $this->wpdb = $wpdb;
    }

    public function getUsers() 
    {
        // $table_name = $this->tables['users'];
        $table_name = Tables::users();

        return $this->wpdb->get_results("SELECT * FROM $table_name");
    }

    public function getLeaderboard() 
    {
        $table_name = Tables::users();
        return $this->wpdb->get_results("SELECT * FROM $table_name ORDER BY points DESC");
    }

    public function register_routes() {
        register_rest_route('shocklogic/gamification', 'users', [
            'methods' => 'GET',
            'callback' => [$this, 'getUsers']
        ]);

        register_rest_route('shocklogic/gamification', 'leaderboard', [
            'methods' => 'GET',
            'callback' => [$this, 'getLeaderboard']
        ]);
    }

    public function register() 
    {
        add_action ('rest_api_init', [$this, 'register_routes']);
    }
}