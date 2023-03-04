@extends('layouts.app')

@section('title', 'Create Group | ' . config('app.name', 'Laravel') )
    
@section('content')
    <section class=" group-create-page bg-light">
        <div class="container py-5">
            <div class="row ">
                <div class="col-lg-6 col-md-8 mx-auto">
                    <div class="card">
                        <div class="card-body m-3">
                            <div class="d-flex justify-content-between mb-3">
                                <h3>Add Products for - {{ $group->name }}</h3>
                            </div>
                            @include('partials.errors')
                            @include('partials.messages')

                            <form action="{{ route('groups.products.store', $group->id) }}" method="post" enctype="multipart/form-data">
                                @csrf

                                <div class="mt-2 mb-4">
                                    <label for="formFile" class="form-label">Select file with (xlsx) extension <span class="text-danger">*</span></label>
                                    <input class="form-control" type="file" name="products_file">
                                  </div>
                                
                                <div class="d-grid">
                                    <button class="btn btn-dark ">Upload</button>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>
@endsection

