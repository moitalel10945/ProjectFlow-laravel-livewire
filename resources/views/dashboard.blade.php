<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
        <h2 class="font-semibold text-xl  leading-tight {{ Auth::user()->role ==='admin' ? 'text-red-800' :(Auth::user()->role==='manager' ? 'text-green-800' :'text-blue-800') }}">
            {{ Auth::user()->name }}
        </h2>
        <span class="text-underline {{ Auth::user()->role ==='admin' ? 'text-red-800' :(Auth::user()->role==='manager' ? 'text-green-800' :'text-blue-800') }}">{{ ucfirst( Auth::user()->role ) }}</span>
        
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <livewire:manage-projects/>
                   {{-- -  <livewire:manage-tasks/>--}}
                </div>
            </div>
        </div>
    </div>
    
</x-app-layout>
