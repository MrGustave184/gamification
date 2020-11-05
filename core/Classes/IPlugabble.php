<?php

namespace Shocklogic\Gamification\Classes;

interface IPlugabble {
    public function install();
    public function uninstall();
    public function register();
    public function setSource();
}