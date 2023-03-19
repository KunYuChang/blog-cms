<?php include 'includes/db.php';?>
<?php include 'includes/header.php';?>

<!-- Navigation -->
<?php include 'includes/nav.php';?>

<?php

    // 不要向訪問者顯示草稿，而是向管理員顯示所有內容。
    if(isset($_SESSION['user_role']) && $_SESSION['user_role'] == 'admin') {
        $query = "SELECT * FROM posts WHERE post_id = '$the_post_id'";
    } else {
        $query = "SELECT * FROM posts WHERE post_id = '$the_post_id' AND post_status = 'published'";
    }
    
    $select_posts = mysqli_query($connection,$query);
    
    while($row = mysqli_fetch_assoc($select_posts)) {
        $post_title = $row['post_title'];
        $post_author = $row['post_author'];
        $post_date = $row['post_date'];
        $post_image = $row['post_image'];
        $post_content = $row['post_content'];
    }
?>

    <!-- Page Content -->
    <div class="container">

        <div class="row">

            <!-- Blog Post Content Column -->
            <div class="col-lg-8">

                <!-- Blog Post -->

                <!-- Title -->
                <h1><?=$post_title?></h1>

                <!-- Author -->
                <p class="lead">
                    by <a href="#"><?=$post_author?></a>
                </p>

                <hr>

                <!-- Date/Time -->
                <p><span class="glyphicon glyphicon-time"></span> Posted on <?=$post_date?></p>

                <hr>

                <!-- Preview Image -->
                <img class="img-responsive" src="/images/<?=$post_image?>" alt="">

                <hr>

                <!-- Post Content -->
                <p class="lead"><?=$post_content?></p>


                <hr>

                <!-- Blog Comments -->
                <?php
                    if(isset($_POST['create_comment'])) {
                        $the_post_id = $_GET['p_id'];
                        $comment_author = $_POST['comment_author'];
                        $comment_email = $_POST['comment_email'];
                        $comment_content = $_POST['comment_content'];

                        // 檢查資料是否為空
                        if(!empty($comment_author) && !empty($comment_email) && !empty($comment_content)) {
                            
                            $create_comment_query = "INSERT INTO comments (comment_post_id, comment_author, comment_email, comment_content, comment_status, comment_date)";
                            $create_comment_query .= "VALUES ($the_post_id, '{$comment_author}', '$comment_email', '$comment_content', 'approved', now())";
                            
                            $create_comment_query = mysqli_query($connection, $create_comment_query);
    
                            if(!$create_comment_query) {
                                die('QUERY FAILED' . mysqli_error($connection));
                            }
    
                            // $update_comment_query = "UPDATE posts 
                            //                          SET post_comment_count = post_comment_count + 1
                            //                          WHERE post_id = '$the_post_id'";
                            // $update_comment_query = mysqli_query($connection, $update_comment_query);
                        
                            header("Location: post.php?p_id=$the_post_id");

                        } else {
                            echo "<script>alert('Fields cannot be empty')</script>";
                        }
                    }                
                ?>

                <!-- Comments Form -->
                <div class="well">
                    <h4>Leave a Comment:</h4>
                    <form role="form" method="POST">
                        <div class="form-group">
                            <label for="author">Author</label>
                            <input type="text" class="form-control" name="comment_author">
                        </div>

                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="text" class="form-control" name="comment_email">
                        </div>

                        <div class="form-group">
                        <label for="comment">Your Comment</label>
                            <textarea name="comment_content" class="form-control" rows="3"></textarea>
                        </div>

                        <button type="submit" name="create_comment" class="btn btn-primary">Submit</button>
                    </form>
                </div>

                <hr>

                <!-- Posted Comments -->

                <?php
                $the_post_id = $_GET['p_id'];

                $query = "SELECT * 
                          FROM comments 
                          WHERE comment_post_id = '{$the_post_id}'
                          AND comment_status = 'approved'
                          ORDER BY comment_id DESC";
                
                $select_comment_query = mysqli_query($connection, $query);
                if(!$select_comment_query) {
                    die('Query Failed' . mysqli_error($connection));
                }
                while($row = mysqli_fetch_array($select_comment_query)) {
                    $comment_date = $row['comment_date'];
                    $comment_content = $row['comment_content'];
                    $comment_author = $row['comment_author'];

                    // Comment
                    echo <<<HTML
                    <div class="media">
    
    
                        <a class="pull-left" href="#">
                            <img class="media-object" src="http://placehold.it/64x64" alt="">
                        </a>
                        <div class="media-body">
                            <h4 class="media-heading">$comment_author
                                <small>$comment_date</small>
                            </h4>
                            $comment_content
                        </div>
                    </div>
                    HTML;
                }              
                
                
                ?>


            </div>

            <!-- Blog Sidebar Widgets Column -->
            <?php include 'includes/sidebar.php';?>

        </div>
        <!-- /.row -->

        <hr>

        <!-- Footer -->
        <footer>
            <div class="row">
                <div class="col-lg-12">
                    <p>Copyright &copy; Your Website 2014</p>
                </div>
            </div>
            <!-- /.row -->
        </footer>

    </div>
    <!-- /.container -->

    <!-- jQuery -->
    <script src="js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>

</body>

</html>
