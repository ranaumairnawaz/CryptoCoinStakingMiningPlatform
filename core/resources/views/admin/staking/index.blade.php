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
                                    <th>@lang('Amount')</th>
                                    <th>@lang('Daily Reward')</th>
                                    <th>@lang('Last Reward At')</th>
                                    <th>@lang('Status')</th>
                                    <th>@lang('Staked At')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($stakings as $staking)
                                    <tr>
                                        <td>
                                            <span class="fw-bold">{{ $staking->user->fullname }}</span>
                                            <br>
                                            <span class="small">
                                                <a href="{{ route('admin.users.detail', $staking->user_id) }}"><span>@</span>{{ $staking->user->username }}</a>
                                            </span>
                                        </td>
                                        <td>
                                            {{ showAmount($staking->amount) }} {{ gs('cur_text') }}
                                        </td>
                                        <td>
                                            {{ showAmount($staking->daily_reward) }} {{ gs('cur_text') }}
                                        </td>
                                        <td>
                                            @if($staking->last_reward_at)
                                                {{ showDateTime($staking->last_reward_at) }} <br> {{ diffForHumans($staking->last_reward_at) }}
                                            @else
                                                <span class="badge badge--warning">@lang('No reward yet')</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($staking->status == 1)
                                                <span class="badge badge--success">@lang('Active')</span>
                                            @else
                                                <span class="badge badge--dark">@lang('Completed')</span>
                                            @endif
                                        </td>
                                        <td>
                                            {{ showDateTime($staking->created_at) }} <br> {{ diffForHumans($staking->created_at) }}
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
                @if ($stakings->hasPages())
                    <div class="card-footer py-4">
                        {{ paginateLinks($stakings) }}
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection

@push('breadcrumb-plugins')
    <x-search-form placeholder="Username" />
@endpush
