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
                SUM(IF(l.isPositive,1,-1))+1 as score,
                :uid=u.id as isMine 
            from video as v 
                left join likedislike as l on v.id=l.videoFK 
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
        echo json_encode($p->fetchAll(PDO::FETCH_OBJ));
    }
}