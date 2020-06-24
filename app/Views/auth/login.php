<?= $this->extend('templates/default'); ?>

<?= $this->section('body') ?>
<div class="row justify-content-center">
    <div class="col-sm-7 col-lg-4">
        <?= \Config\Services::validation()->listErrors() ?>
		<?= form_open( route_to('login'), ['class' => 'form-signin']); ?>
        <input type="email" name="email" class="form-control" placeholder="<?= lang('Auth.email') ?>"
               value="<?= old('email') ?>" autofocus autocomplete="username">
        <input type="password" name="wachtwoord" class="form-control"
               placeholder="<?= lang('Auth.password') ?>" autocomplete="current-password">
        <button class="btn btn-lg btn-primary btn-block" type="submit"><?= lang('Auth.logIn') ?></button>
        <a href="<?= route_to('forgot') ?>"
           class="float-right need-help"><?= lang('Auth.forgotPassword') ?></a><span class="clearfix"></span>
        <?= form_close() ?>
    </div>
</div>
<?= $this->endSection() ?>