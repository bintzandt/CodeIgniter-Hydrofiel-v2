<?= $this->extend('templates/default'); ?>

<?= $this->section('body') ?>
<script>
    function hasWebAuthnSupport() {
        return (window.PublicKeyCredential !== undefined || typeof window.PublicKeyCredential === "function");
    }

    function removeBanner() {
        $("#browser-supported").addClass("d-none");
        Cookies.set("dismissAlert", true, {path: ""});
    }

    $(document).ready(function () {
        const emailValueInCookie = Cookies.get("email");
        const alertDismissed = Cookies.get("dismissAlert");

        if (emailValueInCookie) {
            $("#email").val(emailValueInCookie);
            $("#wachtwoord").focus();
        }

        if (hasWebAuthnSupport() && !alertDismissed) {
            $("#browser-supported").removeClass("d-none");
        }

        $("#form-signin").submit(async function (e) {
            const password = $("#wachtwoord").val();
            const email = $("#email").val();

            Cookies.set("email", email, {path: ""});

            if (password != "") {
                return;
            }

            if (!hasWebAuthnSupport()) {
                return;
            }

            e.preventDefault();


            $.ajax({
                method: "POST",
                url: "/webauthn/prepare_for_login",
                data: {email: email},
                dataType: "json",
                success: function (r) {
                    webauthnAuthenticate(r, function (success, info) {
                        if (success) {
                            $.ajax({
                                method: "POST",
                                url: "/webauthn/authenticate",
                                data: {auth: info, email: email},
                                dataType: "json",
                                success: function () {
                                    window.location.replace("/");
                                },
                                error: function (xhr, status, error) {
                                    alert("login failed: " + error + ": " + xhr.responseText);
                                },
                            });
                        } else {
                            alert(info);
                        }
                    });
                },
                error: function (xhr, status, error) {
                    alert("couldn't initiate login: " + error + ": " + xhr.responseText);
                },
            });
        });
    });
</script>
<script src="/assets/webauthnauthenticate.js"></script>
<script src="/assets/webauthnregister.js"></script>
<div class="row justify-content-center">
    <div class="col-sm-7 col-lg-4">
        <div class="alert alert-info alert-dismissible d-none" id="browser-supported" onclick="removeBanner()"
             role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close" onclick="removeBanner()">
                <span aria-hidden="true">&times;</span>
            </button>
            <strong><?= lang('inloggen_browser_supported'); ?></strong>
        </div>
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