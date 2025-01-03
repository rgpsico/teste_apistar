

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


<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\testephp\src\Views/starswar/index.blade.php ENDPATH**/ ?>