<table>
	<?php
	$i = 0;
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
</table>
<?php if ($i >= 6) { ?>
	<button class="button--icon" id="showAll" onclick="showAll()"><?= lang('Event.showRegistrations') ?></button>
	<button id="hideAll" class="button--icon d-none" onclick="hideAll()"><?= lang('Event.hideRegistrations') ?></button>
<?php } ?>