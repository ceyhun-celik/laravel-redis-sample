<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <!-- Content Starts Here -->
                    <div class="flex justify-between">
                        @include('dashboard.partials.search')

                        <a href="{{ route('dashboard.create') }}">
                            <x-primary-button>
                                {{ __('Create') }}
                            </x-primary-button>
                        </a>
                    </div>
                    @include('dashboard.partials.table')
                    <!-- Content Ends Here -->
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
