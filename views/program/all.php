<?php $this->extends('layouts.main')->setTitle('All programs') ?>

<div class="mt-16 relative rounded border">
    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr>
                <th scope="col" class="px-6 py-3">
                    Handle
                </th>
                <th scope="col" class="px-6 py-3">
                    Total assets
                </th>
                <th scope="col" class="px-6 py-3">
                    Last update
                </th>
                <th scope="col" class="px-6 py-3">
                    <span class="sr-only"></span>
                </th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($programs as $program): ?>
            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                <th scope="row" class="px-6 py-4 font-medium whitespace-nowrap">
                    <a class="transition-all text-blue-500 hover:text-blue-700 hover:underline" href="<?= sprintf('https://hackerone/%s', $program->handle) ?>"><?= ucfirst(escape($program->handle)) ?></a>
                </th>
                <th scope="row" class="px-6 py-4 font-medium whitespace-nowrap">
                    <?= count(json_decode($program->assets)) ?>
                </th>
                <td class="px-6 py-4">
                    <?= $program->updated_at ?? 'Never!' ?>
                </td>
                <td class="px-6 py-4 text-right">
                    <a href="<?= url(sprintf('/programs/%s/delete', $program->id)) ?>" class="font-medium text-red-500 hover:text-red-700 hover:underline">Delete</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>