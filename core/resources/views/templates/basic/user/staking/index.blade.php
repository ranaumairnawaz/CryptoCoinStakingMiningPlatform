@extends($activeTemplate . 'layouts.dashboard')
@section('content')
    <div class="card-payment mb-24">
        <div class="image-item">
            <img loading="lazy" alt="img" src="{{ asset('assets/templates/payqra') }}/images/icons/img-item-1.png">
        </div>
        <div class="image-item item-2">
            <img loading="lazy" alt="img" src="{{ asset('assets/templates/payqra') }}/images/icons/img-item-2.png">
        </div>
        <div class="top-card d-flex align-items-center justify-content-between">
            <div class="left">
                <div class="text fw-5 text-medium">
                    Staked Balance
                </div>
                <div class="price fw-6">
                    {{ getAmount($user->staked_balance) }} TRUMP
                </div>
            </div>
            <div class="right">
                <img class="w-50" style="float: right;" src="{{ siteLogo() }}" >
            </div>
        </div>
    </div>

    <div class="wg-frequently-contacts mb-24">
        <div class="d-flex justify-content-between align-items-center mb-16 heading-wg">
            <h6 class="title fw-6">Stake Your Balance</h6>
        </div>
        <div class="card-payment v2 bg-color-white mb-24">
            <form action="{{ route('user.staking.stake') }}" method="POST">
                @csrf
                <div class="form-group mb-3">
                    <label class="form-label">Amount to Stake</label>
                    <div class="input-group">
                        <input type="number" step="any" name="amount" max="{{ $user->coin_balance }}" class="form-control" placeholder="Enter Amount" required>
                        <span class="input-group-text">TRUMP</span>
                    </div>
                    <small class="text-muted">Daily Reward: 4%</small>
                </div>
                <button type="submit" class="btn btn--base w-100" style="background-color: var(--primary); color: white;">Stake Now</button>
            </form>
        </div>
    </div>

    <div class="wg-transaction-history">
        <div class="tf-container">
            <div class="d-flex justify-content-between align-items-center mb-16 heading-wg">
                <h6 class="title fw-6">Staking History</h6>
            </div>
            <ul class="list">
                @forelse($stakings as $staking)
                <li>
                    <div class="box-transaction-item">
                        <div class="content" style="max-width: 100%;">
                            <div class="top d-flex justify-content-between align-items-center w-100">
                                <p class="name fw-6">
                                    Staked {{ getAmount($staking->amount) }} TRUMP
                                </p>
                                <p class="price fw-5 text-success">
                                    +{{ getAmount($staking->daily_reward) }} TRUMP / Day
                                </p>
                            </div>
                            <div class="bottom d-flex justify-content-between align-items-center">
                                <p class="text-medium">{{ diffForHumans($staking->created_at) }}</p>
                                <p class="text-medium">
                                    @if($staking->status == 1)
                                        <span class="badge badge--success" style="background-color: #28a745;">Active</span>
                                    @else
                                        <span class="badge badge--danger" style="background-color: #dc3545;">Completed</span>
                                    @endif
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
                                <p class="name fw-6">No staking records found</p>
                            </div>
                        </div>
                    </div>
                </li>
                @endforelse
            </ul>
            @if($stakings->hasPages())
                <div class="mt-3">
                    {{ paginateLinks($stakings) }}
                </div>
            @endif
        </div>
    </div>
@endsection
