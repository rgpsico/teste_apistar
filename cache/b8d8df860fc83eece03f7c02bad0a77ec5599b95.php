

<?php $__env->startSection('title', 'Lista de Filmes'); ?>

<?php $__env->startSection('page-title', 'Lista de Filmes'); ?>

<?php $__env->startSection('content'); ?>
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
<?php $__env->stopSection(); ?>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<?php $__env->startSection('scripts'); ?>
<script>
    $(document).ready(function () {
        function loadFavorites(authToken) {
            $.ajax({
                url: '/favorites',
                method: 'GET',
                headers: { Authorization: `Bearer ${authToken}` },
                success: function (datafavorite) {
               
                    response = JSON.parse(datafavorite)
                    let favorites = [];
                    if (Array.isArray(response)) {
                     
                        favorites = response.map(fav => fav.movie_id.toString());
                    } else if (response.favorites && Array.isArray(response.favorites)) {
                     
                        favorites = response.favorites.map(fav => fav.movie_id.toString());
                    } else {
                        console.error("Estrutura inesperada do response:", response);
                        return;
                    }

               
                    $('.favorite-btn').each(function () {
                        const movieId = $(this).data('movie-id').toString(); 
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
                headers: { Authorization: `Bearer ${token}` },
                success: function (data) {
                    user = JSON.parse(data)
                
                    $('#user-info').text(`Bem-vindo, ${user.name}!`);
                    $('#login-btn').addClass('d-none'); 
                    $('#logout-btn').removeClass('d-none'); 
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
            $('#loginRegisterModal').modal('show');
    });


    $(document).on('click', '#login-button', function (e) {
            e.preventDefault();

            const email = $('#login-email').val();
            const password = $('#login-password').val();

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


    $('#register-button').click(function () {
        const name = $('#register-name').val();
        const email = $('#register-email').val();
        const password = $('#register-password').val();

        if (!name || !email || !password) {
            alert('Por favor, preencha todos os campos de registro.');
            return;
        }

        $.ajax({
            url: '/auth/register',
            method: 'POST',
            contentType: 'application/json',
            data: JSON.stringify({ name, email, password }),
            success: function (response) {
                console.log(response)
                alert(response);
              
                
             
                $('#loginRegisterModal').modal('hide');
            },
            error: function () {
                alert('Erro ao realizar registro.');
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
    <?php echo $__env->yieldPushContent('scripts'); ?>
    
<?php $__env->startPush('styles'); ?>
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
<?php $__env->stopPush(); ?>


<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\teste_gitclone\teste_apistar\src\Views/starswar/index.blade.php ENDPATH**/ ?>