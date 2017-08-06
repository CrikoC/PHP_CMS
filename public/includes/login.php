<?php require_once("../../includes/initialize.php"); ?>
<?php

if (isset($_POST['login'])) { // Form has been submitted.
    $username = $_POST['username'];
    $password = $_POST['password'];
    //first find the user by username to grab the encrypted pass
    $user = User::find_by_column('username',$username);

    if(password_verify($password, $user->password)) {
        $found_user = $user;
        $session->login($found_user);
        if ($found_user->role == "admin") {
            redirect_to('../admin/');
        } else {
            redirect_to('../');
        }
    } else {
        redirect_to('../index.php');
        $_SESSION['message'] = die("<div class='alert alert-danger'>Incorrect username or password</div>" . mysqli_error($database->get_connection()));
    }

} else { // Form has not been submitted.
    $username = "";
    $password = "";
}
