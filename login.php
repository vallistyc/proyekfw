<?php
include_once("bootstrap.php");
Flash::tampilkan();
?>
<!DOCTYPE html>
<html>
<head><title>Halaman Login</title></head>
<body>
    <form action="login_post.php" method="post">
        <input type="text" name="username" placeholder="Username" required>
        <input type="password" name="password" placeholder="Password" required>
        <input type="submit" value="Login">
    </form>
</body>
</html>