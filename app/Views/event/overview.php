<?= $this->extend('templates/default'); ?>

<?= $this->section('body') ?>
<h1><?= lang('Event.title') ?></h1>
<table class="table table-striped">
	<thead>
		<tr>
			<th><?= lang('Event.name') ?></th>
			<th><?= lang('Event.date') ?></th>
			<th><?= lang('Event.nrRegistrations') ?></th>
			<th><?= lang('Event.type') ?></th>
		</tr>
	</thead>
	<tbody>
		<?php foreach ($events as $event) {
			$eventUrl = sprintf('/event/%s', $event->event_id ); ?>
			<tr class="clickable-row" data-href="<?= $eventUrl ?>">
				<td><?= $event->name ?></td>
				<td><?= $event->van->format('d-m-Y H:i') ?></td>
				<td><?= $event->nrOfRegistrations . (($event->maximum > 0) ? '/' . $event->maximum : '') ?></td>
				<td><?= ucwords($event->soort) ?></td>
			</tr>
		<?php } ?>
	</tbody>
</table>
<?= $this->endSection() ?>