<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>


    <div class="flex justify-between ">
        <div class="mt-5 px-4">  {{ $article->user->full_name }} :نویسنده </div>
        <div class="mt-5 px-4">  {{ $article->title }} :عنوان </div>
        <div class="mt-5 px-4"> تاریخ انتشار: {{ $article->publish_date }}</div>
    </div>

    <div class="mt-[4rem] px-4 text-center">
        {{ $article->content }}
    </div>

</x-app-layout>
