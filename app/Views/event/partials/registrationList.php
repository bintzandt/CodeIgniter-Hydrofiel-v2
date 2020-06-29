<?php $i = -0;
foreach ($registrations as $registration) {
	$i++;
	if ($i <= 5) { ?>
		<tr>
			<td><?= $registration->name ?></td>
			<?php if ($registration->remark !== "") { ?>
				<td><?= $registration->remark ?></td> <?php } ?>
		</tr>
	<?php } else { ?>
		<tr class="inschrijving d-none">
			<td><?= $registration->name ?></td>
			<?php if ($registration->remark !== "") { ?>
				<td><?= $registration->remark ?></td> <?php } ?>
		</tr>
	<?php }
} ?>