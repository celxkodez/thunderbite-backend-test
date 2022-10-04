<table>
    <thead>
    <tr>
        <th>ACCOUNT</th>
        <th>PRIZE_ID</th>
        <th>TITLE</th>
        <th>REVEALED AT</th>
        <th>STARTS AT</th>
        <th>ENDS AT</th>
    </tr>
    </thead>
    <tbody>
    @foreach($data as $item)
        <tr>
            <td>{{ $item->account }}</td>
            <td>{{ $item->prize_id }}</td>
            <td>{{ $item->title }}</td>
            <td>{{ $item->revealed_at }}</td>
            <td>{{ $item->starts_at }}</td>
            <td>{{ $item->ends_at }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
