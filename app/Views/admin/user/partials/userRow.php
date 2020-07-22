<tr class="clickable-row" data-href="/user/<?= $member->id ?>">
	<td><?= $member->naam ?></td>
	<td><?= mailto( $member->email ); ?></td>
	<td><button class="delete button--icon" data-userId="<?= $member->id ?>" onclick="event.stopPropagation()"><i class="fa fa-trash" aria-hidden="true"></i></button>
</tr>