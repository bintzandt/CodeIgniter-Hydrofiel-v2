<?= $this->extend('email/template'); ?>
<?= $this->section('content') ?>
    <p>
        Beste secretaris,
    </p>
    <p>
        <b><?= $naam ?></b> heeft de volgende gegevens aangepast:
        &nbsp;&nbsp;&nbsp;&nbsp;<b>Email</b>:&nbsp;<?= $email ?>
    </p>
    <p>
        Het is wellicht handig om deze wijzigingen ook in Conscribo door te voeren.
    </p>
<?= $this->endSection() ?>
