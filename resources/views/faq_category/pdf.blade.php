<table width="100%" border="1">
    <tr><th>ID</th><th>Name</th><th>Status</th></tr>
    @foreach($data as $category)
    <tr>
        <td>{{$category['id']}}</td>
        <td>{{$category['name']}}</td>
        <td>{{$category['status']}}</td>
    </tr>
    @endforeach
</table>