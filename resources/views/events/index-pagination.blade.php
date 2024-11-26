@if(!empty($events))

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
                    <th class="">Title</th> 
                    <th class="">Category</th>
                    <th class="">Start Date</th>
                    <th class="">End Date</th>
                    <th class="">Banner</th>
                    <th class="">Status</th>
                    <th class="min-w-100px text-end">Actions</th>
                </tr>
            </thead>
            <!--end::Table head-->
            <!--begin::Table body-->
            <tbody>
                @if($events->count() > 0)
                @foreach($events as $event)
                <tr>
                    <td>
                        <div class="form-check form-check-sm form-check-custom form-check-solid">
                            <input name="all_ids" class="form-check-input event_checkbox_id mx-2" onClick="all_selected_check_boxes();" type="checkbox" value="{{$event['id']}}">
                            {{ $event['id'] }}
                        </div>
                    </td>
                    <td>
                        {{$event['name']}}
                    </td>
                    <td>
                        {!!$event['category_name']!!}
                    </td>
                    <td>
                        {!! $event['start_date'] !!}
                    </td>
                    <td>
                        {!! $event['end_date'] !!}
                    </td>
                    <td>
                        {!!($event['photo']!='')?'<img src="'.asset($event['photo']).'" width="60" />':''!!}
                    </td>
                 
                 
                     <td>
                        <span class="badge badge-light-<?php if($event['status']=='Active'){echo 'success';}else if($event['status']=='Inactive'){echo 'danger';}?>">{{$event['status']}}</span>
                    </td>
                    <td class="text-end">
                        <form id="event_delete_form_id_{{$event['id']}}" action="{{ route('events.destroy',$event['id']) }}" method="POST">

                        @can('event-edit')  
                        <a href="{{ route('events.edit',$event['id']) }}" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1">
                            <i class="ki-duotone ki-pencil fs-2">
                                <span class="path1"></span>
                                <span class="path2"></span>
                            </i>
                        </a>
                        
                        @endcan

                                           

                        @can('event-delete')  
                     
                           
                                @csrf
                                @method('DELETE')
                               
                                <button type="button"  onclick="confirm_delete_button('event_delete_form_id_{{$event['id']}}');" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm"><i class="ki-duotone ki-trash fs-2">
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
            {{ $events->links() }}
          </div>

    </div>
    <!--end::Table container-->
</div>
<!--end::Body-->





    @endif