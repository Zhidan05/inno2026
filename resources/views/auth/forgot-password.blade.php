<x-guest-layout>
    <div class="text-center mb-8">
        <h2 class="text-3xl font-orbitron font-bold text-white tracking-wider mb-2">Forgot Password</h2>
        <p class="text-gray-400 font-exo text-sm">
            {{ __('No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
        </p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}" class="font-exo">
        @csrf

        <!-- Email Address -->
        <div>
            <label for="email" class="block font-medium text-sm text-gray-300">Email <span class="text-red-500">*</span></label>
            <input id="email" class="block mt-1 w-full bg-[#0a0f1d] border border-gray-600 text-gray-200 focus:border-[#FFC209] focus:ring focus:ring-[#FFC209] focus:ring-opacity-50 rounded-md shadow-sm" type="email" name="email" value="{{ old('email') }}" required autofocus />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="mt-8">
            <button type="submit" class="w-full inline-flex justify-center items-center px-4 py-3 bg-[#FFC209] border border-transparent rounded-md font-orbitron font-bold text-[#0a0f1d] uppercase tracking-widest hover:bg-yellow-400 focus:bg-yellow-400 active:bg-yellow-500 focus:outline-none focus:ring-2 focus:ring-[#FFC209] focus:ring-offset-2 focus:ring-offset-[#111827] transition ease-in-out duration-150 shadow-[0_0_15px_rgba(255,194,9,0.5)]">
                Email Password Reset Link
            </button>
        </div>

        <div class="mt-4 text-center">
            <a class="text-sm text-gray-400 hover:text-[#FFC209] transition-colors" href="{{ route('login') }}">
                Back to Login
            </a>
        </div>
    </form>
</x-guest-layout>

