<?php require_once("../includes/initialize.php"); ?>
<?php section('header.php'); ?>
<?php section('navigation.php'); ?>
<?php
    if(!isset($_GET['id'])) {
        redirect_to("index.php");
    }
    $id = $_GET['id'];
    $post = Post::find_by_id($id);
?>
 <?php
    if(isset($_POST['create'])) {
        $user = User::find_by_id($session->user_id);

        $comment = new Comment();

        $comment->post_id = $_GET['id'];
        $comment->author = $user->username;
        $comment->email = $user->email;
        $comment->content = $_POST['content'];
        $comment->status = 'pending';
        $comment->date = date('y-m-d');


        if(empty($comment->content)) {
            echo "<div class='alert alert-danger'>Enter a comment</div>";
        } else {
            if(!$comment->create()) {
                $_SESSION['message'] = die("<div class='alert alert-danger'>Adding failed ". mysqli_error($database) ."</div>");
            } else {
                $_SESSION['message'] = "<div class='alert alert-success'>Comment submitted and pending approval</div>";
                redirect_to("post.php?id=$id");
            }
        }
    }
?>
<!-- Page Content -->
<div class="container">
    <div class="row">

        <!-- Blog Entries Column -->
        <div class="col-md-8">
            <?php if(($post->status == 'published') || (($session->is_admin_logged_in())) ) { ?>
            <?php
                //If the post is available, the views are updated
                $post->views = $post->views + 1;
                $post->update();
            ?>
            <h1 class="page-header">
                <?php echo $post->title; ?>
                <?php if($session->is_admin_logged_in()) { echo "<a class='btn btn-primary' href='/cms/public/admin/posts.php?edit=$post->id'><i class='glyphicon glyphicon-edit'></i></a>"; } ?>
            </h1>
            <p>
                <?php $category = Category::find_by_id($post->category_id); ?>
                Posted in: <a href="/cms/public/category/<?php echo $category->id; ?>"><?php echo $category->title; ?></a>
                <small>(<?php echo $post->views; ?> views)</small>
            </p>
            <!-- Blog Posts -->
            <hr>
            <img class="img-responsive" src="/cms/public/includes/images/<?php echo $post->image; ?>" alt="<?php echo $post->title; ?>">
            <hr>
            <p><?php echo $post->content; ?></p>
            <p class="text-right">
                by <a href="/cms/public/author/<?php echo $post->author; ?>"><?php echo $post->author; ?></a>. <span class="glyphicon glyphicon-time"></span> <?php echo $post->date; ?>
            </p>
            <hr>
            <!-- Pager -->
            <ul class="pager">
                <li class="previous">
                    <a href="#">&larr; Older</a>
                </li>
                <li class="next">
                    <a href="#">Newer &rarr;</a>
                </li>
            </ul>

            <!-- Blog Comments -->

            <!-- Comments Form -->
            <?php echo output_message($message); ?>
            <div class="well">
                <h4>Leave a Comment:</h4>
                 <?php if (($session->is_admin_logged_in()) || ($session->is_subscriber_logged_in())) { ?>
                <form role="form" data-toggle="validator" action="" method="post">
                    <div class="form-group has-feedback">
                        <textarea class="form-control" rows="3" name="content" placeholder="Enter your  comment" required></textarea>
                        <div class="help-block has-feedback"></div>
                    </div>
                    <button type="submit" name="create" class="btn btn-primary">Post Comment</button>
                </form>
                <?php } else { echo "<div class='alert alert-warning'>You must be logged in to post a comment.</div>"; } ?>
            </div>
            <hr>

            <!-- Posted Comments -->
            <?php
                $comments = Comment::find_by_post($id);
                foreach($comments as $comment):
            ?>
            <!-- Comment -->
            <div class="media">
                <a class="pull-left" href="#">
                    <?php
                        $author = User::find_by_column('username',$comment->author);
                    ?>
                    <img width="100" class="media-object" src="/cms/public/includes/images/<?php echo $author->image; ?>" alt="<?php echo $comment->author; ?>">
                </a>
                <div class="media-body">
                    <h4 class="media-heading">
                        <?php echo  $comment->author; ?>
                        <small><?php echo  $comment->email; ?></small>
                        <small><?php echo  $comment->date; ?></small>
                    </h4>
                    <small><?php echo  $comment->content; ?></small>
                </div>
            </div>
            <?php endforeach; ?>
            <hr>
            <?php } else { ?>
                <div class="alert alert-warning">Post not available.</div>
            <?php }  ?>
        </div>
        <?php section('sidebar.php'); ?>
    </div>
<!-- /.row -->

<hr>
<?php section('footer.php'); ?>