<x-guest-layout>
    <form method="POST" action="{{ route('register') }}" class="bg-white p-6 rounded-lg shadow-md w-full max-w-md mx-auto mt-8">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Name')" class="font-semibold text-gray-700" />
            <x-text-input id="name" class="block mt-1 w-full border-gray-300 rounded-lg focus:ring focus:ring-indigo-500" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2 text-red-500 text-sm" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" class="font-semibold text-gray-700" />
            <x-text-input id="email" class="block mt-1 w-full border-gray-300 rounded-lg focus:ring focus:ring-indigo-500" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2 text-red-500 text-sm" />
        </div>

        <!-- Address -->
        <div class="mt-4">
            <x-input-label for="address" :value="__('Address')" class="font-semibold text-gray-700" />
            <x-text-input id="address" class="block mt-1 w-full border-gray-300 rounded-lg focus:ring focus:ring-indigo-500" type="text" name="address" :value="old('address')" required autocomplete="address" />
            <x-input-error :messages="$errors->get('address')" class="mt-2 text-red-500 text-sm" />
        </div>

        <!-- Phone -->
        <div class="mt-4">
            <x-input-label for="phone" :value="__('Phone')" class="font-semibold text-gray-700" />
            <x-text-input id="phone" class="block mt-1 w-full border-gray-300 rounded-lg focus:ring focus:ring-indigo-500" type="text" name="phone" :value="old('phone')" required autocomplete="phone" />
            <x-input-error :messages="$errors->get('phone')" class="mt-2 text-red-500 text-sm" />
        </div>

        <!-- Role -->
        <div class="mt-4">
            <x-input-label for="role" :value="__('Role')" class="font-semibold text-gray-700" />
            <select id="role" name="role" class="block mt-1 w-full border-gray-300 rounded-lg focus:ring focus:ring-indigo-500" required>
                <option value="doctor" {{ old('role') === 'doctor' ? 'selected' : '' }}>Doctor</option>
                <option value="patient" {{ old('role') === 'patient' ? 'selected' : '' }}>Patient</option>
                

            </select>
            <x-input-error :messages="$errors->get('role')" class="mt-2 text-red-500 text-sm" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" class="font-semibold text-gray-700" />
            <x-text-input id="password" class="block mt-1 w-full border-gray-300 rounded-lg focus:ring focus:ring-indigo-500" type="password" name="password" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2 text-red-500 text-sm" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" class="font-semibold text-gray-700" />
            <x-text-input id="password_confirmation" class="block mt-1 w-full border-gray-300 rounded-lg focus:ring focus:ring-indigo-500" type="password" name="password_confirmation" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2 text-red-500 text-sm" />
        </div>

        <!-- Actions -->
        <div class="flex items-center justify-between mt-6">
            <a class="text-sm text-indigo-500 hover:underline focus:outline-none" href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>
            <x-primary-button class="ml-4 bg-indigo-600 hover:bg-indigo-700 focus:ring focus:ring-indigo-500">
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
