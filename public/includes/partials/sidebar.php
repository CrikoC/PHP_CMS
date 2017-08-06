<?php global $session; echo $session->user_role; ?>
<!-- Blog Sidebar Widgets Column -->
<div class="col-md-4">
    <!-- Blog Search Well -->
    <div class="well">
        <h4>Blog Search</h4>
        <form action="search.php" method="post">
            <div class="input-group">
                <input type="text" name="search_input" class="form-control">
                <span class="input-group-btn">
                    <button type="submit" name="submit_search" class="btn btn-default" type="button">
                        <span class="glyphicon glyphicon-search"></span>
                    </button>
                </span>
            </div>
        </form>
        <!-- /.input-group -->
    </div>

    <!-- Blog Login Well -->
    <div class="well">
        <?php if (!isset($_SESSION['user_id'])) {  ?>

            <h4>Login</h4>
            <hr>
            <?php if(isset($_SESSION['message'])) {echo output_message($message); } ?>
            <div class="row">
                <div class="col-md-12 col-lg-12">
                    <form role="form" action="/cms/public/includes/login.php" method="post">
                        <div class="form-group has-feedback">
                            <label class="control-label" for="username">Username</label>
                            <input type="text" class="form-control" title="username" name="username" data-error="Enter a username" required>
                            <div class="help-block"></div>
                        </div>
                        <div class="form-group has-feedback">
                            <label class="control-label" for="password">Password</label>
                            <input type="password" class="form-control" title="password" name="password" data-error="Enter a password" required>
                            <div class="help-block"></div>
                        </div>
                        <div class="form-group">
                            <a href="/cms/public/forgot.php?forgot=<?php echo uniqid(true); ?>">Forgot password?</a>
                        </div>
                        <input class="btn btn-primary btn-block" type="submit" name="login" value="Login">
                    </form>
                </div>
            </div>
        <?php } else { ?>
            <h4>
                <?php
                $user = User::find_by_id($session->user_id);
                echo "Hello $user->first_name";
                ?>
            </h4>
            <hr>
            <form role="form" action="includes/logout.php" method="post">
                <input class="btn btn-primary btn-block" type="submit" name="logout" value="Logout">
            </form>
        <?php }  ?>
        <!-- /.row -->
    </div>


    <!-- Blog Categories Well -->
    <div class="well">
        <h4>Categories</h4>
        <div class="row">
            <div class="col-lg-6">
                <ul class="list-unstyled">
                    <?php
                    $categories = Category::find_all();
                    foreach($categories as $category):?>
                        <li><a href="category/<?php echo $category->id; ?>"><?php echo $category->title; ?></a></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
        <!-- /.row -->
    </div>


    <!-- Side Widget Well -->

</div>