<?php

use Config\Services;

?>
<?= $this->extend('templates/default'); ?>

<?= $this->section('body') ?>
<?= Services::validation()->listErrors() ?>
    <h3><?= lang('Event.furtherInformation') ?></h3>
<?= form_open('event/handleDetailsForm/' . $eventId) ?>
    <div class="form-group">
        <label for="attendPredrink"><?= lang('Event.preborrel') ?></label><br>
        <div class="form-check form-check-inline">
            <label class="form-check-label"><input class="form-check-input" type="radio" id="attendPredrink"
                                                   name="attendPredrink" value="1"
                                                   required <?= $edit_mode && $details->attendPredrink ? 'checked' : '' ?>><?= lang(
                    'Event.yes'
                ); ?></label>
        </div>
        <div class="form-check form-check-inline">
            <label class="form-check-label"><input class="form-check-input" type="radio" name="attendPredrink" value="0"
                                                   required <?= $edit_mode && ! $details->attendPredrink ? 'checked' : '' ?>><?= lang(
                    'Event.no'
                ); ?></label>
        </div>
    </div>
    <div class="form-group">
        <label for="attendDinner"><?= lang('Event.dinner') ?></label><br>
        <div class="form-check form-check-inline">
            <label class="form-check-label"><input class="form-check-input" type="radio" id="attendDinner"
                                                   name="attendDinner" value="1"
                                                   required <?= $edit_mode && $details->attendDinner ? 'checked' : '' ?>><?= lang(
                    'Event.yes'
                ); ?></label>
        </div>
        <div class="form-check form-check-inline">
            <label class="form-check-label"><input class="form-check-input" type="radio" name="attendDinner" value="0"
                                                   required <?= $edit_mode && ! $details->attendDinner ? 'checked' : '' ?>><?= lang(
                    'Event.no'
                ); ?></label>
        </div>
    </div>
    <div class="form-group">
        <label for="attendParty"><?= lang('Event.party') ?></label><br>
        <div class="form-check form-check-inline">
            <label class="form-check-label"><input class="form-check-input" type="radio" id="attendParty"
                                                   name="attendParty" value="1"
                                                   required <?= $edit_mode && $details->attendParty ? 'checked' : '' ?>><?= lang(
                    'Event.yes'
                ); ?></label>
        </div>
        <div class="form-check form-check-inline">
            <label class="form-check-label"><input class="form-check-input" type="radio" name="attendParty" value="0"
                                                   required <?= $edit_mode && ! $details->attendParty ? 'checked' : '' ?>><?= lang(
                    'Event.no'
                ); ?></label>
        </div>
    </div>
    <div class="form-group">
        <label for="requiresSleepAccommodation"><?= lang('Event.sleep') ?></label><br>
        <div class="form-check form-check-inline">
            <label class="form-check-label"><input class="form-check-input" type="radio" id="requiresSleepAccommodation"
                                                   name="requiresSleepAccommodation" value="0"
                                                   required <?= $edit_mode && $details->requiresSleepAccommodation == 0 ? 'checked' : '' ?>><?= lang(
                    'Event.not'
                ); ?></label>
        </div>
        <div class="form-check form-check-inline">
            <label class="form-check-label"><input class="form-check-input" type="radio" id="requiresSleepAccommodation"
                                                   name="requiresSleepAccommodation" value="1"
                                                   required <?= $edit_mode && $details->requiresSleepAccommodation == 1 ? 'checked' : '' ?>><?= lang(
                    'Event.friday'
                ) ?></label>
        </div>
        <div class="form-check form-check-inline">
            <label class="form-check-label"><input class="form-check-input" type="radio"
                                                   name="requiresSleepAccommodation" value="2"
                                                   required <?= $edit_mode && $details->requiresSleepAccommodation == 2 ? 'checked' : '' ?>><?= lang(
                    'Event.saturday'
                ) ?></label>
        </div>
        <div class="form-check form-check-inline">
            <label class="form-check-label"><input class="form-check-input" type="radio"
                                                   name="requiresSleepAccommodation" value="3"
                                                   required <?= $edit_mode && $details->requiresSleepAccommodation == 3 ? 'checked' : '' ?>><?= lang(
                    'Event.both'
                ) ?></label>
        </div>
    </div>
    <div class="form-group">
        <label for="attendOutboundJourney"><?= lang('Event.travelTo') ?></label><br>
        <div class="form-check form-check-inline">
            <label class="form-check-label"><input class="form-check-input" type="radio" id="attendOutboundJourney"
                                                   name="attendOutboundJourney" value="0"
                                                   required <?= $edit_mode && $details->attendOutboundJourney == 0 ? 'checked' : '' ?>><?= lang(
                    'Event.yesFriday'
                ) ?></label>
        </div>
        <div class="form-check form-check-inline">
            <label class="form-check-label"><input class="form-check-input" type="radio" name="attendOutboundJourney"
                                                   value="1"
                                                   required <?= $edit_mode && $details->attendOutboundJourney == 1 ? 'checked' : '' ?>><?= lang(
                    'Event.yesSaturday'
                ) ?></label>
        </div>
        <div class="form-check form-check-inline">
            <label class="form-check-label"><input class="form-check-input" type="radio" name="attendOutboundJourney"
                                                   value="2"
                                                   required <?= $edit_mode && $details->attendOutboundJourney == 2 ? 'checked' : '' ?>><?= lang(
                    'Event.no'
                ); ?></label>
        </div>
    </div>
    <div class="form-group">
        <label for="attendHomeboundJourney"><?= lang('Event.travelFrom') ?></label><br>
        <div class="form-check form-check-inline">
            <label class="form-check-label"><input class="form-check-input" type="radio" id="attendHomeboundJourney"
                                                   name="attendHomeboundJourney" value="0"
                                                   required <?= $edit_mode && $details->attendHomeboundJourney == 0 ? 'checked' : '' ?>><?= lang(
                    'Event.yesSaturday'
                ) ?></label>
        </div>
        <div class="form-check form-check-inline">
            <label class="form-check-label"><input class="form-check-input" type="radio" name="attendHomeboundJourney"
                                                   value="1"
                                                   required <?= $edit_mode && $details->attendHomeboundJourney == 1 ? 'checked' : '' ?>><?= lang(
                    'Event.yesSunday'
                ) ?></label>
        </div>
        <div class="form-check form-check-inline">
            <label class="form-check-label"><input class="form-check-input" type="radio" name="attendHomeboundJourney"
                                                   value="2"
                                                   required <?= $edit_mode && $details->attendHomeboundJourney == 2 ? 'checked' : '' ?>><?= lang(
                    'Event.no'
                ); ?></label>
        </div>
    </div>
    <div class="form-group">
        <label for="requiresContactByBoard"><?= lang('Event.wishes') ?></label><br>
        <div class="form-check form-check-inline">
            <label class="form-check-label"><input class="form-check-input" type="radio" id="requiresContactByBoard"
                                                   name="requiresContactByBoard" value="1"
                                                   required <?= $edit_mode && $details->requiresContactByBoard ? 'checked' : '' ?>><?= lang(
                    'Event.yes'
                ); ?></label>
        </div>
        <div class="form-check form-check-inline">
            <label class="form-check-label"><input class="form-check-input" type="radio" name="requiresContactByBoard"
                                                   value="0"
                                                   required <?= $edit_mode && ! $details->requiresContactByBoard ? 'checked' : '' ?>><?= lang(
                    'Event.no'
                ); ?></label>
        </div>
        <textarea type="text" name="additionalComment"
                  class="form-control <?= $details->requiresContactByBoard ? '' : 'd-none' ?>"
                  style="resize: none;"><?= $edit_mode && $details->requiresContactByBoard ? $details->additionalComment : '' ?></textarea>
    </div>
    <div class="form-group">
        <button class="btn btn-primary form-control"><?= lang('Event.save'); ?></button>
    </div>
<?= form_close(); ?>
    <script>
        const checkboxes = document.querySelectorAll('input[name="requiresContactByBoard"]');
        const textInput = document.querySelector('textarea');

        function handleContactChange() {
            textInput.classList[this.value === '1' ? 'remove' : 'add']('d-none');
        }

        function autoGrow(textField) {
            if (textField.clientHeight < textField.scrollHeight) {
                textField.style.height = textField.scrollHeight + "px";
                if (textField.clientHeight < textField.scrollHeight) {
                    textField.style.height =
                        (textField.scrollHeight * 2 - textField.clientHeight) + "px";
                }
            }
        }

        checkboxes.forEach(checkbox => checkbox.addEventListener('change', handleContactChange));
        textInput.addEventListener('input', () => autoGrow(textInput));
        autoGrow(textInput);
    </script>
<?= $this->endSection(); ?>
