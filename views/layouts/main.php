<!DOCTYPE html>
<html lang="en" dir="ltr">
    <head>
        <meta charset="utf8">
        <meta name="viewport" content="initial-scale=1.0, width=device-width">
        <title><?= escape($this->getTitle()) ?></title>
        <script src="<?= asset('tailwind.js') ?>"></script>
    </head>
    <body class="bg-gray-800">
        <div class="px-2 sm:px-4 h-14 flex justify-between container mx-auto lg:max-w-5xl">
            <?= $this->child() ?>
        </div>
    </body>
</html>