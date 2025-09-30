<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Paramètres - Université Adventiste Zurcher</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { font-family: 'Montserrat', sans-serif; }
        .sidebar { width: 260px; transition: all 0.3s; }
        .main-content { margin-left: 260px; transition: all 0.3s; }
        @media (max-width: 768px) {
            .sidebar { margin-left: -260px; }
            .main-content { margin-left: 0; }
            .sidebar.active { margin-left: 0; }
        }
        .nav-item:hover { background-color: rgba(255, 255, 255, 0.1); }
        .stats-card { transition: transform 0.3s; }
        .stats-card:hover { transform: translateY(-5px); }
    </style>
</head>
<body class="bg-gray-100">
    <?php echo $__env->make('superadmin.components.sidebar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <div class="main-content min-h-screen">
        <?php echo $__env->make('superadmin.components.header', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        <main class="p-6 max-w-2xl mx-auto">
            <h1 class="text-2xl font-bold mb-6">Paramètres du compte</h1>
            <div class="bg-white shadow rounded-lg p-8">
                <form action="<?php echo e(route('superadmin.settings.update')); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('PUT'); ?>
                    <div class="mb-4">
                        <label class="block text-gray-700 font-semibold mb-2">Nom</label>
                        <input type="text" name="name" value="<?php echo e(old('name', auth()->user()->name)); ?>" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700 font-semibold mb-2">Email</label>
                        <input type="email" name="email" value="<?php echo e(old('email', auth()->user()->email)); ?>" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700 font-semibold mb-2">Nouveau mot de passe</label>
                        <input type="password" name="password" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <span class="text-xs text-gray-500">Laisser vide pour ne pas changer</span>
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700 font-semibold mb-2">Langue de l'interface</label>
                        <select name="lang" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="fr" <?php if(auth()->user()->lang == 'fr'): ?> selected <?php endif; ?>>Français</option>
                            <option value="en" <?php if(auth()->user()->lang == 'en'): ?> selected <?php endif; ?>>Anglais</option>
                        </select>
                    </div>
                    <div class="mb-6">
                        <label class="block text-gray-700 font-semibold mb-2">Notifications</label>
                        <div class="flex items-center space-x-4">
                            <label class="flex items-center">
                                <input type="checkbox" name="notif_email" value="1" class="mr-2" <?php if(auth()->user()->notif_email): ?> checked <?php endif; ?>>
                                Email
                            </label>
                            <label class="flex items-center">
                                <input type="checkbox" name="notif_sms" value="1" class="mr-2" <?php if(auth()->user()->notif_sms): ?> checked <?php endif; ?>>
                                SMS
                            </label>
                        </div>
                    </div>
                    <div class="flex justify-end">
                        <button type="submit" class="bg-blue-700 text-white px-6 py-2 rounded-lg hover:bg-blue-800 transition flex items-center">
                            <i class="fas fa-save mr-2"></i> Enregistrer
                        </button>
                    </div>
                </form>
            </div>
        </main>
    </div>
</body>
</html>
<?php /**PATH D:\PROJET REGISTRAIRE\registrarClone\registrar\resources\views/superadmin/settings.blade.php ENDPATH**/ ?>