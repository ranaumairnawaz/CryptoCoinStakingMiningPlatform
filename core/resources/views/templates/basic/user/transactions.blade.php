@extends($activeTemplate . 'layouts.simple')
@section('content')
<div class="wrap">
    <div class="wg-setting">
        <div class="top-wg mb-20">
            
            {{-- Modified Header Section --}}
            <div class="header-2 header-fix bg-primary-100">
                {{-- Assuming simple_header handles the back button/title for the page --}}
                @include($activeTemplate . 'partials.simple_header', ['title' => 'Transaction Log'])
            </div>
        </div>
    </div>
    <div class="wg-transaction-history">
        <div class="tf-container">
            <ul class="list">
                @forelse($transactions as $trx)
                <li>
                    <a href="{{ route('user.transactions') }}" class="box-transaction-item">
                        <div class="content" style="max-width: 100%;">
                            <div class="top d-flex justify-content-between align-items-center w-100">
                                <p class="name text-capitalize fw-6">
                                    {{-- Conditional Logic for Remark --}}
                                    @if ($trx->remark == 'ptc_earn')
                                        @lang('Earnings')
                                    @elseif ($trx->remark == 'staking_reward')
                                        @lang('Staking Profit')
                                    @elseif ($trx->remark == 'staking')
                                        @lang('Staking')
                                    @elseif ($trx->remark == 'withdraw')
                                        @lang('Withdraw')
                                    @elseif ($trx->remark == 'subscribe_plan')
                                        @lang('Plan Subscription')
                                    @elseif ($trx->remark == 'deposit' || $trx->remark == 'balance_add')
                                        @lang('Deposit')
                                    @else
                                        {{ __($trx->remark) }}
                                    @endif
                                </p>
                                <p class="price fw-5 @if ($trx->trx_type == '+') text-success @else text-danger @endif ">
                                    {{ $trx->trx_type }} 
                                    @if($trx->remark == 'staking_reward' || $trx->remark == 'staking')
                                        {{ getAmount($trx->amount) }} TRUMP
                                    @else
                                        {{ showAmount($trx->amount) }}
                                    @endif
                                </p>
                            </div>
                            <div class="bottom d-flex justify-content-between align-items-center">
                                <p class="text-medium">{{ diffForHumans($trx->created_at) }}</p>
                            </div>
                        </div>
                    </a>
                </li>
                @empty
                <li>
                    <a href="" class="box-transaction-item">
                        <div class="content">
                            <div class="top d-flex justify-content-between align-items-center">
                                <p class="name fw-6">No transactions</p>
                            </div>
                        </div>
                    </a>
                </li>
                @endforelse
            </ul>
        </div>
    </div>
</div>


@endsection

@push('style-lib')
    <link rel="stylesheet" href="{{ asset('assets/global/css/select2.min.css') }}">
@endpush

@push('script-lib')
    <script src="{{ asset('assets/global/js/select2.min.js') }}"></script>
@endpush

@push('script')
    <script>
        (function($) {
            "use strict";
            // Initialize select2 for the filter dropdowns
            $('.select2-basic').select2({
                dropdownParent: $('.responsive-filter-card')
            });

            // Toggle filter card visibility for the "simple" design
            $('.showFilterBtn').on('click', function() {
                $('.responsive-filter-card').slideToggle();
            });
        })(jQuery);
    </script>
@endpush

@push('style')
    <style>
        /* Adapt select2 for the simple style */
        .select2-container .select2-selection--single {
            height: 44px !important; /* Matches form-control style-1 height */
            border: 1px solid #e5e5e5 !important;
            border-radius: 8px !important;
            line-height: 44px !important;
        }

        .select2-container--default .select2-selection--single .select2-selection__rendered {
            line-height: 44px !important;
            padding-left: 15px !important;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 42px !important;
        }

        .responsive-filter-card {
            display: none; /* Hidden by default, shown by JS */
        }
        
        /* Ensure the transaction items look like clean, separate cards/list items */
        .transaction-list .transaction-item {
            border: 1px solid #eee; /* Subtle border for separation */
        }
    </style>
@endpush