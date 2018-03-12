<?php
/**
 * Created by PhpStorm.
 * User: Roy
 * Date: 12/03/2018
 * Time: 09:04
 */

class Main
{
    public function index(){
        $pdo=Database::instance()->connection();

        include_once "layout/MainList.php";
    }
}