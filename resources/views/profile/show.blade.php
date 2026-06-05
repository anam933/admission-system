<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $user->name }}'s Profile
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <!-- Profile Card -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-gray-900">
                    <div class="space-y-6">
                        <!-- Profile Header -->
                        <div class="pb-6 border-b border-gray-200">
                            <h3 class="text-2xl font-bold text-gray-800 mb-2">
                                {{ $user->name }}
                            </h3>
                            <p class="text-sm text-gray-500">{{ $user->role|ucfirst }}</p>
                        </div>

                        <!-- Profile Information -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-500 mb-1">
                                    Full Name
                                </label>
                                <p class="text-lg font-semibold text-gray-900">
                                    {{ $user->name }}
                                </p>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-500 mb-1">
                                    Email Address
                                </label>
                                <p class="text-lg font-semibold text-gray-900">
                                    {{ $user->email }}
                                </p>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-500 mb-1">
                                    Role
                                </label>
                                <p class="text-lg font-semibold text-gray-900">
                                    <span class="px-3 py-1 rounded-full text-sm font-medium 
                                        @if($user->role === 'admin')
                                            bg-red-100 text-red-800
                                        @elseif($user->role === 'manager')
                                            bg-blue-100 text-blue-800
                                        @else
                                            bg-green-100 text-green-800
                                        @endif
                                    ">
                                        {{ ucfirst($user->role) }}
                                    </span>
                                </p>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-500 mb-1">
                                    Member Since
                                </label>
                                <p class="text-lg font-semibold text-gray-900">
                                    {{ $user->created_at->format('M d, Y') }}
                                </p>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex gap-4 pt-6 border-t border-gray-200">
                            @if(auth()->user()->id === $user->id)
                                <a href="{{ route('profile.edit') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 transition ease-in-out duration-150">
                                    Edit Profile
                                </a>
                            @elseif(auth()->user()->role === 'admin')
                                <a href="{{ route('admin.edit', $user->id) }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 transition ease-in-out duration-150">
                                    Edit User
                                </a>
                            @endif

                            <a href="javascript:history.back()" class="inline-flex items-center px-4 py-2 bg-gray-300 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-400 transition ease-in-out duration-150">
                                Back
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
