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
						Dear <?= $user->name ?>,<br>
						<br>
						I've processed your application and from today you're officially a member! This means that you'll
						have
						access to the Hydrofiel website. With <a href="<?= site_url('/reset-password') . '?token=' . $user->recoveryToken ?>">this</a>
						link you'll be able to make an account for <a href="<?= site_url('') ?>">www.hydrofiel.nl</a>.
						Among other
						things, you can view the calendar and sign yourself up for events/tournaments/competitions on the
						website.
						You can also find the Rules and Regulations, the Articles of Association, and other useful
						information.<br>
						<br>
						From now, you will also receive the newsletter and any other important e-mails, and you'll be kept
						up-to-date with everything going on.<br>
						<br>
						The practice sessions are split as follows:<br>
						<table style="width: 100%; text-align: left;">
							<thead>
								<tr>
									<th></th>
									<th>Monday</th>
									<th>Tuesday</th>
									<th>Thursday</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<th>Swimming</th>
									<th>-</th>
									<th>20:00-21:00</th>
									<th>20:00-21:00</th>
								</tr>
								<tr>
									<th>Water polo Ladies</th>
									<th>21:30-22:30</th>
									<th>-</th>
									<th>21:00-22:30</th>
								</tr>
								<tr>
									<th>Water polo Gents 1 & 2</th>
									<th>-</th>
									<th>21:00-22:30</th>
									<th>21:30-22:30</th>
								</tr>
								<tr>
									<th>Water polo Gents 3 & recreational</th>
									<th>-</th>
									<th>21:00-22:00</th>
									<th>21:00-22:00</th>
								</tr>
							</tbody>
						</table>
						<?php if (!empty($events)) { ?>
							<br>
							<b>Upcoming events:</b><br>
							<ul>
								<?php
								foreach ($events as $event) { ?>
									<li><a href="<?= site_url('/event/' . $event->eventId) ?>"><?= $event->nameEN ?>
											op <?= $event->from->format('d-m-Y H:i') ?></a></li>
								<?php } ?>
							</ul>
						<?php } ?>
						In the attachment you'll find our welcoming letter. If you have any questions, please ask away. This can
						be done in person or through an e-mail to <a href="mailto:secretaris@hydrofiel.nl">secretaris@hydrofiel.nl</a>.<br>
						<br>
						Don't forget to like us on Facebook: <a href="https://www.facebook.com/Hydrofiel/">https://www.facebook.com/Hydrofiel/</a><br>
						<br>
						See you in the pool!<br>
						<br>
						With Hard and Wet greetings,<br>
						<br>
						Meike Tacken<br>
						<i>Secretary 2019-2020<br>
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