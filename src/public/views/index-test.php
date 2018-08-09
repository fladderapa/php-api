<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Login page</title>
</head>
<?php require_once 'partials/head.php';
/*if (isset($_GET[ "message"])) {
    echo $_GET[ "message"];
    echo "hiiiiiiiiiiiiiiiii";
}*/
if (!isset($_SESSION[ "loggedIn"])):

?>

<body>
  <h1>test</h1>
    <main class="main-wrapper">
        <div class="box-design">
            <form action="partials/register.php" method="POST">
                <label for="">Not a member yet?</label>
                <br>
                <input type="text" class="form-control" name="username">
                <input type="text" class="form-control" name="password">
                <input type="submit" value="Register">
            </form>

            <form action="partials/signin.php" method="POST">
                <label for="">Already a member!</label>
                <br>
                <input type="text" class="form-control" name="username">
                <input type="password" class="form-control" name="password">
                <input type="submit" value="Login">
            </form>
        </div>

    </main>
    <?php endif; ?>

</body>
<?php require 'partials/footer.php';?>


</html>
