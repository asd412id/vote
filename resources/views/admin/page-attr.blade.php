<div x-data class="flex flex-col justify-center gap-2 py-2 md:flex-row md:justify-between">
  <div class="flex gap-2">
    <x-button primary label="Tambah Data" wire:click="create" x-ref="newdata" />
    @if (request()->is('*peserta*')||request()->is('*message/voter*'))
    <x-button negative icon="trash" label="Hapus Semua" wire:click="deleteAll" />
    <x-button info icon="printer" label="Cetak Kartu" wire:click="print" />
    @endif
  </div>
  <div class="flex gap-2">
    <div class="flex items-center w-full gap-2 md:w-52">
      <label>Ditampilkan:</label>
      <x-select :options='[10,15,20,30,50,100, 500]' placeholder="Jumlah Tampilan" wire:model='perPage' class="-mt-1" />
    </div>
    @if (request()->is('*peserta*')||request()->is('*message/voter*'))
    <x-native-select wire:model='vote'>
      <option value="">Semua Pemilihan</option>
      @foreach ($datavotes as $item)
      <option value="{{ $item->id }}">{{ $item->title }}</option>
      @endforeach
    </x-native-select>
    @endif
    <x-input type='text' right-icon="search" wire:model.debounce.500ms='search' placeholder='Cari ...' autofocus
      x-ref="search" />
  </div>
</div>
@push('scripts')
<script>
  Livewire.on('print', data => {
    window.open(data.url,'Cetak Kartu',"width=800,height=680");
  })
</script>
@endpush