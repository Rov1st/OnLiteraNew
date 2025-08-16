<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="h-screen overflow-hidden">

    <div class="flex h-screen w-screen">

        <!-- Left: Form -->
        <div class="w-2/3 mx-auto px-6 py-12 lg:w-1/2 overflow-y-auto">
            <div class="w-full max-w-full space-y-8">
                <!-- Logo & Header -->
                <div>
                    <img src="{{ asset('logo.svg') }}" alt="Logo" class="h-10 w-auto mb-4">
                    <h2 class="text-2xl font-bold tracking-tight text-gray-900">
                        Create your account
                    </h2>
                    <p class="mt-2 text-sm text-gray-600">
                        Already have an account?
                        <a href="{{ route('login') }}" class="font-semibold text-indigo-600 hover:text-indigo-500">Sign in</a>
                    </p>
                </div>
                <div class="">
                    <!-- Form -->
                    <form method="POST" action="{{ route('register') }}" class="space-y-6">
                        @csrf

                        <!-- Full Name -->
                        <div>
                            <x-input-label for="name" :value="__('Full Name')" />
                            <x-text-input id="name" name="name" type="text" :value="old('name')" required autofocus class="block w-full" />
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>

                        <!-- Display Name -->
                        <div>
                            <x-input-label for="display_name" :value="__('Display Name')" />
                            <x-text-input id="display_name" name="display_name" type="text" :value="old('display_name')" required class="block w-full" />
                            <x-input-error :messages="$errors->get('display_name')" class="mt-2" />
                        </div>

                        <!-- Email -->
                        <div>
                            <x-input-label for="email" :value="__('Email')" />
                            <x-text-input id="email" name="email" type="email" :value="old('email')" required class="block w-full" />
                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                        </div>

                        <!-- Password -->
                        <div>
                            <x-input-label for="password" :value="__('Password')" />
                            <x-text-input id="password" name="password" type="password" required class="block w-full" autocomplete="new-password" />
                            <x-input-error :messages="$errors->get('password')" class="mt-2" />
                        </div>

                        <!-- Confirm Password -->
                        <div>
                            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
                            <x-text-input id="password_confirmation" name="password_confirmation" type="password" required class="block w-full" autocomplete="new-password" />
                            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                        </div>

                        <!-- Register Button -->
                        <div>
                            <x-primary-button class="w-full justify-center">
                                {{ __('Register') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Right: Image -->
        <div>

            <div class="block w-full lg:w-1/2 relative h-64 lg:h-auto">
                <img src="{{ asset('images/register-preview.jpg') }}"
                class="h-full w-full object-cover"
                alt="Register image">
            </div>
        </div>
    </div>

</body>
</html>
