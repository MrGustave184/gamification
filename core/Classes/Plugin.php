<?php
use Shocklogic\Gamification\Classes\IPlugabble;
namespace Shocklogic\Gamification\Classes;

class Plugin
{
    private $source;

    public function setSource(ISource $source) 
    {
        $this->source = $source;
    }

    public function install() 
    {
        $this->source->install();
    }

    public function uninstall() 
    {
        $this->source->uninstall();
    }

    public function register() 
    {
        register_activation_hook( __FILE__, [$this, 'install']);
        register_deactivation_hook(__FILE__, [$this, 'uninstall']);

        $this->source->register();
    }
}