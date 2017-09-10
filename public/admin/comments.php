<?php require_once("../../includes/initialize.php"); ?>
<?php if (!$session->is_admin_logged_in()) { redirect_to("../index.php"); } ?>
<?php admin_section('header.php'); ?>
<?php admin_section('navigation.php'); ?>
<?php
    function redirect() {
        if(isset($_GET['post'])) {
            $post_id = $_GET['post'];
            redirect_to("comments.php?post=$post_id");
        } else {
            redirect_to("comments.php");
        }
    }
?>
    <div id="page-wrapper">
        <div class="container-fluid">
            <!-- Page Heading -->
            <div class="row">

                <div class="col-lg-12">
                    <h1 class="page-header">
                        <?php
                        if(isset($_GET['post'])) {
                            $post_id = $_GET['post'];
                            $post = Post::find_by_id($post_id);
                            echo "Comments in ".$post->title;
                        } else { echo "Comments"; };
                        ?>
                    </h1>
                    <ol class="breadcrumb">
                        <li>
                            <i class="fa fa-dashboard"></i> <a href="index.php">Dashboard</a>
                        </li>
                        <li class="active">
                            <i class="fa fa-comments"></i>  <a href="comments.php">Comments</a>
                        </li>
                        <?php
                        if(isset($_GET['post'])) {
                            $post_id = $_GET['post'];
                            $post = Post::find_by_id($post_id);
                            echo '<li class="active"><i class="fa fa-file-text"></i>  <a href="comments.php?post='.$post_id.'">Comments in '.$post->title.'</a></li>';
                        }
                        ?>
                    </ol>
                </div>
            </div>
            <div class="row">
                <?php echo output_message($message); ?>
                <?php
                if(isset($_GET['delete'])) {
                    $comment = Comment::find_by_id($_GET['delete']);
                    if(!$comment->delete()) {
                        $_SESSION['message'] = "<div class='alert alert-danger'>Deleting failed</div>";
                    } else {
                        $_SESSION['message'] = "<div class='alert alert-success'>Comment deleted!</div>";
                        redirect();
                    }
                }
                if(isset($_GET['approve'])) {
                    $comment = Comment::find_by_id($_GET['approve']);
                    $comment->status = 'approved';

                    if(!$comment->update()) {
                        $_SESSION['message'] = "<div class='alert alert-danger'>Updating failed</div>";
                    } else {
                        $_SESSION['message'] = "<div class='alert alert-success'>Comment approved!</div>";
                        redirect();
                    }
                }
                if(isset($_GET['dismiss'])) {
                    $comment = Comment::find_by_id($_GET['dismiss']);
                    $comment->status = 'dismissed';

                    if(!$comment->update()) {
                        $_SESSION['message'] = "<div class='alert alert-danger'>Updating failed</div>";
                    } else {
                        $_SESSION['message'] = "<div class='alert alert-success'>Comment dismissed!</div>";
                        redirect();
                    }
                }
                ?>
                <div class="col-xs-12">
                    <?php
                        if(isset($_GET['post'])) {
                            $post_id = $_GET['post'];
                            include "includes/partials/comments/post_comments.php";
                        } else {
                            include "includes/partials/comments/view_comments.php";
                        }
                    ?>
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->
    </div>
    <!-- /#page-wrapper -->
<?php admin_section('footer.php'); ?>