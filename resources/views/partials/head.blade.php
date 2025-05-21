<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />


<title>{{ $title ?? config('app.name') }}</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet" />
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />


<link rel="preconnect" href="https://fonts.bunny.net">
<link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

<style>
    textarea,
    input,
    select {
        border: 1px solid #000 !important;
    }

    .btn:focus,
    textarea:focus,
    input:focus,
    select:focus {
        outline: none !important;
        border: 1px solid black !important;
    }
</style>


@vite(['resources/css/app.css', 'resources/js/app.js'])
@fluxAppearance
