@props(['disabled' => false])

<textarea {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'shadow-sm focus:ring-rose-500 focus:border-rose-500 mt-1 block w-full sm:text-sm border-gray-300 rounded-md', "rows" => 6]) !!}>{{$value}}</textarea>
