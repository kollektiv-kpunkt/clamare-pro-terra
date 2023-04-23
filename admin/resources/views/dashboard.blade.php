<x-app-layout :title="__('Dashboard')">
    <p class="mb-6 italic opacity-75 text-xs" style="margin-top: -1rem">{{ __("Welcome")}}, {{request()->user()->name}}!</p>
</x-app-layout>
