<x-guest-layout>
    <div class="flex flex-col lg:flex-row w-full h-screen overflow-hidden">
        <!-- Left: Form -->
        <div class="w-full lg:w-1/2 px-6 py-12 overflow-y-auto">
            <div class="max-w-md mx-auto space-y-8">
                <!-- Logo & Header -->
                <div>
                    <img src="{{ asset('logo.svg') }}" alt="Logo" class="h-10 w-auto mb-4">
                    <h2 class="text-2xl font-bold tracking-tight text-gray-900">
                        Sign in to your account
                    </h2>
                    <p class="mt-2 text-sm text-gray-600">
                        Don't have an account?
                        <a href="{{ route('register') }}" class="font-semibold text-indigo-600 hover:text-indigo-500">Register</a>
                    </p>
                </div>

                <!-- Session Status -->
                <x-auth-session-status class="mb-4" :status="session('status')" />

                <!-- Form -->
                <form method="POST" action="{{ route('login') }}" class="space-y-6">
                    @csrf

                    <!-- Email -->
                    <div>
                        <x-input-label for="email" :value="__('Email')" />
                        <x-text-input id="email" class="block w-full mt-1" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <!-- Password -->
                    <div>
                        <x-input-label for="password" :value="__('Password')" />
                        <x-text-input id="password" class="block w-full mt-1" type="password" name="password" required autocomplete="current-password" />
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <!-- Remember Me -->
                    <div class="block mt-4">
                        <label for="remember_me" class="inline-flex items-center">
                            <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                            <span class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                        </label>
                    </div>

                    <!-- Submit -->
                    <div class="flex items-center justify-between mt-6">
                        @if (Route::has('password.request'))
                            <a class="text-sm text-gray-600 hover:text-gray-900 underline" href="{{ route('password.request') }}">
                                {{ __('Forgot your password?') }}
                            </a>
                        @endif

                        <x-primary-button>
                            {{ __('Log in') }}
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Right: Image -->
        <div class="hidden lg:block w-full lg:w-1/2 h-screen">
            <img src="{{ asset('images/register-preview.jpg') }}"
                alt="Login image"
                class="w-full h-full object-cover">
        </div>
    </div>
</x-guest-layout>
