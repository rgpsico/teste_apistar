<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo e(ucfirst($pokemon['name'])); ?> - Detalhes</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center">Detalhes de <?php echo e(ucfirst($pokemon['name'])); ?></h1>
        
        <!-- Detalhes do Pokémon -->
        <div class="card mt-4">
            <div class="card-body text-center">
                <img src="<?php echo e($pokemon['sprites']['front_default']); ?>" alt="<?php echo e(ucfirst($pokemon['name'])); ?>" class="img-fluid mb-3" style="max-width: 200px;">
                <h4><?php echo e(ucfirst($pokemon['name'])); ?></h4>
                <p><strong>Altura:</strong> <?php echo e($pokemon['height']); ?> dm</p>
                <p><strong>Peso:</strong> <?php echo e($pokemon['weight']); ?> hg</p>

                <h5 class="mt-4">Habilidades</h5>
                <ul class="list-group">
                    <?php $__currentLoopData = $pokemon['abilities']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ability): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li class="list-group-item"><?php echo e(ucfirst($ability['ability']['name'])); ?></li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>

                <h5 class="mt-4">Tipos</h5>
                <ul class="list-group">
                    <?php $__currentLoopData = $pokemon['types']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li class="list-group-item"><?php echo e(ucfirst($type['type']['name'])); ?></li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<?php /**PATH C:\laragon\www\testephp\src\Views/pokemons/show.blade.php ENDPATH**/ ?>