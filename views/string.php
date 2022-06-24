<?php $this->extends('layouts/main')->setTitle('String utility!'); ?>

<div class="mx-auto lg:max-w-7xl my-20">
    <div class="space-y-4 bg-gray-600 p-4 rounded-lg border border-gray-400 text-gray-400">
        <form action="string" method="post" class="space-y-2 bg-gray-400 rounded-lg p-4">
            <input value="<?= escape(old('target')) ?>" autocomplete="false" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-800 leading-tight focus:outline-none focus:shadow-outline" name="target" type="text" placeholder="String">

            <select name="operation" class="
                bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg
                focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5
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

        <?php if (isset($result)): ?>
        <div class="bg-gray-400 rounded-lg p-4">
            <h1 class="text-white font-bold text-center"><?= escape($result) ?><h1>
        </div>
        <?php endif ?>
    </div>
</div>