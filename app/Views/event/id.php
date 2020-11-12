<?php

use Config\Services;

?>
<?= $this->extend('templates/default'); ?>

<?= $this->section('body') ?>
<?= Services::validation()->listErrors() ?>
    <h3 align="center"><b><?= $event->name ?></b></h3>
    <p><?= $event->description ?></p>
    <div class="row">
        <div class="col-md-6"><br/><br/>
            <?= view_cell('\App\Libraries\Event::displayRegistration', ['event' => $event]); ?>
        </div>
        <div class="col-md-6">
            <h4>Details</h4>
            <table class="table table-borderless table-sm">
                <tr>
                    <td><b><?= lang('Event.from') ?></b></td>
                    <td><?= $event->from->format('d-m-Y H:i') ?></td>
                </tr>
                <tr>
                    <td><b><?= lang('Event.until') ?></b></td>
                    <td><?= $event->until->format('d-m-Y H:i') ?></td>
                </tr>
                <tr>
                    <td><b><?= lang('Event.location'); ?></b></td>
                    <td><?= $event->location ?></td>
                </tr>
                <?php
                if ($event->needsRegistration) { ?>
                    <tr>
                        <td><b><?= lang('Event.registrationDeadline') ?></b></td>
                        <td><?= $event->registrationDeadline->format('d-m-Y H:i') ?></td>
                    </tr>
                    <tr>
                        <td><b><?= lang('Event.cancelationDeadline') ?></b></td>
                        <td><?= $event->cancellationDeadline->format('d-m-Y H:i') ?></td>
                    </tr>
                    <?php
                    if ($event->maximumRegistrations > 0) { ?>
                        <tr>
                            <td><b><?= lang('Event.nrMaximum') ?></b></td>
                            <td><?= $event->nrOfRegistrations . '/' . $event->maximumRegistrations ?></td>
                        </tr>
                    <?php
                    } else { ?>
                        <tr>
                            <td><b><?= lang('Event.nrMaximum') ?></b></td>
                            <td><?= $event->nrOfRegistrations ?></td>
                        </tr>
                    <?php
                    }
                } ?>
            </table>
        </div>
    </div>
    <div class="row pt-3">
        <div class="col">
            <?php
            // Check if the event allows registrations.
            if ($event->needsRegistration) { ?>
                <?= form_open(); ?>
                <?= view_cell('\App\Libraries\Event::displayForm', ['event' => $event]); ?>
                <?= form_close(); ?>
            <?php
            } else {
                info(lang('Event.noRegistrationsNeeded'));
            } ?>
        </div>
    </div>
<?= $this->endSection(); ?>
