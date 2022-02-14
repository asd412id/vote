<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<link rel="stylesheet" href="{{ mix('css/app.css') }}">
	<title>Cetak Kartu</title>
</head>

<body class="relative antialiased">
	@if (count($data))
	@php($i=1)
	@foreach ($data as $v)
	@if ($i==13)
	@php($i=1)
	</div>
	<div class="break-before-page pt-2"></div>
	@endif
	@if ($i==1)
	<div class="grid grid-cols-3 gap-2 relative">
		@endif
		<div
			class="flex flex-col relative border border-gray-500 rounded-md p-2 justify-center items-center !break-inside-avoid-page !break-after-all">
			<div class="text-center font-bold">
				@php($i++)
				<div>Kartu Peserta</div>
				@if ($v->vote)
				<div class="text-xl">{{ $v->vote->title }}</div>
				@endif
			</div>
			<div class="py-3">{!! QrCode::size(100)->generate($v->code); !!}</div>
			<div class="text-center font-semibold italic py-1 px-4 rounded-md border border-gray-300">{{ $v->name }}</div>
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