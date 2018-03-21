<html>
<head>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
          integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <?php include_once "head.php"?>
    <script src="/WebVideoPlace/layout/js/auth.js"></script>
    <link href="/WebVideoPlace/layout/css/floating-labels.css" rel="stylesheet">

</head>
<body>
<?php include_once "header.php" ?>
<div class="form-box" style="width: 45%">
    <h1>Edit User</h1>
    <p class="err" id="eName"></p>
    <label for="oPass">old Password</label>
    <input type="password" id="oPass" class="form-control">
    <label for="name">Name</label>
    <input id="name" value="<?php echo $x["name"];?>" class="form-control">
    <label for="email">email</label>
    <input type="email" id="email" value="<?php echo $x["email"];?>" class="form-control">
    <label for="nPass">new Password</label>
    <input id="nPass" class="form-control">
    <button id="save" onclick="editUser()">save</button>
</div>
<?php include_once "footer.php" ?>
</body>
</html>