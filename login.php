<?php  include "includes/db.php"; ?>
<?php  include "includes/header.php"; ?>
<?php  include "includes/nav.php"; ?>

<?php
    checkIfUserIsLoggedInAndRedirect('/admin');

    if(ifItIsMethod('post')) {

        if( !empty($_POST['username']) && !empty($_POST['password']) ) {
            login_user($_POST['username'], $_POST['password']);
        } else {
            redirect('/login.php');
        }
    }
?>


<!-- Page Content -->
<main  class="container">

	<section  class="form-gap"></section>
	<section  class="container">
		<div class="row">
			<div class="col-md-4 col-md-offset-4">
				<article class="panel panel-default">
					<section class="panel-body">
						<div class="text-center">


							<h3><i class="fa fa-user fa-4x"></i></h3>
							<h2 class="text-center">Login</h2>
							<section class="panel-body">


								<form id="login-form" role="form" autocomplete="off" class="form" method="post">

									<div class="form-group">
										<div class="input-group">
											<span class="input-group-addon"><i class="glyphicon glyphicon-user color-blue"></i></span>

											<input name="username" type="text" class="form-control" placeholder="Enter Username">
										</div>
									</div>

									<div class="form-group">
										<div class="input-group">
											<span class="input-group-addon"><i class="glyphicon glyphicon-lock color-blue"></i></span>
											<input name="password" type="password" class="form-control" placeholder="Enter Password">
										</div>
									</div>

									<div class="form-group">

										<input name="login" class="btn btn-lg btn-primary btn-block" value="Login" type="submit">
									</div>


								</form>

							</section><!-- Body-->

						</div>
					</section>
				</article>
			</div>
		</div>
	</section>

	<hr>

	<?php include "includes/footer.php";?>

</main> <!-- /.container -->