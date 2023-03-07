@extends('layouts.app')

@section('title', 'Dashboard | ' . config('app.name', 'Laravel') )
    

@section('content')
    <div class="dashboard bg-light min-vh-100 d-flex align-items-center p-5">
            
            <div class="row justify-content-center ">
                <div class="col-lg-8 col-md-10">
                    <div class="card">
                        <div class="card-body p-5">
                            <h1 class="text-center mb-4">Thank you for your subscription</h1>
                            <p class="text-center">
                                We have generated a random password ({{str()->random(8)}}) 
                                for you which you can use to Login any time. But we suggest you to change your password from profile settings.
                            </p>
                            <div class="d-grid col-md-6 mx-auto">
                                @auth
                                    <a href="{{route('dashboard')}}" class="btn btn-dark  mt-4">Go to Dashboard</a>
                                @else
                                    <a href="{{ route('login') }}" class="btn btn-dark  mt-4">Signin</a>
                                @endauth
                            </div>
                        </div>
                    </div>
                </div>
            </div>

    </div>    
@endsection


@push('scripts')
<script>
    
    
</script>
@endpush