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
										class="hidden px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase md:table-cell">
										Gambar
									</th>
									<th scope="col"
										class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
										Nama
									</th>
									<th scope="col"
										class="hidden px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase md:table-cell">
										Deskripsi
									</th>
									<th scope="col"
										class="hidden px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase md:table-cell">
										Pemilihan
									</th>
									<th scope="col"
										class="hidden px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase md:table-cell">
										Jumlah Pemilih
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
									<td class="hidden px-6 py-4 md:table-cell"><img
											src="{{ $v->image?asset('uploaded/'.$v->image):asset('img/noimage.png') }}" alt=""
											class="w-24 h-auto rounded-md">
									</td>
									<td class="px-6 py-4 >
										<div class=" flex flex-col gap-1">
										<img src="{{ $v->image?asset('uploaded/'.$v->image):asset('img/noimage.png') }}" alt=""
											class="md:hidden w-24 h-auto rounded-md">
										<div class="font-medium text-gray-900">
											{{ $v->name }}
										</div>
										<div class="text-sm text-gray-500 md:hidden">
											Deskripsi: {{ $v->desc }}
										</div>
										<div class="text-sm text-gray-500 md:hidden">
											Pemilihan: {{ $v->vote->title }}
										</div>
										<div class="text-sm text-gray-500 md:hidden">
											Jumlah Pemilih: {{ $v->voters()->count() }}
										</div>
					</div>
					</td>
					<td class="hidden px-6 py-4 md:table-cell">
						<div class="text-sm text-gray-900">{{ $v->desc??'-' }}</div>
					</td>
					<td class="hidden px-6 py-4 md:table-cell">
						<div class="text-sm text-gray-900">{{ $v->vote->title }}</div>
					</td>
					<td class="hidden px-6 py-4 md:table-cell">
						<div class="text-sm text-gray-900">{{ $v->voters()->count() }}</div>
					</td>
					<td class="px-6 py-4 text-sm font-medium text-right whitespace-nowrap">
						<div class="flex justify-end gap-2">
							<x-button xs type='button' warning icon="pencil" title="Ubah" wire:click="edit('{{ $v->id }}')" />
							<x-button xs type='button' negative icon="trash" title="Hapus" wire:click="delete('{{ $v->id }}')" />
						</div>
					</td>
					</tr>
					@endforeach
					@else
					<tr>
						<td colspan="6" class="p-3 text-center">{{ $search?'Data tidak ditemukan':'Data
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
			<x-input type='text' label='Nama Kandidat' placeholder='Masukkan Nama Kandidat'
				wire:model.defer='nama_kandidat' />
			<x-textarea label='Deskripsi' placeholder='Masukkan Deskripsi' wire:model.defer='deskripsi' />
			<div class="flex flex-1 gap-2 justify-between">
				<div class="w-7/12 min-h-32 rounded-md overflow-hidden border border-gray-300 shadow-sm">
					<img
						src="{{ $ID&&!$imageChanged?asset('uploaded/'.$gambarUrl):($gambarUrl&&($mime=='jpg'||$mime=='png')?$gambar->temporaryUrl():asset('img/noimage.png')) }}"
						class="w-full" alt="No Image Avaliable">
				</div>
				<div class="w-5/12">
					<input type="file" wire:model='gambar' class="hidden" x-ref="fgambar">
					<x-button type="button" outline secondary label="Upload" icon="upload" x-on:click='$refs.fgambar.click()' />
					@error('gambar') <span class="my-1 text-red-600">{{ $message }}</span> @enderror
				</div>
			</div>
		</div>
		<div class="flex justify-end mt-5 gap-x-4">
			<x-button flat label="BATAL" x-on:click="close" />
			<x-button type='submit' primary label="SIMPAN" />
		</div>
	</form>
</x-modal.card>
</div>