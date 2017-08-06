<?php require_once("../includes/initialize.php"); ?>
<?php section('header.php'); ?>
<?php section('navigation.php'); ?>
<?php if(!isset($_GET['name'])) { redirect_to('index.php'); } ?>
<?php $author = User::find_by_column('username',$_GET['name']); ?>
    <!-- Page Content -->
    <div class="container">
    <div class="row">
        <!-- Blog Entries Column -->
        <div class="col-md-8">
            <h1 class="page-header">
                <?php echo $author->username; ?>
                <small>Info</small>
            </h1>
            <!-- Blog Posts -->
            <ul class="list-group">
                <li class="list-group-item">
                    Name: <?php echo $author->first_name; ?> <?php echo $author->last_name; ?>
                </li>
                <li class="list-group-item">
                    Email: <?php echo $author->email; ?>
                </li>
            </ul>
            <h3 class="page-header">
                All posts by <?php echo $author->username; ?>
            </h3>
            <ul class="list-group">
            <?php
            $posts = Post::find_by_column('author', $author->username);
            foreach ($posts as $post):
            ?>
                <li class="list-group-item">
                    <div class="row">
                        <div class="col-xs-2">
                            <img width="100" src="includes/images/<?php echo $post->image; ?>">
                        </div>
                        <div class="col-xs-2">
                            <a href="post.php?id=<?php echo $post->id; ?>"><?php echo $post->title; ?></a>
                        </div>
                        <div class="col-xs-5">
                            <?php  the_excerpt($post->content); ?>...<a href="post.php?id=<?php echo $post->id; ?>">Read more</a>
                        </div>
                        <div class="col-xs-3">
                            <?php $category = Category::find_by_id($post->category_id); ?>
                            In category: <a href="category.php?id=<?php echo $category->id; ?>"><?php echo $category->title; ?></a>
                            <br/><br/>
                            <span class="glyphicon glyphicon-time"></span> <?php  echo $post->date; ?>
                        </div>
                    </div>
                </li>
            <?php endforeach; ?>
            </ul>
        </div>
        <?php section('sidebar.php'); ?>
    </div>
    <!-- /.row -->

    <hr>
<?php section('footer.php'); ?>