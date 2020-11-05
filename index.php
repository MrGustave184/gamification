<?php
/**
 * Plugin Name: Gamification
 * Description: Gamificate the experience of Virtualogic events
 * Version: 1.0
 * Author: Shocklogic Team
 * Author URI: https://shocklogic.com/
 */

define('BASE_PATH', plugin_dir_path(__FILE__));
define('BASE_URL', plugin_dir_url(__FILE__));
define('FILE_PATH', __FILE__);

// include the Composer autoload file
require BASE_PATH . 'vendor/autoload.php';

use Shocklogic\Gamification\Classes\Gamification;
use Shocklogic\Gamification\Api\IconsRoute;
use Shocklogic\Gamification\Api\UsersRoute;
use Shocklogic\Gamification\PostTypes\Categories;
use Shocklogic\Gamification\Gifts\Test;

$gamification = new Gamification();

$gamification->addRoutes([
    new IconsRoute(),
    new UsersRoute()
]);

$gamification->addCustomPostTypes([
    new Categories()
]);

$gamification->addGifts([
    new Test()
]);

$gamification->register();