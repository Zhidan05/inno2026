<div class="space-y-4">
    @if ($getRecord()->registration_mode === 'solo')
        <div class="px-4 py-3 bg-gray-50 dark:bg-white/5 rounded-xl border border-gray-200 dark:border-white/10">
            <span class="text-sm text-gray-500 dark:text-gray-400">Individual Registration</span>
        </div>
    @else
        <div class="space-y-2">
            <h4 class="text-sm font-semibold text-gray-950 dark:text-white">TEAM LEADER</h4>
            <div class="px-4 py-3 bg-gray-50 dark:bg-white/5 rounded-xl border border-gray-200 dark:border-white/10">
                <p class="text-sm text-gray-950 dark:text-white"><span class="font-medium">Name:</span> {{ $getRecord()->user->name }}</p>
                <p class="text-sm text-gray-500 dark:text-gray-400"><span class="font-medium">Email:</span> {{ $getRecord()->user->email }}</p>
            </div>
        </div>

        @foreach($getRecord()->members as $index => $member)
            <div class="space-y-2 mt-4">
                <h4 class="text-sm font-semibold text-gray-950 dark:text-white">MEMBER {{ $index + 1 }}</h4>
                <div class="px-4 py-3 bg-gray-50 dark:bg-white/5 rounded-xl border border-gray-200 dark:border-white/10">
                    <p class="text-sm text-gray-950 dark:text-white"><span class="font-medium">Name:</span> {{ $member->name }}</p>
                    <p class="text-sm text-gray-500 dark:text-gray-400"><span class="font-medium">NIM:</span> {{ $member->nim }}</p>
                </div>
            </div>
        @endforeach
    @endif
</div>
