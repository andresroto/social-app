<x-app-layout>
    <div
        class="sm:my-12 pb-6 w-full justify-center items-center overflow-hidden md:max-w-3xl rounded-lg shadow-sm mx-auto">
        <div class="relative h-80">
            <img class="absolute h-full w-full object-cover" src="https://picsum.photos/400">
        </div>
        <div class="relative shadow mx-auto h-40 w-40 -my-12 border-white rounded-full overflow-hidden border-4">
            <img class="object-cover w-full h-full" src="{{ $user->avatar() }}" alt="{{ $user->name }}">
        </div>
        <div class="mt-16 bg-white">
            <h1 class="text-lg text-center font-semibold">
                {{ $user->name }}
            </h1>
            <div class="text-sm text-gray-600 text-center">
                <h3 class="text-gray-700 font-lg text-semibold leading-6">{{ $user->email }}</h3>

                @if(Auth::id() === $user->id)
                <div class="p-4 grid grid-cols-1 md:grid-cols-2 gap-4 w-72 md:w-96 mx-auto">
                    <a href="{{ route('friends.index') }}" class="bg-gray-700 hover:bg-gray-900 py-1 px-2 rounded text-white text-sm">Friends</a>
                    <a href="{{ route('accept-friendships.index') }}" class="bg-green-700 hover:bg-green-900 py-1 px-2 rounded text-white text-sm">Friend Requests</a>
                </div>
                @else
                <friendship-btn friendship-status="{{ $friendshipStatus }}" :recipient="{{ $user }}">
                </friendship-btn>
                @endif

                <ul
                    class="bg-gray-100 text-gray-600 hover:text-gray-700 hover:shadow py-2 px-3 mt-3 divide-y rounded shadow-sm">
                    <li class="flex items-center py-3">
                        <span>Status</span>
                        <span class="ml-auto"><span
                                class="bg-gray-900 py-1 px-2 rounded text-white text-sm">Active</span></span>
                    </li>
                    <li class="flex items-center py-3">
                        <span>Member since</span>
                        <span class="ml-auto">{{ $user->created_at->format('Y') }}</span>
                    </li>
                </ul>
            </div>
        </div>
        <div class="mt-6 pt-3 flex flex-wrap mx-6 border-t">
            <div class="w-full">
                <status-list url="{{ route('users.statuses.index', $user) }}"></status-list>
            </div>
        </div>
    </div>
</x-app-layout>