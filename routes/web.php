<?php

use App\Models\Vote;
use App\Models\Voter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::middleware('guest:voter')->group(function () {
	Route::get('/login', function () {
		return view('welcome');
	})->name('login');
	Route::post('/login', function (Request $r) {
		$peserta = Voter::where('code', $r->code)
			->has('vote')
			->first();

		if (!$peserta) {
			return response()->json(['message' => 'Maaf, Anda tidak terdaftar!'], 401);
		}

		Auth::guard('voter')->login($peserta);
		return response()->json(['message' => 'Login berhasil!', 'redirect' => route('voter.index')]);
	})->name('login');
});

Route::middleware('auth:voter')->group(function () {
	Route::get('/', function () {
		return view('voter-page');
	})->name('voter.index');
	Route::get('/logout', function () {
		auth()->logout();
		return redirect()->route('login');
	})->name('voter.logout');
});

Route::get('/live/{uuid}', function ($uuid) {
	$cek = Vote::where('uuid', $uuid)->first();
	if (!$cek || !count($cek->candidates)) {
		return redirect()->back();
	}
	return view('live', ['uuid' => $uuid, 'title' => "Live Voting"]);
})->name('live');

Route::middleware('auth')->group(function () {
	Route::prefix('/admin')->group(function () {
		Route::get('/', function () {
			return view('admin.wrapper', [
				'title' => 'Pemilihan',
				'content' => 'vote'
			]);
		})->name('admin.dashboard');
		Route::get('/kandidat', function () {
			return view('admin.wrapper', [
				'title' => 'Kandidat',
				'content' => 'candidate'
			]);
		})->name('candidate');
		Route::get('/peserta', function () {
			return view('admin.wrapper', [
				'title' => 'Peserta',
				'content' => 'voter'
			]);
		})->name('voter');
		Route::get('/print', function () {
			$ids = explode('|', request()->id);
			$data = Voter::whereIn('id', $ids)->get();
			return view('admin.print', ['data' => $data]);
		})->name('print');
	});
});

require __DIR__ . '/auth.php';
