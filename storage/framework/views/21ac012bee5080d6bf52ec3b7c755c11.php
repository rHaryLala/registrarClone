<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Frais étudiant | Université Adventiste Zurcher</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="icon" href="<?php echo e(url('public/favicon.png')); ?>" type="image/png">
    <style>
        body { font-family: 'Montserrat', sans-serif; }
        .sidebar { width: 260px; transition: all 0.3s; }
        .main-content { margin-left: 260px; transition: all 0.3s; }
        @media (max-width: 768px) { .sidebar { margin-left: -260px; } .main-content { margin-left: 0; } .sidebar.active { margin-left: 0; } }
        .nav-item:hover { background-color: rgba(255,255,255,0.1); }
        .stats-card { transition: transform 0.3s; }
        .stats-card:hover { transform: translateY(-5px); }
        /* Reuse a few animations from chief_accountant dashboard */
        @keyframes fadeInUp { from { opacity: 0; transform: translateY(30px); } to { opacity: 1; transform: translateY(0); } }
        .stats-card { animation: fadeInUp 0.6s ease-out; }
    </style>
</head>
<body class="bg-gray-100">
    <!-- Sidebar (reuse chief_accountant sidebar if available) -->
    <?php if ($__env->exists('chief_accountant.components.sidebar')) echo $__env->make('chief_accountant.components.sidebar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    <div class="main-content min-h-screen">
        <?php if ($__env->exists('chief_accountant.components.header')) echo $__env->make('chief_accountant.components.header', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

        
        <div class="p-6 max-w-7xl mx-auto">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div class="bg-white rounded-2xl p-6 shadow-lg border border-gray-100">
                    <div class="flex items-center">
                        <div class="p-4 rounded-xl bg-blue-50 text-blue-600 mr-4">
                            <i class="fas fa-file-invoice-dollar text-2xl"></i>
                        </div>
                        <div>
                            <p class="text-sm text-slate-500 uppercase font-semibold">Enregistrements de frais</p>
                            <h3 class="text-3xl font-bold text-slate-800 mt-1"><?php echo e(isset($fees) ? $fees->count() : 0); ?></h3>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-2xl p-6 shadow-lg border border-gray-100">
                    <div class="flex items-center">
                        <div class="p-4 rounded-xl bg-green-50 text-green-600 mr-4">
                            <i class="fas fa-coins text-2xl"></i>
                        </div>
                        <div>
                            <p class="text-sm text-slate-500 uppercase font-semibold">Montant total</p>
                            <h3 class="text-3xl font-bold text-slate-800 mt-1"><?php echo e(isset($fees) ? number_format($fees->sum(fn($f) => $f->total_amount ?? 0), 0, ',', ' ') : '0'); ?> ar</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <main class="p-6 max-w-8xl mx-auto">
            <div class="mb-6 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <h1 class="text-2xl font-bold">Frais par étudiant / semestre</h1>

                <div class="flex items-center gap-3">
                    <form method="GET" action="" class="flex items-center gap-2">
                        <input id="q-input" name="q" value="<?php echo e(request('q')); ?>" placeholder="Rechercher par nom, matricule..." class="px-3 py-2 rounded-lg border border-gray-200 bg-white shadow-sm w-64" />
                        <select id="academic-year-select" name="academic_year_id" class="px-3 py-2 rounded-lg border border-gray-200 bg-white shadow-sm">
                            <option value="">Année</option>
                            
                        </select>
                        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg">Filtrer</button>
                    </form>
                    <button id="copy-excel-btn" type="button" class="px-4 py-2 bg-emerald-600 text-white rounded-lg">Copier pour Excel</button>
                </div>
            </div>

            
            <div class="hidden lg:block bg-white rounded-2xl shadow overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full table-auto">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700 whitespace-nowrap">Étudiant</th>
                                <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700 whitespace-nowrap">Matricule</th>
                                <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700 whitespace-nowrap">Code compte</th>
                                <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700 whitespace-nowrap">Boursier par</th>
                                <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700 whitespace-nowrap">Année</th>
                                <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700 whitespace-nowrap">Semestre</th>
                                <th class="px-4 py-3 text-right text-sm font-semibold text-gray-700 whitespace-nowrap">Total</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            <?php $__currentLoopData = $fees; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $fee): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php
                                    $sponsorName = trim((optional($fee->student)->sponsor_nom ?? '') . ' ' . (optional($fee->student)->sponsor_prenom ?? ''));
                                    // prefer student.account_code then fee.account_code
                                    $acct = optional($fee->student)->account_code ?? ($fee->account_code ?? null);
                                ?>
                                <tr data-amount="<?php echo e($fee->total_amount ?? 0); ?>" data-sponsor="<?php echo e($sponsorName); ?>">
                                    <td class="px-4 py-3 whitespace-nowrap"><?php echo e(optional($fee->student)->prenom); ?> <?php echo e(optional($fee->student)->nom); ?></td>
                                    <td class="px-4 py-3 whitespace-nowrap"><?php echo e(optional($fee->student)->matricule ?? '-'); ?></td>
                                    <td class="px-4 py-3 whitespace-nowrap"><?php echo e($acct ?? '-'); ?></td>
                                    <td class="px-4 py-3 whitespace-nowrap"><?php echo e($sponsorName ?: '-'); ?></td>
                                    <td class="px-4 py-3 whitespace-nowrap"><?php echo e(optional($fee->academicYear)->libelle ?? $fee->academic_year_id); ?></td>
                                    <td class="px-4 py-3 whitespace-nowrap"><?php echo e(optional($fee->semester)->nom ?? $fee->semester_id); ?></td>
                                    <td class="px-4 py-3 text-right font-semibold whitespace-nowrap" data-amount-formatted="<?php echo e($fee->total_amount ?? 0); ?>"><?php echo e(number_format($fee->total_amount ?? 0, 0, ',', ' ')); ?> ar</td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
            </div>

            
            <div class="lg:hidden space-y-4">
                <?php $__currentLoopData = $fees; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $fee): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php $acct = optional($fee->student)->account_code ?? ($fee->account_code ?? null); ?>
                    <div class="bg-white rounded-2xl p-4 shadow">
                        <div class="flex items-start justify-between">
                            <div>
                                <div class="font-semibold"><?php echo e(optional($fee->student)->prenom); ?> <?php echo e(optional($fee->student)->nom); ?></div>
                                <div class="text-sm text-gray-500"><?php echo e(optional($fee->student)->matricule ?? '-'); ?> <?php if($acct): ?> • <?php echo e($acct); ?> <?php endif; ?> • <?php echo e(optional($fee->student)->sponsor_nom ?? '-'); ?></div>
                            </div>
                            <div class="text-right">
                                <div class="font-semibold text-lg"><?php echo e(number_format($fee->total_amount ?? 0, 0, ',', ' ')); ?> ar</div>
                                <div class="text-sm text-gray-500"><?php echo e($fee->computed_at ? \Carbon\Carbon::parse($fee->computed_at)->locale('fr')->isoFormat('D MMM YYYY') : '-'); ?></div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>

            <script>
                // Copy visible desktop table as TSV with raw numeric amounts so Excel can compute immediately
                document.addEventListener('DOMContentLoaded', function() {
                        const btn = document.getElementById('copy-excel-btn');
                    if (!btn) return;
                    btn.addEventListener('click', function() {
                        // Find rows in desktop table
                        const rows = Array.from(document.querySelectorAll('table.min-w-full tbody tr'));
                        if (!rows.length) {
                            alert('Aucune donnée à copier');
                            return;
                        }

                        // Build TSV: header then rows (added Code compte)
                        const headers = ['Étudiant','Matricule','Code compte','Boursier par','Année','Semestre','Total'];
                        const lines = [headers.join('\t')];

                        rows.forEach(r => {
                            const cols = Array.from(r.querySelectorAll('td'));
                            if (!cols.length) return;
                            const student = cols[0].innerText.trim();
                            const matricule = cols[1].innerText.trim();
                            // code compte is now column 2 (index 2)
                            const codeCompte = cols[2] ? cols[2].innerText.trim() : '';
                            const annee = cols[3].innerText.trim();
                            const semestre = cols[4].innerText.trim();
                            const sponsor = r.getAttribute('data-sponsor') || '';
                            // numeric raw value is stored in data-amount attribute on the tr
                            const rawAmount = r.getAttribute('data-amount') ?? '';
                            const computed = cols[5] ? cols[5].innerText.trim() : '';
                            // Use rawAmount without thousands separators so Excel recognizes it as number
                            lines.push([student, matricule, codeCompte, sponsor, annee, semestre, rawAmount, computed].join('\t'));
                        });

                        const tsv = lines.join('\n');
                        navigator.clipboard.writeText(tsv).then(() => {
                            // small feedback
                            btn.innerText = 'Copié ✓';
                            setTimeout(() => btn.innerText = 'Copier pour Excel', 1500);
                        }).catch(err => {
                            alert('Impossible de copier: ' + err);
                        });
                    });

                    // Live search: debounce and fetch updated table/mobile HTML
                    const qInput = document.getElementById('q-input');
                    const aySelect = document.getElementById('academic-year-select');
                    if (qInput) {
                        let debounceTimer = null;
                        let currentController = null;
                        const tableSelector = 'table.min-w-full';
                        const mobileListSelector = '.lg:hidden.space-y-4';

                        const performSearch = () => {
                            const q = qInput.value.trim();
                            const ay = aySelect ? aySelect.value : '';
                            // build url preserving current path
                            const url = new URL(window.location.href.split('?')[0], window.location.origin);
                            if (q) url.searchParams.set('q', q);
                            if (ay) url.searchParams.set('academic_year_id', ay);

                            // abort previous
                            if (currentController) {
                                try { currentController.abort(); } catch (e) {}
                            }
                            currentController = new AbortController();

                            fetch(url.toString(), { signal: currentController.signal, credentials: 'same-origin' })
                                .then(r => r.text())
                                .then(html => {
                                    try {
                                        const parser = new DOMParser();
                                        const doc = parser.parseFromString(html, 'text/html');
                                        const newTbody = doc.querySelector(tableSelector + ' tbody');
                                        const curTbody = document.querySelector(tableSelector + ' tbody');
                                        if (newTbody && curTbody) curTbody.innerHTML = newTbody.innerHTML;

                                        const newMobile = doc.querySelector(mobileListSelector);
                                        const curMobile = document.querySelector(mobileListSelector);
                                        if (newMobile && curMobile) curMobile.innerHTML = newMobile.innerHTML;

                                        // update browser URL without reloading
                                        try { window.history.replaceState({}, '', url); } catch (e) {}
                                    } catch (e) {
                                        // ignore parse errors
                                    }
                                }).catch(err => {
                                    if (err.name === 'AbortError') return;
                                    console.error('Live search fetch error', err);
                                });
                        };

                        qInput.addEventListener('input', function() {
                            if (debounceTimer) clearTimeout(debounceTimer);
                            debounceTimer = setTimeout(performSearch, 350);
                        });

                        // also trigger search when academic year changes
                        if (aySelect) {
                            aySelect.addEventListener('change', function() {
                                if (debounceTimer) clearTimeout(debounceTimer);
                                debounceTimer = setTimeout(performSearch, 150);
                            });
                        }
                    }
                });
            </script>

        </main>
    </div>
</body>
</html>
<?php /**PATH D:\PROJET REGISTRAIRE\registrarClone\registrar\resources\views/chief_accountant/fees/list.blade.php ENDPATH**/ ?>