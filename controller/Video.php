<?php
/**
 * Created by PhpStorm.
 * User: Roy
 * Date: 14/03/2018
 * Time: 10:10
 */

class Video
{
    public function index(){
        $pdo=Database::instance()->connection();
        $p=$pdo->prepare("
            select v.* 
            from video as v
                left JOIN user as u on u.id=v.userFK
                LEFT JOIN likedislike as l on l.videoFK");
    }

    public function upload(){
        include_once "layout/upload.php";

    }

    public function checkUpload(){
        Auth::securePage($_SESSION);
        if(isset($_POST["name"])&&
            isset($_POST["description"])&&
            isset($_FILES["thumbnail"])&&
            isset($_FILES["video"])){
            if(Uploader::checkImage($_FILES["thumbnail"])){
                if(Uploader::checkVideo($_FILES["video"])){
                    $videoPath=Uploader::upload($_FILES["video"],Uploader::$VIDEO_LOC);
                    $thumbPath=Uploader::upload($_FILES["thumbnail"],Uploader::$THUMB_LOC);
                }else{
                    $eVideo="your video file is incorrect";
                    include_once "layout/upload.php";

                    return;
                }
            }else{
                $eThumb="your Thumbnail is incorrect";
                include_once "layout/upload.php";

                return;
            }
            $pdo=Database::instance()->connection();
            $p=$pdo->prepare("insert into video(name, description, video, thumbnail,userFK,views) 
                                          VALUE (:name,:desc,:video,:thumb,:ufk,0)");
            $p->bindParam(":name",$_POST["name"]);
            $p->bindParam(":desc",$_POST["description"]);
            $p->bindParam(":video",$videoPath);
            $p->bindParam(":thumb",$thumbPath);
            $p->bindParam(":ufk",$_SESSION["uid"]);
            $p->execute();
            $vid=$pdo->query("select LAST_INSERT_ID()")->fetchColumn(0);
            echo "<script>window.location.replace(\"/WebVideoPlace/Video?id=".$vid."\")</script>";

        }else{
            $eName="please fill out the entire form";
            include_once "layout/upload.php";
            return;

        }
    }
}