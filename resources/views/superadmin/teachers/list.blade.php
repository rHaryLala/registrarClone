<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des enseignants - Université Adventiste Zurcher</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link href="https://fonts.googleapis.com/css2?family=Work+Sans:wght@300;400;500;600;700&family=Open+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { font-family: 'Open Sans', sans-serif; }
        h1,h2,h3,h4,h5,h6 { font-family: 'Work Sans', sans-serif; }
        .sidebar { width: 260px; transition: all 0.3s; }
        .main-content { margin-left: 260px; transition: all 0.3s; }
        @media (max-width: 768px) { .sidebar { margin-left: -260px; } .main-content { margin-left: 0; } .sidebar.active { margin-left: 0; } }
        .search-container { background: linear-gradient(135deg, #1e40af 0%, #3b82f6 100%); border-radius: 12px; }
        .modern-input { background: white; }
        .matricule-badge { background: linear-gradient(135deg, rgba(59,130,246,0.1) 0%, rgba(147,197,253,0.15) 100%); }
        .table-container { background: rgba(255,255,255,0.95); border-radius: 12px; box-shadow: 0 20px 60px rgba(0,0,0,0.08); }
        .card { background: white; border-radius: 12px; box-shadow: 0 8px 24px rgba(0,0,0,0.06); }
    </style>
</head>
<body class="bg-gray-50">
    @include('superadmin.components.sidebar')
    <div class="main-content min-h-screen">
        @include('superadmin.components.header')
        <main class="p-4 md:p-6 lg:p-8">
            <div class="search-container text-white p-6 mb-6 shadow-lg">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                    <div>
                        <h1 class="text-3xl font-bold mb-1">Liste des enseignants</h1>
                        <p class="text-blue-100">Gérez les enseignants de votre université</p>
                    </div>
                    <a href="{{ route('superadmin.teachers.create') }}" class="bg-white text-blue-800 px-6 py-3 rounded-xl hover:bg-blue-50 transition-all duration-300 flex items-center justify-center font-semibold shadow-lg">
                        <i class="fas fa-plus mr-2"></i> Nouvel enseignant
                    </a>
                </div>

                <div class="mt-6 flex flex-col md:flex-row gap-4">
                    <div class="flex-1 relative">
                        <input type="text" id="searchInput" placeholder="Rechercher par nom, email, téléphone, diplôme..." class="modern-input w-full px-4 py-3 rounded-xl text-gray-800 placeholder-gray-500 focus:outline-none" />
                        <i class="fas fa-search absolute left-4 top-3 text-gray-400"></i>
                    </div>
                </div>
            </div>

            <div class="table-container rounded-2xl overflow-hidden hidden md:block">
                <div class="overflow-x-auto">
                    <table class="min-w-full">
                        <thead class="bg-gradient-to-r from-blue-800 to-blue-700 text-white">
                            <tr>
                                <th class="px-6 py-4 text-left text-sm font-semibold uppercase tracking-wider">Nom</th>
                                <th class="px-6 py-4 text-left text-sm font-semibold uppercase tracking-wider">Email</th>
                                <th class="px-6 py-4 text-left text-sm font-semibold uppercase tracking-wider">Téléphone</th>
                                <th class="px-6 py-4 text-left text-sm font-semibold uppercase tracking-wider">Diplôme</th>
                                <th class="px-6 py-4 text-left text-sm font-semibold uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody id="teachersTableBody" class="bg-white divide-y divide-gray-100">
                            @foreach($teachers as $teacher)
                                <tr class="cursor-pointer" data-name="{{ strtolower($teacher->name) }}" data-email="{{ strtolower($teacher->email) }}" data-phone="{{ strtolower($teacher->telephone) }}" data-diplome="{{ strtolower($teacher->diplome ?? '') }}" onclick="window.location='{{ route('superadmin.teachers.edit', $teacher->id) }}'">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $teacher->name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ $teacher->email }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ $teacher->telephone }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ $teacher->diplome }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                        <div class="flex items-center gap-3">
                                            <a href="{{ route('superadmin.teachers.edit', $teacher->id) }}" class="bg-blue-100 text-blue-700 px-3 py-2 rounded-lg hover:bg-blue-200 transition text-sm font-medium"><i class="fas fa-edit mr-1"></i> Modifier</a>
                                            <form action="{{ route('superadmin.teachers.destroy', $teacher->id) }}" method="POST" onsubmit="return confirm('Voulez-vous vraiment supprimer cet enseignant ?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="bg-red-100 text-red-700 px-3 py-2 rounded-lg hover:bg-red-200 transition text-sm font-medium"><i class="fas fa-trash-alt mr-1"></i> Supprimer</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="mt-6 flex items-center">
                <div class="w-1/3"></div>
                <div id="pagination" class="flex items-center gap-2 justify-center w-1/3"></div>
                <div class="w-1/3 flex justify-end">
                    <div id="filteredCountBadge" class="text-sm text-gray-600">Affichés : 0 / 0</div>
                </div>
            </div>

            <!-- Mobile cards -->
            <div class="mobile-cards space-y-4 mt-6 md:hidden" id="mobileTeacherCards">
                @foreach($teachers as $teacher)
                    <div class="card p-4" data-name="{{ strtolower($teacher->name) }}" data-email="{{ strtolower($teacher->email) }}" data-phone="{{ strtolower($teacher->telephone) }}" data-diplome="{{ strtolower($teacher->diplome ?? '') }}">
                        <div class="flex items-start justify-between">
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900">{{ $teacher->name }}</h3>
                                <p class="text-sm text-gray-600">{{ $teacher->email }} • {{ $teacher->telephone }}</p>
                            </div>
                            <div class="flex flex-col items-end gap-2">
                                <a href="{{ route('superadmin.teachers.edit', $teacher->id) }}" class="bg-blue-100 text-blue-700 px-3 py-2 rounded-lg text-sm"><i class="fas fa-edit"></i></a>
                            </div>
                        </div>
                        <div class="mt-4 text-sm text-gray-700">Diplôme: {{ $teacher->diplome ?? '-' }}</div>
                    </div>
                @endforeach
            </div>

        </main>
    </div>

    <script>
        let currentPage = 1;
        const pageSize = 12;

        function getMatchingItems() {
            const term = (document.getElementById('searchInput').value || '').toLowerCase();
            const rows = Array.from(document.querySelectorAll('#teachersTableBody tr'));
            const cards = Array.from(document.querySelectorAll('#mobileTeacherCards .card'));

            const matchingRows = rows.filter(r => {
                const name = (r.getAttribute('data-name') || '').toLowerCase();
                const email = (r.getAttribute('data-email') || '').toLowerCase();
                const phone = (r.getAttribute('data-phone') || '').toLowerCase();
                const diplome = (r.getAttribute('data-diplome') || '').toLowerCase();
                return name.includes(term) || email.includes(term) || phone.includes(term) || diplome.includes(term);
            });

            const matchingCards = cards.filter(c => {
                const name = (c.getAttribute('data-name') || '').toLowerCase();
                const email = (c.getAttribute('data-email') || '').toLowerCase();
                const phone = (c.getAttribute('data-phone') || '').toLowerCase();
                const diplome = (c.getAttribute('data-diplome') || '').toLowerCase();
                return name.includes(term) || email.includes(term) || phone.includes(term) || diplome.includes(term);
            });

            return { matchingRows, matchingCards };
        }

        function renderPagination(total) {
            const pagination = document.getElementById('pagination');
            if (!pagination) return;
            const totalPages = Math.max(1, Math.ceil(total / pageSize));
            if (totalPages <= 1) {
                pagination.innerHTML = '';
                return;
            }

            // Clear existing
            pagination.innerHTML = '';
            const maxVisible = 7;
            let start = Math.max(1, currentPage - Math.floor(maxVisible / 2));
            let end = Math.min(totalPages, start + maxVisible - 1);
            if (end - start < maxVisible - 1) start = Math.max(1, end - maxVisible + 1);

            const makeButton = (label, opts = {}) => {
                const btn = document.createElement('button');
                btn.className = 'px-3 py-2 rounded-lg';
                btn.textContent = label;
                if (opts.className) btn.className += ' ' + opts.className;
                if (opts.disabled) {
                    btn.disabled = true;
                    btn.setAttribute('aria-disabled', 'true');
                    btn.style.cursor = 'not-allowed';
                } else {
                    btn.style.cursor = 'pointer';
                    if (opts.onClick) btn.addEventListener('click', opts.onClick);
                }
                return btn;
            };

            // Prev
            const prevBtn = makeButton('‹', { disabled: currentPage === 1, onClick: () => goToPage(currentPage - 1) });
            pagination.appendChild(prevBtn);

            if (start > 1) {
                const first = makeButton('1', { onClick: () => goToPage(1) });
                pagination.appendChild(first);
            }
            if (start > 2) {
                const dots = document.createElement('span'); dots.className = 'px-2'; dots.textContent = '...'; pagination.appendChild(dots);
            }

            for (let i = start; i <= end; i++) {
                const isCurrent = i === currentPage;
                const btn = makeButton(i, { className: isCurrent ? 'bg-blue-700 text-white' : 'bg-white border', onClick: isCurrent ? null : (() => goToPage(i)) });
                if (isCurrent) btn.style.cursor = 'default';
                pagination.appendChild(btn);
            }

            if (end < totalPages - 1) {
                const dots = document.createElement('span'); dots.className = 'px-2'; dots.textContent = '...'; pagination.appendChild(dots);
            }

            if (end < totalPages) {
                const last = makeButton(String(totalPages), { onClick: () => goToPage(totalPages) });
                pagination.appendChild(last);
            }

            const nextBtn = makeButton('›', { disabled: currentPage === totalPages, onClick: () => goToPage(currentPage + 1) });
            pagination.appendChild(nextBtn);
        }

        function goToPage(page) {
            const { matchingRows } = getMatchingItems();
            const totalPages = Math.max(1, Math.ceil(matchingRows.length / pageSize));
            if (page < 1 || page > totalPages) return;
            currentPage = page;
            updateDisplay();
            window.scrollTo({ top: 0, behavior: 'smooth' });
        }

        function updateDisplay() {
            const { matchingRows, matchingCards } = getMatchingItems();
            const total = matchingRows.length;

            // Hide all rows and cards
            document.querySelectorAll('#teachersTableBody tr').forEach(r => r.style.display = 'none');
            document.querySelectorAll('#mobileTeacherCards .card').forEach(c => c.style.display = 'none');

            // Calculate slice for pagination
            const start = (currentPage - 1) * pageSize;
            const end = start + pageSize;

            // Show page slice for rows
            matchingRows.slice(start, end).forEach(r => r.style.display = '');
            // Show page slice for cards
            matchingCards.slice(start, end).forEach(c => c.style.display = '');

            // Update badge
            const badge = document.getElementById('filteredCountBadge');
            if (badge) badge.textContent = `Affichés : ${Math.min(pageSize, total - start > 0 ? end - start : 0)} / ${total}`;

            renderPagination(total);
        }

        document.getElementById('searchInput').addEventListener('input', function() {
            currentPage = 1;
            updateDisplay();
        });

        document.addEventListener('DOMContentLoaded', function() {
            updateDisplay();
        });
    </script>
</body>
</html>
