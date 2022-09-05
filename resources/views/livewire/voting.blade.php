<div class="p-3 h-screen relative" x-data="{choice: $wire.choice,dialog: false}">
	<a href="{{ route('voter.logout') }}"
		class="fixed bottom-5 right-5 bg-red-600 shadow-md hover:bg-red-700 active:shadow-none active:bg-red-900 text-white rounded-md py-1 px-4">Logout</a>
	<div class="text-center mt-3 font-bold text-3xl">SELAMAT DATANG</div>
	<div class="text-center mt-3 font-bold text-4xl">{{ $vote->title }}</div>
	@if ($vote->desc)
	<div class="text-center mt-3 text-xl">{{ $vote->desc }}</div>
	@endif

	<div class="mt-5 px-10 pb-5">
		@if ($vote->start > now()->toDateTimeString())
		<div class="text-4xl mt-10 text-center font-bold italic text-red-600">Maaf, Proses {{ $vote->title }} akan dibuka
			pada {{
			$vote->start->format('d/m/Y H:i') }}</div>
		@elseif($vote->end < now()->toDateTimeString())
			<div class="text-4xl mt-10 text-center font-bold italic text-red-600">Maaf, Proses {{ $vote->title }} telah
				berakhir pada {{ $vote->end->format('d/m/Y H:i') }}!</div>
			@elseif(!$vote->status)
			<div class="text-4xl mt-10 text-center font-bold italic text-red-600">Maaf, Proses {{ $vote->title }} belum dapat
				dilakukan!</div>
			@else
			<div class="flex flex-col md:flex-row gap-5 justify-center">
				@foreach ($vote->candidates as $key => $v)
				<div class="w-full md:w-3/12 cursor-pointer" x-on:click="!$wire.hasChoosed?(choice={{ $v->id }}):null">
					<x-card x-bind:class="choice=={{ $v->id }}?'bg-info-400':''">
						<img src="{{ asset('uploaded/'.$v->image) }}" class="w-full h-full object-cover" alt="">
						<x-slot name="footer">
							<div class="text-center font-bold">
								{{ $v->name }}
							</div>
						</x-slot>
					</x-card>
				</div>
				@endforeach

			</div>
			@if (!$hasChoosed)
			<div class="mt-9 flex justify-center">
				<x-button x-bind:disabled="choice==null" info class="py-3 px-5 text-3xl" label="SIMPAN PILIHAN"
					x-on:click="dialog=true" />
			</div>
			@else
			<div class="text-center mt-9 text-info-600 font-semibold italic text-xl">Anda sudah memilih pada {{
				auth()->user()->voted_time->format('d/m/Y H:i') }}</div>
			@endif
			@endif
	</div>
	@if (!$hasChoosed)
	<div class="fixed hidden z-10 inset-0 overflow-y-auto" x-bind:class="dialog?'!block':''" aria-labelledby="modal-title"
		role="dialog" aria-modal="true">
		<div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
			<div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>
			<span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
			<div
				class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
				<div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
					<div class="sm:flex sm:items-start">
						<div
							class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
							<svg class="h-6 w-6 text-red-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
								stroke="currentColor" aria-hidden="true">
								<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
									d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
							</svg>
						</div>
						<div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
							<h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">Konfirmasi</h3>
							<div class="mt-2">
								<p class="text-sm text-gray-500">Anda yakin ingin menyimpan pilihan?</p>
							</div>
						</div>
					</div>
				</div>
				<div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
					<button type="button"
						class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm"
						x-on:click='$wire.save(choice)' wire:loading.attr='disabled'>Ya,
						Simpan Pilihan Saya</button>
					<button type="button"
						class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm"
						x-on:click="dialog=false" wire:loading.attr='disabled'>Batal</button>
				</div>
			</div>
		</div>
	</div>
	@endif
</div>
@push('scripts')
<script>
	Livewire.on('success',()=>{
			setTimeout(() => {
				location.href='/logout';
			}, 5000);
		});
</script>
@endpush