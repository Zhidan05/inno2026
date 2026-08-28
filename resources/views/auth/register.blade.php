<x-guest-layout>
    <div class="text-center mb-8">
        <h2 class="text-3xl font-orbitron font-bold text-white tracking-wider mb-2">Participant Registration</h2>
        <p class="text-gray-400 font-exo text-sm">Join the InnoElectrica 2026 competitions.</p>
    </div>

    <form method="POST" action="{{ route('register') }}" class="font-exo">
        @csrf

        <!-- Name -->
        <div>
            <label for="name" class="block font-medium text-sm text-gray-300">Full Name <span class="text-red-500">*</span></label>
            <input id="name" class="block mt-1 w-full bg-[#0a0f1d] border border-gray-600 text-gray-200 focus:border-[#FFC209] focus:ring focus:ring-[#FFC209] focus:ring-opacity-50 rounded-md shadow-sm" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <label for="email" class="block font-medium text-sm text-gray-300">Email Address <span class="text-red-500">*</span></label>
            <input id="email" class="block mt-1 w-full bg-[#0a0f1d] border border-gray-600 text-gray-200 focus:border-[#FFC209] focus:ring focus:ring-[#FFC209] focus:ring-opacity-50 rounded-md shadow-sm" type="email" name="email" value="{{ old('email') }}" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Phone Number -->
        <div class="mt-4">
            <label for="phone" class="block font-medium text-sm text-gray-300">Phone / WhatsApp Number <span class="text-red-500">*</span></label>
            <input id="phone" class="block mt-1 w-full bg-[#0a0f1d] border border-gray-600 text-gray-200 focus:border-[#FFC209] focus:ring focus:ring-[#FFC209] focus:ring-opacity-50 rounded-md shadow-sm" type="text" name="phone" value="{{ old('phone') }}" required />
            <x-input-error :messages="$errors->get('phone')" class="mt-2" />
        </div>

        <!-- Institution -->
        <div class="mt-4">
            <label for="institution" class="block font-medium text-sm text-gray-300">Institution / University <span class="text-red-500">*</span></label>
            <input id="institution" class="block mt-1 w-full bg-[#0a0f1d] border border-gray-600 text-gray-200 focus:border-[#FFC209] focus:ring focus:ring-[#FFC209] focus:ring-opacity-50 rounded-md shadow-sm" type="text" name="institution" value="{{ old('institution') }}" required />
            <x-input-error :messages="$errors->get('institution')" class="mt-2" />
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

        <div class="flex items-center justify-between mt-8">
            <a class="text-sm text-gray-400 hover:text-[#FFC209] transition-colors" href="{{ route('login') }}">
                Already registered?
            </a>

            <button type="submit" class="inline-flex justify-center items-center px-4 py-3 bg-[#FFC209] border border-transparent rounded-md font-orbitron font-bold text-[#0a0f1d] uppercase tracking-widest hover:bg-yellow-400 focus:bg-yellow-400 active:bg-yellow-500 focus:outline-none focus:ring-2 focus:ring-[#FFC209] focus:ring-offset-2 focus:ring-offset-[#111827] transition ease-in-out duration-150 shadow-[0_0_15px_rgba(255,194,9,0.5)]">
                Register
            </button>
        </div>
    </form>
</x-guest-layout>
