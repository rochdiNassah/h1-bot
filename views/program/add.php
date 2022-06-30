<?php $this->extends('layouts.main')->setTitle('Add a program') ?>

<div class="w-full sm:w-1/2 mx-auto mt-16 px-2 sm:px-0 space-y-4">
    <?php foreach (errors() as $error): ?>
    <div class="bg-red-100 border-t-4 border-red-500 rounded text-red-900 px-4 py-3" role="alert">
        <div class="flex">
            <p class="text-sm"><?= escape($error) ?></p>
        </div>
    </div>
    <?php endforeach; ?>

    <form method="post" action="<?= url('/programs/add') ?>" class="bg-white border border-gray-200 rounded px-4 py-6 mb-4 space-y-4">
        <h1 class="text-md text-amber-500">Add a program</h1>

        <div class="space-y-2">
            <input value="<?= escape(old('name')) ?>" autocomplete="off" name="name" class="appearance-none border rounded w-full py-1.5 px-3 text-gray-700 text-sm leading-tight focus:outline-none" type="text" placeholder="Name">
            <input value="<?= escape(old('root')) ?>" autocomplete="off" name="root" class="appearance-none border rounded w-full py-1.5 px-3 text-gray-700 text-sm leading-tight focus:outline-none" type="text" placeholder="Root domain e.g https://google.com">
            
            <select name="platform" class="bg-gray-50 border text-gray-700 rounded text-sm focus:outline-none block w-full p-1.5">
                <option value="" selected>Choose the platform</option>
                <option value="hackerone" <?= !old('platform') ?: 'selected' ?>>HackerOne</option>
            </select>
        </div>

        <button class="text-sm transition-all hover:bg-amber-500 hover:text-white p-2 rounded text-amber-500 bg-white border-amber-500 border">Submit</button>
    </form>
</div>