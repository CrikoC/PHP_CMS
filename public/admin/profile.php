<?php require_once("../../includes/initialize.php"); ?>
<?php if (!$session->is_admin_logged_in()) { redirect_to("../index.php"); } ?>
<?php $user = User::find_by_id($session->user_id) ?>
<?php admin_section('header.php'); ?>
<?php admin_section('navigation.php'); ?>
    <div id="page-wrapper">
        <div class="container-fluid">
            <!-- Page Heading -->
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">
                        <h2><?php echo $user->first_name; ?></h2>
                    </h1>
                    <ol class="breadcrumb">
                        <li>
                            <i class="fa fa-dashboard"></i> <a href="index.php">Dashboard</a>
                        </li>
                        <li class="active">
                            <i class="fa fa-user"></i>  <a href="profile.php">Profile</a>
                        </li>
                        <?php
                        if(isset($_GET['edit'])) {
                            $edit = $_GET['edit'];
                            echo '<li class="active"><i class="fa fa-edit" ></i>  <a href="profile.php?edit='.$edit.'">Edit profile</a></li>';
                        }
                        ?>
                    </ol>
                </div>
            </div>
            <div class="row">
                <?php
                    if (isset($_POST['update'])) {
                        $user->username = $_POST['username'];
                        $user->first_name = $_POST['first_name'];
                        $user->last_name = $_POST['last_name'];
                        $user->email = $_POST['email'];
                        $user->role = $_POST['role'];

                        if(empty($_FILES['image']['name'])) {
                            $user->image = $_POST['current_image'];
                        } else {
                            $user->image = $_FILES['image']['name'];
                            $user->image_temp = $_FILES['image']['tmp_name'];
                            $user->upload_image($user->image_temp, $user->image);
                        }

                        if (!$user->update()) {
                            die("<div class='alert alert-danger'>Updating failed " . mysqli_error($database->get_connection()) . "</div>");
                        } else {
                            $_SESSION['session'] = "<div class='alert alert-success'>User Updated!</div>";
                            redirect_to("profile.php");
                        }

                    }

                    if (isset($_POST['update_password'])) {
                        if($_POST['password'] != $_POST['repeat_password']) {
                            die("<div class='alert alert-danger'>Repeat the Password correctly ". "</div>");
                        } else {
                            //Encrypt pass
                            $user->password = password_hash($_POST['password'], PASSWORD_BCRYPT, ['cost'=>10]);
                            if (!$user->update()) {
                                die("<div class='alert alert-danger'>Updating password failed " . mysqli_error($database->get_connection()) . "</div>");
                            } else {
                                $_SESSION['message'] = "<div class='alert alert-success'>User password Updated!</div>";
                                redirect_to("profile.php");
                            }
                        }
                    }
                ?>
                <?php echo output_message($message); ?>
                <?php if(!$user) {
                die("<div class='alert alert-danger'>Error while selecting post ". mysqli_error($database->get_connection()) ."</div>");
                } else { ?>
                <div class="col-xs-12 col-sm-12 col-md-6">
                    <form data-toggle="validator" role="form" action="" method="post" enctype="multipart/form-data">
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <div class="form-group has-feedback">
                                    <label class="control-label" for="username">Username</label>
                                    <input type="text" class="form-control" title="username" name="username" id="username" data-error="Add a username." placeholder="username" value="<?php echo $user->username; ?>" required>
                                    <div class="help-block with-errors"></div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group has-feedback">
                                            <label class="control-label" for="first_name">First Name</label>
                                            <input type="text" class="form-control" title="first_name" name="first_name" id="first_name" placeholder="First Name" value="<?php echo $user->first_name; ?>" required>
                                            <div class="help-block with-errors"></div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group has-feedback">
                                            <label class="control-label" for="last_name">Last Name</label>
                                            <input type="text" class="form-control" title="last_name" name="last_name" id="last_name" placeholder="Last Name" value="<?php echo $user->last_name; ?>" required>
                                            <div class="help-block with-errors"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group has-feedback">
                                    <label class="control-label" for="email">Email</label>
                                    <input type="email" class="form-control" title="email" name="email" id="email" placeholder="example@example.com" value="<?php echo $user->email; ?>" required>
                                    <div class="help-block with-errors"></div>
                                </div>
                                <div class="form-group has-feedback">
                                    <?php if($user->image != null) { ?>
                                        <strong>Current Image</strong><br/>
                                        <input type="hidden" name="current_image" value="<?php echo $user->image; ?>">
                                        <img width="100" src="../includes/images/<?php echo $user->image; ?>" >
                                        <hr>
                                    <?php } ?>
                                    <label class="control-label" for="image">Image</label>
                                    <input type="file" class="form-control" title="image" name="image" id="image" data-error="Add an image.">
                                    <div class="help-block with-errors"></div>
                                </div>
                                <div class="form-group has-feedback">
                                    <label class="control-label" for="role">Role</label>
                                    <select class="form-control" title="role" name="role">
                                        <?php if($user->role == 'admin') { ?>
                                            <option value="admin">Administrator</option>
                                            <option value="subscriber">Subscriber</option>
                                        <?php } else {?>
                                            <option value="subscriber">Subscriber</option>
                                            <option value="admin">Administrator</option>
                                        <?php } ?>
                                    </select>
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div>
                            <div class="panel-footer">
                                <div class="form-group">
                                    <input type="submit" class="btn btn-primary btn-block" title="update" name="update" value="Update Profile">
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <hr>
            </div>
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-6">
                    <form data-toggle="validator" role="form" action="" method="post">
                        <div class="panel panel-warning">
                            <div class="panel-heading">
                                <h3>Set new Password</h3>
                            </div>
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group has-feedback">
                                            <label class="control-label" for="password">Password</label>
                                            <input type="password" class="form-control" title="password" name="password" id="password" placeholder="password" autocomplete="off">
                                            <div class="help-block with-errors"></div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group has-feedback">
                                            <label class="control-label" for="repeat_password">Repeat Password</label>
                                            <input type="password" class="form-control" title="repeat_password" name="repeat_password" id="repeat_password" data-match="password" placeholder="Repeat Password" autocomplete="off">
                                            <div class="help-block with-errors"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="panel-footer">
                                <div class="form-group">
                                    <input type="submit" class="btn btn-warning btn-block" title="update" name="update_password" value="Update Password">
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->
    </div>
    <!-- /#page-wrapper -->
<?php } admin_section('footer.php'); ?>