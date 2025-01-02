<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Filmes</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

<style>
   .heart-icon {
    font-size: 1.5rem; /* Ajuste o tamanho do ícone */
    opacity: 0.5;
    color: gray;
    transition: opacity 0.3s ease, color 0.3s ease;
}

.heart-icon.favorited {
    opacity: 1;
    color: red;
}


</style>
</head>
<body>
    <div class="container mt-5">
        <!-- Header com botão de login/registro -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1>Lista de Filmes</h1>
            <div>
                <button id="favorites-btn" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#favoritesModal">Ver Favoritos</button>

                <span id="user-info" class="me-3"></span>
                <button id="login-btn" class="btn btn-outline-primary btn-sm">Login</button>
                <button id="logout-btn" class="btn btn-outline-danger btn-sm d-none">Logout</button>
            </div>
        </div>

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
                <?php $__currentLoopData = $movies; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $movie): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td><?php echo e($movie['properties']['title']); ?></td>
                        <td><?php echo e(date('d/m/Y', strtotime($movie['properties']['release_date']))); ?></td>
                        <td>
                            <a href="/movies/<?php echo e($movie['uid']); ?>" class="btn btn-primary btn-sm">Ver Detalhes</a>
                            <button 
                            class="btn favorite-btn" 
                            data-movie-id="<?php echo e($movie['uid']); ?>">
                            <i class="heart-icon bi bi-heart"></i>
                            </button>
                        </td>
                        
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
    </div>

    <!-- Modal para listar favoritos -->
<div class="modal fade" id="favoritesModal" tabindex="-1" aria-labelledby="favoritesModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="favoritesModalLabel">Listar Favoritos</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <ul id="favorites" class="list-group">
                    <!-- Lista de favoritos será inserida aqui -->
                </ul>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
            </div>
        </div>
    </div>
</div>


    <!-- Modal de Login -->
    <div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="loginModalLabel">Login</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="login-form">
                        <div class="mb-3">
                            <label for="email" class="form-label">E-mail</label>
                            <input type="email" class="form-control" id="email" placeholder="Digite seu e-mail">
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Senha</label>
                            <input type="password" class="form-control" id="password" placeholder="Digite sua senha">
                        </div>
                        <button type="button" id="login-button" class="btn btn-primary">Login</button>
                    </form>
                    
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        // Variável para armazenar o token
        $(document).ready(function () {


            function loadFavorites(authToken) {
                $.ajax({
                    url: '/favorites',
                    method: 'GET',
                    headers: { Authorization: `Bearer ${authToken}` },
                    success: function (datafavorite) {
                        console.log("Response recebido:", datafavorite); // Verificar a estrutura no console
                        response = JSON.parse(datafavorite)
                        let favorites = [];
                        if (Array.isArray(response)) {
                            // Extrair IDs de filmes se for um array
                            favorites = response.map(fav => fav.movie_id.toString());
                        } else if (response.favorites && Array.isArray(response.favorites)) {
                            // Caso os favoritos estejam em uma propriedade chamada "favorites"
                            favorites = response.favorites.map(fav => fav.movie_id.toString());
                        } else {
                            console.error("Estrutura inesperada do response:", response);
                            return;
                        }

                        // Atualizar ícones
                        $('.favorite-btn').each(function () {
                            const movieId = $(this).data('movie-id').toString(); // Garantir que seja string
                            const icon = $(this).find('.heart-icon');

                            if (favorites.includes(movieId)) {
                                icon.addClass('favorited');
                            } else {
                                icon.removeClass('favorited');
                            }
                        });
                    },
                    error: function () {
                        console.error('Erro ao carregar favoritos.');
                    }
                });
            }


            function getUserByToken(token){
                $.ajax({
                    url: '/auth/user',
                    method: 'POST',
                    headers: { Authorization: `Bearer ${token}` }, // Adiciona "Bearer" ao token
                    success: function (data) {
                        user = JSON.parse(data)
                       
                        $('#user-info').text(`Bem-vindo, ${user.name}!`);
                        $('#login-btn').addClass('d-none'); // Esconde o botão de login
                        $('#logout-btn').removeClass('d-none'); // Mostra o botão de logout
                    },
                    error: function (xhr, status, error) {
                        console.error('Erro:', error);
                        console.error('Resposta do servidor:', xhr.responseText);
                        alert('Erro ao buscar informações do usuário.');
                    }
                });
            }

            let authToken = localStorage.getItem('authToken');

    if (authToken) {
        getUserByToken(authToken);
    }

    

    // Mostrar modal de login ao clicar no botão
    $('#favorites-btn').click(function () {

        $('#favorites').empty();
        
    // Encontra todos os elementos com o ícone de coração marcado como favorito
        const favorites = [];
        $('.heart-icon.favorited').each(function () {
            // Para cada coração marcado, pegue o ID do filme e o nome associado
            const movieId = $(this).closest('.favorite-btn').data('movie-id');
            const movieTitle = $(this).closest('tr').find('td:first').text().trim(); // Encontra o título do filme na mesma linha
            favorites.push({ id: movieId, title: movieTitle });
        });

        // Limpa a lista antes de preencher
       

        // Verifica se há favoritos
        if (favorites.length === 0) {
            $('#favorites').append('<li class="list-group-item">Você não possui favoritos.</li>');
            return;
        }

        // Adiciona os favoritos na lista
        favorites.forEach(favorite => {
            $('#favorites').append(
                `<li class="list-group-item">Filme: ${favorite.title} (ID: ${favorite.id})</li>`
            );
        });

        setTimeout(() => {
            $('#favoritesModal').modal('show'); 
        }, 5000);
   

    // Abre o modal (caso ainda não esteja aberto)
    
    
});






    $('#login-btn').click(function () {
        $('#loginModal').modal('show');
    });

    // Processar login
    $(document).on('click', '#login-button', function (e) {
        e.preventDefault();

        const email = $('#email').val();
        const password = $('#password').val();

        // Verificar se os campos estão preenchidos
        if (!email || !password) {
            alert('Por favor, preencha todos os campos.');
            return;
        }

        $.ajax({
            url: '/auth/login',
            method: 'POST',
            contentType: 'application/json',
            data: JSON.stringify({ email, password }),
            success: function (response) {
                $('#loginModal').modal('hide');
                authToken = JSON.parse(response); // Armazenar o token
                localStorage.setItem('authToken', authToken.token);
                console.log(authToken.token)
                getUserByToken(authToken.token)
                loadFavorites(authToken.token)
                // Obter informações do usuário autenticado   
            },
            error: function (xhr, status, error) {
                console.error('Status:', status);
                console.error('Erro:', error);
                console.error('Resposta:', xhr.responseText); // Mostra a resposta do backend
                alert('Erro no login: ' + xhr.responseText);
            }
        });
    });

    // Processar logout
    $('#logout-btn').click(function () {
    $.ajax({
        url: '/auth/logout',
        method: 'POST',
        headers: { Authorization: `Bearer ${localStorage.getItem('authToken')}` },
        success: function () {
            // Remove o token do LocalStorage
            localStorage.removeItem('authToken');
            
            // Limpa a variável authToken
            authToken = null;

            // Remove a classe "favorited" de todos os ícones
            $('.heart-icon').removeClass('favorited');

            // Atualiza os botões de login/logout
            $('#user-info').text('');
            $('#login-btn').removeClass('d-none'); // Mostra o botão de login
            $('#logout-btn').addClass('d-none'); // Esconde o botão de logout

            alert('Logout realizado com sucesso!');
        },
        error: function () {
            alert('Erro ao realizar logout.');
        }
    });
});



    // Favoritar filme
    // Favoritar filme
    



    // Carregar favoritos ao iniciar
    if (authToken) {
        loadFavorites(authToken);
    }

    // Alternar estado de favoritos
    $('.favorite-btn').click(function () {
        const button = $(this);
        const movieId = button.data('movie-id');
        const icon = button.find('.heart-icon');

        // Determinar ação (favoritar/desfavoritar) baseado no estado atual
        const isFavorited = icon.hasClass('favorited');
        const url = isFavorited ? `/favorites/${movieId}` : '/favorites';
        const method = isFavorited ? 'DELETE' : 'POST';

        $.ajax({
            url: url,
            method: method,
            headers: { Authorization: `Bearer ${authToken}` },
            contentType: 'application/json',
            data: isFavorited ? null : JSON.stringify({ movie_id: movieId }),
            success: function () {
                // Alternar classe visual
                icon.toggleClass('favorited');
                alert(isFavorited ? 'Favorito removido!' : 'Filme favoritado!');
            },
            error: function () {
                alert('Erro ao processar favorito.');
            }
        });
    });

});

    </script>
</body>
</html>
<?php /**PATH C:\laragon\www\testephp\src\Views/starswar/index.blade.php ENDPATH**/ ?>