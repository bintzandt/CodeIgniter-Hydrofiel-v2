<?php

function generate_icon($name) {
	switch (strtolower($name)) {
		case 'home':
			return 'fa fa-home';
			break;
		case 'zwemmen':
			return 'fa fa-swimmer';
			break;
		case 'waterpolo':
			return 'fa fa-volleyball-ball';
			break;
		case 'vereniging':
			return 'fa fa-users';
			break;
		case 'coronaregels':
			return 'fas fa-virus'
		default:
			return 'fa fa-phone';
			break;
	}
}

?>
<div class="banner">
	<div class="header">
		<nav class="navbar navbar-expand-xl navbar-dark">
			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#hydrofiel-nav" aria-controls="hydrofiel-nav" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			</button>
			<div class="collapse navbar-collapse justify-content-end" id="hydrofiel-nav">
				<ul class="navbar-nav">
					<?php foreach ($hoofdmenus as $hoofdmenu) {
						if (!empty($hoofdmenu->submenu)) { ?>
							<li class="nav-item dropdown">
								<a class="nav-link dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
									<span class="<?= generate_icon($hoofdmenu->nameNL) ?>"></span>
									<?= $hoofdmenu->name ?>
									<span class="caret"></span>
								</a>
								<div class="dropdown-menu hydrofiel-dropdown">
									<a class="dropdown-item" href="/page/<?= $hoofdmenu->pageId ?>"><?= $hoofdmenu->name ?></a>
									<?php foreach ($hoofdmenu->submenu as $submenu) {
										if (!$submenu->ingelogd || isLoggedIn()) { ?>
											<a class="dropdown-item" href="/page/<?= $submenu->pageId ?>"><?= $submenu->name ?></a>
									<?php }
									} ?>
								</div>
							</li>
						<?php
						} else { ?>
							<li class="nav-item">
								<a class="nav-link" href="/page/<?= $hoofdmenu->pageId ?>">
									<span class="<?= generate_icon($hoofdmenu->nameNL) ?>"></span>
									<?= $hoofdmenu->name ?>
								</a>
							</li>
						<?php
						}
					}
					if (isLoggedIn()) { ?>
						<li class="nav-item"><a href="/event" class="nav-link"><span class="fa fa-calendar"></span> <?= lang('General.generalCalendar') ?></a></li>
						<li class="nav-item"><a href="/user" class="nav-link"><span class="fa fa-user"></span> <?= lang('General.generalProfile') ?> </a></li>
						<li class="nav-item"><a href="/training" class="nav-link"><span class="fa fa-dumbbell"></span> Training</a></li>
						<?php if (isAdmin()) { ?>
							<li class="nav-item"><a href="/admin" class="nav-link"><span class="fa fa-cogs"></span> <?= lang('General.generalControlPanel') ?></a></li>
						<?php } ?>
						<li class="nav-item"><a href="<?= route_to('logout') ?>" class="nav-link"><span class="fa fa-sign-out"></span> <?= lang('General.generalSignOut') ?> </a></li>
					<?php
					} else { ?>
						<li class="nav-item"><a href="<?= route_to('login') ?>" class="nav-link"><span class="fa fa-sign-in-alt"></span> <?= lang('General.generalSignIn') ?> </a></li>
					<?php
					} ?>
					<li class="nav-item"><a href="<?= route_to('switchLanguage') ?>" class="nav-link"><span class="fa fa-flag"></span> <?= lang('General.generalLanguage') ?></a></li>
				</ul>
			</div>
		</nav>
	</div>
	<div class="banner-info" id="info">
		<p><?= lang('General.generalInfo') ?></p>
		<!--        <label></label>-->
		<h2>N.S.Z.&W.V. Hydrofiel</h2>
	</div>
</div>
<div class="container pt-3">
	<?php if (session('success')) { ?>
		<div class="alert alert-success">
			<strong><?= session('success') ?></strong>
		</div>
	<?php } elseif (session('error')) { ?>
		<div class="alert alert-danger">
			<strong><?= session('error') ?></strong>
		</div>
	<?php } ?>