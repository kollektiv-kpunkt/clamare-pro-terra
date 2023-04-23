<x-app-layout :title="__('Users')">
    <x-button-bar>
        <x-link-button :href="route('users.create')" class="green">{{__("Create User")}}</x-link-button>
    </x-button-bar>
    <x-app-container>
        <x-page-title>{{ __('Users') }}</x-page-title>
        <x-admin-table>
            <table>
                <thead>
                    <tr>
                        <th>{{ __('Name') }}</th>
                        <th>{{ __('Email') }}</th>
                        <th>{{ __('Verified') }}</th>
                        <th>{{ __('Approved') }}</th>
                        <th>{{ __('Role') }}</th>
                        <th>{{ __('Actions') }}</th>
                    </tr>
                </thead>
                @foreach ($users as $user)
                    <tr>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->email_verified_at ? __('Yes') : __('No') }}</td>
                        <td>{{ $user->approved ? __('Yes') : __('No') }}</td>
                        <td>{{ $user->role }}</td>
                        <td>
                            <x-button-link :href="route('users.edit', $user)">{{ __('Edit') }}</x-button-link>
                            <x-button-link :href="route('users.destroy', $user)" method="delete">{{ __('Delete') }}</x-button-link>
                            <x-button-link :href="route('users.approval', $user)" method="patch" class="{{$user->approved ? 'yellow' : 'green'}}">{{ $user->approved ? __('Unapprove') : __('Approve') }}</x-button-link>
                        </td>
                    </tr>
                @endforeach
            </table>
        </x-admin-table>
    </x-app-container>
</x-app-layout>
