<?= $this->extend('templates/admin') ?>
<?= $this->section('body') ?>
<div class="navigation-link">
	<a href="/admin/users/import"><b>Leden importeren&nbsp;<i aria-hidden="true" class="fa fa-plus-circle"></i></b></a><br>

	<a href="/admin/users/addFriend"><b>Vriend van Hydrofiel toevoegen&nbsp;<i aria-hidden="true" class="fa fa-user-plus"></i></b></a>
</div>
<div class="container-fluid">
	<div class="row">
		<div class="col-lg-6">
			<h2>Zwemmers</h2>
			<table class="table table-sm table-striped">
				<thead>
					<th>Naam</th>
					<th>Email</th>
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
	deleteButtons.forEach(button => button.addEventListener('click', showDeleteModal));

	/**
	 * Shows a modal before deletion.
	 */
	function showDeleteModal(event) {
		event.stopPropagation();

		const id = this.getAttribute('data-userId');

		showBSModal({
			title: "Weet je het zeker?",
			body: `Gebruiker zal verwijderd worden!`,
			actions: [{
				label: "Ja",
				cssClass: "btn-danger",
				onClick: () => deleteUser(id),
			}, {
				label: "Nee",
				cssClass: "btn-success",
				onClick: function(e) {
					$(e.target).parents(".modal").modal("hide");
				},
			}],
		});
	}

	/**
	 * Deletes a user by visiting the delete URL.
	 */
	function deleteUser(id) {
		window.location.replace(`/admin/users/delete/${ id }`);
	}
</script>
<?= $this->endSection() ?>