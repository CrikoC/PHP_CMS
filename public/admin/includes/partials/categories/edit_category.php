<?php

$category = Category::find_by_id($_GET['edit']);

if (isset($_POST['update'])) {
    $category->title = $_POST['title'];

    if(empty($category->title)) {
        echo "<div class='alert alert-danger'>Enter a name for the category.</div>";
    } else {
        if(!$category->update($id)) {
            $_SESSION['message'] = die("<div class='alert alert-danger'>Adding failed ". mysqli_error($database->get_connection()) ."</div>");
        } else {
            $_SESSION['message'] = "<div class='alert alert-success'>Category updated</div>";
            redirect_to("categories.php");
        }
    }
}

if(!$category) {
die("<div class='alert alert-danger'>Error while selecting category ". mysqli_error($database->get_connection()) ."</div>");
} else { ?>
<form data-toggle="validator" role="form" action="" method="post">
    <div class="panel panel-warning">
        <div class="panel-heading">
            <h3>Edit Category</h3>
        </div>
        <div class="panel-body">
            <div class="form-group has-feedback">
                <label class="control-label" for="title">Title</label>
                <input type="text" class="form-control" title="title" name="title" id="title" data-error="Add a name." placeholder="Name your category" value="<?php echo $category->title; ?>" required>
                <div class="help-block with-errors"></div>
            </div>
        </div>
        <div class="panel-footer">
            <div class="form-group">
                <input type="submit" class="btn btn-warning btn-block" title="update" name="update" value="Update">
            </div>
        </div>
    </div>
</form>
<?php } ?>