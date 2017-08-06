<?php require_once("../includes/initialize.php"); ?>
<?php section('header.php'); ?>
<?php section('navigation.php'); ?>
<?php
    if(!isset($_GET['email']) && !isset($_GET['token'])) {
        redirect_to('index');
    }

    $token = $_GET['token'];

    $user = User::find_by_column('token',$token);

    if($_GET['email'] != $user->email || $_GET['token'] != $user->token) {
        redirect_to('index');
    }

    if (isset($_POST['reset-submit'])) {
        if($_POST['password'] != $_POST['repeat_password']) {
            $_SESSION['message'] = die("<div class='alert alert-danger'>Repeat the Password correctly ". "</div>");
        } else {
            //Empty the token
            $user->token = '';
            //Encrypt pass
            $user->password = password_hash($_POST['password'], PASSWORD_BCRYPT, ['cost'=>10]);
            if (!$user->update()) {
                $_SESSION['message'] = die("<div class='alert alert-danger'>Updating password failed " . mysqli_error($database->get_connection()) . "</div>");
            } else {
                $_SESSION['message'] = "<div class='alert alert-success'>User password Updated!</div>";
                redirect_to("login.php");
            }
        }
    }
?>
<!-- Page Content -->
<div class="container">
    <div class="form-gap"></div>
    <div class="container">
        <?php if(isset($_SESSION['message'])) {echo output_message($message); } ?>
        <div class="row">
            <div class="col-md-4 col-md-offset-4">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="text-center">
                            <h3><i class="fa fa-lock fa-4x"></i></h3>
                            <h2 class="text-center">Reset Password</h2>
                            <div class="panel-body">
                                <form id="register-form" role="form" autocomplete="off" class="form" method="post">
                                    <div class="form-group">
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="glyphicon glyphicon-lock color-blue"></i></span>
                                            <input id="password" name="password" placeholder="Set new password" class="form-control"  type="password">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="glyphicon glyphicon-lock color-blue"></i></span>
                                            <input id="repeat_password" name="repeat_password" placeholder="Repeat new password" class="form-control" data-match="password" type="password">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <input name="reset-submit" class="btn btn-lg btn-primary btn-block" value="Reset Password" type="submit">
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

<?php section('footer.php'); ?>
