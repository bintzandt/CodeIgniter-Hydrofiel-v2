<?= $this->extend('templates/default'); ?>

<?= $this->section('body') ?>
<script src="/assets/webauthnauthenticate.js"></script>
<script src="/assets/webauthnregister.js"></script>
<script>
    function hasWebAuthnSupport() {
        return (window.PublicKeyCredential !== undefined || typeof window.PublicKeyCredential === "function");
    }

    $(document).ready(function () {
        let webauth_btn = $("#webauthn-add-button");

        if (hasWebAuthnSupport()) {
            webauth_btn.removeClass("d-none");
        }

        webauth_btn.click(async function () {
            $.ajax({
                method: "GET",
                url: "webauthn/get_registration_challenge",
                dataType: "json",
                success: function (response) {
                    webauthnRegister(response, function (success, info) {
                        if (success) {
                            $.ajax({
                                method: "POST",
                                url: "/webauthn/register",
                                data: {register: info},
                                dataType: "json",
                                success: function (r) {
                                    console.debug(r);
                                    alert("registration success!");
                                },
                                error: function (xhr, status, error) {
                                    alert("registration failed: " + error + ": " + xhr.responseText);
                                },
                            });
                        } else {
                            alert(info);
                        }
                    });
                },
                error: function (xhr, status, error) {
                    alert("couldn't initiate registration: " + error + ": " + xhr.responseText);
                },
            });
        });
    });
</script>
<?= \Config\Services::validation()->listErrors() ?>
<h3><?= sprintf( '%s %s', lang('User.title'), $user->name); ?></h3>
<?= form_open(); ?>
<div class="form-group">
    <div class="col-md-2">
        <label class="col-form-label" for="naam"><?= lang("User.name") ?></label>
    </div>
    <div class="col-md-10">
        <input style="cursor: not-allowed" id="naam" name="naam" type="text" class="form-control" disabled value="<?= $user->name ?>">
    </div>
</div>
<div class="form-group">
    <div class="col-md-2">
        <label class="col-form-label" for="wachtwoord"><?= lang("User.password") ?></label>
    </div>
    <div class="col-md-10">
        <input id="wachtwoord" name="wachtwoord1" type="password" class="form-control" placeholder="<?= lang('Auth.password') ?>" autocomplete="new-password">
        <input id="wachtwoord2" name="wachtwoord2" type="password" class="form-control" placeholder="<?= lang('Auth.confirmPassword') ?>" autocomplete="new-password">
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
        <input type="checkbox" name="zichtbaar_email"
               value="1" <?= $user->visibleEmail ?>> <?= lang("User.showEmail") ?>
    </div>
</div>
<div class="form-group">
    <div class="col-md-2">
        <label class="col-form-label"><?= lang("User.newsletter") ?></label>
    </div>
    <div class="col-md-10">
        <input type="checkbox" name="nieuwsbrief"
               value="1" <?= $user->receiveNewsletter ?>> <?= lang("User.newsletterHelp") ?>
    </div>
</div>
<div class="form-group">
    <div class="col-md-2">
        <label class="col-form-label">English</label>
    </div>
    <div class="col-md-10">
        <input type="checkbox" name="engels" value="1" <?= $user->preferEnglish ?>> I want to receive
        content in English
    </div>
</div>
<div class="form-group">
    <div class="col-md-10">
        <input type="submit" class="btn btn-primary" value="<?= lang('Button.save') ?>">
        <input type="reset" class="btn btn-warning" onclick="window.location.replace(document.referrer)"
               value="<?= lang('Button.cancel') ?>">
        <input type="button" class="btn btn-success d-none" id="webauthn-add-button"
               value="Add a FIDO2 key"/>
    </div>
</div>
<?= form_close(); ?>
<?= $this->endSection() ?>