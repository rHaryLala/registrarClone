<!DOCTYPE html>
<html lang="fr" class="scroll-smooth h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <title>UAZ | Année Académique 2025-2026</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;900&family=Open+Sans:wght@400;600&display=swap" rel="stylesheet">
    <link rel="icon" type="image/png" href="/favicon.png">
    <style>
        .font-montserrat { font-family: 'Montserrat', sans-serif; }
        .font-opensans { font-family: 'Open Sans', sans-serif; }
        
        /* Animations d'entrée personnalisées */
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
        
        @keyframes fadeInLeft {
            from {
                opacity: 0;
                transform: translateX(-30px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }
        
        @keyframes fadeInRight {
            from {
                opacity: 0;
                transform: translateX(30px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }
        
        @keyframes fadeIn {
            from {
                opacity: 0;
            }
            to {
                opacity: 1;
            }
        }
        
        @keyframes scaleIn {
            from {
                opacity: 0;
                transform: scale(0.9);
            }
            to {
                opacity: 1;
                transform: scale(1);
            }
        }
        
        /* Classes d'animation */
        .animate-fade-in-up {
            animation: fadeInUp 0.8s ease-out forwards;
        }
        
        .animate-fade-in-left {
            animation: fadeInLeft 0.8s ease-out forwards;
        }
        
        .animate-fade-in-right {
            animation: fadeInRight 0.8s ease-out forwards;
        }
        
        .animate-fade-in {
            animation: fadeIn 0.8s ease-out forwards;
        }
        
        .animate-scale-in {
            animation: scaleIn 0.8s ease-out forwards;
        }
        
        /* États initiaux pour les animations */
        .animate-on-load {
            opacity: 0;
        }
        
        .animate-on-scroll {
            opacity: 0;
            transform: translateY(30px);
            transition: all 0.8s ease-out;
        }
        
        .animate-on-scroll.visible {
            opacity: 1;
            transform: translateY(0);
        }
        
        /* Délais d'animation pour effet de cascade */
        .delay-100 { animation-delay: 0.1s; }
        .delay-200 { animation-delay: 0.2s; }
        .delay-300 { animation-delay: 0.3s; }
        .delay-400 { animation-delay: 0.4s; }
        .delay-500 { animation-delay: 0.5s; }
        .delay-600 { animation-delay: 0.6s; }
        .delay-700 { animation-delay: 0.7s; }
        .delay-800 { animation-delay: 0.8s; }
    </style>
</head>
<body class="bg-white text-gray-600 font-opensans h-full flex flex-col">
    <!-- Overlay de chargement -->
    <div id="loading-overlay" class="fixed inset-0 bg-white z-50 flex items-center justify-center transition-opacity duration-500">
        <div class="text-center">
            <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-blue-600 mx-auto mb-4"></div>
            <p class="text-gray-600 font-montserrat">Chargement...</p>
        </div>
    </div>

    <main class="flex-grow">
        <!-- Section Welcome avec animations échelonnées -->
        <section class="animate-on-load animate-fade-in-up delay-200">
            @include('layouts.welcome')
        </section>
        
        <!-- Sections supplémentaires avec animation au scroll -->
        <div class="animate-on-scroll">
            <!-- Contenu qui apparaîtra au scroll -->
        </div>
    </main>

    <footer class="mt-auto animate-on-scroll">
        @include('layouts.footer')
    </footer>

    <script>
        // Animation au chargement de la page
        window.addEventListener('load', function() {
            // Masquer l'overlay de chargement
            const loadingOverlay = document.getElementById('loading-overlay');
            setTimeout(() => {
                loadingOverlay.style.opacity = '0';
                setTimeout(() => {
                    loadingOverlay.style.display = 'none';
                }, 500);
            }, 800);
            
            // Déclencher les animations de chargement
            const elementsToAnimate = document.querySelectorAll('.animate-on-load');
            elementsToAnimate.forEach((element, index) => {
                setTimeout(() => {
                    element.style.opacity = '1';
                }, index * 100);
            });
        });

        // Animation au scroll
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver(function(entries) {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('visible');
                }
            });
        }, observerOptions);

        // Observer tous les éléments avec la classe animate-on-scroll
        document.querySelectorAll('.animate-on-scroll').forEach(element => {
            observer.observe(element);
        });

        // Smooth scroll pour les ancres
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });

        // Animation des éléments de navigation
        function animateNavItems() {
            const navItems = document.querySelectorAll('nav a, nav button');
            navItems.forEach((item, index) => {
                item.classList.add('animate-on-load', 'animate-fade-in-up');
                item.style.animationDelay = `${0.3 + (index * 0.1)}s`;
            });
        }

        // Animation des cartes ou éléments répétitifs
        function animateCards() {
            const cards = document.querySelectorAll('.card, .feature-item, .service-card');
            cards.forEach((card, index) => {
                card.classList.add('animate-on-scroll');
                card.style.transitionDelay = `${index * 0.1}s`;
            });
        }

        // Animation des boutons avec effet hover amélioré
        function enhanceButtons() {
            const buttons = document.querySelectorAll('button, .btn');
            buttons.forEach(button => {
                button.classList.add('transition-all', 'duration-300', 'transform', 'hover:scale-105', 'hover:shadow-lg');
            });
        }

        // Initialiser les animations
        document.addEventListener('DOMContentLoaded', function() {
            animateNavItems();
            animateCards();
            enhanceButtons();
        });

        // Animation de typing pour les titres (optionnel)
        function typeWriter(element, text, speed = 100) {
            let i = 0;
            element.innerHTML = '';
            function type() {
                if (i < text.length) {
                    element.innerHTML += text.charAt(i);
                    i++;
                    setTimeout(type, speed);
                }
            }
            type();
        }

        // Utiliser l'effet typing sur le titre principal (si souhaité)
        // const mainTitle = document.querySelector('h1');
        // if (mainTitle) {
        //     const originalText = mainTitle.textContent;
        //     setTimeout(() => typeWriter(mainTitle, originalText, 80), 1000);
        // }
    </script>
</body>
</html>