<?php require_once("../../includes/initialize.php"); ?>
<?php
if(isset($_POST['create'])) {
    $user = new User();

    $user->username = $_POST['username'];
    $user->first_name = $_POST['first_name'];
    $user->last_name = $_POST['last_name'];
    $user->email = $_POST['email'];

    $user->image = $_FILES['image']['name'];
    $user->image_temp = $_FILES['image']['tmp_name'];

    $user->role = $_POST['role'];
    $user->status = $_POST['status'];

    $existing_user = User::find_by_column('username',$user->username);


    if(empty($user->username)) {
        echo "<div class='alert alert-danger'>Enter a name for the post.</div>";
    }
    else if(User::username_exists($user->username)) {
        echo "<div class='alert alert-danger'>Username already exists in database</div>";
    }
    else if(User::email_exists($user->email)) {
        echo "<div class='alert alert-danger'>Email already exists in database</div>";
    }
    else if($_POST['password'] != $_POST['repeat_password']) {
        echo "<div class='alert alert-danger'>You did not repeat the password correctly</div>";
    } else {
        //Encrypt pass
        $user->password = password_hash($_POST['password'], PASSWORD_BCRYPT, ['cost'=>10]);
        if(!$user->create()) {
            die("<div class='alert alert-danger'>Adding failed ". mysqli_error($database->get_connection()) ."</div>");
        } else {
            $user->upload_image($user->image_temp, $user->image);
            $_SESSION['message'] = "<div class='alert alert-success'>User Added!</div>";
            redirect_to("users.php");
        }
    }
}
?>
<div class="col-xs-12 col-sm-12 col-md-6">
    <form data-toggle="validator" role="form" action="" method="post" enctype="multipart/form-data">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3>Add User</h3>
            </div>
            <div class="panel-body">
                <div class="form-group has-feedback">
                    <label class="control-label" for="username">Username</label>
                    <input type="text" class="form-control" title="username" name="username" id="username" data-error="Add a username." placeholder="username" required>
                    <div class="help-block with-errors"></div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group has-feedback">
                            <label class="control-label" for="password">Password</label>
                            <input type="password" class="form-control" title="password" name="password" id="password" data-error="Add a password." placeholder="password" required autocomplete="off">
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group has-feedback">
                            <label class="control-label" for="repeat_password">Repeat Password</label>
                            <input type="password" class="form-control" title="repeat_password" name="repeat_password" id="repeat_password" data-match="password" placeholder="Repeat Password" required autocomplete="off">
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group has-feedback">
                            <label class="control-label" for="first_name">First Name</label>
                            <input type="text" class="form-control" title="first_name" name="first_name" id="first_name" data-error="Add first name." placeholder="First Name" required>
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group has-feedback">
                            <label class="control-label" for="last_name">Last Name</label>
                            <input type="text" class="form-control" title="last_name" name="last_name" id="last_name" data-error="Add last name." placeholder="Last Name" required>
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>
                </div>

                <div class="form-group has-feedback">
                    <label class="control-label" for="email">Email</label>
                    <input type="email" class="form-control" title="email" name="email" id="email" placeholder="example@example.com" required>
                    <div class="help-block with-errors"></div>
                </div>
                <div class="form-group has-feedback">
                    <label class="control-label" for="image">Image</label>
                    <input type="file" class="form-control" title="image" name="image" id="image" data-error="Add an image.">
                    <div class="help-block with-errors"></div>
                </div>
                <div class="form-group has-feedback">
                    <label class="control-label" for="role">Role</label>
                    <select class="form-control" title="role" name="role">
                        <option value="subscriber">Subscriber</option>
                        <option value="admin">Administrator</option>
                    </select>
                    <div class="help-block with-errors"></div>
                </div>
                <div class="form-group has-feedback">
                    <label class="control-label" for="status">Status</label>
                    <select class="form-control" title="status" name="status">
                        <option value="pending">Pending</option>
                        <option value="approved">Approved</option>
                        <option value="dismissed">Dismissed</option>
                    </select>
                    <div class="help-block with-errors"></div>
                </div>
            </div>
            <div class="panel-footer">
                <div class="form-group">
                    <input type="submit" class="btn btn-primary btn-block" title="create" name="create" value="Create">
                </div>
            </div>
        </div>
    </form>
</div>