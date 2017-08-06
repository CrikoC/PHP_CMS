<?php
if(isset($_POST['checkBoxArray'])) {
    $option = $_POST['option'];
    foreach($_POST['checkBoxArray'] as $checkBoxValue):
        $post = Post::find_by_id($checkBoxValue);
        switch ($option) {
            case 'publish':
                $post->status = 'published';
                $post->update();
                break;
            case 'draft':
                $post->status = 'draft';
                $post->update();
                break;
            case 'delete':
                $post->delete();
                break;
            default:
                break;
        }
    endforeach;
}
?>
<div class="col-xs-12">
    <form action="" method="post">
        <div id="bulkOptionsContainer" class="col-xs-4">
            <select name="option" class="form-control">
                <option value="">Select option</option>
                <option value="publish">Publish</option>
                <option value="draft">Draft</option>
                <option value="delete">Delete</option>
            </select>
        </div>
        <div class="col-xs-4">
            <input type="submit" class="btn btn-default" name="apply" value="Apply" />
        </div>
        <table class="table table-responsive table-hover">
            <thead>
            <tr>
                <th><input type="checkbox" class="form-control" id="selectAll" /></th>
                <th>ID</th>
                <th>Author</th>
                <th>Title</th>
                <th>Category</th>
                <th>Status</th>
                <th>Image</th>
                <th>Tags</th>
                <th>Comments</th>
                <th>Date</th>
                <th>Views</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            <?php
            $posts = Post::find_all();

            foreach($posts as $post): ?>
                <tr>
                    <td><input type="checkbox" class="form-control checkboxes" name="checkBoxArray[]" value="<?php echo  $post->id; ?>" /></td>
                    <td><?php echo  $post->id; ?></td>
                    <td><?php echo  $post->author; ?></td>
                    <td><a href="../post.php?id=<?php echo  $post->id; ?>"><?php echo  $post->title; ?></a></td>
                    <td><?php
                        $category = Category::find_by_id($post->category_id);
                        echo $category->title;
                        ?>
                    </td>
                    <td><?php echo  $post->status; ?></td>
                    <td><img width="100" src="../includes/images/<?php echo $post->image; ?>" alt="<?php echo $post->title; ?>" /></td>
                    <td><?php echo  $post->tags; ?></td>
                    <td>
                        <a href="comments.php?post=<?php echo $post->id; ?>">
                        <?php
                            $comment_count = Comment::count_by_column('post_id',$post->id);
                            echo $comment_count;
                        ?>
                        </a>
                    </td>
                    <td><?php echo  $post->date; ?></td>
                    <td><?php echo  $post->views; ?> <a href="posts.php?reset=<?php echo  $post->id; ?>">Reset</a></td>
                    <td>
                        <a href="posts.php?edit=<?php echo  $post->id; ?>" class="btn btn-warning">
                            <span class="glyphicon glyphicon-edit"></span>
                        </a>
                        <button
                            type="button"
                            class="btn btn-danger delete_post_link"
                            data-post-id="<?php echo $post->id; ?>"
                            data-post-title="<?php echo $post->title; ?>"
                            data-toggle="modal" data-target="#post_delete_modal"
                        ><span class="glyphicon glyphicon-remove"></span>
                        </button>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </form>

    <!--Delete Modal-->
    <div class="modal fade" id="post_delete_modal" role="dialog">
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
                    <a href="" class="btn btn-danger post_confirm_delete">Delete</a>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                </div>
            </div>
        </div>
    </div>
</div>


