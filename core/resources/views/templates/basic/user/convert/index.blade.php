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
                    Available Balance
                </div>
                <div class="price fw-6">
                    {{ showAmount($user->balance) }}
                </div>
                <div class="text fw-5 text-medium mt-2">
                    {{ $coin->symbol }} Balance
                </div>
                <div class="price fw-6" style="font-size: 1.2rem;">
                    {{ getAmount($user->coin_balance) }} {{ $coin->symbol }}
                </div>
            </div>
            <div class="right">
                <img class="w-50" style="float: right;" src="{{ siteLogo() }}" >
            </div>
        </div>
    </div>

    <div class="wg-frequently-contacts mb-24">
        <div class="d-flex justify-content-between align-items-center mb-16 heading-wg">
            <h6 class="title fw-6">Convert Currency</h6>
            <span class="badge badge--info" style="background-color: var(--primary);">1 {{ $coin->symbol }} = {{ showAmount($coin->rate) }}</span>
        </div>
        <div class="card-payment v2 bg-color-white mb-24">
            <form action="{{ route('user.convert.submit') }}" method="POST" id="convertForm">
                @csrf
                <div class="form-group mb-3">
                    <label class="form-label">Conversion Type</label>
                    <select name="type" class="form-control" id="convertType" required>
                        <option value="usdt_to_coin">USDT to {{ $coin->symbol }}</option>
                        <option value="coin_to_usdt">{{ $coin->symbol }} to USDT</option>
                    </select>
                </div>
                <div class="form-group mb-3">
                    <label class="form-label" id="amountLabel">Amount in USDT</label>
                    <div class="input-group">
                        <input type="number" step="any" name="amount" id="amountInput" class="form-control" placeholder="Enter Amount" required>
                        <span class="input-group-text" id="amountAddon">{{ gs('cur_text') }}</span>
                    </div>
                </div>
                <div class="form-group mb-3">
                    <label class="form-label">You will get (Estimated)</label>
                    <div class="input-group">
                        <input type="text" id="estimatedOutput" class="form-control" readonly>
                        <span class="input-group-text" id="outputAddon">{{ $coin->symbol }}</span>
                    </div>
                </div>
                <button type="submit" class="btn btn--base w-100" style="background-color: var(--primary); color: white;">Convert Now</button>
            </form>
        </div>
    </div>

    <div class="wg-transaction-history">
        <div class="tf-container">
            <div class="d-flex justify-content-between align-items-center mb-16 heading-wg">
                <h6 class="title fw-6">Conversion History</h6>
            </div>
            <ul class="list">
                @forelse($conversions as $conv)
                <li>
                    <div class="box-transaction-item">
                        <div class="content" style="max-width: 100%;">
                            <div class="top d-flex justify-content-between align-items-center w-100">
                                <p class="name fw-6">
                                    {{ getAmount($conv->from_amount) }} {{ $conv->from_currency }} &rarr; {{ getAmount($conv->to_amount) }} {{ $conv->to_currency }}
                                </p>
                                <p class="price fw-5 text-muted" style="font-size: 0.8rem;">
                                    Rate: 1 {{ $coin->symbol }} = {{ showAmount($conv->rate) }}
                                </p>
                            </div>
                            <div class="bottom d-flex justify-content-between align-items-center">
                                <p class="text-medium">{{ diffForHumans($conv->created_at) }}</p>
                            </div>
                        </div>
                    </div>
                </li>
                @empty
                <li>
                    <div class="box-transaction-item">
                        <div class="content">
                            <div class="top d-flex justify-content-between align-items-center">
                                <p class="name fw-6">No conversion records found</p>
                            </div>
                        </div>
                    </div>
                </li>
                @endforelse
            </ul>
            @if($conversions->hasPages())
                <div class="mt-3">
                    {{ paginateLinks($conversions) }}
                </div>
            @endif
        </div>
    </div>
@endsection

@push('script')
<script>
    (function($){
        "use strict";
        const rate = {{ $coin->rate }};
        const coinSymbol = "{{ $coin->symbol }}";
        const usdtSymbol = "{{ gs('cur_text') }}";

        const $typeSelect = $('select[name="type"]');
        const $amountInput = $('input[name="amount"]');
        const $estimatedOutput = $('#estimatedOutput');
        const $amountLabel = $('#amountLabel');
        const $amountAddon = $('#amountAddon');
        const $outputAddon = $('#outputAddon');

        $typeSelect.on('change', function(){
            const type = $(this).val();
            if(type == 'usdt_to_coin'){
                $amountLabel.text('Amount in USDT');
                $amountAddon.text(usdtSymbol);
                $outputAddon.text(coinSymbol);
            } else {
                $amountLabel.text('Amount in ' + coinSymbol);
                $amountAddon.text(coinSymbol);
                $outputAddon.text(usdtSymbol);
            }
            calculate();
        });

        $amountInput.on('input', function(){
            calculate();
        });

        function calculate(){
            const amount = parseFloat($amountInput.val());
            const type = $typeSelect.val();
            if(!amount || amount <= 0){
                $estimatedOutput.val('');
                return;
            }

            let result = 0;
            if(type == 'usdt_to_coin'){
                result = amount / rate;
            } else {
                result = amount * rate;
            }
            $estimatedOutput.val(result.toFixed(8));
        }
    })(jQuery);
</script>
@endpush
