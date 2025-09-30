<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Détails Finances - Université Adventiste Zurcher</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link href="https://fonts.googleapis.com/css2?family=Work+Sans:wght@300;400;500;600;700&family=Open+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { 
            font-family: 'Work Sans', sans-serif; 
            background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
        }
        .sidebar { width: 260px; transition: all 0.3s; }
        .main-content { margin-left: 260px; transition: all 0.3s; }
        @media (max-width: 768px) {
            .sidebar { margin-left: -260px; }
            .main-content { margin-left: 0; }
            .sidebar.active { margin-left: 0; }
        }
        .nav-item:hover { background-color: rgba(255, 255, 255, 0.1); }
        
        /* Added modern toast notification styles */
        .toast-container {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 9999;
        }
        
        .toast {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            color: white;
            padding: 16px 20px;
            border-radius: 12px;
            box-shadow: 0 10px 25px rgba(16, 185, 129, 0.3);
            margin-bottom: 10px;
            transform: translateX(400px);
            opacity: 0;
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            min-width: 300px;
        }
        
        .toast.show {
            transform: translateX(0);
            opacity: 1;
        }
        
        .toast.hide {
            transform: translateX(400px);
            opacity: 0;
        }
        
        .toast-content {
            display: flex;
            align-items: center;
            gap: 12px;
        }
        
        .toast-icon {
            font-size: 20px;
            animation: pulse 2s infinite;
        }
        
        @keyframes pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.1); }
        }
        
        /* Enhanced table and card styles */
        .finance-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 16px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            animation: slideUp 0.6s ease-out;
        }
        
        .finance-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 40px rgba(0, 0, 0, 0.15);
        }
        
        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .table-header {
            background: linear-gradient(135deg, #1e40af 0%, #3b82f6 100%);
            position: relative;
            overflow: hidden;
        }
        
        .table-header::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.1), transparent);
            animation: shimmer 3s infinite;
        }
        
        @keyframes shimmer {
            0% { left: -100%; }
            100% { left: 100%; }
        }
        
        .table-row {
            transition: all 0.3s ease;
            border-bottom: 1px solid rgba(226, 232, 240, 0.5);
        }
        
        .table-row:hover {
            background: linear-gradient(135deg, rgba(59, 130, 246, 0.05) 0%, rgba(147, 197, 253, 0.05) 100%);
            transform: scale(1.01);
        }
        
        .action-btn {
            transition: all 0.3s ease;
            padding: 8px 12px;
            border-radius: 8px;
            font-weight: 500;
        }
        
        .action-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }
        
        .btn-view:hover { background: rgba(59, 130, 246, 0.1); }
        .btn-edit:hover { background: rgba(245, 158, 11, 0.1); }
        .btn-delete:hover { background: rgba(239, 68, 68, 0.1); }
        
        .header-section {
            background: linear-gradient(135deg, #1e40af 0%, #3b82f6 100%);
            color: white;
            padding: 24px;
            border-radius: 16px 16px 0 0;
            position: relative;
            overflow: hidden;
        }
        
        .header-section::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255, 255, 255, 0.1) 0%, transparent 70%);
            animation: float 6s ease-in-out infinite;
        }
        
        @keyframes float {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-20px) rotate(180deg); }
        }
    </style>
</head>
<body>
    <?php echo $__env->make('superadmin.components.sidebar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <div class="main-content min-h-screen">
        <?php echo $__env->make('superadmin.components.header', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        <main class="p-6">
            <!-- Added toast container for notifications -->
            <div class="toast-container" id="toastContainer"></div>
            
            <div class="finance-card overflow-hidden">
                <div class="header-section">
                    <div class="flex items-center justify-between relative z-10">
                        <div>
                            <h1 class="text-3xl font-bold mb-2">Liste des détails finances</h1>
                            <p class="text-blue-100">Gestion des frais universitaires</p>
                        </div>
                        
                    </div>
                </div>
                
                <div class="overflow-x-auto">
                    <table class="min-w-full">
                        <thead class="table-header">
                            <tr class="relative z-10">
                                <th class="px-6 py-4 text-left text-sm font-semibold text-white uppercase tracking-wider">ID</th>
                                <th class="px-6 py-4 text-left text-sm font-semibold text-white uppercase tracking-wider">Type de frais</th>
                                <th class="px-6 py-4 text-left text-sm font-semibold text-white uppercase tracking-wider">Mention</th>
                                <th class="px-6 py-4 text-left text-sm font-semibold text-white uppercase tracking-wider">Niveau d'étude</th>
                                <th class="px-6 py-4 text-left text-sm font-semibold text-white uppercase tracking-wider">Année académique</th>
                                <th class="px-6 py-4 text-left text-sm font-semibold text-white uppercase tracking-wider">Semestre</th>
                                <th class="px-6 py-4 text-left text-sm font-semibold text-white uppercase tracking-wider">Coût</th>
                                <th class="px-6 py-4 text-left text-sm font-semibold text-white uppercase tracking-wider">Notes</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white">
                            <?php $__empty_1 = true; $__currentLoopData = $details; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $detail): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <tr class="table-row cursor-pointer" style="animation-delay: <?php echo e($index * 0.02); ?>s">
                                    <td class="px-6 py-4 whitespace-nowrap font-medium text-gray-900"><?php echo e($detail->id); ?></td>
                                    <td class="px-6 py-4 whitespace-nowrap text-gray-700"><?php echo e($detail->feeType ? $detail->feeType->name : ($detail->fee_type_id ?? '-')); ?></td>
                                    <td class="px-6 py-4 whitespace-nowrap text-gray-700"><?php echo e($detail->mention ? $detail->mention->nom : '-'); ?></td>
                                    <td class="px-6 py-4 whitespace-nowrap text-gray-700"><?php echo e($detail->yearLevel ? $detail->yearLevel->label : ($detail->year_level_id ?? '-')); ?></td>
                                    <td class="px-6 py-4 whitespace-nowrap text-gray-700"><?php echo e($detail->academicYear ? $detail->academicYear->libelle : ($detail->academic_year_id ?? '-')); ?></td>
                                    <td class="px-6 py-4 whitespace-nowrap text-gray-700"><?php echo e($detail->semester ? $detail->semester->nom : ($detail->semester_id ?? '-')); ?></td>
                                    <td class="px-6 py-4 whitespace-nowrap text-gray-700 font-semibold"><?php echo e(number_format($detail->amount ?? 0, 0, ',', ' ')); ?> Ar</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-gray-700"><?php echo e($detail->notes ?? '-'); ?></td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <tr>
                                    <td colspan="8" class="px-6 py-12 text-center">
                                        <div class="text-gray-400">
                                            <i class="fas fa-inbox text-4xl mb-4"></i>
                                            <p class="text-lg font-medium">Aucun détail finance trouvé</p>
                                            <p class="text-sm">Commencez par ajouter un nouveau détail finance</p>
                                        </div>
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>

    <!-- Added JavaScript for toast notifications -->
    <script>
        // Function to show toast notification
        function showToast(message, type = 'success') {
            const toastContainer = document.getElementById('toastContainer');
            const toast = document.createElement('div');
            toast.className = 'toast';
            
            const iconClass = type === 'success' ? 'fas fa-check-circle' : 'fas fa-exclamation-circle';
            
            toast.innerHTML = `
                <div class="toast-content">
                    <i class="${iconClass} toast-icon"></i>
                    <span>${message}</span>
                </div>
            `;
            
            toastContainer.appendChild(toast);
            
            // Show toast with animation
            setTimeout(() => {
                toast.classList.add('show');
            }, 100);
            
            // Hide toast after 5 seconds
            setTimeout(() => {
                toast.classList.add('hide');
                setTimeout(() => {
                    if (toast.parentNode) {
                        toast.parentNode.removeChild(toast);
                    }
                }, 400);
            }, 5000);
        }
        
        // Check for Laravel session messages and show toast
        <?php if(session('success')): ?>
            document.addEventListener('DOMContentLoaded', function() {
                showToast("<?php echo e(session('success')); ?>", 'success');
            });
        <?php endif; ?>
        
        <?php if(session('error')): ?>
            document.addEventListener('DOMContentLoaded', function() {
                showToast("<?php echo e(session('error')); ?>", 'error');
            });
        <?php endif; ?>
    </script>
</body>
</html>
<?php /**PATH D:\PROJET REGISTRAIRE\registrarClone\registrar\resources\views/superadmin/financedetails/index.blade.php ENDPATH**/ ?>