<?php foreach (messages() as $message): ?>
<div class="bg-green-100 border-t-4 border-green-500 rounded text-green-900 px-4 py-3" role="alert">
    <div class="flex">
        <p class="text-sm"><?= escape($message) ?></p>
    </div>
</div>
<?php endforeach; ?>

<?php foreach (errors() as $error): ?>
<div class="bg-red-100 border-t-4 border-red-500 rounded text-red-900 px-4 py-3" role="alert">
    <div class="flex">
        <p class="text-sm"><?= $error ?></p>
    </div>
</div>
<?php endforeach; ?>