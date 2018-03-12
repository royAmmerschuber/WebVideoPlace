<?php
/**
 * Created by PhpStorm.
 * User: Roy
 * Date: 12/03/2018
 * Time: 11:23
 */

class Auth
{
    public function index(){
        login();
    }
    public function login(){
        include_once "layout/login.php";
    }
    public function register(){
        include_once "layout/register.php";

    }
}