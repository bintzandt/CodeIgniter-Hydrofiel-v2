<?= $this->extend('templates/default'); ?>

<?= $this->section('title') ?>
<?= lang('Event.title'); ?>
<?= $this->endSection() ?>

<?= $this->section('body') ?>
    <h1><?= lang('Event.title') ?></h1>
    <table class="table table-striped table-responsive-sm">
        <thead>
        <tr>
            <th scope="col"><?= lang('Event.name') ?></th>
            <th scope="col"><?= lang('Event.date') ?></th>
            <th class="d-none d-sm-table-cell" scope="col"><?= lang('Event.nrRegistrations') ?></th>
            <th class="d-none d-sm-table-cell" scope="col"><?= lang('Event.type') ?></th>
        </tr>
        </thead>
        <tbody>
        <?php
        foreach ($events as $event) {
            $eventUrl = sprintf('/event/%s', $event->eventId); ?>
            <tr scope="row" class="clickable-row" data-href="<?= $eventUrl ?>">
                <td><?= $event->name ?></td>
                <td><?= $event->from->format('d-m-Y H:i') ?></td>
                <td class="d-none d-sm-table-cell"><?= $event->nrOfRegistrations . (($event->maximumRegistrations > 0) ? '/' . $event->maximumRegistrations : '') ?></td>
                <td class="d-none d-sm-table-cell"><?= lang(sprintf('Event.%s', $event->kind)) ?></td>
            </tr>
        <?php
        } ?>
        </tbody>
    </table>
<?= $this->endSection() ?>
