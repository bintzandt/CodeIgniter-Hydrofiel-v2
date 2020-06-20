<?= $this->extend('templates/default'); ?>

<?= $this->section('body') ?>
<div class="row justify-content-center">
    <div class="col-lg-4 col-md-6">
        <?= form_open(route_to('forgot'), ["class" => "form-signin"]); ?>
        <?= \Config\Services::validation()->listErrors() ?>
        <input type="text" name="email" class="form-control" placeholder="<?= lang('Auth.email') ?>" autofocus>
        <button class="btn btn-lg btn-primary btn-block" type="submit">
            <?= lang('Auth.send'); ?>
        </button>
        <?= form_close(); ?>
    </div>
</div>
<?= $this->endSection() ?>