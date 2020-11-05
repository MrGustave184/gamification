<?php

use Shocklogic\Gamification\Classes\ISource;
namespace Shocklogic\Gamification\Classes;

class Gamification implements ISource 
{
    private $routes;
    private $wpdb;
    private $tables;
    private $postTypes;
    private $gitfs;

    public function __construct() {
        global $wpdb;
        $this->wpdb = $wpdb;
        $this->postTypes = [];
        $this->routes = [];
        $this->gifts = [];
        $this->tables = [
            'game_icons' => $this->wpdb->prefix . 'game_icons',
            'categories' => $this->wpdb->prefix . 'categories',
            'users' => $this->wpdb->prefix . 'gamification_users',
        ];
    }

    // ISource
    public function install() 
    {
        // need to mplement try catch error handling
        $charset_collate = $this->wpdb->get_charset_collate();

        // Create game icons table
        $table_name = $this->tables['game_icons'];	
        $sql = "CREATE TABLE $table_name (
            id varchar(100) NOT NULL,
            category varchar (255) NOT NULL,
            url varchar (255) NOT NULL,
            userId int(11) NOT NULL,
            points int(11) NOT NULL,
            PRIMARY KEY  (id)
        ) $charset_collate;";
    
        require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
        dbDelta( $sql );

        // create categories table
        $table_name = $this->tables['categories'];	
        $sql = "CREATE TABLE $table_name (
            id mediumint(9) NOT NULL AUTO_INCREMENT,
            name tinytext NOT NULL,
            points mediumint(9),
            PRIMARY KEY  (id)
        ) $charset_collate;";
    
        require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
        dbDelta( $sql );

        // create users table
        $table_name = $this->tables['users'];	
        $sql = "CREATE TABLE $table_name (
            userId int(11) NOT NULL,
            points int(11),
            PRIMARY KEY  (userId)
        ) $charset_collate;";
    
        require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
        dbDelta( $sql );
    }

    // ISource
    public function uninstall() 
    {
        global $wpdb;

        // Implement try catch error handling
        foreach($this->tables as $table) {
            $sql = "DROP TABLE IF EXISTS $table;";
            $wpdb->query($sql);
        }
    }

    // ISource
    public function register() 
    {
        register_activation_hook(FILE_PATH, [$this, 'install']);
        register_deactivation_hook(FILE_PATH, [$this, 'uninstall']);

        $this->registerRoutes();
        $this->registerCustomPostTypes();
        $this->registerGifts();
        
    }

    public function addElement(string $property, array $elements)
    {
        if(! property_exists($this, $property)) {
            return false;
        }

        foreach($elements as $element) {
            array_push($this->$property, $element);
        }
    }


    // Add and register should be generic functions
    // use a variable variable $$ to achieve this without switchs

    // IApiRoute
    public function addRoutes($routes)
    {
        foreach($routes as $route) {
            array_push($this->routes, $route);
        }
    }

    public function addCustomPostTypes($postTypes)
    {
        foreach($postTypes as $postType) {
            array_push($this->postTypes, $postType);
        }
    }

    // IApiRoute
    public function registerRoutes() 
    {
        if(count($this->routes)) {
            foreach($this->routes as $route) {
                $route->register();
            }
        }
    }

    public function registerCustomPostTypes() 
    {
        if(count($this->postTypes)) {
            foreach($this->postTypes as $postType) {
                $postType->register();
            }
        }
    }

    public function addGifts($gifts)
    {
        foreach($gifts as $gift) {
            array_push($this->gifts, $gift);
        }
    }

    public function registerGifts() 
    {
        if(count($this->gifts)) {
            foreach($this->gifts as $gift) {
                $gift->register();
            }
        }
    }
}