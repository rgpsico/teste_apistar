<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalhes do Filme</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center">{{ $movie['title'] }}</h1>

        <div class="card mt-4">
            <div class="card-body">
                <h5 class="card-title">Detalhes do Filme</h5>
                <p><strong>Nº do Episódio:</strong> {{ $movie['episode_id'] }}</p>
                <p><strong>Sinopse:</strong> {{ $movie['opening_crawl'] }}</p>
                <p><strong>Data de Lançamento:</strong> {{ date('d/m/Y', strtotime($movie['release_date'])) }}</p>
                <p><strong>Diretor:</strong> {{ $movie['director'] }}</p>
                <p><strong>Produtores:</strong> {{ $movie['producer'] }}</p>

                <h5 class="mt-4">Personagens</h5>
                <ul>
                    @foreach($movie['characters'] as $character)
                        <li>{{ $character }}</li>
                    @endforeach
                </ul>

                <h5 class="mt-4">Idade do Filme</h5>
                <p>{{ $movie['age']['years'] }} anos, {{ $movie['age']['months'] }} meses e {{ $movie['age']['days'] }} dias</p>
            </div>
        </div>

        <a href="/movies" class="btn btn-secondary mt-3">Voltar para a Lista</a>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
