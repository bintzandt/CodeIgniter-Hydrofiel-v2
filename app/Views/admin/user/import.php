<?= $this->extend('templates/admin') ?>
<?= $this->section('body') ?>

<div style="text-align:right; vertical-align: top; padding: 20px;"><a href="/admin/users"><b>Terug</b></a></div>
<?= form_open_multipart(); ?>
<input type="file" name="users" size="20" />
<br /><br />
<input type="submit" class="btn btn-primary" value="Importeren" />
<?= form_close() ?>

<?= $this->endSection() ?>