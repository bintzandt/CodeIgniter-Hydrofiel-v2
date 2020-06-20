<?= $this->extend('templates/default'); ?>

<?= $this->section('body') ?>
	<div class="row">
		<div class="col-md-2 d-none d-md-block">
			<a href="https://www.sponsorkliks.com/winkels.php?club=8634" target="_blank" rel="noopener"><img
						class="rounded" style="margin: 0 auto;" src="/images/sponsorkliks.gif"
						alt="SponsorKliks, gratis sponsoren!" title="SponsorKliks, sponsor jouw sponsordoel gratis!"
						Border="0"></a>
		</div><!--
		-->
		<div class="col-md-10">
			<p>
				<?= lang('Home.homeWelcome'); ?>
			</p>
			<p>
				<?= lang('Home.homeSponsor'); ?>
			</p>
		</div>
	</div>
	<hr>
	<div class="row">
		<div class="col-md homepage_block">
			<a href="/agenda"><h3><?= lang('Home.homeEvents') ?></h3></a>
			<?php if (!empty($events)) {
				foreach ($events as $event) { ?>
					<div>
						<span class="far fa-calendar"></span><a
								href="/agenda/id/<?= $event->event_id ?>"> <?= $engels ? $event->en_naam : $event->nl_naam ?></a><br>
						<div class="pl-3"><?= date_format(date_create($event->van), 'd-m-Y H:i') ?></div>
					</div>
				<?php }
			} else { ?>
				<span class="fa fa-frown-open"></span> <?= lang('Home.homeNoEvents') ?>
			<?php } ?>
		</div>
		<div class="col-md homepage_block">
			<h3><?= lang('Home.homeBirthdays') ?></h3>
			<?php if (isLoggedIn()) : ?>
				<?php foreach ($verjaardagen as $verjaardag) { ?>
					<div>
						<span class="fa fa-birthday-cake"></span><a
								href="/profile/id/<?= $verjaardag->id ?>"> <?= $verjaardag->naam ?>
							(<?= date('Y') - $verjaardag->geboortejaar ?>)</a><br>
						<div class="pl-3"><?= $verjaardag->geboortedatum ?></div>
					</div>
				<?php } ?>
			<?php else: ?>
				<span class="fa fa-birthday-cake"></span> <?= lang('Home.homeLogin'); ?>
			<?php endif; ?>
		</div>
	</div>
	<?php if(isset($posts) && !empty($posts)){ ?>
	<hr>
	<h3><?= lang('Home.homeNews') ?></h3>
		<?php foreach ($posts as $post) { ?>
			<h4><?= $engels ? $post->post_title_en : $post->post_title_nl ?></h4>
			<div class="row">
				<?php if ($post->post_image !== "") { ?>
					<div class='col-lg pb-lg-3'>
						<img class="img-fluid" src="<?= $post->post_image ?>">
					</div>
					<div class="col-lg-9 pt-md-2 pt-sm-2">
						<?= $engels ? $post->post_text_en : $post->post_text_nl ?>
					</div>
				<?php } else { ?>
					<div class="col-lg" align="left">
						<?= $engels ? $post->post_text_en : $post->post_text_nl ?>
					</div>
				<?php } ?>
				<hr>
				</div>
			<?php }
		?>
	<?php } ?>
<?= $this->endSection() ?>