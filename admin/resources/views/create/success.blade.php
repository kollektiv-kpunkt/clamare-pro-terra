<x-guest-layout>
    <h1 class="text-2xl !leading-none text-center font-black uppercase text-rose-500">{{__("Success!")}}</h1>
    <div class="text-xl">
        <p class="mt-4">{{__("Your event has been created successfully.")}}</p>
        @if (session()->get("response"))
            <p class="mt-4">{!! session()->get("response")["message"] !!}</p>
        @endif
    </div>
</x-guest-layout>
