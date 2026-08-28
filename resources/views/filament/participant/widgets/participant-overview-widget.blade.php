<x-filament-widgets::widget>
    <x-filament::section>
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-xl font-bold tracking-tight">Participant Dashboard</h2>
            @if($registration)
                <x-filament::badge :color="match($registration->status) { 'pending' => 'warning', 'approved' => 'success', 'rejected' => 'danger', default => 'gray' }">
                    {{ ucfirst($registration->status) }}
                </x-filament::badge>
            @endif
        </div>

        @if(!$registration)
            <div class="text-center py-8">
                <p class="text-gray-500 mb-4">You have not registered for any competition yet.</p>
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-6">
                
                {{-- Competition Details --}}
                <div class="bg-gray-50 p-4 rounded-xl">
                    <h3 class="text-sm font-medium text-gray-500">Competition</h3>
                    <p class="text-lg font-bold mt-1">{{ $registration->competition->name ?? 'Unknown' }}</p>
                    <p class="text-sm text-gray-500 mt-2">Team: {{ $registration->team_name }}</p>
                </div>

                {{-- Grade --}}
                <div class="bg-gray-50 p-4 rounded-xl">
                    <h3 class="text-sm font-medium text-gray-500">Grade</h3>
                    @if($registration->grade !== null)
                        <p class="text-3xl font-bold mt-1 text-primary-600">{{ number_format($registration->grade, 2) }}</p>
                    @else
                        <p class="text-lg font-bold mt-1 text-gray-400">Pending Evaluation</p>
                    @endif
                </div>

                {{-- Rank --}}
                <div class="bg-gray-50 p-4 rounded-xl relative overflow-hidden">
                    <h3 class="text-sm font-medium text-gray-500 relative z-10">Rank</h3>
                    @if($rank !== null)
                        @php
                            $rankStyle = match($rank) {
                                1 => 'text-transparent bg-clip-text bg-gradient-to-r from-yellow-400 via-yellow-200 to-yellow-500',
                                2 => 'text-transparent bg-clip-text bg-gradient-to-r from-gray-300 via-gray-100 to-gray-400',
                                3 => 'text-transparent bg-clip-text bg-gradient-to-r from-orange-700 via-orange-500 to-orange-800',
                                default => 'text-gray-700'
                            };
                            
                            $bgStyle = match($rank) {
                                1 => 'absolute inset-0 bg-gradient-to-br from-yellow-500/10 to-transparent',
                                2 => 'absolute inset-0 bg-gradient-to-br from-gray-400/10 to-transparent',
                                3 => 'absolute inset-0 bg-gradient-to-br from-orange-600/10 to-transparent',
                                default => ''
                            };
                        @endphp
                        
                        <div class="{{ $bgStyle }}"></div>
                        
                        <p class="text-4xl font-extrabold mt-1 relative z-10 {{ $rankStyle }}">
                            #{{ $rank }}
                        </p>
                        
                        @if($rank <= 3)
                            <div class="absolute -right-4 -bottom-4 opacity-20 z-0">
                                <x-heroicon-s-trophy class="w-24 h-24 text-current {{ match($rank) { 1 => 'text-yellow-500', 2 => 'text-gray-400', 3 => 'text-orange-600' } }}" />
                            </div>
                        @endif
                    @else
                        <p class="text-lg font-bold mt-1 text-gray-400">Not Ranked Yet</p>
                    @endif
                </div>
            </div>
        @endif
    </x-filament::section>
</x-filament-widgets::widget>
