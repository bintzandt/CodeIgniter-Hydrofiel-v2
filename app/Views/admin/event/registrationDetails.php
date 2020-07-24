<?= $this->extend('templates/admin') ?>
<?= $this->section('body') ?>
<div class="navigation-link"><a href="/admin/events/registrations/<?= $eventId ?>"><b>Terug</b></a></div>
<?= form_open(); ?>
<div class="form-group">
    <div class="col-md-4">
        <label class="col-form-label" for="naam">Naam</label>
    </div>
    <div class="col-md-8">
        <input disabled id="naam" class="form-control" type="text" value="<?= $inschrijving->name ?>">
    </div>
</div>
<div class="form-group">
    <div class="col-md-4">
        <label class="col-form-label" for="opmerking">Opmerking</label>
    </div>
    <div class="col-md-8">
        <input disabled id="opmerking" class="form-control" type="text" value="<?= $inschrijving->remark ?>">
    </div>
</div>
<div class="<?= ($nszk) ? '' : 'd-none' ?>">
    <?php if (!empty($strokes)) { ?>
		<hr>
		<h3>strokes</h3><br>
        <?php foreach ($strokes as $slag => $tijd) { ?>
            <div class="form-group">
                <div class="col-md-4">
                    <label class="col-form-label"><?= $slag ?></label>
                </div>
                <div class="col-md-8">
                    <input disabled class="form-control" type="text" value="<?= $tijd ?>">
                </div>
            </div>
        <?php }
    }
    if (!empty($details)) { ?>
        <hr>
        <h3>Details</h3><br>
        <div class="form-group">
            <div class="col-md-4">
                <label for="attendPredrink">Ik ga mee naar de preborrel</label>
            </div>
            <div class="col-md-8">
                <input type="radio" id="attendPredrink" name="attendPredrink" value="1"
                       disabled <?= ($details->attendPredrink) ? 'checked' : '' ?>> Ja
                <input type="radio" name="attendPredrink" value="0"
                       disabled <?= (!$details->attendPredrink) ? 'checked' : '' ?>> Nee
            </div>
        </div>
        <div class="form-group">
            <div class="col-md-4">
                <label for="attendDinner">Ik eet 's avonds mee</label>
            </div>
            <div class="col-md-8">
                <input type="radio" id="attendDinner" name="attendDinner" value="1"
                       disabled <?= ($details->attendDinner) ? 'checked' : '' ?>> Ja
                <input type="radio" name="attendDinner" value="0"
                       disabled <?= (!$details->attendDinner) ? 'checked' : '' ?>> Nee
            </div>
        </div>
        <div class="form-group">
            <div class="col-md-4">
                <label for="attendParty">Ik ga mee naar het feest</label>
            </div>
            <div class="col-md-8">
                <input type="radio" id="attendParty" name="attendParty" value="1"
                       disabled <?= ($details->attendParty) ? 'checked' : '' ?>> Ja
                <input type="radio" name="attendParty" value="0" disabled <?= (!$details->attendParty) ? 'checked' : '' ?>> Nee
            </div>
        </div>
        <div class="form-group">
            <div class="col-md-4">
                <label for="requiresSleepAccommodation">Ik zou graag op de volgende dagen blijven slapen</label>
            </div>
            <div class="col-md-8">
                <input type="radio" id="requiresSleepAccommodation" name="requiresSleepAccommodation" value="0"
                       disabled <?= ($details->requiresSleepAccommodation === '0') ? 'checked' : '' ?>> Niet
                <input type="radio" id="requiresSleepAccommodation" name="requiresSleepAccommodation" value="1"
                       disabled <?= ($details->requiresSleepAccommodation === '1') ? 'checked' : '' ?>> Vrijdag
                <input type="radio" name="requiresSleepAccommodation" value="2"
                       disabled <?= ($details->requiresSleepAccommodation === '2') ? 'checked' : '' ?>> Zaterdag
                <input type="radio" name="requiresSleepAccommodation" value="3"
                       disabled <?= ($details->requiresSleepAccommodation === '3') ? 'checked' : '' ?>> Beide
            </div>
        </div>
        <div class="form-group">
            <div class="col-md-4">
                <label for="attendOutboundJourney">Ik zou graag met de groep heen willen reizen</label>
            </div>
            <div class="col-md-8">
                <input type="radio" id="attendOutboundJourney" name="attendOutboundJourney" value="0"
                       disabled <?= ($details->attendOutboundJourney === '0') ? 'checked' : '' ?>> Ja, met een groep op vrijdag
                <input type="radio" name="attendOutboundJourney" value="1"
                       disabled <?= ($details->groepattendOutboundJourney_heen === '1') ? 'checked' : '' ?>> Ja, met een groep op zaterdag
                <input type="radio" name="attendOutboundJourney" value="2"
                       disabled <?= ($details->attendOutboundJourney === '2') ? 'checked' : '' ?>> Nee
            </div>
        </div>
        <div class="form-group">
            <div class="col-md-4">
                <label for="attendHomeboundJourney">Ik zou graag met de groep terug willen reizen</label>
            </div>
            <div class="col-md-8">
                <input type="radio" id="attendHomeboundJourney" name="attendHomeboundJourney" value="0"
                       disabled <?= ($details->attendHomeboundJourney === '0') ? 'checked' : '' ?>> Ja, met een groep op zaterdag
                <input type="radio" name="attendHomeboundJourney" value="1"
                       disabled <?= ($details->attendHomeboundJourney === '1') ? 'checked' : '' ?>> Ja, met een groep op zondag
                <input type="radio" name="attendHomeboundJourney" value="2"
                       disabled <?= ($details->attendHomeboundJourney === '2') ? 'checked' : '' ?>> Nee
            </div>
        </div>
        <div class="form-group">
            <div class="col-md-4">
                <label for="requiresContactByBoard">Heb je nog speciale wensen (dieet, vegetarisch..) waarover het bestuur contact
                    moet opnemen?</label>
            </div>
            <div class="col-md-8">
                <input type="radio" id="requiresContactByBoard" name="requiresContactByBoard" value="1"
                       disabled <?= ($details->requiresContactByBoard) ? 'checked' : '' ?>> Ja
                <input type="radio" name="requiresContactByBoard" value="0" disabled <?= (!$details->requiresContactByBoard) ? 'checked' : '' ?>>
                Nee
            </div>
        </div>
    <?php } ?>
</div>
<?= form_close() ?>
<?= $this->endSection() ?>