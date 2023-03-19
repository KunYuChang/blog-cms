<?php
include "includes/db.php";
include "includes/header.php";

if (!isset($_GET['email']) || !isset($_GET['token'])) {
    redirect('index');
}

$email = $_GET['email'];
$token = $_GET['token'];

$stmt = mysqli_prepare($connection, 'SELECT username, user_email, token FROM users WHERE token=?');
mysqli_stmt_bind_param($stmt, "s", $token);
mysqli_stmt_execute($stmt);
mysqli_stmt_bind_result($stmt, $username, $user_email, $token);
mysqli_stmt_fetch($stmt);
mysqli_stmt_close($stmt);

if (empty($user_email) || $token !== $_GET['token']) {
    redirect('index');
}

if (isset($_POST['password'], $_POST['confirmPassword']) && ($_POST['password'] === $_POST['confirmPassword'])) {
    $hashedPassword = password_hash($_POST['password'], PASSWORD_ARGON2ID, ['memory_cost' => 2048, 'time_cost' => 4, 'threads' => 2]);
    $stmt = mysqli_prepare($connection, "UPDATE users SET token='', user_password=? WHERE user_email = ?");
    mysqli_stmt_bind_param($stmt, "ss", $hashedPassword, $email);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    if (mysqli_affected_rows($connection) >= 1) {
        redirect('/login.php');
    }
}
include "includes/nav.php";
?>
<div class="container">



<div class="container">
    <div class="row">
        <div class="col-md-4 col-md-offset-4">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="text-center">


                        <h3><i class="fa fa-lock fa-4x"></i></h3>
                        <h2 class="text-center">Reset Password</h2>
                        <p>You can reset your password here.</p>
                        <div class="panel-body">


                            <form id="register-form" role="form" autocomplete="off" class="form" method="post">

                                <div class="form-group">
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="glyphicon glyphicon-user color-blue"></i></span>
                                        <input id="password" name="password" placeholder="Enter password" class="form-control"  type="password">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="glyphicon glyphicon-ok color-blue"></i></span>
                                        <input id="confirmPassword" name="confirmPassword" placeholder="Confirm password" class="form-control"  type="password">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <input name="resetPassword" class="btn btn-lg btn-primary btn-block" value="Reset Password" type="submit">
                                </div>

                                <input type="hidden" class="hide" name="token" id="token" value="">
                            </form>

                        </div><!-- Body-->

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<hr>

<?php include "includes/footer.php";?>

</div> <!-- /.container -->