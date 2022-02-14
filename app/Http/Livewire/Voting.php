<?php

namespace App\Http\Livewire;

use App\Models\Candidate;
use Livewire\Component;
use WireUi\Traits\Actions;

class Voting extends Component
{
	use Actions;
	public $hasChoosed = false;
	public $choice = null;

	public function render()
	{
		$this->hasChoosed = !is_null(auth()->user()->candidate_id);
		$this->choice = auth()->user()->candidate_id;
		$vote = auth()->user()->vote;
		return view('livewire.voting', ['vote' => $vote]);
	}

	public function save($id)
	{
		$cek = Candidate::find($id);
		if (!$cek) {
			return $this->notification()->error('Gagal', 'Kandidat tidak ditemukan!');
		}
		$update = auth()->user();
		$update->candidate_id = $cek->id;
		$update->voted_time = now();
		$update->save();
		$this->notification()->success('Berhasil', 'Pilihanmu berhasil disimpan');
		$this->emit('success');
	}
}
