<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Roles') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <!-- Content Starts Here -->
                    <section>
                        <header>
                            <h2 class="text-lg font-medium text-gray-900">
                                {{ __('Show Role') }}
                            </h2>

                            <p class="mt-1 text-sm text-gray-600">
                                {{ __("Here is the details of the selected role.") }}
                            </p>
                        </header>

                        <div class="mt-6">
                            <p class="text-black text-base font-light leading-relaxed">{{ __('Name') }}:</p>
                            <p class="text-neutral-500 text-base font-light leading-relaxed">{{ $role->role_name }}</p>
                        </div>

                        <div class="mt-2">
                            <p class="text-black text-base font-light leading-relaxed">{{ __('Created At') }}:</p>
                            <p class="text-neutral-500 text-base font-light leading-relaxed">{{ $role->created_at }}</p>
                        </div>

                        <div class="flex justify-end mt-6 space-x-1">
                            <a href="{{ route('roles.edit', $role->id) }}">
                                <x-primary-button>
                                    {{ __('Edit') }}
                                </x-primary-button>
                            </a>

                            <form method="post" action="{{ route('roles.destroy', $role->id) }}"> @csrf @method('DELETE')
                                <x-danger-button>
                                    {{ __('Delete') }}
                                </x-danger-button>
                            </form>
                        </div>

                    </section>
                    <!-- Content Ends Here -->
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
