<?= $this->extend('templates/default'); ?>

<?= $this->section('body') ?>
<h1><?= lang('Training.register') ?></h1>
<p><?= lang('Training.registrationHelp') ?></p>
<p><?= lang('Training.concerns') ?><b><?= lang('Training.cancel') ?></b></p>
<p><?= lang('Training.dataNotice') ?></p>
<h2><?= lang('Training.register' ) ?></h2>
<table class="table table-striped">
	<thead>
		<tr>
			<th><?= lang('Event.name') ?></th>
			<th><?= lang('Event.from') ?></th>
			<th><?= lang('Event.until') ?></th>
			<th><?= lang('Event.nrRegistrations') ?></th>
		</tr>
	</thead>
	<tbody>
		<?php
		foreach ($swimTrainings as $swimming_training) { ?>
			<tr class="clickable-row" data-href="/event/<?= $swimming_training->eventId ?>">
				<td><?= $swimming_training->name ?></td>
				<td><?= $swimming_training->from->format('d-m-Y H:i') ?></td>
				<td><?= $swimming_training->until->format('d-m-Y H:i') ?></td>
				<td><?= $swimming_training->nrOfRegistrations ?></td>
			</tr>
		<?php } ?>
	</tbody>
</table>
<h2>Waterpolo trainingen</h2>
<table class="table table-striped">
	<thead>
		<tr>
			<th><?= lang('Event.name') ?></th>
			<th><?= lang('Event.from') ?></th>
			<th><?= lang('Event.until') ?></th>
			<th><?= lang('Event.nrRegistrations') ?></th>
		</tr>
	</thead>
	<tbody>
		<?php
		foreach ($waterpoloTrainings as $waterpolo_training) { ?>
			<tr class="clickable-row" data-href="/event/<?= $waterpolo_training->eventId ?>">
				<td><?= $waterpolo_training->name ?></td>
				<td><?= $waterpolo_training->from->format('d-m-Y H:i') ?></td>
				<td><?= $waterpolo_training->until->format('d-m-Y H:i') ?></td>
				<td><?= $waterpolo_training->nrOfRegistrations ?></td>
			</tr>
		<?php } ?>
	</tbody>
</table>
<?= $this->endSection(); ?>