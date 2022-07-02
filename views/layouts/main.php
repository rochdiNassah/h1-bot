<!DOCTYPE html>
<html lang="en" dir="ltr">
    <head>
        <meta charset="utf8">
        <meta name="viewport" content="initial-scale=1.0, width=device-width">
        <title><?= escape($this->getTitle()) ?></title>
        <link rel="icon" href="<?= url('logo.png') ?>">
        <script src="<?= url('js/tailwind.js') ?>"></script>
        <script src="<?= url('js/flowbite.js') ?>"></script>
    </head>
    <body style="background-color: #FFFFF9">
        <div class="h-screen max-w-2xl sm:max-w-4xl container mx-auto">
            <?= $this->include('layouts.message') ?>
            <?= $this->include('layouts.navbar') ?>
            <?= $this->child() ?>
        </div>
    </body>
</html>