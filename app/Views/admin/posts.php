<?= $this->extend('templates/admin') ?>
<?= $this->section('body') ?>
<h3>Posts</h3>
<table class="table table-striped">
	<thead>
		<tr>
			<th>Titel</th>
			<th>Datum</th>
			<th>Beheer</th>
		</tr>
	</thead>
	<tbody>
		<?php if (isset($posts)) {
			foreach ($posts as $post) { ?>
				<tr>
					<td><?= $post->titleNL ?></td>
					<td><?= $post->timestamp->format('d-m-Y H:i') ?></td>
					<td>
						<a onclick="showModal('<?= $post->titleNL ?>', <?= $post->postId ?>)"><span class="fa fa-trash"></span></a>
					</td>
				</tr>
		<?php }
		} ?>
	</tbody>
</table>
<hr>
<h3>Post toevoegen</h3>
<?= form_open(); ?>
<div class="form-group">
	<div class="col-md-2">
		<label class="col-form-label" for="titleNL">Titel (NL)</label>
	</div>
	<div class="col-md-10">
		<input class="form-control" name="titleNL" id="titleNL" maxlength="175">
	</div>
</div>
<div class="form-group">
	<div class="col-md-2">
		<label class="col-form-label" for="summernote">Tekst (NL)</label>
	</div>
	<div class="col-md-10">
		<textarea id="summernote" name="textNL" id="textNL"></textarea>
	</div>
</div>
<div class="form-group">
	<div class="col-md-2">
		<label class="col-form-label" for="titleEN">Titel (EN)</label>
	</div>
	<div class="col-md-10">
		<input class="form-control" name="titleEN" id="titleEN" maxlength="175">
	</div>
</div>
<div class="form-group">
	<div class="col-md-2">
		<label class="col-form-label" for="engels">Tekst (EN)</label>
	</div>
	<div class="col-md-10">
		<textarea class="input-block-level" id="engels" name="textEN"></textarea>
	</div>
</div>
<div class="form-group">
	<div class="col-md-2">
		<label class="col-form-label" for="image">Plaatje</label>
	</div>
	<div class="col-md-10">
		<input class="form-control" name="image" id="image" maxlength="255"><br>
		<button class="btn btn-primary" type="submit">Post toevoegen</button>
	</div>
</div>
<?= form_close(); ?>
<script>
	function showModal(naam, postId) {
		showBSModal({
			title: "Weet je het zeker?",
			body: `De post ${ naam } zal verwijderd worden`,
			actions: [{
				label: "Ja",
				cssClass: "btn-danger",
				onClick: function(e) {
					window.location.assign(`/admin/posts/deletePost/${ postId }`);
				},
			}, {
				label: "Nee",
				cssClass: "btn-success",
				onClick: function(e) {
					$(e.target).parents(".modal").modal("hide");
				},
			}],
		});
	}
</script>
<?= $this->endSection() ?>