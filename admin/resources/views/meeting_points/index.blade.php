<x-app-layout :title="__('Meeting Points')">
    <x-button-bar>
        <x-link-button :href="route('meeting_points.create')" class="green">{{__("Create Meeting Point")}}</x-link-button>
    </x-button-bar>
    <x-app-container>
        <x-page-title>{{ __('Meeting Points') }}</x-page-title>
        @if ($meetingPoints->isEmpty())
            <p>{{ __('No meeting points found.') }}</p>
        @else
        <x-admin-table>
            <table>
                <thead>
                    <tr>
                        <th>{{ __('Title') }}</th>
                        <th>{{ __('Location') }}</th>
                        <th>{{ __('Date') }}</th>
                        <th>{{ __('Time') }}</th>
                        <th>{{ __('Approved') }}</th>
                        <th>{{ __('User')}}</th>
                        <th>{{ __('Actions') }}</th>
                    </tr>
                </thead>
                @foreach ($meetingPoints as $meetingPoint)
                    <tr>
                        <td><a href="{{route('meeting_points.show', $meetingPoint)}}" class="underline text-rose-600">{{ $meetingPoint->title }}</a></td>
                        <td>{{ $meetingPoint->location }}</td>
                        <td>{{ $meetingPoint->meeting_time->format("d.m.y") }}</td>
                        <td>{{ $meetingPoint->meeting_time->format("H:i") }}</td>
                        <td>{{ $meetingPoint->approved ? __('approved') : __('pending') }}</td>
                        <td>{{ $meetingPoint->user->name }}</td>
                        <td>
                            <x-button-link :href="route('meeting_points.edit', $meetingPoint)">{{ __('Edit') }}</x-button-link>
                            <x-button-link :href="route('meeting_points.destroy', $meetingPoint)" method="delete">{{ __('Delete') }}</x-button-link>
                            @if (request()->user()->hasAnyRole(['admin', 'manager']))
                                <x-button-link :href="route('meeting_points.approval', $meetingPoint)" method="patch" class="{{$meetingPoint->approved ? 'yellow' : 'green'}}">{{ $meetingPoint->approved ? __('Unapprove') : __('Approve') }}</x-button-link>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </table>
        </x-admin-table>
        @if ($meetingPoints->hasPages())
            <div class="mt-8">
                {{ $meetingPoints->links() }}
            </div>
        @endif
        @endif
    </x-app-container>
</x-app-layout>
