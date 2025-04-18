@extends('layout.app')

@section('content')
    <div class="container py-5">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h1 class="text-center mb-0">Cart</h1>
                    </div>
                    <div class="card-body">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">Product</th>
                                    <th scope="col">Price</th>
                                    <th scope="col">Quantity</th>
                                    <th scope="col">Total</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $total = 0;
                                @endphp
                                @foreach ($cartItems as $key => $item)
                                    @php
                                        $total += $item['price'] * $item['quantity'];
                                    @endphp
                                    <tr>
                                        <td>{{ $item['name'] }}</td>
                                        <td>${{ $item['price'] }}</td>
                                        <td>
                                            <input type="hidden" name="product_id" value="{{ $key }}">
                                            <div class="d-flex">
                                                <button type="submit" class="btn btn-sm btn-primary btn-decrement"
                                                    data-id="{{ $key }}">-</button>
                                                <input type="number" name="quantity" data-id="{{ $key }}"
                                                    value="{{ $item['quantity'] }}" class="form-control w-25 mx-2 quantity">
                                                <button type="submit" class="btn btn-sm btn-primary btn-increment"
                                                    data-id="{{ $key }}">+</button>
                                            </div>

                                        </td>
                                        <td>${{ $item['price'] * $item['quantity'] }}</td>
                                        <td>
                                            <form action="{{ route('cart.destroy', $key) }}" method="post">
                                                @csrf
                                                @method('DELETE')
                                                <input type="hidden" name="product_id" value="{{ $key }}">
                                                <button type="submit" class="btn btn-danger">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="d-flex justify-content-end">
                            <h3>Total: ${{ $total }}</h3>
                        </div>
                        <div class="d-flex justify-content-end">
                            <a href="" class="btn btn-primary">Checkout</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('custom_js')
    <script>
        $(document).ready(function() {
            $('.btn-decrement').click(function() {
                var productId = $(this).attr('data-id');
                let quantity = $('.quantity[data-id="' + productId + '"]').val();
                if (quantity > 1) {
                    quantity--;
                }
                $('.quantity[data-id="' + productId + '"]').val(quantity);
                $.ajax({
                    url: "{{ route('cart.update') }}",
                    method: "POST",
                    data: {
                        product_id: productId,
                        quantity_decrement: quantity,
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        location.reload();
                    }
                })
            });

            $('.btn-increment').click(function() {
                var productId = $(this).attr('data-id');
                let quantity = $('.quantity[data-id="' + productId + '"]').val();
                quantity++;
                $('.quantity[data-id="' + productId + '"]').val(quantity);
                $.ajax({
                    url: "{{ route('cart.update') }}",
                    method: "POST",
                    data: {
                        product_id: productId,
                        quantity_increment: quantity,
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        location.reload();
                    }
                })
            });
        });
    </script>
@endpush
