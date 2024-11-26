@extends('layouts.app')


@section('content')

<div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
  <div id="kt_app_toolbar_container" class="app-container container-xxl d-flex flex-stack">
      <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
          <h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">Permission</h1>
          <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
              <li class="breadcrumb-item text-muted">
                  <a href="{{route('permissions.create')}}" class="text-muted text-hover-primary">Permission</a>
              </li>
              <li class="breadcrumb-item">
                  <span class="bullet bg-gray-500 w-5px h-2px"></span>
              </li>

              <li class="breadcrumb-item text-muted">List</li>

          </ul>
      </div>

      <div class="d-flex align-items-center gap-2 gap-lg-3">
          <!--begin::Filter menu-->
         
          <div class="card-toolbar flex-row-fluid justify-content-end gap-5">
            <a class="btn btn-primary" href="{{ route('permissions.create') }}"> 
                <span class="fa fa-plus"></span> &nbsp; Create New Permission		
            </a>
          </div> 
          
          <button type="button" class="btn btn-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
            <i class="ki-duotone ki-exit-down fs-2"><span class="path1"></span><span class="path2"></span></i>Export Report
          </button>

          <div id="kt_datatable_example_export_menu" data-kt-menu="true" class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-200px py-4" style="">
                                  
                            
                          
            <!--begin::Menu item-->
            <div class="menu-item px-3">
                <form id="permission_excel_form" method="POST" action="{{route('permission.excel.export')}}">
                    @csrf
                    <input type="hidden" name="all_ids" id="all_ids_excell" />
                    <table><tr><td>
                    <select  name="type" id="excel_type">
                        <option value="All" >All</option>
                        <option value="Selected" >Selected</option>
                    </select>
                    </td><td>
                    <a href="javascript:void(0);" onClick="submit_form('permission_excel_form','all_ids_excell','excel_type');" class="menu-link px-3" data-kt-export="excel">
                     Excel 
                </a>
                </td></tr>
                </table>
                </form>
               
            </div>
            <!--end::Menu item-->
        
            <!--begin::Menu item-->
            <div class="menu-item px-3">
                <form id="permission_csv_form" method="POST" action="{{route('permission.csv.export')}}">
                    @csrf
                    <input type="hidden" name="all_ids" id="all_ids_csv" />
                    <table><tr><td>
                    <select  name="type" id="csv_type">
                        <option value="All" >All</option>
                        <option value="Selected" >Selected</option>
                    </select>
                    </td><td>
                <a href="javascript:void(0);" onClick="submit_form('permission_csv_form','all_ids_csv','csv_type');" class="menu-link px-3" data-kt-export="csv">
                     CSV 
                </a>
                </td></tr></table>
                </form>
            </div>
            <!--end::Menu item-->
        
            <!--begin::Menu item-->
            <div class="menu-item px-3">
                <form id="permission_pdf_form" method="POST" action="{{route('permission.pdf.export')}}">
                    @csrf
                    <input type="hidden" name="all_ids" id="all_ids_pdf" />
                    <table><tr><td>
                    <select  name="type" id="pdf_type">
                        <option value="All" >All</option>
                        <option value="Selected" >Selected</option>
                    </select>
                    </td><td>
                <a href="javascript:void(0);" onClick="submit_form('permission_pdf_form','all_ids_pdf','pdf_type');" class="menu-link px-3" data-kt-export="pdf">
                     PDF 
                </a>
                </td></tr></table>
                </form>
            </div>
            <!--end::Menu item--> 
            <script>
              function submit_form(formId, inputId, excelType) {
                  var form = document.getElementById(formId);
                  var input = document.getElementById(inputId);
                  // Set any additional parameters as needed
                  // input.value = excelType;
                  form.submit();
              }
          </script>
        </div>

          <div id="kt_datatable_example_buttons" class="d-none">
          <div class="dt-buttons btn-group flex-wrap">      
          <button class="btn btn-secondary buttons-copy buttons-html5" tabindex="0" aria-controls="kt_datatable_example" type="button"><span>Copy</span></button> 
          <button class="btn btn-secondary buttons-excel buttons-html5" tabindex="0" aria-controls="kt_datatable_example" type="button"><span>Excel</span></button> <button class="btn btn-secondary buttons-csv buttons-html5" tabindex="0" aria-controls="kt_datatable_example" type="button"><span>CSV</span></button> <button class="btn btn-secondary buttons-pdf buttons-html5" tabindex="0" aria-controls="kt_datatable_example" type="button"><span>PDF</span></button>
         </div>
         </div>

      </div>
      </div>
  </div>

    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif

<div id="kt_app_content" class="app-content flex-column-fluid">
  <div id="kt_app_content_container" class="app-container container-xxl">
    <div class="row g-5 g-xl-8">
      <div class="col-xl-12">
        <div class="card card-xl-stretch mb-xl-8">
          <div class="card-header border-0 pt-5">

            <h3 class="card-title align-items-start flex-column">
              <span class="card-label fw-bold fs-3 mb-1">Permission</span>
              <span class="text-muted fw-semibold fs-7"></span>
            </h3>
          </div>

            <div class="card-body card-toolbar">
              <table class="table table-row-bordered gy-3">
                <tr>
                  <th>No</th>
                  <th>Name</th>
                  <th width="280px">Action</th>
                </tr>
                @foreach ($permissions as $key => $permission)
                <tr>
                  <td>{{ $permission->id }}</td>
                  <td>{{ $permission->name }}</td>
          <td>
            <a class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1" href="{{ route('permissions.show',$permission->id) }}"><i class="fa fa-eye" aria-hidden="true"></i></a>
            <a class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1" href="{{ route('permissions.edit',$permission->id) }}"><i class="fas fa-pen-nib"></i></a>
            {!! Form::open(['method' => 'DELETE','route' => ['permissions.destroy', $permission->id],'style'=>'display:inline']) !!}
                <button class="btn btn-icon btn-bg-light btn-active-color-danger btn-sm me-1" type="submit"><i class="fa fa-trash"></i></button>
            {!! Form::close() !!}
          </td>
          </tr>
                @endforeach
                </table>

                
{!! $permissions->render() !!}

            </div>

        </div>
      </div>
    </div>
  </div>
</div>

{{-- <p class="text-center text-primary"><small>TimD</small></p> --}}
@endsection