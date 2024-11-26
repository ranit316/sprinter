@extends('layouts.app')
@section('content')

<div class="container px-lg-10">
<div class="card mb-5 mb-xl-10" id="kt_profile_details_view">

    @if ($message = Session::get('success'))
    <div class="alert alert-success">
        <p>{{ $message }}</p>
    </div>
    @endif
    
    <!--begin::Card header-->
    <div class="card-header cursor-pointer">
        <!--begin::Card title-->
        <div class="card-title m-0">
            <h3 class="fw-bold m-0">Profile Details</h3>
        </div>

        <!--end::Card title-->
        @foreach($users as $user)
        <!--begin::Action-->
        <a href="{{ route('profile.edit',$user['id']) }}" class="btn btn-sm btn-primary align-self-center">Edit Profile</a>   
        <!--end::Action-->    
    </div>
    <!--begin::Card header-->

    <!--begin::Card body-->
    <div class="card-body p-9">
        <!--begin::Row-->
        <div class="row mb-7">
            <!--begin::Label-->
            <label class="col-lg-4 fw-semibold text-muted">Full Name</label>
            <!--end::Label-->

            <!--begin::Col-->
            <div class="col-lg-8">                    
                <span class="fw-bold fs-6 text-gray-800">  {{$user['name']}}</span>                
            </div>
            <!--end::Col-->
        </div>
        <!--end::Row-->

        <!--begin::Input group-->
        <div class="row mb-7">
            <!--begin::Label-->
            <label class="col-lg-4 fw-semibold text-muted">Company</label>
            <!--end::Label-->

            <!--begin::Col-->
            <div class="col-lg-8 fv-row">
                <span class="fw-semibold text-gray-800 fs-6">Timd</span>                         
            </div>
            <!--end::Col-->
        </div>
        <!--end::Input group-->

        <!--begin::Input group-->
        <div class="row mb-7">
           <!--begin::Label-->
           <label class="col-lg-4 fw-semibold text-muted">
                Email 

                <span class="ms-1" data-bs-toggle="tooltip" aria-label="Phone number must be active" data-bs-original-title="Phone number must be active" data-kt-initialized="1">
                    <i class="ki-duotone ki-information fs-7"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i>                </span>              
            </label>
            <!--end::Label-->
            
            <!--begin::Col-->
            <div class="col-lg-8 d-flex align-items-center">
                <span class="fw-bold fs-6 text-gray-800 me-2">{!!$user['email']!!}</span>                      
                <span class="badge badge-success">Verified</span>
            </div>
            <!--end::Col-->
        </div>
        <!--end::Input group-->

        <!--begin::Input group-->
        {{-- <div class="row mb-7">
            <!--begin::Label-->
            <label class="col-lg-4 fw-semibold text-muted">Password</label>
            <!--end::Label-->

            <!--begin::Col-->
            <div class="col-lg-8">
                <a href="#" class="fw-semibold fs-6 text-gray-800 text-hover-primary">{!!$user['password']!!}</a>                         
            </div>
            <!--end::Col-->
        </div> --}}
        <!--end::Input group-->

        <!--begin::Input group-->
        <div class="row mb-7">
             <!--begin::Label-->
             <label class="col-lg-4 fw-semibold text-muted">
                Country
                
                <span class="ms-1" data-bs-toggle="tooltip" aria-label="Country of origination" data-bs-original-title="Country of origination" data-kt-initialized="1">
                    <i class="ki-duotone ki-information fs-7"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i>                </span>
            </label>

            <div class="col-lg-8">
                <span class="fw-bold fs-6 text-gray-800">India</span> 
            </div>
            <!--end::Col-->
        </div>
   

        @endforeach
    </div>
    <!--end::Card body-->     
</div>
</div>

@endsection