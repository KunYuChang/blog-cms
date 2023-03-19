<?php include_once "admin/functions.php"; ?>
<!-- 前端介面，包含網站導覽列 -->
<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <div class="container">
            <!-- 品牌和切換按鈕用於更好的行動裝置顯示 -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="/">首頁</a>
            </div>
            <!-- 導覽列中的連結 -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">

                    <!-- 從資料庫中取得所有分類 -->
                    <?php
                    $query = "SELECT * FROM category";
                    $select_all_categories_query = mysqli_query($connection,$query);

                    // 顯示分類連結
                    while($row = mysqli_fetch_assoc($select_all_categories_query)) {
                        $cat_title = $row['cat_title'];
                        $cat_id = $row['cat_id'];

                        $category_class = '';
                        $registration_class = '';

                        $pageName = basename($_SERVER['PHP_SELF']);
                        $registration = 'registration.php';

                        if(isset($_GET['category']) && $_GET['category'] == $cat_id) {
                            $category_class = 'active';
                        } else if ($pageName == $registration) {
                            $registration_class = 'active';
                        }

                        echo "<li class='$category_class'><a href='category/$cat_id'>{$cat_title}</a></li>";
                    }

                    ?>

                    <?php if(isLoggedIn()): ?>

                        <li><a href="/admin">Admin</a></li>
                        <li><a href="/includes/logout.phh">Admin</a></li>
                    
                    <?php else: ?>
                
                        <li><a href="/login.php">Login</a></li>

                    <?php endif; ?>

                    <li class="<?=$registration_class?>"><a href="registration.php">Registration</a></li>
                    <li><a href="contact.php">Contact</a></li>
                    <li><a href="forgot.php">忘記密碼</a></li>

                    <!-- 如果用戶有登入，且編輯文章的id存在，顯示編輯文章的連結 -->
                    <?php
                    if(isset($_SESSION['user_role'])) {
                        if(isset($_GET['p_id'])) {
                            $the_post_id = $_GET['p_id'];
                            echo "<li><a href='admin/posts.php?source=edit_post&p_id=$the_post_id'>Edit Post</a></li>";
                        }
                    }
                    ?>
                </ul>
            </div>
        </div>
    </nav>