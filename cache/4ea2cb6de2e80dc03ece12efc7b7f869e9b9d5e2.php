

<?php $__env->startSection('title', 'Bem-vindo ao Meu Sistema'); ?>

<?php $__env->startSection('content'); ?>
<div class="text-center mt-5">
    <h1>Bem-vindo ao Meu Sistema</h1>
    <p class="lead">
        Este sistema foi inteiramente desenvolvido por mim. Cada linha de código foi cuidadosamente pensada e implementada para garantir qualidade e aprendizado. As únicas dependências utilizadas são bibliotecas de terceiros para suporte a funcionalidades específicas.
    </p>

    <h3 class="mt-4">Funcionalidades Disponíveis:</h3>
    <ul class="list-group list-group-flush">
        <li class="list-group-item">🎥 <strong>Gerenciamento de Filmes:</strong> Explore a lista de filmes, visualize detalhes e favorite seus preferidos.</li>
        <li class="list-group-item">🐾 <strong>Pokémons:</strong> Acesse informações sobre diferentes Pokémons em uma interface simples e intuitiva.</li>
    </ul>

    <div class="mt-4">
        <a href="/movies" class="btn btn-primary btn-lg me-3">Ir para Lista de Filmes</a>
        <a href="/pokemons" class="btn btn-success btn-lg">Ir para Lista de Pokémons</a>
    </div>

    <div class="mt-5">
        <h4>Sobre o Sistema:</h4>
        <p>
            Este não é um framework, mas sim um sistema criado do zero, com arquitetura limpa e organizada. 
            As principais dependências incluem:
        </p>
        <ul class="list-group list-group-flush">
            <li class="list-group-item">⚙️ <strong>PHP</strong> para a lógica do backend.</li>
            <li class="list-group-item">📄 <strong>MySQL</strong> para o gerenciamento de dados.</li>
            <li class="list-group-item">🚀 <strong>Bootstrap</strong> para estilização e responsividade.</li>
            <li class="list-group-item">📊 <strong>jQuery</strong> para requisições e manipulação do DOM.</li>
            <li class="list-group-item">📊 <strong>Redis</strong> (opcional para cache).</li>

        </ul>
        <p class="mt-3">
            O sistema também utiliza Blade para organização das views e FastRoute para gerenciar as rotas.
        </p>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\teste_gitclone\teste_apistar\src\Views/wecome.blade.php ENDPATH**/ ?>