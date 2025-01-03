<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Aplicação')</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    @stack('styles')
</head>
<body>
    <div class="container mt-5">
        <!-- Menu -->
        @include('partials.menu')

        <!-- Conteúdo Principal -->
        <div class="content">
            @yield('content')
        </div>
    </div>

    <!-- Modals -->
    @include('partials.favorites-modal')
    @include('partials.login-modal')

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
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



      
    $('#favorites-btn').click(function () {
        $('#favorites').empty();

      
        const favorites = [];
        $('.heart-icon.favorited').each(function () {
       
        const movieId = $(this).closest('.favorite-btn').data('movie-id');
        const movieTitle = $(this).closest('tr').find('td:first').text().trim(); 
        favorites.push({ id: movieId, title: movieTitle });
        });    


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
                
                setTimeout(() => {
                    location.reload();
                }, 500);
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



        if (authToken) {
        loadFavorites(authToken);
        }

// Alternar estado de favoritos
        $('.favorite-btn').click(function () {
                const button = $(this);
                const movieId = button.data('movie-id');
                const icon = button.find('.heart-icon');

               
                const isFavorited = icon.hasClass('favorited');
                const url = isFavorited ? `/favorites/${movieId}` : '/favorites';
                const method = isFavorited ? 'DELETE' : 'POST';

                if (!authToken) 
                {
                    alert('Usuario deve esta autenticado pra poder favoritar')
                }

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
                    // alert('Erro ao processar favorito.');
                    }
                    });
                });

            });

    </script>
    @stack('scripts')
</body>
</html>
