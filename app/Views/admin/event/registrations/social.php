<?php
use App\Entities\Registration;
/**
 * @var Registration $registrations
 */

 // Split out the registrations per group
 $waterpolo = array_filter( $registrations, function( Registration $registration ){
	return in_array( $registration->user->membership, ['waterpolo_recreatief', 'waterpolo_competitief'] );
 } );
 $swimmer = array_filter( $registrations, function( Registration $registration ){
	return $registration->user->membership === 'zwemmer';
 } );
$other = array_filter( $registrations, function( Registration $registration ){
	return in_array( $registration->user->membership, ['trainer', 'overig', 'vriend'] );
 } );
?>
<?= $this->extend('templates/admin') ?>
<?= $this->section('body') ?>
<div class="navigation-link"><a href="<?= previous_url() ?>"><b>Terug</b></a></div>
<h1>Aanmeldingen</h1>
<h2>Zwemmen (<?= sizeof($swimmer) ?>)</h2>
<table class="table table-striped">
	<thead>
		<tr>
			<th>Naam</th>
			<th>Datum</th>
			<th>Beheer</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach ($swimmer as $registration) { ?>
			<tr>
				<td class="clickable-row" data-href="/admin/events/registrationDetails/<?= $registration->eventId ?>/<?= $registration->userId ?>"><?= $registration->name ?></td>
				<td class="clickable-row" data-href="/admin/events/registrationDetails/<?= $registration->eventId ?>/<?= $registration->userId ?>"><?= $registration->registrationDate->format('d-m-Y H:i') ?></td>
				<td>
					<button aria-label="Delete registration" class="delete button--icon" data-memberName="<?= $registration->name ?>" data-eventId="<?= $registration->eventId ?>" data-userId="<?= $registration->userId ?>"><span class="fa fa-trash" aria-hidden="true"></span></button>
				</td>
			</tr>
		<?php } ?>
	</tbody>
</table>
<!-- Waterpolo registrations -->
<h2>Waterpolo (<?= sizeof($waterpolo) ?>)</h2>
<table class="table table-striped">
	<thead>
		<tr>
			<th>Naam</th>
			<th>Datum</th>
			<th>Beheer</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach ($waterpolo as $registration) { ?>
			<tr>
				<td class="clickable-row" data-href="/admin/events/registrationDetails/<?= $registration->eventId ?>/<?= $registration->userId ?>"><?= $registration->name ?></td>
				<td class="clickable-row" data-href="/admin/events/registrationDetails/<?= $registration->eventId ?>/<?= $registration->userId ?>"><?= $registration->registrationDate->format('d-m-Y H:i') ?></td>
				<td>
					<button aria-label="Delete registration" class="delete button--icon" data-memberName="<?= $registration->name ?>" data-eventId="<?= $registration->eventId ?>" data-userId="<?= $registration->userId ?>"><span class="fa fa-trash" aria-hidden="true"></span></button>
				</td>
			</tr>
		<?php } ?>
	</tbody>
</table>
<!-- Other registrations -->
<h2>Anders (<?= sizeof($other) ?>)</h2>
<table class="table table-striped">
	<thead>
		<tr>
			<th>Naam</th>
			<th>Datum</th>
			<th>Beheer</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach ($other as $registration) { ?>
			<tr>
				<td class="clickable-row" data-href="/admin/events/registrationDetails/<?= $registration->eventId ?>/<?= $registration->userId ?>"><?= $registration->name ?></td>
				<td class="clickable-row" data-href="/admin/events/registrationDetails/<?= $registration->eventId ?>/<?= $registration->userId ?>"><?= $registration->registrationDate->format('d-m-Y H:i') ?></td>
				<td>
					<button aria-label="Delete registration" class="delete button--icon" data-memberName="<?= $registration->name ?>" data-eventId="<?= $registration->eventId ?>" data-userId="<?= $registration->userId ?>"><span class="fa fa-trash" aria-hidden="true"></span></button>
				</td>
			</tr>
		<?php } ?>
	</tbody>
</table>
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