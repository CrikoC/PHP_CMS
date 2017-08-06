<?php require_once("../../includes/initialize.php"); ?>
<?php $user = User::find_by_id($_SESSION['user_id']); ?>
<?php
$post = Post::find_by_id($_GET['edit']);

if (isset($_POST['update'])) {
    $post->id = $_GET['edit'];
    $post->title = $_POST['title'];
    $post->category_id = $_POST['category_id'];
    $post->author = $_POST['author'];
    $post->date = date('y-m-d');
    $post->content = $_POST['content'];
    $post->tags = $_POST['tags'];
    $post->status = $_POST['status'];

    if(empty($_FILES['image']['name'])) {
        $post->image = $_POST['current_image'];
    } else {
        $post->image = $_FILES['image']['name'];
        $post->image_temp = $_FILES['image']['tmp_name'];
        $post->upload_image($post->image_temp, $post->image);
    }
    if (!$post->update()) {
        die("<div class='alert alert-danger'>Updating failed " . mysqli_error($database->get_connection()) . "</div>");
    } else {
        $_SESSION['message'] = "<div class='alert alert-success'>Post Updated!</div>";
        redirect_to("posts.php");
    }
}

if(!$post) {
    die("<div class='alert alert-danger'>Error while selecting post ". mysqli_error($database->get_connection()) ."</div>");
} else { ?>
    <div class="col-xs-12 col-sm-12 col-md-6">
        <form data-toggle="validator" role="form" action="" method="post">
            <div class="panel panel-warning">
                <div class="panel-heading">
                    <h3>Edit Post</h3>
                </div>
                <div class="panel-body">
                    <div class="form-group has-feedback">
                        <label class="control-label" for="title">Title</label>
                        <input type="text" class="form-control" title="title" name="title" id="title" data-error="Add a name." placeholder="Name your post" value="<?php echo $post->title; ?>" required>
                        <div class="help-block with-errors"></div>
                    </div>
                    <div class="form-group has-feedback">
                        <label class="control-label" for="category_id">Category</label>
                        <select class="form-control" title="category_id" name="category_id">
                            <?php
                            $categories = Category::find_all();

                            foreach($categories as $category): ?>
                                <option value="<?php echo $category->id; ?>"><?php echo $category->title; ?></option>
                            <?php endforeach; ?>
                        </select>
                        <div class="help-block with-errors"></div>
                    </div>
                    <div class="form-group has-feedback">
                        <label class="control-label" for="author">Author</label>
                        <input type="text" class="form-control" title="author" name="author" id="author" data-error="Add an author." value="<?php echo $post->author; ?>" placeholder="Author name">
                        <div class="help-block with-errors"></div>
                    </div>
                    <div class="form-group has-feedback">
                        <label class="control-label" for="status">Status</label>
                        <select class="form-control" title="status" name="status">
                            <?php if($post->status == 'draft') { ?>
                                <option value="draft">Draft</option>
                                <option value="published">Published</option>
                            <?php } else { ?>
                                <option value="published">Published</option>
                                <option value="draft">Draft</option>
                            <?php } ?>
                        </select>
                        <div class="help-block with-errors"></div>
                    </div>
                    <div class="form-group has-feedback">
                        <strong>Current Image</strong><br/>
                        <input type="hidden" name="current_image" value="<?php echo $post->image; ?>">
                        <img width="100" src="../includes/images/<?php echo $post->image; ?>" alt="<?php echo $post->title; ?>" />
                        <hr>
                        <label class="control-label" for="image">Image</label>
                        <input type="file" class="form-control" title="image" name="image" id="image" data-error="Add an image.">
                        <div class="help-block with-errors"></div>
                    </div>
                    <div class="form-group has-feedback">
                        <label class="control-label" for="tags">Tags</label>
                        <input type="text" class="form-control" title="tags" name="tags" id="tags" placeholder="Separate with comma" value="<?php echo $post->tags; ?>">
                        <div class="help-block with-errors"></div>
                    </div>
                    <div class="form-group has-feedback">
                        <label class="control-label" for="content">Content</label>
                        <textarea class="form-control" title="content" name="content" rows="10"><?php echo $post->content; ?></textarea>
                        <div class="help-block with-errors"></div>
                    </div>
                    <div class="panel-footer">
                        <div class="form-group">
                            <input type="submit" class="btn btn-warning btn-block" title="update" name="update" value="Update">
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
<?php }