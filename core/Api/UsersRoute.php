<?php

namespace Shocklogic\Gamification\Api;

// Implements IApi
class UsersRoute 
{ 
    private $wpdb;
    private $tables;

    public function __construct() {
        global $wpdb;
        $this->wpdb = $wpdb;
        $this->tables = [
            'users' => $this->wpdb->prefix . 'gamification_users'
        ];
    }

    public function getUsers() 
    {
        $table_name = $this->tables['users'];
        return $this->wpdb->get_results("SELECT * FROM $table_name");
    }

    public function getLeaderboard() 
    {
        $table_name = $this->tables['users'];
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