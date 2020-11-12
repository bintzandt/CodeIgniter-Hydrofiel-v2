<?= $this->extend('templates/admin') ?>
<?= $this->section('body') ?>
    <div class="navigation-link"><a href="/admin"><b>Terug</b></a></div>
<?= form_open_multipart("/admin/pages") ?>
<?php
if ($edit_mode) { ?>
    <input type="hidden" name="pageId" value="<?= $page->pageId ?>"/>
<?php
} ?>
    <div class="form-group">
        <label for="naam">Nederlandse naam</label>
        <input class="form-control" type="text" name="nameNL" id="naam" value="<?= ($edit_mode) ? $page->nameNL : '' ?>"
               placeholder="Naam">
    </div>
    <div class="form-group">
        <label for="engelse_naam">Engelse naam</label>
        <input class="form-control" type="text" name="nameEN" id="engelse_naam"
               value="<?= ($edit_mode) ? $page->nameEN : '' ?>" placeholder="Name">
    </div>
    <div class="form-group">
        <label for="bereikbaar">Bereikbaar</label><br>
        <div class="form-check form-check-inline">
            <label class="form-check-label"><input class="form-check-input"
                                                   required <?= ($edit_mode && $page->isAccessible) ? 'checked' : '' ?>
                                                   type="radio" name="isAccessible" id="bereikbaar" value="1">Ja</label>
        </div>
        <div class="form-check form-check-inline">
            <label class="form-check-label"><input class="form-check-input"
                                                   required <?= ($edit_mode && ! $page->isAccessible) ? 'checked' : '' ?>
                                                   type="radio" name="isAccessible" value="0">Nee</label>
        </div>
    </div>
    <div class="form-group">
        <label for="zichtbaar">Zichtbaar in menu</label><br>
        <div class="form-check form-check-inline">
            <label class="form-check-label"><input class="form-check-input"
                                                   required <?= ($edit_mode && $page->isVisible) ? 'checked' : '' ?>
                                                   type="radio" name="isVisible" id="zichtbaar" value="1">Ja</label>
        </div>
        <div class="form-check form-check-inline">
            <label class="form-check-label"><input class="form-check-input"
                                                   required <?= ($edit_mode && ! $page->isVisible) ? 'checked' : '' ?>
                                                   type="radio" name="isVisible" value="0">Nee</label>
        </div>
    </div>
    <div class="form-group">
        <label for="hoofdmenu">Hoofdmenu</label><br>
        <div class="form-check form-check-inline">
            <label class="form-check-label"><input class="form-check-input"
                                                   required <?= ($edit_mode && $page->parentPageId === null) ? 'checked' : '' ?>
                                                   type="radio" onchange="update(this.value)" name="mainMenuItem"
                                                   id="hoofdmenu" value="1">Ja</label>
        </div>
        <div class="form-check form-check-inline">
            <label class="form-check-label"><input class="form-check-input"
                                                   required <?= ($edit_mode && $page->parentPageId !== null) ? 'checked' : '' ?>
                                                   type="radio" onchange="update(this.value)" name="mainMenuItem"
                                                   value="0">Nee</label>
        </div>
        <?php
        if ($edit_mode && $page->parentPageId === null) { ?>
            <small class="form-text text-muted">
                Het veranderen van een hoofdmenu naar een submenu zorgt ervoor dat alle pagina's die er onder hangen
                niet meer toegankelijk zullen zijn. Zorg ervoor dat je deze pagina's eerst onder een ander menu item
                hangt.
            </small>
        <?php
        } ?>
    </div>
    <div class="form-group">
        <label for="ingelogd">Moet ingelogd zijn</label><br>
        <div class="form-check form-check-inline">
            <label class="form-check-label"><input class="form-check-input"
                                                   required <?= ($edit_mode && $page->requiresLogIn) ? 'checked' : '' ?>
                                                   type="radio" name="requiresLogIn" id="ingelogd" value="1">Ja</label>
        </div>
        <div class="form-check form-check-inline">
            <label class="form-check-label"><input class="form-check-input"
                                                   required <?= ($edit_mode && ! $page->requiresLogIn) ? 'checked' : '' ?>
                                                   type="radio" name="requiresLogIn" value="0">Nee</label>
        </div>
    </div>
    <div id="menu"
         class="<?= ($edit_mode && $page->parentPageId === null) ? 'd-none' : (! $edit_mode ? 'd-none' : '') ?>">
        <div class="form-group">
            <label id="labelna" for="na">Onder welk menu</label>
            <select class="form-control" id="na" name="na">
                <?php
                foreach ($hoofdmenu as $optie) { ?>
                    <option value="<?= $optie->pageId ?>" <?= ($edit_mode && $page->parentPageId === $optie->pageId) ? 'selected' : '' ?>><?= $optie->nameNL ?></option>
                <?php
                } ?>
            </select>
        </div>
    </div>
<?php
if ($edit_mode && $page->isCMSPage || ! $edit_mode) { ?>
    <div class="form-group">
        <label for="summernote">Nederlands</label>
        <textarea class="input-block-level" id="summernote"
                  name="contentNL"><?= ($edit_mode) ? $page->contentNL : '' ?></textarea>
    </div>
    <div class="form-group">
        <label for="summernote">Engels</label>
        <textarea class="input-block-level" id="engels"
                  name="contentEN"><?= ($edit_mode) ? $page->contentEN : '' ?></textarea>
    </div>
<?php
} ?>
    <div class="form-group">
        <button type="submit" id="submit" class="btn btn-primary"><?= ($edit_mode) ? 'Opslaan' : 'Toevoegen' ?></button>
    </div>
<?= form_close(); ?>
    <script>
        function update(tekst) {
            const element = document.getElementById("menu");
            if (tekst === "0") {
                element.classList.remove('d-none');
            } else {
                element.classList.add('d-none');
            }
        }
    </script>
<?= $this->endSection() ?>
