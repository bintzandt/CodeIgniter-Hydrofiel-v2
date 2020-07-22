<?= $this->extend('templates/admin') ?>
<?= $this->section('body') ?>
<?php $eventRoute = '/admin/events'; ?>
<div class="navigation-link"><a href="<?= $eventRoute ?>/addOrEdit"><b>Activiteit
			toevoegen</b></a></div>
<?php if (empty($upcomingEvents)) { ?>
	<b>Er zijn geen aankomende evenementen.</b>
<?php } else { ?>
	<table class="table">
		<thead>
			<tr>
				<th>Naam</th>
				<th>Datum</th>
				<th>Beheer</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($upcomingEvents as $event) {
				echo view('admin/event/partials/eventRow', ['event' => $event]);
			} ?>
		</tbody>
	</table>
<?php }
if (empty($passedEvents)) { ?>
	<b>Er zijn geen oude evenementen.</b>
<?php } else { ?>
	<h3>Oude evenementen</h3>
	<table class="table mb-0">
		<thead>
			<tr>
				<th>Naam</th>
				<th>Datum</th>
				<th>Beheer</th>
			</tr>
		</thead>
		<tbody id="oude_evenementen">
			<?php
			foreach ($passedEvents as $event) {
				echo view('admin/event/partials/eventRow', ['event' => $event]);
			} ?>
		</tbody>
	</table>
	<a onclick="showMore()">Laat meer oude evenementen zien</a>
<?php } ?>
<script>
	const hiddenPassedEvents = Array.from(document.querySelectorAll("#oude_evenementen tr"))
		.filter(oldEvent => oldEvent.className === "d-none");
	const deleteButtons = document.querySelectorAll(".delete");

	/**
	 * Displays the next 5 hidden events.
	 */
	function showMore() {
		for (let i = 0; i < 5; i++) {
			if (hiddenPassedEvents.length === 0) return;
			hiddenPassedEvents.shift().classList.remove("d-none");
		}
	}

	/** 
	 * Displays a model that warns about deleting.
	 */
	function showModal(event) {
		event.stopPropagation();
		
		showBSModal({
			title: "Weet je het zeker?",
			body: `Het evenement ${ this.getAttribute("data-name") } zal verwijderd worden!`,
			actions: [{
				label: "Ja",
				cssClass: "btn-danger",
				onClick: () => {
					window.location.assign(`/admin/events/delete/${ this.getAttribute("data-id") }`);
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
	deleteButtons.forEach(button => button.addEventListener('click', showModal));
</script>
<?= $this->endSection() ?>