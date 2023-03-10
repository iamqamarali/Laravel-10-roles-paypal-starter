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
                            @foreach ($groups as $group) 
                                <tr class="{{ auth()->user()->cannot('show-group', $group) ? 'bg-light' : '' }}">
                                    <td>
                                        @can('show-group', $group)
                                            <a href="{{route('groups.products.index', $group->id)}}">{{ $group->name }}</a>
                                        @else
                                            <div>{{ $group->name }}</div>
                                        @endcan
                                    </td>
                                    <td>{{ $group->description }}</td>
                                    
                                    <td>
                                        @cannot('show-group', $group)
                                            <div class="dropdown">
                                                <a href="#" class="text-dark text-decoration-none dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false"></a>
                                                <ul class="dropdown-menu dropdown-menu-end " >
                                                    <li>
                                                        <a href="{{ route('checkouts.online-arbitrage-lead') }}" class="dropdown-item">Subscribe to see products from this group</a>
                                                    </li>
                                                </ul>
                                            </div>                                                             
                                        @endcannot
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