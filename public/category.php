<?php require_once("../includes/initialize.php"); ?>
<?php section('header.php'); ?>
<?php section('navigation.php'); ?>
<?php
if(!isset($_GET['id'])) {
    redirect_to("index.php");
} else {
    $category_id = $_GET['id'];
}
$category = Category::find_by_id($category_id);

?>
    <!-- Page Content -->
    <div class="container">
        <div class="row">
            <!-- Blog Entries Column -->
            <div class="col-md-8">
                <h1 class="page-header">
                    <?php echo $category->title; ?>
                </h1>
                <?php
                // 1. the current page number ($current_page)
                $page = !empty($_GET['page']) ? (int)$_GET['page'] : 1;
                // 2. records per page ($per_page)
                $per_page = 3;
                // 3. total record count ($total_count)
                $query = "SELECT * FROM posts ";
                $query .= "WHERE category_id = $category_id ";
                if(!$session->is_admin_logged_in()) {
                    $query .= "AND status = 'published' ";
                }
                $total_count = Post::find_by_sql($query);
                $pagination = new Pagination($page, $per_page, $total_count);
                // Instead of finding all records, just find the records
                // for this page
                $query = "SELECT * FROM posts ";
                $query .= "WHERE category_id = $category_id ";
                if(!$session->is_admin_logged_in()) {
                    $query .= "AND status = 'published' ";
                }
                $query .= "LIMIT {$per_page} ";
                $query .= "OFFSET {$pagination->offset()}";
                $posts = Post::find_by_sql($query);

                // Need to add ?page=$page to all links we want to
                // maintain the current page (or store $page in $session)

                if(!$posts) {
                    echo "<div class='alert alert-warning'>No posts yet</div>";
                }
                foreach($posts as $post):
                    ?>
                    <h2>
                        <a href="/cms/public/post/<?php echo $post->id; ?>">
                            <?php echo $post->title; ?>
                        </a>
                        <?php if($session->is_admin_logged_in()) { echo "<a class='btn btn-primary' href='admin/posts.php?edit=$post->id'><i class='glyphicon glyphicon-edit'></i></a>"; } ?>
                    </h2>
                    <hr>
                    <div class="row">
                        <div class="col-sm-6 col-md-6">
                            <img class="img-responsive" src="/cms/public/includes/images/<?php echo $post->image; ?>" alt="<?php echo $post->title; ?>">
                        </div>
                        <div class="col-sm-6 col-md-6">
                            <p><?php  the_excerpt($post->content); ?></p>
                            <a class="btn btn-primary" href="/cms/public/post/<?php echo $post->id; ?>">Read More <span class="glyphicon glyphicon-chevron-right"></span></a>
                        </div>
                    </div>
                    <p class="text-right">
                        by <a href="/cms/public/author.php?name=<?php echo $post->author; ?>"><?php echo $post->author; ?></a>. <span class="glyphicon glyphicon-time"></span> <?php echo $post->date; ?>
                    </p>
                    <hr>
                <?php endforeach; ?>
                <!-- Pager -->
                <ul class="pager">
                    <?php
                    if($pagination->total_pages() > 1) {
                        if($pagination->has_previous_page()) { ?>
                            <li>
                                <a href='category.php?id=<?php echo $category->id; ?>&page=<?php  echo $pagination->previous_page(); ?>'>
                                    &laquo; Previous
                                </a>
                            </li>
                    <?php  }

                        for($i=1; $i <= $pagination->total_pages(); $i++) {
                            if($i == $page) {
                                echo " <li>{$i}</li> ";
                            } else { ?>
                                <li>
                                    <a href='category.php?id=<?php echo $category->id; ?>&page=<?php echo $i; ?>'>
                                        <?php echo $i; ?>
                                    </a>
                                </li>
                           <?php }
                        }

                        if($pagination->has_next_page()) { ?>
                            <li>
                                <a href='category.php?id=<?php echo $category->id; ?>&page=<?php  echo $pagination->next_page(); ?>'>
                                    Next &raquo;
                                </a>
                            </li>
                    <?php } } ?>
                </ul>
            </div>
            <?php section('sidebar.php'); ?>
        </div>
    <!-- /.row -->
    <hr>
<?php section('footer.php'); ?>