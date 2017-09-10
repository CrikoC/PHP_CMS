<?php require_once("../../includes/initialize.php"); ?>
<?php if (!$session->is_admin_logged_in()) { redirect_to("../index.php"); } ?>
<?php admin_section('header.php'); ?>
<?php admin_section('navigation.php'); ?>
<div id="page-wrapper">
    <div class="container-fluid">
        <!-- Page Heading -->
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">
                    Posts
                    <a href="posts.php?add" class="btn btn-success">
                        <span class="glyphicon glyphicon-plus"></span>
                    </a>
                </h1>
                <ol class="breadcrumb">
                    <li>
                        <i class="fa fa-dashboard"></i> <a href="index.php">Dashboard</a>
                    </li>
                    <li class="active">
                        <i class="fa fa-file-text"></i>  <a href="posts.php">Posts</a>
                    </li>
                    <?php
                    if(isset($_GET['edit'])) {
                        $edit = $_GET['edit'];
                        echo '<li class="active"><i class="fa fa-edit" ></i>  <a href="posts.php?edit='.$edit.'">Edit post</a></li>';
                    } else if(isset($_GET['add'])) {
                        echo '<li class="active"><i class="fa fa-plus"></i>  <a href="posts.php?add">Add post</a></li>';
                    }
                    ?>
                </ol>
            </div>
        </div>
        <div class="row">
            <?php
            if(isset($_GET['delete'])) {
                $post = Post::find_by_id($_GET['delete']);
                if(!$post->delete()) {
                    $_SESSION['message'] = "<div class='alert alert-danger'>Deleting failed</div>";
                } else {
                    $_SESSION['message'] = "<div class='alert alert-success'>Post Deleted!</div>";
                    redirect_to("posts.php");
                }
            }
            if(isset($_GET['reset'])) {
                $post = Post::find_by_id($_GET['reset']);
                $post->views = 0;
                if(!$post->update()) {
                    $_SESSION['message'] = "<div class='alert alert-danger'>Reset failed</div>";
                } else {
                    $_SESSION['message'] = "<div class='alert alert-success'>Post's views have be reset!</div>";
                    redirect_to("posts.php");
                }
            }
            ?>
            <?php echo output_message($message); ?>
            <?php
            if(isset($_GET['edit'])) {
                admin_section("posts/edit_post.php");
            } else if(isset($_GET['add'])) {
                admin_section("posts/add_post.php");
            } else {
                admin_section("posts/view_posts.php");
            }
            ?>
        </div>
    </div>
    <!-- /.container-fluid -->
</div>
<!-- /#page-wrapper -->
<?php admin_section('footer.php'); ?>