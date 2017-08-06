l<?php require_once("../includes/initialize.php"); ?>
<?php section('header.php'); ?>
<?php section('navigation.php'); ?>
<?php if (($session->is_admin_logged_in()) || ($session->is_subscriber_logged_in())) { redirect_to("/cms/public/index"); } ?>
<!-- Page Content -->
<div class="container">
	<div class="form-gap"></div>
	<div class="container">
        <?php echo output_message($message); ?>
        <div class="row">
			<div class="col-md-4 col-md-offset-4">
				<div class="panel panel-default">
					<div class="panel-body">
						<div class="text-center">
							<h3><i class="fa fa-user fa-4x"></i></h3>
							<h2 class="text-center">Login</h2>
							<div class="panel-body">
								<form id="login-form" action="/cms/public/includes/login.php" role="form" autocomplete="off" class="form" method="post">
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
                                        <a href="/cms/public/forgot.php?forgot=<?php echo uniqid(true); ?>">Forgot password?</a>
                                    </div>
                                    <div class="form-group">
										<input name="login" class="btn btn-lg btn-primary btn-block" value="Login" type="submit">
									</div>
								</form>
							</div><!-- Body-->
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<hr>
    <?php section('footer.php'); ?>
</div> <!-- /.container -->