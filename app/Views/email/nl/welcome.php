<!DOCTYPE HTML>
<html>

<body>
	<div style="width: 100%; margin: auto;" align="center">
		<table cellspacing="0" cellpadding="0" width="100%">
			<tr style="background: #ffab3a; height: 120px; padding: 7px;">
				<td><img src="<?= site_url('/images/logomail.png') ?>" alt="Logo" height="100" style="float:left;"></td>
			</tr>
			<tr>
				<td valign="top" style="text-align: left;">
					<p>
						Lieve <?= $user->name ?>,<br>
						<br>
						Ik heb zojuist je inschrijving verwerkt en je bent vanaf vandaag officieel lid! Dit betekent dat je
						toegang hebt tot de Hydrofiel website. Met <a href="<?= site_url('/reset-password') . '?token=' . $user->recoveryToken ?>">deze</a> link kun je een account
						aanmaken op <a href="<?= site_url('') ?>">www.hydrofiel.nl</a>. Op de website zie je onder andere
						de agenda en kan je jezelf inschrijven voor activiteiten/toernooien/wedstrijden. Tevens vind je daar
						het HR en de statuten en andere nuttige informatie.<br>
						<br>
						Ook krijg je voortaan de nieuwsbrief, andere belangrijke mails en blijf je op de hoogte van alle
						gebeurtenissen!<br>
						<br>
						<p>De trainingen zijn als volgt verdeeld:</p>
						<table style="width: 100%; text-align: left;">
							<thead>
								<tr>
									<th></th>
									<th>Maandag</th>
									<th>Dinsdag</th>
									<th>Donderdag</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<th>Zwemmen</th>
									<th>-</th>
									<th>20:00-21:00</th>
									<th>20:00-21:00</th>
								</tr>
								<tr>
									<th>Waterpolo Dames</th>
									<th>21:30-22:30</th>
									<th>-</th>
									<th>21:00-22:30</th>
								</tr>
								<tr>
									<th>Waterpolo Heren 1 & 2</th>
									<th>-</th>
									<th>21:00-22:30</th>
									<th>21:30-22:30</th>
								</tr>
								<tr>
									<th>Waterpolo Heren 3 & recreatief</th>
									<th>-</th>
									<th>21:00-22:00</th>
									<th>21:00-22:00</th>
								</tr>
							</tbody>
						</table>
						<?php if (!empty($events)) { ?>
							<br>
							<b>Aankomende evenementen:</b><br>
							<ul>
								<?php foreach ($events as $event) { ?>
									<li><a href="<?= site_url('event/' . $event->eventId) ?>"><?= $event->nameNL ?>
											op <?= $event->from->format('d-m-Y H:i') ?></a></li>
								<?php
								} ?>
							</ul>
						<?php }
						?>
						In de bijlage vind je onze welkomstbrief. Mocht je nog vragen hebben, dan hoor ik deze graag. Dit kan
						persoonlijk of via een mailtje naar <a href="mailto:secretaris@hydrofiel.nl">secretaris@hydrofiel.nl</a>.<br>
						<br>
						Vergeet ons vooral niet te liken op Facebook: <a href="https://www.facebook.com/Hydrofiel/">https://www.facebook.com/Hydrofiel/</a><br>
						<br>
						Tot in het bad!<br>
						<br>
						Met Harde en Natte groet,<br>
						<br>
						Meike Tacken<br>
						<i>Secretaris 2019-2020<br>
							N.S.Z.&W.V. Hydrofiel</i>
					</p>
				</td>
			</tr>
			<tr>
				<td style="color: #FFFFFF; background: #315265; padding: 7px;" height="50"></td>
			</tr>
		</table>
	</div>
</body>

</html>