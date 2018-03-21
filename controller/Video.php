<?php
/**
 * Created by PhpStorm.
 * User: Roy
 * Date: 14/03/2018
 * Time: 10:10
 */

class Video
{
    //View
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
        include_once "layout/video.php";
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
    public function comment(){
        Auth::securePage();
        $p=Database::instance()->connection()->prepare("
            insert into comment(text, userFK, videoFK) 
        VALUE (:text,:uid,:vid)");
        $p->bindParam(":text",$_POST["text"]);
        $p->bindParam(":uid",$_SESSION["uid"]);
        $p->bindParam(":vid",$_POST["vid"]);
        $p->execute();
        echo "test";
    }

    public function loadComments(){
        $pdo=Database::instance()->connection();
        $p=$pdo->prepare("
            Select c.*, u.name, u.id=v.userFK as isOwner
            from comment as c
                LEFT JOIN user as u on u.id=c.userFK
                LEFT JOIN video as v on v.id=c.videoFK
            WHERE videoFK=:vid");
        $p->bindParam(":vid",$_POST["vid"]);
        $p->execute();
        $x=$p->fetchAll(PDO::FETCH_ASSOC);
        for($i=0;$i<count($x);$i++){
            $x[$i]["name"]=utf8_encode($x[$i]["name"]);
            $x[$i]["text"]=utf8_encode($x[$i]["text"]);
        }
       // echo print_r($x);
        echo json_encode($x);
    }
    //Upload
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
            echo "<script>window.location.replace('/WebVideoPlace/Video?id=".$vid."')</script>";

        }else{
            $eName="please fill out the entire form";
            include_once "layout/upload.php";
            return;

        }
    }

    //Edit
    public function edit(){
        $uid=Auth::securePage();
        $pdo=Database::instance()->connection();
        $p=$pdo->prepare("select * from video where id=:vid");
        $p->bindParam(":vid",$_GET["id"]);
        $p->execute();
        $x=$p->fetch(PDO::FETCH_ASSOC);

        if($uid!=$x["userFK"]){
            header("Location: /WebVideoPlace/Video?id=".$x["id"]);
            die();
        }
        include_once "layout/edit.php";
    }

    public function editSave(){
        $pdo=Database::instance()->connection();
        $p=$pdo->prepare("update video set name=:name, description=:desc where id=:vid");
        $p->bindParam(":name",$_POST["name"]);
        $p->bindParam(":desc",$_POST["desc"]);
        $p->bindParam(":vid",$_POST["vid"]);
        $p->execute();
        return true;
    }
    public function editDelete(){
        $pdo=Database::instance()->connection();
        $p=$pdo->prepare("
            select video as v,thumbnail as t from video where id=:vid");
        $p->bindParam(":vid",$_POST["vid"]);
        $p->execute();
        $files=$p->fetch(PDO::FETCH_ASSOC);
        $p=$pdo->prepare("
                delete from video where id=:vid; 
                delete from comment where videoFK=:vid; 
                delete from likedislike where videoFK=:vid");
        $p->bindParam(":vid",$_POST["vid"]);
        $p->execute();
        unlink(Uploader::$VIDEO_LOC.$files["v"]);
        unlink(Uploader::$THUMB_LOC.$files["t"]);
        return true;
    }
}