<?php $eventRegistrationLink = '/admin/event/registrations/' . $event->event_id; ?>
<tr class="clickable-row" data-href="<?= $eventRegistrationLink ?>">
	<td><?= $event->name ?></td>
	<td><?= $event->from->format('d-m-Y H:i') ?></td>
	<td>
		<a href="/admin/event/addOrEdit/<?= $event->event_id ?>"><i class="fa fa-edit"></i></a>
		<button class="delete button--icon" data-name="<?= $event->name ?>" data-id="<?= $event->event_id ?>" aria-label="Delete event"><i class="fa fa-trash" aria-hidden="true"></i></button>
	</td>
</tr>