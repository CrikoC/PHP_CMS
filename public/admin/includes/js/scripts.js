$(document).ready(function () {
    $('#selectAll').click(function () {
        if(this.checked) {
            $('.checkboxes').each(function () {
                this.checked = true;
            });
        } else {
            $('.checkboxes').each(function () {
                this.checked = false;
            });
        }
    });

    //PRE-LOADER
    // var loading_container = "<div id='load-screen'><div class='loading'></div></div>";
    // $('body').prepend(loading_container);
    //
    // $('#load-screen').delay(500).fadeOut(300, function () {
    //     $(this).remove();
    // });

    //AUTOLOAD USER COUNTER
    function loadOnlineUsers() {
        var url = 'http://localhost/cms/public/admin/includes/users_online_count.php';
        $.ajax({
            type: 'GET',
            url: url,
            dataType: 'text',
            success: function(data) {
                $('.users_online').html('Users online: ' + data);
            }
        })
    }

    setInterval(function () {
        loadOnlineUsers();
    },500);

    //Delete Modals

    //Category
    $('.delete_category_link').on('click', function () {
        var id = $(this).attr('data-category-id');
        var title = $(this).attr('data-category-title');
        var url = 'categories.php?delete=' + id;
        $('.modal-title').text(title);
        $('.category_confirm_delete').attr('href',url);
    });

    //Post
    $('.delete_post_link').on('click', function () {
        var id = $(this).attr('data-post-id');
        var title = $(this).attr('data-post-title');
        var url = 'posts.php?delete=' + id;
        $('.modal-title').text(title);
        $('.post_confirm_delete').attr('href',url);
    });

    //User
    $('.delete_user_link').on('click', function () {
        var id = $(this).attr('data-user-id');
        var title = $(this).attr('data-user-username');
        var url = 'users.php?delete=' + id;
        $('.modal-title').text(title);
        $('.user_confirm_delete').attr('href',url);
    });

    //Comment
    $('.delete_comment_link').on('click', function () {
        var id = $(this).attr('data-comment-id');
        var url = 'comments.php?delete=' + id;
        $('.comment_confirm_delete').attr('href',url);
    });
});








