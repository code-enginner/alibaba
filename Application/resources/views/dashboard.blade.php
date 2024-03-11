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

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    <!--Tabs navigation-->
                    <ul
                        class="mb-5 flex list-none flex-row flex-wrap border-b-0 ps-0"
                        role="tablist"
                        data-twe-nav-ref>
                        <li role="presentation">
                            <a
                                href="#tabs-home"
                                class="my-2 block border-x-0 border-b-2 border-t-0 border-transparent px-7 pb-3.5 pt-4 text-xs font-medium uppercase leading-tight text-neutral-500 hover:isolate hover:border-transparent hover:bg-neutral-100 focus:isolate focus:border-transparent data-[twe-nav-active]:border-primary data-[twe-nav-active]:text-primary dark:text-white/50 dark:hover:bg-neutral-700/60 dark:data-[twe-nav-active]:text-primary"
                                data-twe-toggle="pill"
                                data-twe-target="#tabs-home"
                                data-twe-nav-active
                                role="tab"
                                aria-controls="tabs-home"
                                aria-selected="true"
                            >Articles List</a
                            >
                        </li>

                        <li role="presentation">
                            <a
                                href="#tabs-profile"
                                class="my-2 block border-x-0 border-b-2 border-t-0 border-transparent px-7 pb-3.5 pt-4 text-xs font-medium uppercase leading-tight text-neutral-500 hover:isolate hover:border-transparent hover:bg-neutral-100 focus:isolate focus:border-transparent data-[twe-nav-active]:border-primary data-[twe-nav-active]:text-primary dark:text-white/50 dark:hover:bg-neutral-700/60 dark:data-[twe-nav-active]:text-primary"
                                data-twe-toggle="pill"
                                data-twe-target="#tabs-profile"
                                role="tab"
                                aria-controls="tabs-profile"
                                aria-selected="false"
                            >New Article</a
                            >
                        </li>
                    </ul>

                    <!--Tabs content-->
                    <div class="mb-6">
                        <div
                            class="hidden opacity-100 transition-opacity duration-150 ease-linear data-[twe-tab-active]:block"
                            id="tabs-home"
                            role="tabpanel"
                            aria-labelledby="tabs-home-tab"
                            data-twe-tab-active>

                            <x-article.show :articles="$articles"></x-article.show>
                        </div>

                        <div
                            class="hidden opacity-0 transition-opacity duration-150 ease-linear data-[twe-tab-active]:block"
                            id="tabs-profile"
                            role="tabpanel"
                            aria-labelledby="tabs-profile-tab">

                            <form action="{{ route('article.store') }}" method="post">
                                @csrf

                                <div class="relative mb-3" data-twe-input-wrapper-init>
                                    <input
                                        type="text"
                                        class="peer block min-h-[auto] w-full rounded border-0 bg-transparent px-3 py-[0.32rem] leading-[1.6] outline-none transition-all duration-200 ease-linear focus:placeholder:opacity-100 peer-focus:text-primary data-[twe-input-state-active]:placeholder:opacity-100 motion-reduce:transition-none dark:text-white dark:placeholder:text-neutral-300 dark:autofill:shadow-autofill dark:peer-focus:text-primary [&:not([data-twe-input-placeholder-active])]:placeholder:opacity-0"
                                        id="title"
                                        name="title"
                                        placeholder="title"/>
                                    <label
                                        for="title"
                                        class="pointer-events-none absolute left-3 top-0 mb-0 max-w-[90%] origin-[0_0] truncate pt-[0.37rem] leading-[1.6] text-neutral-500 transition-all duration-200 ease-out peer-focus:-translate-y-[0.9rem] peer-focus:scale-[0.8] peer-focus:text-primary peer-data-[twe-input-state-active]:-translate-y-[0.9rem] peer-data-[twe-input-state-active]:scale-[0.8] motion-reduce:transition-none dark:text-neutral-400 dark:peer-focus:text-primary"
                                    >title
                                    </label>
                                </div>

                                <div class="relative mb-3" data-twe-input-wrapper-init>
                                  <textarea
                                      class="peer block min-h-[auto] w-full rounded border-0 bg-transparent px-3 py-[0.32rem] leading-[1.6] outline-none transition-all duration-200 ease-linear focus:placeholder:opacity-100 peer-focus:text-primary data-[twe-input-state-active]:placeholder:opacity-100 motion-reduce:transition-none dark:text-white dark:placeholder:text-neutral-300 dark:peer-focus:text-primary [&:not([data-twe-input-placeholder-active])]:placeholder:opacity-0"
                                      id="content"
                                      rows="4"
                                      name="content"
                                      placeholder="content"></textarea>
                                    <label
                                        for="content"
                                        class="pointer-events-none absolute left-3 top-0 mb-0 max-w-[90%] origin-[0_0] truncate pt-[0.37rem] leading-[1.6] text-neutral-500 transition-all duration-200 ease-out peer-focus:-translate-y-[0.9rem] peer-focus:scale-[0.8] peer-focus:text-primary peer-data-[twe-input-state-active]:-translate-y-[0.9rem] peer-data-[twe-input-state-active]:scale-[0.8] motion-reduce:transition-none dark:text-neutral-400 dark:peer-focus:text-primary"
                                    >content
                                    </label>
                                </div>

                                <div>
                                    <button
                                        type="submit"
                                        class="inline-block rounded bg-primary px-6 pb-2 pt-2.5 text-xs font-medium uppercase leading-normal text-white shadow-primary-3 transition duration-150 ease-in-out hover:bg-primary-accent-300 hover:shadow-primary-2 focus:bg-primary-accent-300 focus:shadow-primary-2 focus:outline-none focus:ring-0 active:bg-primary-600 active:shadow-primary-2 motion-reduce:transition-none dark:shadow-black/30 dark:hover:shadow-dark-strong dark:focus:shadow-dark-strong dark:active:shadow-dark-strong">
                                        register
                                    </button>
                                </div>

                            </form>

                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
