<?= $this->extend('templates/default'); ?>

<?= $this->section('body') ?>
<?= \Config\Services::validation()->listErrors() ?>
<h3><?= sprintf( '%s %s', lang('User.title'), $user->name); ?></h3>
<?= form_open(); ?>
<div class="form-group">
    <div class="col-md-2">
        <label class="col-form-label" for="name"><?= lang("User.name") ?></label>
    </div>
    <div class="col-md-10">
        <input style="cursor: not-allowed" id="name" name="name" type="text" class="form-control" disabled value="<?= $user->name ?>">
    </div>
</div>
<div class="form-group">
    <div class="col-md-2">
        <label class="col-form-label" for="password"><?= lang("User.password") ?></label>
    </div>
    <div class="col-md-10">
        <input id="password" name="password1" type="password" class="form-control" placeholder="<?= lang('Auth.password') ?>" autocomplete="new-password">
        <input id="password2" name="password2" type="password" class="form-control" placeholder="<?= lang('Auth.confirmPassword') ?>" autocomplete="new-password">
        <span class="form-text"><?= lang("User.passwordHelp") ?></span>
    </div>
</div>
<div class="form-group">
    <div class="col-md-2">
        <label class="col-form-label" for="email"><?= lang("User.email") ?></label>
    </div>
    <div class="col-md-10">
        <input id="email" type="text" name="email" value="<?= $user->email ?>" class="form-control" autocomplete="email">
    </div>
</div>
<div class="form-group">
    <div class="col-md-2">
        <label class="col-form-label"><?= lang("User.visible") ?></label>
    </div>
    <div class="col-md-10">
        <input type="hidden" name="showEmail" value="0" />
        <input type="checkbox" name="showEmail"
               value="1" <?= $user->showEmail ?>> <?= lang("User.showEmail") ?>
    </div>
</div>
<div class="form-group">
    <div class="col-md-2">
        <label class="col-form-label"><?= lang("User.newsletter") ?></label>
    </div>
    <div class="col-md-10">
        <input type="hidden" name="receiveNewsletter" value="0" />
        <input type="checkbox" name="receiveNewsletter"
               value="1" <?= $user->receiveNewsletter ?>> <?= lang("User.newsletterHelp") ?>
    </div>
</div>
<div class="form-group">
    <div class="col-md-2">
        <label class="col-form-label">English</label>
    </div>
    <div class="col-md-10">
        <input type="hidden" name="preferEnglish" value="0" />
        <input type="checkbox" name="preferEnglish" value="1" <?= $user->preferEnglish ?>> I want to receive
        content in English
    </div>
</div>
<div class="form-group">
    <div class="col-md-10">
        <input type="submit" class="btn btn-primary" value="<?= lang('Button.save') ?>">
        <input type="reset" class="btn btn-warning" onclick="window.location.replace(document.referrer)"
               value="<?= lang('Button.cancel') ?>">
    </div>
</div>
<?= form_close(); ?>
<?= $this->endSection() ?>