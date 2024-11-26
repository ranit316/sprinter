@if(session('success'))


 
<!--begin::Alert-->
<div class="alert alert-success d-flex align-items-center p-5">
  <!--begin::Icon-->
  <i class="ki-duotone ki-shield-tick fs-2hx text-success me-4"><span class="path1"></span><span class="path2"></span></i>
  <!--end::Icon-->

  <!--begin::Wrapper-->
  <div class="d-flex flex-column">
      <!--begin::Title-->
      <h4 class="mb-1 text-dark">Well done!</h4>
      <!--end::Title-->

      <!--begin::Content-->
      <span>{{session('success')}}</span>
      <!--end::Content-->
  </div>
  <!--end::Wrapper-->
</div>
<!--end::Alert-->

                              

@elseif(session('error'))


<!--begin::Alert-->
<div class="alert alert-danger d-flex align-items-center p-5">
  <!--begin::Icon-->
  <i class="ki-duotone ki-shield-tick fs-2hx text-danger me-4"><span class="path1"></span><span class="path2"></span></i>
  <!--end::Icon-->

  <!--begin::Wrapper-->
  <div class="d-flex flex-column">
      <!--begin::Title-->
      <h4 class="mb-1 text-dark">Warning!</h4>
      <!--end::Title-->

      <!--begin::Content-->
      <span>{{session('error')}}</span>
      <!--end::Content-->
  </div>
  <!--end::Wrapper-->
</div>
<!--end::Alert-->

@endif