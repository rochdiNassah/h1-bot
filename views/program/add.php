<?php $this->extends('layouts.main')->setTitle('Add a program') ?>

<div class="w-full sm:w-1/2 mx-auto mt-16 px-2 sm:px-0 space-y-4">
    <?php foreach (errors() as $error): ?>
    <div class="bg-red-100 border-t-4 border-red-500 rounded text-red-900 px-4 py-3" role="alert">
        <div class="flex">
            <div class="py-1"><svg class="fill-current h-6 w-6 text-red-500 mr-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M2.93 17.07A10 10 0 1 1 17.07 2.93 10 10 0 0 1 2.93 17.07zm12.73-1.41A8 8 0 1 0 4.34 4.34a8 8 0 0 0 11.32 11.32zM9 11V9h2v6H9v-4zm0-6h2v2H9V5z"/></svg></div>
            <div>
            <p class="font-bold">Error</p>
            <p class="text-sm"><?= $error ?></p>
            </div>
        </div>
    </div>
    <?php endforeach; ?>

    <form method="post" action="<?= url('/programs/add') ?>" class="bg-white border border-gray-200 rounded px-4 py-6 mb-4 space-y-4">
        <h1 class="text-md text-amber-500">Add a program</h1>

        <div class="space-y-2">
            <input value="<?= escape(old('name')) ?>" autocomplete="off" name="name" class="appearance-none border rounded w-full py-1.5 px-3 text-gray-700 text-sm leading-tight focus:outline-none" type="text" placeholder="Name">
            <input value="<?= escape(old('root')) ?>" autocomplete="off" name="root" class="appearance-none border rounded w-full py-1.5 px-3 text-gray-700 text-sm leading-tight focus:outline-none" type="text" placeholder="Root domain e.g https://google.com">
        </div>

        <button class="text-sm transition-all hover:bg-amber-500 hover:text-white p-2 rounded text-amber-500 bg-white border-amber-500 border">Submit</button>
    </form>
</div>