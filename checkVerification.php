<?php
session_start();
$massage = '';
$verificationCode = $_SESSION['verification-code'];
print_r($_SESSION);
print_r($verificationCode);
if (isset($_POST['captcha'])) {
    $captcha = $_POST['captcha'];
    if ($captcha === $verificationCode) {
        $massage = 'it is ok';
        echo '<div>';
        echo $massage;
        echo '</div>';
        exit;
    } else {
        $massage = 'it is not ok';
        echo '<div>';
        echo $massage;
        echo '</div>';
    }
}
?>

<body>
    <img src="generateCaptcha.php">
    <form action="" method="post">
        Enter captcha <input type="text" name="captcha"><br>
        <input type="submit" name="submitbtn">
    </form>
    <?php

    session_destroy();
    ?>

</body>