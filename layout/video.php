<html>
<head>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
          integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <?php include_once "head.php"?>
    <script src="/WebVideoPlace/layout/js/main.js"></script>
</head>
<body>
<?php include_once "header.php" ?>
<div class="video-box">
    <h1><?php echo $vid["name"];?></h1>
    <h4>Owner: <?php echo $vid["owner"];?></h4>
    <?php
        $mime=mime_content_type("media/video/".$vid["video"]);
        if(strpos($mime,"video/")!==false){
            echo "<video controls autoplay>
                        <source src=\"/WebVideoPlace/media/video/". $vid["video"]."\" >
                  </video>";
        }else if(strpos($mime,"audio/")!==false){
            echo "<audio controls autoplay>
                      <source src='/WebVideoPlace/media/video/".$vid["video"]."'>
                  </audio>";
        }else if(strpos($mime,"image/")!==false){
            echo "<img src='/WebVideoPlace/media/video/".$vid["video"]."'>";
        }else{
            echo $mime;
        }

    ?>
    <!--<video controls autoplay>
        <source src="/WebVideoPlace/media/video/<?php /*echo $vid["video"];*/?>" >
    </video>-->
    <div class="vid-likebar">
        <p>views:<?php echo $vid["views"];?></p>
        <?php
//        echo $vid["myLike"];
        if($vid["myLike"]==true){
            $lLike=" iLikeBtn";
            $lDislike="";
        }else if($vid["myLike"]==null){
            $lLike="";
            $lDislike="";
        }else{
            $lLike="";
            $lDislike=" iLikeBtn";

        }
        ?>

        <div>
            <img src="/WebVideoPlace/layout/icons/like.png" id="likebtnD" onclick="like(false,<?php echo $vid["id"];?>)" class="dislike <?php echo $lDislike?>">
            <p id="dislikes"><?php if(isset($like["dislikes"])){ echo $like["dislikes"];}else{echo 0;}?></p>
        </div>
        <div>
            <img src="/WebVideoPlace/layout/icons/like.png" id="likebtnL" onclick="like(true,<?php echo $vid["id"];?>)" class="<?php echo $lLike?>">
            <p id="likes"><?php if(isset($like["likes"])){ echo $like["likes"];}else{echo 0;}?></p>
        </div>

    </div>
    <?php
    if($vid["isMine"]){
        echo "<a href=\"/WebVideoPlace/Video/edit?id=".$vid["id"]."\" class=\"btn\">edit</a>";
    }
    ?>
    <h5>Description</h5>
    <p>
        <?php echo $vid["description"];?>
    </p>
    <div class="comments">
        <div>
            <h5>Comment</h5>
            <textarea id="commentText"></textarea>
            <button onclick="comment()">Submit</button>
        </div>
        <div id="commentList">

        </div>
    </div>
</div>


<?php include_once "footer.php" ?>
<script>loadComments();</script>
</body>
</html>
