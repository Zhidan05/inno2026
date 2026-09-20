<x-guest-layout>
    <div class="text-center mb-8">
        <h2 class="text-3xl font-orbitron font-bold text-white tracking-wider mb-2">Reset Password</h2>
        <p class="text-gray-400 font-exo text-sm">Enter your new password below.</p>
    </div>

    <form method="POST" action="{{ route('password.store') }}" class="font-exo">
        @csrf

        <!-- Password Reset Token -->
        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <!-- Email Address -->
        <div>
            <label for="email" class="block font-medium text-sm text-gray-300">Email <span class="text-red-500">*</span></label>
            <input id="email" class="block mt-1 w-full bg-[#0a0f1d] border border-gray-600 text-gray-200 focus:border-[#FFC209] focus:ring focus:ring-[#FFC209] focus:ring-opacity-50 rounded-md shadow-sm" type="email" name="email" value="{{ old('email', $request->email) }}" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <label for="password" class="block font-medium text-sm text-gray-300">Password <span class="text-red-500">*</span></label>
            <input id="password" class="block mt-1 w-full bg-[#0a0f1d] border border-gray-600 text-gray-200 focus:border-[#FFC209] focus:ring focus:ring-[#FFC209] focus:ring-opacity-50 rounded-md shadow-sm" type="password" name="password" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <label for="password_confirmation" class="block font-medium text-sm text-gray-300">Confirm Password <span class="text-red-500">*</span></label>
            <input id="password_confirmation" class="block mt-1 w-full bg-[#0a0f1d] border border-gray-600 text-gray-200 focus:border-[#FFC209] focus:ring focus:ring-[#FFC209] focus:ring-opacity-50 rounded-md shadow-sm" type="password" name="password_confirmation" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="mt-8">
            <button type="submit" class="w-full inline-flex justify-center items-center px-4 py-3 bg-[#FFC209] border border-transparent rounded-md font-orbitron font-bold text-[#0a0f1d] uppercase tracking-widest hover:bg-yellow-400 focus:bg-yellow-400 active:bg-yellow-500 focus:outline-none focus:ring-2 focus:ring-[#FFC209] focus:ring-offset-2 focus:ring-offset-[#111827] transition ease-in-out duration-150 shadow-[0_0_15px_rgba(255,194,9,0.5)]">
                Reset Password
            </button>
        </div>
    </form>
</x-guest-layout>

