<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion - Université Adventiste Zurcher</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Montserrat:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
        .brand-font {
            font-family: 'Montserrat', sans-serif;
        }
        .login-container {
            background: linear-gradient(135deg, #0f172a 0%, #1e3a8a 35%, #3b82f6 100%);
            min-height: 100vh;
            position: relative;
        }
        .login-container::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grid" width="10" height="10" patternUnits="userSpaceOnUse"><path d="M 10 0 L 0 0 0 10" fill="none" stroke="rgba(255,255,255,0.05)" stroke-width="0.5"/></pattern></defs><rect width="100" height="100" fill="url(%23grid)"/></svg>');
            opacity: 0.3;
        }
        .login-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-radius: 24px;
            box-shadow: 
                0 32px 64px -12px rgba(0, 0, 0, 0.25),
                0 0 0 1px rgba(255, 255, 255, 0.1),
                inset 0 1px 0 rgba(255, 255, 255, 0.9);
            border: 1px solid rgba(255, 255, 255, 0.2);
            position: relative;
            z-index: 10;
        }
        .logo-glow {
            box-shadow: 0 0 30px rgba(59, 130, 246, 0.3);
        }
        .input-focus {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .input-focus:focus {
            transform: translateY(-1px);
            box-shadow: 0 10px 25px -5px rgba(59, 130, 246, 0.25);
        }
        .btn-primary {
            background: linear-gradient(135deg, #1e40af 0%, #3b82f6 50%, #60a5fa 100%);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
        }
        .btn-primary::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
            transition: left 0.5s;
        }
        .btn-primary:hover::before {
            left: 100%;
        }
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 20px 40px -10px rgba(59, 130, 246, 0.4);
        }
        .floating-shapes {
            position: absolute;
            width: 100%;
            height: 100%;
            overflow: hidden;
            z-index: 1;
        }
        .shape {
            position: absolute;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            animation: float 6s ease-in-out infinite;
        }
        .shape:nth-child(1) {
            width: 80px;
            height: 80px;
            top: 20%;
            left: 10%;
            animation-delay: 0s;
        }
        .shape:nth-child(2) {
            width: 120px;
            height: 120px;
            top: 60%;
            right: 15%;
            animation-delay: 2s;
        }
        .shape:nth-child(3) {
            width: 60px;
            height: 60px;
            bottom: 20%;
            left: 20%;
            animation-delay: 4s;
        }
        @keyframes float {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-20px) rotate(180deg); }
        }
        .fade-in {
            animation: fadeIn 0.8s ease-out;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body class="login-container flex items-center justify-center p-4">
    <!-- Formes flottantes décoratives -->
    <div class="floating-shapes">
        <div class="shape"></div>
        <div class="shape"></div>
        <div class="shape"></div>
    </div>

    <div class="login-card w-full max-w-md p-10 fade-in">
        <!-- Logo et en-tête -->
        <div class="text-center mb-10">
            <div class="w-24 h-24 rounded-2xl mx-auto mb-6 flex items-center justify-center overflow-hidden logo-glow">
                <img src="https://yt3.googleusercontent.com/ytc/AGIKgqMrYnDBtikTA3sE31ur77qAnb56zLrCpKXqfFCB=s900-c-k-c0x00ffffff-no-rj"
                     alt="Logo UAZ"
                     class="w-full h-full object-cover rounded-2xl">
            </div>
            <h1 class="text-3xl font-bold text-gray-900 brand-font mb-2">Université Adventiste Zurcher</h1>
            <p class="text-gray-600 font-medium">Connexion</p>
            <div class="w-16 h-1 bg-gradient-to-r from-blue-600 to-blue-400 rounded-full mx-auto mt-4"></div>
        </div>

        <!-- Messages de session -->
        <?php if(session('status')): ?>
            <div class="mb-6 p-4 bg-gradient-to-r from-green-50 to-emerald-50 text-green-800 rounded-xl border border-green-200">
                <div class="flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                    </svg>
                    <?php echo e(session('status')); ?>

                </div>
            </div>
        <?php endif; ?>

        <?php if($errors->any()): ?>
            <div class="mb-6 p-4 bg-gradient-to-r from-red-50 to-rose-50 text-red-800 rounded-xl border border-red-200">
                <div class="flex items-start">
                    <svg class="w-5 h-5 mr-2 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                    </svg>
                    <ul class="list-disc list-inside space-y-1">
                        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li><?php echo e($error); ?></li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                </div>
            </div>
        <?php endif; ?>

        <!-- Formulaire de connexion -->
        <form method="POST" action="<?php echo e(route('login')); ?>" class="space-y-6">
            <?php echo csrf_field(); ?>
            
            <div class="space-y-5">
                <div>
                    <label for="email" class="block text-sm font-semibold text-gray-800 mb-2">Adresse email</label>
                    <div class="relative">
                        <input type="email" id="email" name="email" required
                               class="input-focus w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-4 focus:ring-blue-500/20 focus:border-blue-500 transition-all duration-300 bg-white/80"
                               value="<?php echo e(old('email')); ?>"
                               placeholder="votremail@zurcher.edu.mg">
                        <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <div>
                    <label for="password" class="block text-sm font-semibold text-gray-800 mb-2">Mot de passe</label>
                    <div class="relative">
                        <input type="password" id="password" name="password" required
                               class="input-focus w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-4 focus:ring-blue-500/20 focus:border-blue-500 transition-all duration-300 bg-white/80"
                               placeholder="Votre mot de passe">
                        <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                            <!-- Toggle password visibility button -->
                            <button type="button" id="toggle-password" aria-label="Afficher/masquer le mot de passe" class="text-gray-500 hover:text-gray-700 focus:outline-none focus:ring-0">
                                <!-- Eye (visible) -->
                                <svg id="icon-eye" xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5s8.268 2.943 9.542 7c-1.274 4.057-5.065 7-9.542 7s-8.268-2.943-9.542-7z" />
                                </svg>
                                <!-- Eye off (hidden) - hidden by default -->
                                <svg id="icon-eye-off" xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 hidden" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.269-2.943-9.543-7a9.969 9.969 0 012.223-3.274" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6.1 6.1L18 18" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.88 9.88A3 3 0 0114.12 14.12" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

                <div class="flex items-center justify-between pt-2">
                    <div class="flex items-center">
                        <input type="checkbox" id="remember" name="remember"
                               class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded transition-colors">
                        <label for="remember" class="ml-3 block text-sm font-medium text-gray-700">Se souvenir de moi</label>
                    </div>

                    <?php if(Route::has('password.request')): ?>
                    <a href="<?php echo e(route('password.request')); ?>" 
                       class="text-sm font-medium text-blue-600 hover:text-blue-500 transition-colors duration-200">
                        Mot de passe oublié?
                    </a>
                    <?php endif; ?>
                </div>
            </div>

            <div class="pt-4">
                <button type="submit"
                        class="btn-primary w-full py-3 px-6 text-white font-semibold rounded-xl focus:outline-none focus:ring-4 focus:ring-blue-500/30 transition-all duration-300">
                    <span class="relative z-10">Se connecter</span>
                </button>
            </div>
        </form>

        <!-- Footer -->
        <div class="mt-8 pt-6 border-t border-gray-200">
            <p class="text-center text-xs text-gray-500">
                © 2025 Université Adventiste Zurcher. Tous droits réservés.
            </p>
        </div>
    </div>
</body>
</html>
<script>
    (function(){
        var toggle = document.getElementById('toggle-password');
        if(!toggle) return;
        var pwd = document.getElementById('password');
        var eye = document.getElementById('icon-eye');
        var eyeOff = document.getElementById('icon-eye-off');

        toggle.addEventListener('click', function(e){
            e.preventDefault();
            if(!pwd) return;
            if(pwd.type === 'password'){
                pwd.type = 'text';
                if(eye) eye.classList.add('hidden');
                if(eyeOff) eyeOff.classList.remove('hidden');
            } else {
                pwd.type = 'password';
                if(eye) eye.classList.remove('hidden');
                if(eyeOff) eyeOff.classList.add('hidden');
            }
            // keep focus on password input after toggle
            pwd.focus();
        });
    })();
</script>
<?php /**PATH D:\PROJET REGISTRAIRE\registrarClone\registrar\resources\views/auth/login.blade.php ENDPATH**/ ?>