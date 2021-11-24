<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8" style="height: 2000px;">
            <status-list-item :status="{{ json_encode($status) }}"></status-list-item>
        </div>
    </div>
</x-app-layout>