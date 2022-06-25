<?php

$nav_links = [
    ['name' => 'Home', 'path' => url('/'), 'is_current'],
    ['name' => 'Add program', 'path' => url('/program/add')]
];

?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
    <head>
        <meta charset="utf8">
        <meta name="viewport" content="initial-scale=1.0, width=device-width">
        <title><?= escape($this->getTitle()) ?></title>
        <script src="<?= asset('js/tailwind.js') ?>"></script>
        <script src="<?= asset('js/flowbite.js') ?>"></script>
    </head>
    <body>
        <div class="h-screen max-w-2xl sm:max-w-5xl container mx-auto">
            <?= $this->include('layouts.navbar', ['nav_links' => $nav_links]) ?>

            <?= $this->child() ?>
        </div>
    </body>
</html>