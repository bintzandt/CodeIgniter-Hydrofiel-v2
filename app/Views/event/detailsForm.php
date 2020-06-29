<?= $this->extend('templates/default'); ?>

<?= $this->section('body') ?>
<?= \Config\Services::validation()->listErrors() ?>
<h3><?= lang('Event.furtherInformation') ?></h3>
<?= form_open('event/handleDetailsForm/' . $eventId) ?>
<div class="form-group">
	<div class="col">
		<label for="preborrel"><?= lang('Event.preborrel') ?></label>
	</div>
	<div class="col">
		<input type="radio" id="preborrel" name="preborrel" value="1" required <?= $edit_mode && $details->preborrel ? 'checked' : '' ?>> <?= lang('Event.yes'); ?>
		<input type="radio" name="preborrel" value="0" required <?= $edit_mode && !$details->preborrel ? 'checked' : '' ?>> <?= lang('Event.no'); ?>
	</div>
</div>
<div class="form-group">
	<div class="col">
		<label for="avondeten"><?= lang('Event.dinner') ?></label>
	</div>
	<div class="col">
		<input type="radio" id="avondeten" name="avondeten" value="1" required <?= $edit_mode && $details->avondeten ? 'checked' : '' ?>> <?= lang('Event.yes'); ?>
		<input type="radio" name="avondeten" value="0" required <?= $edit_mode && !$details->avondeten ? 'checked' : '' ?>> <?= lang('Event.no'); ?>
	</div>
</div>
<div class="form-group">
	<div class="col">
		<label for="feest"><?= lang('Event.party') ?></label>
	</div>
	<div class="col">
		<input type="radio" id="feest" name="feest" value="1" required <?= $edit_mode && $details->feest ? 'checked' : '' ?>> <?= lang('Event.yes'); ?>
		<input type="radio" name="feest" value="0" required <?= $edit_mode && !$details->feest ? 'checked' : '' ?>> <?= lang('Event.no'); ?>
	</div>
</div>
<div class="form-group">
	<div class="col">
		<label for="slapen"><?= lang('Event.sleep') ?></label>
	</div>
	<div class="col">
		<input type="radio" id="slapen" name="slapen" value="0" required <?= $edit_mode && $details->slapen == 0 ? 'checked' : '' ?>> <?= lang('Event.not'); ?>
		<input type="radio" id="slapen" name="slapen" value="1" required <?= $edit_mode && $details->slapen == 1 ? 'checked' : '' ?>> <?= lang('Event.friday') ?>
		<input type="radio" name="slapen" value="2" required <?= $edit_mode && $details->slapen == 2 ? 'checked' : '' ?>> <?= lang('Event.saturday') ?>
		<input type="radio" name="slapen" value="3" required <?= $edit_mode && $details->slapen == 3 ? 'checked' : '' ?>> <?= lang('Event.both') ?>
	</div>
</div>
<div class="form-group">
	<div class="col">
		<label for="groep_heen"><?= lang('Event.travelTo') ?></label>
	</div>
	<div class="col">
		<input type="radio" id="groep_heen" name="groep_heen" value="0" required <?= $edit_mode && $details->groep_heen == 0 ? 'checked' : '' ?>> <?= lang(
																																						'Event.yesFriday'
																																					) ?>
		<input type="radio" name="groep_heen" value="1" required <?= $edit_mode && $details->groep_heen == 1 ? 'checked' : '' ?>> <?= lang(
																																		'Event.yesSaturday'
																																	) ?>
		<input type="radio" name="groep_heen" value="2" required <?= $edit_mode && $details->groep_heen == 2 ? 'checked' : '' ?>> <?= lang('Event.no'); ?>
	</div>
</div>
<div class="form-group">
	<div class="col">
		<label for="groep_terug"><?= lang('Event.travelFrom') ?></label>
	</div>
	<div class="col">
		<input type="radio" id="groep_terug" name="groep_terug" value="0" required <?= $edit_mode && $details->groep_terug == 0 ? 'checked' : '' ?>> <?= lang(
																																							'Event.yesSaturday'
																																						) ?>
		<input type="radio" name="groep_terug" value="1" required <?= $edit_mode && $details->groep_terug == 1 ? 'checked' : '' ?>> <?= lang(
																																		'Event.yesSunday'
																																	) ?>
		<input type="radio" name="groep_terug" value="2" required <?= $edit_mode && $details->groep_terug == 2 ? 'checked' : '' ?>> <?= lang('Event.no'); ?>
	</div>
</div>
<div class="form-group">
	<div class="col">
		<label for="speciaal"><?= lang('Event.wishes') ?></label>
	</div>
	<div class="col">
		<input type="radio" id="speciaal" name="speciaal" value="1" required <?= $edit_mode && $details->speciaal ? 'checked' : '' ?>> <?= lang('Event.yes'); ?>
		<input type="radio" name="speciaal" value="0" required <?= $edit_mode && !$details->speciaal ? 'checked' : '' ?>> <?= lang('Event.no'); ?>
	</div>
</div>
<div class="form-group col">
	<button class="btn btn-primary btn-block"><?= lang('Event.save'); ?></button>
</div>
<?= form_close(); ?>
<?= $this->endSection(); ?>