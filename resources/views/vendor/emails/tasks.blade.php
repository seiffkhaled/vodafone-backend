<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Task Report</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            padding: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        .completed {
            background-color: #d4edda;
        }
        .pending {
            background-color: #fff3cd;
        }
        .overdue {
            background-color: #f8d7da;
        }
    </style>
</head>
<body>
    <h1>Your Task Report</h1>
    <p>Here is a list of your tasks for the selected period:</p>

    <table>
        <thead>
            <tr>
                <th>Task Name</th>
                <th>Status</th>
                <th>End Date</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($tasks as $task)
                <tr class="{{ $task->status }}">
                    <td>{{ $task->title }}</td>
                    <td>{{ ucfirst($task->status) }}</td>
                    <td>{{ $task->due_date }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <p>If you have any questions or need further assistance, feel free to reach out.</p>
</body>
</html>
