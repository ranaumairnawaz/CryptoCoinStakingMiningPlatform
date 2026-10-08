@extends('admin.layouts.app')
@section('panel')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body p-0">
                    <div class="table-responsive--md table-responsive">
                        <table class="table table--light style--two">
                            <thead>
                                <tr>
                                    <th>@lang('User')</th>
                                    <th>@lang('Conversion')</th>
                                    <th>@lang('Amount')</th>
                                    <th>@lang('Rate')</th>
                                    <th>@lang('Date')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($conversions as $conversion)
                                    <tr>
                                        <td>
                                            <span class="fw-bold">{{ $conversion->user->fullname }}</span>
                                            <br>
                                            <span class="small">
                                                <a href="{{ route('admin.users.detail', $conversion->user_id) }}"><span>@</span>{{ $conversion->user->username }}</a>
                                            </span>
                                        </td>
                                        <td>
                                            <span class="fw-bold">{{ $conversion->from_currency }}</span> 
                                            <i class="las la-arrow-right"></i> 
                                            <span class="fw-bold">{{ $conversion->to_currency }}</span>
                                        </td>
                                        <td>
                                            {{ showAmount($conversion->from_amount) }} {{ $conversion->from_currency }}
                                            <br>
                                            <i class="las la-arrow-down"></i>
                                            <br>
                                            {{ showAmount($conversion->to_amount) }} {{ $conversion->to_currency }}
                                        </td>
                                        <td>
                                            1 {{ $conversion->from_currency }} = {{ showAmount($conversion->rate) }} {{ $conversion->to_currency }}
                                        </td>
                                        <td>
                                            {{ showDateTime($conversion->created_at) }} <br> {{ diffForHumans($conversion->created_at) }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td class="text-muted text-center" colspan="100%">{{ __($emptyMessage) }}</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                @if ($conversions->hasPages())
                    <div class="card-footer py-4">
                        {{ paginateLinks($conversions) }}
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection

@push('breadcrumb-plugins')
    <x-search-form placeholder="Username" />
@endpush
