<?php $this->extends('layouts/main')->setTitle('Homepage') ?>

<div class="container mx-auto flex justify-center">
    <div class="w-full xl:w-2/5 mt-32 flex justify-center flex-wrap space-y-8">
        <div class="w-full container mx-auto">
            <img class="w-1/2 md:w-1/3 mx-auto" src="<?= asset('logo.svg') ?>" />
        </div>

        <h1 class="text-lg sm:text-2xl md:text-3xl text-gray-600 font-bold text-center">Maintain bug-bounty targets automatically!</h1>

        <form class="w-full px-4" action="#" method="post">
            <input class="w-full appearance-none outline-none p-4 border border-gray-200" placeholder="Exact target name..." name="target" autocomplete="off">
        </form>
    </div>
</div>