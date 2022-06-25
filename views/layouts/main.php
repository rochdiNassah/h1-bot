<!DOCTYPE html>
<html lang="en" dir="ltr">
    <head>
        <meta charset="utf8">
        <meta name="viewport" content="initial-scale=1.0, width=device-width">
        <title><?= escape($this->getTitle()) ?></title>
        <script src="<?= asset('tailwind.js') ?>"></script>
    </head>
    <body>
        <?= $this->child() ?>
    </body>
</html>