<?php require_once("../includes/initialize.php"); ?>
<?php section('header.php'); ?>
<?php section('navigation.php'); ?>
<?php
    require './vendor/autoload.php';

    if((!isset($_GET['forgot']))){
        redirect_to('index');
    }

    if(isset($_POST['email'])) {
        $email = $_POST['email'];
        $user = User::find_by_column('email',$email);
        $length = 50;
        $token = bin2hex(openssl_random_pseudo_bytes($length));
        if(User::email_exists($email)){
            $user = User::find_by_column('email', $email);
            $user->token = $token;
            $user->update();

            //configure PHPMailer
            $mail = new PHPMailer();
            $mail->isSMTP();
            $mail->Host = MailTrap::SMTP_HOST;
            $mail->Username = MailTrap::SMTP_USER;
            $mail->Password = MailTrap::SMTP_PASSWORD;
            $mail->Port = MailTrap::SMTP_PORT;
            $mail->SMTPSecure = 'tls';
            $mail->SMTPAuth = true;
            $mail->isHTML(true);
            $mail->CharSet = 'UTF-8';

            $mail->setFrom('info@localhost', 'CMS Administration');
            $mail->addAddress($email);
            $mail->Subject = 'CMS pass reset';
            $mail->Body = '<p>Please click to reset your password

            <a href="http://localhost/cms/public/reset.php?email='.$email.'&token='.$token.' ">http://localhost/cms/public/reset.php?email='.$email.'&token='.$token.'</a>
            </p>';
            if($mail->send()){
                $emailSent = true;
            } else{
                echo "NOT SENT";
            }
        } else {
             $_SESSION['session'] = die("<div class='alert alert-danger'>This mail does not exist in our database " . mysqli_error($database->get_connection()) . "</div>");
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
                        <?php if(!isset($emailSent)): ?>
                                <h3><i class="fa fa-lock fa-4x"></i></h3>
                                <h2 class="text-center">Forgot Password?</h2>
                                <p>You can reset your password here.</p>
                                <div class="panel-body">
                                    <form id="register-form" role="form" autocomplete="off" class="form" method="post">
                                        <div class="form-group">
                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="glyphicon glyphicon-envelope color-blue"></i></span>
                                                <input id="email" name="email" placeholder="email address" class="form-control"  type="email">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <input name="recover-submit" class="btn btn-lg btn-primary btn-block" value="Reset Password" type="submit">
                                        </div>
                                        <input type="hidden" class="hide" name="token" id="token" value="">
                                    </form>
                                </div><!-- Body-->
                            <?php else: ?>
                                <h2>Please check your email</h2>
                            <?php endIf; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <hr>
<?php section('footer.php'); ?>