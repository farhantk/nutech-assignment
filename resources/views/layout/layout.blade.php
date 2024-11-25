@extends('layout.head')
@extends('layout.sidebar')

<div class="p-4 sm:ml-64">
    <div class="p-4 border-2 border-gray-200 border-dashed rounded-lg dark:border-gray-700">
        @yield('content')
    </div>
</div>