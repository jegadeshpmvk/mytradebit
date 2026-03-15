<?php
$flashSuccess = Yii::$app->session->getFlash("success");
$flashError   = Yii::$app->session->getFlash("error");
?>

<div style="text-align:center;margin-top:50px; font-family:Arial;">

    <?php if ($flashSuccess): ?>
        <h2 style="color:green;">Payment Successful ✅</h2>
        <p>Your subscription is now active.</p>
    <?php endif; ?>

    <?php if ($flashError): ?>
        <h2 style="color:red;">Payment Failed ❌</h2>
        <p>Please try again.</p>
    <?php endif; ?>

</div>

<script>
    // Refresh parent page
    if (window.opener) {
        window.opener.location.href = "/dashboard";
    }

    // Close popup after 2 seconds
    setTimeout(() => {
        window.close();
    }, 2000);
</script>