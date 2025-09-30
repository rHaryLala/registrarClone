<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier le cours - Université Adventiste Zurcher</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="icon" type="image/png" href="/favicon.png">
    <style>
        body {
            font-family: 'Montserrat', sans-serif;
        }
        .sidebar {
            width: 260px;
            transition: all 0.3s;
        }
        .main-content {
            margin-left: 260px;
            transition: all 0.3s;
        }
        @media (max-width: 768px) {
            .sidebar {
                margin-left: -260px;
            }
            .main-content {
                margin-left: 0;
            }
            .sidebar.active {
                margin-left: 0;
            }
        }
        .nav-item:hover {
            background-color: rgba(255, 255, 255, 0.1);
        }
        .stats-card {
            transition: transform 0.3s;
        }
        .stats-card:hover {
            transform: translateY(-5px);
        }
    </style>
</head>
<body class="bg-gray-100">
    <?php echo $__env->make('superadmin.components.sidebar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <div class="main-content min-h-screen">
        <?php echo $__env->make('superadmin.components.header', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        <main class="p-6 flex items-center justify-center min-h-screen">
            <!-- Modal -->
            <div class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50">
                <div class="bg-white rounded-lg shadow-lg w-full max-w-lg p-8 relative">
                    <h2 class="text-xl font-bold mb-6">Modifier le cours</h2>
                    <form action="<?php echo e(route('superadmin.courses.update', $course->id)); ?>" method="POST">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('PUT'); ?>
                        <div class="mb-4">
                            <label class="block text-gray-700 font-semibold mb-2">Sigle</label>
                            <input type="text" name="sigle" value="<?php echo e(old('sigle', $course->sigle)); ?>" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-700 font-semibold mb-2">Nom du cours</label>
                            <input type="text" name="nom" value="<?php echo e(old('nom', $course->nom)); ?>" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-700 font-semibold mb-2">Crédits</label>
                            <input type="number" name="credits" min="1" value="<?php echo e(old('credits', $course->credits)); ?>" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-700 font-semibold mb-2">Professeur</label>
                            <select name="teacher_id" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <option value="">-- Sélectionner --</option>
                                <?php $__currentLoopData = $teachers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $teacher): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($teacher->id); ?>" <?php if(old('teacher_id', $course->teacher_id) == $teacher->id): ?> selected <?php endif; ?>><?php echo e($teacher->name); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                        <div class="mb-6">
                            <label class="block text-gray-700 font-semibold mb-2">Mentions (sélection multiple possible)</label>
                            <select name="mention_ids[]" multiple class="w-full border border-gray-300 rounded-lg px-3 py-2" size="5">
                                <?php $__currentLoopData = $mentions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $mention): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($mention->id); ?>" <?php if(in_array($mention->id, old('mention_ids', $course->mentions()->pluck('mentions.id')->toArray()))): ?> selected <?php endif; ?>><?php echo e($mention->nom); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                            <p class="text-sm text-gray-500 mt-2">Maintenez Ctrl (ou Cmd) pour sélectionner plusieurs mentions.</p>
                        </div>
                        <div class="mb-6">
                            <label class="block text-gray-700 font-semibold mb-2">Niveaux (sélection multiple possible)</label>
                            <select name="year_level_ids[]" multiple class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" size="5" required>
                                <?php $__currentLoopData = $yearLevels; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $level): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($level->id); ?>" <?php if(in_array($level->id, old('year_level_ids', $course->yearLevels()->pluck('year_levels.id')->toArray()))): ?> selected <?php endif; ?>><?php echo e($level->label); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                            <p class="text-sm text-gray-500 mt-2">Maintenez Ctrl (ou Cmd) pour sélectionner plusieurs niveaux.</p>
                        </div>
                        <div class="mb-6">
                            <label class="block text-gray-700 font-semibold mb-2">Catégorie</label>
                            <select name="categorie" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                                <option value="général" <?php if(old('categorie', $course->categorie) == 'général'): ?> selected <?php endif; ?>>Général</option>
                                <option value="majeur" <?php if(old('categorie', $course->categorie) == 'majeur'): ?> selected <?php endif; ?>>Majeur</option>
                            </select>
                        </div>
                        <div class="flex justify-end">
                            <a href="<?php echo e(route('superadmin.courses.list')); ?>" class="mr-4 px-4 py-2 rounded-lg border border-gray-300 text-gray-700 hover:bg-gray-100">Annuler</a>
                            <button type="submit" class="bg-blue-700 text-white px-6 py-2 rounded-lg hover:bg-blue-800 transition flex items-center">
                                <i class="fas fa-save mr-2"></i> Enregistrer
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </main>
    </div>
</body>
</html>
<?php /**PATH D:\PROJET REGISTRAIRE\registrarClone\registrar\resources\views/superadmin/courses/edit.blade.php ENDPATH**/ ?>