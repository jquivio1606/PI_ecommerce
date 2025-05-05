<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Nombre Tienda - {{ $metaTitle }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet" />
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            width: 100% !important;
            max-width: 100% !important;
        }

        .container {
            width: 95%;
            max-width: 100% !important;
            margin: auto;
            padding: 0;
        }

        .btn-sm {
            font-size: small;
        }

        @media (max-width: 950px) {
            .container {
                max-width: 100%;
                font-size: small;
            }
        }
    </style>
</head>

<body class="d-flex flex-column min-vh-100">

    @include('components.layouts.header')
    @include('components.layouts.nav')

    <!-- Main -->
    <main class="flex-grow-1 py-4">
        <div class="container">
            <h2 class="text-center">{{ $tituloSeccion ?? 'Bienvenido a nuestra tienda' }}</h2>
            <br>
            {{ $slot }}
        </div>
    </main>

    @include('components.layouts.footer')

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
