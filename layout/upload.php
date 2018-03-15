<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../../../favicon.ico">

    <title>Login</title>
    <?php include_once  "head.php"?>
    <!-- Custom styles for this template -->
    <link href="/WebVideoPlace/layout/css/floating-labels.css" rel="stylesheet">
    <script src="/WebVideoPlace/layout/js/video.js"></script>
</head>

<body>
<?php include_once "header.php"?>
<form class="form-box" method="post" action="/WebVideoPlace/Video/checkUpload" enctype="multipart/form-data">
    <h1>Upload Video</h1>
    <p class="err" id="eName"><?php if(isset($eName)){echo $eName;}?></p>
    <label for="inputName">Video name:</label>
    <input type="text" id="inputName" name="name" class="form-control" placeholder="Video Name" required autofocus>

    <p class="err" id="eDescr"><?php if(isset($eDesc)){echo $eDesc;}?></p>
    <label for="inputDescr">Description:</label>
    <textarea id="inputDescr" class="form-control" name="description" placeholder="Description" required></textarea>
    <p class="err" id="eThumbnail"><?php if(isset($eThumb)){echo $eThumb;}?></p>
    <label for="inputThumbnail">Thumbnail:</label>
    <input type="file" id="inputThumbnail" name="thumbnail" required>
    <p class="err" id="eVideo"><?php if(isset($eVideo)){echo $eVideo;}?></p>
    <label for="inputVideo">Video:</label>
    <input type="file" id="inputVideo" name="video" required>
    <button type="submit">Upload</button>
</form>
<?php include_once "footer.php"?>
</body>
</html>

