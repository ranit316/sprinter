@extends('layouts.app')


@section('content')

<div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
  <div id="kt_app_toolbar_container" class="app-container container-xxl d-flex flex-stack">
      <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
          <h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">Notification</h1>
          <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
              <li class="breadcrumb-item text-muted">
                  <a href="#" class="text-muted text-hover-primary">Notification</a>
              </li>
              <li class="breadcrumb-item">
                  <span class="bullet bg-gray-500 w-5px h-2px"></span>
              </li>

              <li class="breadcrumb-item text-muted">List</li>

          </ul>
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
              <span class="card-label fw-bold fs-3 mb-1">Notification</span>
              <span class="text-muted fw-semibold fs-7"></span>
            </h3>
          </div>

            <div class="card-body card-toolbar">
              <table class="table table-row-bordered gy-3">
                <tr>
                  <th>No</th>
                  <th>Message</th>
                  <th width="280px">Module</th>
                  <th>Status</th>
                </tr>
                @foreach ($notifi as $key => $notification)
                <tr>
                  <td>{{ $notification->id }}</td>
                  <td>{{ $notification->message }}</td>
                  <td><span class="badge badge-light-warning">{{ $notification->module }}</span></td>
                  <td><span class="badge badge-light-success">{{ $notification->is_read }}</span></td>
                </tr>
                @endforeach
                </table>

            </div>

        </div>
      </div>
    </div>
  </div>
</div>

{{-- <p class="text-center text-primary"><small>TimD</small></p> --}}
@endsection