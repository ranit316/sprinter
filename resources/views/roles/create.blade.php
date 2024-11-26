@extends('layouts.app')

@section('content')

  <!--begin::Content wrapper-->
  <div class="d-flex flex-column flex-column-fluid">
    <!--begin::Toolbar-->
    <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
        <!--begin::Toolbar container-->
        <div id="kt_app_toolbar_container" class="app-container container-xxl d-flex flex-stack">
            <!--begin::Page title-->
            <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                <!--begin::Title-->
                <h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">Role</h1>
                <!--end::Title-->
                <!--begin::Breadcrumb-->
                <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                    <!--begin::Item-->
                    <li class="breadcrumb-item text-muted">
                        <a href="{{route('roles.index')}}" class="text-muted text-hover-primary">Role</a>
                    </li>
                    <!--end::Item-->
                    <!--begin::Item-->
                    <li class="breadcrumb-item">
                        <span class="bullet bg-gray-500 w-5px h-2px"></span>
                    </li>
                    <!--end::Item-->
                    <!--begin::Item-->
                    <li class="breadcrumb-item text-muted">Create</li>
                    <!--end::Item-->
                </ul>
                <!--end::Breadcrumb-->
            </div>
            <div class="d-flex align-items-center gap-2 gap-lg-3">
               
                <div class="card-toolbar flex-row-fluid justify-content-end gap-5">

                    <a href="{{route('roles.index')}}" type="button"  class="btn btn-primary" >
                        <span class="fa fa-arrow-left"></span> Back		
                    </a>
                </div>
                <!--end::Primary button-->
            </div>
            <!--end::Actions-->
        </div>
        <!--end::Toolbar container-->
    </div>
    <!--end::Toolbar-->
    <!--begin::Content-->
    <div id="kt_app_content" class="app-content flex-column-fluid">
        <!--begin::Content container-->
        <div id="kt_app_content_container" class="app-container container-xxl">
            <!--begin::Row-->
            <div class="row g-5 g-xl-8">
                <!--begin::Col-->
                <div class="col-xl-12">
                    <!--begin::Tables Widget 1-->
                    <div class="card card-xl-stretch mb-xl-8">
                        <!--begin::Header-->
                        <div class="card-header">
                            <h3 class="card-title">Create Role</h3>
                            <div class="card-toolbar">
                            </div>
                        </div>
                        <!--end::Header-->
                        @include('message_notification.notification')

                      
                        <div class="card-body">

                            {!! Form::open(array('route' => 'roles.store','method'=>'POST')) !!}

                          <div class="w-100">

                             <div class="fv-row mb-10 fv-plugins-icon-container">
                                 <label class="d-flex align-items-center fs-5 fw-semibold mb-2">
                                     <span class="required">Role Name</span>
                                     <span class="ms-1" data-bs-toggle="tooltip" aria-label="Specify your unique app name" data-bs-original-title="Specify your unique role name" data-kt-initialized="1">
                                         <i class="ki-duotone ki-information-5 text-gray-500 fs-6">
                                             <span class="path1"></span>
                                             <span class="path2"></span>
                                             <span class="path3"></span>
                                         </i>
                                     </span>
                                 </label>
                                 <input type="text"   class="form-control form-control-lg form-control-solid" name="name" id="name" placeholder="Role Name" maxlength="250" >
                                 <!--end::Input-->
                                 @error('name')
                                 <span class="text-danger">{{ $message }}</span>
                                 @enderror
                                <div id="name_error" class="fv-plugins-message-container error_msg fv-plugins-message-container--enabled invalid-feedback"></div>
                            </div>

                           
                            <div class="fv-row mb-10 fv-plugins-icon-container">
                                <!--begin::Label-->
                                <label class="d-flex align-items-center fs-5 fw-semibold mb-2">
                                    <span class="required">Permission:</span>
                                    <span class="ms-1" data-bs-toggle="tooltip" aria-label="Specify your unique app name" data-bs-original-title="Specify your unique app name" data-kt-initialized="1">
                                        <i class="ki-duotone ki-information-5 text-gray-500 fs-6">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                            <span class="path3"></span>
                                        </i>
                                    </span>
                                </label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                    @foreach($permission as $permissions)
                                    <div class="form-check form-check-custom form-check-success form-check-solid my-4 mx-2">
                                        <input class="form-check-input" type="checkbox" name="permission[]" value="{{$permissions->name }}" />
                                        <label class="form-check-label" for=""> {{$permissions->name }}  </label>
                                    </div>
                                    @endforeach
                                <!--end::Input-->
                                @error('permission')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            <div id="description_error" class="fv-plugins-message-container error_msg fv-plugins-message-container--enabled invalid-feedback"></div>
                           </div>
                             
         
                             <div class="fv-row mb-10 fv-plugins-icon-container" style="text-align: center">
                                 <button type="submit" class="btn btn-primary">Create Role</button>
                             
                             </div>
                           
                         </div>
         
                         {!! Form::close() !!}

                        </div>
                     

                    </div>
                    <!--endW::Tables Widget 1-->
                </div>
                <!--end::Col-->
        </div>
        <!--end::Content container-->
    </div>
    <!--end::Content-->
</div>
<!--end::Content wrapper-->


@endsection