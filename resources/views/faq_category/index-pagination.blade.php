@if(!empty($categories))

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
                    <th class="">Name</th>
                    {{-- <th class="">Photo</th> --}}
                    <th class="">Description</th>
                    <th class="">Status</th>
                    <th class="min-w-100px text-end">Actions</th>
                </tr>
            </thead>
            <!--end::Table head-->
            <!--begin::Table body-->
            <tbody>
                @if($categories->count() > 0)
                @foreach($categories as $category)
                <tr>
                    <td>
                        <div class="form-check form-check-sm form-check-custom form-check-solid">
                            <input name="all_ids" class="form-check-input category_checkbox_id mx-2" onClick="all_selected_check_boxes();" type="checkbox" value="{{$category['id']}}">
                            {{$category['id']}}
                        </div>
                    </td>
                    <td>
                        {{$category['name']}}
                    </td>
                    {{-- <td>
                        {!!($category['photo']!='')?'<img src="'.asset($category['photo']).'" width="60" />':''!!}
                    </td> --}}
                    <td>
                        {{$category['description']}}
                    </td>
                 
                     <td>
                        <span class="badge badge-light-<?php if($category['status']=='Active'){echo 'success';}else if($category['status']=='Inactive'){echo 'danger';}?>">{{$category['status']}}</span>
                    </td>
                    <td class="text-end">
                        <form id="category_delete_form_id_{{$category['id']}}" action="{{ route('faq_category.destroy',$category['id']) }}" method="POST">

                        @can('category-edit')  
                        <a href="{{ route('faq_category.edit',$category['id']) }}" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1">
                            <i class="ki-duotone ki-pencil fs-2">
                                <span class="path1"></span>
                                <span class="path2"></span>
                            </i>
                        </a>
                        
                        @endcan

                                           

                        @can('category-delete')  
                     
                           
                                @csrf
                                @method('DELETE')
                               
                                <button type="button"  onclick="confirm_delete_button('category_delete_form_id_{{$category['id']}}');" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm"><i class="ki-duotone ki-trash fs-2">
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
            {{ $categories->links() }}
          </div>

    </div>
    <!--end::Table container-->
</div>
<!--end::Body-->





    @endif