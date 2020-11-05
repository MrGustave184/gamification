<?php

namespace Shocklogic\Gamification\Classes;

interface ISource {
    public function install();
    public function uninstall();
    public function register();
}