<?= $this->extend('templates/admin') ?>
<?= $this->section('body') ?>
<div class="navigation-link"><a href="/admin/events"><b>Terug</b></a></div>
<?php if (isset($error)) { ?>
	<b>Er zijn geen inschrijvingen voor dit evenement of voor dit evenement kan niet worden ingeschreven.</b>
<?php } else { ?>
	<table class="table table-striped">
		<thead>
			<tr>
				<th>Naam</th>
				<th>Datum</th>
				<th>Beheer</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($registrations as $registration) { ?>
				<tr>
					<td class="clickable-row" data-href="/admin/events/registrationDetails/<?= $registration->event_id ?>/<?= $registration->member_id ?>"><?= $registration->name ?></td>
					<td class="clickable-row" data-href="/admin/events/registrationDetails/<?= $registration->event_id ?>/<?= $registration->member_id ?>"><?= $registration->datum->format('d-m-Y H:i') ?></td>
					<td>
						<button aria-label="Delete registration"  class="delete button--icon" data-memberName="<?= $registration->name ?>" data-eventId="<?= $registration->event_id ?>" data-userId="<?= $registration->member_id ?>"><span class="fa fa-trash" aria-hidden="true"></span></button>
					</td>e
				</tr>
			<?php } ?>
		</tbody>
	</table>
<?php } ?>
<script>
	// Find all delete buttons and attach an eventHandler for the click action.
	const deleteButtons = document.querySelectorAll('.delete');
	deleteButtons.forEach(button => button.addEventListener('click', showDeleteRegistrationModal));

	/**
	 * Shows a modal that warns before deletion of the registration.
	 */
	function showDeleteRegistrationModal() {
		const name = this.getAttribute('data-memberName');
		const eventId = this.getAttribute('data-eventId');
		const userId = this.getAttribute('data-userId');
		showBSModal({
			title: "Weet je het zeker?",
			body: `De inschrijving van ${ name } zal verwijderd worden!`,
			actions: [{
				label: "Ja",
				cssClass: "btn-danger",
				onClick: function() {
					window.location.assign(`/admin/events/cancelRegistration/${ eventId }/${ userId }`);
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