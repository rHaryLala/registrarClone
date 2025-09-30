<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Doyen - Université Adventiste Zurcher</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="icon" type="image/png" href="/favicon.png">
    <style>
        * {
            font-family: 'Montserrat', sans-serif;
        }
        
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateX(-20px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        /* Added consistent layout styles for sidebar and main content */
        .dashboard-container {
            display: flex;
            min-height: 100vh;
            background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
        }

        .sidebar {
            width: 280px;
            background: linear-gradient(180deg, #1954b4 0%, #0b2d5c 100%);
            box-shadow: 4px 0 20px rgba(0, 0, 0, 0.1);
            position: fixed;
            height: 100vh;
            z-index: 1000;
        }

        .main-content {
            flex: 1;
            margin-left: 280px;
            background: transparent;
        }

        .header {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(226, 232, 240, 0.8);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
        }

        /* Enhanced card styles with better shadows and hover effects */
        .stats-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(226, 232, 240, 0.5);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.08);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            animation: fadeInUp 0.6s ease-out forwards;
        }

        .stats-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.12);
            border-color: rgba(59, 130, 246, 0.3);
        }

        .content-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(226, 232, 240, 0.5);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.08);
            animation: fadeInUp 0.8s ease-out forwards;
        }

        /* Improved registration item styles */
        .registration-item {
            background: linear-gradient(135deg, rgba(248, 250, 252, 0.8) 0%, rgba(241, 245, 249, 0.8) 100%);
            border: 1px solid rgba(226, 232, 240, 0.6);
            transition: all 0.3s ease;
            animation: slideIn 0.5s ease-out forwards;
            animation-delay: calc(var(--item-index) * 0.1s);
            opacity: 0;
        }

        .registration-item:hover {
            background: linear-gradient(135deg, rgba(239, 246, 255, 0.9) 0%, rgba(219, 234, 254, 0.9) 100%);
            transform: translateX(8px);
            border-color: rgba(59, 130, 246, 0.3);
        }

        /* Enhanced icon containers */
        .icon-container {
            background: linear-gradient(135deg, rgba(59, 130, 246, 0.1) 0%, rgba(147, 197, 253, 0.2) 100%);
            border: 1px solid rgba(59, 130, 246, 0.2);
            box-shadow: 0 4px 12px rgba(59, 130, 246, 0.15);
        }

        .avatar-container {
            background: linear-gradient(135deg, rgba(59, 130, 246, 0.1) 0%, rgba(147, 197, 253, 0.2) 100%);
            border: 2px solid rgba(59, 130, 246, 0.2);
            box-shadow: 0 4px 12px rgba(59, 130, 246, 0.15);
        }

        /* Responsive design improvements */
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
                transition: transform 0.3s ease;
            }
            
            .sidebar.open {
                transform: translateX(0);
            }
            
            .main-content {
                margin-left: 0;
            }
        }

        /* Added smooth scrolling and better typography */
        html {
            scroll-behavior: smooth;
        }

        .page-title {
            background: linear-gradient(135deg, #1e293b 0%, #3b82f6 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
    </style>
</head>
<body class="bg-gray-50">
    <div class="dashboard-container">
        <!-- Sidebar -->
        <div class="sidebar">
            <?php echo $__env->make('dean.components.sidebar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        </div>

        <!-- Main Content -->
        <div class="main-content">
            <!-- Header -->
            <div class="header sticky top-0 z-50">
                <?php echo $__env->make('dean.components.header', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
            </div>

            <!-- Content -->
            <main class="p-8">
                <!-- Enhanced title section with better typography and spacing -->
                <div class="mb-12">
                    <h1 class="page-title text-4xl font-bold mb-3"><?php echo e($mention->nom); ?></h1>
                    <p class="text-slate-600 text-lg font-medium">Gérez et suivez les informations de votre mention</p>
                    <div class="w-24 h-1 bg-gradient-to-r from-blue-500 to-indigo-500 rounded-full mt-4"></div>
                </div>

                <!-- Improved statistics grid with better spacing and animations -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-12">
                    <div class="stats-card rounded-2xl p-8 border border-gray-100 hover:border-blue-200">
                        <div class="flex items-center">
                            <div class="icon-container p-4 rounded-2xl bg-gradient-to-br from-blue-100 to-blue-200 text-blue-600 mr-6">
                                <i class="fas fa-users text-2xl"></i>
                            </div>
                            <div>
                                <p class="text-slate-500 text-sm font-semibold uppercase tracking-wide">Total Étudiants</p>
                                <h3 class="number-counter text-3xl font-bold text-slate-800 mt-1"><?php echo e($totalStudents); ?></h3>
                            </div>
                        </div>
                        
                    </div>
                    
                    <!-- Added placeholder for additional stats cards with consistent styling -->
                    <div class="stats-card rounded-2xl p-8 border border-gray-100 hover:border-green-200">
                        <div class="flex items-center">
                            <div class="icon-container p-4 rounded-2xl bg-gradient-to-br from-green-100 to-green-200 text-green-600 mr-6">
                                <i class="fas fa-book text-2xl"></i>
                            </div>
                            <div>
                                <p class="text-slate-500 text-sm font-semibold uppercase tracking-wide">Total Cours</p>
                                <h3 class="number-counter text-3xl font-bold text-slate-800 mt-1"><?php echo e($totalCourses ?? 0); ?></h3>
                            </div>
                        </div>
                        
                    </div>

                    <div class="stats-card rounded-2xl p-8 border border-gray-100 hover:border-purple-200">
                        <div class="flex items-center">
                            <div class="icon-container p-4 rounded-2xl bg-gradient-to-br from-purple-100 to-purple-200 text-purple-600 mr-6">
                                <i class="fas fa-chalkboard-teacher text-2xl"></i>
                            </div>
                            <div>
                                <p class="text-slate-500 text-sm font-semibold uppercase tracking-wide">Total Enseignants</p>
                                <h3 class="number-counter text-3xl font-bold text-slate-800 mt-1"><?php echo e($totalTeachers ?? 0); ?></h3>
                            </div>
                        </div>
                        
                    </div>
                </div>

                <!-- Enhanced recent students section with better design -->
                <div class="content-card rounded-2xl p-8 border border-gray-100">
                    <div class="flex items-center justify-between mb-8">
                        <h3 class="text-2xl font-bold text-slate-800">Derniers étudiants inscrits</h3>
                        <a href="<?php echo e(route('dean.students.index')); ?>" class="text-blue-600 hover:text-blue-800 font-semibold transition-colors duration-200 flex items-center">
                            Voir tous <i class="fas fa-arrow-right ml-2"></i>
                        </a>
                    </div>
                    <div class="space-y-4">
                        <?php $__currentLoopData = $students->take(5); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $student): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="registration-item flex items-center justify-between p-6 rounded-2xl border border-gray-100" 
                                style="--item-index: <?php echo e($index); ?>">
                                <div class="flex items-center space-x-6">
                                    <div class="avatar-container w-14 h-14 rounded-2xl flex items-center justify-center shadow-sm">
                                        <span class="text-blue-600 font-bold text-lg"><?php echo e(substr($student->prenom, 0, 1)); ?><?php echo e(substr($student->nom, 0, 1)); ?></span>
                                    </div>
                                    <div>
                                        <p class="font-bold text-slate-800 text-lg"><?php echo e($student->nom); ?> <?php echo e($student->prenom); ?></p>
                                        <p class="text-slate-500 font-medium"><?php echo e($student->matricule); ?></p>
                                    </div>
                                </div>
                                <a href="<?php echo e(route('dean.students.show', $student->id)); ?>" 
                                   class="bg-blue-50 hover:bg-blue-100 text-blue-600 hover:text-blue-700 font-semibold px-6 py-3 rounded-xl transition-all duration-200 border border-blue-200 hover:border-blue-300">
                                    Voir détails
                                </a>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Animate numbers
            const counters = document.querySelectorAll('.number-counter');
            counters.forEach(counter => {
                const target = parseInt(counter.textContent);
                let current = 0;
                const increment = target / 50;
                const timer = setInterval(() => {
                    current += increment;
                    if (current >= target) {
                        counter.textContent = target;
                        clearInterval(timer);
                    } else {
                        counter.textContent = Math.floor(current);
                    }
                }, 30);
            });

            // Mobile sidebar toggle (if needed)
            const sidebarToggle = document.querySelector('.sidebar-toggle');
            const sidebar = document.querySelector('.sidebar');
            
            if (sidebarToggle && sidebar) {
                sidebarToggle.addEventListener('click', () => {
                    sidebar.classList.toggle('open');
                });
            }
        });
    </script>
</body>
</html>
<?php /**PATH D:\PROJET REGISTRAIRE\registrarClone\registrar\resources\views/dean/dashboard.blade.php ENDPATH**/ ?>