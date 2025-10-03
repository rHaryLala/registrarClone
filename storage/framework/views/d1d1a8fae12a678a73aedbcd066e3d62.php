<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Paramètres - Université Adventiste Zurcher</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="icon" href="<?php echo e(url('public/favicon.png')); ?>" type="image/png">
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
    <?php echo $__env->make('dean.components.sidebar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <div class="main-content min-h-screen">
        <?php echo $__env->make('dean.components.header', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        <main class="p-6 max-w-3xl mx-auto">
            <h1 class="text-3xl font-bold mb-8 text-center text-gray-800 flex items-center justify-center gap-2">
                <i class="fas fa-user-cog text-blue-600"></i> Paramètres du compte
            </h1>

            <div class="bg-gradient-to-r from-white via-gray-50 to-white shadow-xl rounded-2xl p-8 border border-gray-200">
                <form action="<?php echo e(route('dean.settings.update')); ?>" method="POST" class="space-y-6">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('PUT'); ?>

                    <!-- Nom -->
                    <div>
                        <label class="block text-gray-700 font-semibold mb-2">Nom</label>
                        <input type="text" name="name" value="<?php echo e(old('name', auth()->user()->name)); ?>"
                            class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition" required>
                    </div>

                    <!-- Email -->
                    <div>
                        <label class="block text-gray-700 font-semibold mb-2">Email</label>
                        <input type="email" name="email" value="<?php echo e(old('email', auth()->user()->email)); ?>"
                            class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition" required>
                    </div>

                    <!-- Mot de passe -->
                    <div>
                        <label class="block text-gray-700 font-semibold mb-2">Nouveau mot de passe</label>
                        <input type="password" name="password"
                            class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                        <span class="text-xs text-gray-500">Laisser vide pour ne pas changer</span>
                    </div>

                    <!-- Langue -->
                    <div>
                        <label class="block text-gray-700 font-semibold mb-2">Langue de l'interface</label>
                        <select name="lang"
                                class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                            <option value="fr" <?php if(auth()->user()->lang == 'fr'): ?> selected <?php endif; ?>>🇫🇷 Français</option>
                            <option value="en" <?php if(auth()->user()->lang == 'en'): ?> selected <?php endif; ?>>🇬🇧 Anglais</option>
                        </select>
                    </div>

                    <!-- Notifications -->
                    <div>
                        <label class="block text-gray-700 font-semibold mb-3">Notifications</label>
                        <div class="flex items-center gap-6">
                            <label class="flex items-center gap-2">
                                <input type="checkbox" name="notif_email" value="1"
                                    class="w-5 h-5 text-blue-600 rounded focus:ring-2 focus:ring-blue-500" 
                                    <?php if(auth()->user()->notif_email): ?> checked <?php endif; ?>>
                                <span>Email</span>
                            </label>
                            <label class="flex items-center gap-2">
                                <input type="checkbox" name="notif_sms" value="1"
                                    class="w-5 h-5 text-blue-600 rounded focus:ring-2 focus:ring-blue-500"
                                    <?php if(auth()->user()->notif_sms): ?> checked <?php endif; ?>>
                                <span>SMS</span>
                            </label>
                        </div>
                    </div>

                    <!-- Bouton -->
                    <div class="flex justify-end">
                        <button type="submit"
                                class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-xl shadow-md transition transform hover:scale-105 flex items-center gap-2">
                            <i class="fas fa-save"></i> Enregistrer
                        </button>
                    </div>
                </form>
            </div>
        </main>
    </div>
</body>
</html>
<?php /**PATH D:\PROJET REGISTRAIRE\registrarClone\registrar\resources\views/dean/settings.blade.php ENDPATH**/ ?>