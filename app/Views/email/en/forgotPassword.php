<?php
$date = $valid->toDateTime();
?>
<!DOCTYPE HTML>
<html>
<body>
<div style="width: 100%; margin: auto;" align="center">
    <table cellspacing="0" cellpadding="0" width="100%">
        <tr style="background: #ffab3a; height: 120px; padding: 7px;">
            <td><img src="<?= site_url('/images/logomail.png') ?>" alt="Logo" height="100" style="float:left;"></td>
        </tr>
        <tr>
            <td valign="top" style="text-align: left;">
                <p>
                    Dear member,<br>
                    <br>
                    With <a href="<?= site_url([route_to('reset-password'), '?token=' . $recovery]) ?>">this</a> url you can reset your
                    password.<br>
                    <br>
                    <b>Be careful: this link will expire on <?= $date->format('d-m-Y') ?>
                        at <?= $date->format('H:i') ?>.</b><br>
                    <br>
                    Or copy the following link to the reset form: <?= $recovery ?></br>
                    </br>
                    If you did not ask to reset your password you can just sit back. If you keep getting these emails
                    please contact <a href="mailto:webmaster@hydrofiel.nl">webmaster@hydrofiel.nl</a>.<br>
                    <br>
                </p>
            </td>
        </tr>
        <tr>
            <td style="color: #FFFFFF; background: #315265; padding: 7px;" height="50"></td>
        </tr>
    </table>
</div>
</body>
</html>
