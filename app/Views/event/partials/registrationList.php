<?php $i = -0;
foreach ($registrations as $registration) {
	$i++;
	if ($i <= 5) { ?>
		<tr>
			<td><?= $registration->naam ?></td>
			<?php if ($registration->opmerking !== "") { ?>
				<td><?= $registration->opmerking ?></td> <?php } ?>
		</tr>
	<?php } else { ?>
		<tr class="inschrijving d-none">
			<td><?= $registration->naam ?></td>
			<?php if ($registration->opmerking !== "") { ?>
				<td><?= $registration->opmerking ?></td> <?php } ?>
		</tr>
	<?php }
} ?>