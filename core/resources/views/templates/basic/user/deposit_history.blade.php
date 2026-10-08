@extends($activeTemplate . 'layouts.simple')
@section('content')
<div class="wrap">
    <div class="wg-setting">
        <div class="top-wg mb-20">
            <div class="header-2 header-fix bg-primary-100">
                @include($activeTemplate . 'partials.simple_header', ['title' => 'Deposit History'])
            </div>
        </div>
    </div>

    <div class="wg-transaction-history">
        <div class="tf-container">
            <ul class="list">
                @forelse($deposits as $deposit)
                @php
                    // Map Status for the badge
                    $statusClass = 'text-dark';
                    if($deposit->status == 1) $statusClass = 'text-success';
                    elseif($deposit->status == 2) $statusClass = 'text-warning';
                    elseif($deposit->status == 3) $statusClass = 'text-danger';
                @endphp
                <li>
                    {{-- Using the exact class 'box-transaction-item' --}}
                    <div class="box-transaction-item">
                        <div class="content" style="max-width: 100%;">
                            {{-- Top Section: Gateway Name & Amount --}}
                            <div class="top d-flex justify-content-between align-items-center w-100">
                                <p class="name text-capitalize fw-6">
                                    {{ __($deposit->gateway?->name) }}
                                </p>
                                <p class="price fw-5 text-success">
                                    + {{ showAmount($deposit->amount + $deposit->charge) }} {{ __(gs('cur_text')) }}
                                </p>
                            </div>
                            {{-- Bottom Section: Time & Status --}}
                            <div class="bottom d-flex justify-content-between align-items-center">
                                <p class="text-medium">{{ diffForHumans($deposit->created_at) }}</p>
                                
                                {{-- Added Status as a small indicator to match the clean look --}}
                                <p class="text-medium fw-6 {{ $statusClass }}">
                                    @if($deposit->status == 1) @lang('Success')
                                    @elseif($deposit->status == 2) @lang('Pending')
                                    @elseif($deposit->status == 3) @lang('Cancelled')
                                    @else @lang('Rejected') @endif
                                </p>
                            </div>
                        </div>
                    </div>
                </li>
                @empty
                <li>
                    <div class="box-transaction-item">
                        <div class="content">
                            <div class="top d-flex justify-content-between align-items-center">
                                <p class="name fw-6">@lang('No deposits found')</p>
                            </div>
                        </div>
                    </div>
                </li>
                @endforelse
            </ul>

            {{-- Pagination --}}
            <div class="mt-3">
                {{ paginateLinks($deposits) }}
            </div>
        </div>
    </div>
</div>
@endsection