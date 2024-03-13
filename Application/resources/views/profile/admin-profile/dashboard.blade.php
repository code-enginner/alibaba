<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="my-3 mx-5 text-center">
        @if($errors->any())
            @foreach($errors->all() as $error)
                <div class="my-3 py-6 border rounded border-[#ffcdd2] bg-[#ffebee] text-[#f44336]">{{ $error }}</div>
            @endforeach
        @endif
    </div>

    <div class="my-3 mx-5 text-center">
        @if(session('success'))
            <div class="my-3 py-6 border rounded border-[#c8e6c9] bg-[#e8f5e9] text-[#4caf50]">{{ session('success') }}</div>
        @endif
    </div>

    <div class="mt-[4rem] mx-3">
        <x-article.show :articles="$articles"></x-article.show>
    </div>


</x-app-layout>
