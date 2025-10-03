<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard SuperAdmin - Université Adventiste Zurcher</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="icon" href="{{ url('public/favicon.png') }}" type="image/png">
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
        <main class="p-6">
            <!-- Ajout d'animations CSS modernes et d'effets visuels -->
            <style>
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

                @keyframes slideInLeft {
                    from {
                        opacity: 0;
                        transform: translateX(-30px);
                    }
                    to {
                        opacity: 1;
                        transform: translateX(0);
                    }
                }

                @keyframes pulse {
                    0%, 100% {
                        transform: scale(1);
                    }
                    50% {
                        transform: scale(1.05);
                    }
                }

                @keyframes growBar {
                    from {
                        height: 0;
                    }
                    to {
                        height: var(--bar-height);
                    }
                }

                .stats-card {
                    animation: fadeInUp 0.6s ease-out;
                    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
                    position: relative;
                    overflow: hidden;
                }

                .stats-card:nth-child(1) { animation-delay: 0.1s; }
                .stats-card:nth-child(2) { animation-delay: 0.2s; }
                .stats-card:nth-child(3) { animation-delay: 0.3s; }
                .stats-card:nth-child(4) { animation-delay: 0.4s; }

                .stats-card::before {
                    content: '';
                    position: absolute;
                    top: 0;
                    left: -100%;
                    width: 100%;
                    height: 100%;
                    background: linear-gradient(90deg, transparent, rgba(255,255,255,0.4), transparent);
                    transition: left 0.5s;
                }

                .stats-card:hover {
                    transform: translateY(-8px);
                    box-shadow: 0 20px 40px rgba(0,0,0,0.1);
                }

                .stats-card:hover::before {
                    left: 100%;
                }

                .icon-container {
                    transition: all 0.3s ease;
                }

                .stats-card:hover .icon-container {
                    transform: scale(1.1) rotate(5deg);
                }

                .chart-container {
                    animation: slideInLeft 0.8s ease-out 0.5s both;
                }

                .chart-bar {
                    animation: growBar 1s ease-out;
                    animation-delay: calc(var(--bar-index) * 0.1s);
                    transition: all 0.3s ease;
                }

                .chart-bar:hover {
                    background: linear-gradient(to top, #1e40af, #3b82f6) !important;
                    transform: scale(1.1);
                }

                .registration-item {
                    animation: fadeInUp 0.5s ease-out;
                    animation-delay: calc(var(--item-index) * 0.1s);
                    transition: all 0.3s ease;
                }

                .registration-item:hover {
                    transform: translateX(10px);
                    background: linear-gradient(135deg, #f8fafc, #e2e8f0) !important;
                }

                .quick-action {
                    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
                    position: relative;
                    overflow: hidden;
                }

                .quick-action::before {
                    content: '';
                    position: absolute;
                    top: 50%;
                    left: 50%;
                    width: 0;
                    height: 0;
                    background: radial-gradient(circle, rgba(59, 130, 246, 0.1), transparent);
                    transition: all 0.4s ease;
                    transform: translate(-50%, -50%);
                    border-radius: 50%;
                }

                .quick-action:hover::before {
                    width: 300px;
                    height: 300px;
                }

                .quick-action:hover {
                    transform: translateY(-5px) scale(1.02);
                    box-shadow: 0 15px 30px rgba(0,0,0,0.1);
                }

                .number-counter {
                    transition: all 0.3s ease;
                }

                .stats-card:hover .number-counter {
                    color: #1e40af;
                    transform: scale(1.1);
                }

                .gradient-bg {
                    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                }

                .glass-effect {
                    backdrop-filter: blur(10px);
                    background: rgba(255, 255, 255, 0.9);
                    border: 1px solid rgba(255, 255, 255, 0.2);
                }
            </style>

            <!-- Statistiques -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <div class="stats-card bg-white rounded-xl shadow-lg p-6 border border-gray-100 hover:border-blue-200">
                    <div class="flex items-center">
                        <div class="icon-container p-3 rounded-full bg-gradient-to-br from-blue-100 to-blue-200 text-blue-600 mr-4">
                            <i class="fas fa-users text-xl"></i>
                        </div>
                        <div>
                            <p class="text-gray-500 text-sm font-medium">Utilisateurs</p>
                            <h3 class="number-counter text-2xl font-bold text-gray-800"><?php echo e($usersCount); ?></h3>
                        </div>
                    </div>
                    <!-- Statistiques dynamiques à implémenter -->
                </div>

                <div class="stats-card bg-white rounded-xl shadow-lg p-6 border border-gray-100 hover:border-green-200">
                    <div class="flex items-center">
                        <div class="icon-container p-3 rounded-full bg-gradient-to-br from-green-100 to-green-200 text-green-600 mr-4">
                            <i class="fas fa-graduation-cap text-xl"></i>
                        </div>
                        <div>
                            <p class="text-gray-500 text-sm font-medium">Étudiants (1ère année)</p>
                            <h3 class="number-counter text-2xl font-bold text-gray-800"><?php echo e($firstYearCount); ?></h3>
                        </div>
                    </div>
                    <!-- Statistiques dynamiques : afficher le total des étudiants -->
                    <div class="mt-4 text-sm text-gray-600">
                        <span class="font-medium">Total étudiants :</span> <?php echo e($totalStudents); ?>

                    </div>
                </div>

                <div class="stats-card bg-white rounded-xl shadow-lg p-6 border border-gray-100 hover:border-blue-200">
                    <div class="flex items-center">
                        <div class="icon-container p-3 rounded-full bg-gradient-to-br from-blue-100 to-blue-200 text-blue-600 mr-4">
                            <i class="fas fa-chalkboard-teacher text-xl"></i>
                        </div>
                        <div>
                            <p class="text-gray-500 text-sm font-medium">Enseignants</p>
                            <h3 class="number-counter text-2xl font-bold text-gray-800"><?php echo e($teachersCount); ?></h3>
                        </div>
                    </div>
                    <!-- Statistiques dynamiques à implémenter -->
                </div>

                <div class="stats-card bg-white rounded-xl shadow-lg p-6 border border-gray-100 hover:border-orange-200">
                    <div class="flex items-center">
                        <div class="icon-container p-3 rounded-full bg-gradient-to-br from-orange-100 to-orange-200 text-orange-600 mr-4">
                            <i class="fas fa-book text-xl"></i>
                        </div>
                        <div>
                            <p class="text-gray-500 text-sm font-medium">Cours</p>
                            <h3 class="number-counter text-2xl font-bold text-gray-800"><?php echo e($coursesCount); ?></h3>
                        </div>
                    </div>
                    <!-- Statistiques dynamiques à implémenter -->
                </div>
            </div>

            <!-- Graphiques et tableaux -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
                <!-- Graphique d'inscriptions -->
                <?php
                    $days = [];
                    $counts = [];
                    $maxBarHeight = 150;
                    $maxCount = 1;
                    for ($i = 6; $i >= 0; $i--) {
                        $date = \Carbon\Carbon::now()->subDays($i)->format('Y-m-d');
                        $days[] = \Carbon\Carbon::parse($date)->format('d/m');
                        $counts[] = $dailyRegistrations[$date] ?? 0;
                        if (($dailyRegistrations[$date] ?? 0) > $maxCount) $maxCount = $dailyRegistrations[$date] ?? 0;
                    }
                ?>
                <div class="chart-container bg-white rounded-xl shadow-lg p-6 border border-gray-100">
                    <h3 class="text-lg font-semibold mb-6 text-gray-800">Inscriptions des 7 derniers jours</h3>
                    <div class="h-64 flex justify-between items-end">
                        <?php $__currentLoopData = $days; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $day): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php
                                $count = $counts[$i];
                                $barHeight = ($count > 0 && $maxCount > 0) ? max(8, ($count / $maxCount) * $maxBarHeight) : 0;
                            ?>
                            <div class="flex flex-col items-center" style="width: 24px;">
                                <?php if($count > 0): ?>
                                    <div class="chart-bar bg-gradient-to-t from-blue-600 to-blue-400 w-3 rounded-t-lg shadow-sm" 
                                        style="--bar-height: <?php echo e($barHeight); ?>px; --bar-index: <?php echo e($i); ?>; height: <?php echo e($barHeight); ?>px; max-height: <?php echo e($maxBarHeight); ?>px"></div>
                                <?php else: ?>
                                    <div style="height: 0px;"></div>
                                <?php endif; ?>
                                <span class="text-xs mt-2 font-medium text-gray-600"><?php echo e($day); ?></span>
                                <span class="text-xs text-blue-600 font-semibold"><?php echo e($count); ?></span>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>

                <!-- Dernières inscriptions -->
                <div class="bg-white rounded-xl shadow-lg p-6 border border-gray-100">
                    <h3 class="text-lg font-semibold mb-6 text-gray-800">Dernières inscriptions</h3>
                    <div class="space-y-4">
                        <?php $__currentLoopData = $latestRegistrations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $registration): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="registration-item flex items-center justify-between p-4 bg-gradient-to-r from-gray-50 to-blue-50 rounded-xl border border-gray-100" 
                                style="--item-index: <?php echo e($index); ?>;">
                                <div class="flex items-center space-x-4">
                                    <div class="w-12 h-12 bg-gradient-to-br from-blue-100 to-blue-200 rounded-full flex items-center justify-center shadow-sm">
                                        <i class="fas fa-user-graduate text-blue-600"></i>
                                    </div>
                                    <div>
                                        <p class="font-semibold text-gray-800"><?php echo e($registration->name ?? $registration->nom ?? ''); ?></p>
                                        <p class="text-sm text-gray-600"><?php echo e($registration->email ?? $registration->mention_envisagee ?? ''); ?></p>
                                    </div>
                                </div>
                                <span class="text-sm text-blue-600 font-medium"><?php echo e($registration->created_at->diffForHumans()); ?></span>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
            </div>

            <!-- Actions rapides -->
            <div class="bg-white rounded-xl shadow-lg p-6 border border-gray-100">
                <h3 class="text-lg font-semibold mb-6 text-gray-800">Actions rapides</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    <a href="<?php echo e(route('register')); ?>" class="quick-action p-6 border border-gray-200 rounded-xl text-center hover:border-blue-300 transition-all duration-300 group">
                        <div class="w-14 h-14 bg-gradient-to-br from-blue-100 to-blue-200 rounded-full flex items-center justify-center mx-auto mb-4 group-hover:shadow-lg transition-all duration-300">
                            <i class="fas fa-user-plus text-blue-600 text-xl"></i>
                        </div>
                        <p class="font-semibold text-gray-800 group-hover:text-blue-600 transition-colors">Nouvel étudiant</p>
                    </a>

                    <a href="<?php echo e(route('superadmin.students.list')); ?>" class="quick-action p-6 border border-gray-200 rounded-xl text-center hover:border-green-300 transition-all duration-300 group">
                        <div class="w-14 h-14 bg-gradient-to-br from-green-100 to-green-200 rounded-full flex items-center justify-center mx-auto mb-4 group-hover:shadow-lg transition-all duration-300">
                            <i class="fas fa-user-graduate text-green-600 text-xl"></i>
                        </div>
                        <p class="font-semibold text-gray-800 group-hover:text-green-600 transition-colors">Voir étudiants</p>
                    </a>

                    <a href="#" class="quick-action p-6 border border-gray-200 rounded-xl text-center hover:border-blue-300 transition-all duration-300 group">
                        <div class="w-14 h-14 bg-gradient-to-br from-blue-100 to-blue-200 rounded-full flex items-center justify-center mx-auto mb-4 group-hover:shadow-lg transition-all duration-300">
                            <i class="fas fa-chart-line text-blue-600 text-xl"></i>
                        </div>
                        <p class="font-semibold text-gray-800 group-hover:text-blue-600 transition-colors">Rapports</p>
                    </a>
                    <a href="<?php echo e(route('superadmin.accesscodes.export_pdf')); ?>" target="_blank" class="quick-action p-6 border border-gray-200 rounded-xl text-center hover:border-purple-300 transition-all duration-300 group">
                        <div class="w-14 h-14 bg-gradient-to-br from-purple-100 to-purple-200 rounded-full flex items-center justify-center mx-auto mb-4 group-hover:shadow-lg transition-all duration-300">
                            <i class="fas fa-key text-purple-600 text-xl"></i>
                        </div>
                        <p class="font-semibold text-gray-800 group-hover:text-purple-600 transition-colors">Exporter Access Codes</p>
                    </a>
                    <a href="<?php echo e(route('superadmin.settings')); ?>" class="quick-action p-6 border border-gray-200 rounded-xl text-center hover:border-orange-300 transition-all duration-300 group">
                        <div class="w-14 h-14 bg-gradient-to-br from-orange-100 to-orange-200 rounded-full flex items-center justify-center mx-auto mb-4 group-hover:shadow-lg transition-all duration-300">
                            <i class="fas fa-cog text-orange-600 text-xl"></i>
                        </div>
                        <p class="font-semibold text-gray-800 group-hover:text-orange-600 transition-colors">Paramètres</p>
                    </a>
                    <a href="#" id="openExportModal" class="quick-action p-6 border border-gray-200 rounded-xl text-center hover:border-teal-300 transition-all duration-300 group">
                        <div class="w-14 h-14 bg-gradient-to-br from-teal-100 to-teal-200 rounded-full flex items-center justify-center mx-auto mb-4 group-hover:shadow-lg transition-all duration-300">
                            <i class="fas fa-file-export text-teal-600 text-xl"></i>
                        </div>
                        <p class="font-semibold text-gray-800 group-hover:text-teal-600 transition-colors">Exporter étudiants</p>
                    </a>
                </div>
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

        // Export modal logic
        const openExportModal = document.getElementById('openExportModal');
        if (openExportModal) {
            openExportModal.addEventListener('click', function(e) {
                e.preventDefault();
                const modal = document.getElementById('exportModal');
                if (modal) {
                    modal.style.display = 'flex';
                    setTimeout(() => modal.classList.add('modal-show'), 10);
                }
            });
        }

        function closeExportModal() {
            const modal = document.getElementById('exportModal');
            if (modal) {
                modal.classList.remove('modal-show');
                setTimeout(() => modal.style.display = 'none', 300);
            }
        }

        function submitExportForm() {
            const form = document.getElementById('exportForm');
            if (!form) return;
            // Open a named window and target the form to that name so the POST response
            // will be delivered to the created window instead of leaving about:blank.
            const winName = 'studentExportWindow_' + Date.now();
            const wRef = window.open('', winName);
            // show a temporary processing message while server generates the PDF
            try {
                if (wRef && wRef.document) {
                    wRef.document.write('<!doctype html><html><head><title>Export en cours</title></head><body style="font-family:Arial,Helvetica,sans-serif;display:flex;align-items:center;justify-content:center;height:100vh;"><div><h3>Génération du PDF en cours…</h3><p>Veuillez patienter...</p></div></body></html>');
                    wRef.document.close();
                }
            } catch (e) {
                // ignore cross-origin or popup blockers
            }
            form.target = winName;
            form.submit();
            closeExportModal();
        }

        // Close the modal when clicking on the background
        document.getElementById('exportModal')?.addEventListener('click', function(e) {
            if (e.target === this) closeExportModal();
        });
    </script>

    <!-- Export Modal -->
    <style>
        #exportModal {
            opacity: 0;
            transition: opacity 0.3s ease;
        }
        
        #exportModal.modal-show {
            opacity: 1;
        }
        
        #exportModal.modal-show .modal-content {
            transform: scale(1) translateY(0);
            opacity: 1;
        }
        
        .modal-content {
            transform: scale(0.9) translateY(-20px);
            opacity: 0;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        .modal-input:focus {
            outline: none;
            border-color: #0059e7;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }
        
        .modal-checkbox:checked {
            background-color: #0546af;
            border-color: #0343ab;
        }
        
        .modal-btn-cancel:hover {
            background-color: #f3f4f6;
        }
        
        .modal-btn-export:hover {
            background-color: #0e51e2;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(4, 83, 209, 0.4);
        }
    </style>
    
    <div id="exportModal" style="display:none; position:fixed; inset:0; background:rgba(0,0,0,0.6); backdrop-filter:blur(4px); z-index:1000; align-items:center; justify-content:center;">
        <div class="modal-content" style="width:90%; max-width:560px; background:#fff; border-radius:16px; padding:0; box-shadow:0 20px 60px rgba(0,0,0,0.3); overflow:hidden;">
            <!-- Header -->
            <div style="background:linear-gradient(135deg, #0d2dbc 0%, #4b52a2 100%); padding:24px; position:relative;">
                <button onclick="closeExportModal()" style="position:absolute; top:16px; right:16px; background:rgba(255,255,255,0.2); border:none; width:32px; height:32px; border-radius:50%; cursor:pointer; display:flex; align-items:center; justify-content:center; transition:all 0.2s;" onmouseover="this.style.background='rgba(255,255,255,0.3)'" onmouseout="this.style.background='rgba(255,255,255,0.2)'">
                    <i class="fas fa-times" style="color:#fff; font-size:16px;"></i>
                </button>
                <div style="display:flex; align-items:center; gap:12px;">
                    <div style="width:48px; height:48px; background:rgba(255,255,255,0.2); border-radius:12px; display:flex; align-items:center; justify-content:center;">
                        <i class="fas fa-file-export" style="color:#fff; font-size:24px;"></i>
                    </div>
                    <div>
                        <h3 style="font-size:22px; font-weight:700; color:#fff; margin:0;">Exporter les étudiants</h3>
                        <p style="font-size:14px; color:rgba(255,255,255,0.9); margin:4px 0 0 0;">Sélectionnez les critères de filtrage</p>
                    </div>
                </div>
            </div>
            
            <!-- Form -->
            <form id="exportForm" method="POST" action="<?php echo e(url('/superadmin/students/export')); ?>" style="padding:24px;">
                <?php echo csrf_field(); ?>
                
                <!-- Année académique et Niveau -->
                <div style="display:grid; grid-template-columns:1fr 1fr; gap:16px; margin-bottom:16px;">
                    <div>
                        <label style="display:block; font-size:14px; font-weight:600; color:#374151; margin-bottom:8px;">
                            <i class="fas fa-calendar-alt" style="color:#667eea; margin-right:6px;"></i>
                            Année académique
                        </label>
                        <select name="academic_year_id" class="modal-input" style="width:100%; border:2px solid #e5e7eb; border-radius:8px; padding:10px 12px; font-size:14px; transition:all 0.2s; background:#fff;">
                            <option value="">Toutes les années</option>
                            <?php $__currentLoopData = App\Models\AcademicYear::orderBy('libelle','desc')->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ay): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($ay->id); ?>"><?php echo e($ay->libelle); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                    
                    <div>
                        <label style="display:block; font-size:14px; font-weight:600; color:#374151; margin-bottom:8px;">
                            <i class="fas fa-layer-group" style="color:#667eea; margin-right:6px;"></i>
                            Niveau d'étude
                        </label>
                        <select name="year_level_id" class="modal-input" style="width:100%; border:2px solid #e5e7eb; border-radius:8px; padding:10px 12px; font-size:14px; transition:all 0.2s; background:#fff;">
                            <option value="">Tous les niveaux</option>
                            <?php $__currentLoopData = App\Models\YearLevel::all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $yl): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($yl->id); ?>"><?php echo e($yl->label); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                </div>
                
                <!-- Mention -->
                <div style="margin-bottom:20px;">
                    <label style="display:block; font-size:14px; font-weight:600; color:#374151; margin-bottom:8px;">
                        <i class="fas fa-graduation-cap" style="color:#2548e4; margin-right:6px;"></i>
                        Mention
                    </label>
                    <select name="mention_ids[]" multiple size="6" class="modal-input" style="width:100%; border:2px solid #e5e7eb; border-radius:8px; padding:8px 10px; font-size:14px; transition:all 0.2s; background:#fff;">
                        <option value="">-- Toutes les mentions (laisser vide) --</option>
                        <?php $__currentLoopData = App\Models\Mention::all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $m): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($m->id); ?>"><?php echo e($m->nom); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                    <div style="font-size:12px; color:#6b7280; margin-top:6px;">Maintenez Ctrl (ou Cmd) pour sélectionner plusieurs mentions.</div>
                </div>
                
                <!-- Exporter tous -->
                <div style="background:linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 100%); border:2px solid #bae6fd; border-radius:12px; padding:16px; margin-bottom:24px;">
                    <label style="display:flex; align-items:center; gap:12px; cursor:pointer; user-select:none;">
                        <input type="checkbox" name="export_all" value="1" class="modal-checkbox" style="width:20px; height:20px; border:2px solid #94a3b8; border-radius:4px; cursor:pointer; transition:all 0.2s;">
                        <div>
                            <span style="font-size:15px; font-weight:600; color:#0c4a6e; display:block;">Exporter tous les étudiants</span>
                            <span style="font-size:13px; color:#0369a1;">Ignorer les filtres et exporter l'intégralité de la base</span>
                        </div>
                    </label>
                </div>
                
                    <!-- Choix des champs à exporter -->
                    <div style="margin-bottom:20px;">
                        <label style="display:block; font-size:14px; font-weight:600; color:#374151; margin-bottom:8px;">
                            <i class="fas fa-columns" style="color:#0ea5e9; margin-right:6px;"></i>
                            Champs à choisir
                        </label>
                        <div style="font-size:13px; color:#374151; margin-bottom:8px;">Matricule et Nom et Prénom sont toujours inclus par défaut.</div>
                        <div style="display:flex; gap:12px; flex-wrap:wrap;">
                            <label style="display:flex; align-items:center; gap:8px; font-size:13px; color:#374151;">
                                <input type="checkbox" name="fields[]" value="email" style="width:16px; height:16px;">
                                Email
                            </label>
                            <label style="display:flex; align-items:center; gap:8px; font-size:13px; color:#374151;">
                                <input type="checkbox" name="fields[]" value="plain_password" style="width:16px; height:16px;">
                                Mot de passe
                            </label>
                            <label style="display:flex; align-items:center; gap:8px; font-size:13px; color:#374151;">
                                <input type="checkbox" name="fields[]" value="telephone" style="width:16px; height:16px;">
                                Téléphone
                            </label>
                            <label style="display:flex; align-items:center; gap:8px; font-size:13px; color:#374151;">
                                <input type="checkbox" name="fields[]" value="religion" style="width:16px; height:16px;">
                                Religion
                            </label>
                            <label style="display:flex; align-items:center; gap:8px; font-size:13px; color:#374151;">
                                <input type="checkbox" name="fields[]" value="abonne_caf" style="width:16px; height:16px;">
                                Abonné CAF
                            </label>
                            <label style="display:flex; align-items:center; gap:8px; font-size:13px; color:#374151;">
                                <input type="checkbox" name="fields[]" value="statut_interne" style="width:16px; height:16px;">
                                Statut interne
                            </label>
                            <label style="display:flex; align-items:center; gap:8px; font-size:13px; color:#374151;">
                                <input type="checkbox" name="fields[]" value="taille" style="width:16px; height:16px;">
                                Taille
                            </label>
                        </div>
                    </div>
                
                <!-- Buttons -->
                <div style="display:flex; gap:12px; justify-content:flex-end;">
                    <button type="button" onclick="closeExportModal()" class="modal-btn-cancel" style="padding:12px 24px; border:2px solid #e5e7eb; border-radius:8px; font-size:15px; font-weight:600; color:#6b7280; background:#fff; cursor:pointer; transition:all 0.2s;">
                        Annuler
                    </button>
                    <button type="button" onclick="submitExportForm()" class="modal-btn-export" style="padding:12px 32px; border:none; border-radius:8px; font-size:15px; font-weight:600; color:#fff; background:linear-gradient(135deg, #0c32dc 0%, #4b54a2 100%); cursor:pointer; transition:all 0.2s; box-shadow:0 4px 12px rgba(102, 126, 234, 0.3); display:flex; align-items:center; gap:8px;">
                        <i class="fas fa-download"></i>
                        Exporter
                    </button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
<?php /**PATH D:\PROJET REGISTRAIRE\registrarClone\registrar\resources\views/superadmin/dashboard.blade.php ENDPATH**/ ?>