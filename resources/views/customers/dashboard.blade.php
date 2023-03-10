@extends('layouts.app-customer')

@section('title', 'Dashboard | ' . config('app.name', 'Laravel') )
    

@section('content')
    <div class="dashboard bg-light">
        <div class="container py-4">
            
            <div class="card"> 
                <div class="card-body m-3">
                    <div class="d-flex justify-content-between mb-3">
                        <h3>Groups</h3>
                    </div>


                    <table class="table mb-5">
                        <thead>
                            <th>Name</th>
                            <th>Description</th>
                            <th></th>
                        </thead>
                        <tbody>
                            @foreach ($customer->groups as $group) 
                            <tr>
                                <td>
                                    <a href="{{route('groups.products.index', $group->id)}}">{{ $group->name }}</a>
                                </td>
                                <td>{{ $group->description }}</td>                                
                                <td></td>
                            </tr>
                        @endforeach

                            @foreach ($groups as $group) 
                                <tr class="bg-light">
                                    <td>
                                        <div>{{ $group->name }}</div>
                                    </td>
                                    <td>{{ $group->description }}</td>
                                    
                                    <td>
                                        <div class="dropdown">
                                            <a href="#" class="text-dark text-decoration-none dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false"></a>
                                            <ul class="dropdown-menu dropdown-menu-end " >
                                                <li>
                                                    <a href="{{ route('checkouts.online-arbitrage-lead') }}" class="dropdown-item">Subscribe to see products from this group</a>
                                                </li>
                                            </ul>
                                        </div>                                                             
                                    </td>

                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    {{ $groups->links() }}


                </div>
            </div>


            <div class=" py-6 my-5 "></div>
        </div>
    </div>    
@endsection


@push('scripts')
<script>
    
    
</script>
@endpush