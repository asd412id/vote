<x-guest-layout>
	<x-slot name="title">{{ $title }}</x-slot>
	@livewire('live', ['uuid'=>$uuid])
</x-guest-layout>