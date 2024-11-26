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
                    <h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">Categories</h1>
                    <!--end::Title-->
                    <!--begin::Breadcrumb-->
                    <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                        <!--begin::Item-->
                        <li class="breadcrumb-item text-muted">
                            <a href="{{route('categories.index')}}" class="text-muted text-hover-primary">Categories</a>
                        </li>
                        <!--end::Item-->
                        <!--begin::Item-->
                        <li class="breadcrumb-item">
                            <span class="bullet bg-gray-500 w-5px h-2px"></span>
                        </li>
                        <!--end::Item-->
                        <!--begin::Item-->
                        <li class="breadcrumb-item text-muted">List</li>
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

                        <button type="button"  class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modals-add">
                            <span class="fa fa-plus"></span> Add Category		
                        </button>


                        <!--begin::Export dropdown-->
                        <button type="button" class="btn btn-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                            <i class="ki-duotone ki-exit-down fs-2"><span class="path1"></span><span class="path2"></span></i>						Export Report
                        </button>
                        <!--begin::Menu-->
                            <div id="kt_datatable_example_export_menu" data-kt-menu="true" class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-200px py-4" style="">
                                    
                              
                            
                                <!--begin::Menu item-->
                                <div class="menu-item px-3">
                                    <form id="category_excel_form" method="POST" action="{{route('category.excel.export')}}">
                                        @csrf
                                        <input type="hidden" name="all_ids" id="all_ids_excell" />
                                        <table><tr><td>
                                        <select  name="type" id="excel_type">
                                            <option value="All" >All</option>
                                            <option value="Selected" >Selected</option>
                                        </select>
                                        </td><td>
                                    <a href="javascript:void(0);" onClick="submit_form('category_excel_form','all_ids_excell','excel_type');" class="menu-link px-3" data-kt-export="excel">
                                         Excel 
                                    </a>
                                    </td></tr></table>
                                    </form>
                                   
                                </div>
                                <!--end::Menu item-->
                            
                                <!--begin::Menu item-->
                                <div class="menu-item px-3">
                                    <form id="category_csv_form" method="POST" action="{{route('category.csv.export')}}">
                                        @csrf
                                        <input type="hidden" name="all_ids" id="all_ids_csv" />
                                        <table><tr><td>
                                        <select  name="type" id="csv_type">
                                            <option value="All" >All</option>
                                            <option value="Selected" >Selected</option>
                                        </select>
                                        </td><td>
                                    <a href="javascript:void(0);" onClick="submit_form('category_csv_form','all_ids_csv','csv_type');" class="menu-link px-3" data-kt-export="csv">
                                         CSV 
                                    </a>
                                    </td></tr></table>
                                    </form>
                                </div>
                                <!--end::Menu item-->
                            
                                <!--begin::Menu item-->
                                <div class="menu-item px-3">
                                    <form id="category_pdf_form" method="POST" action="{{route('category.pdf.export')}}">
                                        @csrf
                                        <input type="hidden" name="all_ids" id="all_ids_pdf" />
                                        <table><tr><td>
                                        <select  name="type" id="pdf_type">
                                            <option value="All" >All</option>
                                            <option value="Selected" >Selected</option>
                                        </select>
                                        </td><td>
                                    <a href="javascript:void(0);" onClick="submit_form('category_pdf_form','all_ids_pdf','pdf_type');" class="menu-link px-3" data-kt-export="pdf">
                                         PDF 
                                    </a>
                                    </td></tr></table>
                                    </form>
                                </div>
                                <!--end::Menu item--> 
                            </div>
                            <!--end::Menu-->
                                                <!--end::Export dropdown-->
                            
                                                <!--begin::Hide default export buttons-->
                                                <div id="kt_datatable_example_buttons" class="d-none"><div class="dt-buttons btn-group flex-wrap">      <button class="btn btn-secondary buttons-copy buttons-html5" tabindex="0" aria-controls="kt_datatable_example" type="button"><span>Copy</span></button> <button class="btn btn-secondary buttons-excel buttons-html5" tabindex="0" aria-controls="kt_datatable_example" type="button"><span>Excel</span></button> <button class="btn btn-secondary buttons-csv buttons-html5" tabindex="0" aria-controls="kt_datatable_example" type="button"><span>CSV</span></button> <button class="btn btn-secondary buttons-pdf buttons-html5" tabindex="0" aria-controls="kt_datatable_example" type="button"><span>PDF</span></button> </div></div>
                                                <!--end::Hide default export buttons->
                                            </div>
                                            <!--end::Card toolbar-->
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
                            <div class="card-header border-0 pt-5">
                                <h3 class="card-title align-items-start flex-column">
                                    <span class="card-label fw-bold fs-3 mb-1">Categories</span>
                                    <span class="text-muted fw-semibold fs-7"></span>
                                </h3>
                                <div class="card-toolbar">
                                    <!--begin::Menu-->
                                    <button type="button" class="btn btn-sm btn-icon btn-color-primary btn-active-light-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                                        <i class="ki-duotone ki-category fs-6">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                            <span class="path3"></span>
                                            <span class="path4"></span>
                                        </i>
                                    </button>
                                    <!--begin::Menu 1-->
                                    <div class="menu menu-sub menu-sub-dropdown w-250px w-md-300px" data-kt-menu="true" id="kt_menu_65a1215942bd4">
                                        <!--begin::Header-->
                                        <div class="px-7 py-5">
                                            <div class="fs-5 text-gray-900 fw-bold">Filter Options</div>
                                        </div>
                                        <!--end::Header-->
                                        <!--begin::Menu separator-->
                                        <div class="separator border-gray-200"></div>
                                        <!--end::Menu separator-->
                                        <!--begin::Form-->
                                        <div class="px-7 py-5">
                                            <form id="searchform" name="searchform">

                                           
                                              
                                           
                                                
                                           




                                           
                                                <!--begin::Input group-->
                                                <div class="mb-10">
                                                    <!--begin::Label-->
                                                    <label class="form-label fw-semibold">Name :</label>
                                                    <!--end::Label-->
                                                    <!--begin::Options-->
                                                    <div class="d-flex">
                                                        <input type="text"  name="name" value="" class="form-control form-control-lg form-control-solid" placeholder="Name"
                                                        aria-label="Name" >
                                                    </div>
                                                    <!--end::Options-->
                                                </div>
                                                <!--end::Input group-->
                                               
                                                <!--begin::Actions-->
                                                <div class="d-flex justify-content-end">
                                                    <button type="reset" class="btn btn-sm btn-light btn-active-light-primary me-2" data-kt-menu-dismiss="true">Reset</button>
                                                    
                                                    <a class='btn btn-sm btn-primary' href='{{ route('categories.index') }}' id='search_btn'>Search</a>


                                                </div>
                                            </form>
                                            <!--end::Actions-->
                                        </div>
                                        <!--end::Form-->
                                    </div>
                                    <!--end::Menu 1-->
                                    <!--end::Menu-->
                                </div>
                            </div>
                            <!--end::Header-->
                            @include('message_notification.notification')
   
                            <div id="pagination_data">
                                @include('categories.index-pagination', ['categories' => $categories])
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




   


  <!--begin::Modal - Create App-->
  <div class="modal fade" id="modals-add" tabindex="-1" aria-hidden="true">
    <!--begin::Modal dialog-->
    <div class="modal-dialog modal-dialog-centered mw-900px">
        <!--begin::Modal content-->
        <div class="modal-content">
            <!--begin::Modal header-->
            <div class="modal-header">
                <!--begin::Modal title-->
                <h2>Create Category</h2>
                <!--end::Modal title-->
                <!--begin::Close-->
                <div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
                    <i class="ki-duotone ki-cross fs-1">
                        <span class="path1"></span>
                        <span class="path2"></span>
                    </i>
                </div>
                <!--end::Close-->
            </div>
            <!--end::Modal header-->
            <!--begin::Modal body-->
            <div class="modal-body py-lg-10 px-lg-10">
                <form class="add-new-modal"   enctype="multipart/form-data" >
                    
                   
                  
                
                   
                   <div class="w-100">
                    <!--begin::Input group-->
                    <div class="fv-row mb-10 fv-plugins-icon-container">
                        <!--begin::Label-->
                        <label class="d-flex align-items-center fs-5 fw-semibold mb-2">
                            <span class="required">Name</span>
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
                        <input type="text"  required class="form-control form-control-lg form-control-solid" name="name" id="name" placeholder="Name" maxlength="250" >
                        <!--end::Input-->
                    <div id="name_error" class="fv-plugins-message-container error_msg fv-plugins-message-container--enabled invalid-feedback"></div></div>
                    <div class="fv-row mb-10 fv-plugins-icon-container">
                        <!--begin::Label-->
                        <label class="d-flex align-items-center fs-5 fw-semibold mb-2">
                            <span class="required">Description</span>
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
                        <textarea required class="form-control form-control-lg form-control-solid" name="description" id="description" placeholder="Description"  ></textarea>
                        <!--end::Input-->
                    <div id="description_error" class="fv-plugins-message-container error_msg fv-plugins-message-container--enabled invalid-feedback"></div></div>

                 
                    <div class="fv-row mb-10 fv-plugins-icon-container">
                        <!--begin::Label-->
                        <label class="d-flex align-items-center fs-5 fw-semibold mb-2">
                            <span class="">Photo</span>
                           
                        </label>
                        <!--end::Label-->
                        <!--begin::Input-->
                     
                        <input type="file" class="form-control" onchange="readURL(this,'blah_2');" name="photo" id="file" accept=".jpg, .jpeg, .png"   />
                        <input type="hidden" name="old_photo" id="old_photo" value="" />
                        <img src="" id="blah_2" width="200" />
                        <!--end::Input-->
                    <div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback"></div></div>


                    <!--end::Input group-->
                    <div class="fv-row mb-10 fv-plugins-icon-container" style="text-align: center">
                        <button type="submit" id="modal_add" class="btn btn-lg btn-primary data-add">Save</button>
                    
                    </div>
                  
                </div>

                   </form>
            </div>
            <!--end::Modal body-->
        </div>
        <!--end::Modal content-->
    </div>
    <!--end::Modal dialog-->
</div>
<!--end::Modal - Create App-->

  
  <!-- Modal to add  Ends-->
  

@endsection
