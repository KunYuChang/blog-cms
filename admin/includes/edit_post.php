<?php

if(isset($_GET['p_id'])) {
    $the_post_id = $_GET['p_id'];
}

$query = "SELECT * FROM posts WHERE post_id = $the_post_id";
$select_posts_by_id = mysqli_query($connection,$query);

while($row = mysqli_fetch_assoc($select_posts_by_id)) {
    $post_id = $row['post_id'];
    $post_author = $row['post_author'];
    $post_title = $row['post_title'];
    $post_category_id = $row['post_category_id'];
    $post_status = $row['post_status'];
    $post_image = $row['post_image'];
    $post_content = $row['post_content'];
    $post_tags = $row['post_tags'];
    $post_comment_count = $row['post_comment_count'];
    $post_date = $row['post_date'];

}

if(isset($_POST['update_post'])) {

    $post_title = $_POST['title'];
    $post_author = $_POST['author'];
    $post_category_id = $_POST['post_category'];
    $post_status = $_POST['post_status'];
    $post_image = $_FILES['image']['name'];
    $post_image_temp = $_FILES['image']['tmp_name'];
    $post_tags = $_POST['post_tags'];
    $post_content = $_POST['post_content'];

    move_uploaded_file($post_image_temp, "../images/$post_image");

    // 處理沒有更改圖片的情況
    if(empty($post_image)) {
        $query = "SELECT * FROM posts WHERE post_id = $the_post_id";
        $select_image = mysqli_query($connection,$query);

        while($row = mysqli_fetch_array($select_image)) {
            $post_image = $row['post_image'];
        }
    }

    $query = <<<SQL
        UPDATE posts 
        SET post_title = '$post_title',
            post_category_id = '$post_category_id',
            post_date = now(),
            post_status = '$post_status',
            post_tags = '$post_tags',
            post_content = '$post_content', 
            post_image = '$post_image'
        WHERE post_id = '$the_post_id'
    SQL;

    $update_post = mysqli_query($connection, $query);

    if(!$update_post) {
        die("QUERY FAILED" . mysqli_error($connection));
    }

    echo "<p class='bg-success'>Post Updated. <a href='../post.php?p_id=$the_post_id'>View Post</a> or <a href='posts.php'>Edit More Posts</a></p>";

}

?>

<form action="" method="post" enctype="multipart/form-data">

    <div class="form-group">
        <label for="title">Post Title</label>
        <input value="<?=$post_title?>" type="text" class="form-control" name="title">
    </div>

    <div class="form-group">
        <label for="title">Post Category Id</label>
        <select name="post_category" id="post_category" class="form-control">

        <?php

        $query = "SELECT * FROM category";
        $select_categories = mysqli_query($connection,$query);

        while($row = mysqli_fetch_assoc($select_categories)) {
            $cat_id = $row['cat_id'];
            $cat_title = $row['cat_title'];

            if ($cat_id == $post_category_id) {
                echo "<option value='$cat_id' selected>$cat_title</option>";
            } else {
                echo "<option value='$cat_id'>$cat_title</option>";
            }
        }

        ?>
        </select>

    </div>

    <div class="form-group">
        <label for="title">Post Author</label>
        <input value="<?=$post_author?>" type="text" class="form-control" name="author">
    </div>

    <div class="form-group">
        <label for="title">Post Status</label>
        <select name="post_status" id="post_category" class="form-control">
            <option value="draft" <?= $post_status === 'draft' ? 'selected':'' ?> >Draft</option>
            <option value="published" <?= $post_status === 'published' ? 'selected':'' ?> >Publish</option>
        </select>
    </div>


    <img width='100' src='../images/<?=$post_image?>'>


    <div class="form-group">
        <label for="title">Post Image</label>
        <input value="<?=$post_image?>" type="file" class="form-control" name="image">
    </div>

    <div class="form-group">
        <label for="title">Post Tags</label>
        <input value="<?=$post_tags?>" type="text" class="form-control" name="post_tags">
    </div>

    <div class="form-group">
        <label for="summernote">Post Content</label>
        <textarea type="text" class="form-control" name="post_content" id="summernote" cols="30" rows="10"><?= str_replace('\r\n','</br>',$post_content)?></textarea>
    </div>

    <div class="form-group">
        <input class="btn btn-primary" type="submit" name="update_post" value="Publish Post">
    </div>

</form>