<?php require_once("../../../includes/initialize.php"); ?>
<?php

$session_id = session_id();
$time = time();
$time_out_in_seconds = 60;
$time_out = $time - $time_out_in_seconds;

$count = UserOnline::count_by_column('session',$session_id);

if($count == 0) {
    $user_online = new UserOnline();
    $user_online->session = $session_id;
    $user_online->time = $time;
    $user_online->create();
} else {
    $user_online = UserOnline::find_by_column('session',$session_id);
    $user_online->time = $time;
    $user_online->update();
}
echo $users_online_count = UserOnline::count_by_column('time',$time_out);




