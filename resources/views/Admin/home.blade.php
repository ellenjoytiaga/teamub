@extends('layouts.homenav')

@section('content')


<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header"> You are logged in as Admin!</div>
                
            <a class="btn btn-outline-primary" href="{{ route('Cindex') }}">Category Table</a>
                <a class="btn btn-outline-primary" href="{{ route('Iindex') }}">Item Table</a>
                
               
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    


                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
