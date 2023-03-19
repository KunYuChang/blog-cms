<?php

function redirect($location) {
    header("Location:" . $location);
    exit;
}

function escape($string) {
    global $connection;

    return mysqli_real_escape_string($connection, trim($string));
}

function ifItIsMethod($method=null) {
    if($_SERVER['REQUEST_METHOD'] == strtoupper($method)) {
        return true;
    }

    return false;
}

function isLoggedIn() {
    if(isset($_SESSION['user_role']))  {
        return true;
    }

    return false;
}

function checkIfUserIsLoggedInAndRedirect($redirectLocation=null) {
    if(isLoggedIn()) {
        redirect($redirectLocation);
    }
}

// Track Users Online
function users_online() {

    global $connection;

    if(!isset($_GET['onlineusers'])) {
        return;
    }

    if(!$connection) {
        session_start();
        include("../includes/db.php");
    }

    // 取得目前使用者的 session ID
    $session = session_id();

    // 取得目前時間的 timestamp
    $time = time();

    // 設定閒置多久時間 (秒) 之後視為離線
    $time_out_in_seconds = 3;

    // 計算 $time_out，表示多久之前的時間就視為離線
    $time_out = $time - $time_out_in_seconds;

    // 執行 SQL 查詢，檢查目前使用者的 session 是否已存在於 users_online 資料表中
    $query = "SELECT * FROM users_online WHERE session = '$session'";
    $send_query = mysqli_query($connection, $query);
    $count = mysqli_num_rows($send_query);

    // 如果目前使用者的 session 不存在於資料表中，就新增一筆資料
    if($count == null) {
        mysqli_query($connection, "INSERT INTO users_online(session, time) VALUES('$session','$time')");
    } 
    // 如果目前使用者的 session 已存在於資料表中，就更新該筆資料的時間欄位
    else {
        mysqli_query($connection, "UPDATE users_online SET time = '$time' WHERE session = '$session'");
    }

    // 執行 SQL 查詢，找出所有時間晚於 $time_out 的資料，代表這些使用者被視為在線上。
    $users_online_query =  mysqli_query($connection, "SELECT * FROM users_online WHERE time > '$time_out'");
    $result = mysqli_num_rows($users_online_query);

    echo $result;
}

users_online();

function insert_categories() {

    global $connection;

    if(isset($_POST['submit'])) {
        $cat_title = $_POST['cat_title'];
    
        if(empty($cat_title)) {
    
            echo 'This field should not be empty';
    
        } else {
    
            $query = "INSERT INTO category(cat_title)";
            $query .= "VALUE('{$cat_title}')";
    
            $create_category_query = mysqli_query($connection, $query);
    
            if(!$create_category_query) {
                die('QUERY FAILED' . mysqli_error($connection));
            }
    
        }
    }
}

function findAllCategories() {

    global $connection;

    $query = "SELECT * FROM category";
    $select_categories = mysqli_query($connection,$query);

    while($row = mysqli_fetch_assoc($select_categories)) {
        $cat_id = $row['cat_id'];
        $cat_title = $row['cat_title'];

        echo "<tr>";
        echo "<td>{$cat_id}</td>";
        echo "<td>{$cat_title}</td>";
        echo "<td><a href='categories.php?delete={$cat_id}'>Delete</a></td>";
        echo "<td><a href='categories.php?edit={$cat_id}'>Edit</a></td>";
        echo "</tr>";
    }
}

function deleteCategories() {

    global $connection;

    // DELETE QUERY
    if(isset($_GET['delete'])) {
        $the_cat_id = $_GET['delete'];
        $query = "DELETE FROM category WHERE cat_id= {$the_cat_id}";
        $delete_query = mysqli_query($connection,$query);
        header("Location: categories.php");
    }
}

/**
 * 此函式可取得指定資料表中的資料筆數。
 * 
 * @param string $table - 欲取得資料筆數的資料表名稱。
 * @return int - 指定資料表中的資料筆數。
 */
function recordCount($table) {
    // 存取全域的資料庫連線變數。
    global $connection;
    
    // 建立 SQL 查詢以從指定資料表中擷取所有資料。
    $query = "SELECT * FROM " . $table;
    
    // 執行查詢並將結果存入 statement 物件中。
    $stmt = mysqli_query($connection, $query);
    
    // 回傳 statement 物件回傳的資料筆數，即為指定資料表中的資料筆數。
    return mysqli_num_rows($stmt);
}

function is_admin($username = '') {
    global $connection;

    $query = "SELECT user_role FROM users WHERE username = '$username'";
    $result = mysqli_query($connection, $query);
    $row = mysqli_fetch_array($result);

    if($row['user_role'] == 'admin') {
        return true;
    } else {
        return false;
    }
}

function username_exists($username) {
    global $connection;

    $query = "SELECT username FROM users WHERE username = '$username'";
    $result = mysqli_query($connection, $query);

    if(mysqli_num_rows($result) >0) {
        return true;
    } else {
        return false;
    }
}

function email_exists($email) {
    global $connection;

    $query = "SELECT user_email FROM users WHERE user_email = '$email'";
    $result = mysqli_query($connection, $query);

    if(mysqli_num_rows($result) >0) {
        return true;
    } else {
        return false;
    }
}

function confirmQuery($query) {
    global $connection;

    if(!$query) {
        die("查詢失敗" . mysqli_error($connection) . ' ' . mysqli_errno($connection));
    }
}

function register_user($username, $email, $password) {
    global $connection;

    // 提取表單值並進行跳脫處理
    $username = mysqli_real_escape_string($connection, $username);
    $email = mysqli_real_escape_string($connection, $email);
    $password = mysqli_real_escape_string($connection, $password);

    // 將密碼進行雜湊處理
    $password = password_hash($password, PASSWORD_DEFAULT);    

    // 執行註冊用戶的查詢語句
    $query = "INSERT INTO users (username, user_email, user_password, user_role)
                VALUES('$username','$email','$password','subscriber')";
    $register_user_query = mysqli_query($connection, $query);

    confirmQuery($register_user_query);

    $message ="您的註冊已經提交";    
}

function login_user($username, $password) {
    global $connection;

    $username = trim(mysqli_real_escape_string($connection, $username));
    $password = trim(mysqli_real_escape_string($connection, $password));

    $query = "SELECT * FROM users WHERE username = '$username'";
    $select_user_query = mysqli_query($connection, $query);

    if(!$select_user_query) {
        die("QUERY FAILED". mysqli_error($connection));
    }

    while($row = mysqli_fetch_array($select_user_query)) {
        $db_user_id = $row['user_id'];
        $db_username = $row['username'];
        $db_password = $row['user_password'];
        $db_user_firstname = $row['user_id'];
        $db_user_lastname = $row['user_id'];
        $db_user_role = $row['user_role'];
    }


    if (password_verify($password, $db_password)) {
        
        $_SESSION['username'] = $db_username;
        $_SESSION['firstname'] = $db_user_firstname;
        $_SESSION['lastname'] = $db_user_lastname;
        $_SESSION['user_role'] = $db_user_role;

        redirect("/admin");      
    } else {
        return false;
    }
}

