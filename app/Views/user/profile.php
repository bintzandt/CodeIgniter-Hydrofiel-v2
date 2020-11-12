<?= $this->extend('templates/default'); ?>

<?= $this->section('body') ?>
    <h3>
        <?php
        echo sprintf('%s %s %s', lang('User.title'), $user->name, getEditIcon($user->userId));
        ?>
    </h3>
    <table class="table table-sm table-user-information">
        <tbody>
        <tr>
            <td>
                <strong>
                    <span class="fa fa-user"></span>
                    <?= lang("User.name"); ?>
                </strong>
            </td>
            <td>
                <?= $user->name ?>
            </td>
        </tr>
        <tr>
            <td>
                <strong>
                    <span class="fa fa-birthday-cake"></span>
                    <?= lang("User.birthday"); ?>
                </strong>
            </td>
            <td>
                <?= $user->birthday ? $user->birthday->format('d-m-Y') : '' ?>
            </td>
        </tr>
        <tr>
            <td>
                <strong>
                    <span class="fa fa-envelope"></span>
                    <?= lang("User.email"); ?>
                </strong>
            </td>
            <td>
                <?= $user->email ?>
            </td>
        </tr>
        <tr>
            <td>
                <strong>
                    <span class="fa fa-swimmer"></span>
                    <?= lang("User.membership"); ?>
                </strong>
            </td>
            <td>
                <?= $user->localizedMembership ?>
            </td>
        </tr>
        </tbody>
    </table>
<?= $this->endSection() ?>
