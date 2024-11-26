<table width="100%" border="1">
    <tr><th>ID</th><th>Name</th><th>Email</th><th>Type</th></tr>
    @foreach($data as $category)
    <tr>
        <td>{{$category['id']}}</td>
        <td>{{$category['name']}}</td>
        <td>{{$category['email']}}</td>
        <td>{{$category['type']}}</td>
    </tr>
    @endforeach
</table>