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
        include_once "layout/MainList.php";
    }

    public function loadList(){
        $pdo=Database::instance()->connection();
        $p=$pdo->prepare("
            Select 
                v.id,
                v.name,
                IF(LENGTH(v.description)>64,
                    concat(substring(v.description,1,64),'...'),
                    v.description) as description,
                v.thumbnail,
                V.views as score,
                :uid=u.id as isMine,
                (select isPositive from likedislike as lx where lx.userFK=:uid and lx.videoFK=v.id) as iLike
            from video as v 
                left join user as u on u.id=v.userFK
            WHERE 
                v.name REGEXP :search or
                v.description REGEXP :search OR 
                u.name REGEXP :search
            GROUP BY v.id
            ORDER BY score,v.name DESC
            "
        );
        $p->bindParam(":search",$_POST["search"]);
        $p->bindParam(":uid",$_SESSION["uid"]);
        $p->execute();
        //echo $p->debugDumpParams();
        $x=$p->fetchAll(PDO::FETCH_OBJ);
        for($i=0;$i<count($x);$i++){
            $x[$i]->name=utf8_encode($x[$i]->name);
            $x[$i]->description=utf8_encode($x[$i]->description);
        }
        echo json_encode($x);
    }

    public function loadListFav(){
        $pdo=Database::instance()->connection();
        $p=$pdo->prepare("
            Select 
                v.id,
                v.name,
                IF(LENGTH(v.description)>64,
                    concat(substring(v.description,1,64),'...'),
                    v.description) as description,
                v.thumbnail,
                V.views as score,
                :uid=u.id as isMine 
            from video as v 
            RIGHT JOIN likedislike as l on v.id=l.videoFK 

                left join user as u on u.id=v.userFK
            WHERE 
                (v.name REGEXP :search or
                v.description REGEXP :search OR 
                u.name REGEXP :search) AND 
                L.userFK=:uid AND 
                L.isPositive=TRUE 
            ORDER BY score,v.name DESC
            "
        );
        $p->bindParam(":search",$_POST["search"]);
        $p->bindParam(":uid",$_SESSION["uid"]);
        $p->execute();
        $x=$p->fetchAll(PDO::FETCH_OBJ);
        for($i=0;$i<count($x);$i++){
            $x[$i]->name=utf8_encode($x[$i]->name);
            $x[$i]->description=utf8_encode($x[$i]->description);
        }
        echo json_encode($x);
    }

    public function favorites(){
        Auth::securePage();
        $fav="Fav";
        include_once "layout/FavList.php";
    }

    public function dropFav(){
        echo "test";
        $pdo=Database::instance()->connection();
        $p=$pdo->prepare("DELETE from likeDislike where videoFK=:vid and userFK=:uid");
        $p->bindParam(":vid",$_POST["vid"]);
        $p->bindParam(":uid",$_SESSION["uid"]);
        $p->execute();
    }
}