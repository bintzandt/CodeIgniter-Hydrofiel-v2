<?php

use Config\Services;

?>
<?= $this->extend('templates/default'); ?>

<?= $this->section('title') ?>
<?= lang('Auth.changePassword'); ?>
<?= $this->endSection() ?>

<?= $this->section('body') ?>
<div class="row justify-content-center">
    <div class="col-lg-4 col-md-6">
        <?= Services::validation()->listErrors() ?>
        <?= form_open(route_to('reset-password'), ["class" => "form-signin"]); ?>
        <input type="text" name="token" class="form-control"
               placeholder="<?= lang('Auth.token') ?>" value="<?= old('token', $token ?? '') ?>">
        <input type="email" name="email" class="form-control"
               placeholder="<?= lang('Auth.email') ?>" value="<?= old('email') ?>">
        <input type="password" name="password" class="form-control"
               placeholder="<?= lang('Auth.password'); ?>">
        <input type="password" name="pass_confirm" class="form-control"
               placeholder="<?= lang('Auth.confirmPassword') ?>">
        <button class="btn btn-lg btn-primary btn-block" type="submit"
                name="submit"><?= lang('Auth.changePassword') ?></button>
        <?= form_close(); ?>
    </div>
</div>
<?= $this->endSection() ?>
