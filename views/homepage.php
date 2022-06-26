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

        <?php if($status = flashed('status')): ?>
        <?php 
            $color = 'success' === $status ? 'green' : ($status === 'error' ? 'red' : 'blue');
        ?>
        <div class="w-full p-4 text-xs text-<?= $color ?>-700 bg-<?= $color ?>-100" role="alert">
            <?= flashed('message') ?>
        </div>
        <?php endif; ?>
        <?php if(isset($program)): ?>
        <div class="w-full p-4 text-xs text-green-700 bg-green-100" role="alert">
            <?= escape($program) ?>
        </div>
        <?php endif; ?>
    </div>
</div>