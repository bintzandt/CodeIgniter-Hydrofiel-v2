<!DOCTYPE HTML>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="UTF-8">
    <style type="text/css">
        <?= view_cell('\App\Libraries\Mail::minifyCSS'); ?>
    </style>
</head>

<body>
<header>
    <img src="<?= site_url('/images/logomail.png') ?>" alt="Logo" style="width: 100%; margin: 0; padding: 0;">
</header>
<?= $this->renderSection('content'); ?>
<footer></footer>
</body>

</html>
