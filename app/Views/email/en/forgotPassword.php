<?php

$date = $valid->toDateTime(); ?>
<?= $this->extend('email/template'); ?>
<?= $this->section('content') ?>
<p>
    Dear member,
</p>
<p>
    With <a href="<?= site_url([route_to('reset-password'), '?token=' . $recovery]) ?>">this</a> url you can reset
    your
    password.
</p>
<p>
    <b>Be careful: this link will expire on <?= $date->format('d-m-Y') ?> at <?= $date->format('H:i') ?>.</b>
</p>
<p>
    Or copy the following link to the reset form: <?= $recovery ?>.
</p>
<p>
    If you did not ask to reset your password you can just sit back. If you keep getting these emails please contact
    <a href="mailto:webmaster@hydrofiel.nl">webmaster@hydrofiel.nl</a>.
</p>
<?= $this->endSection() ?>
