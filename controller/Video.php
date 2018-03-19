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
        if(!isset($_GET["id"])){
            //echo "<script>window.location.replace(\"/WebVideoPlace/Main\")</script>";
            return;
        }
        $id=$_GET["id"];
        $p=$pdo->prepare("
            select v.*,
                u.name as owner,
                u.id=:uid as isMine, 
                (select isPositive from likedislike as li where li.userFK=:uid and li.videoFK=v.id) AS myLike
            from video as v
                left JOIN user as u on u.id=v.userFK
            where v.id=:id");
        $p->bindParam(":id",$id);
        $p->bindParam(":uid",$_SESSION["uid"]);
        $p->execute();
        $vid=$p->fetch(PDO::FETCH_ASSOC);
        $p=$pdo->prepare("
            select SUM(if(isPositive,1,0)) as likes, 
                SUM(if(isPositive,0,1)) as dislikes 
            from likedislike
            WHERE videoFK=:vid");
        $p->bindParam(":vid",$id);
        $p->execute();
        $like=$p->fetch(PDO::FETCH_ASSOC);
        if(!$vid["isMine"]){
            $p=$pdo->prepare("update video set views=views+1 where id=:id");
            $p->bindParam(":id",$id);
            $p->execute();
        }
        $p=$pdo->prepare("
            Select c.*, u.name, u.id=:oid as isOwner
            from comment as c
                LEFT JOIN user as u on u.id=c.userFK
            WHERE videoFK=:id");
        $p->bindParam(":id",$id);
        $p->bindParam(":oid",$vid["id"]);
        $p->execute();
        $comments=$p->fetchAll(PDO::FETCH_ASSOC);
        include_once "layout/video.php";
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
            //echo "<script>window.location.replace(\"/WebVideoPlace/Video?id=".$vid."\")</script>";

        }else{
            $eName="please fill out the entire form";
            include_once "layout/upload.php";
            return;

        }
    }

    public function edit(){

    }

    public function like(){
        //echo $_POST["isPositive"];
        $pdo=Database::instance()->connection();
        $p=$pdo->prepare("
            select count(*) from likedislike 
            where userFK=:uid and videoFK=:vid and isPositive=:pos");
        $p->bindParam(":uid",$_SESSION["uid"]);
        $p->bindParam(":vid",$_POST["vid"]);
        $truth=$_POST["isPositive"]=="true";
        $p->bindParam(":pos",$truth);
        $p->execute();
        //echo $p->debugDumpParams()."<br><br><br>";
        $x=$p->fetchColumn();
        //echo $x;
        if($x==1){
            $p=$pdo->prepare("delete from likedislike where userFK=:uid and videoFK=:vid");

        }else{
            $p=$pdo->prepare("replace likedislike(isPositive, userFK, videoFK) VALUE (:pos,:uid,:vid)");
            $tru=$_POST["isPositive"]=="true"?1:0;

            $p->bindParam(":pos",$tru);
        }
        $p->bindParam(":uid",$_SESSION["uid"]);
        $p->bindParam(":vid",$_POST["vid"]);
        $p->execute();
        //echo $p->debugDumpParams();
        $p=$pdo->prepare("
            select SUM(if(isPositive,1,0)) as likes, 
                SUM(if(isPositive,0,1)) as dislikes,
                (SELECT x.isPositive from likedislike as x where x.userFK=:uid and x.videoFK=:vid) as myLike
            from likedislike
            WHERE videoFK=:vid");
        $p->bindParam(":vid",$_POST["vid"]);
        $p->bindParam(":uid",$_SESSION["uid"]);
        $p->execute();
        echo json_encode($p->fetch(PDO::FETCH_ASSOC));
    }
}