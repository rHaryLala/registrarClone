<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter un cours à l'étudiant</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link href="https://fonts.googleapis.com/css2?family=Work+Sans:wght@300;400;500;600;700&family=Open+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="icon" type="image/png" href="/favicon.png">
    <style>
        body { 
            font-family: 'Work Sans', sans-serif; 
            /* Uniformisation de l'arrière-plan avec un seul gradient bleu cohérent */
            background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
            min-height: 100vh;
        }
        .sidebar { width: 260px; transition: all 0.3s; }
        .main-content { margin-left: 260px; transition: all 0.3s; }
        @media (max-width: 768px) {
            .sidebar { margin-left: -260px; }
            .main-content { margin-left: 0; }
            .sidebar.active { margin-left: 0; }
        }

        /* Ajout d'animations et effets modernes */
        .hero-section {
            background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 50%, #06b6d4 100%);
            position: relative;
            overflow: hidden;
        }

        .hero-section::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
            animation: float 20s ease-in-out infinite;
        }

        .floating-shape {
            position: absolute;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.1);
            animation: float 15s ease-in-out infinite;
        }

        .floating-shape:nth-child(1) {
            width: 80px;
            height: 80px;
            top: 20%;
            left: 10%;
            animation-delay: -2s;
        }

        .floating-shape:nth-child(2) {
            width: 120px;
            height: 120px;
            top: 60%;
            right: 15%;
            animation-delay: -8s;
        }

        .floating-shape:nth-child(3) {
            width: 60px;
            height: 60px;
            bottom: 20%;
            left: 20%;
            animation-delay: -15s;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            33% { transform: translateY(-20px) rotate(120deg); }
            66% { transform: translateY(10px) rotate(240deg); }
        }

        .glass-card {
            /* Uniformisation du background des cartes avec transparence cohérente */
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
        }

        .course-item {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            border: 2px solid transparent;
            /* Uniformisation du background des items de cours */
            background: rgba(255, 255, 255, 0.8);
        }

        .course-item:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px -5px rgba(59, 130, 246, 0.3);
            border-color: rgba(59, 130, 246, 0.3);
            /* Background hover uniforme */
            background: rgba(255, 255, 255, 0.95);
        }

        .course-item-compact {
            padding: 12px 16px !important;
        }

        .course-item-compact h3 {
            font-size: 16px !important;
        }

        .course-item-compact p {
            font-size: 14px !important;
        }

        .course-checkbox {
            appearance: none;
            width: 18px;
            height: 18px;
            border: 2px solid #d1d5db;
            border-radius: 6px;
            position: relative;
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .course-checkbox:checked {
            background: linear-gradient(135deg, #3b82f6, #1d4ed8);
            border-color: #3b82f6;
            transform: scale(1.1);
        }

        .course-checkbox:checked::after {
            content: '✓';
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            color: white;
            font-size: 12px;
            font-weight: bold;
        }

        .modern-button {
            background: linear-gradient(135deg, #1e40af 0%, #3b82f6 50%, #06b6d4 100%);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
        }

        .modern-button::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
            transition: left 0.5s;
        }

        .modern-button:hover::before {
            left: 100%;
        }

        .modern-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 15px 35px -5px rgba(59, 130, 246, 0.4);
        }

        .fade-in {
            opacity: 0;
            transform: translateY(30px);
            animation: fadeInUp 0.8s ease-out forwards;
        }

        .fade-in-delay-1 { animation-delay: 0.2s; }
        .fade-in-delay-2 { animation-delay: 0.4s; }
        .fade-in-delay-3 { animation-delay: 0.6s; }

        @keyframes fadeInUp {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .course-item {
            animation: slideInLeft 0.6s ease-out forwards;
            opacity: 0;
            transform: translateX(-30px);
        }

        @keyframes slideInLeft {
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        /* Ajout du style pour le bouton "Tout cocher" */
        .select-all-button {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
        }

        .select-all-button::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
            transition: left 0.5s;
        }

        .select-all-button:hover::before {
            left: 100%;
        }

        .select-all-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 15px 35px -5px rgba(16, 185, 129, 0.4);
        }
    </style>
</head>
<body class="bg-gradient-to-br from-slate-50 to-blue-50">
    <?php echo $__env->make('dean.components.sidebar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <div class="main-content min-h-screen">
        <?php echo $__env->make('dean.components.header', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        
        <!-- Hero section modernisée avec animations -->
        <div class="hero-section py-12 mb-8 relative">
            <div class="floating-shape"></div>
            <div class="floating-shape"></div>
            <div class="floating-shape"></div>
            
            <div class="max-w-4xl mx-auto px-6 relative z-10">
                <div class="flex items-center justify-between fade-in">
                    <div>
                        <h1 class="text-4xl font-bold text-white mb-2">
                            <i class="fas fa-plus-circle mr-3 text-blue-200"></i>
                            Ajouter des cours
                        </h1>
                        <p class="text-blue-100 text-lg">
                            Sélectionnez les cours pour <?php echo e($student->prenom); ?> <?php echo e($student->nom); ?>

                        </p>
                    </div>
                    <a href="<?php echo e(route('dean.students.show', $student->id)); ?>" 
                       class="bg-white/20 backdrop-blur-sm text-white px-6 py-3 rounded-xl hover:bg-white/30 transition-all duration-300 flex items-center space-x-2 border border-white/20">
                        <i class="fas fa-arrow-left"></i>
                        <span class="font-medium">Retour</span>
                    </a>
                </div>
            </div>
        </div>

        <main class="px-6 pb-12">
            <div class="max-w-4xl mx-auto">
                <!-- Carte modernisée avec effet de verre -->
                <div class="glass-card rounded-2xl p-8 fade-in fade-in-delay-1">
                    <form action="<?php echo e(route('dean.students.courses.store', $student->id)); ?>" method="POST">
                        <?php echo csrf_field(); ?>
                        
                        <div class="mb-8 fade-in fade-in-delay-2">
                            <div class="flex items-center mb-6">
                                <div class="w-12 h-12 bg-gradient-to-r from-blue-500 to-cyan-500 rounded-xl flex items-center justify-center mr-4">
                                    <i class="fas fa-book text-white text-xl"></i>
                                </div>
                                <div class="flex-1">
                                    <h2 class="text-2xl font-bold text-gray-800">Cours disponibles</h2>
                                    <p class="text-gray-600">Cochez les cours que vous souhaitez ajouter</p>
                                </div>
                                <!-- Ajout du bouton "Tout cocher" -->
                                <button type="button" 
                                        id="selectAllBtn" 
                                        class="select-all-button text-white px-4 py-2 rounded-lg font-medium text-sm flex items-center space-x-2 relative z-10">
                                    <i class="fas fa-check-double"></i>
                                    <span>Tout cocher</span>
                                </button>
                            </div>
                            
                            <!-- Liste modernisée avec animations -->
                            <div class="grid gap-3">
                                <?php $__currentLoopData = $courses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $course): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <!-- Ajout de la classe compact pour réduire la taille -->
                             <div class="course-item course-item-compact rounded-xl border-2 border-transparent hover:border-blue-200" 
                                 style="animation-delay: <?php echo e($index * 0.1); ?>s" data-credits="<?php echo e($course->credits); ?>">
                                        <label for="course_<?php echo e($course->id); ?>" class="flex items-center gap-3 cursor-pointer">
                                            <input type="checkbox" 
                                                   name="course_id[]" 
                                                   value="<?php echo e($course->id); ?>" 
                                                   id="course_<?php echo e($course->id); ?>" 
                                                   class="course-checkbox">
                                            
                                            <div class="flex-1">
                                                <div class="flex items-center gap-3 mb-1">
                                                    <span class="bg-blue-100 text-blue-800 px-2 py-1 rounded-full text-xs font-semibold">
                                                        <?php echo e($course->sigle); ?>

                                                    </span>
                                                    <!-- Réduction de la taille du titre -->
                                                    <h3 class="font-semibold text-gray-800 text-base"><?php echo e($course->nom); ?></h3>
                                                    <!-- Afficher le nombre de crédits -->
                                                    <span class="bg-gray-100 text-gray-800 px-2 py-1 rounded-full text-xs font-semibold ml-2">
                                                        <?php echo e($course->credits); ?> cr
                                                    </span>
                                                </div>
                                                <!-- Réduction de la taille du texte -->
                                                <p class="text-gray-600 flex items-center text-sm">
                                                    <i class="fas fa-graduation-cap mr-2 text-gray-400"></i>
                                                    <?php if($course->mention): ?>
                                                        <?php if(isset($course->mentions) && $course->mentions->count()): ?>
                                                            <?php echo e($course->mentions->pluck('nom')->join(', ')); ?>

                                                        <?php else: ?>
                                                            <?php echo e($course->mention->nom ?? 'Mention non définie'); ?>

                                                        <?php endif; ?>
                                                    <?php elseif(isset($course->mentions) && $course->mentions->count()): ?>
                                                        <?php echo e($course->mentions->pluck('nom')->join(', ')); ?>

                                                    <?php else: ?>
                                                        <span class="text-gray-400">Mention non définie</span>
                                                    <?php endif; ?>
                                                </p>
                                            </div>
                                            
                                            <div class="text-blue-500">
                                                <i class="fas fa-chevron-right transition-transform duration-300"></i>
                                            </div>
                                        </label>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        </div>
                            <!-- Totaux sélectionnés -->
                            <div class="mb-6 text-right fade-in fade-in-delay-3">
                                <p class="text-gray-700 font-medium">Cours sélectionnés: <span id="selectedCount">0</span></p>
                                <p class="text-gray-700 font-medium">Total crédits sélectionnés: <span id="totalCredits">0</span></p>
                            </div>
                        
                        <!-- Bouton modernisé avec effets -->
                        <div class="flex justify-end fade-in fade-in-delay-3">
                            <button type="submit" class="modern-button text-white px-8 py-4 rounded-xl font-semibold text-lg flex items-center space-x-3 relative z-10">
                                <i class="fas fa-plus"></i>
                                <span>Ajouter les cours sélectionnés</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </main>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const courseItems = document.querySelectorAll('.course-item');
            const selectAllBtn = document.getElementById('selectAllBtn');
            const checkboxes = document.querySelectorAll('.course-checkbox');
            let allSelected = false;
            
            selectAllBtn.addEventListener('click', function() {
                allSelected = !allSelected;
                
                checkboxes.forEach(checkbox => {
                    checkbox.checked = allSelected;
                    const item = checkbox.closest('.course-item');
                    
                    if (allSelected) {
                        /* Uniformisation des couleurs pour la sélection multiple */
                        item.style.background = 'rgba(219, 234, 254, 0.9)';
                        item.style.borderColor = '#3b82f6';
                    } else {
                        item.style.background = 'rgba(255, 255, 255, 0.8)';
                        item.style.borderColor = 'transparent';
                    }
                });
                
                // Mise à jour du texte du bouton
                const btnText = selectAllBtn.querySelector('span');
                const btnIcon = selectAllBtn.querySelector('i');
                
                if (allSelected) {
                    btnText.textContent = 'Tout décocher';
                    btnIcon.className = 'fas fa-times';
                    selectAllBtn.style.background = 'linear-gradient(135deg, #ef4444 0%, #dc2626 100%)';
                } else {
                    btnText.textContent = 'Tout cocher';
                    btnIcon.className = 'fas fa-check-double';
                    selectAllBtn.style.background = 'linear-gradient(135deg, #10b981 0%, #059669 100%)';
                }
                // Recalculate totals after toggling
                recalcTotals();
            });
            
            courseItems.forEach((item, index) => {
                const checkbox = item.querySelector('.course-checkbox');
                const chevron = item.querySelector('.fa-chevron-right');
                
                item.addEventListener('mouseenter', function() {
                    chevron.style.transform = 'translateX(5px)';
                });
                
                item.addEventListener('mouseleave', function() {
                    chevron.style.transform = 'translateX(0)';
                });
                
                checkbox.addEventListener('change', function() {
                    if (this.checked) {
                        /* Uniformisation des couleurs de sélection */
                        item.style.background = 'rgba(219, 234, 254, 0.9)';
                        item.style.borderColor = '#3b82f6';
                    } else {
                        item.style.background = 'rgba(255, 255, 255, 0.8)';
                        item.style.borderColor = 'transparent';
                    }
                    
                    const allChecked = Array.from(checkboxes).every(cb => cb.checked);
                    const noneChecked = Array.from(checkboxes).every(cb => !cb.checked);
                    
                    if (allChecked && !allSelected) {
                        allSelected = true;
                        const btnText = selectAllBtn.querySelector('span');
                        const btnIcon = selectAllBtn.querySelector('i');
                        btnText.textContent = 'Tout décocher';
                        btnIcon.className = 'fas fa-times';
                        selectAllBtn.style.background = 'linear-gradient(135deg, #ef4444 0%, #dc2626 100%)';
                    } else if (noneChecked && allSelected) {
                        allSelected = false;
                        const btnText = selectAllBtn.querySelector('span');
                        const btnIcon = selectAllBtn.querySelector('i');
                        btnText.textContent = 'Tout cocher';
                        btnIcon.className = 'fas fa-check-double';
                        selectAllBtn.style.background = 'linear-gradient(135deg, #10b981 0%, #059669 100%)';
                    }
                    // Recalculate totals after any individual change
                    recalcTotals();
                });
            });

            // Recalculate totals function
            function recalcTotals() {
                // Query checked checkboxes live from the DOM to avoid stale NodeList issues
                const selected = Array.from(document.querySelectorAll('.course-checkbox:checked'));
                const selectedCountEl = document.getElementById('selectedCount');
                const totalCreditsEl = document.getElementById('totalCredits');

                let totalCredits = 0;
                selected.forEach(cb => {
                    const item = cb.closest('.course-item');
                    const credits = Number(item && item.dataset && item.dataset.credits ? item.dataset.credits : 0) || 0;
                    totalCredits += credits;
                });

                selectedCountEl.textContent = selected.length;
                totalCreditsEl.textContent = totalCredits;
            }

            // Initial calc
            recalcTotals();
        });
    </script>
</body>
</html>
<?php /**PATH D:\PROJET REGISTRAIRE\registrarClone\registrar\resources\views/dean/students/courses-add.blade.php ENDPATH**/ ?>