<?php
foreach ($slagen as $slag) { ?>
	<div class="form-group">
		<div class="col-md-4">
			<label><?= $slag ?></label>
		</div>
		<div class="col-md-8">
			<input type="hidden" value="<?= $slag ?>" name="slag[]">
			<input type="text" class="form-control" name="tijd[]" placeholder="Tijd" />
		</div>
	</div>
<?php }