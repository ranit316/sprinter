 @if(!empty($datas))
 @foreach ($datas as $data)
       
    

        
        <h3 class="fs-5 text-muted m-0 pb-5" data-kt-search-element="category-title">{{ $lable[$data['table']] ?? $data['table'] }}</h3>

        @foreach ($data['data'] as $d)
        <div class="d-flex align-items-center mb-5">
            <!--begin::Symbol-->
           
            <!--end::Symbol-->
            <!--begin::Title-->
            <div class="d-flex flex-column">
                <a href="{{ route($all_route[$data['table']], $d->id) }}" class="fs-6 text-gray-800 text-hover-primary fw-semibold">
                    @foreach ($show_column[$data['table']] as $show)
                    {{ ((array) $d)[$show] }}
                @endforeach
            </a>
               
            </div>
            <!--end::Title-->
        </div>
        <!--end::Item-->
        @endforeach

    @endforeach
    @else 
No data founds
    @endif