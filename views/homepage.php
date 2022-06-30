<?php $this->extends('layouts.main')->setTitle('Homepage') ?>

<div class="w-full mx-auto px-4 md:px-32 lg:px-52">
    <div class="pt-16 space-y-8">
        <div class="w-full mx-auto">
            <div class="w-32 sm:w-44 mx-auto max-w-52">
                <img src="<?= url('logo.png') ?>" />
            </div>
        </div>

        <h1 class="w-full sm:w-3/4 mx-auto text-lg sm:text-2xl text-gray-500 text-center">Maintain bug-bounty progams automatically!</h1>

        <div class="w-full mx-auto sm:px-8 flex space-x-0 space-y-2 text-center flex-wrap sm:space-x-2 sm:space-y-0 sm:flex-nowrap">
            <a href="<?= url('/programs/add') ?>" class="p-2 text-md font-bold transition-all w-full rounded-lg border border-amber-400 text-amber-500 hover:bg-amber-500 hover:text-white cursor-pointer">Add Program</a>
            <a href="<?= url('/programs') ?>" class="p-2 text-md font-bold transition-all w-full rounded-lg border border-amber-400 text-amber-500 hover:bg-amber-500 hover:text-white cursor-pointer">Browse Programs</a>
        </div>
        
        <div class="max-w-2xl mx-auto space-y-2 my-2">
        <?php foreach (errors() as $error): ?>
            <div class="w-full p-3.5 text-xs text-red-700 bg-red-100" role="alert">
                <?= $error ?>
            </div>
        <?php endforeach; ?>
        <div>

        <div class="max-w-2xl mx-auto space-y-2 my-2">
        <?php if (null !== ($message = app('session')->pull('message'))): ?>
            <div class="w-full p-3.5 text-xs text-blue-700 bg-blue-100" role="alert">
                <?= $message ?>
            </div>
        <?php endif; ?>
        <div>
        <div class="max-w-2xl mx-auto space-y-2 my-2">
        <?php if (null !== ($error = app('session')->pull('error'))): ?>
            <div class="w-full p-3.5 text-xs text-red-700 bg-red-100" role="alert">
                <?= $error ?>
            </div>
        <?php endif; ?>
        <div>
    </div>
</div>
