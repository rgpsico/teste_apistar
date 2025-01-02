<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Pokémon</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center">Lista de Pokémon</h1>
        <table class="table table-striped mt-3">
            <thead>
                <tr>
                    <th>Imagem</th>
                    <th>Nome</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                @foreach($pokemons as $pokemon)
                    <tr>
                        <!-- Adicionar imagem do Pokémon -->
                        <td>
                            <img src="https://raw.githubusercontent.com/PokeAPI/sprites/master/sprites/pokemon/{{ explode('/', rtrim($pokemon['url'], '/'))[6] }}.png" 
                                 alt="{{ $pokemon['name'] }}" 
                                 class="img-fluid" 
                                 style="max-width: 50px;">
                        </td>
                        <td>{{ ucfirst($pokemon['name']) }}</td>
                        <td>
                            <a href="/pokemon/show/{{ $pokemon['name'] }}" class="btn btn-primary btn-sm">Ver</a>
                            <a href="/pokemon/delete?id={{ $pokemon['name'] }}" class="btn btn-danger btn-sm">Excluir</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
