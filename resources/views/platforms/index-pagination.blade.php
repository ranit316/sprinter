@if(!empty($platforms))

  <!--begin::Body-->
  <div class="card-body py-3">
    <!--begin::Table container-->
    <div class="table-responsive">
        <!--begin::Table-->
        
        <table class="table table-row-bordered table-row-gray-100 align-middle gs-0 gy-3">
            <!--begin::Table head-->
            <thead>
                <tr class="fw-bold text-muted">
                   
                    <th class="">Sys Id</th>
                    <th class="">Name</th>
                    <th class="">Platform Logo</th>
                    <th class="">Demo User Id</th>
                    <th class="">Demo Password</th>
                    <th class="">Status</th>
                    <th class="min-w-100px text-end">Actions</th>
                </tr>
            </thead>
            <!--end::Table head-->
            <!--begin::Table body-->
            <tbody>
                @if($platforms->count() > 0)
                @foreach($platforms as $platform)
                <tr>
                    <td>
                        <div class="form-check form-check-sm form-check-custom form-check-solid">
                            {{ $platform['id'] }}
                        </div>
                    </td>
                    <td>
                        {{$platform['name']}}
                    </td>
                    <td>
                        {!!($platform['photo']!='')?'<img src="'.asset($platform['photo']).'" width="60" />':''!!}
                    </td>
                    <td>
                        {{$platform['demo_user_id']}}
                    </td>
                    <td>
                        {{$platform['demo_password']}}
                    </td>
                  
                     <td>
                        <span class="badge badge-light-<?php if($platform['status']=='Active'){echo 'success';}else if($platform['status']=='Inactive'){echo 'danger';}?>">{{$platform['status']}}</span>
                    </td>
                    <td class="text-end">
                        <form id="platform_delete_form_id_{{$platform['id']}}" action="{{ route('platforms.destroy',$platform['id']) }}" method="POST">

                        @can('platform-edit')  
                        <a href="{{ route('platforms.edit',$platform['id']) }}" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1">
                            <i class="ki-duotone ki-pencil fs-2">
                                <span class="path1"></span>
                                <span class="path2"></span>
                            </i>
                        </a>
                        
                        @endcan

                                           

                        @can('platform-delete')  
                     
                           
                                @csrf
                                @method('DELETE')
                               
                                <button type="button"  onclick="confirm_delete_button('platform_delete_form_id_{{$platform['id']}}');" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm"><i class="ki-duotone ki-trash fs-2">
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
            {{ $platforms->links() }}
          </div>

    </div>
    <!--end::Table container-->
</div>
<!--end::Body-->





    @endif