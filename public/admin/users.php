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
                        <span class="glyphicon glyphicon-user"></span> Users
                        <a href="users.php?add" class="btn btn-success">
                            <span class="glyphicon glyphicon-plus"></span>
                        </a>
                    </h1>
                    <ol class="breadcrumb">
                        <li>
                            <i class="fa fa-dashboard"></i> <a href="index.php">Dashboard</a>
                        </li>
                        <li class="active">
                            <i class="fa fa-user"></i>  <a href="users.php">Users</a>
                        </li>
                        <?php
                        if(isset($_GET['edit'])) {
                            $edit = $_GET['edit'];
                            echo '<li class="active"><i class="fa fa-edit" ></i>  <a href="users.php?edit='.$edit.'">Edit user</a></li>';
                        } else if(isset($_GET['add'])) {
                            echo '<li class="active"><i class="fa fa-edit"></i>  <a href="users.php?add">Add user</a></li>';
                        }
                        ?>
                    </ol>
                </div>
            </div>
            <div class="row">
                <?php
                if(isset($_GET['delete'])) {
                    if($session->is_admin_logged_in()) {
                        $user = User::find_by_id($_GET['delete']);
                        if(!$user->delete()) {
                            $_SESSION['message'] = "<div class='alert alert-danger'>Deleting failed</div>";
                        } else {
                            $_SESSION['message'] = "<div class='alert alert-success'>User Deleted!</div>";
                            redirect_to("users.php");
                        }
                    }

                }
                if(isset($_GET['approve'])) {
                    if($session->is_admin_logged_in()) {
                        $user = User::find_by_id($_GET['approve']);
                        $user->status = 'approved';

                        if (!$user->update()) {
                            $_SESSION['message'] = "<div class='alert alert-danger'>Updating failed</div>";
                        } else {
                            $_SESSION['message'] = "<div class='alert alert-success'>User approved!</div>";
                            redirect_to("users.php");
                        }
                    }
                }
                if(isset($_GET['dismiss'])) {
                    if($session->is_admin_logged_in()) {
                        $user = User::find_by_id($_GET['dismiss']);
                        $user->status = 'dismissed';

                        if (!$user->update()) {
                            $_SESSION['message'] = "<div class='alert alert-danger'>Updating failed</div>";
                        } else {
                            $_SESSION['message'] = "<div class='alert alert-success'>User dismissed!</div>";
                            redirect_to("users.php");
                        }
                    }
                }
                ?>
                <?php echo output_message($message); ?>
                <?php
                if(isset($_GET['edit'])) {
                    admin_section("users/edit_user.php");
                } else if(isset($_GET['add'])) {
                    admin_section("users/add_user.php");
                } else {
                    admin_section("users/view_users.php");
                }
                ?>
            </div>
        </div>
        <!-- /.container-fluid -->
    </div>
    <!-- /#page-wrapper -->
<?php admin_section('footer.php'); ?>