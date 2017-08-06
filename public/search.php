<?php require_once("../includes/initialize.php"); ?>
<?php section('header.php'); ?>
<?php section('navigation.php'); ?>
    <!-- Page Content -->
    <div class="container">
    <div class="row">
        <!-- Blog Entries Column -->
        <div class="col-md-8">
            <h1 class="page-header">
                Search Results
                <small>from all posts</small>
            </h1>
            <!-- Blog Posts -->
            <?php
                if(isset($_POST['submit_search'])) {
                    $search_input = $_POST['search_input'];

                    $query = "SELECT * FROM posts ";
                    $query .= "WHERE tags LIKE '%$search_input%'";

                    $search_results = Post::find_by_sql($query);

                    if($search_results) {
                        $count = Post::count_by_input($search_input);
                        echo $count;
                        if($count == 0) {
                            echo "<br/><div class='alert alert-warning'>No results found.</div>";
                        } else {
                            foreach($search_results as $search_result):
                            ?>
                            <h2>
                                <a href="#">
                                    <?php echo $search_result->title; ?>
                                </a>
                            </h2>
                            <p class="lead">
                                by <a href="index.php"><?php echo $search_result->author; ?></a>
                            </p>
                            <p><span class="glyphicon glyphicon-time"></span> <?php echo $search_result->date; ?></p>
                            <hr>
                            <img class="img-responsive" src="images/<?php echo $search_result->image; ?>" alt="<?php echo $search_result->title; ?>">
                            <hr>
                            <p><?php echo $search_result->content; ?></p>
                            <a class="btn btn-primary" href="#">Read More <span class="glyphicon glyphicon-chevron-right"></span></a>
            
                            <hr>
                        <?php endforeach;
                        }
                    }
                }
            ?>

            <!-- Pager -->
            <ul class="pager">
                <li class="previous">
                    <a href="#">&larr; Older</a>
                </li>
                <li class="next">
                    <a href="#">Newer &rarr;</a>
                </li>
            </ul>
        </div>
        <?php section('navigation.php'); ?>
    </div>
    <!-- /.row -->

    <hr>
<?php section('footer.php'); ?>