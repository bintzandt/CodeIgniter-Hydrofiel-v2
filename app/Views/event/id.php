<?= $this->extend('templates/default'); ?>

<?= $this->section('body') ?>
<?= \Config\Services::validation()->listErrors() ?>
<h3 align="center"><b><?= $event->name ?></b></h3>
<p><?= $event->description ?></p>
<div class="row">
	<div class="col-md-6">
		<br><br>
		<table style="width: 100%;">
			<?= view_cell('\App\Libraries\Event::displayRegistration', ['event' => $event]); ?>
		</table>
	</div>
	<div class="col-md-6">
		<h4>Details</h4>
		<table style="width:100%;">
			<tr>
				<td><b><?= lang('Event.from') ?></b></td>
				<td><?= $event->van->format('d-m-Y H:i') ?></td>
			</tr>
			<tr>
				<td><b><?= lang('Event.until') ?></b></td>
				<td><?= $event->tot->format('d-m-Y H:i') ?></td>
			</tr>
			<tr>
				<td><b><?= lang('Event.location'); ?></b></td>
				<td><?= $event->locatie ?></td>
			</tr>
			<?php if ($event->needsRegistration) { ?>
				<tr>
					<td><b><?= lang('Event.registrationDeadline') ?></b></td>
					<td><?= $event->inschrijfdeadline->format('d-m-Y H:i') ?></td>
				</tr>
				<tr>
					<td><b><?= lang('Event.cancelationDeadline') ?></b></td>
					<td><?= $event->afmelddeadline->format('d-m-Y H:i') ?></td>
				</tr>
				<?php if ($event->maximum > 0) { ?>
					<tr>
						<td><b><?= lang('Event.nrMaximum') ?></b></td>
						<td><?= $event->nrOfRegistrations . '/' . $event->maximum ?></td>
					</tr>
				<?php } else { ?>
					<tr>
						<td><b><?= lang('Event.nrMaximum') ?></b></td>
						<td><?= $event->nrOfRegistrations ?></td>
					</tr>
			<?php }
			} ?>
		</table>
	</div>
</div>
<div class="row pt-3">
	<div class="col">
		<?php
		// Check if the event allows registrations.
		if ($event->needsRegistration) { ?>
			<?= form_open(); ?>
			<?= view_cell('\App\Libraries\Event::displayForm', ['event' => $event]); ?>
			<?= form_close(); ?>
		<?php } else {
			info(lang('Event.noRegistrationsNeeded'));
		} ?>
	</div>
</div>
<?= $this->endSection(); ?>