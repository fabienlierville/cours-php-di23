<?php
require('./inc/config.php');
require('./inc/header.php');
?>
<h1>Login</h1>

<form method="post" action="login_check.php">
    <input type="email" name="Email" placeholder="Email">
    <input type="password" name="Password" placeholder="Password">

    <input type="submit">
</form>

<?php require('./inc/footer.php');?>
