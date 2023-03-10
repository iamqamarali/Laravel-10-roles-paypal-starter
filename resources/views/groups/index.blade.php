@extends('layouts.app')

@section('title', 'Groups | ' . config('app.name', 'Laravel') )
    

@section('content')
    <div class="dashboard bg-light">
        <div class="container py-4">
            
            <div class="card">
                <div class="card-body m-3">
                    <div class="d-flex justify-content-between mb-3">
                        <h3>Groups</h3>
                        @can('create-group')
                            <a href="{{ route('admin.groups.create') }}" class="btn btn-dark ">Create Group</a>                                
                        @endcan
                    </div>

                    @include('partials.messages')

                    <table class="table mb-5">
                        <thead>
                            <th>Name</th>
                            <th>Description</th>
                            <th>Members</th>
                            {{-- <th>Products</th> --}}
                            @can('delete-group')
                                <th></th>
                            @endcan
                        </thead>
                        <tbody>
                            @foreach ($groups as $group) 
                                <tr>
                                    <td><a href="{{route('admin.groups.products.index', $group->id)}}">{{ $group->name }}</a></td>
                                    <td>{{ $group->description }}</td>
                                    <td>{{ $group->users_count }}</td>
                                    
                                    @can('delete-group')
                                        <td>
                                            <div class="dropdown">
                                                <a href="#" class="text-dark text-decoration-none dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false"></a>
                                                <ul class="dropdown-menu dropdown-menu-end " >
                                                    <li>
                                                        <a href="{{ route('admin.groups.edit', $group->id) }}" class="dropdown-item">Edit</a>
                                                    </li>
                                                    <li>
                                                        <form action="{{ route('admin.groups.destroy', $group->id) }}" method="POST" >
                                                            @csrf
                                                            @method('delete')
                                                            <button type="button" class="dropdown-item delete-group" >Destroy</button>
                                                        </form>
                                                    </li>
                                                </ul>
                                            </div>                 
                                        </td>
                                    @endcan

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
    $('.delete-group').click(function(){
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