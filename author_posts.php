<?php include 'includes/db.php';?>
<?php include 'includes/header.php';?>

<!-- Navigation -->
<?php include 'includes/nav.php';?>

    <!-- Page Content -->
    <div class="container">

        <div class="row">

            <!-- Blog Post Content Column -->
            <div class="col-lg-8">

            <?php
                if(isset($_GET['p_id'])) {
                    $the_post_id = $_GET['p_id'];
                    $the_post_author = $_GET['author'];
                }

                $query = "SELECT * FROM posts WHERE post_author = '$the_post_author'";
                $select_posts = mysqli_query($connection,$query);
                
                while($row = mysqli_fetch_assoc($select_posts)) {
                    $post_title = $row['post_title'];
                    $post_author = $row['post_author'];
                    $post_date = $row['post_date'];
                    $post_image = $row['post_image'];
                    $post_content = $row['post_content'];

                    echo <<<STR
                        <h1>$post_title</h1>
                        <p class="lead">by <a href="author_posts.php?author=$post_author&p_id=$the_post_id">$post_author</a></p>
                        <hr>   
                        <p><span class="glyphicon glyphicon-time"></span> Posted on $post_date</p>
                        <hr>     
                        <img class="img-responsive" src="images/$post_image" alt="">
                        <hr>
                        <p class="lead">$post_content</p>
                        <hr>    
                    STR;
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
