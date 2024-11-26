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
                <h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">Platform</h1>
                <!--end::Title-->
                <!--begin::Breadcrumb-->
                <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                    <!--begin::Item-->
                    <li class="breadcrumb-item text-muted">
                        <a href="{{route('platforms.index')}}" class="text-muted text-hover-primary">Platform</a>
                    </li>
                    <!--end::Item-->
                    <!--begin::Item-->
                    <li class="breadcrumb-item">
                        <span class="bullet bg-gray-500 w-5px h-2px"></span>
                    </li>
                    <!--end::Item-->
                    <!--begin::Item-->
                    <li class="breadcrumb-item text-muted">View</li>
                    <!--end::Item-->
                </ul>
                <!--end::Breadcrumb-->
            </div>
            <!--end::Page title-->
            <!--begin::Actions-->
            <div class="d-flex align-items-center gap-2 gap-lg-3">
                <!--begin::Filter menu-->

                <!--end::Filter menu-->
                <!--begin::Secondary button-->
                <!--end::Secondary button-->
                <!--begin::Primary button-->
               
                <div class="card-toolbar flex-row-fluid justify-content-end gap-5">

                    <a href="{{route('platforms.index')}}" type="button"  class="btn btn-primary" >
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
                            <h3 class="card-title">View Platform</h3>
                            <div class="card-toolbar">
                            </div>
                        </div>
                        <!--end::Header-->
                        @include('message_notification.notification')

                      
                        <div class="card-body">
                   
                          <div class="w-100">
                            <div class="row">

                          <div class="col-6">
                             <div class="fv-row mb-10 fv-plugins-icon-container">
                                 <label class="d-flex align-items-center fs-5 fw-semibold mb-2">
                                     <span>Platform Name</span>
                                    
                                 </label>
                                 <div class="bg-light-success py-2 px-2">{{$platform->name}}</div>
                            </div>
                          </div>

                          <div class ="col-6">
                             <div class="fv-row mb-10 fv-plugins-icon-container">
                                 <!--begin::Label-->
                                 <label class="d-flex align-items-center fs-5 fw-semibold mb-2">
                                     <span>Platform Description</span>
                                    
                                 </label>
                                 <div class="bg-light-success py-2 px-2">{{strip_tags($platform->description)}}</div>                      
                            </div>
                          </div>

                          <div class="col-6">
                            <div class="fv-row mb-10 fv-plugins-icon-container">
                                <!--begin::Label-->
                                <label class="d-flex align-items-center fs-5 fw-semibold mb-2">
                                    <span>Demo Details</span>
                                   
                                </label>
                                <div class="bg-light-success py-2 px-2">{{$platform->demo_details}}</div>
                            </div>
                         </div>
        


                          <div class="col-6">  
                             <div class="fv-row mb-10 fv-plugins-icon-container">
                                <!--begin::Label-->
                                <label class="d-flex align-items-center fs-5 fw-semibold mb-2">
                                    <span>Status</span>
                                  
                                </label>
                                <div class="bg-light-success py-2 px-2">{{$platform->status}}</div>
                             </div>
                          </div>
        
                          
                             <div class="fv-row mb-10 fv-plugins-icon-container">
                                 <!--begin::Label-->
                                 <label class="d-flex align-items-center fs-5 fw-semibold mb-2">
                                     <span class="">Banner</span> 
                                 </label>
                                 <input type="hidden" name="old_photo" id="old_photo" value="" />
                                 <img src="" id="blah_2" width="200" class="pt-5" />
                                 @if($platform->photo!='')
                                 <img src="{{asset($platform->photo)}}" width="150" />
                                 @endif
                                 <!--end::Input-->
                                <div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback"></div>
                            </div>
                           
                         </div>
                        </div>
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
