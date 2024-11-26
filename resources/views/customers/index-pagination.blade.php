@if(!empty($customers))

  <!--begin::Body-->
  <div class="card-body py-3">
    <!--begin::Table container-->
    <div class="table-responsive">
        <!--begin::Table-->

        
{{-- @if ($message = Session::get('success'))
<div class="alert alert-success">
    <p>{{ $message }}</p>
</div>
@endif --}}

        
        <table class="table table-row-bordered table-row-gray-100 align-middle gs-0 gy-3 text-center">
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
                    <th class="">Email</th>
                    <th class="">Last Login</th>
                    <th class="">Refferel Count</th>
                    <th class="">Status</th>
                    <th class="min-w-100px">Actions</th>
                </tr>
            </thead>
            <!--end::Table head-->
            <!--begin::Table body-->
            <tbody>
                @if($customers->count() > 0)
                @foreach($customers as $customer)
                <tr>
                    <td>
                        <div class="form-check form-check-sm form-check-custom form-check-solid">
                            <input name="all_ids" class="form-check-input customer_checkbox_id  mx-2" onClick="all_selected_check_boxes();" type="checkbox" value="{{$customer['id']}}">
                            {{ $loop->iteration }}
                        </div>
                    </td>
                    <td>
                        {{$customer['first_name'].' '.$customer['last_name']}}
                    </td>
                   
                    <td>
                        {!!$customer['email']!!}
                    </td>
                    <td>
                        {!!$customer['last_login']!!}
                    </td>
                    <td>
                        <a href="{{route('customer.refferel',$customer['id'])}}">{!!$customer['referred_count']!!}</a>
                    </td>
                 
                     <td>
                        <span class="badge badge-light-<?php if($customer['status']=='Active'){echo 'success';}else if($customer['status']=='Inactive'){echo 'danger';}?>">{{$customer['status']}}</span>
                    </td>
                    <td class="">
                        <form id="customer_delete_form_id_{{$customer['id']}}" action="{{ route('customers.destroy',$customer['id']) }}" method="POST">

                        @can('customer-edit')  
                        <a href="{{ route('customers.edit',$customer['id']) }}" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1">
                            <i class="ki-duotone ki-pencil fs-2">
                                <span class="path1"></span>
                                <span class="path2"></span>
                            </i>
                        </a>
                        
                        @endcan                    

                        @can('customer-delete')  

                                @csrf
                                @method('DELETE')
                               
                                <button type="button"  onclick="confirm_delete_button('customer_delete_form_id_{{$customer['id']}}');" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm"><i class="ki-duotone ki-trash fs-2">
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
            {{ $customers->links() }}
        </div>
    </div>
    <!--end::Table container-->
</div>
<!--end::Body-->

    @endif