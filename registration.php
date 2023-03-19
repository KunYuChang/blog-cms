<?php  include "includes/db.php"; ?>
<?php  include "includes/header.php"; ?>
<?php  include "admin/functions.php"; ?>

<?php
$message = "";

if(isset($_POST['resgister'])) {

    $username  = trim($_POST['username']);
    $email     = trim($_POST['email']);
    $password  = trim($_POST['password']);

    // 宣告一個 $error 陣列，用於儲存錯誤訊息
    $error = [
        'username' => '',
        'email'    => '',
        'password' => ''
    ];

    if(mb_strlen($username, 'UTF-8') < 4) {
        $error['username'] = '使用者名稱需要更長';
    }

    if($username == '') {
        $error['username'] = '使用者名稱不能為空';
    }

    if(username_exists($username)) {
        $error['username'] = '該使用者名稱已經存在，請選擇其他名稱';
    }

    if($email == '') {
        $error['email'] = '電子郵件不能為空';
    }

    if(username_exists($email)) {
        $error['email'] = '該電子郵件已經存在，<a href="index.php">請登入</a>';
    }

    if($password == '') {
        $error['password'] = '密碼不能為空';
    }

    // 移除 $error 陣列中值為空的元素
    foreach($error as $key => $value) {
        if(empty($value)) {
            unset($error[$key]);
        }
    }

    // 如果 $error 陣列為空，則註冊使用者
    if(empty($error)) {
        register_user($username, $email, $password);
        login_user($username, $password);
    }
}

?>

    <!-- Navigation -->
    
    <?php  include "includes/nav.php"; ?>
    
 
    <!-- Page Content -->
    <div class="container">
    
<!-- 整個表單 -->
<section id="login">
    <!-- 包含表單的容器 -->
    <div class="container">
        <!-- 行 -->
        <div class="row">
            <!-- 以小螢幕裝置為基礎的 6 格，並向右偏移 3 格 -->
            <div class="col-xs-6 col-xs-offset-3">
                <!-- 表單的容器 -->
                <div class="form-wrap">
                    <!-- 標題 -->
                    <h1>Register</h1>
                    <!-- 表單 -->
                    <form role="form" action="registration.php" method="post" id="login-form" autocomplete="off">
                        <!-- 使用者名稱輸入框 -->
                        <div class="form-group">
                            <label for="username" class="sr-only">username</label>
                            <input type="text" name="username" id="username" class="form-control"  placeholder="Enter Desired Username">
                            <p><?=$error['username']??''?></p>
                        </div>
                        <!-- 電子郵件輸入框 -->
                        <div class="form-group">
                            <label for="email" class="sr-only">Email</label>
                            <input type="email" name="email" id="email" class="form-control" placeholder="somebody@example.com">
                            <p><?=$error['email']??''?></p>
                        </div>
                        <!-- 密碼輸入框 -->
                        <div class="form-group">
                            <label for="password" class="sr-only">Password</label>
                            <input type="password" name="password" id="key" class="form-control" placeholder="Password">
                            <p><?=$error['password']??''?></p>
                        </div>
                        <!-- 提交按鈕 -->
                        <button type="submit" name="resgister" id="btn-login" class="btn btn-custom btn-lg btn-block">Register</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>


        <hr>



<?php include "includes/footer.php";?>
