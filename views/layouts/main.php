<!DOCTYPE html>
<html lang="en" dir="ltr">
    <head>
        <meta charset="utf8">
        <meta name="viewport" content="initial-scale=1.0, width=device-width">
        <title><?= escape($this->getTitle()) ?></title>
        <link rel="stylesheet" href="<?= asset('tailwind.css') ?>">
    </head>
    <body>
        <?= $this->child() ?>
    </body>
</html>