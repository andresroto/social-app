<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="overflow-hidden shadow-sm sm:rounded-lg">
                    @foreach ($friendshipRequests as $friendshipRequest)
                    <accept-friendship-btn :sender="{{ $friendshipRequest->sender }}"
                        friendship-status="{{ $friendshipRequest->status }}">
                    </accept-friendship-btn>
                    @endforeach
            </div>
        </div>
    </div>
</x-app-layout>