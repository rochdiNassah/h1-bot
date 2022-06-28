<?php $this->extends('layouts.main')->setTitle('Homepage') ?>

<div class="w-full mx-auto px-8 md:px-32 lg:px-52">
    <div class="pt-16 space-y-8">
        <div class="w-full mx-auto">
            <div class="w-32 sm:w-44 mx-auto max-w-52">
                <img src="<?= url('logo.png') ?>" />
            </div>
        </div>

        <h1 class="w-full sm:w-3/4 mx-auto text-lg sm:text-2xl text-gray-500 text-center">Maintain bug-bounty progams automatically!</h1>

        <form class="w-full space-x-2 flex align-center" action="" method="post">
            <input class="font-bold rounded-sm text-gray-500 w-full appearance-none outline-none p-3.5 text-xs border border-gray-200" placeholder="Exact program name..." name="program" autocomplete="off" value="<?= escape(old('program')) ?>" />
            <input class="w-16 p-3.5 rounded-sm font-bold hover:bg-amber-500 cursor-pointer text-xs bg-amber-400 text-white mx-auto" type="submit" value="Go" />
        </form>
        
        <div class="max-w-2xl mx-auto space-y-2 my-2">
        <?php foreach (errors() as $error): ?>
            <div class="w-full p-3.5 text-xs text-amber-700 bg-amber-100" role="alert">
                <?= $error ?>
            </div>
        <?php endforeach; ?>
        <div>
    </div>
</div>
