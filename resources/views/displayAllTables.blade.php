<html>
<body>
    <table>
        <tr>
            <th>Index</th>
            <th>Room</th>
            <th>Table ID</th>
            <th>Table Name</th>
            <th>QR Code Path</th>
        </tr>
        @foreach ($data as $index => $tableData)
            <tr>
                <td>{{$index + 1}}</td>
                <td>{{$tableData['room']}}</td>
                <td>{{$tableData['tableID']}}</td>
                <td>{{$tableData['tableName']}}</td>
                <td>{{$tableData['QRCodePath']}}</td>
            </tr>
        @endforeach
    </table>
</body>
</html>