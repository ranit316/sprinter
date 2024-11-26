@if(!empty($reviews))

  <!--begin::Body-->
  <div class="card-body py-3">
    <!--begin::Table container-->
    <div class="table-responsive">
        <!--begin::Table-->
        
        <table class="table table-row-bordered table-row-gray-100 align-middle gs-0 gy-3">
            <!--begin::Table head-->
            <thead>
                <tr class="fw-bold text-muted">
                   
                    <th class="">
                        <div class="form-check form-check-sm form-check-custom form-check-solid">
                            <input class="form-check-input-all mx-2" id="checkAll" onClick="checkAll();"  type="checkbox"  value="1">
                            Sys Id     
                        </div>
                    </th>
                    <th class="">Content Type</th>
                    <th class="">Title</th>
                    <th class="">Marks</th>
                    <th class="">User Name</th>
                    <th class="">Review Type</th>
                    <th class="">Status</th>
                    <th class="min-w-100px text-end">Actions</th>
                </tr>
            </thead>
            <!--end::Table head-->
            <!--begin::Table body-->
            <tbody>
                @if($reviews->count() > 0)
                @foreach($reviews as $review)
                <tr>
                    <td>
                        <div class="form-check form-check-sm form-check-custom form-check-solid">
                            <input name="all_ids" class="form-check-input review_checkbox_id mx-2" onClick="all_selected_check_boxes();" type="checkbox" value="{{$review['id']}}">
                            {{$review['id']}}
                        </div>
                    </td>
                    <td>
                        {{$review['type']}}
                    </td>
                  
                    <td>
                        <?php 
                        if($review['type']=='Text')
                        {
                            //echo $review['content'];
                            echo $review['title'];
                        }
                        else  if($review['type']=='Image')
                        {
                            //echo "<img src='".asset($review['photo'])."' width='60' />";
                            echo $review['title'];
                        }
                        else  if($review['type']=='Video')
                        {
                            //echo "<a href='".$review['video']."' target='_blank'>".$review['video']."</a>";
                            echo $review['title'];
                        }
                        ?>
                    </td>
                    <td>
                        {!!$review['marks']!!}
                    </td>
                    <td>
                        {!!$review['user']!!}
                    </td>

                    <td>
                        {!!$review['review']!!}
                    </td>
                 
                     <td>
                        <span class="badge badge-light-<?php if($review['status']=='Approved'){echo 'success';}else if($review['status']=='Pending'){echo 'warning';}else if($review['status']=='Rejected'){echo 'danger';}?>">{{$review['status']}}</span>
                    </td>
                    <td class="text-end">
                        <form id="review_delete_form_id_{{$review['id']}}" action="{{ route('reviews.destroy',$review['id']) }}" method="POST">

                        @can('review-edit')  
                        <a href="{{ route('reviews.edit',$review['id']) }}" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1">
                            <i class="ki-duotone ki-pencil fs-2">
                                <span class="path1"></span>
                                <span class="path2"></span>
                            </i>
                        </a>
                        
                        @endcan

                                           

                        @can('review-delete')  
                     
                           
                                @csrf
                                @method('DELETE')
                               
                                <button type="button"  onclick="confirm_delete_button('review_delete_form_id_{{$review['id']}}');" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm"><i class="ki-duotone ki-trash fs-2">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                    <span class="path3"></span>
                                    <span class="path4"></span>
                                    <span class="path5"></span>
                                </i></button>
                               
                           
                       
                        @endcan
                    </form>

                    </td>
                </tr>
                @endforeach
                @else
                <tr><td colspan="5" align="center">No data founds</td></tr>
                @endif
               
            </tbody>
            <!--end::Table body-->
        </table>
        <!--end::Table-->

        <div id="pagination">
            {{ $reviews->links() }}
          </div>

    </div>
    <!--end::Table container-->
</div>
<!--end::Body-->





    @endif