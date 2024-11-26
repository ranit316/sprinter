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
                    <h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">Support
                        Info
                    </h1>
                    <!--end::Title-->
                    <!--begin::Breadcrumb-->
                    <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                        <!--begin::Item-->
                        <li class="breadcrumb-item text-muted">
                            <a href="#" class="text-muted text-hover-primary">Support Info</a>
                        </li>
                        <!--end::Item-->
                        <!--begin::Item-->
                        <li class="breadcrumb-item">
                            <span class="bullet bg-gray-500 w-5px h-2px"></span>
                        </li>
                        <!--end::Item-->
                        <!--begin::Item-->
                        <li class="breadcrumb-item text-muted">Settings</li>
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


                        <!--end::Header-->
                        @include('message_notification.notification')

                        <!--begin::Basic info-->
                        <div class="card mb-5 mb-xl-10">
                            <!--begin::Card header-->
                            {{-- <div class="card-header border-0 cursor-pointer" role="button" data-bs-toggle="collapse"
                                data-bs-target="#kt_account_profile_details" aria-expanded="true"
                                aria-controls="kt_account_profile_details">
                                <!--begin::Card title-->
                                <div class="card-title m-0">
                                    <h3 class="fw-bold m-0">Details Info</h3>
                                </div>
                                <!--end::Card title-->
                            </div> --}}
                            <!--begin::Card header-->
                            <!--begin::Content-->
                            <div id="kt_account_settings_profile_details" class="collapse show">
                                <!--begin::Form-->
                                <form id="kt_account_profile_details_form" class="form"
                                    action="{{ route('support-whatsapp.store') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <!--begin::Card body-->
                                    {{-- <div class="card-body border-top p-9">
                                        <!--begin::Input group-->
                                        <div class="row mb-6">
                                            <!--begin::Label-->
                                            <label class="col-lg-4 col-form-label fw-semibold fs-6">Logo</label>
                                            <!--end::Label-->
                                            <!--begin::Col-->
                                            <div class="col-lg-8">
                                                <!--begin::Image input-->
                                                <div class="image-input image-input-outline" data-kt-image-input="true"
                                                    style="background-image: url('assets/media/svg/avatars/blank.svg')">
                                                    <!--begin::Preview existing avatar-->
                                                    <div class="image-input-wrapper w-125px h-125px"
                                                        style="background-image: url({{ $appinfo->logo != '' ? asset($appinfo->logo) : '' }})">
                                                    </div>
                                                    <!--end::Preview existing avatar-->
                                                    <!--begin::Label-->
                                                    <label
                                                        class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                                        data-kt-image-input-action="change" data-bs-toggle="tooltip"
                                                        title="Change Logo">
                                                        <i class="ki-duotone ki-pencil fs-7">
                                                            <span class="path1"></span>
                                                            <span class="path2"></span>
                                                        </i>
                                                        <!--begin::Inputs-->
                                                        <input type="file" name="logo" accept=".png, .jpg, .jpeg" />
                                                        <input type="hidden" name="logo_remove" value="" />
                                                        <!--end::Inputs-->
                                                    </label>
                                                    <!--end::Label-->
                                                    <!--begin::Cancel-->
                                                    <span
                                                        class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                                        data-kt-image-input-action="cancel" data-bs-toggle="tooltip"
                                                        title="Cancel Logo">
                                                        <i class="ki-duotone ki-cross fs-2">
                                                            <span class="path1"></span>
                                                            <span class="path2"></span>
                                                        </i>
                                                    </span>
                                                    <!--end::Cancel-->

                                                    <!--begin::Remove-->
                                                    @if ($appinfo->logo != '')
                                                        <span
                                                            class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                                            data-kt-image-input-action="remove" data-bs-toggle="tooltip"
                                                            title="Remove Logo">
                                                            <i class="ki-duotone ki-cross fs-2">
                                                                <span class="path1"></span>
                                                                <span class="path2"></span>
                                                            </i>
                                                        </span>
                                                    @endif
                                                    <!--end::Remove-->
                                                </div>
                                                <!--end::Image input-->
                                                <!--begin::Hint-->
                                                <div class="form-text">Allowed file types: png, jpg, jpeg.</div>
                                                <!--end::Hint-->
                                            </div>
                                            <!--end::Col-->
                                        </div>
                                        <!--end::Input group-->
                                        <!--begin::Input group-->
                                        <div class="row mb-6">
                                            <!--begin::Label-->
                                            <label class="col-lg-4 col-form-label fw-semibold fs-6">Dark Logo</label>
                                            <!--end::Label-->
                                            <!--begin::Col-->
                                            <div class="col-lg-8">
                                                <!--begin::Image input-->
                                                <div class="image-input image-input-outline" data-kt-image-input="true"
                                                    style="background-image: url('assets/media/svg/avatars/blank.svg')">
                                                    <!--begin::Preview existing avatar-->
                                                    <div class="image-input-wrapper w-125px h-125px"
                                                        style="background-image: url({{ $appinfo->dark_logo != '' ? asset($appinfo->dark_logo) : '' }})">
                                                    </div>
                                                    <!--end::Preview existing avatar-->
                                                    <!--begin::Label-->
                                                    <label
                                                        class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                                        data-kt-image-input-action="change" data-bs-toggle="tooltip"
                                                        title="Change Dark Logo">
                                                        <i class="ki-duotone ki-pencil fs-7">
                                                            <span class="path1"></span>
                                                            <span class="path2"></span>
                                                        </i>
                                                        <!--begin::Inputs-->
                                                        <input type="file" name="dark_logo" accept=".png, .jpg, .jpeg" />
                                                        <input type="hidden" name="dark_logo_remove" value="" />
                                                        <!--end::Inputs-->
                                                    </label>
                                                    <!--end::Label-->
                                                    <!--begin::Cancel-->
                                                    <span
                                                        class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                                        data-kt-image-input-action="cancel" data-bs-toggle="tooltip"
                                                        title="Cancel Dark Logo">
                                                        <i class="ki-duotone ki-cross fs-2">
                                                            <span class="path1"></span>
                                                            <span class="path2"></span>
                                                        </i>
                                                    </span>
                                                    <!--end::Cancel-->
                                                    <!--begin::Remove-->
                                                    @if ($appinfo->dark_logo != '')
                                                        <span
                                                            class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                                            data-kt-image-input-action="remove" data-bs-toggle="tooltip"
                                                            title="Remove Dark Logo">
                                                            <i class="ki-duotone ki-cross fs-2">
                                                                <span class="path1"></span>
                                                                <span class="path2"></span>
                                                            </i>
                                                        </span>
                                                    @endif
                                                    <!--end::Remove-->
                                                </div>
                                                <!--end::Image input-->
                                                <!--begin::Hint-->
                                                <div class="form-text">Allowed file types: png, jpg, jpeg.</div>
                                                <!--end::Hint-->
                                            </div>
                                            <!--end::Col-->
                                        </div>
                                        <!--end::Input group-->
                                        <!--begin::Input group-->
                                        <div class="row mb-6">
                                            <!--begin::Label-->
                                            <label class="col-lg-4 col-form-label fw-semibold fs-6">FAV Icon</label>
                                            <!--end::Label-->
                                            <!--begin::Col-->
                                            <div class="col-lg-8">
                                                <!--begin::Image input-->
                                                <div class="image-input image-input-outline" data-kt-image-input="true"
                                                    style="background-image: url('assets/media/svg/avatars/blank.svg')">
                                                    <!--begin::Preview existing avatar-->
                                                    <div class="image-input-wrapper w-125px h-125px"
                                                        style="background-image: url({{ $appinfo->fav_icon != '' ? asset($appinfo->fav_icon) : '' }})">
                                                    </div>
                                                    <!--end::Preview existing avatar-->
                                                    <!--begin::Label-->
                                                    <label
                                                        class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                                        data-kt-image-input-action="change" data-bs-toggle="tooltip"
                                                        title="Change fav Icon">
                                                        <i class="ki-duotone ki-pencil fs-7">
                                                            <span class="path1"></span>
                                                            <span class="path2"></span>
                                                        </i>
                                                        <!--begin::Inputs-->
                                                        <input type="file" name="fav_icon"
                                                            accept=".png, .jpg, .jpeg" />
                                                        <input type="hidden" name="fav_icon_remove" value="" />
                                                        <!--end::Inputs-->
                                                    </label>
                                                    <!--end::Label-->
                                                    <!--begin::Cancel-->
                                                    <span
                                                        class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                                        data-kt-image-input-action="cancel" data-bs-toggle="tooltip"
                                                        title="Cancel Fav Icon">
                                                        <i class="ki-duotone ki-cross fs-2">
                                                            <span class="path1"></span>
                                                            <span class="path2"></span>
                                                        </i>
                                                    </span>
                                                    <!--end::Cancel-->
                                                    <!--begin::Remove-->
                                                    @if ($appinfo->fav_icon != '')
                                                        <span
                                                            class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                                            data-kt-image-input-action="remove" data-bs-toggle="tooltip"
                                                            title="Remove Fav Icon">
                                                            <i class="ki-duotone ki-cross fs-2">
                                                                <span class="path1"></span>
                                                                <span class="path2"></span>
                                                            </i>
                                                        </span>
                                                    @endif
                                                    <!--end::Remove-->
                                                </div>
                                                <!--end::Image input-->
                                                <!--begin::Hint-->
                                                <div class="form-text">Allowed file types: png, jpg, jpeg.</div>
                                                <!--end::Hint-->
                                            </div>
                                            <!--end::Col-->
                                        </div>
                                        <!--end::Input group-->
                                        <!--begin::Input group-->
                                        <div class="row mb-6">
                                            <!--begin::Label-->
                                            <label class="col-lg-4 col-form-label required fw-semibold fs-6">Title</label>
                                            <!--end::Label-->
                                            <!--begin::Col-->
                                            <div class="col-lg-8">
                                                <!--begin::Row-->
                                                <div class="row">
                                                    <!--begin::Col-->
                                                    <div class="col-lg-12 fv-row">
                                                        <input type="text" name="title" required
                                                            class="form-control form-control-lg form-control-solid mb-3 mb-lg-0"
                                                            placeholder="Title" value="{{ $appinfo->title }}" />
                                                    </div>
                                                    <!--end::Col-->

                                                </div>
                                                <!--end::Row-->
                                            </div>
                                            <!--end::Col-->
                                        </div>
                                        <!--end::Input group-->
                                        <!--begin::Input group-->
                                        <div class="row mb-6">
                                            <!--begin::Label-->
                                            <label
                                                class="col-lg-4 col-form-label required fw-semibold fs-6">Description</label>
                                            <!--end::Label-->
                                            <!--begin::Col-->
                                            <div class="col-lg-8">
                                                <!--begin::Row-->
                                                <div class="row">
                                                    <!--begin::Col-->
                                                    <div class="col-lg-12 fv-row">
                                                        <textarea name="description" required class="form-control form-control-lg form-control-solid mb-3 mb-lg-0"
                                                            placeholder="Description">{{ $appinfo->description }}</textarea>
                                                    </div>
                                                    <!--end::Col-->

                                                </div>
                                                <!--end::Row-->
                                            </div>
                                            <!--end::Col-->
                                        </div>
                                        <!--end::Input group-->
                                        <!--begin::Input group-->
                                        <div class="row mb-6">
                                            <!--begin::Label-->
                                            <label class="col-lg-4 col-form-label  fw-semibold fs-6">Version</label>
                                            <!--end::Label-->
                                            <!--begin::Col-->
                                            <div class="col-lg-8">
                                                <!--begin::Row-->
                                                <div class="row">
                                                    <!--begin::Col-->
                                                    <div class="col-lg-12 fv-row">
                                                        <input type="text" name="version"
                                                            class="form-control form-control-lg form-control-solid mb-3 mb-lg-0"
                                                            placeholder="Version" value="{{ $appinfo->version }}" />
                                                    </div>
                                                    <!--end::Col-->

                                                </div>
                                                <!--end::Row-->
                                            </div>
                                            <!--end::Col-->
                                        </div>
                                        <!--end::Input group-->
                                        <!--begin::Input group-->
                                        <div class="row mb-6">
                                            <!--begin::Label-->
                                            <label class="col-lg-4 col-form-label  fw-semibold fs-6">Beta Url</label>
                                            <!--end::Label-->
                                            <!--begin::Col-->
                                            <div class="col-lg-8">
                                                <!--begin::Row-->
                                                <div class="row">
                                                    <!--begin::Col-->
                                                    <div class="col-lg-12 fv-row">
                                                        <input type="text" name="beta_url"
                                                            class="form-control form-control-lg form-control-solid mb-3 mb-lg-0"
                                                            placeholder="Beta Url" value="{{ $appinfo->beta_url }}" />
                                                    </div>
                                                    <!--end::Col-->

                                                </div>
                                                <!--end::Row-->
                                            </div>
                                            <!--end::Col-->
                                        </div>
                                        <!--end::Input group-->
                                        <!--begin::Input group-->
                                        <div class="row mb-6">
                                            <!--begin::Label-->
                                            <label class="col-lg-4 col-form-label  fw-semibold fs-6">Playstore Url</label>
                                            <!--end::Label-->
                                            <!--begin::Col-->
                                            <div class="col-lg-8">
                                                <!--begin::Row-->
                                                <div class="row">
                                                    <!--begin::Col-->
                                                    <div class="col-lg-12 fv-row">
                                                        <input type="text" name="playstore_url"
                                                            class="form-control form-control-lg form-control-solid mb-3 mb-lg-0"
                                                            placeholder="Playstore Url"
                                                            value="{{ $appinfo->playstore_url }}" />
                                                    </div>
                                                    <!--end::Col-->

                                                </div>
                                                <!--end::Row-->
                                            </div>
                                            <!--end::Col-->
                                        </div>
                                        <!--end::Input group-->
                                        <!--begin::Input group-->
                                        <div class="row mb-6">
                                            <!--begin::Label-->
                                            <label class="col-lg-4 col-form-label  fw-semibold fs-6">Appstore Url</label>
                                            <!--end::Label-->
                                            <!--begin::Col-->
                                            <div class="col-lg-8">
                                                <!--begin::Row-->
                                                <div class="row">
                                                    <!--begin::Col-->
                                                    <div class="col-lg-12 fv-row">
                                                        <input type="text" name="appstore_url"
                                                            class="form-control form-control-lg form-control-solid mb-3 mb-lg-0"
                                                            placeholder="Appstore Url"
                                                            value="{{ $appinfo->appstore_url }}" />
                                                    </div>
                                                    <!--end::Col-->

                                                </div>
                                                <!--end::Row-->
                                            </div>
                                            <!--end::Col-->
                                        </div>
                                        <!--end::Input group-->






                                    </div> --}}
                                    <!--end::Card body-->
                                    <!--begin::Actions-->
                                    <div class="card-header border cursor-pointer">
                                        <div class="card-title m-0">
                                            <h3 class="fw-bold m-0">Support Info</h3>
                                        </div>
                                    </div>
                                    @foreach($shows as $show)
                                    <div class="card-body border-top p-9">
                                        <div class="row mb-6">
                                            <!--begin::Label-->
                                            <label class="col-lg-4 col-form-label  fw-semibold fs-6">Email</label>
                                            <!--end::Label-->
                                            <!--begin::Col-->
                                            <div class="col-lg-8">
                                                <!--begin::Row-->
                                                <div class="row">
                                                    <!--begin::Col-->
                                                    <div class="col-lg-12 fv-row">
                                                        <input type="email" name="email"
                                                            class="form-control form-control-lg form-control-solid mb-3 mb-lg-0"
                                                            placeholder="Email" value="{{$show->email}}" />
                                                    </div>
                                                    <!--end::Col-->

                                                </div>
                                                <!--end::Row-->
                                            </div>
                                            <!--end::Col-->
                                        </div>
                                        <div class="row mb-6">
                                            <!--begin::Label-->
                                            <label class="col-lg-4 col-form-label  fw-semibold fs-6">Phone</label>
                                            <!--end::Label-->
                                            <!--begin::Col-->
                                            <div class="col-lg-8">
                                                <!--begin::Row-->
                                                <div class="row">
                                                    <!--begin::Col-->
                                                    <div class="col-lg-12 fv-row">
                                                        <input type="tel" name="phone"
                                                            class="form-control form-control-lg form-control-solid mb-3 mb-lg-0" id="phone"
                                                           onkeyup="maxvalidation(this.value,'phone',10)" placeholder="Phone" value="{{$show->phone}}" />
                                                    </div>
                                                    <!--end::Col-->

                                                </div>
                                                <!--end::Row-->
                                            </div>
                                            <!--end::Col-->
                                        </div>
                                        <div class="row mb-6">
                                            <!--begin::Label-->
                                            <label class="col-lg-4 col-form-label  fw-semibold fs-6">Whatsapp No</label>
                                            <!--end::Label-->
                                            <!--begin::Col-->
                                            <div class="col-lg-8">
                                                <!--begin::Row-->
                                                <div class="row">
                                                    <!--begin::Col-->
                                                    <div class="col-lg-12 fv-row">
                                                        <label class="col-lg-4 col-form-label  fw-semibold fs-6">Whatsapp No 1</label>
                                                        <input type="tel" name="whats_app_1"
                                                            class="form-control form-control-lg form-control-solid mb-3 mb-lg-0"
                                                            placeholder="Whatsapp No 1" id ="whats_app_1" onkeyup="maxvalidation(this.value,'whats_app_1',10)" value="{{$show->whats_app_1}}" />
                                                    </div>
                                                    <div class="col-lg-12 fv-row">
                                                        <label class="col-lg-4 col-form-label  fw-semibold fs-6">Whatsapp No 2</label>
                                                        <input type="tel" name="whats_app_2"
                                                            class="form-control form-control-lg form-control-solid mb-3 mb-lg-0"
                                                           id="whats_app_2" onkeyup="maxvalidation(this.value,'whats_app_2',10)" placeholder="Whatsapp No 2" value="{{$show->whats_app_2}}" />
                                                    </div>
                                                    <div class="col-lg-12 fv-row">
                                                        <label class="col-lg-4 col-form-label  fw-semibold fs-6">Whatsapp No 3</label>
                                                        <input type="tel" name="whats_app_3"
                                                            class="form-control form-control-lg form-control-solid mb-3 mb-lg-0"
                                                           id="whats_app_3" placeholder="Whatsapp No 3"       onkeyup="maxvalidation(this.value,'whats_app_3',10)" value="{{$show->whats_app_3}}" />
                                                    </div>
                                                    <div class="col-lg-12 fv-row">
                                                        <label class="col-lg-4 col-form-label  fw-semibold fs-6">Whatsapp No 4</label>
                                                        <input type="tel" name="whats_app_4"
                                                            class="form-control form-control-lg form-control-solid mb-3 mb-lg-0" id="whats_app_4"
                                                            onkeyup="maxvalidation(this.value,'whats_app_4',10)" placeholder="Whatsapp No 4" value="{{$show->whats_app_4}}" />
                                                    </div>
                                                    <div class="col-lg-12 fv-row">
                                                        <label class="col-lg-4 col-form-label  fw-semibold fs-6">Whatsapp No 5</label>
                                                        <input type="tel" name="whats_app_5"
                                                            class="form-control form-control-lg form-control-solid mb-3 mb-lg-0" id="whats_app_5"
                                                           onkeyup="maxvalidation(this.value,'whats_app_5',10)" placeholder="Whatsapp No 5" value="{{$show->whats_app_5}}" />
                                                    </div>
                                                    <div class="col-lg-12 fv-row">
                                                        <label class="col-lg-4 col-form-label  fw-semibold fs-6">PlatformCTA</label>
                                                        <input type="tel" name="whats_app_6"
                                                            class="form-control form-control-lg form-control-solid mb-3 mb-lg-0" id="whats_app_6"
                                                            onkeyup="maxvalidation(this.value,'whats_app_6',10)" placeholder="Enter Cta Link" value="{{$show->whats_app_6}}" />
                                                    </div>
                                                    <!--end::Col-->
                                                    @endforeach
                                                </div>
                                                <!--end::Row-->
                                            </div>
                                            <!--end::Col-->
                                        </div>

                                    </div>

                                    <div class="card-footer d-flex justify-content-end py-6 px-9">

                                        <button type="submit" class="btn btn-primary"
                                            id="kt_account_profile_details_submit">Save Changes</button>
                                    </div>
                                    <!--end::Actions-->
                                </form>
                                <!--end::Form-->
                            </div>
                            <!--end::Content-->
                        </div>
                        <!--end::Basic info-->
                    </div>




                </div>
                <!--end::Content container-->
            </div>
            <!--end::Content-->
        </div>
        <!--end::Content wrapper-->

        <!-- Modal to add  Ends-->
    @endsection

    <script>
        function maxvalidation(value,id,max){
            var length = value.length;
            if(length > max){
                var new_val = value.substr(0,max)
                document.getElementById(id).value = new_val; 
            }
        }
    </script>