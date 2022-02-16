<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<link rel="stylesheet" href="{{ mix('css/app.css') }}">
	<title>Cetak Kartu</title>
	<style>
		* {
			font-size: 0.9rem;
		}
	</style>
</head>

<body class="relative antialiased">
	@if (count($data))
	@php($i=1)
	@foreach ($data as $v)
	@if ($i==26)
	@php($i=1)
	</div>
	<div class="pt-2 break-before-page"></div>
	@endif
	@if ($i==1)
	<div class="relative grid grid-cols-5 gap-2">
		@endif
		<div
			class="flex flex-col relative border border-gray-500 rounded-md p-2 justify-center items-center !break-inside-avoid-page !break-after-all">
			<div class="font-bold text-center">
				@php($i++)
				<div>Kartu Peserta</div>
				@if ($v->vote)
				<div>{{ $v->vote->title }}</div>
				@endif
			</div>
			<div class="py-3">{!! QrCode::size(100)->generate($v->code); !!}</div>
			<div class="px-4 py-1 italic font-semibold text-center border border-gray-300 rounded-md">{{ $v->name }}</div>
		</div>
		@endforeach
		<script>
			window.print()
		</script>
		@else
		<script>
			window.close()
		</script>
		@endif
</body>

</html>