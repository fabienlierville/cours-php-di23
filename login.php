<?php
session_start();
require('./inc/config.php');
require('./inc/header.php');
?>
<h1>Login</h1>

<?php
    if(isset($_SESSION['ERROR'])){
        echo "<p style='color: red'>".$_SESSION['ERROR']."</p>";
        unset($_SESSION['ERROR']);
    }
?>

<form method="post" action="login_check.php">
    <input type="email" name="Email" placeholder="Email">
    <input type="password" name="Password" placeholder="Password">

    <input type="submit">
</form>

<?php require('./inc/footer.php');?>
