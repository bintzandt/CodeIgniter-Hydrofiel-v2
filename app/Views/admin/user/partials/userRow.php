<tr class="clickable-row" data-href="/user/<?= $member->userId ?>">
	<td><?= $member->name ?></td>
	<td><?= mailto( $member->email ); ?></td>
	<?php if ($member->membership === lang('User.friend')) {?>
		<td><button class="delete button--icon" data-userId="<?= $member->userId ?>"><i class="fa fa-trash" aria-hidden="true"></i></button>
	<?php } ?>
</tr>