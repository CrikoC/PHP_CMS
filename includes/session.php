<?php
class Session {

    private $subscriber_logged_in = false;
    private $admin_logged_in = false;
    public $user_id;
    public $user_role;
    public $user_status;
    public $message;

    function __construct() {
        ob_start();
        session_start();
        $this->check_message();
        $this->check_login();
    }

    public function is_admin_logged_in() {
        return $this->admin_logged_in;
    }

    public function is_subscriber_logged_in() {
        return $this->subscriber_logged_in;
    }

    public function login($user) {
        // database should find user based on username/password
        if($user){
            $this->user_id = $_SESSION['user_id'] = $user->id;
            $this->user_role = $_SESSION['user_role'] = $user->role;
            $this->user_status = $_SESSION['user_status'] = $user->status;
            if($this->user_role == 'admin' && $this->user_status == 'approved') {
                $this->admin_logged_in = true;
            }
            else if($this->user_role == 'subscriber' && $this->user_status == 'approved') {
                $this->subscriber_logged_in = true;
            }
        }
    }

    public function logout() {
        unset($_SESSION['user_id']);
        unset($this->user_id);
        if($_SESSION['user_role'] == 'admin') {
            $this->admin_logged_in = false;
        } else {
            $this->subscriber_logged_in = false;
        }
        unset($_SESSION['user_role']);
        unset($this->user_role);
        unset($_SESSION['user_status']);
        unset($this->user_status);

    }

    public function message($msg="") {
        if(!empty($msg)) {
            // then this is "set message"
            // make sure you understand why $this->message=$msg wouldn't work
            $_SESSION['message'] = $msg;
        } else {
            // then this is "get message"
            return $this->message;
        }
    }

    private function check_login() {
        if(isset($_SESSION['user_id'])) {
            $this->user_id = $_SESSION['user_id'];
            if($_SESSION['user_role'] == "admin") {
                $this->admin_logged_in = true;
            }
            else if($_SESSION['user_role'] == "subscriber") {
                $this->subscriber_logged_in = true;
            }

        } else {
            unset($this->user_id);
            $this->admin_logged_in = false;
            $this->subscriber_logged_in = false;
        }
    }

    private function check_message() {
        // Is there a message stored in the session?
        if(isset($_SESSION['message'])) {
            // Add it as an attribute and erase the stored version
            $this->message = $_SESSION['message'];
            unset($_SESSION['message']);
        } else {
            $this->message = "";
        }
    }
}

$session = new Session();
$message = $session->message();