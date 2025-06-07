@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Perfil de Usuario') }}</div>

                <div class="card-body">
                    <div class="row mb-3">
                        <label class="col-md-4 col-form-label text-md-end">{{ __('Nombre') }}</label>
                        <div class="col-md-6">
                            <p class="form-control-plaintext">{{ Auth::user()->name }}</p>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-md-4 col-form-label text-md-end">{{ __('Email') }}</label>
                        <div class="col-md-6">
                            <p class="form-control-plaintext">{{ Auth::user()->email }}</p>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-md-4 col-form-label text-md-end">{{ __('Fecha de Registro') }}</label>
                        <div class="col-md-6">
                            <p class="form-control-plaintext">{{ Auth::user()->created_at ? Auth::user()->created_at->format('d/m/Y H:i') : 'No disponible' }}</p>
                        </div>
                    </div>

                    <div class="row mb-0">
                        <div class="col-md-6 offset-md-4">
                            <a href="{{ route('dashboard') }}" class="btn btn-primary">
                                {{ __('Volver al Dashboard') }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection