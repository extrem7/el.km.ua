<?php

/**
 * Plugin Name: Stihl
 * Version: 1.0
 * Author: Raxkor
 * Author uri: https://t.me/drKeinakh
 */

require_once "includes/functions.php";
require_once "Stihl.php";


function StihlActivation()
{
    global $Stihl;
    $Stihl = new Stihl();
}

StihlActivation();