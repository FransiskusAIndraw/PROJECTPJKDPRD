<x-guest-layout>

<style>
    body {
        background: #06008A; /* Biru gelap background */
    }
</style>

<div class="min-h-screen flex items-center justify-center px-4">

    <div class="bg-gradient-to-b from-blue-700 to-blue-900 text-white w-full max-w-md p-10 rounded-2xl shadow-2xl text-center">

        <!-- Logo -->
        <img src="{{ asset('images/logo.jpg') }}" 
     alt="Logo DPRD" 
     class="w-24 h-24 rounded-full object-cover mx-auto mb-4 shadow-md border">

        <h2 class="text-2xl font-bold tracking-wide">SEKRETARIAT DPRD</h2>
        <p class="text-sm mb-8">Sistem Surat Masuk dan Disposisi Surat</p>

        <!-- Session Status -->
        <x-auth-session-status class="mb-3" :status="session('status')" />

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <!-- Email -->
            <div class="text-left">
                <x-input-label for="email" :value="__('Email')" class="text-white" />
                <x-text-input id="email" class="block mt-1 w-full border-gray-300 rounded text-black" type="email"
              name="email" :value="old('email')" required autofocus autocomplete="username" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <!-- Password -->
            <div class="mt-4 text-left">
                <x-input-label for="password" :value="__('Password')" class="text-white" />
                <x-text-input id="password" class="block mt-1 w-full border-gray-300 rounded text-black" type="password"
              name="password" required autocomplete="current-password" />
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <!-- Submit Button -->
            <div class="mt-8">
                <button type="submit" 
                        class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 rounded-lg transition">
                    Submit
                </button>
            </div>
        </form>

    </div>
</div>

</x-guest-layout>
