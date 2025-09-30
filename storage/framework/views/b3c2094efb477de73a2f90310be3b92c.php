<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fiche étudiant - Université Adventiste Zurcher</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link href="https://fonts.googleapis.com/css2?family=Work+Sans:wght@300;400;500;600;700;800&family=Open+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="icon" type="image/png" href="/favicon.png">
    <style>
        body { font-family: 'Open Sans', sans-serif; }
        .sidebar { width: 260px; transition: all 0.3s; }
        .main-content { margin-left: 260px; transition: all 0.3s; }
        @media (max-width: 768px) {
            .sidebar { margin-left: -260px; }
            .main-content { margin-left: 0; }
            .sidebar.active { margin-left: 0; }
        }
        /* Harmonized glass card and gradient styles with consistent blue theme */
        .glass-card {
            background: rgba(30, 58, 138, 0.95);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(30, 58, 138, 0.1);
        }
        .gradient-bg {
            background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 50%, #1d4ed8 100%);
        }
        .card-hover {
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .card-hover:hover {
            transform: translateY(-6px);
            box-shadow: 0 25px 50px -12px rgba(30, 58, 138, 0.15), 0 10px 20px -5px rgba(30, 58, 138, 0.08);
        }
        /* Added consistent animation system */
        .section-header {
            background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 50%, #1d4ed8 100%);
        }
        .info-item {
            transition: all 0.3s ease;
            border-radius: 12px;
        }
        .info-item:hover {
            background: rgba(59, 130, 246, 0.05);
            transform: translateX(4px);
        }
    </style>
</head>
<body class="bg-gradient-to-br from-slate-50 via-blue-50 to-blue-100 min-h-screen font-body">
    <?php echo $__env->make('dean.components.sidebar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    
    <div class="main-content min-h-screen">
        <?php echo $__env->make('dean.components.header', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        
<main class="p-6 bg-gradient-to-br from-gray-50 to-blue-50 min-h-screen">
    <!-- Enhanced hero section with floating elements and improved animations -->
    <div class="max-w-7xl mx-auto mb-8">
        <div class="gradient-bg rounded-3xl p-8 text-white shadow-2xl relative overflow-hidden animate-fade-in">
            <!-- Enhanced decorative elements -->
            <div class="absolute top-0 right-0 w-64 h-64 bg-white/10 rounded-full -translate-y-32 translate-x-32 animate-float"></div>
            <div class="absolute bottom-0 left-0 w-48 h-48 bg-white/10 rounded-full translate-y-24 -translate-x-24 animate-float-delayed"></div>
            <div class="absolute top-1/2 left-1/4 w-32 h-32 bg-white/5 rounded-full animate-pulse"></div>
            
            <div class="relative z-10 flex flex-col md:flex-row items-start md:items-center justify-between gap-6">
                <div class="flex items-center space-x-6">
                    <div class="relative group">
                        <div class="w-28 h-28 rounded-3xl overflow-hidden bg-white/20 backdrop-blur-sm flex items-center justify-center text-white font-bold text-3xl shadow-2xl border-2 border-white/30">
                            <?php if($student->image): ?>
                                <img src="<?php echo e(asset($student->image)); ?>" alt="Photo de profil" class="object-cover w-full h-full rounded-3xl">
                            <?php else: ?>
                                <span class="font-heading text-4xl"><?php echo e(substr($student->prenom, 0, 1)); ?><?php echo e(substr($student->nom, 0, 1)); ?></span>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="animate-slide-in-left">
                        <h1 class="text-5xl font-heading font-bold mb-4 text-balance bg-gradient-to-r from-white to-blue-100 bg-clip-text"><?php echo e($student->prenom); ?> <?php echo e($student->nom); ?></h1>
                        <div class="flex flex-wrap items-center gap-4">
                            <span class="bg-white/25 backdrop-blur-sm px-5 py-3 rounded-full text-sm font-semibold border border-white/30 hover:bg-white/35 transition-all duration-300 transform hover:scale-105">
                                <i class="fas fa-id-badge mr-2 text-blue-200"></i>Matricule: <?php echo e($student->matricule); ?>

                            </span>
                            <?php if($student->bursary_status): ?>
                                <span class="bg-gradient-to-r from-yellow-400 to-amber-400 text-yellow-900 px-5 py-3 rounded-full text-sm font-bold shadow-lg hover:shadow-xl transform hover:scale-105 transition-all duration-300">
                                    <i class="fas fa-star mr-2 animate-pulse"></i>Boursier
                                </span>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                
                <div class="flex flex-wrap items-center gap-4 animate-slide-in-right">
                    <a href="<?php echo e(route('dean.students.courses.history', $student->id)); ?>" 
                       class="bg-white/25 backdrop-blur-sm hover:bg-white/40 text-white px-6 py-4 rounded-2xl transition-all duration-300 flex items-center space-x-3 border border-white/40 font-semibold hover:scale-105 hover:shadow-xl">
                        <i class="fas fa-book text-lg"></i>
                        <span>Cours</span>
                    </a>
                    <a href="<?php echo e(route('dean.students.index')); ?>"
                       class="text-white hover:text-blue-100 flex items-center space-x-3 px-6 py-4 rounded-2xl hover:bg-white/15 transition-all duration-300 font-semibold hover:scale-105">
                        <i class="fas fa-arrow-left text-lg"></i>
                        <span>Retour</span>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Enhanced main content grid with staggered animations -->
    <div class="max-w-7xl mx-auto">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-8">
            
            <!-- Standardized all section headers with consistent gradient and spacing -->
            <!-- Personal Information -->
            <div class="bg-white rounded-3xl shadow-xl card-hover overflow-hidden border border-gray-100 animate-fade-in-up" style="animation-delay: 0.1s">
                <div class="section-header p-6 relative overflow-hidden">
                    <div class="absolute top-0 right-0 w-24 h-24 bg-white/10 rounded-full -translate-y-12 translate-x-12"></div>
                    <div class="flex items-center text-white relative z-10">
                        <div class="w-14 h-14 bg-white/25 rounded-2xl flex items-center justify-center mr-4 hover:scale-110 transition-transform duration-300">
                            <i class="fas fa-user text-xl"></i>
                        </div>
                        <h2 class="text-xl font-heading font-bold">Informations personnelles</h2>
                    </div>
                </div>
                <div class="p-6 space-y-2">
                    <!-- Standardized all info items with consistent hover effects and spacing -->
                    <div class="info-item flex justify-between items-center py-4 px-3">
                        <span class="text-gray-600 font-semibold flex items-center"><i class="fas fa-venus-mars text-blue-600 mr-3"></i>Sexe</span>
                        <span class="font-bold text-gray-900"><?php echo e($student->sexe); ?></span>
                    </div>
                    <div class="info-item flex justify-between items-center py-4 px-3">
                        <span class="text-gray-600 font-semibold flex items-center"><i class="fas fa-birthday-cake text-blue-600 mr-3"></i>Date de naissance</span>
                        <span class="font-bold text-gray-900">
                            <?php echo e($student->date_naissance ? \Carbon\Carbon::parse($student->date_naissance)->format('Y-m-d') : ''); ?>

                        </span>
                    </div>
                    <div class="info-item flex justify-between items-center py-4 px-3">
                        <span class="text-gray-600 font-semibold flex items-center"><i class="fas fa-map-marker-alt text-blue-600 mr-3"></i>Lieu de naissance</span>
                        <span class="font-bold text-gray-900"><?php echo e($student->lieu_naissance); ?></span>
                    </div>
                    <div class="info-item flex justify-between items-center py-4 px-3">
                        <span class="text-gray-600 font-semibold flex items-center"><i class="fas fa-flag text-blue-600 mr-3"></i>Nationalité</span>
                        <span class="font-bold text-gray-900"><?php echo e($student->nationalite); ?></span>
                    </div>
                    <div class="info-item flex justify-between items-center py-4 px-3">
                        <span class="text-gray-600 font-semibold flex items-center"><i class="fas fa-pray text-blue-600 mr-3"></i>Religion</span>
                        <span class="font-bold text-gray-900"><?php echo e($student->religion); ?></span>
                    </div>
                    <div class="info-item flex justify-between items-center py-4 px-3">
                        <span class="text-gray-600 font-semibold flex items-center"><i class="fas fa-heart text-blue-600 mr-3"></i>État civil</span>
                        <span class="font-bold text-gray-900"><?php echo e($student->etat_civil); ?></span>
                    </div>
                </div>
            </div>

            <!-- Contact Information -->
            <div class="bg-white rounded-3xl shadow-xl card-hover overflow-hidden border border-gray-100 animate-fade-in-up" style="animation-delay: 0.2s">
                <div class="section-header p-6 relative overflow-hidden">
                    <div class="absolute top-0 right-0 w-24 h-24 bg-white/10 rounded-full -translate-y-12 translate-x-12"></div>
                    <div class="flex items-center text-white relative z-10">
                        <div class="w-14 h-14 bg-white/25 rounded-2xl flex items-center justify-center mr-4 hover:scale-110 transition-transform duration-300">
                            <i class="fas fa-address-book text-xl"></i>
                        </div>
                        <h2 class="text-xl font-heading font-bold">Coordonnées</h2>
                    </div>
                </div>
                <div class="p-6 space-y-2">
                    <div class="info-item flex justify-between items-center py-4 px-3">
                        <span class="text-gray-600 font-semibold flex items-center"><i class="fas fa-phone text-blue-600 mr-3"></i>Téléphone</span>
                        <span class="font-bold text-gray-900"><?php echo e($student->telephone); ?></span>
                    </div>
                    <div class="info-item flex justify-between items-center py-4 px-3">
                        <span class="text-gray-600 font-semibold flex items-center"><i class="fas fa-envelope text-blue-600 mr-3"></i>Email</span>
                        <span class="font-bold text-gray-900 break-all"><?php echo e($student->email); ?></span>
                    </div>
                    <div class="info-item flex justify-between items-center py-4 px-3">
                        <span class="text-gray-600 font-semibold flex items-center"><i class="fas fa-home text-blue-600 mr-3"></i>Adresse</span>
                        <span class="font-bold text-gray-900 text-right"><?php echo e($student->adresse); ?></span>
                    </div>
                    <div class="info-item flex justify-between items-center py-4 px-3">
                        <span class="text-gray-600 font-semibold flex items-center"><i class="fas fa-globe text-blue-600 mr-3"></i>Région</span>
                        <span class="font-bold text-gray-900"><?php echo e($student->region); ?></span>
                    </div>
                    <div class="info-item flex justify-between items-center py-4 px-3">
                        <span class="text-gray-600 font-semibold flex items-center"><i class="fas fa-map text-blue-600 mr-3"></i>District</span>
                        <span class="font-bold text-gray-900"><?php echo e($student->district); ?></span>
                    </div>
                </div>
            </div>

            <!-- Academic Information -->
            <div class="bg-white rounded-3xl shadow-xl card-hover overflow-hidden border border-gray-100 animate-fade-in-up" style="animation-delay: 0.3s">
                <div class="section-header p-6 relative overflow-hidden">
                    <div class="absolute top-0 right-0 w-24 h-24 bg-white/10 rounded-full -translate-y-12 translate-x-12"></div>
                    <div class="flex items-center text-white relative z-10">
                        <div class="w-14 h-14 bg-white/25 rounded-2xl flex items-center justify-center mr-4 hover:scale-110 transition-transform duration-300">
                            <i class="fas fa-graduation-cap text-xl"></i>
                        </div>
                        <h2 class="text-xl font-heading font-bold">Scolarité</h2>
                    </div>
                </div>
                <div class="p-6 space-y-2">
                    <div class="info-item flex justify-between items-center py-4 px-3">
                        <span class="text-gray-600 font-semibold flex items-center"><i class="fas fa-certificate text-blue-600 mr-3"></i>Série Bac</span>
                        <span class="font-bold text-gray-900"><?php echo e($student->bacc_serie); ?></span>
                    </div>
                    <div class="info-item flex justify-between items-center py-4 px-3">
                        <span class="text-gray-600 font-semibold flex items-center"><i class="fas fa-calendar text-blue-600 mr-3"></i>Date obtention Bac</span>
                        <span class="font-bold text-gray-900"><?php echo e($student->bacc_date_obtention); ?></span>
                    </div>
                    <div class="info-item flex justify-between items-center py-4 px-3">
                        <span class="text-gray-600 font-semibold flex items-center"><i class="fas fa-level-up-alt text-blue-600 mr-3"></i>Niveau d'étude</span>
                        <span class="font-bold text-gray-900"><?php echo e($student->yearLevel ? $student->yearLevel->label : '-'); ?></span>
                    </div>
                    <div class="info-item flex justify-between items-center py-4 px-3">
                        <span class="text-gray-600 font-semibold flex items-center"><i class="fas fa-trophy text-blue-600 mr-3"></i>Mention</span>
                        <span class="font-bold text-gray-900"><?php echo e($student->mention->nom ?? '-'); ?></span>
                    </div>
                    <div class="info-item flex justify-between items-center py-4 px-3">
                        <span class="text-gray-600 font-semibold flex items-center"><i class="fas fa-trophy text-blue-600 mr-3"></i>Parcours</span>
                        <span class="font-bold text-gray-900"><?php echo e($student->parcours->nom ?? '-'); ?></span>
                    </div>
                </div>
            </div>
        </div>

    </div>
</main>

<style>
/* Enhanced and harmonized animations with consistent timing */
@keyframes fade-in {
    from { opacity: 0; transform: translateY(20px); }
    to { opacity: 1; transform: translateY(0); }
}

@keyframes fade-in-up {
    from { opacity: 0; transform: translateY(40px); }
    to { opacity: 1; transform: translateY(0); }
}

@keyframes slide-in-left {
    from { opacity: 0; transform: translateX(-30px); }
    to { opacity: 1, transform: translateX(0); }
}

@keyframes slide-in-right {
    from { opacity: 0; transform: translateX(30px); }
    to { opacity: 1, transform: translateX(0); }
}

@keyframes float {
    0%, 100% { transform: translateY(0px) rotate(0deg); }
    50% { transform: translateY(-20px) rotate(5deg); }
}

@keyframes float-delayed {
    0%, 100% { transform: translateY(0px) rotate(0deg); }
    50% { transform: translateY(-15px) rotate(-3deg); }
}

.animate-fade-in { animation: fade-in 0.8s ease-out forwards; }
.animate-fade-in-up { animation: fade-in-up 0.8s ease-out forwards; }
.animate-slide-in-left { animation: slide-in-left 0.8s ease-out forwards; }
.animate-slide-in-right { animation: slide-in-right 0.8s ease-out forwards; }
.animate-float { animation: float 6s ease-in-out infinite; }
.animate-float-delayed { animation: float-delayed 8s ease-in-out infinite; }

/* Consistent hover effects across all cards */
.card-hover {
    transition: all 0.4s ease;
}

.card-hover:hover {
    transform: translateY(-6px);
    box-shadow: 0 25px 50px -12px rgba(30, 58, 138, 0.15);
}

/* Unified gradient background */
.gradient-bg, .section-header {
    background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 50%, #60a5fa 100%);
}
</style>

    </div>

    <script>
    function uploadProfilePhoto(event) {
        const form = document.getElementById('photo-upload-form');
        const input = event.target;
        
        if (input.files && input.files[0]) {
            const formData = new FormData(form);
            
            fetch(form.action, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('input[name=_token]').value,
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success && data.image_url) {
                    // Mettre à jour l'image affichée
                    const img = document.getElementById('profile-photo');
                    const initials = document.getElementById('profile-initials');
                    
                    if (img) {
                        img.src = data.image_url;
                        img.style.display = 'block';
                        if (initials) initials.style.display = 'none';
                    } else {
                        // Recharger la page si l'élément img n'existe pas encore
                        location.reload();
                    }
                } else {
                    alert('Erreur lors du téléchargement de l\'image');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Erreur lors du téléchargement de l\'image');
            });
        }
    }
    </script>
</body>
</html>
  <?php /**PATH D:\PROJET REGISTRAIRE\registrarClone\registrar\resources\views/dean/students/show.blade.php ENDPATH**/ ?>