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
    <h4><?php echo $vid["owner"];?></h4>
    <video controls autoplay>
        <source src="/WebVideoPlace/media/video/<?php echo $vid["video"];?>" >
    </video>
    <div>
        <p>views:<?php echo $vid["views"];?></p>
        <img src="/WebVideoPlace/layout/icons/like.png" onclick="like(true,<?php echo $vid["id"];?>)">
        <p><?php echo $vid["likes"];?></p>
        <img src="/WebVideoPlace/layout/icons/like.png" onclick="like(false,<?php echo $vid["id"];?>)" class="dislike">
        <p id="likes"><?php echo $vid["dislikes"];?></p>
        <?php
        if($vid["isMine"]){
            echo "<a href=\"/WebVideoPlace/Video/edit?id=".$vid["id"]."\" class=\"btn\">edit</a>";
        }
        ?>
    </div>
    <p>
        <?php echo $vid["description"];?>
    </p>
</div>


<?php include_once "footer.php" ?>
</body>
</html>
