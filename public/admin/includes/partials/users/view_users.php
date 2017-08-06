<div class="col-xs-12">
    <?php
    if(isset($_POST['checkBoxArray'])) {
        $option = $_POST['option'];
        foreach($_POST['checkBoxArray'] as $checkBoxValue):
            $user = User::find_by_id($checkBoxValue);
            if($session->is_admin_logged_in()) {
                switch ($option) {
                    case 'approve':
                        $user->status = 'approved';
                        $user->update();
                        break;
                    case 'dismiss':
                        $user->status = 'dismissed';
                        $user->update();
                        break;
                    case 'delete':
                        $user->delete();
                        break;
                    default:
                        break;
                }
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
                <th>Username</th>
                <th>Image</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Email</th>
                <th>Role</th>
                <th>Status</th>
                <th></th>
                <th></th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            <?php
            $users = User::find_all();

            foreach($users as $user): ?>
                <tr>
                    <td><input type="checkbox" class="form-control checkboxes" name="checkBoxArray[]" value="<?php echo $user->id; ?>" /></td>
                    <td><?php echo  $user->id; ?></td>
                    <td><?php echo  $user->username; ?></td>
                    <td><img width="100" src="../includes/images/<?php echo $user->image; ?>" alt="<?php echo $user->username; ?>" /></td>
                    <td><?php echo  $user->first_name; ?></td>
                    <td><?php echo  $user->last_name; ?></td>
                    <td><?php echo  $user->email; ?></td>
                    <td><?php echo  $user->role; ?></td>
                    <td><?php echo  $user->status; ?></td>
                    <td>
                        <?php if($user->status == 'dismissed' || $user->status == 'pending') { ?>
                            <a href="users.php?approve=<?php echo $user->id; ?>">Approve</a>
                        <?php  } else { ?>
                        <a href="users.php?dismiss=<?php echo $user->id; ?>">Dismiss</a></td>
                    <?php } ?>
                    </td>
                    <td>
                        <a href="users.php?edit=<?php echo  $user->id; ?>" class="btn btn-warning">
                            <span class="glyphicon glyphicon-edit"></span>
                        </a>
                        <button
                            type="button"
                            class="btn btn-danger delete_user_link"
                            data-user-id="<?php echo $user->id; ?>"
                            data-user-username="<?php echo $user->username; ?>"
                            data-toggle="modal" data-target="#user_delete_modal"
                        ><span class="glyphicon glyphicon-remove"></span>
                        </button>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </form>
</div>

<!--Delete Modal-->
<div class="modal fade" id="user_delete_modal" role="dialog">
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
                <a href="" class="btn btn-danger user_confirm_delete">Delete</a>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>
