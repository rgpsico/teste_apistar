

<?php $__env->startSection('title', 'Erro'); ?>

<?php $__env->startSection('content'); ?>
<div class="container mt-5 text-center">
    <h1>Ocorreu um erro</h1>
    <p><?php echo e($message); ?></p>
    <a href="/" class="btn btn-primary">Voltar para a página inicial</a>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\teste_gitclone\teste_apistar\src\Views/errors/exception.blade.php ENDPATH**/ ?>