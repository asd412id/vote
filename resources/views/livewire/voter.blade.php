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
										Nama
									</th>
									<th scope="col"
										class="hidden px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase md:table-cell">
										Pemilihan
									</th>
									<th scope="col"
										class="hidden px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase md:table-cell">
										Status
									</th>
									<th scope="col"
										class="hidden px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase md:table-cell">
										Tanggal Memilih
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
										<div class=" flex flex-col gap-1">
											<div class="font-medium text-gray-900">
												{{ $v->name }}
											</div>
											<div class="text-sm text-gray-500 md:hidden">
												Pemilihan: {{ $v->vote->title }}
											</div>
											<div class="text-sm text-gray-500 md:hidden">
												Status:
												@if (!$v->candidate_id)
												<span
													class="inline-flex px-2 text-xs font-semibold leading-5 text-red-800 bg-red-100 rounded-md">
													Belum Memilih
												</span>
												@else
												<span
													class="inline-flex px-2 text-xs font-semibold leading-5 text-green-800 bg-green-100 rounded-md">
													Sudah Memilih
												</span>
												@endif
											</div>
											<div class="text-sm text-gray-500 md:hidden">
												Tanggal Memilih: {{ $v->voted_time?$v->voted_time->format('d/m/Y H:i'):'-' }}
											</div>
										</div>
									</td>
									<td class="hidden px-6 py-4 md:table-cell">
										<div class="text-sm text-gray-900">{{ $v->vote->title }}</div>
									</td>
									<td class="hidden px-6 py-4 md:table-cell whitespace-nowrap">
										<div class="text-sm text-gray-900">
											@if (!$v->candidate_id)
											<span class="inline-flex px-2 text-xs font-semibold leading-5 text-red-800 bg-red-100 rounded-md">
												Belum Memilih
											</span>
											@else
											<span
												class="inline-flex px-2 text-xs font-semibold leading-5 text-green-800 bg-green-100 rounded-md">
												Sudah Memilih
											</span>
											@endif
										</div>
									</td>
									<td class="hidden px-6 py-4 md:table-cell">
										<div class="text-sm text-gray-900">{{ $v->voted_time?$v->voted_time->format('d/m/Y H:i'):'-' }}
										</div>
									</td>
									<td class="px-6 py-4 text-sm font-medium text-right whitespace-nowrap">
										<div class="flex justify-end gap-2">
											<x-button xs type='button' negative icon="trash" title="Hapus"
												wire:click="delete('{{ $v->id }}')" />
										</div>
									</td>
								</tr>
								@endforeach
								@else
								<tr>
									<td colspan="5" class="p-3 text-center">{{ $search?'Data tidak ditemukan':'Data
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

	<x-modal.card title="{{ $modalTitle }}" wire:model.defer="openModal" maxWidth="md" x-data>
		<form x-trap="$wire.openModal" wire:submit.prevent='{{ $ID==null?' store':'update' }}'>
			<div class="flex flex-col gap-3">
				<x-native-select label='Pemilihan' placeholder='Pilih Pemilihan' wire:model.defer='pemilihan'>
					<option value="">Pilih Pemilihan</option>
					@foreach ($votes as $v)
					<option value="{{ $v['id'] }}">{{ $v['title'] }}</option>
					@endforeach
				</x-native-select>
				<x-input type='text' label='Prefix Nama Peserta' placeholder='Masukkan Prefix Nama Peserta'
					wire:model.defer='prefix_nama' />
				<x-input type='number' label='Jumlah Peserta' placeholder='Masukkan Jumlah Peserta'
					wire:model.defer='jumlah_peserta' />
			</div>
			<div class="flex justify-end mt-5 gap-x-4">
				<x-button flat label="BATAL" x-on:click="close" />
				<x-button type='submit' primary label="GENERATE PESERTA" />
			</div>
		</form>
	</x-modal.card>
</div>