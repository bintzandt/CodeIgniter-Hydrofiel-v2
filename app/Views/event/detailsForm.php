<?= $this->extend('templates/default'); ?>

<?= $this->section('body') ?>
<?= \Config\Services::validation()->listErrors() ?>
<h3><?= lang('Event.furtherInformation') ?></h3>
<?= form_open('event/handleDetailsForm/' . $eventId) ?>
<div class="form-group">
	<div class="col">
		<label for="attendPredrink"><?= lang('Event.preborrel') ?></label>
	</div>
	<div class="col">
		<input type="radio" id="attendPredrink" name="attendPredrink" value="1" required <?= $edit_mode && $details->attendPredrink ? 'checked' : '' ?>> <?= lang('Event.yes'); ?>
		<input type="radio" name="attendPredrink" value="0" required <?= $edit_mode && !$details->attendPredrink ? 'checked' : '' ?>> <?= lang('Event.no'); ?>
	</div>
</div>
<div class="form-group">
	<div class="col">
		<label for="attendDinner"><?= lang('Event.dinner') ?></label>
	</div>
	<div class="col">
		<input type="radio" id="attendDinner" name="attendDinner" value="1" required <?= $edit_mode && $details->attendDinner ? 'checked' : '' ?>> <?= lang('Event.yes'); ?>
		<input type="radio" name="attendDinner" value="0" required <?= $edit_mode && !$details->attendDinner ? 'checked' : '' ?>> <?= lang('Event.no'); ?>
	</div>
</div>
<div class="form-group">
	<div class="col">
		<label for="attendParty"><?= lang('Event.party') ?></label>
	</div>
	<div class="col">
		<input type="radio" id="attendParty" name="attendParty" value="1" required <?= $edit_mode && $details->attendParty ? 'checked' : '' ?>> <?= lang('Event.yes'); ?>
		<input type="radio" name="attendParty" value="0" required <?= $edit_mode && !$details->attendParty ? 'checked' : '' ?>> <?= lang('Event.no'); ?>
	</div>
</div>
<div class="form-group">
	<div class="col">
		<label for="requiresSleepAccommodation"><?= lang('Event.sleep') ?></label>
	</div>
	<div class="col">
		<input type="radio" id="requiresSleepAccommodation" name="requiresSleepAccommodation" value="0" required <?= $edit_mode && $details->requiresSleepAccommodation == 0 ? 'checked' : '' ?>> <?= lang('Event.not'); ?>
		<input type="radio" id="requiresSleepAccommodation" name="requiresSleepAccommodation" value="1" required <?= $edit_mode && $details->requiresSleepAccommodation == 1 ? 'checked' : '' ?>> <?= lang('Event.friday') ?>
		<input type="radio" name="requiresSleepAccommodation" value="2" required <?= $edit_mode && $details->requiresSleepAccommodation == 2 ? 'checked' : '' ?>> <?= lang('Event.saturday') ?>
		<input type="radio" name="requiresSleepAccommodation" value="3" required <?= $edit_mode && $details->requiresSleepAccommodation == 3 ? 'checked' : '' ?>> <?= lang('Event.both') ?>
	</div>
</div>
<div class="form-group">
	<div class="col">
		<label for="attendOutboundJourney"><?= lang('Event.travelTo') ?></label>
	</div>
	<div class="col">
		<input type="radio" id="attendOutboundJourney" name="attendOutboundJourney" value="0" required <?= $edit_mode && $details->attendOutboundJourney == 0 ? 'checked' : '' ?>> <?= lang(
																																						'Event.yesFriday'
																																					) ?>
		<input type="radio" name="attendOutboundJourney" value="1" required <?= $edit_mode && $details->attendOutboundJourney == 1 ? 'checked' : '' ?>> <?= lang(
																																		'Event.yesSaturday'
																																	) ?>
		<input type="radio" name="attendOutboundJourney" value="2" required <?= $edit_mode && $details->attendOutboundJourney == 2 ? 'checked' : '' ?>> <?= lang('Event.no'); ?>
	</div>
</div>
<div class="form-group">
	<div class="col">
		<label for="attendHomeboundJourney"><?= lang('Event.travelFrom') ?></label>
	</div>
	<div class="col">
		<input type="radio" id="attendHomeboundJourney" name="attendHomeboundJourney" value="0" required <?= $edit_mode && $details->attendHomeboundJourney == 0 ? 'checked' : '' ?>> <?= lang(
																																							'Event.yesSaturday'
																																						) ?>
		<input type="radio" name="attendHomeboundJourney" value="1" required <?= $edit_mode && $details->attendHomeboundJourney == 1 ? 'checked' : '' ?>> <?= lang(
																																		'Event.yesSunday'
																																	) ?>
		<input type="radio" name="attendHomeboundJourney" value="2" required <?= $edit_mode && $details->attendHomeboundJourney == 2 ? 'checked' : '' ?>> <?= lang('Event.no'); ?>
	</div>
</div>
<div class="form-group">
	<div class="col">
		<label for="requiresContactByBoard"><?= lang('Event.wishes') ?></label>
	</div>
	<div class="col">
		<input type="radio" id="requiresContactByBoard" name="requiresContactByBoard" value="1" required <?= $edit_mode && $details->requiresContactByBoard ? 'checked' : '' ?>> <?= lang('Event.yes'); ?>
		<input type="radio" name="requiresContactByBoard" value="0" required <?= $edit_mode && !$details->requiresContactByBoard ? 'checked' : '' ?>> <?= lang('Event.no'); ?>
	</div>
</div>
<div class="form-group col">
	<button class="btn btn-primary btn-block"><?= lang('Event.save'); ?></button>
</div>
<?= form_close(); ?>
<?= $this->endSection(); ?>