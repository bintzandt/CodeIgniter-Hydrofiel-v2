<div class="form-group">
    <input type="text" name="remark" maxlength="20" class="form-control" style="margin-top: 20px"
           placeholder="<?= lang("Event.remark"); ?>">
</div>
<?php
if ($needsPayment) { ?>
    <div class="form-check">
        <input type="checkbox" class="form-check-input" required id="agreeToTerms">
        <label for="agreeToTerms" class="form-check-label"><?= lang('Event.agreeTerms') ?></label>
    </div>
<?php
} ?>
<div class="form-group">
    <button type="submit" class="btn btn-primary form-control"><?= lang('Event.register') ?></button>
</div>
