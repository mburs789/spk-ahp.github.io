<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Perangkingan</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            text-align: center;
        }
        h2 {
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        th, td {
            border: 1px solid black;
            padding: 8px;
            text-align: center;
        }
        th {
            background-color: #f2f2f2;
            font-weight: bold;
        }
        td {
            text-align: left;
        }
    </style>
</head>
<body>
    <h2>Laporan Perangkingan Karyawan</h2>
    <table>
        <thead>
            <tr>
                <th>Peringkat</th>
                <th>NIK</th>
                <th>Nama Karyawan</th>
                <th>Total Nilai</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $index => $item)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $item['nik'] }}</td>
                    <td>{{ $item['nama_karyawan'] }}</td>
                    <td>{{ number_format($item['total_nilai'], 6) }}</td>
                    <td>{{ ucfirst($item['status']) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
