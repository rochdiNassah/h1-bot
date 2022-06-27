<?php $this->extends('layouts.main')->setTitle('Debug') ?>

<?php

    // dump(app('request')->getReferer());

?>

<form method="post" action="<?= url('/debug') ?>" enctype="multipart/form-data">
    <div class="flex justify-center mt-8">
        <div class="max-w-2xl rounded-lg shadow-xl bg-gray-50">
            <div class="m-4">
                <div class="flex items-center justify-center w-full flex-wrap space-y-2">
                <input value="Rochdi" class="w-full appearance-none outline-none p-4 text-xs border border-gray-200" placeholder="First name" name="first_name" autocomplete="off" value="<?= escape(old('first_name')) ?>" />
                <input value="Nassah" class="w-full appearance-none outline-none p-4 text-xs border border-gray-200" placeholder="Last name" name="last_name" autocomplete="off" value="<?= escape(old('last_name')) ?>" />
                <input value="rochdinassah.1998@gmail.com" class="w-full appearance-none outline-none p-4 text-xs border border-gray-200" placeholder="Email address" name="email_address" autocomplete="off" value="<?= escape(old('email_address')) ?>" />
                <input value="nassah#/401:)xD" class="w-full appearance-none outline-none p-4 text-xs border border-gray-200" placeholder="Password" name="password" autocomplete="off" value="<?= escape(old('password')) ?>" />
                <input value="nassah#/401:)xD" class="w-full appearance-none outline-none p-4 text-xs border border-gray-200" placeholder="Password confirmation" name="password_confirm" autocomplete="off" value="<?= escape(old('password_confirm')) ?>" />
                    <label
                        class="flex flex-col w-full h-32 border-4 border-blue-200 border-dashed hover:bg-gray-100 hover:border-gray-300">
                        <div class="flex flex-col items-center justify-center pt-7">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-gray-400 group-hover:text-gray-600"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                            </svg>
                            <p class="pt-1 text-sm tracking-wider text-gray-400 group-hover:text-gray-600">
                                Attach a file</p>
                        </div>
                        <input name="file" type="file" class="opacity-0" />
                    </label>
                </div>
            </div>
            <div class="flex justify-center p-2">
                <button class="w-full px-4 py-2 text-white bg-blue-500 rounded shadow-xl">Create</button>
            </div>
        </div>
    </div>
</form>

<div class="max-w-2xl mx-auto space-y-2 my-2">
<?php foreach (app('session')->errors() as $key => $value): ?>
    <div class="w-full p-4 text-xs text-red-700 bg-red-100" role="alert">
        <?php dump($value) ?>
    </div>
<?php endforeach; ?>
<div>