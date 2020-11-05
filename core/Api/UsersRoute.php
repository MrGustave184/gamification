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
        $table_name = Tables::users();

        return $this->wpdb->get_results("SELECT * FROM $table_name");
    }

    public function getLeaderboard() 
    {
        $table_name = Tables::users();
        return $this->wpdb->get_results("SELECT * FROM $table_name ORDER BY points DESC");
    }

    public function getUserPoints($request) 
    {
        $userId = $request['id'];
        $table_name = Tables::users();

        return $this->wpdb->get_results("SELECT points FROM $table_name WHERE userId = $userId");
    }
    
    public function getUserActivePoints($request) 
    {
        $userId = $request['id'];
        $table_name = Tables::icons();
        $pointsArray = $this->wpdb->get_results("SELECT id FROM $table_name WHERE userId = $userId", ARRAY_N);
        $response = [];
        
        foreach($pointsArray as $point) {
            array_push($response, $point[0]);
        }
        return $response;
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

        register_rest_route('shocklogic/gamification', '/users/(?P<id>[\d]+)', [
            'methods' => 'GET',
            'callback' => [$this, 'getUserPoints'],
        ]);
        
        register_rest_route('shocklogic/gamification', '/users/(?P<id>[\d]+)/activePoints', [
            'methods' => 'GET',
            'callback' => [$this, 'getUserActivePoints'],
        ]);
    }

    public function register() 
    {
        add_action ('rest_api_init', [$this, 'register_routes']);
    }
}
