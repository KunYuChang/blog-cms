<?php

// 將 PHPMailer 類別匯入全域命名空間
// 這些必須放在程式碼頂部，而不是函式內部
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// 載入 Composer 的自動載入器
require 'vendor/autoload.php';
include "includes/db.php"; 
include "classes/Config.php";
include "includes/header.php";
include "includes/nav.php";


if (isset($_POST['email'])) {
    $reset_email = $_POST['email'];
    $token = generate_random_token(50);

    $is_update = update_token($connection, $reset_email, $token);
    ($is_update ? send_email($reset_email,$token) : null);      
}

/************************************************************
 * FUNCTIONS
 ***********************************************************/

function generate_random_token($length) {
    return bin2hex(openssl_random_pseudo_bytes($length));
}

function update_token($connection, $reset_email, $token) {
    $flag = false;    
    if (email_exists($reset_email)) {
        if ($stmt = mysqli_prepare($connection, "UPDATE users SET token = ? WHERE user_email = ?")) {
            mysqli_stmt_bind_param($stmt, 'ss', $token, $reset_email);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt); 
            $flag = true;           
        } 
    } 
    return $flag;
}

function send_email($reset_email,$token) {
    // 創建一個實例，傳遞 true 參數以啟用異常處理
    $mail = new PHPMailer(true);

    try {
        // 伺服器設定
        // $mail->SMTPDebug = SMTP::DEBUG_SERVER;                   // 啟用詳細的偵錯輸出
        $mail->isSMTP();                                            // 使用 SMTP 發送郵件
        $mail->Host       = 'sandbox.smtp.mailtrap.io';             // 設定 SMTP 伺服器
        $mail->SMTPAuth   = true;                                   // 啟用 SMTP 驗證
        $mail->Username   = 'jojouser';                       //SMTP 帳號
        $mail->Password   = 'jojopass';                               //SMTP 密碼
        // $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //啟用隱含的 TLS 加密
        $mail->Port       = 2525;                                    //要連接的 TCP 埠；如果設定了 `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`，則使用 587 埠

        // 收件人
        $mail->setFrom('jojo@gmail.com', 'JOJO');
        $mail->addAddress($reset_email);     //添加收件人
        $mail->addAddress('ellen@example.com');               //名稱是可選的
        $mail->addReplyTo('info@example.com', '信息');
        $mail->addCC('cc@example.com');
        $mail->addBCC('bcc@example.com');

        // 附件
        // $mail->addAttachment('/var/tmp/file.tar.gz');         //添加附件
        // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //可選的附件名稱

        // 內容
        $mail->isHTML(true);                                  //將電子郵件格式設定為 HTML
        $mail->CharSet = 'UTF-8';
        $mail->Subject = '這是主旨';        
        $mail->Body    = <<<HTML
            <p>Please click to reset your password
            <a href=http://cms.test/reset.php?email=$reset_email&token=$token>reset</a>
            </p>
        HTML;
        $mail->AltBody = '這是非 HTML 郵件客戶端的純文本內容';

        if($mail->send()) {
            echo "IT WAST SENT";
        } else {
            echo 'NOT SENT';
        }
        // $mail->send();
        // echo '郵件已發送';
    } catch (Exception $e) {
        echo "無法發送郵件。錯誤訊息: {$mail->ErrorInfo}";
    }
}







?>

<!-- Page Content -->
<div class="container">

    <div class="form-gap"></div>
    <div class="container">
        <div class="row">
            <div class="col-md-4 col-md-offset-4">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="text-center">

                        <?php if(!isset($email_sent)): ?>

                                <h3><i class="fa fa-lock fa-4x"></i></h3>
                                <h2 class="text-center">Forgot Password?</h2>
                                <p>You can reset your password here.</p>
                                <div class="panel-body">

                                    <form id="register-form" role="form" autocomplete="off" class="form" method="post">

                                        <div class="form-group">
                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="glyphicon glyphicon-envelope color-blue"></i></span>
                                                <input id="email" name="email" placeholder="email address" class="form-control"  type="email">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <input name="recover-submit" class="btn btn-lg btn-primary btn-block" value="Reset Password" type="submit">
                                        </div>

                                        <input type="hidden" class="hide" name="token" id="token" value="">
                                    </form>

                                </div><!-- Body-->

                        <?php else: ?>

                            <h2>Please check your email</h2>

                        <?php endif; ?>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <hr>

    <?php include "includes/footer.php";?>

</div> <!-- /.container -->
