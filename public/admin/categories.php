<?php require_once("../../includes/initialize.php"); ?>
<?php if (!$session->is_admin_logged_in()) { redirect_to("../index.php"); } ?>

<?php admin_section('header.php'); ?>
<?php admin_section('navigation.php'); ?>
<?php
if(isset($_POST['create'])) {
    $category = new Category();

    $category->title = $_POST['title'];

    if(empty($category->title)) {
        $message = "<div class='alert alert-danger'>Enter a name for the category.</div>";
    } else {
        if(!$category->create()) {
            $_SESSION['message'] = "<div class='alert alert-danger'>Adding failed </div>";
        } else {
            $_SESSION['message'] = "<div class='alert alert-success'>Category created</div>";
            redirect_to("categories.php");
        }
    }
}

if(isset($_GET['delete'])) {

        $id = $_GET['delete'];

        $category = Category::find_by_id($id);
        if (!$category->delete()) {
            $_SESSION['message'] = "<div class='alert alert-danger'>Deleting failed</div>";
        } else {
            $_SESSION['message'] = "<div class='alert alert-success'>Category Deleted</div>";
            redirect_to("categories.php");
        }
    
}
?>
<div id="page-wrapper">
    <div class="container-fluid">
        <!-- Page Heading -->
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">
                    Categories
                </h1>
                <ol class="breadcrumb">
                    <li>
                        <i class="fa fa-dashboard"></i> <a href="index.php">Dashboard</a>
                    </li>
                    <li class="active">
                        <i class="fa fa-list"></i> <a href="categories.php">Categories</a>
                    </li>
                </ol>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-6 col-sm-6 col-md-3 col-lg-3">
                <form data-toggle="validator" role="form" action="" method="post">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <h3>Add Category</h3>
                        </div>
                        <div class="panel-body">
                            <div class="form-group has-feedback">
                                <label class="control-label" for="title">Title</label>
                                <input type="text" class="form-control" title="title" name="title" id="title" data-error="Add a name." placeholder="Name your category" required>
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
                <?php
                if(isset($_GET['edit'])) {
                    admin_section('categories/edit_category.php');
                }
                ?>
            </div>
            <div class="col-xs-6">
                <?php echo output_message($message); ?>
                <table class="table table-responsive table-hover">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Title</th>
                        <th></th>
                          </tr>
                    </thead>
                    <tbody>
                        <?php
                        $categories = Category::find_all();

                        foreach($categories as $category): ?>
                            <tr>
                                <td><?php echo  $category->id; ?></td>
                                <td><?php echo  $category->title; ?></td>
                                <td>
                                    <a href="categories.php?edit=<?php echo  $category->id; ?>" class="btn btn-warning">
                                        <span class="glyphicon glyphicon-edit"></span>
                                    </a>
                                    <button
                                        type="button"
                                        class="btn btn-danger delete_category_link"
                                        data-category-id="<?php echo $category->id; ?>"
                                        data-category-title="<?php echo $category->title; ?>"
                                        data-toggle="modal" data-target="#category_delete_modal"
                                    ><span class="glyphicon glyphicon-remove"></span>
                                    </button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!--Delete Modal-->
    <div class="modal fade" id="category_delete_modal" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete?</p>
                </div>
                <div class="modal-footer">
                    <a href="" class="btn btn-danger category_confirm_delete">Delete</a>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                </div>
            </div>
        </div>
    </div>
</div>
    <!-- /.container-fluid -->
</div>
<!-- /#page-wrapper -->
<?php admin_section('footer.php'); ?>