<?= $this->extend('templates/admin') ?>
<?= $this->section('body') ?>
<h2>Mailen</h2>
<?= form_open_multipart('', ['id' => 'mailForm']); ?>
<?= \Config\Services::validation()->listErrors() ?>
<div class="form-group">
	<label for="aan">Aan</label>
	<select class="selectpicker form-control" id="aan" name="aan">
		<option value="bestuur" <?php echo set_select('aan', 'bestuur', true); ?>>Bestuur</option>
		<option value="leden" <?php echo set_select('aan', 'leden'); ?>>Leden (excl. Vrienden van Hydrofiel)</option>
		<option value="nieuwsbrief" <?php echo set_select('aan', 'nieuwsbrief'); ?>>Nieuwsbrief</option>
		<option value="zwemmer" <?php echo set_select('aan', 'zwemmer'); ?>>Zwemmers</option>
		<option value="waterpolo" <?php echo set_select('aan', 'waterpolo'); ?>>Waterpolo</option>
		<option value="waterpolo_competitie" <?php echo set_select('aan', 'waterpolo_competitie'); ?>>Waterpolo
			(competitie)
		</option>
		<option value="waterpolo_recreatief" <?php echo set_select('aan', 'waterpolo_recreatief'); ?>>Waterpolo
			(recreatief)
		</option>
		<option value="iedereen" <?php echo set_select('aan', 'iedereen'); ?>>Iedereen (incl. Vrienden van Hydrofiel)</option>
		<option value="trainer" <?php echo set_select('aan', 'trainer'); ?>>Trainers</option>
		<option value="select" <?php echo set_select('aan', 'select'); ?>>Losse personen</option>
	</select>
</div>
<div class="form-group">
	<label for="van">Van</label>
	<select class="selectpicker form-control" id="van" name="van">
		<option value="bestuur" <?php echo set_select('van', 'bestuur', true); ?>>Bestuur</option>
		<option value="voorzitter" <?php echo set_select('van', 'voorzitter'); ?>>Voorzitter</option>
		<option value="secretaris" <?php echo set_select('van', 'secretaris'); ?>>Secretaris</option>
		<option value="penningmeester" <?php echo set_select('van', 'penningmeester'); ?>>Penningmeester</option>
		<option value="zwemmen" <?php echo set_select('van', 'zwemmen'); ?>>Zwemcommissaris</option>
		<option value="waterpolo" <?php echo set_select('van', 'waterpolo'); ?>>Waterpolocommissaris</option>
		<option value="algemeen" <?php echo set_select('van', 'algemeen'); ?>>Commissaris Algemeen</option>
		<option value="activiteiten" <?php echo set_select('van', 'activiteiten'); ?>>Activiteitencommissie
		</option>
	</select>
</div>
<div class="form-group">
	<label for="email">Stuur ook naar</label>
	<input type="text" class="form-control" id="email" name="email" value="<?= set_value('email') ?>">
	<span class="form-text">Laat dit veld leeg als je de email niet apart wilt doorsturen.</span>
</div>
<div class="form-group">
	<label for="los">Los</label>
	<select multiple class="form-control" id="los" name="los[]">
		<?php foreach ($leden as $lid) { ?>
			<option value="<?= $lid->id ?>" <?php echo set_select('los[]', $lid->id) ?>><?= $lid->naam ?></option>
		<?php } ?>
	</select>
</div>
<div class="form-group">
	<label for="layout">Layout</label>
	<select id="layout" class="form-control" name="layout">
		<option value="standaard" <?php echo set_select('layout', 'standaard', true); ?>>Standaard layout</option>
		<option value="nieuwsbrief" <?php echo set_select('layout', 'nieuwsbrief'); ?>>Nieuwsbrief layout</option>
		<option value="geen" <?php echo set_select('layout', 'geen'); ?>>Geen layout</option>
	</select>
</div>
<div class="form-group">
	<label for="onderwerp">Onderwerp (NL)</label>
	<input type="text" class="form-control" id="onderwerp" name="onderwerp" value="<?= set_value('onderwerp') ?>" required />
</div>
<div class="form-group">
	<label for="summernote">Tekst (NL)</label>
	<textarea class="input-block-level" id="summernote" name="content" required><?php echo set_value('content') ?></textarea>
</div>
<div class="form-group">
	<label for="file">Bijlage (NL)</label>
	<input type="file" name="attachments_nl[]" size="10" multiple />
</div>
<div class="form-group">
	<label for="en_onderwerp">Onderwerp (EN)</label>
	<input type="text" class="form-control" id="en_onderwerp" name="en_onderwerp" value="<?= set_value('en_onderwerp') ?>" required />
</div>
<div class="form-group">
	<label for="engels">Tekst (EN)</label>
	<textarea class="input-block-level" id="engels" name="en_content" required><?php echo set_value('en_content') ?></textarea>
</div>
<div class="form-group">
	<label for="file">Bijlage (EN)</label>
	<input type="file" name="attachments_en[]" size="10" multiple>
</div>
<div class="form-group">
	<input id="send" onclick="showModal()" type="button" role="button" class="btn btn-primary form-control" value="Versturen">
</div>
<?= form_close() ?>
<?= $this->endSection() ?>