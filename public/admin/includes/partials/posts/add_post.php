<?php require_once("../../includes/initialize.php"); ?>
<?php $user = User::find_by_id($_SESSION['user_id']); ?>
<?php
if(isset($_POST['create'])) {
    $post = new Post();

    $post->title = $_POST['title'];
    $post->category_id = $_POST['category_id'];
    $post->author = $_POST['author'];
    $post->date = date('y-m-d');

    $post->image = $_FILES['image']['name'];
    $post->image_temp = $_FILES['image']['tmp_name'];

    $post->content = $_POST['content'];
    $post->tags = $_POST['tags'];
    $post->status = $_POST['status'];

    $post->upload_image($post->image_temp, $post->image);

    if(empty($post->title)) {
        $_SESSION['message'] = "<div class='alert alert-danger'>Enter a name for the post.</div>";
    } else {
        if(!$post->create()) {
            die("<div class='alert alert-danger'>Adding failed ". mysqli_error($database->get_connection()) ."</div>");
        } else {
            $_SESSION['message'] = "<div class='alert alert-success'>Post Added!</div>";
            redirect_to("posts.php");
        }
    }
}
?>
<div class="col-xs-12 col-sm-12 col-md-6">
    <form data-toggle="validator" role="form" action="" method="post" enctype="multipart/form-data">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3>Add Post</h3>
            </div>
            <div class="panel-body">
                <div class="form-group has-feedback">
                    <label class="control-label" for="title">Title</label>
                    <input type="text" class="form-control" title="title" name="title" id="title" data-error="Add a name." placeholder="Name your post" required>
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
                    <input type="text" class="form-control" title="author" name="author" id="author" data-error="Add an author." placeholder="Author name" value="<?php echo $user->username; ?>">
                    <div class="help-block with-errors"></div>
                </div>
                <div class="form-group has-feedback">
                    <label class="control-label" for="status">Status</label>
                    <select class="form-control" title="status" name="status">
                        <option value="draft">Draft</option>
                        <option value="published">Published</option>
                    </select>
                    <div class="help-block with-errors"></div>
                </div>
                <div class="form-group has-feedback">
                    <label class="control-label" for="image">Image</label>
                    <input type="file" class="form-control" title="image" name="image" id="image" data-error="Add an image.">
                    <div class="help-block with-errors"></div>
                </div>
                <div class="form-group has-feedback">
                    <label class="control-label" for="tags">Tags</label>
                    <input type="text" class="form-control" title="author" name="tags" id="tags" placeholder="Separate with comma">
                    <div class="help-block with-errors"></div>
                </div>
                <div class="form-group has-feedback">
                    <label class="control-label" for="content">Content</label>
                    <textarea class="form-control" title="content" name="content" rows="10"></textarea>
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