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
                                    <th>@lang('Name')</th>
                                    <th>@lang('Symbol')</th>
                                    <th>@lang('Rate (1 Coin = ? USDT)')</th>
                                    <th>@lang('Action')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($coins as $coin)
                                    <tr>
                                        <td>{{ $coin->name }}</td>
                                        <td>{{ $coin->symbol }}</td>
                                        <td>{{ showAmount($coin->rate) }} USDT</td>
                                        <td>
                                            <button class="btn btn-sm btn-outline--primary editBtn" 
                                                data-id="{{ $coin->id }}"
                                                data-name="{{ $coin->name }}"
                                                data-symbol="{{ $coin->symbol }}"
                                                data-rate="{{ getAmount($coin->rate) }}">
                                                <i class="la la-pencil"></i> @lang('Edit')
                                            </button>
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
                @if ($coins->hasPages())
                    <div class="card-footer py-4">
                        {{ paginateLinks($coins) }}
                    </div>
                @endif
            </div>
        </div>
    </div>

    {{-- Edit Modal --}}
    <div id="editModal" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">@lang('Edit Coin')</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <i class="las la-times"></i>
                    </button>
                </div>
                <form action="" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label>@lang('Name')</label>
                            <input type="text" name="name" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>@lang('Symbol')</label>
                            <input type="text" name="symbol" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>@lang('Rate (1 Coin = ? USDT)')</label>
                            <div class="input-group">
                                <input type="number" step="any" name="rate" class="form-control" required>
                                <span class="input-group-text">USDT</span>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn--primary w-100">@lang('Submit')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Add Modal --}}
    <div id="addModal" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">@lang('Add New Coin')</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <i class="las la-times"></i>
                    </button>
                </div>
                <form action="{{ route('admin.coin.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label>@lang('Name')</label>
                            <input type="text" name="name" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>@lang('Symbol')</label>
                            <input type="text" name="symbol" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>@lang('Rate (1 Coin = ? USDT)')</label>
                            <div class="input-group">
                                <input type="number" step="any" name="rate" class="form-control" required>
                                <span class="input-group-text">USDT</span>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn--primary w-100">@lang('Submit')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('breadcrumb-plugins')
    <button class="btn btn-sm btn-outline--primary addBtn">
        <i class="las la-plus"></i> @lang('Add New')
    </button>
@endpush

@push('script')
    <script>
        (function($){
            "use strict";
            $('.addBtn').on('click', function() {
                var modal = $('#addModal');
                modal.modal('show');
            });

            $('.editBtn').on('click', function() {
                var modal = $('#editModal');
                var resource = $(this).data();
                modal.find('form').attr('action', `{{ route('admin.coin.update', '') }}/${resource.id}`);
                modal.find('[name=name]').val(resource.name);
                modal.find('[name=symbol]').val(resource.symbol);
                modal.find('[name=rate]').val(resource.rate);
                modal.modal('show');
            });
        })(jQuery);
    </script>
@endpush
