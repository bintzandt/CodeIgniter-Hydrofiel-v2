<?php
$date = $valid->toDateTime(); ?>
<?= $this->extend('email/template'); ?>
<?= $this->section('content') ?>
    <p>
        Beste,
    </p>
    <p>
        Je hebt aangegeven je wachtwoord niet meer te weten. Met <a
                href="<?= site_url([route_to('reset-password'), '?token=' . $recovery]) ?>">deze link</a> kun je je
        wachtwoord opnieuw instellen.
    </p>
    <p>
        <b>Let op: Deze link vervalt automatisch op <?= $date->format('d-m-Y') ?> om <?= $date->format('H:i') ?>.</b>
    </p>
    <p>
        Of kopieër de volgende token naar het reset formulier: <?= $recovery ?>
    </p>
    <p>
        Mocht je geen nieuw wachtwoord hebben aangevraagd dan hoef je niets te doen. Alleen als je herhaaldelijk deze
        mail ontvangt kun je contact opnemen met <a href="mailto:webmaster@hydrofiel.nl">webmaster@hydrofiel.nl</a>.
    </p>
<?= $this->endSection() ?>
