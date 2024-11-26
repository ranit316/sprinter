<table width="100%" border="1">
    <tr><th>ID</th><th>Name</th></tr>
    @foreach($data as $category)
    <tr>
        <td>{{$category['id']}}</td>
        <td>{{$category['name']}}</td>
    </tr>
    @endforeach
</table>