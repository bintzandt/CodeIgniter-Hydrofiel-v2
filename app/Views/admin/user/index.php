<?= $this->extend('templates/admin') ?>
<?= $this->section('body') ?>
<div align="right" style="padding: 20px"><a href="/admin/user/import"><b>Leden importeren</b></a></div>
<div class="container-fluid">
	<div class="row">
		<div class="col-lg-6">
			<h2>Zwemmers</h2>
			<table class="table table-sm table-striped">
				<thead>
					<th>Naam</th>
					<th>Email</th>
					<th>Verwijder</th>
				</thead>
				<tbody>
					<?php foreach ($swimmers as $member) {
						echo view('admin/user/partials/userRow', ['member' => $member]);
					} ?>
				</tbody>
			</table>
		</div>
		<div class="col-lg-6">
			<h2>Waterpolo</h2>
			<table class="table table-sm table-striped table-hover">
				<thead>
					<th>Naam</th>
					<th>Email</th>
					<th>Verwijder</th>
				</thead>
				<tbody>
					<?php foreach ($waterpoloers as $member) {
						echo view('admin/user/partials/userRow', ['member' => $member]);
					} ?>
				</tbody>
			</table>
		</div>
	</div>
	<div class="row">
		<div class="col-lg-6">
			<h2>Trainers</h2>
			<table class="table table-sm table-striped">
				<thead>
					<th>Naam</th>
					<th>Email</th>
					<th>Verwijder</th>
				</thead>
				<tbody>
					<?php foreach ($trainers as $member) {
						echo view('admin/user/partials/userRow', ['member' => $member]);
					} ?>
				</tbody>
			</table>
		</div>
		<div class="col-lg-6">
			<h2>Vrienden van Hydrofiel</h2>
			<table class="table table-sm table-striped table-hover">
				<thead>
					<th>Naam</th>
					<th>Email</th>
					<th>Verwijder</th>
				</thead>
				<tbody>
					<?php foreach ($friends as $member) {
						echo view('admin/user/partials/userRow', ['member' => $member]);
					} ?>
				</tbody>
			</table>
		</div>
	</div>
</div>
<script>
	const deleteButtons = document.querySelectorAll('.delete');
	deleteButtons.forEach( button => button.addEventListener('click', deleteUser));

	function deleteUser(){
		const id = this.getAttribute('data-userId');
		window.location.replace(`/admin/user/delete/${ id }`);
	}
</script>
<?= $this->endSection() ?>