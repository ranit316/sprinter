<table width="100%" border="1">
    <tr><th>ID</th><th>Type</th><th>Content</th></tr>
    @foreach($data as $category)
    <tr>
        <td>{{$category['id']}}</td>
        <td>{{$category['type']}}</td>
        <td>
        
            <?php 
            
            if($category['type']=='Text')
            {
                echo $category['content'];
            }
            else  if($category['type']=='Image')
            {
                echo "<img src='".$category['photo']."' alt='' title='' width='60' />";
            }
            else  if($category['type']=='Video')
            {
                echo "<a href='".$category['video']."' target='_blank'>".$category['video']."</a>";
            }
            
            ?>
            </td>
    </tr>
    @endforeach
</table>