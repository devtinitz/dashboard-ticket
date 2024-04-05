<!DOCTYPE html>
<html>
<head>
    <title>Tickets</title>
    <style>
        /* Ajoutez votre CSS personnalisé pour la mise en forme du PDF ici */
        body {
            font-family: Arial, sans-serif;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <h1>Tickets</h1>
    <table>
        <thead>
            <tr>
                <th>Nom</th>
                <th>Email</th>
                <th>Contact</th>
                <th>Placing</th>
                <th>Place</th>
                <th>Code</th>
                <th>Date de scanne</th>
                <!-- Ajoutez d'autres colonnes si nécessaire -->
            </tr>
        </thead>
        <tbody>
            @foreach ($tickets as $ticket)
            <tr>
                <td>{{ $ticket->name }}</td>
                <td>{{ $ticket->email }}</td>
                <td>{{ $ticket->contact }}</td>
                <td>{{ $ticket->placing }}</td>
                <td>{{ $ticket->place }}</td>
                <td>{{ $ticket->code }}</td>
                <td>{{ $ticket->date_scanne }}</td>
                <!-- Ajoutez d'autres colonnes si nécessaire -->
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
