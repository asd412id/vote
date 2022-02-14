<?php

namespace App\Http\Livewire;

use App\Models\Vote;
use Livewire\Component;

class Live extends Component
{
	public $uuid;
	public $count = 0;

	public function mount($uuid)
	{
		$this->uuid = $uuid;
	}

	public function render()
	{
		$vote = Vote::where('uuid', $this->uuid)->first();
		$total = $vote->voters()->count();
		$choiced = $vote->voters()->whereNotNull('candidate_id')->count();

		$percent = round($choiced / $total * 100, 2);

		return view('livewire.live', ['vote' => $vote, 'total' => $total, 'percent' => $percent]);
	}

	public function refresh()
	{
		$this->count++;
	}
}
