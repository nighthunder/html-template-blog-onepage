<?php
/**
 * Created by PhpStorm.
 * User: Mayara
 * Date: 27/07/2017
 * Time: 10:36
 */
session_start();
include_once ('rootdirectory.php');
session_destroy();
header('Location: '.SITE_ROOT);