<div class="p-3 pb-5 h-full md:h-screen relative" x-data x-init="setInterval(()=>{$refs.refresh.click()},15000)">
	<button class="hidden" wire:click='refresh' x-ref="refresh">Refresh</button>
	<div class="text-center mt-3 font-bold text-3xl">
		@if ($vote->start > now()->toDateTimeString())
		VOTING BELUM DIMULAI
		@elseif ($vote->end < now()->toDateTimeString())
			VOTING TELAH SELESAI
			@else
			LIVE VOTING
			@endif
	</div>
	<div class="text-center mt-3 font-bold text-4xl">{{ $vote->title }}</div>
	@if ($vote->desc)
	<div class="text-center mt-3 text-xl">{{ $vote->desc }}</div>
	@endif
	<div class="text-center mt-3 text-2xl">Jumlah Suara Masuk: {{ $percent }}%</div>

	<div class="mt-5 px-10">
		<div class="flex flex-col md:flex-row gap-5 justify-center">
			@foreach ($vote->candidates as $key => $v)
			@php
			$percent = round($v->voters()->count()/$total*100,2);
			@endphp
			<div class="w-full md:w-3/12">
				<x-card>
					<img src="{{ asset('uploaded/'.$v->image) }}" class="w-full h-full object-cover" alt="">
					<x-slot name="footer">
						<div class="text-center font-bold">
							{{ $v->name }}
						</div>
						<div class="text-center font-bold">
							{{ $percent }}%
						</div>
					</x-slot>
				</x-card>
			</div>
			@endforeach
		</div>
	</div>
</div>