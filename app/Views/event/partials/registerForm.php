<div class="form-group">
	<input type="text" name="opmerking" maxlength="20" class="form-control" style="margin-top: 20px" placeholder="<?= lang("Event.remark"); ?>">
	<?php if ($needsPayment) { ?>
		<input type="checkbox" required> <?= lang('Event.agreeTerms') ?>
	<?php } ?>
</div>
<div class="form-group">
	<button type="submit" class="btn btn-primary form-control"><?= lang('Event.register') ?></button>
</div>