<html>
<head>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
          integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <?php include_once "head.php"?>
    <script src="/WebVideoPlace/layout/js/main.js"></script>
    <link href="/WebVideoPlace/layout/css/floating-labels.css" rel="stylesheet">

</head>
<body>
<?php include_once "header.php" ?>
<div class="form-box" style="width: 45%">
    <h1>Edit Video</h1>
    <p id="id" style="visibility: collapse;position:absolute"><?php echo $x["id"];?></p>
    <label for="name">Name</label>
    <input id="name" value="<?php echo $x["name"];?>" class="form-control">
    <label for="description">Description</label>
    <textarea id="description" class="form-control" style="height: 200px; resize: none"><?php echo $x["description"];?></textarea>

    <button id="save" onclick="saveEdit()">save</button>
    <button id="delete" onclick="deleteEdit()">delete</button>
</div>
<?php include_once "footer.php" ?>
</body>
</html>