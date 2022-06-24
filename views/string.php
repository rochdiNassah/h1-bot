<?php $this->extends('layouts/main')->setTitle('String utility!'); ?>

<div class="space-y-4 mx-auto lg:max-w-7xl my-20">
    <div class="space-y-4 p-4 border border-gray-200 text-gray-400">
        <h1 class="text-gray-600 font-bold text-4xl">String utility</h1>

        <form action="string-manipulation" method="post" class="space-y-2 rounded-lg">
            <input value="<?= escape(old('target')) ?>" autocomplete="off" class="appearance-none border rounded w-full py-4 px-3 text-gray-800 leading-tight focus:outline-none focus:shadow-outline" name="target" type="text" placeholder="String">

            <select name="operation" class="
                bg-gray-50 border border-gray-300 text-gray-900 text-sm
                focus:ring-blue-500 focus:border-blue-500 block w-full p-2 rounded-lg
                dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400
                dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500
            ">
                <option <?= old('operation') !== null ?: 'selected' ?> >Choose an operation to perform against the given string</option>

                <?php foreach (['length', 'reverse'] as $operation): ?>
                    <option <?= old('operation') !== $operation ?: 'selected' ?> value="<?= $operation ?>"><?= $operation ?></option>
                <?php endforeach ?>
            </select>

            <button class="bg-gray-600 hover:bg-gray-500 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="submit">
                Submit
            </button>
        </form>
    </div>

    <?php if (isset($result)): ?>
    <div class="bg-green-100 border border-green-200 p-4">
        <h1 class="text-green-600 font-bold text-center"><?= escape($result) ?><h1>
    </div>
    <?php endif ?>
</div>