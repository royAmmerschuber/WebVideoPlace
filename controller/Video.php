<?php
/**
 * Created by PhpStorm.
 * User: Roy
 * Date: 14/03/2018
 * Time: 10:10
 */

class Video
{
    public function upload(){
        include_once "layout/upload.php";

    }

    public function checkUpload(){
        if(isset($_POST["name"])&&
            isset($_POST["description"])&&
            isset($_FILES["thumbnail"])&&
            isset($_FILES["video"])){
            if(Uploader::checkImage($_FILES["thumbnail"])){
                Uploader::upload($_FILES["thumbnail"],Uploader::$THUMB_LOC);
            }
        }
    }
}