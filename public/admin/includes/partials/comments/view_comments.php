<?php
if(isset($_POST['checkBoxArray'])) {
    $option = $_POST['option'];
    foreach($_POST['checkBoxArray'] as $checkBoxValue):
        $comment = Comment::find_by_id($checkBoxValue);
        switch ($option) {
            case 'approve':
                $comment->status = 'approved';
                $comment->update();
                break;
            case 'dismiss':
                $comment->status = 'dismissed';
                $comment->update();
                break;
            case 'delete':
                $comment->delete();
                break;
            default:
                break;
        }
    endforeach;
}
?>

<form action="" method="post">
    <div id="bulkOptionsContainer" class="col-xs-4">
        <select name="option" class="form-control">
            <option value="">Select option</option>
            <option value="approve">Approve</option>
            <option value="dismiss">Dismiss</option>
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
            <th>Email</th>
            <th>Content</th>
            <th>Status</th>
            <th>In Response to</th>
            <th>Date</th>
            <th></th>
            <th></th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        <?php
        $comments = Comment::find_all();
    
        foreach($comments as $comment): ?>
            <tr>
                <td><input type="checkbox" class="form-control checkboxes" name="checkBoxArray[]" value="<?php echo  $comment->id; ?>" /></td>
                <td><?php echo  $comment->id; ?></td>
                <td><?php echo  $comment->author; ?></td>
                <td><?php echo  $comment->email; ?></td>
                <td><?php echo  $comment->content; ?></td>
                <td><?php echo  $comment->status; ?></td>
                <td>
                    <?php
                    $post = Post::find_by_id($comment->post_id);
                    echo "<a href='../post.php?id=$post->id'>$post->title</a>";
                    ?>
                </td>
                <td><?php echo  $comment->date; ?></td>
                <td>
                    <?php if($comment->status == 'dismissed' || $comment->status == 'pending') { ?>
                        <a href="comments.php?approve=<?php echo $comment->id; ?>">Approve</a>
                    <?php  } else { ?>
                    <a href="comments.php?dismiss=<?php echo $comment->id; ?>">Dismiss</a></td>
                <?php } ?>
                <td>
                    <button
                        type="button"
                        class="btn btn-danger delete_comment_link"
                        data-comment-id="<?php echo $comment->id; ?>"
                        data-toggle="modal" data-target="#comment_delete_modal"
                    ><span class="glyphicon glyphicon-remove"></span>
                    </button>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</form>

<!--Delete Modal-->
<div class="modal fade" id="comment_delete_modal" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Delete Comment</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete?</p>
            </div>
            <div class="modal-footer">
                <a href="" class="btn btn-danger comment_confirm_delete">Delete</a>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>
