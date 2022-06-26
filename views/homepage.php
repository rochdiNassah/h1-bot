<?php $this->extends('layouts.main')->setTitle('Homepage') ?>

<div class="w-full mx-auto px-2 md:px-32 lg:px-52">
    <div class="pt-24 space-y-8">
        <div class="w-full mx-auto">
            <img class="w-1/2 sm:w-52 mx-auto" src="<?= url('logo.svg') ?>" />
        </div>

        <h1 class="w-full sm:w-2/4 mx-auto text-lg sm:text-2xl text-gray-800 font-bold text-center">Maintain bug-bounty targets automatically!</h1>

        <form class="w-full space-x-1 flex align-center" action="" method="post">
            <input class="w-full appearance-none outline-none p-4 text-xs border border-gray-200" placeholder="Exact program name..." name="program" autocomplete="off" value="<?= escape(old('program')) ?>" />
            <input class="w-32 p-4 font-bold hover:bg-gray-700 cursor-pointer text-xs bg-gray-800 text-white mx-auto" type="submit" value="Go" />
        </form>

        <?php foreach($errors as $key => $value): ?>
        <div class="w-full p-4 text-xs text-red-700 bg-red-100 dark:bg-red-200 dark:text-red-800" role="alert">
            <?= $value ?>
        </div>
        <?php endforeach; ?>

        <?php if(flashed('status')): ?>
        <div class="w-full p-4 text-xs text-green-700 bg-green-100 dark:bg-green-200 dark:text-green-800" role="alert">
            <?= flashed('message') ?>
        </div>
        <?php endif; ?>
    </div>
</div>