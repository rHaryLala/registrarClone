<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Complatable - Université Adventiste Zurcher</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="icon" type="image/png" href="/favicon.png">
    <style>
        * {
            font-family: 'Inter', sans-serif;
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

        @keyframes modalFadeIn {
            from {
                opacity: 0;
                transform: scale(0.9);
            }
            to {
                opacity: 1;
                transform: scale(1);
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

        /* Modern table styles and search styling borrowed from superadmin list view */
        .modern-table {
            background: rgba(255, 255, 255, 0.98);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(226, 232, 240, 0.5);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.08);
            border-radius: 16px;
            overflow: hidden;
            animation: fadeInUp 0.6s ease-out forwards;
        }

        .search-container {
            background: linear-gradient(135deg, #1e40af 0%, #3b82f6 100%);
        }

        .modern-input {
            transition: all 0.3s ease;
            border: 2px solid #e5e7eb;
            background: white;
        }
        .modern-input:focus {
            border-color: #1e40af;
            box-shadow: 0 0 0 3px rgba(30, 64, 175, 0.1);
        }

        .modern-select {
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%236b7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='m6 8 4 4 4-4'/%3e%3c/svg%3e");
            background-position: right 0.5rem center;
            background-repeat: no-repeat;
            background-size: 1.5em 1.5em;
            padding-right: 2.5rem;
        }

        .student-card {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            border-left: 4px solid transparent;
        }
        .student-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
            border-left-color: #1e40af;
        }

        .table-row {
            transition: all 0.3s ease;
            border-bottom: 1px solid rgba(226, 232, 240, 0.3);
        }

        .table-row:hover {
            background: linear-gradient(135deg, rgba(59, 130, 246, 0.02) 0%, rgba(147, 197, 253, 0.05) 100%);
            transform: translateX(4px);
        }

        .table-row:last-child {
            border-bottom: none;
        }

        /* Modern checkbox styles */
        .modern-checkbox {
            appearance: none;
            width: 20px;
            height: 20px;
            border: 2px solid #d1d5db;
            border-radius: 6px;
            background: white;
            cursor: pointer;
            transition: all 0.3s ease;
            position: relative;
        }

        .modern-checkbox:checked {
            background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
            border-color: #3b82f6;
        }

        .modern-checkbox:checked::after {
            content: '✓';
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            color: white;
            font-size: 12px;
            font-weight: bold;
        }

        .modern-checkbox:hover {
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }

        /* Modal styles */
        .modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.5);
            backdrop-filter: blur(4px);
            z-index: 9999;
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
        }

        .modal-overlay.active {
            opacity: 1;
            visibility: visible;
        }

        .modal-content {
            background: white;
            border-radius: 16px;
            padding: 32px;
            max-width: 480px;
            width: 90%;
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.25);
            transform: scale(0.9);
            transition: all 0.3s ease;
            animation: modalFadeIn 0.3s ease-out forwards;
        }

        .modal-overlay.active .modal-content {
            transform: scale(1);
        }

        /* Badge styles */
        .status-badge {
            display: inline-flex;
            align-items: center;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .status-verified {
            background: linear-gradient(135deg, #dcfce7 0%, #bbf7d0 100%);
            color: #166534;
            border: 1px solid #22c55e;
        }

        .status-pending {
            background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
            color: #92400e;
            border: 1px solid #f59e0b;
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

            .modern-table {
                margin: 0 -16px;
                border-radius: 0;
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
        <div class="sidebar">
            <?php echo $__env->make('accountant.components.sidebar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        </div>

        <div class="main-content">
            <div class="header sticky top-0 z-50">
                <?php echo $__env->make('accountant.components.header', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
            </div>

            <main class="p-8 space-y-8">
                        <div class="mb-8">
                            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
                                <div>
                                    <h1 class="text-3xl font-bold text-gray-900 mb-2">Liste des étudiants</h1>
                                    <p class="text-gray-600">Gestion des frais de scolarité et vérifications</p>
                                </div>
                            </div>
                            <!-- Modern search and filter section (matches superadmin appearance) -->
                            <div class="search-container rounded-2xl p-6 mb-6 shadow-lg">
                                <form method="get" id="searchForm" onsubmit="return false;" class="space-y-4">
                                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                                        <div class="md:col-span-2">
                                            <label for="searchInputAccountant" class="block text-sm font-medium text-white mb-2">
                                                <i class="fas fa-search mr-2"></i>Rechercher des étudiants
                                            </label>
                                            <input type="text" 
                                                   name="q" 
                                                   id="searchInputAccountant" 
                                                   placeholder="Nom, prénom, matricule, email..." 
                                                   class="modern-input w-full px-4 py-3 rounded-xl border-0 focus:ring-0 text-gray-900 placeholder-gray-500"
                                                   autocomplete="off" />
                                        </div>
                                        <div class="md:col-span-2 flex items-center justify-end">
                                            <div class="bg-white rounded-lg px-4 py-2 shadow-sm border border-slate-200">
                                                <span class="text-sm text-slate-500">Total étudiants:</span>
                                                <span class="font-semibold text-slate-800 ml-2"><?php echo e(count($students ?? [])); ?></span>
                                            </div>
                                            <button type="button" id="clearSearchBtn" class="ml-4 text-white bg-slate-700 hover:bg-slate-600 px-4 py-2 rounded-xl">Effacer</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>

                <div class="desktop-table bg-white rounded-2xl shadow-lg overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="min-w-full" id="studentsTable">
                            <thead class="bg-blue-800">
                                <tr>
                                    <th class="px-6 py-4 text-left text-sm font-semibold text-white uppercase tracking-wider">Matricule</th>
                                    <th class="px-6 py-4 text-left text-sm font-semibold text-white uppercase tracking-wider">N° Compte</th>
                                    <th class="px-6 py-4 text-left text-sm font-semibold text-white uppercase tracking-wider">Nom</th>
                                    <th class="px-6 py-4 text-left text-sm font-semibold text-white uppercase tracking-wider">Prénom</th>
                                    <th class="px-6 py-4 text-left text-sm font-semibold text-white uppercase tracking-wider">Validation Frais</th>
                                </tr>
                            </thead>
                            <tbody id="studentsTableBody" class="bg-white divide-y divide-slate-100">
                                <?php $__empty_1 = true; $__currentLoopData = $students ?? collect(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $student): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <tr class="hover:bg-blue-50 transition-colors duration-200">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-blue-600 rounded-full flex items-center justify-center text-white font-semibold text-sm mr-3">
                                                    <?php echo e(substr($student->nom ?? 'N', 0, 1)); ?><?php echo e(substr($student->prenom ?? 'A', 0, 1)); ?>

                                                </div>
                                                <span class="text-sm font-medium text-slate-800"><?php echo e($student->matricule ?? '-'); ?></span>
                                            </div>
                                        </td>

                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="text-sm text-slate-600 font-mono bg-slate-50 px-2 py-1 rounded"><?php echo e($student->account_code ?? '-'); ?></span>
                                        </td>

                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="text-sm font-medium text-slate-800"><?php echo e($student->nom); ?></span>
                                        </td>

                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="text-sm text-slate-600"><?php echo e($student->prenom); ?></span>
                                        </td>

                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center space-x-3">
                                                <input 
                                                    type="checkbox" 
                                                    class="modern-checkbox fee-check-checkbox" 
                                                    data-student-id="<?php echo e($student->id); ?>"
                                                    data-student-name="<?php echo e($student->nom); ?> <?php echo e($student->prenom); ?>"
                                                    <?php echo e($student->fee_check ? 'checked' : ''); ?>

                                                />
                                                <?php if($student->fee_check): ?>
                                                    <span class="status-badge status-verified">
                                                        <i class="fas fa-check-circle mr-1"></i>
                                                        Vérifié
                                                    </span>
                                                <?php else: ?>
                                                    <span class="status-badge status-pending">
                                                        <i class="fas fa-clock mr-1"></i>
                                                        En attente
                                                    </span>
                                                <?php endif; ?>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <tr>
                                        <td colspan="5" class="px-6 py-12 text-center">
                                            <div class="flex flex-col items-center">
                                                <i class="fas fa-users text-4xl text-gray-300 mb-4"></i>
                                                <p class="text-gray-500 text-lg font-medium">Aucun étudiant trouvé</p>
                                                <p class="text-gray-400 text-sm">Il n'y a actuellement aucun étudiant dans la base de données.</p>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Mobile cards layout like superadmin list -->
                <div class="mobile-cards space-y-4" id="mobileCards">
                    
                </div>
            </main>
        </div>
    </div>

    <div id="confirmationModal" class="modal-overlay">
        <div class="modal-content">
            <div class="text-center">
                <div class="w-16 h-16 bg-gradient-to-br from-amber-400 to-orange-500 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-exclamation-triangle text-white text-xl"></i>
                </div>
                <h3 class="text-xl font-semibold text-slate-800 mb-2">Confirmation requise</h3>
                <p class="text-slate-600 mb-6" id="confirmationMessage">
                    Êtes-vous sûr de vouloir modifier le statut de vérification des frais pour cet étudiant ?
                </p>
                <div class="flex space-x-3 justify-center">
                    <button 
                        id="cancelButton" 
                        class="px-6 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-lg font-medium transition-colors"
                    >
                        Annuler
                    </button>
                    <button 
                        id="confirmButton" 
                        class="px-6 py-2 bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white rounded-lg font-medium transition-all shadow-lg hover:shadow-xl"
                    >
                        Confirmer
                    </button>
                </div>
            </div>
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

    <script>
        // CSRF token from meta tag or blade directive
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '<?php echo e(csrf_token()); ?>';
        
        // Modal elements
        const modal = document.getElementById('confirmationModal');
        const confirmationMessage = document.getElementById('confirmationMessage');
        const cancelButton = document.getElementById('cancelButton');
        const confirmButton = document.getElementById('confirmButton');
        
        let currentCheckbox = null;
        let originalState = false;

        // Modal functions
        function showModal(checkbox, studentName, newState) {
            currentCheckbox = checkbox;
            originalState = !newState;
            
            const action = newState ? 'marquer comme vérifié' : 'retirer la vérification de';
            confirmationMessage.textContent = `Êtes-vous sûr de vouloir ${action} les frais de ${studentName} ?`;
            
            modal.classList.add('active');
            document.body.style.overflow = 'hidden';
        }

        function hideModal() {
            modal.classList.remove('active');
            document.body.style.overflow = '';
            currentCheckbox = null;
        }

        // Modal event listeners
        cancelButton.addEventListener('click', () => {
            if (currentCheckbox) {
                currentCheckbox.checked = originalState;
            }
            hideModal();
        });

        confirmButton.addEventListener('click', async () => {
            if (currentCheckbox) {
                await updateFeeCheck(currentCheckbox);
            }
            hideModal();
        });

        // Close modal on overlay click
        modal.addEventListener('click', (e) => {
            if (e.target === modal) {
                if (currentCheckbox) {
                    currentCheckbox.checked = originalState;
                }
                hideModal();
            }
        });

        // Close modal on Escape key
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape' && modal.classList.contains('active')) {
                if (currentCheckbox) {
                    currentCheckbox.checked = originalState;
                }
                hideModal();
            }
        });

        // Fee check update function
        async function updateFeeCheck(checkbox) {
            const studentId = checkbox.dataset.studentId;
            const checked = checkbox.checked ? 1 : 0;

            try {
                const res = await fetch(`/accountant/students/${studentId}/fee-check`, {
                    method: 'PATCH',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({ fee_check: checked })
                });

                if (!res.ok) throw new Error('Network response was not ok');
                const json = await res.json();
                
                // Update the status badge — find the enclosing table row first (works for table layout)
                const row = checkbox.closest('tr') || checkbox.closest('.table-row');
                const statusBadge = row ? row.querySelector('.status-badge') : null;

                if (statusBadge) {
                    if (checked) {
                        statusBadge.className = 'status-badge status-verified';
                        statusBadge.innerHTML = '<i class="fas fa-check-circle mr-1"></i>Vérifié';
                    } else {
                        statusBadge.className = 'status-badge status-pending';
                        statusBadge.innerHTML = '<i class="fas fa-clock mr-1"></i>En attente';
                    }
                }
                
                // Show success feedback
                showToast('Statut mis à jour avec succès', 'success');
                
            } catch (err) {
                console.error(err);
                showToast('Impossible de mettre à jour le statut', 'error');
                // Revert checkbox
                checkbox.checked = !checkbox.checked;
            }
        }

        // Checkbox event listeners with modal confirmation
        document.querySelectorAll('.fee-check-checkbox').forEach(checkbox => {
            checkbox.addEventListener('change', function(e) {
                e.preventDefault();
                
                const studentName = this.dataset.studentName;
                const newState = this.checked;
                
                showModal(this, studentName, newState);
            });
        });

        // Toast notification function
        function showToast(message, type = 'info') {
            const toast = document.createElement('div');
            toast.className = `fixed top-4 right-4 z-50 px-6 py-3 rounded-lg shadow-lg text-white font-medium transition-all duration-300 transform translate-x-full`;
            
            if (type === 'success') {
                toast.classList.add('bg-green-500');
                toast.innerHTML = `<i class="fas fa-check-circle mr-2"></i>${message}`;
            } else if (type === 'error') {
                toast.classList.add('bg-red-500');
                toast.innerHTML = `<i class="fas fa-exclamation-circle mr-2"></i>${message}`;
            } else {
                toast.classList.add('bg-blue-500');
                toast.innerHTML = `<i class="fas fa-info-circle mr-2"></i>${message}`;
            }
            
            document.body.appendChild(toast);
            
            // Animate in
            setTimeout(() => {
                toast.classList.remove('translate-x-full');
            }, 100);
            
            // Animate out and remove
            setTimeout(() => {
                toast.classList.add('translate-x-full');
                setTimeout(() => {
                    document.body.removeChild(toast);
                }, 300);
            }, 3000);
        }
    </script>
    <script>
        // Client-side search for accountant dashboard
        (function() {
            const input = document.getElementById('searchInputAccountant');
            const clearBtn = document.getElementById('clearSearchBtn');
            const table = document.querySelector('table.min-w-full');
            if (!input || !table) return;

            const tbody = table.querySelector('tbody');

            // Create a no-results row if it doesn't exist
            let noResultsRow = tbody.querySelector('.no-results-row');
            if (!noResultsRow) {
                noResultsRow = document.createElement('tr');
                noResultsRow.className = 'no-results-row';
                noResultsRow.innerHTML = `<td colspan="5" class="px-6 py-12 text-center hidden" id="accountantNoResults">
                        <div class="flex flex-col items-center">
                            <i class="fas fa-users text-4xl text-gray-300 mb-4"></i>
                            <p class="text-gray-500 text-lg font-medium">Aucun étudiant trouvé</p>
                            <p class="text-gray-400 text-sm">Essayez de modifier vos critères de recherche</p>
                        </div>
                    </td>`;
                tbody.appendChild(noResultsRow);
            }

            function normalize(s) {
                return (s || '').toString().toLowerCase().normalize('NFD').replace(/\p{Diacritic}/gu, '');
            }

            function filterRows() {
                const q = normalize(input.value.trim());
                const rows = Array.from(tbody.querySelectorAll('tr')).filter(r => !r.classList.contains('no-results-row'));
                let visible = 0;

                rows.forEach(row => {
                    // Extract searchable values from cells: matricule, account_code, nom, prenom
                    const cells = row.querySelectorAll('td');
                    const matricule = normalize(cells[0]?.textContent || '');
                    const accountCode = normalize(cells[1]?.textContent || '');
                    const nom = normalize(cells[2]?.textContent || '');
                    const prenom = normalize(cells[3]?.textContent || '');

                    const haystack = [matricule, accountCode, nom, prenom].join(' ');
                    const match = !q || haystack.includes(q);

                    if (match) {
                        row.style.display = '';
                        visible++;
                    } else {
                        row.style.display = 'none';
                    }
                });

                const noResultsCell = tbody.querySelector('#accountantNoResults');
                if (noResultsCell) {
                    if (visible === 0) {
                        noResultsCell.classList.remove('hidden');
                    } else {
                        noResultsCell.classList.add('hidden');
                    }
                }
            }

            input.addEventListener('input', filterRows);
            clearBtn.addEventListener('click', function() {
                input.value = '';
                input.focus();
                filterRows();
            });
        })();
    </script>
</body>
</html>
<?php /**PATH D:\PROJET REGISTRAIRE\registrarClone\registrar\resources\views/accountant/dashboard.blade.php ENDPATH**/ ?>