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
			$eventUrl = sprintf('/event/%s', $event->eventId ); ?>
			<tr class="clickable-row" data-href="<?= $eventUrl ?>">
				<td><?= $event->name ?></td>
				<td><?= $event->from->format('d-m-Y H:i') ?></td>
				<td><?= $event->nrOfRegistrations . (($event->maximumRegistrations > 0) ? '/' . $event->maximumRegistrations : '') ?></td>
				<td><?= ucwords($event->kind) ?></td>
			</tr>
		<?php } ?>
	</tbody>
</table>
<?= $this->endSection() ?>