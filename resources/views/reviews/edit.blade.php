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
                <h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">Review</h1>
                <!--end::Title-->
                <!--begin::Breadcrumb-->
                <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                    <!--begin::Item-->
                    <li class="breadcrumb-item text-muted">
                        <a href="{{route('reviews.index')}}" class="text-muted text-hover-primary">Review</a>
                    </li>
                    <!--end::Item-->
                    <!--begin::Item-->
                    <li class="breadcrumb-item">
                        <span class="bullet bg-gray-500 w-5px h-2px"></span>
                    </li>
                    <!--end::Item-->
                    <!--begin::Item-->
                    <li class="breadcrumb-item text-muted">Edit</li>
                    <!--end::Item-->
                </ul>
                <!--end::Breadcrumb-->
            </div>
            <div class="d-flex align-items-center gap-2 gap-lg-3">
               
                <div class="card-toolbar flex-row-fluid justify-content-end gap-5">

                    <a href="{{route('reviews.index')}}" type="button"  class="btn btn-primary" >
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

    @if (count($errors) > 0)
    <div class="alert alert-danger">
        <strong>Whoops!</strong> There were some problems with your input.<br><br>
        <ul>
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
        </ul>
    </div>
    @endif


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
                            <h3 class="card-title">Edit Reviews</h3>
                            <div class="card-toolbar">
                            </div>
                        </div>
                        <!--end::Header-->
                        @include('message_notification.notification')

                        <div class="card-body">
                            {!! Form::model($review, ['method' => 'PATCH','route' => ['reviews.update', $review->id]]) !!}

                          <div class="w-100">

                            <div class="fv-row mb-10 fv-plugins-icon-container">
                                <!--begin::Label-->
                                <label class="d-flex align-items-center fs-5 fw-semibold mb-2">
                                    <span class="required">Status</span>
                                    <span class="ms-1" data-bs-toggle="tooltip"
                                        aria-label="Specify your unique app name"
                                        data-bs-original-title="Specify your unique app name" data-kt-initialized="1">
                                        <i class="ki-duotone ki-information-5 text-gray-500 fs-6">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                            <span class="path3"></span>
                                        </i>
                                    </span>
                                </label>
                                <select class="form-select form-select-solid" aria-label="Select example" name="status">
                                    <option>Select</option>
                                    <option <?php echo ($review->status === 'Pending') ? 'selected' : ''; ?> value="Pending">Pending</option>
                                    <option <?php echo ($review->status === 'Approved') ? 'selected' : ''; ?> value="Approved">Approved</option>
                                    <option <?php echo ($review->status === 'Rejected') ? 'selected' : ''; ?> value="Rejected">Rejected</option>
                                </select>
                                <!--end::Input-->
                                <div id="user_name_error"
                                    class="fv-plugins-message-container error_msg fv-plugins-message-container--enabled invalid-feedback">
                                </div>
                            </div>
                            
                            @if($review->created_by == '1')
                            {{-- @if(auth()->user()->id == '1') --}}
                            <div class="fv-row mb-10 fv-plugins-icon-container">
                                <!--begin::Label-->
                                <label class="d-flex align-items-center fs-5 fw-semibold mb-2">
                                    <span class="required">Type</span>
                                    <span class="ms-1" data-bs-toggle="tooltip"
                                        aria-label="Specify your unique app name"
                                        data-bs-original-title="Specify your unique app name" data-kt-initialized="1">
                                        <i class="ki-duotone ki-information-5 text-gray-500 fs-6">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                            <span class="path3"></span>
                                        </i>
                                    </span>
                                </label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <select required
                                    class="form-control form-control-lg" name="type"
                                    id="type" placeholder="Type" onchange="changetype(this.value);" >
                                    <option <?php echo ($review->type === 'Text') ? 'selected': '';?> value="Text">Text</option>
                                    <option <?php echo ($review->type === 'Image') ? 'selected': '';?> value="Image">Image</option>
                                    <option <?php echo($review->type === 'Video') ? 'selected': '';?>value="Video">Video</option>
                                </select>
                                <!--end::Input-->
                                <div id="type_error"
                                    class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
                                </div>
                            </div>

                            <div class="fv-row mb-10 fv-plugins-icon-container" style="display:block;" id="Text_div">
                                <!--begin::Label-->
                                <label class="d-flex align-items-center fs-5 fw-semibold mb-2">
                                    <span class="required">Content</span>
                                    <span class="ms-1" data-bs-toggle="tooltip"
                                        aria-label="Specify your unique app name"
                                        data-bs-original-title="Specify your unique app name" data-kt-initialized="1">
                                        <i class="ki-duotone ki-information-5 text-gray-500 fs-6">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                            <span class="path3"></span>
                                        </i>
                                    </span>
                                </label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <textarea  class="form-control form-control-lg error_msg form-control-solid" name="content" id="content"
                                    placeholder="Content" value="<?php echo($review->content === 'text') ? 'selected': '';?>"></textarea>
                                <!--end::Input-->
                                <div id="content_error"
                                    class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
                                </div>
                            </div>

                            <div class="fv-row mb-10 fv-plugins-icon-container" style="display:block;" id="Video_div">
                                <!--begin::Label-->
                                <label class="d-flex align-items-center fs-5 fw-semibold mb-2">
                                    <span class="required">Video Link (Youtube)</span>
                                    <span class="ms-1" data-bs-toggle="tooltip"
                                        aria-label="Specify your unique app name"
                                        data-bs-original-title="Specify your unique app name" data-kt-initialized="1">
                                        <i class="ki-duotone ki-information-5 text-gray-500 fs-6">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                            <span class="path3"></span>
                                        </i>
                                    </span>
                                </label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="text"  class="form-control form-control-lg error_msg form-control-solid" name="video" id="video"
                                    placeholder="video" />
                                <!--end::Input-->
                                <div id="video_error"
                                    class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
                                </div>
                            </div>

                            <div class="fv-row mb-10 fv-plugins-icon-container" style="display:block;" id="Image_div">
                                <!--begin::Label-->
                                <label class="d-flex align-items-center fs-5 fw-semibold mb-2">
                                    <span class="required">Image</span>
                                    <span class="ms-1" data-bs-toggle="tooltip"
                                        aria-label="Specify your unique app name"
                                        data-bs-original-title="Specify your unique app name" data-kt-initialized="1">
                                        <i class="ki-duotone ki-information-5 text-gray-500 fs-6">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                            <span class="path3"></span>
                                        </i>
                                    </span>
                                </label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="file" class="form-control" onchange="readURL(this,'blah_2');" name="photo" id="file" accept=".jpg, .jpeg, .png"   />
                                <input type="hidden" name="old_photo" id="old_photo" value="" />
                                <img src="" id="blah_2" width="200" />
                                <!--end::Input-->
                                <div id="file_error"
                                    class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
                                </div>
                            </div>

                            <div class="fv-row mb-10 fv-plugins-icon-container">
                                <!--begin::Label-->
                                <label class="d-flex align-items-center fs-5 fw-semibold mb-2">
                                    <span class="required">Marks</span>
                                    <span class="ms-1" data-bs-toggle="tooltip"
                                        aria-label="Specify your unique app name"
                                        data-bs-original-title="Specify your unique app name" data-kt-initialized="1">
                                        <i class="ki-duotone ki-information-5 text-gray-500 fs-6">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                            <span class="path3"></span>
                                        </i>
                                    </span>
                                </label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="number" required
                                    class="form-control form-control-lg error_msg form-control-solid" name="marks" value={{$review->marks}}
                                    id="marks" placeholder="Marks" maxlength="250">
                                <!--end::Input-->
                                <div id="marks_error"
                                    class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
                                </div>
                            </div>

                            <div class="fv-row mb-10 fv-plugins-icon-container">
                                <!--begin::Label-->
                                <label class="d-flex align-items-center fs-5 fw-semibold mb-2">
                                    <span class="required">User Name</span>
                                    <span class="ms-1" data-bs-toggle="tooltip"
                                        aria-label="Specify your unique app name"
                                        data-bs-original-title="Specify your unique app name" data-kt-initialized="1">
                                        <i class="ki-duotone ki-information-5 text-gray-500 fs-6">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                            <span class="path3"></span>
                                        </i>
                                    </span>
                                </label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="text" required
                                    class="form-control form-control-lg error_msg form-control-solid" name="user_name" value="{{$review->user_name}}"
                                    id="user_name" placeholder="User Name" maxlength="250">
                                <!--end::Input-->
                                <div id="user_name_error"
                                    class="fv-plugins-message-container error_msg fv-plugins-message-container--enabled invalid-feedback">
                                </div>
                            </div>
                            @endif
                            
                             <div class="fv-row mb-10 fv-plugins-icon-container" style="text-align: center">
                                 <button type="submit" id="modal_add" class="btn btn-primary">Update Review</button>
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