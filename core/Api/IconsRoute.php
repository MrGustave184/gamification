<?php

namespace Shocklogic\Gamification\Api;
use Shocklogic\Gamification\Classes\Tables;

// Implements IApi
class IconsRoute 
{ 
    private $wpdb;

    public function __construct() {
        global $wpdb;
        $this->wpdb = $wpdb;
    }

    public function createIcon($request) {
        $params = $request->get_json_params()['data'];
        
        $this->registerUser($params['userId']);

        // category function refactor
        $category = get_posts([
            'post_type' => 'gamif_categories',
            'title' => $params['category']
        ]);

        if(! $category) {
            return [
                'category' => $category,
                'error' => 'invalid category'
            ];
        }

        $points = $this->calculatePointsByCategory($category);
        // category function refactor

        // create icons function refactor
        $record = [
            'id' => $params['id'],
            'category' => $params['category'],
            'url' => $params['url'],
            'userId' => $params['userId'],
            'points' => $points
        ];
        
        $isValidRecord = $this->wpdb->insert(Tables::icons(), $record);

        if(! $isValidRecord) {
            return [
                'error' => 'record already exists'
            ];
        }
        // create icons function refactor

        return $this->addPoints([
            'userId' => $params['userId'],
            'points' => $points
        ]);
    }

    // Do we need to sanitize user id?
    private function registerUser($userId) {
        return $this->wpdb->insert(Tables::users(), [
            'userId' => $userId,
            'points' => 0
        ]);
    }

    private function addPoints($data) {
        $table_name = Tables::users();

        return $this->wpdb->query($this->wpdb->prepare(
            "UPDATE $table_name SET points = points + %d WHERE userId = %d",
            $data['points'],
            $data['userId']
        ));
    }

    private function calculatePointsByCategory($category) {
        $points = get_post_meta($category[0]->ID, 'points');

        return (int)$points[0];
    }

    public function register_routes() {
        register_rest_route('shocklogic/gamification', 'registerIcon', [
            'methods' => 'POST',
            'callback' => [$this, 'createIcon']
        ]);
    }

    public function register() {
        add_action ('rest_api_init', [$this, 'register_routes']);
    }
}