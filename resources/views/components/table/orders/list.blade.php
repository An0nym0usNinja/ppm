{{-- generate orders --}}
@can('create', App\Models\Order::class)
    <a
        class="btn-sky mb-2 max-w-fit"
        href="{{ route('orders.generate') }}"
    >
        {{ __('Generate orders') }}
    </a>
@endcan

{{-- list of orders --}}
<ul class="grid grid-cols-1 gap-6 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4">
    @foreach ($data as $order)
        {{-- order card --}}
        <div
            class="order-card-{{ $order->status }} order-card-hover"
            id="order-card-{{ $order->id }}"
        >
            <div class="order-card-header">
                <span>PO {{ $order->po_number ?? 'N/A' }}</span>
                <x-order.status :status="$order->status ?? 'N/A'" />
            </div>
            <div class="order-card-body">
                <div class="order-card-body-item">
                    <x-icon.company class="w-5 min-w-[1.25rem]" />
                    <span>{{ $order->supplier?->name ?? 'N/A' }}</span>
                </div>
                <div class="order-card-body-item">
                    <x-icon.email class="w-5 min-w-[1.25rem]" />
                    <span>{{ $order->supplier?->representatives()->first()->email ?? 'N/A' }}</span>
                </div>
                <div class="order-card-body-item">
                    <x-icon.submission class="w-5 min-w-[1.25rem]" />
                    <span>{{ $order->submission->assembly_name ?? '## submission deleted' }}</span>
                </div>
                <div class="order-card-body-item">
                    <x-icon.spanner class="w-5 min-w-[1.25rem]" />
                    <span>Total parts: {{ $order->total_parts ?? 'N/A' }}</span>
                </div>
                <div class="order-card-body-item">
                    <x-icon.datetime class="w-5 min-w-[1.25rem]" />
                    <span>{{ $order->created_at ?? 'N/A' }}</span>
                </div>
            </div>
            <div class="order-card-footer">
                <div class="text-nowrap">
                    {{ __('Purchase order summary') }} <span aria-hidden="true">&rarr;</span>
                </div>
                @if ($order->status == 'ordered')
                    <x-icon.checkmark class="w-5 text-green-500" />
                @endif
            </div>
        </div>

        {{-- order modal --}}
        <div
            class="purchase-order-modal smaller-than-572:px-4 hidden"
            id="order-modal-{{ $order->id }}"
        >
            <div
                class="order-card-{{ $order->status }} smaller-than-572:min-w-full max-h-[700px] min-w-[34rem] overflow-y-scroll">
                <div class="order-card-header">
                    <span>PO {{ $order->po_number ?? 'N/A' }}</span>
                    <div class="flex gap-3">
                        <x-order.status :status="$order->status ?? 'N/A'" />
                        @if (request()->has('archived') && request()->archived == 'true')
                            @can('restore', App\Models\Order::class)
                                <x-icon.refresh
                                    class="delete-po restore-button aspect-square w-5 text-sky-500 hover:text-sky-700"
                                    route="{{ route('orders.restore', $order->id) }}"
                                    item-id="{{ $order->id }}"
                                />
                            @endcan
                            @can('forceDelete', App\Models\Order::class)
                                <x-icon.trash
                                    class="delete-po trash-button aspect-square w-5 text-red-400 hover:text-red-600"
                                    route="{{ route('orders.trash', $order->id) }}"
                                    item-id="{{ $order->id }}"
                                />
                            @endcan
                        @else
                            @can('delete', App\Models\Order::class)
                                <x-icon.trash
                                    class="delete-po aspect-square w-5 text-red-400 hover:text-red-600"
                                    route="{{ route('orders.delete', $order->id) }}"
                                    item-id="{{ $order->id }}"
                                />
                            @endcan
                        @endif
                    </div>
                </div>
                <div class="order-card-body">
                    @foreach ($order->parts()->get() as $part)
                        <div class="order-card-body-item w-full justify-between">
                            <span>{{ $part->name ?? 'N/A' }}</span>
                            <span>{{ $part->quantity_ordered ?? 'N/A' }}</span>
                        </div>
                    @endforeach
                </div>
                @if ($order->status == 'ordered')
                    <div class="order-card-footer">
                        <div class="flex gap-3">
                            <span class="text-green-500">{{ __('Parts ordered') }}</span>
                            <x-icon.checkmark class="w-5 text-green-500" />
                        </div>
                    </div>
                @else
                    <div class="order-card-footer flex items-center justify-between">
                        @if (request()->has('archived') && request()->archived == 'true')
                            <span class="w-full py-2 text-center text-sm text-gray-500">
                                {{ __('Purchase order is archived') }}
                            </span>
                        @else
                            @can('update', App\Models\Order::class)
                                <a
                                    class="hover:text-sky-600"
                                    href="{{ route('email.purchase-order.render', $order->id) }}"
                                >
                                    <span>{{ __('Prepare email') }}</span>
                                    <span aria-hidden="true">&rarr;</span>
                                </a>
                                <form
                                    action="{{ route('parts.mark-as', [
                                        'po_number' => $order->po_number,
                                        'mark_as' => 'qc_passed',
                                    ]) }}"
                                    method="post"
                                >
                                    @csrf
                                    <button
                                        class="hover:text-sky-600 flex"
                                        type="submit"
                                    >
                                        <span class="text-nowrap">{{ __('Mark as QC passed') }}</span>
                                        <span aria-hidden="true">&rarr;</span>
                                    </button>
                                </form>
                                <a
                                    class="text-right hover:text-sky-600"
                                    href="{{ route('orders.complete', $order->id) }}"
                                >
                                    <span>{{ __('Mark as ordered') }}</span>
                                    <span aria-hidden="true">&rarr;</span>
                                </a>
                            @endcan
                        @endif
                    </div>
                @endif
            </div>
        </div>
    @endforeach
</ul>

{{-- delete modal --}}
@include('components.generic-delete-modal')
