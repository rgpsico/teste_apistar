@extends('layouts.app')

@section('title', 'Detalhes')

@section('page-title',  $movie['title'] )

@section('content')
    <!-- Tabela de Filmes -->
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
@endsection
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
@section('scripts')
<script>
    $(document).ready(function () {
        

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



            });

    </script>
    @stack('scripts')
    
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
