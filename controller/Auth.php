<?php
/**
 * Created by PhpStorm.
 * User: Roy
 * Date: 12/03/2018
 * Time: 11:23
 */

class Auth
{
    public static function securePage(){
        if(!isset($_SESSION["uid"])) {
            echo "<script>window.location.replace(\"/WebVideoPlace/Auth\")</script>";
            return;
        }
    }

    public function index(){
        login();
    }

    public function login(){
        include_once "layout/login.php";
    }
    public function loginCheck(){
        if(isset($_POST["name"]) && isset($_POST["password"])) {
            $valid = true;
            $pdo = Database::instance()->connection();
            $p = $pdo->prepare("Select count(*) from user where name=:name");
            $p->bindParam(":name", $_POST["name"]);
            $p->execute();
            $x=$p->fetchColumn(0);
            if ($x == 0) {
                $valid = false;
                $eName = "the User Does not exist".$x;
            }
            $p = $pdo->prepare("Select * from user where name=:name");
            $p->bindParam(":name", $_POST["name"]);
            $p->execute();
            $u = $p->fetch(PDO::FETCH_ASSOC);
            if (!password_verify($_POST["password"], $u["password"])) {
                $valid = false;
                $ePassword = "the Username or Password is incorrect";
            }

            if ($valid) {
                $_SESSION["uid"] = $u["id"];
                return;
            }

        } else {
            $eName = "Please fill out the entire form";

        }
        if (isset($eName)) {echo $eName;}
        echo "\n";
        if (isset($ePassword)) {echo $ePassword;}
        echo "\n";
    }

    public function register(){
        include_once "layout/register.php";

    }
    public function registerCheck(){
        $pdo = Database::instance()->connection();
        $valid=true;
        if(isset($_POST["name"])&&isset($_POST["email"])&&isset($_POST["password1"])&&isset($_POST["password2"])){
            if(!filter_var($_POST["email"],FILTER_VALIDATE_EMAIL)){
                $valid=false;
                $eEmail="the email is incorrect";
            }
            if($_POST["password1"] != $_POST["password2"]) {
                $valid = false;
                $ePwd2 = "the Passwords do not match";
            }
            $p=$pdo->prepare("select count(*) from user WHERE name=:name");
            $p->bindParam(":name",$_POST["name"]);
            $p->execute();
            if($p->fetchColumn(0)!=0){
                $valid=false;
                $eName="name is already taken";
            }
            if($valid){
                $hashword = password_hash($_POST["password1"], PASSWORD_DEFAULT);
                $p = $pdo->prepare("INSERT INTO user (name, password, email) VALUE (:name,:password,:email)");
                $p->bindParam(":name", $_POST["name"]);
                $p->bindParam(":password", $hashword);
                $p->bindParam(":email", $_POST["email"]);
                $p->execute();
                return;

            }
        }else{
            echo "there has been some Kind of mistake with the values.Please try again\n\n\n";
        }
        //returning errors
        if(isset($eName)){echo $eName;}
        echo "\n";
        if(isset($eEmail)){echo $eEmail;}
        echo "\n";
        if(isset($ePwd1)){echo $ePwd1;}
        echo "\n";
        if(isset($ePwd2)){echo $ePwd2;}
        echo "\n";

    }

    public function logout(){
        session_destroy();
        echo "<script>window.location.replace(\"/WebVideoPlace/\")</script>";
    }
}