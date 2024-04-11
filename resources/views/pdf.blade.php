<!DOCTYPE html>
<html>
<head>
    <title>Tickets</title>
    <style>
        
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
                <th>Status</th>
               
            </tr>
        </thead>
        <tbody>
            @foreach ($tickets as $ticket)
            <tr>
                <td>{{ $ticket->name??"---------------" }}</td>
                <td>{{ $ticket->email??"---------------" }}</td>
                <td>{{ $ticket->contact??"---------------" }}</td>
                <td>{{ Strtoupper($ticket->placing??"---------------") }}</td>
                <td>{{ $ticket->place??"---------------" }}</td>
                <td>{{ $ticket->code??"---------------" }}</td>
                <td>{{ $ticket->date_scanne??"---------------"}}</td>
                <td>
                            @if($ticket->status == 1)
                            <span class="badge badge-success">Scanné</span>
                            @else
                            <span class="badge badge-danger">Non Scanné</span>
                            @endif
                          </td>
                        </tr>
              
            </tr>
            @endforeach
        </tbody>
    </table>
    <footer>
        <p>pied de page</p>
    </footer>
</body>
</html>
