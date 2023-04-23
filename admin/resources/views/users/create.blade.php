<x-app-layout :title="__('Create a new User')">
    <x-app-container>
        <x-page-title>{{__('User Details')}}</x-page-title>
        <form action="{{route('users.store')}}" method="POST" class="cpt-form">
            @csrf
            <x-form-group name="name" :label="__('Username')" :required="true" :value="old('name')"/>
            <x-form-group name="email" :label="__('Email address')" :required="true" :value="old('email')" type="email"/>
            <x-form-group name="role" :label="__('Role')" :required="true" :value="old('role')" type="select" :fullwidth="true" :options="['user', 'manager', 'admin']"/>
            <x-primary-button type="submit">{{__('Create User')}}</x-primary-button>
        </form>
    </x-app-container>
</x-app-layout>
