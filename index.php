<?php include 'includes/db.php';?>
<?php include 'includes/header.php';?>

<!-- Navigation -->
<?php include 'includes/nav.php';?>

<!-- Page Content -->
<div class="container">

<div class="row">

    <!-- Blog Entries Column -->
    <div class="col-md-8">

        <!-- while -->
        <?php

        // 設定每頁顯示的筆數
        $limit = 5;

        if(isset($_GET['page'])) {
            $page = $_GET['page'];
        } else {
            $page = "";
        }

        // 取得目前頁數
        if($page == "" || $page == 1) {
            $page_1 = 0;
        } else {
            $page_1 = ($page * $limit) - $limit;
        }

        // 計算總筆數
        $post_query_count = "SELECT * FROM posts WHERE post_status = 'published'";
        $find_count = mysqli_query($connection,$post_query_count);
        $count = mysqli_num_rows($find_count);
        $count = ceil($count / $limit);

        // 取得分頁資料
        // $query = "SELECT * FROM posts WHERE post_status =  'published' LIMIT $page_1, 5";
        $query = "SELECT * FROM posts LIMIT $page_1, $limit";
        $select_all_posts_query = mysqli_query($connection,$query);

        while($row = mysqli_fetch_assoc($select_all_posts_query)) {
            $post_id = $row['post_id'];
            $post_title = $row['post_title'];
            $post_author = $row['post_author'];
            $post_date = $row['post_date'];
            $post_image = $row['post_image'];
            
            // 首頁的文章內容只顯示前100字元即可
            $post_content = substr($row['post_content'],0,100);
        ?>

        <h1 class="page-header">
            Page Heading
            <small>Secondary Text</small>
        </h1>

        <h2>
            <a href="post/<?=$post_id?>"> <?= $post_title?> </a>
        </h2>
        <p class="lead">
            by <a href="author_posts.php?author=<?=$post_author?>&p_id=<?= $post_id?>"><?= $post_author?></a>
        </p>
        <p><span class="glyphicon glyphicon-time"></span><?= $post_date?></p>
        <hr>
        <a href="post.php?p_id=<?=$post_id?>">
            <img class="img-responsive" src="images/<?= $post_image?>" alt="">
        </a>
        <hr>
        <p><?= $post_content?></p>

        <hr>  

        <?php 
            }
        ?>
        <!-- ./while -->
        
    </div>

    <!-- Blog Sidebar Widgets Column -->
    <?php include 'includes/sidebar.php';?>

</div>
<!-- /.row -->

<hr>

<ul class="pager">
    <?php
        // 顯示分頁連結
        for($i=1;$i<=$count;$i++) {

            if(empty($page)) {
                $page = 1;
            }

            if($i == $page) {
                echo "<li><a class='active_link' href='index.php?page=$i'>$i</a></li>";
            } else {
                echo "<li><a href='index.php?page=$i'>$i</a></li>";
            }
        }
    ?>
</ul>

<?php include 'includes/footer.php';?>
