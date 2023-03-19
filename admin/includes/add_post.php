<?php

if(isset($_POST['create_post'])) {

    $post_title = escape($_POST['title']);
    $post_author = escape($_POST['author']);
    $post_category_id = escape($_POST['post_category_id']);
    $post_status = escape($_POST['post_status']);

    $post_image = $_FILES['image']['name'];
    $post_image_temp = $_FILES['image']['tmp_name'];

    $post_tags = $_POST['post_tags'];
    $post_content = $_POST['post_content'];
    $post_date = date('d-m-y');
 
    move_uploaded_file($post_image_temp, "../images/$post_image");

    $query = "INSERT INTO posts(post_category_id, post_title, post_author, post_date, post_image, post_content, post_tags,  post_status)";

    $query .= "VALUES($post_category_id,'$post_title','$post_author','$post_date','$post_image','$post_content','$post_tags','$post_status')";

    $create_post_query = mysqli_query($connection, $query);

    if(!$create_post_query) {
        die("QUERY FAILED" . mysqli_error($connection));
    }

    $the_post_id = mysqli_insert_id($connection);

    echo "<p class='bg-success'>Post Created. <a href='../post.php?p_id=$the_post_id'>View Post</a> or <a href='posts.php'>Edit More Posts</a></p>";
}

?>

<form action="" method="post" enctype="multipart/form-data">

    <div class="form-group">
        <label for="title">Post Title</label>
        <input type="text" class="form-control" name="title">
    </div>

    <div class="form-group">
        <label for="category">Category</label>
        <select name="post_category_id" class="form-control">
        <?php
            $query = "SELECT * FROM category";
            $stmt = mysqli_query($connection,$query);
            $str = "";
            
            while($row = mysqli_fetch_assoc($stmt)) {
                $cat_id = $row['cat_id'];
                $cat_title = $row['cat_title'];

                $str .= "<option value='$cat_id'>$cat_title</option>";
            }

            echo $str;
        ?>
        </select>
    </div>

    <div class="form-group">
        <label for="users">Users</label>
        <select name="post_category_id" class="form-control">
        <?php
            $query = "SELECT * FROM users";
            $stmt = mysqli_query($connection,$query);
            $str = "";
            
            while($row = mysqli_fetch_assoc($stmt)) {
                $user_id = $row['user_id'];
                $username = $row['username'];

                $str .= "<option value='$user_id'>$username</option>";
            }

            echo $str;
        ?>
        </select>
    </div>

    <!-- <div class="form-group">
        <label for="title">Post Author</label>
        <input type="text" class="form-control" name="author">
    </div> -->

    <div class="form-group">
        <label for="title">Post Status</label>
        <select name="post_status" id="" class="form-control">
            <option value="draft">Post Status</option>
            <option value="published">Published</option>
        </select>
    </div>


    <div class="form-group">
        <label for="title">Post Image</label>
        <input type="file" class="form-control" name="image">
    </div>

    <div class="form-group">
        <label for="title">Post Tags</label>
        <input type="text" class="form-control" name="post_tags">
    </div>

    <div class="form-group">
        <label for="summernote">Post Content</label>
        <textarea type="text" class="form-control" name="post_content" id="summernote" cols="30" rows="10"></textarea>
    </div>

    <div class="form-group">
        <input class="btn btn-primary" type="submit" name="create_post" value="Publish Post">
    </div>

</form>