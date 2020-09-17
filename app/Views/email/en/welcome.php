<!DOCTYPE HTML>
<html>
<!DOCTYPE HTML>
<html>

<head>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta charset="UTF-8">
	<style type="text/css">
		html,
		body {
			width: 100%;
			max-width: 800px;
			padding: 0;
			margin: 0 auto;
			color: #2B4078;
			font-family: liberation-sans, sans-serif;
		}

		header {
			background: #FFAB3A;
			height: 120px;
			padding: 7px;
		}

		p {
			padding: 0 10px;
			box-sizing: border-box;
		}

		a {
			color: #FFAB3A;
			text-decoration: none;
		}

		a:hover {
			text-decoration: underline;
		}

		table {
			width: 100%;
		}

		.training {
			text-align: left;
			border: 1px solid black;
			border-collapse: collapse;
		}

		.training th,
		.training td {
			border: 1px solid black;
			height: 30px;
			vertical-align: bottom;
			padding: 15px;
		}

		.training tr:nth-child(even),
		.training th {
			background-color: #f2f2f2;
		}

		footer {
			color: #FFFFFF;
			background: #315265;
			padding: 7px;
			height: 50px;
		}
	</style>
</head>

<body>
	<header>
		<img src="<?= site_url('/images/logomail.png') ?>" alt="Logo" style="width: 100%; margin: 0; padding: 0;">	
	</header>
	<p>Dear <?= $user->name ?>,</p>
	<p>
		I've processed your application and from today you're officially a member! This means that you'll have access to the Hydrofiel website. With <a href="<?= site_url('/reset-password') . '?token=' . $user->recoveryToken ?>">this</a> link you'll be able to make an account for <a href="<?= site_url('') ?>">www.hydrofiel.nl</a>. Among other things, you can view the calendar and sign yourself up for events/tournaments/competitions on the website. You can also find the Rules and Regulations, the Articles of Association, and other useful information.
	</p>
	<p>
		From now, you will also receive the newsletter and any other important e-mails, and you'll be kept up-to-date with everything going on.
	</p>
	<p>
		The practice sessions are split as follows:
	</p>
	<div style="overflow-x: auto;">
		<table class="training">
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
	</div>
	<?php if (!empty($events)) { ?>
		<p>
			<b>Upcoming events:</b>
		</p>
		<ul>
			<?php
			foreach ($events as $event) { ?>
				<li><a href="<?= site_url('/event/' . $event->eventId) ?>"><?= $event->nameEN ?>
						op <?= $event->from->format('d-m-Y H:i') ?></a></li>
			<?php } ?>
		</ul>
	<?php } ?>
	<p>
		In the attachment you'll find our welcoming letter. If you have any questions, please ask away. This can be done in person or through an e-mail to <a href="mailto:secretaris@hydrofiel.nl">secretaris@hydrofiel.nl</a>.
	</p>
	<p>
		Don't forget to like us on Facebook: <a href="https://www.facebook.com/Hydrofiel/">https://www.facebook.com/Hydrofiel/</a>
	</p>
	<p>
		See you in the pool!
	</p>
	<p>
		With Hard and Wet greetings,
	</p>
	<p>
		Iris Harmsen<br>
		<i>Secretary 2020-2021<br>
			N.S.Z.&W.V. Hydrofiel</i>
	</p>
	<footer></footer>
</body>

</html>