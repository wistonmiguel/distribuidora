@extends('layouts.admin')

@section('content')
<div class="container my-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Bienvenido {{ Auth::user()->name }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <div class="my-4" style="text-align: center;">
                    <img class="img-fluid" src="{{ asset('./img/logo.png') }}" />
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
