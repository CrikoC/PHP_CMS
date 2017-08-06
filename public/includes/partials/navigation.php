<?php if(isset($_SESSION['user_id'])){ $user = User::find_by_id($_SESSION['user_id']); } ?>
<?php global $session; ?>
<!-- Navigation -->
<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
    <div class="container">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="/cms/public/index">BLOG</a>
        </div>
        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
                <?php
                $categories = Category::find_all();

                foreach($categories as $category):
                $active = '';
                if(isset($_GET['id']) && $_GET['id'] == $category->id) {
                    $active = 'active';
                }
                ?>
                    <li class="<?php echo $active; ?>">
                        <a href="/cms/public/category/<?php echo $category->id; ?>"><?php echo $category->title; ?></a>
                    </li>
                <?php endforeach; ?>
                <li class="<?php if(basename($_SERVER['PHP_SELF']) == 'contact.php') { echo 'active'; } ?>">
                    <a href="/cms/public/contact">Contact</a>
                </li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <?php if($session->is_admin_logged_in() || $session->is_subscriber_logged_in()) { ?>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i> Welcome <?php echo $user->first_name; ?><b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <?php if($session->is_admin_logged_in()) { ?>
                            <li>
                                <a href="/cms/public/admin/profile.php"><i class="fa fa-fw fa-user"></i> Profile</a>
                            </li>
                            <li><a href='/cms/public/admin/'><i class="fa fa-dashboard"></i> Dashboard</a></li>
                            <li class="divider"></li>
                        <?php } ?>
                        <li>
                            <a href="/cms/public/includes/logout.php"><i class="fa fa-fw fa-power-off"></i> Log Out</a>
                        </li>
                    </ul>
                </li>
                <?php } else { ?>
                    <li class="<?php if(basename($_SERVER['PHP_SELF']) == 'login.php') { echo 'active'; } ?>">
                        <a href='/cms/public/login'>Login</a>
                    </li>
                    <li class="<?php if(basename($_SERVER['PHP_SELF']) == 'register.php') { echo 'active'; } ?>">
                        <a href='/cms/public/register'>Register</a>
                    </li>
                <?php } ?>
            </ul>


        </div>
        <!-- /.navbar-collapse -->
    </div>
    <!-- /.container -->
</nav>