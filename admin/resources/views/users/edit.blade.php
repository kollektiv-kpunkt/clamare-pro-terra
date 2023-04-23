<x-app-layout :title="__('Edit user') . ' : ' . $user->name">
    <x-app-container>
        <x-page-title>{{__('User Details')}}</x-page-title>
        <form action="{{route('users.update', $user)}}" method="POST" class="cpt-form">
            @method('PATCH')
            @csrf
            <x-form-group name="name" :label="__('Username')" :required="true" :value="$user->name"/>
            <x-form-group name="email" :label="__('Email address')" :required="true" :value="$user->email" type="email"/>
            <x-form-group name="role" :label="__('Role')" :required="true" :value="$user->role" type="select" :fullwidth="true" :options="['user', 'manager', 'admin']"/>
            <x-primary-button type="submit">{{__('Create User')}}</x-primary-button>
        </form>
    </x-app-container>
</x-app-layout>
