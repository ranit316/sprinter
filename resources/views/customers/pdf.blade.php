<table width="100%" border="1">
    <tr><th>ID</th><th>First Name</th><th>Last Name</th><th>Address</th><th>Phone Number</th></tr>
    @foreach($data as $category)
    <tr>
        <td>{{$category['id']}}</td>
        <td>{{$category['first_name']}}</td>
        <td>{{$category['last_name']}}</td>
        <td>{{$category['address']}}</td>
        <td>{{$category['phone_number']}}</td> 
    </tr>
    @endforeach
</table>