<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Plan Semanal</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 13px;
            color: #1a202c;
        }

        h1 {
            color: #047857;
            font-size: 20px;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            margin-top: 20px;
            border: 1px solid #ccc;
        }

        th,
        td {
            padding: 10px;
            border: 1px solid #ccc;
            vertical-align: top;
        }

        th {
            font-size: 14px;
            color: #1f2937;
        }

        td {
            background-color: #ffffff;
            line-height: 1.5;
        }

        tr:nth-child(even) td {
            background-color: #f9fafb;
        }
    </style>
</head>

<body>
    <h1>Plan Semanal - {{ $start_date }} a {{ $end_date }}</h1>

    <table>
        <thead>
            <tr>
                <th style="background-color: #d1fae5;">Día</th>
                <th style="background-color: #fef3c7;">Desayuno</th>
                <th style="background-color: #fde68a;">Media Mañana</th>
                <th style="background-color: #bfdbfe;">Comida</th>
                <th style="background-color: #bbf7d0;">Merienda</th>
                <th style="background-color: #fbcfe8;">Cena</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($meals as $dia => $comidas)
                <tr>
                    <td style="font-weight: bold;">{{ ucfirst($dia) }}</td>
                    <td>{{ $comidas['desayuno'] ?? '-' }}</td>
                    <td>{{ $comidas['media-mañana'] ?? '-' }}</td>
                    <td>{{ $comidas['comida'] ?? '-' }}</td>
                    <td>{{ $comidas['merienda'] ?? '-' }}</td>
                    <td>{{ $comidas['cena'] ?? '-' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>