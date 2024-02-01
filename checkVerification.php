<?php
session_start();
$massage = '';
// print_r($_SESSION);
if (isset($_POST['captcha'])) {
    $captcha = $_POST['captcha'];
    $captchaKey = $_POST['key'];
    $verificationCode= $_SESSION['verification_code'][$captchaKey];
    if ($captcha === $verificationCode) {
        $massage = 'it is ok';
        echo '<div>';
        echo $massage;
        echo '</div>';
        session_destroy();
        exit;
    } else {
        $massage = 'it is not ok';
        echo '<div>';
        echo $massage;
        echo '</div>';
        session_destroy();
    }
    
}
$key = rand(1,10000);

?>

<body>
    <h3><?=$key?></h3>
    <img src="generateCaptcha.php?key=<?=$key?>">
    <form action="" method="post">
        <input type="hidden" name="key" value="<?=$key?>" />
        Enter captcha <input type="text" name="captcha"><br>
        <input type="submit" name="submitbtn">
    </form>


</body>