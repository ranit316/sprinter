<div id="kt_app_footer" class="app-footer">
    <!--begin::Footer container-->
    <div class="app-container container-fluid d-flex flex-column flex-md-row flex-center flex-md-stack py-3">
        <!--begin::Copyright-->
        <div class="text-gray-900 order-2 order-md-1">
            <a href="#" class="text-gray-800 text-hover-primary"> {{optional(DB::table('app_infos')->first())->footer_left}}</a>
        </div>
        <!--end::Copyright-->
        <!--begin::Menu-->
       
        <ul class="menu menu-gray-600 menu-hover-primary fw-semibold order-1">
            @foreach(footer_content() as $data)
            @if ($data->title != 'Unsubscibe')
            <li class="menu-item">
                <a href="{{$data->description}}" class="menu-link px-2">{{$data->title}}</a>
            </li>
          
            @endif
            @endforeach
        </ul>
        
        <!--end::Menu-->
    </div>
    <!--end::Footer container-->
</div>

