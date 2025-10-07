<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Étudiants - Enseignant</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link href="https://fonts.googleapis.com/css2?family=Work+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { font-family: 'Work Sans', sans-serif; }
        .table-container { background: rgba(255,255,255,0.95); border-radius: 12px; box-shadow: 0 20px 60px rgba(0,0,0,0.06); }
    </style>
</head>
<body class="bg-gray-50">
    <?php echo $__env->renderWhen(view()->exists('teacher.components.sidebar'), 'teacher.components.sidebar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1])); ?>

    <div class="main-content min-h-screen md:ml-64">
        <?php echo $__env->renderWhen(view()->exists('teacher.components.header'), 'teacher.components.header', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1])); ?>

        <main class="p-6">
            <div class="bg-gradient-to-r from-blue-800 to-blue-700 text-white rounded-2xl p-6 mb-6">
                <h1 class="text-2xl font-bold">Étudiants</h1>
                <p class="text-blue-100 text-sm">Liste des étudiants que vous encadrez</p>
            </div>

            <div class="table-container overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full">
                        <thead class="bg-white">
                            <tr>
                                <th class="px-6 py-3 text-left text-sm font-semibold">Matricule</th>
                                <th class="px-6 py-3 text-left text-sm font-semibold">Nom</th>
                                <th class="px-6 py-3 text-left text-sm font-semibold">Prénom</th>
                                <th class="px-6 py-3 text-left text-sm font-semibold">Email</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-100">
                            <?php $__empty_1 = true; $__currentLoopData = $students; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $student): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <tr>
                                    <td class="px-6 py-4"><?php echo e($student->matricule ?? '-'); ?></td>
                                    <td class="px-6 py-4"><?php echo e($student->nom ?? $student->name ?? '-'); ?></td>
                                    <td class="px-6 py-4"><?php echo e($student->prenom ?? '-'); ?></td>
                                    <td class="px-6 py-4"><?php echo e($student->email ?? '-'); ?></td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <tr>
                                    <td colspan="4" class="px-6 py-12 text-center text-gray-400">Aucun étudiant trouvé</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>
</body>
</html>
<?php /**PATH D:\PROJET REGISTRAIRE\registrarClone\registrar\resources\views/teacher/students/index.blade.php ENDPATH**/ ?>