@extends('layouts.app', [
    'title' => 'Laravel Mix Extensions',
    'description' => 'Browse packages to extend Laravel Mix and customize it to your own needs.'
])

@section('body')
@include('partials.header', [
    'hide_menu' => true,
])

<div class="max-w-screen-xl px-6 mx-auto">
    <h1 class="py-12 text-center">Discover Laravel Mix Extensions</h1>
    <div class="flex flex-wrap -mx-2 -mb-4">
        @foreach($extensions as $extension)
        <div class="w-full px-2 mb-4 lg:w-1/2 xl:w-1/3">
            <div class="flex flex-col h-48 bg-white border-t-4 border-blue-400 shadow">
                <a href="{{ route('extensions.show', $extension) }}" class="flex flex-col flex-1 p-4 cursor-pointer">
                    <h2 class="mt-0 mb-2 text-xl text-gray-900 hover:text-blue-500">
                        {{ $extension->title }}
                    </h2>
                    <p class="flex-1">
                        {{ \Illuminate\Support\Str::limit($extension->description, 90) }}
                    </p>
                </a>
                <div class="flex justify-between px-4 py-2 text-xs text-blue-700 bg-gray-200 border-t border-gray-400">
                    <div class="font-semibold uppercase">{{ $extension->author_name }}</div>
                    <div class="text-gray-700">{{ $extension->latestVersion }}</div>
                </div>
            </div>
        </div>
        @endforeach
        <div class="w-full py-6 text-center">
            Would you like to be listed on this page? Please open an issue <a href="https://github.com/mvdnbrk/laravel-mix-docs/issues" target="_blank" class="underline hover:no-underline hover:text-gray-900">here</a>
        </div>
    </div>
</div>

<x-footer></x-footer>
@endsection
