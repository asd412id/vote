<?php

namespace App\Http\Livewire;

use App\Models\Vote;
use App\Models\Voter as ModelsVoter;
use App\PageHelpers;
use Livewire\Component;

class Voter extends Component
{
	use PageHelpers;

	public $vote = '';
	public $votes = [];
	public $ids = [];
	public $pemilihan = null;
	public $prefix_nama = 'Peserta ';
	public $jumlah_peserta = 1;

	public function render()
	{
		$data = ModelsVoter::when($this->search, function ($q, $role) {
			$q->where('name', 'like', "%$role%")
				->orWhereHas('vote', function ($q) use ($role) {
					$q->where('title', 'like', "%$role%")
						->orWhere('desc', 'like', "%$role%");
				});
		})
			->when($this->vote, function ($q, $vote_id) {
				$q->where('vote_id', $vote_id);
			})
			->with('vote')
			->orderBy('vote_id', 'desc')
			->orderBy('id', 'asc')
			->paginate($this->perPage);

		$this->ids = [];
		foreach ($data as $key => $v) {
			array_push($this->ids, $v->id);
		}

		return view('livewire.voter', ['data' => $data, 'datavotes' => Vote::all()]);
	}

	public function create()
	{
		$this->setDefault();
		$this->votes = Vote::select('id', 'title')->get()->toArray();
		$this->openModal = true;
	}

	public function store()
	{
		$this->clearValidation();
		$this->validate([
			'pemilihan' => 'required',
			'prefix_nama' => 'string',
			'jumlah_peserta' => 'required|numeric|min:1',
		]);

		$insert = [];
		$this->jumlah_peserta = $this->jumlah_peserta <= 0 ? 1 : $this->jumlah_peserta;
		$this->prefix_nama = $this->prefix_nama ?? 'Peserta ';

		$cek = ModelsVoter::where('name', 'like', "%$this->prefix_nama%")
			->where('vote_id', $this->pemilihan)
			->orderBy('id', 'desc')->first();

		$number = 0;
		if ($cek) {
			preg_match("/([0-9]+)/", $cek->name, $matches);
			$number = (int) $matches[0];
		}

		for ($i = 0; $i < $this->jumlah_peserta; $i++) {
			$number++;
			array_push($insert, [
				'code' => sha1(time() + $number),
				'name' => $this->prefix_nama . $number,
				'vote_id' => $this->pemilihan
			]);
		}

		ModelsVoter::insert($insert);

		$this->openModal = false;
		$this->notification()->success('Berhasil', 'Data berhasil disimpan');
	}

	public function delete(ModelsVoter $dta)
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
		$dta = ModelsVoter::find($this->ID);
		$dta->delete();
		$this->notification()->success('Berhasil', 'Data berhasil dihapus');
	}

	public function deleteAll()
	{
		if (!count($this->ids)) {
			return $this->notification()->info('Notifikasi', 'Data tidak tersedia');
		}
		$this->dialog()->confirm([
			'title'       => 'Hapus ' . count($this->ids) . ' Data?',
			'description' => 'Anda yakin ingin menghapus data ini? ',
			'icon'        => 'question',
			'accept'      => [
				'label'  => 'Hapus',
				'method' => 'destroyAll',
			],
			'reject' => [
				'label'  => 'Tidak',
				'method' => '',
			],
		]);
	}

	public function destroyAll()
	{
		$dta = ModelsVoter::whereIn('id', $this->ids);
		$dta->delete();
		$this->notification()->success('Berhasil', 'Data berhasil dihapus');
	}

	public function print()
	{
		if (!count($this->ids)) {
			return $this->notification()->info('Notifikasi', 'Data tidak tersedia');
		}
		$this->emit('print', [
			'url' => route('print', ['id' => implode('|', $this->ids)])
		]);
	}
}
