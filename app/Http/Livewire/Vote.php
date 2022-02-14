<?php

namespace App\Http\Livewire;

use App\Models\Vote as ModelsVote;
use App\PageHelpers;
use Livewire\Component;

class Vote extends Component
{
	use PageHelpers;

	public $judul_voting = null;
	public $deskripsi = null;
	public $waktu_mulai = null;
	public $waktu_selesai = null;
	public $status = null;

	public function render()
	{
		$data = ModelsVote::when($this->search, function ($q, $role) {
			$q->where('title', 'like', "%$role%")
				->orWhere('desc', 'like', "%$role%");
		})
			->paginate($this->perPage);
		return view('livewire.vote', ['data' => $data]);
	}

	public function create()
	{
		$this->setDefault();
		$this->waktu_mulai = now()->startOfDay();
		$this->waktu_selesai = now()->endOfDay();
		$this->openModal = true;
		$this->status = 1;
	}

	public function store()
	{
		$this->validate([
			'judul_voting' => 'required|string',
			'waktu_mulai' => 'required',
			'waktu_selesai' => 'required',
			'status' => 'required|boolean',
		]);

		$insert = new ModelsVote();
		$insert->title = $this->judul_voting;
		$insert->desc = $this->deskripsi;
		$insert->start = $this->waktu_mulai;
		$insert->end = $this->waktu_selesai;
		$insert->status = $this->status;
		$insert->save();

		$this->openModal = false;
		$this->notification()->success('Berhasil', 'Data berhasil disimpan');
	}

	public function edit(ModelsVote $dta)
	{
		$this->ID = $dta->id;
		$this->judul_voting = $dta->title;
		$this->deskripsi = $dta->desc;
		$this->waktu_mulai = $dta->start;
		$this->waktu_selesai = $dta->end;
		$this->status = $dta->status;
		$this->openModal = true;
	}

	public function update()
	{
		$this->validate([
			'judul_voting' => 'required|string',
			'waktu_mulai' => 'required',
			'waktu_selesai' => 'required',
			'status' => 'required|boolean',
		]);

		$insert = ModelsVote::find($this->ID);
		$insert->title = $this->judul_voting;
		$insert->desc = $this->deskripsi;
		$insert->start = $this->waktu_mulai;
		$insert->end = $this->waktu_selesai;
		$insert->status = $this->status;
		$insert->save();

		$this->openModal = false;
		$this->notification()->success('Berhasil', 'Data berhasil disimpan');
	}

	public function delete(ModelsVote $dta)
	{
		$this->ID = $dta->id;
		$this->dialog()->confirm([
			'title'       => 'Hapus Data ' . $dta->title . '?',
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
		$dta = ModelsVote::find($this->ID);
		$dta->candidates()->delete();
		$dta->voters()->delete();
		$dta->delete();
		$this->notification()->success('Berhasil', 'Data berhasil dihapus');
	}
}
