<div class="cpt-form-group{{$fullwidth ? ' fullwidth' : ''}}">
    <x-input-label for="{{$name}}" :value="$label" />
    @if (in_array($type, ["text", "email", "password", "number", "datetime-local", "url"]))
        <x-text-input {{$attributes}} id="{{$name}}" name="{{$name}}" type="{{$type}}" :required="$required" :value="$value" autofocus />
    @elseif ($type == "textarea")
        <x-textarea-input id="{{$name}}" name="{{$name}}" :required="$required" :value="$value" autofocus />
    @elseif ($type == "select")
        <x-select-input id="{{$name}}" name="{{$name}}" :required="$required" :value="$value" autofocus>
            <option value="">{{__('Please select an option')}}</option>
            @foreach ($options as $option)
                <option value="{{$option}}" {{$value == $option ? " selected" : ""}}>{{$option}}</option>
            @endforeach
        </x-select-input>
    @endif
    <x-input-error class="mt-2" :messages="$errors->get($name)" />
</div>
