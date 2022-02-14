<x-guest-layout>
	<div x-data="{openScan: false}">
		<div class="flex h-screen flex-col p-3 justify-center items-center">
			<div x-show="!openScan">
				<div class="self-start items-center justify-center w-full text-center">
					<h2 class="text-4xl font-bold">
						Selamat Datang di
					</h2>
					<h1 class="mb-5 text-5xl font-bold md:whitespace-nowrap">
						{!! nl2br(env('APP_NAME','Aplikasi Sistem E-Voting')) !!}
					</h1>
					<p class="mb-5">
						Silahkan Scan Kode QR di kartu Anda terlebih dahulu untuk dapat melakukan Voting!
					</p>
					<x-button info class="py-3 px-5 text-2xl !inline-block" label="SCAN KARTU"
						x-on:click="$nextTick(()=>{openScan=true;startScan()})" />
				</div>
			</div>
			<div x-show="openScan" class="flex flex-col self-start items-center justify-center w-full text-center">
				<div class="flex mb-3 mt-1 gap-3">
					<h1 class="font-bold mt-1 text-2xl hidden" x-bind:class="{ '!block': openScan }">SCAN KARTU</h1>
					<div class="flex">
						<x-button outline info class="self-center hidden" label="TUTUP" x-bind:class="{ '!inline-block': openScan }"
							x-on:click="$nextTick(()=>{openScan=false;stopScan()})" />
					</div>
				</div>
				<div id="qr-reader" class="w-full md:max-w-screen-md hidden text-2xl" x-bind:class="{ '!block': openScan }">
					Mohon
					Tunggu
				</div>
			</div>
		</div>
	</div>
</x-guest-layout>