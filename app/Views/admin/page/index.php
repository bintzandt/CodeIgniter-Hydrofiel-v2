<?= $this->extend('templates/admin') ?>
<?= $this->section('body') ?>
<?php
function get_status($bereikbaar, $zichtbaar, $ingelogd) {
	$status = '';
	if ($bereikbaar == 'nee') {
		return '<i class="fa fa-exclamation-circle">';
	}

	if ($zichtbaar == 'ja') {
		$status .= '<i class="fa fa-check">';
	} else {
		$status .= '<i class="fa fa-eye-slash">';
	}

	if ($ingelogd) {
		$status .= '<i class="fa fa-key">';
	}

	return $status;
}

?>
<div align="right" style="padding: 20px"><a href="/admin/pages/add"><b>Pagina Toevoegen</b></a></div>
<table class="table table-sm table-striped table-hover">
	<thead>
		<tr>
			<th>Pagina naam</th>
			<th class="d-xs-none">Status</th>
			<th>Beheer</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach ($pages as $hoofd) { ?>
			<tr>
				<td class="clickable-row" data-href="/admin/pages/edit/<?= $hoofd->id ?>" style="padding-right: 0;"><?= $hoofd->naam ?></td>
				<td class="d-xs-none"><?= get_status($hoofd->bereikbaar, $hoofd->zichtbaar, $hoofd->ingelogd) ?></td>
				<td><?= form_open(''); ?>
					<!-- <a href="/admin/pages/up/<?= $hoofd->id ?>"><i class="fa fa-arrow-up"></i></a> -->
					<!-- <a href="/admin/pages/down/<?= $hoofd->id ?>"><i class="fa fa-arrow-down"></i></a> -->
					<a href="/admin/pages/edit/<?= $hoofd->id ?>"><i class="fa fa-pencil-alt"></i></a>
					<button type="button" class="delete button--icon" data-pageName="<?= $hoofd->naam ?>" data-pageId="<?= $hoofd->id ?>"><i class="fa fa-trash"></i></button>
					<?= form_close() ?>
				</td>
			</tr>
			<?php if ($hoofd->subPages !== null) {
				foreach ($hoofd->subPages as $sub) { ?>
					<tr>
						<td class="clickable-row pl-4" data-href="/admin/pages/edit/<?= $sub->id ?>"><?= $sub->naam ?></td>
						<td class="d-xs-none"><?= get_status($sub->bereikbaar, $sub->zichtbaar, $sub->ingelogd) ?></td>
						<td><?= form_open(''); ?>
							<!-- <a href="/admin/pages/up/<?= $sub->id ?>"><i class="fa fa-arrow-up"></i></a> -->
							<!-- <a href="/admin/pages/down/<?= $sub->id ?>"><i class="fa fa-arrow-down"></i></a> -->
							<a href="/admin/pages/edit/<?= $sub->id ?>"><i class="fa fa-pencil-alt"></i></a>
							<button type="button" class="delete button--icon" data-pageName="<?= $sub->naam ?>" data-pageId="<?= $sub->id ?>"><i class="fa fa-trash"></i></button>
							<?= form_close(); ?>
						</td>
					</tr>
		<?php }
			}
		} ?>
	</tbody>
</table>
<table>
	<tr>
		<th>Legenda</th>
	</tr>
	<tr>
		<td colspan="4" style="border-bottom: 2px solid #000000;"></td>
	</tr>
	<tr>
		<td colspan="3">
			<table width="100%">
				<tr>
					<td><i class="fa fa-check"></i></td>
					<td>Pagina zichtbaar in menu</td>
				</tr>
				<tr>
					<td><i class="fa fa-key"></i></td>
					<td>Je moet ingelogd zijn om pagina te bereiken</td>
				</tr>
				<tr>
					<td><i class="fa fa-eye-slash"></i></td>
					<td>Pagina niet zichtbaar in menu</td>
				</tr>
				<tr>
					<td><i class="fa fa-exclamation-circle"></i></td>
					<td>Deze pagina kan niet gezien worden</td>
				</tr>
				<tr>
					<td><i class="fa fa-pencil-alt"></i></td>
					<td>Pagina bewerken</td>
				</tr>
				<tr>
					<td><i class="fa fa-trash"></i></td>
					<td>Pagina verwijderen</td>
				</tr>
			</table>
		</td>
	</tr>
</table>
<!-- JS for showing a modal before deleting a page -->
<script>
	const deleteButtons = document.querySelectorAll('.delete');
	deleteButtons.forEach(button => button.addEventListener('click', showModal));

	function showModal() {
		const name = this.getAttribute('data-pageName');
		const id = this.getAttribute('data-pageId');

		showBSModal({
			title: "Weet je het zeker?",
			body: `De pagina ${ name } wordt verwijderd. Alle pagina's die onder deze pagina hangen zijn dan ook niet meer toegankelijk.`,
			actions: [{
				label: "Ja",
				cssClass: "btn-danger",
				onClick: () => {
					window.location.replace(`/admin/pages/delete/${ id }`);
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