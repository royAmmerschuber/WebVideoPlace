<html>
<head>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
          integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <?php include_once "head.php"?>
    <script src="/WebVideoPlace/layout/js/main.js"></script>
</head>
<body>
<?php include_once "header.php" ?>
<div>
    <p id="id"><?php echo $x["id"];?></p>
    <label for="name">Name</label>
    <input id="name" value="<?php echo $x["name"];?>">
    <label for="description">Description</label>
    <textarea id="description" ><?php echo $x["description"];?></textarea>

    <button id="save" onclick="saveEdit()">save</button>
    <button id="delete" onclick="deleteEdit()">delete</button>
</div>
<?php include_once "footer.php" ?>
</body>
</html>