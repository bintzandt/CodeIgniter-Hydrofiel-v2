<?= $this->extend('templates/default'); ?>

<?= $this->section('title') ?>
<?= $page->name ?>
<?= $this->endSection(); ?>

<?= $this->section('body') ?>
<?= $page->text ?>
<?= $this->endSection() ?>
