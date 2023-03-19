<?php
    checkIfUserIsLoggedInAndRedirect('/admin');

    if(ifItIsMethod('post')) {

        if( !empty($_POST['username']) && !empty($_POST['password']) ) {
            login_user($_POST['username'], $_POST['password']);
        } else {
            redirect('/index.php');
        }
    }
?>

<div class="col-md-4">

<!-- 取得POST -->
<?php

if(isset($_POST['submit'])) {
    echo $_POST['search'];

    $query = "SELECT * FROM posts WHERE post_tags LIKE '%$search%'";
    $search_query = mysqli_query($connection, $query);

    if(!$search_query) {
        die("QUERY FAILED". mysqli_error($connection));
    }

    $count = mysqli_num_rows($search_query);

    if($count == 0) {
        echo "<h1>NO RESULT</h1>";
    } else {
        echo "SOME RESULT";
    }
}

?>


<!-- Blog Search Well -->
<div class="well">
    <h4>Blog Search</h4>
    <form method="post">
        <div class="input-group">
            <input name="search" type="text" class="form-control">
            <span class="input-group-btn">
                <button name="submit" class="btn btn-default" type="submit">
                    <span class="glyphicon glyphicon-search"></span>
                </button>
            </span>
        </div>
    </form>
    <!-- /.input-group -->
</div>

<!-- 登入 -->
<div class="well">

    <!-- 登入中 -->
    <?php if(isset($_SESSION['user_role'])): ?>

        <h4>Logged in as <?= $_SESSION['username']?></h4>

    <!-- 尚未登入 -->
    <?php else: ?>
    
        <h4>Login</h4>
        <form action="login.php" method="post">
            <div class="form-group">
                <input name="username" type="text" class="form-control" placeholder="Enter Username">
            </div>
            
            <div class="input-group">            
                <input name="password" type="password" class="form-control" placeholder="Enter Password">
                <span class="input-group-btn">
                <button class="btn btn-primary" name="login" type="submit">登入</button>  
                </span>
            </div>
            
            <div class="form-group">
                <a href="frogot.">Forgot Password</a>
            </div>
        </form>
    
    <?php endif; ?>


</div>

<?php

$query = "SELECT * FROM category LIMIT 3";
$select_categories_query = mysqli_query($connection,$query);
?>

<!-- Blog Categories Well -->
<div class="well">
    <h4>Blog Categories</h4>
    <div class="row">
        <div class="col-lg-12">
            <ul class="list-unstyled">
            <?php
                while($row = mysqli_fetch_assoc($select_categories_query)) {
                    $cat_title = $row['cat_title'];
                    $cat_id = $row['cat_id'];

                    echo "<li><a href='category.php?category=$cat_id'>$cat_title</a></li>";
                }

            ?>
            </ul>
        </div>
    </div>
    <!-- /.row -->
</div>

<!-- Side Widget Well -->
<?php include 'includes/widget.php';?>

</div>