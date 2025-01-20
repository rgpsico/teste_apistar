@extends('layouts.app')

@section('title', 'Erro')

@section('content')
<div class="container mt-5 text-center">
    <h1>Ocorreu um erro</h1>
    <p>{{ $message }}</p>
    <a href="/" class="btn btn-primary">Voltar para a página inicial</a>
</div>
@endsection
