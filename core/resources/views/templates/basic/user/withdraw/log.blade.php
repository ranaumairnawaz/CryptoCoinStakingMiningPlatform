@extends($activeTemplate . 'layouts.simple')
@section('content')
<div class="wrap">
    <div class="wg-setting">
        <div class="top-wg mb-20">
            <div class="header-2 header-fix bg-primary-100">
                @include($activeTemplate . 'partials.simple_header', ['title' => 'Withdraw History'])
            </div>
        </div>
    </div>

    <div class="wg-transaction-history">
        <div class="tf-container">
            <ul class="list">
                @forelse($withdraws as $withdraw)
                @php
                    // Map Status for the color logic
                    $statusClass = 'text-dark';
                    if($withdraw->status == Status::PAYMENT_SUCCESS) $statusClass = 'text-success';
                    elseif($withdraw->status == Status::PAYMENT_PENDING) $statusClass = 'text-warning';
                    elseif($withdraw->status == Status::PAYMENT_REJECT) $statusClass = 'text-danger';
                @endphp
                <li>
                    {{-- Using the exact class 'box-transaction-item' --}}
                    <div class="box-transaction-item">
                        <div class="content" style="max-width: 100%;">
                            {{-- Top Section: Method Name & Amount --}}
                            <div class="top d-flex justify-content-between align-items-center w-100">
                                <p class="name text-capitalize fw-6">
                                    {{ __(@$withdraw->method->name) }}
                                </p>
                                <p class="price fw-5 text-danger">
                                    - {{ showAmount($withdraw->amount) }} {{ __(gs('cur_text')) }}
                                </p>
                            </div>
                            {{-- Bottom Section: Time, Status & Detail Toggle --}}
                            <div class="bottom d-flex justify-content-between align-items-center mt-1">
                                <div class="d-flex align-items-center">
                                    <p class="text-medium me-2">{{ diffForHumans($withdraw->created_at) }}</p>
                                    
                                </div>
                                
                                {{-- Detail Button styled to be subtle --}}
                                <div>
                                    <button class="detailBtn border-0 bg-transparent p-0 text-primary" 
                                        data-user_data="{{ json_encode($withdraw->withdraw_information) }}"
                                        @if ($withdraw->status == Status::PAYMENT_REJECT) data-admin_feedback="{{ $withdraw->admin_feedback }}" @endif>
                                        <i class="icon-eye fs-14 text-primary"></i>
                                    </button>
                                    <p class="text-medium fw-6 {{ $statusClass }}">
                                        @if($withdraw->status == Status::PAYMENT_SUCCESS) @lang('Success')
                                        @elseif($withdraw->status == Status::PAYMENT_PENDING) @lang('Pending')
                                        @elseif($withdraw->status == Status::PAYMENT_REJECT) @lang('Rejected')
                                        @endif
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </li>
                @empty
                <li>
                    <div class="box-transaction-item">
                        <div class="content">
                            <div class="top d-flex justify-content-between align-items-center">
                                <p class="name fw-6">@lang('No withdrawals found')</p>
                            </div>
                        </div>
                    </div>
                </li>
                @endforelse
            </ul>

            {{-- Pagination --}}
            @if ($withdraws->hasPages())
                <div class="mt-3">
                    {{ paginateLinks($withdraws) }}
                </div>
            @endif
        </div>
    </div>
</div>

{{-- DETAIL MODAL --}}
<div id="detailModal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">@lang('Withdraw Details')</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <ul class="list-group userData list-group-flush">
                </ul>
                <div class="feedback"></div>
            </div>
        </div>
    </div>
</div>
@endsection


@push('script')
    <script>
        (function($) {
            "use strict";
            $('.detailBtn').on('click', function() {
                var modal = $('#detailModal');
                var userData = $(this).data('user_data'); 
                var html = ``;
                
                if (userData) {
                    userData.forEach(element => {
                        if (element.type != 'file') {
                            html += `
                            <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                                <span class="text-muted">${element.name}</span>
                                <span class="fw-bold">${element.value}</span>
                            </li>`;
                        }
                    });
                }
                
                modal.find('.userData').html(html);

                if ($(this).data('admin_feedback') != undefined) {
                    var adminFeedback = `
                        <div class="my-3 p-3 bg-light border-radius-sm">
                            <strong class="text-danger">@lang('Admin Feedback')</strong>
                            <p class="mt-1">${$(this).data('admin_feedback')}</p>
                        </div>
                    `;
                    modal.find('.feedback').html(adminFeedback);
                } else {
                    modal.find('.feedback').empty();
                }

                modal.modal('show');
            });
        })(jQuery);
    </script>
@endpush