<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="w-80 md:w-full mx-auto sm:px-6 lg:px-8">

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                @foreach ($friends as $friend )
                <div class="bg-white shadow-md border border-gray-200 rounded-lg max-w-sm">
                    <img class="rounded-t-lg w-80 h-80 md:h-96 md:w-96" src="{{ $friend->avatar() }}" alt="{{ $friend->name }}" />
                    <div class="p-5">
                        <div>
                            <h5 class="text-gray-900 font-bold text-2xl tracking-tight mb-2 text-center">
                                {{ $friend->name }}
                            </h5>
                        </div>
                        <a href="#"
                            class="text-white bg-red-700 hover:bg-red-800 font-medium rounded-lg text-sm px-3 py-2 text-center items-center inline-block w-full">
                            Delete friend
                        </a>
                    </div>
                </div>
                @endforeach
            </div>

            @if($friends->isEmpty())
            <div class="bg-green-100 rounded-lg p-4 mb-4 text-sm text-green-700 text-center">
                <span class="bg-green-100 text-green-800 text-lg mr-2 px-2.5 py-0.5 rounded-md">You still
                    don't have friends</span>
                <div class="mt-4 p-2">
                    <a href="{{ route('users.show', auth()->user()) }}"
                        class="bg-green-700 hover:bg-green-900 py-2 px-3 rounded text-white text-sm">Go back</a>
                </div>
            </div>  
            @endif

        </div>
    </div>
</x-app-layout>