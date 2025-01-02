<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ ucfirst($pokemon['name']) }} - Detalhes</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center">Detalhes de {{ ucfirst($pokemon['name']) }}</h1>
        
        <!-- Detalhes do Pokémon -->
        <div class="card mt-4">
            <div class="card-body text-center">
                <img src="{{ $pokemon['sprites']['front_default'] }}" alt="{{ ucfirst($pokemon['name']) }}" class="img-fluid mb-3" style="max-width: 200px;">
                <h4>{{ ucfirst($pokemon['name']) }}</h4>
                <p><strong>Altura:</strong> {{ $pokemon['height'] }} dm</p>
                <p><strong>Peso:</strong> {{ $pokemon['weight'] }} hg</p>

                <h5 class="mt-4">Habilidades</h5>
                <ul class="list-group">
                    @foreach($pokemon['abilities'] as $ability)
                        <li class="list-group-item">{{ ucfirst($ability['ability']['name']) }}</li>
                    @endforeach
                </ul>

                <h5 class="mt-4">Tipos</h5>
                <ul class="list-group">
                    @foreach($pokemon['types'] as $type)
                        <li class="list-group-item">{{ ucfirst($type['type']['name']) }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
