<?php
if (! isset($slagen) || ! is_array($slagen)){
	return;
}
foreach ($slagen as $slag) {
	if ($slag === ""){
		continue;
	} ?>
	<div class="form-group">
		<div class="col-md-4">
			<label><?= $slag ?></label>
		</div>
		<div class="col-md-8">
			<input type="hidden" value="<?= $slag ?>" name="slag[]" />
			<input type="text" class="form-control" name="tijd[]" placeholder="Tijd" />
		</div>
	</div>
<?php }