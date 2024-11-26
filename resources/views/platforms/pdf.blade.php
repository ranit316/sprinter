<table width="100%" border="1">
    <tr><th>ID</th><th>Name</th><th>Demo User Id</th><th>Demo Password</th><th>Demo Website Link</th><th>Status</th></tr>
    @foreach($data as $category)
    <tr>
        <td>{{$category['id']}}</td>
        <td>{{$category['name']}}</td>
        <td>{{$category['demo_user_id']}}</td>
        <td>{{$category['demo_password']}}</td>
        <td>{{$category['demo_details']}}</td>
        <td>{{$category['status']}}</td>
    </tr>
    @endforeach
</table>