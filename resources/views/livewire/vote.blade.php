<div class="px-2 md:px-0">
	@include('admin.page-attr')
	<div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
		<div class="flex flex-col">
			<div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
				<div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
					<div class="overflow-hidden border-b border-gray-200 shadow sm:rounded-lg">
						<table class="min-w-full divide-y divide-gray-200">
							<thead class="bg-gray-50">
								<tr>
									<th scope="col"
										class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
										Judul
									</th>
									<th scope="col"
										class="hidden px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase md:table-cell">
										Deskripsi
									</th>
									<th scope="col"
										class="hidden px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase md:table-cell">
										Mulai
									</th>
									<th scope="col"
										class="hidden px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase md:table-cell">
										Selesai
									</th>
									<th scope="col"
										class="hidden px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase md:table-cell">
										Jumlah Peserta
									</th>
									<th scope="col"
										class="hidden px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase md:table-cell">
										Status
									</th>
									<th scope="col" class="relative px-6 py-3">
										<span class="sr-only">Edit</span>
									</th>
								</tr>
							</thead>
							<tbody class="bg-white divide-y divide-gray-200">
								@if (count($data))
								@foreach ($data as $v)
								<tr>
									<td class="px-6 py-4">
										<div class="flex flex-col gap-1">
											<div class="font-medium text-gray-900">
												{{ $v->title }}
											</div>
											<div class="text-sm text-gray-500 md:hidden">
												Deskripsi: {{ $v->desc }}
											</div>
											<div class="text-sm text-gray-500 md:hidden">
												Mulai: {{ $v->start->format('d/m/Y H:i') }}
											</div>
											<div class="text-sm text-gray-500 md:hidden">
												Selesai: {{ $v->end->format('d/m/Y H:i') }}
											</div>
											<div class="text-sm text-gray-500 md:hidden">
												Peserta: {{ $v->voters()->count() }}
											</div>
											<div class="text-sm text-gray-500 md:hidden whitespace-nowrap">
												@if (!$v->status)
												<span
													class="inline-flex px-2 text-xs font-semibold leading-5 text-red-800 bg-red-100 rounded-md">
													Tidak Aktif
												</span>
												@elseif ($v->status)
												<span
													class="inline-flex px-2 text-xs font-semibold leading-5 text-green-800 bg-green-100 rounded-md">
													Aktif
												</span>
												@endif
											</div>
										</div>
									</td>
									<td class="hidden px-6 py-4 md:table-cell">
										<div class="text-sm text-gray-900">{{ $v->desc??'-' }}</div>
									</td>
									<td class="hidden px-6 py-4 md:table-cell">
										<div class="text-sm text-gray-900">{{ $v->start->format('d/m/Y H:i') }}</div>
									</td>
									<td class="hidden px-6 py-4 md:table-cell">
										<div class="text-sm text-gray-900">{{ $v->end->format('d/m/Y H:i') }}</div>
									</td>
									<td class="hidden px-6 py-4 md:table-cell">
										<div class="text-sm text-gray-900">{{ $v->voters()->count() }}</div>
									</td>
									<td class="hidden px-6 py-4 md:table-cell whitespace-nowrap">
										@if (!$v->status)
										<span class="inline-flex px-2 text-xs font-semibold leading-5 text-red-800 bg-red-100 rounded-md">
											Tidak Aktif
										</span>
										@elseif ($v->status)
										<span
											class="inline-flex px-2 text-xs font-semibold leading-5 text-green-800 bg-green-100 rounded-md">
											Aktif
										</span>
										@endif
									</td>
									<td class="px-6 py-4 text-sm font-medium text-right whitespace-nowrap">
										<div class="flex justify-end gap-2" x-data>
											<x-button xs type='button' positive icon="desktop-computer" title="Live Voting"
												x-on:click="$refs.live.click()" />
											<a href="{{ route('live',['uuid'=>$v->uuid]) }}" target="_blank" x-ref="live" class="hidden"></a>
											<x-button xs type='button' warning icon="pencil" title="Ubah" wire:click="edit('{{ $v->id }}')" />
											<x-button xs type='button' negative icon="trash" title="Hapus"
												wire:click="delete('{{ $v->id }}')" />
										</div>
									</td>
								</tr>
								@endforeach
								@else
								<tr>
									<td colspan="7" class="p-3 text-center">{{ $search?'Data tidak ditemukan':'Data
										tidak tersedia' }}
									</td>
								</tr>
								@endif
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="px-2 py-2 md:px-0">
		{!! $data->links() !!}
	</div>

	<x-modal.card title="{{ $modalTitle }}" wire:model.defer="openModal" maxWidth="md" x-data
		x-on:open="$nextTick(()=>{$refs.autofocus.focus()})">
		<form x-trap="$wire.openModal" wire:submit.prevent='{{ $ID==null?' store':'update' }}'>
			<div class="flex flex-col gap-3">
				<x-input type='text' label='Judul Voting' placeholder='Masukkan Judul Voting' wire:model.defer='judul_voting'
					x-ref="autofocus" />
				<x-textarea label='Deskripsi' placeholder='Masukkan Deskripsi' wire:model.defer='deskripsi' />
				<x-datetime-picker label="Waktu Mulai" placeholder="Masukkan Waktu Mulai" display-format="DD/MM/YYYY HH:mm"
					parse-format="YYYY-MM-DD HH:mm" wire:model.defer="waktu_mulai" without-timezone />
				<x-datetime-picker label="Waktu Selesai" placeholder="Masukkan Waktu Selesai" display-format="DD/MM/YYYY HH:mm"
					parse-format="YYYY-MM-DD HH:mm" wire:model.defer="waktu_selesai" without-timezone />
				<x-select label='Status' placeholder='Pilih Status' wire:model.defer='status' :options="[
        ['name' => 'Aktif',  'id' => 1],
        ['name' => 'Tidak Aktif',  'id' => 0],
    ]" option-label="name" option-value="id" />
			</div>
			<div class="flex justify-end mt-5 gap-x-4">
				<x-button flat label="BATAL" x-on:click="close" />
				<x-button type='submit' primary label="SIMPAN" />
			</div>
		</form>
	</x-modal.card>
</div>