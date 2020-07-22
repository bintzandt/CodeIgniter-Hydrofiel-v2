<?= $this->extend('templates/admin') ?>
<?= $this->section('body') ?>
<div class="navigation-link"><a href="/admin"><b>Terug</b></a></div>
<?= form_open_multipart("/admin/pages") ?>
<?php if ($edit_mode) { ?>
	<input type="hidden" name="id" value="<?= $page->id ?>" />
<?php } ?>
<div class="form-group">
	<label for="naam">Nederlandse naam</label>
	<input class="form-control" type="text" name="naam" id="naam" value="<?= ($edit_mode) ? $page->naam : '' ?>" placeholder="Naam">
</div>
<div class="form-group">
	<label for="engelse_naam">Engelse naam</label>
	<input class="form-control" type="text" name="engelse_naam" id="engelse_naam" value="<?= ($edit_mode) ? $page->engelse_naam : '' ?>" placeholder="Name">
</div>
<div class="form-group">
	<label for="bereikbaar">Bereikbaar</label><br>
	<div class="form-check form-check-inline">
		<label class="form-check-label"><input class="form-check-input" required <?= ($edit_mode && $page->bereikbaar === 'ja') ? 'checked' : '' ?> type="radio" name="bereikbaar" id="bereikbaar" value="ja">Ja</label>
	</div>
	<div class="form-check form-check-inline">
		<label class="form-check-label"><input class="form-check-input" required <?= ($edit_mode && $page->bereikbaar === 'nee') ? 'checked' : '' ?> type="radio" name="bereikbaar" value="nee">Nee</label>
	</div>
</div>
<div class="form-group">
	<label for="zichtbaar">Zichtbaar in menu</label><br>
	<div class="form-check form-check-inline">
		<label class="form-check-label"><input class="form-check-input" required <?= ($edit_mode && $page->zichtbaar === 'ja') ? 'checked' : '' ?> type="radio" name="zichtbaar" id="zichtbaar" value="ja">Ja</label>
	</div>
	<div class="form-check form-check-inline">
		<label class="form-check-label"><input class="form-check-input" required <?= ($edit_mode && $page->zichtbaar === 'nee') ? 'checked' : '' ?> type="radio" name="zichtbaar" value="nee">Nee</label>
	</div>
</div>
<div class="form-group">
	<label for="hoofdmenu">Hoofdmenu</label><br>
	<div class="form-check form-check-inline">
		<label class="form-check-label"><input class="form-check-input" required <?= ($edit_mode && $page->submenu === 'A') ? 'checked' : '' ?> type="radio" onchange="update(this.value)" name="mainMenuItem" id="hoofdmenu" value="1">Ja</label>
	</div>
	<div class="form-check form-check-inline">
		<label class="form-check-label"><input class="form-check-input" required <?= ($edit_mode && $page->submenu !== 'A') ? 'checked' : '' ?> type="radio" onchange="update(this.value)" name="mainMenuItem" value="0">Nee</label>
	</div>
	<?php if ($page->submenu === 'A') { ?>
		<small class="form-text text-muted">
			Het veranderen van een hoofdmenu naar een submenu zorgt ervoor dat alle pagina's die er onder hangen niet meer toegankelijk zullen zijn. Zorg ervoor dat je deze pagina's eerst onder een ander menu item hangt.
		</small>
	<?php } ?>
</div>
<div class="form-group">
	<label for="ingelogd">Moet ingelogd zijn</label><br>
	<div class="form-check form-check-inline">
		<label class="form-check-label"><input class="form-check-input" required <?= ($edit_mode && $page->ingelogd) ? 'checked' : '' ?> type="radio" name="ingelogd" id="ingelogd" value="1">Ja</label>
	</div>
	<div class="form-check form-check-inline">
		<label class="form-check-label"><input class="form-check-input" required <?= ($edit_mode && !$page->ingelogd) ? 'checked' : '' ?> type="radio" name="ingelogd" value="0">Nee</label>
	</div>
</div>
<div id="menu" class="<?= $page->submenu === 'A' ? 'd-none' : '' ?>">
	<div class="form-group">
		<label id="labelna" for="na">Onder welk menu</label>
		<select class="form-control" id="na" name="na">
			<?php foreach ($hoofdmenu as $optie) { ?>
				<option value="<?= $optie->id ?>" <?= ($edit_mode && $page->submenu === $optie->id) ? 'selected' : '' ?>><?= $optie->naam ?></option>
			<?php } ?>
		</select>
	</div>
</div>
<?php if ($edit_mode && $page->cmspagina === 'ja' || !$edit_mode) { ?>
	<div class="form-group">
		<label for="summernote">Nederlands</label>
		<textarea class="input-block-level" id="summernote" name="tekst"><?= ($edit_mode) ? $page->tekst : '' ?></textarea>
	</div>
	<div class="form-group">
		<label for="summernote">Engels</label>
		<textarea class="input-block-level" id="engels" name="engels"><?= ($edit_mode) ? $page->engels : '' ?></textarea>
	</div>
<?php } ?>
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