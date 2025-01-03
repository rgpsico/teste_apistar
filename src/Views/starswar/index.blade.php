@extends('layouts.app')

@section('title', 'Lista de Filmes')

@section('page-title', 'Lista de Filmes')

@section('content')
    <!-- Tabela de Filmes -->
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Título</th>
                <th>Data de Lançamento</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            @foreach($movies as $movie)
                <tr>
                    <td>{{ $movie['properties']['title'] }}</td>
                    <td>{{ date('d/m/Y', strtotime($movie['properties']['release_date'])) }}</td>
                    <td>
                        <a href="/movies/{{ $movie['uid'] }}" class="btn btn-primary btn-sm">Ver Detalhes</a>
                        <button 
                            class="btn favorite-btn" 
                            data-movie-id="{{ $movie['uid'] }}">
                            <i class="heart-icon bi bi-heart"></i>
                        </button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
@push('styles')
<style>
    .heart-icon {
        font-size: 1.5rem;
        opacity: 0.5;
        color: gray;
        transition: opacity 0.3s ease, color 0.3s ease;
    }
    .heart-icon.favorited {
        opacity: 1;
        color: red;
    }
</style>
@endpush

