<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter un cours - Université Adventiste Zurcher</title>
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
    <!-- Sidebar -->
    <?php echo $__env->make('superadmin.components.sidebar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    <!-- Main Content -->
    <div class="main-content min-h-screen">
        <!-- Header -->
        <?php echo $__env->make('superadmin.components.header', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

        <!-- Content -->
        <main class="p-6 max-w-2xl mx-auto">
            <h1 class="text-2xl font-bold mb-6">Ajouter un cours</h1>
            <div class="bg-white shadow rounded-lg p-8">
                <form action="<?php echo e(route('superadmin.courses.store')); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    <?php if($errors->any()): ?>
                        <div class="mb-4 p-4 bg-red-50 border border-red-200 text-red-700 rounded">
                            <strong>Erreur :</strong>
                            <ul class="mt-2 list-disc list-inside">
                                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <li><?php echo e($error); ?></li>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </ul>
                        </div>
                    <?php endif; ?>
                    <div class="mb-4">
                        <label class="block text-gray-700 font-semibold mb-2">Sigle</label>
                        <input type="text" name="sigle" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700 font-semibold mb-2">Nom du cours</label>
                        <input type="text" name="nom" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700 font-semibold mb-2">Crédits</label>
                        <input type="number" name="credits" min="1" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                    </div>
                    <div class="mb-6">
                        <label class="block text-gray-700 font-semibold mb-2">Professeur</label>
                        <select name="teacher_id" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="">-- Sélectionner --</option>
                            <?php $__currentLoopData = $teachers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $teacher): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($teacher->id); ?>"><?php echo e($teacher->name); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                    <div class="mb-6">
                        <label class="block text-gray-700 font-semibold mb-2">Mention(s)</label>
                        <select name="mention_ids[]" class="w-full border border-gray-300 rounded-lg px-3 py-2" multiple size="4">
                            <?php $__currentLoopData = $mentions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $mention): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($mention->id); ?>" <?php if(is_array(old('mention_ids', [])) && in_array($mention->id, old('mention_ids', []))): ?> selected <?php endif; ?>><?php echo e($mention->nom); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                        <p class="text-sm text-gray-500 mt-2">Maintenez Ctrl (ou Cmd) pour sélectionner plusieurs mentions.</p>
                    </div>
                    <div class="mb-6">
                        <label class="block text-gray-700 font-semibold mb-2">Niveau(x) d'étude</label>
                        <select name="year_level_ids[]" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" multiple size="4" required>
                            <?php $__currentLoopData = $yearLevels; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $level): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($level->id); ?>" <?php if(is_array(old('year_level_ids', [])) && in_array($level->id, old('year_level_ids', []))): ?> selected <?php endif; ?>><?php echo e($level->label); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                        <p class="text-sm text-gray-500 mt-2">Maintenez Ctrl (ou Cmd) pour sélectionner plusieurs niveaux.</p>
                    </div>
                    <div class="flex justify-end">
                        <div class="mr-4">
                            <label class="block text-gray-700 font-semibold mb-2">Catégorie</label>
                            <select name="categorie" class="border border-gray-300 rounded-lg px-3 py-2">
                                <option value="général" <?php if(old('categorie') == 'général'): ?> selected <?php endif; ?>>général</option>
                                <option value="majeur" <?php if(old('categorie') == 'majeur'): ?> selected <?php endif; ?>>majeur</option>
                            </select>
                        </div>
                        <button type="submit" class="bg-blue-700 text-white px-6 py-2 rounded-lg hover:bg-blue-800 transition flex items-center">
                            <i class="fas fa-save mr-2"></i> Enregistrer
                        </button>
                    </div>
                </form>
            </div>
        </main>
    </div>

    <script>
        // Toggle sidebar on mobile
        document.getElementById('sidebarToggle').addEventListener('click', function() {
            document.querySelector('.sidebar').classList.toggle('active');
        });

        // Close sidebar when clicking outside on mobile
        document.addEventListener('click', function(event) {
            const sidebar = document.querySelector('.sidebar');
            const toggle = document.getElementById('sidebarToggle');
            
            if (window.innerWidth < 768 && 
                !sidebar.contains(event.target) && 
                !toggle.contains(event.target) &&
                sidebar.classList.contains('active')) {
                sidebar.classList.remove('active');
            }
        });
    </script>
</body>
</html>
<?php /**PATH D:\PROJET REGISTRAIRE\registrarClone\registrar\resources\views/superadmin/courses/create.blade.php ENDPATH**/ ?>