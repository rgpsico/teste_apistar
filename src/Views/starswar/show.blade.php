@extends('layouts.app')

@section('title', 'Detalhes do Filme')

@section('page-title', 'Detalhes do Filme')

@section('content')
    <h2>{{ $movie['properties']['title'] }}</h2>
    <p>Data de Lançamento: {{ date('d/m/Y', strtotime($movie['properties']['release_date'])) }}</p>
    <p>Descrição: {{ $movie['properties']['opening_crawl'] }}</p>
    <a href="/movies" class="btn btn-secondary">Voltar</a>
@endsection
