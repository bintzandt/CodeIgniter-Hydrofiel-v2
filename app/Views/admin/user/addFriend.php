<?php

use Config\Services;

?>
<?= $this->extend('templates/admin') ?>
<?= $this->section('body') ?>
    <h2>Vriend van Hydrofiel toevoegen</h2>
    <div class="navigation-link"><b><a href="/admin/users">Terug</a></b></div>
<?= Services::validation()->listErrors() ?>
<?= form_open(); ?>
    <div class="form-group">
        <label for="name">Naam</label>
        <input class="form-control" placeholder="volledige naam" id="name" name="name" value="<?= old('name') ?>"/>
    </div>
    <div class="form-group">
        <label for="email">Email</label>
        <input class="form-control" placeholder="email-adres" id="email" name="email" value="<?= old('email') ?>"/>
    </div>
    <div class="form-group">
        <label for="preferEnglish">Engels</label>
        <div class="form-check">
            <label class="form-check-label"><input type="checkbox" class="form-check-input" id="preferEnglish"
                                                   name="preferEnglish" value="Ja" <?= set_checkbox(
                    'preferEnglish',
                    'Ja'
                ) ?> />Gebruiker is Engelstalig</label>
        </div>
    </div>
    <div class="form-group">
        <button type="submit" role="button" class="btn btn-primary form-control">Toevoegen</button>
    </div>
<?= form_close(); ?>
<?= $this->endSection() ?>
