<div class="rpc-button-link">
    @if ($method === 'delete')
        <form action="{{ $href }}" method="POST">
            @csrf
            @method('DELETE')
            <button type="submit" {{$attributes->merge(["class" => "rpc-button-link-text red"])}}>{{ $slot }}</button>
        </form>
    @elseif ($method === 'patch')
        <form action="{{ $href }}" method="POST">
            @csrf
            @method('PATCH')
            <button type="submit" {{$attributes->merge(["class" => "rpc-button-link-text"])}}>{{ $slot }}</button>
        </form>
    @else
        <a href="{{ $href }}" {{$attributes->merge(["class" => "rpc-button-link-text"])}}>{{ $slot }}</a>
    @endif
</div>
