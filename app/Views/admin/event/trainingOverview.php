<?= $this->extend('templates/admin') ?>
<?= $this->section('body') ?>
<?php
/**
 * @var {Event[]} $waterpoloTrainings
 * @var {Event[]} $swimTrainings
 */

?>
<?= $this->extend('templates/admin') ?>
<?= $this->section('body') ?>
    <h1>Oude trainingen</h1>
<?php
if (empty($swimTrainings)) { ?>
    <p><b>Er zijn geen oude zwemtrainingen.</b></p>
<?php
} else { ?>
    <h2>Zwemmen</h2>
    <table class="table mb-0">
        <thead>
        <tr>
            <th>Naam</th>
            <th>Datum</th>
        </tr>
        </thead>
        <tbody>
        <?php
        foreach ($swimTrainings as $event) {
            $eventRegistrationOverview = '/admin/events/registrations/' . $event->eventId; ?>
            <tr class="clickable-row" data-href="<?= $eventRegistrationOverview ?>">
                <td><?= $event->name ?></td>
                <td><?= $event->from->format('d-m-Y H:i') ?></td>
            </tr>
        <?php
        } ?>
        </tbody>
    </table>
<?php
} ?>
<?php
if (empty($waterpoloTrainings)) { ?>
    <p><b>Er zijn geen oude waterpolotrainingen.</b></p>
<?php
} else { ?>
    <h2>Waterpolo</h2>
    <table class="table mb-0">
        <thead>
        <tr>
            <th>Naam</th>
            <th>Datum</th>
        </tr>
        </thead>
        <tbody>
        <?php
        foreach ($waterpoloTrainings as $event) {
            $eventRegistrationOverview = '/admin/events/registrations/' . $event->eventId; ?>
            <tr class="clickable-row" data-href="<?= $eventRegistrationOverview ?>">
                <td><?= $event->name ?></td>
                <td><?= $event->from->format('d-m-Y H:i') ?></td>
            </tr>
        <?php
        } ?>
        </tbody>
    </table>
<?php
} ?>
<?= $this->endSection() ?>
