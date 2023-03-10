@extends('layouts.app-customer')

@section('title', 'Products | ' . config('app.name', 'Laravel') )
    

@section('body-class', 'products-page')
    
@section('content')
    <div class="dashboard bg-light">
        <div class="container-fluid py-4">
            
            <div class="card">
                <div class="card-body m-3">
                    <div class="d-flex justify-content-between mb-3">
                        <h3>{{ $group->name }} - Products</h3>
                    </div>

                    <table class="table mb-5">
                        <thead>
                            <th>Name</th>
                            <th>Store Link</th>
                            <th>Monthly Sales</th>
                            <th>BSR</th>
                            <th>Selling Price</th>
                            <th>Sup.price + Tax</th>
                            <th>Prep</th>
                            <th>Amz Ship</th>
                            <th>Fba Fee</th>
                            <th>Profit</th>
                            <th>ROI</th>
                            <th>Discount Code</th>
                            <th>
                                @php
                                    $url = route('groups.products.index', [$group->id,  
                                        'created_at' => request()->query('created_at') == 'desc' ? 'asc' : 'desc',
                                        'page' => 1 
                                    ]);
                                @endphp
                                <a href="{{ $url }}" class="text-dark">
                                    Date
                                    <i class="fa-solid fa-arrow-{{ request()->query('created_at') == 'desc' ? 'up' : 'down' }}"></i>    
                                </a>
                            </th>
                        </thead>
                        <tbody>
                            @foreach ($products as $product) 
                                <tr>
                                    <td>
                                        <a href="{{ $product->data->amz_link }}" target="_blank">
                                            {{ str($product->title)->substr(0, 30) . '...' }}    
                                        </a>
                                    </td>
                                    <td><a href="{{ $product->data->store_link }}" target="_blank">View</a></td>
                                    <td>{{ $product->data->monthly_sales }}</td>
                                    <td>{{ $product->data->bsr }}</td>
                                    <td>{{ $product->data->selling_price }}</td>
                                    <td>{{ $product->data->sup_price_tax }}</td>
                                    <td>{{ $product->data->prep }}</td>
                                    <td>{{ $product->data->amz_ship }}</td>
                                    <td>{{ $product->data->fba_fee }}</td>
                                    <td>{{ $product->data->profit  }}</td>
                                    <td>{{ $product->data->roi  }}</td>
                                    <td>{{ str($product->data->discount_code)->substr(0,10) .'...'  }}</td>
                                    <td>{{ $product->created_at->format('d/m/Y') }}</td>
                                                                        
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    

                    {{ $products->withQueryString()->links() }}

                </div>
            </div>


            <div class=" py-6 my-5 "></div>
        </div>
    </div>    
@endsection


@push('scripts')
<script>
    $('.delete-product').click(function(){
        let self = this;
        $.confirm({
            title: 'Confirm!',
            content: 'Simple confirm!',
            buttons: {
                confirm: {
                    text: 'Confirm',
                    btnClass: 'btn-danger',
                    action : function () {
                        $(self).parents("form").submit();
                    }
                },
                cancel: function () {

                },
            }
        });
    })    
</script>
@endpush