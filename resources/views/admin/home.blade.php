@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="card-header nav-link">
            <i class="fa-solid fa-house-chimney fa-fw fa-lg icone" aria-hidden="true"></i>{{ __('Dashboard') }}
        </div>

        <div class="card-body nav-link">
            @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
            @endif

            {{ __('You are logged in!') }}
        </div>
    </div>
@endsection 
