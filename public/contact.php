<?php require_once("../includes/initialize.php"); ?>
<?php section('header.php'); ?>
<?php section('navigation.php'); ?>
<?php
if(isset($_POST['contact'])) {
    $to = "konstadinoschr@gmail.com";
    $header = "From: ".$_POST['email'];
    $subject = $_POST['subject'];
    $message = $_POST['message'];

    mail($to,$subject,$message,$header);
}
?>
    <!-- Page Content -->
    <div class="container">
    <div class="row">
        <?php if(isset($_SESSION['message'])) { echo output_message($message); } ?>
        <div class="col-md-6">
            <div class="form-wrap">
                <form data-toggle="validator" role="form" action="contact.php" method="post">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <h3>Contact</h3>
                        </div>
                        <div class="panel-body">
                            <div class="form-group has-feedback">
                                <label class="control-label" for="name">Name</label>
                                <input type="text" class="form-control" title="name" name="name" id="name" data-error="Add your name." placeholder="First and last name" required>
                                <div class="help-block with-errors"></div>
                            </div>
                            <div class="form-group has-feedback">
                                <label class="control-label" for="email">Email</label>
                                <input type="email" class="form-control" title="email" name="email" id="email" data-error="Add an email." placeholder="example@example.com" required>
                                <div class="help-block with-errors"></div>
                            </div>
                            <div class="form-group has-feedback">
                                <label class="control-label" for="subject">Subject</label>
                                <input type="text" class="form-control" title="subject" name="subject" id="subject" data-error="Add a subject." placeholder="Subject" required>
                                <div class="help-block with-errors"></div>
                            </div>
                            <div class="form-group has-feedback">
                                <strong>Message</strong><br/>
                                <textarea class="form-control" title="message" name="message" rows="10" placeholder="Your message" required></textarea>
                                <div class="help-block with-errors"></div>
                            </div>
                        </div>
                        <div class="panel-footer">
                            <div class="form-group">
                                <input type="submit" class="btn btn-primary btn-block" title="contact" name="contact" value="Send Email">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div> <!-- /.col-xs-12 -->
        <hr>
    </div>
    <!-- /.row -->
    <hr>
<?php section('footer.php'); ?>