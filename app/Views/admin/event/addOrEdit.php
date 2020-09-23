<?= $this->extend('templates/admin') ?>
<?= $this->section('body') ?>
<script>
	$(document).ready(function() {
		let slag = $("#slag");
		let edit_mode = <?= $edit_mode ? 'true' : 'false' ?>;

		if (!edit_mode) {
			for (i = 0; i < 10; i++) {
				slag.append("<div class=\"input-group date\"><input type=\"text\" class=\"form-control\" name=\"strokes[]\"><span class=\"input-group-addon\"><i class=\"glyphicon glyphicon-trash\"></i></span></div>"); //add input box
			}
		}

		slag.on("click", ".input-group-addon", function(e) {
			e.preventDefault();
			$(this).closest("div").remove();
		});
	});
</script>
<div class="navigation-link"><a href="/admin/events"><b>Terug</b></a></div>
<?= \Config\Services::validation()->listErrors() ?>
<?= form_open_multipart('/admin/events') ?>
<?php if ($edit_mode && $event->eventId) { ?>
	<input type="hidden" name="eventId" value="<?= $event->eventId ?>">
<?php } ?>
<div class="form-group">
	<label for="nameNL">Naam (NL)</label>
	<input type="text" class="form-control" name="nameNL" id="nameNL" placeholder="Naam" value="<?= ($edit_mode) ? $event->nameNL : '' ?>">
</div>
<div class="form-group">
	<label for="summernote">Omschrijving (NL)</label>
	<textarea class="input-block-level" id="summernote" name="descriptionNL" required><?= ($edit_mode) ? $event->descriptionNL : '' ?></textarea>
</div>
<div class="form-group">
	<label for="nameEN">Naam (EN)</label>
	<input type="text" class="form-control" name="nameEN" id="nameEN" placeholder="Naam" value="<?= ($edit_mode) ? $event->nameEN : '' ?>">
</div>
<div class="form-group">
	<label for="engels">Omschrijving (EN)</label>
	<textarea class="input-block-level" id="engels" name="descriptionEN" required><?= ($edit_mode) ? $event->descriptionEN : '' ?></textarea>
</div>
<div class="form-group">
	<label for="kind">Soort</label>
	<select class="form-control" id="kind" name="kind">
		<option value="algemeen" <?= ($edit_mode && $event->kind === "algemeen") ? 'selected' : '' ?>>Algemeen
		</option>
		<option value="toernooi" <?= ($edit_mode && $event->kind === "toernooi") ? 'selected' : '' ?>>Toernooi
		</option>
		<option value="nszk" <?= ($edit_mode && $event->kind === "nszk") ? 'selected' : '' ?>>NSZK</option>
	</select>
</div>
<div class="form-group">
	<label for="from">Van/Tot</label>
	<div class="input-daterange input-group" id="datepicker">
		<input type="text" class="form-control-sm form-control flatpickr" name="from" id="from" value="<?= ($edit_mode) ? $event->from->format('d-m-Y H:i') : '' ?>" />
		<span class="input-group-addon">until</span>
		<input type="text" class="form-control-sm form-control flatpickr" name="until" id="until" value="<?= ($edit_mode) ? $event->until->format('d-m-Y H:i') : '' ?>" />
	</div>
</div>
<div class="form-group">
	<label for="link">Link</label>
	<input type="text" class="form-control" name="link" id="link" placeholder="Link naar het Facebook-evenement of website" value="<?= ($edit_mode) ? $event->link : '' ?>">
</div>
<div class="form-group">
	<label for="location">Locatie</label>
	<input type="text" class="form-control" name="location" id="location" placeholder="location" value="<?= ($edit_mode) ? $event->location : '' ?>">
</div>
<div class="form-group">
	<label for="inschrijven">Inschrijven mogelijk</label>
	<label><input required type="radio" name="needsRegistration" onchange="toggleInschrijf($(this).val())" id="inschrijven" value="1" <?= ($edit_mode && $event->needsRegistration) ? 'checked' : '' ?>>Ja</label>
	<label><input required type="radio" name="needsRegistration" onchange="toggleInschrijf($(this).val())" value="0" <?= ($edit_mode && !$event->needsRegistration) ? 'checked' : '' ?>>Nee</label>
</div>
<div class="form-group <?= ($edit_mode && $event->needsRegistration) ? '' : 'd-none' ?>" id="registrationDeadline">
	<label for="registrationDeadline">Aanmelddeadline</label>
	<div class="input-group date">
		<input type="text" class="form-control flatpickr" name="registrationDeadline" id="inschrijf" value="<?= ($edit_mode && $event->needsRegistration) ? $event->registrationDeadline->format('d-m-Y H:i') : '' ?>"><span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>
	</div>
</div>
<div class="form-group <?= ($edit_mode && $event->needsRegistration) ? '' : 'd-none' ?>" id="cancellationDeadline">
	<label for="cancellationDeadline">Afmelddeadline</label>
	<div class="input-group date">
		<input type="text" class="form-control flatpickr" name="cancellationDeadline" id="afmeld" value="<?= ($edit_mode && $event->needsRegistration && $event->cancellationDeadline) ? $event->cancellationDeadline->format('d-m-Y H:i') : '' ?>"><span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>
	</div>
</div>
<div class="form-group">
	<label for="needsPayment">Betaalde activiteit</label>
	<label><input required type="radio" name="needsPayment" id="needsPayment" value="1" <?= ($edit_mode && $event->needsPayment) ? 'checked' : '' ?>>Ja</label>
	<label><input required type="radio" name="needsPayment" value="0" <?= ($edit_mode && !$event->needsPayment) ? 'checked' : '' ?>>Nee</label>
</div>
<div class="form-group">
	<label for="maximumRegistrations">Maximum aantal aanmeldingen</label>
	<input type="number" value="<?= ($edit_mode) ? $event->maximumRegistrations : 0 ?>" id="maximumRegistrations" name="maximumRegistrations" class="form-control" min="0">
	<span class="form-text">De standaardwaarde 0 betekent dat er geen limiet is op het aantal aanmeldingen!</span>
</div>
<div id="nszk" class="<?= ($edit_mode && $event->kind === 'nszk') ? '' : 'd-none' ?>">
	<div class="form-group">
		<label for="strokes">strokes</label>
		<div id="wrapper">
			<?php if ($edit_mode && $event->kind === 'nszk') { ?>
				<div id="slag">
					<?php $strokes = json_decode($event->strokes);
					foreach ($strokes as $slag) { ?>
						<input type="text" class="form-control" id="strokes" name="strokes[]" value="<?= $slag ?>">
					<?php } ?>
				</div>
			<?php } else { ?>
				<div id="slag">
					<input type="text" class="form-control" id="strokes" name="strokes[]">
				</div>
			<?php } ?>
			<button type="button" class="btn btn-primary form-control" id="add_button">Slag toevoegen</button>
		</div>
	</div>
</div>
<div class="form-group">
	<button class="btn btn-primary" type="submit"><?= ($edit_mode) ? 'Opslaan' : 'Toevoegen' ?></button>
</div>
<?= form_close(); ?>
<script lang="text/javascript" src="/assets/components/agenda.js"></script>
<?= $this->endSection() ?>