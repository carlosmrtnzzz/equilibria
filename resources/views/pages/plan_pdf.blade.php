<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Plan Semanal</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 14px;
        }

        h1 {
            color: #2f855a;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            border: 1px solid #ccc;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #def7e2;
        }
    </style>
</head>

<body>
    <h1>Plan Semanal - {{ $start_date }} a {{ $end_date }}</h1>

    @php
        $diasPrimera = ['lunes', 'martes', 'miércoles', 'jueves'];
        $diasSegunda = ['viernes', 'sábado', 'domingo'];
    @endphp

    {{-- Página 1 --}}
    @foreach ($diasPrimera as $dia)
        @if(isset($meals[$dia]))
            <h2>{{ ucfirst($dia) }}</h2>
            <table>
                <thead>
                    <tr>
                        <th>Comida</th>
                        <th>Descripción</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($meals[$dia] as $tipo => $descripcion)
                        <tr>
                            <td>{{ ucfirst($tipo) }}</td>
                            <td>{{ $descripcion }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    @endforeach

    <div style="page-break-before: always;"></div>

    {{-- Página 2 --}}
    @foreach ($diasSegunda as $dia)
        @if(isset($meals[$dia]))
            <h2>{{ ucfirst($dia) }}</h2>
            <table>
                <thead>
                    <tr>
                        <th>Comida</th>
                        <th>Descripción</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($meals[$dia] as $tipo => $descripcion)
                        <tr>
                            <td>{{ ucfirst($tipo) }}</td>
                            <td>{{ $descripcion }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    @endforeach
</body>

</html>