    <!-- Hero Section -->
    <section id="accueil" class="pt-16 bg-gradient-to-br from-gray-50 to-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20 lg:py-32">
            <div class="grid lg:grid-cols-2 gap-12 items-center">
                <div class="text-center lg:text-left">
                    <!-- Titre principal adapté pour l'université -->
                    <h1 class="text-4xl md:text-5xl lg:text-6xl font-montserrat font-black text-gray-900 leading-tight text-balance">
                        Bienvenue à l'
                        <span class="text-blue-900">Université Adventiste Zurcher</span>
                    </h1>
                    <!-- Description adaptée pour l'université -->
                    <p class="mt-6 text-xl text-gray-600 leading-relaxed text-pretty">
                        Rejoignez une communauté académique d'excellence où la foi, l'apprentissage et le service 
                        se rencontrent pour former les leaders de demain. Découvrez nos programmes innovants 
                        pour l'année académique 2025-2026.
                    </p>
                    <div class="mt-8 flex flex-col sm:flex-row gap-4 justify-center lg:justify-start">
                        <!-- Boutons d'action adaptés avec couleurs bleu marine -->
                        <a href="{{ route('register')}}" class="bg-blue-900 text-white px-8 py-4 rounded-lg text-lg font-semibold hover:bg-blue-800 transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-xl">
                            S'inscrire maintenant
                        </a>
                        <a href="{{ route('login')}}" class="border-2 border-blue-900 text-blue-900 px-8 py-4 rounded-lg text-lg font-semibold hover:bg-blue-900 hover:text-white transition-all duration-300">
                            Se connecter
                        </a>
                    </div>
                </div>
                <div class="relative">
                    <div class="relative z-10">
                        <!-- Image adaptée pour le campus universitaire -->
                        <img src="https://yt3.googleusercontent.com/ytc/AGIKgqMrYnDBtikTA3sE31ur77qAnb56zLrCpKXqfFCB=s900-c-k-c0x00ffffff-no-rj" 
                             alt="Campus de l'Université Adventiste Zurcher" 
                             class="w-full h-auto rounded-2xl shadow-2xl">
                    </div>
                    <!-- Éléments décoratifs avec couleurs bleu marine -->
                    <div class="absolute -top-4 -right-4 w-72 h-72 bg-blue-100 rounded-full mix-blend-multiply filter blur-xl opacity-70 animate-pulse"></div>
                    <div class="absolute -bottom-8 -left-4 w-72 h-72 bg-gray-100 rounded-full mix-blend-multiply filter blur-xl opacity-70 animate-pulse"></div>
                </div>
            </div>
        </div>
    </section>

    <!-- Programs Section -->
    <section id="programmes" class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <!-- Titre de section adapté pour les programmes universitaires -->
                <h2 class="text-3xl md:text-4xl font-montserrat font-black text-gray-900 text-balance">
                    Pourquoi choisir l'UAZ ?
                </h2>
                <p class="mt-4 text-xl text-gray-600 max-w-3xl mx-auto text-pretty">
                    Une éducation holistique qui combine excellence académique, valeurs chrétiennes et préparation professionnelle.
                </p>
            </div>

            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Feature 1 -->
                <div class="bg-gray-50 p-8 rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2 group">
                    <!-- Icône et contenu adaptés pour l'excellence académique -->
                    <div class="w-16 h-16 bg-blue-900 rounded-xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-montserrat font-bold text-gray-900 mb-4">Excellence Académique</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Programmes accrédités avec un corps professoral qualifié et une approche pédagogique innovante.
                    </p>
                </div>

                <!-- Feature 2 -->
                <div class="bg-gray-50 p-8 rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2 group">
                    <div class="w-16 h-16 bg-blue-900 rounded-xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-montserrat font-bold text-gray-900 mb-4">Communauté Bienveillante</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Un environnement chaleureux et inclusif où chaque étudiant est valorisé et accompagné.
                    </p>
                </div>

                <!-- Feature 3 -->
                <div class="bg-gray-50 p-8 rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2 group">
                    <div class="w-16 h-16 bg-blue-900 rounded-xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2-2v2m8 0V6a2 2 0 012 2v6a2 2 0 01-2 2H6a2 2 0 01-2-2V8a2 2 0 012-2V6"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-montserrat font-bold text-gray-900 mb-4">Formation Professionnelle</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Préparation concrète au monde du travail avec stages, projets pratiques et réseau professionnel.
                    </p>
                </div>

                <!-- Feature 4 -->
                <div class="bg-gray-50 p-8 rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2 group">
                    <div class="w-16 h-16 bg-blue-900 rounded-xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-montserrat font-bold text-gray-900 mb-4">Perspective Internationale</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Programmes d'échange, partenariats internationaux et ouverture sur le monde.
                    </p>
                </div>

                <!-- Feature 5 -->
                <div class="bg-gray-50 p-8 rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2 group">
                    <div class="w-16 h-16 bg-blue-900 rounded-xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-montserrat font-bold text-gray-900 mb-4">Valeurs Chrétiennes</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Formation intégrale qui nourrit l'esprit, l'âme et le corps dans la tradition adventiste.
                    </p>
                </div>

                <!-- Feature 6 -->
                <div class="bg-gray-50 p-8 rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2 group">
                    <div class="w-16 h-16 bg-blue-900 rounded-xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-montserrat font-bold text-gray-900 mb-4">Innovation Pédagogique</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Technologies modernes, méthodes d'apprentissage actif et approches pédagogiques créatives.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Campus Section -->
    <section id="campus" class="py-20 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid lg:grid-cols-2 gap-12 items-center">
                <div>
                    <!-- Image adaptée pour le campus -->
                    <img src="https://scontent-jnb2-1.xx.fbcdn.net/v/t39.30808-6/492503040_1167834935357704_98875299689711851_n.jpg?_nc_cat=100&ccb=1-7&_nc_sid=127cfc&_nc_eui2=AeFqCii0OOrB08E53Y5Tq9Be--zPykhkuRf77M_KSGS5F_SU1AxhtnON9jR1TI7qmImpa3V8QxmuEex9gMQDWwIs&_nc_ohc=ieBwU7ZXZcYQ7kNvwEnbgsP&_nc_oc=Adkb2TwB9010Yoi6uuBZMjtBaDzPuEecQtRSh4KU7XYbslCM9zLoVVggKprz-7kvhgE&_nc_zt=23&_nc_ht=scontent-jnb2-1.xx&_nc_gid=t_LvdngIRSa5LkxT1Va90g&oh=00_AfbepaiKXRxmWQ-fzHURTjF8vgvMzS-iEMPsMYj9dD7JMQ&oe=68D6AA02" 
                         alt="Campus UAZ" 
                         class="w-full h-auto rounded-2xl shadow-xl">
                </div>
                <div>
                    <!-- Contenu adapté pour présenter le campus -->
                    <h2 class="text-3xl md:text-4xl font-montserrat font-black text-gray-900 mb-6 text-balance">
                        Un campus moderne au cœur de l'apprentissage
                    </h2>
                    <p class="text-lg text-gray-600 mb-6 leading-relaxed text-pretty">
                        Notre campus offre un environnement d'apprentissage exceptionnel avec des infrastructures 
                        modernes, des espaces verts paisibles et toutes les commodités nécessaires à votre réussite 
                        académique et personnelle.
                    </p>
                    <div class="space-y-4">
                        <!-- Points clés adaptés pour le campus avec couleurs bleu marine -->
                        <div class="flex items-center">
                            <div class="w-8 h-8 bg-blue-900 rounded-full flex items-center justify-center mr-4">
                                <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                            <span class="text-gray-700 font-medium">Bibliothèque moderne avec plusieurs ouvrages</span>
                        </div>
                        <div class="flex items-center">
                            <div class="w-8 h-8 bg-blue-900 rounded-full flex items-center justify-center mr-4">
                                <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                            <span class="text-gray-700 font-medium">Laboratoires équipés et salles informatiques</span>
                        </div>
                        <div class="flex items-center">
                            <div class="w-8 h-8 bg-blue-900 rounded-full flex items-center justify-center mr-4">
                                <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                            <span class="text-gray-700 font-medium">Résidences étudiantes et services de restauration</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section id="admissions" class="py-20 bg-gradient-to-r from-blue-900 to-blue-800">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <!-- Call-to-action adapté pour les admissions -->
            <h2 class="text-3xl md:text-4xl font-montserrat font-black text-white mb-6 text-balance">
                Prêt à rejoindre l'UAZ pour 2025-2026 ?
            </h2>
            <p class="text-xl text-blue-100 mb-8 text-pretty">
                Les inscriptions pour l'année académique 2025-2026 sont ouvertes. Rejoignez notre communauté 
                et commencez votre parcours vers l'excellence académique et personnelle.
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <!-- Boutons d'action adaptés pour les admissions -->
                <a href="mailto:registraroffice@zurcher.edu.mg" class="bg-white text-blue-900 px-8 py-4 rounded-lg text-lg font-semibold hover:bg-gray-100 transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-xl">
                    Déposer mon dossier
                </a>
                <a href="tel:+261 34 46 000 08" class="border-2 border-white text-white px-8 py-4 rounded-lg text-lg font-semibold hover:bg-white hover:text-blue-900 transition-all duration-300">
                    Nous contacter
                </a>
            </div>
        </div>
    </section>