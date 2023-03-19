<?php

if(isset($_GET['edit_user'])) {
    $the_user_id = $_GET['edit_user'];

    $query = "SELECT * FROM users WHERE user_id = $the_user_id";
    $select_users_query = mysqli_query($connection,$query);

    while($row = mysqli_fetch_assoc($select_users_query)) {
        $user_id = $row['user_id'];
        $username = $row['username'];
        $user_password = $row['user_password'];
        $user_firstname = $row['user_firstname'];
        $user_lastname = $row['user_lastname'];
        $user_email = $row['user_email'];
        $user_image = $row['user_image'];
        $user_role = $row['user_role'];
    }

}

if(isset($_POST['edit_user'])) {
    $user_firstname = $_POST['user_firstname'];
    $user_lastname = $_POST['user_lastname'];
    $user_role = $_POST['user_role'];
    $username = $_POST['username'];
    $user_email = $_POST['user_email'];
    
    $user_password = $_POST['user_password'];
    $user_password = password_hash($user_password, PASSWORD_DEFAULT); 

    $query = <<<SQL
        UPDATE users 
        SET user_firstname = '$user_firstname',
            user_lastname = '$user_lastname',
            user_role = '$user_role',
            username = '$username',
            user_email = '$user_email',
            user_password = '$user_password'
        WHERE user_id = '$the_user_id'
    SQL;

    $edit_user_query = mysqli_query($connection, $query);

    if(!$edit_user_query) {
        die("QUERY FAILED" . mysqli_error($connection));
    }

}
?>

<form action="" method="post" enctype="multipart/form-data">

    <div class="form-group">
        <label for="title">Firstname</label>
        <input type="text" value="<?=$user_firstname?>" class="form-control" name="user_firstname">
    </div>

    <div class="form-group">
        <label for="title">Lastname</label>
        <input type="text" value="<?=$user_lastname?>" class="form-control" name="user_lastname">
    </div>

    <div class="form-group">
        <label for="user-role">User Role</label>
        <select name="user_role" id="user-role" class="form-control">
            <option value="admin" <?= $user_role === 'admin' ? 'selected' : '' ?>>Admin</option>
            <option value="subscriber" <?= $user_role === 'subscriber' ? 'selected' : '' ?>>Subscriber</option>
        </select>
    </div>

    <div class="form-group">
        <label for="title">Username</label>
        <input type="text" value="<?=$username?>" class="form-control" name="username">
    </div>

    <div class="form-group">
        <label for="title">Email</label>
        <input type="email" value="<?=$user_email?>" class="form-control" name="user_email">
    </div>

    <div class="form-group">
        <label for="title">Password</label>
        <input type="password" value="<?=$user_password?>" class="form-control" name="user_password">
    </div>
    

    <div class="form-group">
        <input class="btn btn-primary" type="submit" name="edit_user" value="Add User">
    </div>

</form>