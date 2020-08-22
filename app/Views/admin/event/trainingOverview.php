<?= $this->extend('templates/admin') ?>
<?= $this->section('body') ?>
<?php
/**
 * @var {Event[]} $trainings
 */
?>
<?= $this->extend('templates/admin') ?>
<?= $this->section('body') ?>
<?php if (empty($traingings)) { ?>
	<b>Er zijn geen oude trainingen.</b>
<?php } else { ?>
	<h3>Oude trainingen</h3>
	<table class="table mb-0">
		<thead>
			<tr>
				<th>Naam</th>
				<th>Datum</th>
			</tr>
		</thead>
		<tbody id="oude_evenementen">
			<?php
			foreach ($trainings as $event) {
				$eventRegistrationLink = '/admin/events/registrations/' . $event->eventId; ?>
				<tr class="clickable-row" data-href="<?= $eventRegistrationLink ?>">
					<td><?= $event->name ?></td>
					<td><?= $event->from->format('d-m-Y H:i') ?></td>
				</tr>
			<?php } ?>
		</tbody>
	</table>
<?php } ?>
<?= $this->endSection() ?>