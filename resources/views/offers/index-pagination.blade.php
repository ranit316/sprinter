@if (!empty($offers))

    <!--begin::Body-->
    <div class="card-body py-3">
        <!--begin::Table container-->
        <div class="table-responsive">
            <!--begin::Table-->

            <table class="table table-row-bordered table-row-gray-100 align-middle gs-0 gy-3">
                <!--begin::Table head-->
                <thead>
                    <tr class="fw-bold text-muted">

                        <th>
                        <div class="form-check form-check-sm form-check-custom form-check-solid">
                                <input class="form-check-input-all mx-2" id="checkAll" onClick="checkAll();"  type="checkbox"  value="1">
                                Sys Id     
                        </div>
                        </th>
                        <th class="">Offer Name</th>
                        <th class="">Description</th>
                        <th class="">Start Date</th>
                        <th class="">End Date</th>
                        <th class="">Banner</th>
                        <th class="">Status</th>
                        <th class="min-w-100px text-end">Actions</th>
                    </tr>
                </thead>
                <!--end::Table head-->
                <!--begin::Table body-->
                <tbody>
                    @if ($offers->count() > 0)
                        @foreach ($offers as $offer)
                            <tr>
                                <td>
                                    <div class="form-check form-check-sm form-check-custom form-check-solid">
                                        <input name="all_ids" class="form-check-input offer_checkbox_id mx-2"
                                            onClick="all_selected_check_boxes();" type="checkbox"
                                            value="{{ $offer['id'] }}">
                                            {{ $offer['id'] }}
                                    </div>
                                </td>
                                <td>
                                    {{ $offer['name'] }}
                                </td>

                                <td>
                                    {!! $offer['description'] !!}
                                </td>
                                <td>
                                    {!! $offer['start_date'] !!}
                                </td>
                                <td>
                                    {!! $offer['end_date'] !!}
                                </td>
                                <td>
                                    {!! $offer['photo'] != '' ? '<img src="' . asset($offer['photo']) . '" width="60" />' : '' !!}
                                </td>
                               
                                <td>
                                    <span class="badge badge-light-<?php if ($offer['status'] == 'Active') {
                                        echo 'success';
                                    } elseif ($offer['status'] == 'Inactive') {
                                        echo 'danger';
                                    } ?>">{{ $offer['status'] }}</span>
                                </td>

                                <td class="text-end">
                                    <form id="offer_delete_form_id_{{ $offer['id'] }}"
                                        action="{{ route('offers.destroy', $offer['id']) }}" method="POST">

                                        @can('offer-edit')
                                            <a href="{{ route('offers.edit', $offer['id']) }}"
                                                class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1">
                                                <i class="ki-duotone ki-pencil fs-2">
                                                    <span class="path1"></span>
                                                    <span class="path2"></span>
                                                </i>
                                            </a>
                                        @endcan



                                        @can('offer-delete')
                                            @csrf
                                            @method('DELETE')

                                            <button type="button"
                                                onclick="confirm_delete_button('offer_delete_form_id_{{ $offer['id'] }}');"
                                                class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm"><i
                                                    class="ki-duotone ki-trash fs-2">
                                                    <span class="path1"></span>
                                                    <span class="path2"></span>
                                                    <span class="path3"></span>
                                                    <span class="path4"></span>
                                                    <span class="path5"></span>
                                                </i></button>
                                        @endcan
                                    </form>

                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="5" align="center">No data founds</td>
                        </tr>
                    @endif

                </tbody>
                <!--end::Table body-->
            </table>
            <!--end::Table-->

            <div id="pagination">
                {{ $offers->links() }}
            </div>

        </div>
        <!--end::Table container-->
    </div>
    <!--end::Body-->





@endif
