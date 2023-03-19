<?php 
    include 'includes/db.php';
    include 'includes/header.php';
    include 'includes/nav.php';
?>
<div class="container">
    <div class="row">
        <div class="col-md-8">
            <?php
            if(!isset($_GET['category'])) {
                header("Location: index.php");
                exit;
            }

            
            $post_category_id = $_GET['category'];
            $query = "SELECT * FROM posts WHERE post_category_id = '$post_category_id' AND post_status = 'published'";
            $select_all_posts_query = mysqli_query($connection, $query);

            if(mysqli_num_rows($select_all_posts_query) < 1) {
                echo "<h1 class='text-center'>No posts available</h1>";
            } else {
                foreach($select_all_posts_query as $row) {
                    $post_id = $row['post_id'];
                    $post_title = $row['post_title'];
                    $post_author = $row['post_author'];
                    $post_date = $row['post_date'];
                    $post_image = $row['post_image'];
                    $post_content = $row['post_content'];
                    echo "<h1 class='page-header'>
                            Page Heading <small>Secondary Text</small>
                        </h1>

                        <h2>
                            <a href='post.php?p_id=$post_id'>$post_title</a>
                        </h2>
                        <p class='lead'>
                            by <a href='index.php'>$post_author</a>
                        </p>
                        <p><span class='glyphicon glyphicon-time'></span>$post_date</p>
                        <hr>
                        <img class='img-responsive' src='images/$post_image' alt=''>
                        <hr>
                        <p>$post_content</p>
                        <a class='btn btn-primary' href='#'>Read More <span class='glyphicon glyphicon-chevron-right'></span></a>
                        <hr>";
                }
            }
            ?>
        </div>

<?php include 'includes/sidebar.php';?>
</div>