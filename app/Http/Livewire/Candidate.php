<?php

namespace App\Http\Livewire;

use App\Models\Candidate as ModelsCandidate;
use App\Models\Vote;
use App\PageHelpers;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

class Candidate extends Component
{
	use PageHelpers;
	use WithFileUploads;

	public $votes = [];
	public $pemilihan;
	public $nama_kandidat;
	public $deskripsi;
	public $gambar;
	public $gambarUrl;
	public $mime;
	public $imageChanged = false;

	public function render()
	{
		$data = ModelsCandidate::when($this->search, function ($q, $role) {
			$q->where('name', 'like', "%$role%")
				->orWhere('desc', 'like', "%$role%")
				->orWhereHas('vote', function ($q) use ($role) {
					$q->where('title', 'like', "%$role%")
						->orWhere('desc', 'like', "%$role%");
				});
		})
			->with('vote')
			->orderBy('vote_id', 'desc')
			->orderBy('id', 'asc')
			->paginate($this->perPage);
		return view('livewire.candidate', ['data' => $data]);
	}

	public function create()
	{
		$this->setDefault();
		$this->votes = Vote::select('id', 'title')->get()->toArray();
		$this->openModal = true;
	}

	public function updatedGambar()
	{
		$this->mime = $this->gambar->extension();
		$this->imageChanged = true;
		$this->gambarUrl = $this->gambar;
		$this->validate([
			'gambar' => 'image|mimes:png,jpg|max:1024',
		]);
	}

	public function store()
	{
		$this->validate([
			'nama_kandidat' => 'required|string',
			'pemilihan' => 'required',
		]);

		if ($this->gambar) {
			$filePath = $this->gambar->store('candidate', 'public');
		}
		$insert = new ModelsCandidate();
		$insert->name = $this->nama_kandidat;
		$insert->desc = $this->deskripsi;
		$insert->vote_id = $this->pemilihan;
		if (isset($filePath)) {
			$insert->image = $filePath;
		}
		$insert->save();

		$this->openModal = false;
		$this->notification()->success('Berhasil', 'Data berhasil disimpan');
	}

	public function edit(ModelsCandidate $dta)
	{
		$this->setDefault();
		$this->votes = Vote::select('id', 'title')->get()->toArray();
		$this->ID = $dta->id;
		$this->nama_kandidat = $dta->name;
		$this->deskripsi = $dta->desc;
		$this->gambarUrl = $dta->image;
		$this->pemilihan = $dta->vote_id;
		$this->openModal = true;
	}

	public function update()
	{
		$this->validate([
			'nama_kandidat' => 'required|string',
			'pemilihan' => 'required',
		]);

		$insert = ModelsCandidate::find($this->ID);
		if ($this->gambar) {
			Storage::disk('public')->delete($insert->image);
			$filePath = $this->gambar->store('candidate', 'public');
		}
		$insert->name = $this->nama_kandidat;
		$insert->desc = $this->deskripsi;
		$insert->vote_id = $this->pemilihan;
		if (isset($filePath)) {
			$insert->image = $filePath;
		}
		$insert->save();

		$this->openModal = false;
		$this->notification()->success('Berhasil', 'Data berhasil disimpan');
	}

	public function delete(ModelsCandidate $dta)
	{
		$this->ID = $dta->id;
		$this->dialog()->confirm([
			'title'       => 'Hapus Data ' . $dta->name . '?',
			'description' => 'Anda yakin ingin menghapus data ini? ',
			'icon'        => 'question',
			'accept'      => [
				'label'  => 'Hapus',
				'method' => 'destroy',
			],
			'reject' => [
				'label'  => 'Tidak',
				'method' => '',
			],
		]);
	}

	public function destroy()
	{
		$dta = ModelsCandidate::find($this->ID);
		Storage::disk('public')->delete($dta->image);
		$dta->voters()->update(['candidate_id' => null, 'voted_time' => null]);
		$dta->delete();
		$this->notification()->success('Berhasil', 'Data berhasil dihapus');
	}
}
