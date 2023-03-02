@extends('layouts.app')

@section('title', 'Groups | ' . config('app.name', 'Laravel') )
    

@section('content')
    <div class="dashboard bg-light">
        <div class="container py-4">
            
            <div class="card">
                <div class="card-body m-3">
                    <div class="d-flex justify-content-between mb-3">
                        <h3>Groups</h3>
                        <a href="@route('groups.create')" class="btn btn-dark ">Create Group</a>    
                    </div>

                    @include('partials.messages')

                    <table class="table mb-5">
                        <thead>
                            <th>Name</th>
                            <th>Description</th>
                            <th>Members</th>
                            {{-- <th>Products</th> --}}
                            <th></th>
                        </thead>
                        <tbody>
                            @foreach ($groups as $group)
                                <tr>
                                    <td>{{ $group->name }}</td>
                                    <td>{{ $group->description }}</td>
                                    <td>{{ $group->users_count }}</td>
                                    {{-- <td>{{ $group->amazon_products_count }}</td> --}}
                                    <td>
                                        <div class="dropdown">
                                            <a href="#" class="text-dark text-decoration-none dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false"></a>
                                            <ul class="dropdown-menu dropdown-menu-end " >
                                                <li>
                                                    <form action="{{ route('groups.destroy', $group->id) }}" method="POST" >
                                                        @csrf
                                                        @method('delete')
                                                        <button type="button" class="dropdown-item delete-group" >Destroy</button>
                                                    </form>
                                                </li>
                                            </ul>
                                        </div>

                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

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