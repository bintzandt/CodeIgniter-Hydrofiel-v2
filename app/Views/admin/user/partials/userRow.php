<tr class="clickable-row" data-href="/user/<?= $member->id ?>">
	<td><?= $member->naam ?></td>
	<td><?= mailto( $member->email ); ?></td>
	<?php if ($member->membership === lang('User.friend')) {?>
		<td><button class="delete button--icon" data-userId="<?= $member->id ?>"><i class="fa fa-trash" aria-hidden="true"></i></button>
	<?php } ?>
</tr>