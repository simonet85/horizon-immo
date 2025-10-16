<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Maintenance en cours - HorizonImmo</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
        }
        .float-animation {
            animation: float 3s ease-in-out infinite;
        }
        @keyframes pulse-slow {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.5; }
        }
        .pulse-slow {
            animation: pulse-slow 2s ease-in-out infinite;
        }
    </style>
</head>
<body class="bg-gradient-to-br from-blue-50 via-white to-green-50 min-h-screen flex items-center justify-center px-4">
    <div class="max-w-4xl w-full">
        <!-- Logo et Header -->
        <div class="text-center mb-12">
            <div class="inline-block mb-6 float-animation">
                <svg class="w-24 h-24 mx-auto text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                </svg>
            </div>
            <h1 class="text-5xl md:text-6xl font-bold text-gray-900 mb-4">
                HorizonImmo
            </h1>
        </div>

        <!-- Carte principale -->
        <div class="bg-white rounded-2xl shadow-2xl overflow-hidden">
            <!-- En-tête coloré -->
            <div class="bg-gradient-to-r from-blue-600 to-green-600 px-8 py-6 text-center">
                <div class="flex items-center justify-center mb-4">
                    <svg class="w-16 h-16 text-white pulse-slow" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"/>
                    </svg>
                </div>
                <h2 class="text-3xl md:text-4xl font-bold text-white">
                    Maintenance en cours
                </h2>
            </div>

            <!-- Contenu -->
            <div class="px-8 py-12">
                <div class="text-center mb-10">
                    <p class="text-xl md:text-2xl text-gray-700 mb-6 leading-relaxed">
                        Nous effectuons actuellement une maintenance pour améliorer nos services.
                    </p>
                    <p class="text-lg text-gray-600 mb-8">
                        Notre équipe travaille activement pour remettre le site en ligne dans les plus brefs délais.
                    </p>

                    <!-- Barre de progression animée -->
                    <div class="max-w-md mx-auto mb-8">
                        <div class="bg-gray-200 rounded-full h-3 overflow-hidden">
                            <div class="bg-gradient-to-r from-blue-600 to-green-600 h-full rounded-full animate-pulse" style="width: 75%"></div>
                        </div>
                        <p class="text-sm text-gray-500 mt-3">Mise à jour en cours...</p>
                    </div>
                </div>

                <!-- Informations de contact -->
                <div class="bg-gradient-to-br from-blue-50 to-green-50 rounded-xl p-8 mb-8">
                    <h3 class="text-2xl font-bold text-gray-900 mb-6 text-center">
                        Besoin d'assistance urgente ?
                    </h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Côte d'Ivoire -->
                        <div class="bg-white rounded-lg p-6 shadow-md">
                            <div class="flex items-center mb-4">
                                <svg class="w-6 h-6 text-blue-600 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"/>
                                </svg>
                                <h4 class="text-lg font-semibold text-gray-900">Côte d'Ivoire</h4>
                            </div>
                            <div class="space-y-2 text-gray-700">
                                <div class="flex items-center">
                                    <svg class="w-4 h-4 text-green-600 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z"/>
                                    </svg>
                                    <a href="tel:+2250707696914" class="hover:text-blue-600 transition">+225 0707 6969 14</a>
                                </div>
                                <div class="flex items-center">
                                    <svg class="w-4 h-4 text-green-600 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z"/>
                                    </svg>
                                    <a href="tel:+2250545010199" class="hover:text-blue-600 transition">+225 0545 0101 99</a>
                                </div>
                            </div>
                        </div>

                        <!-- Afrique du Sud -->
                        <div class="bg-white rounded-lg p-6 shadow-md">
                            <div class="flex items-center mb-4">
                                <svg class="w-6 h-6 text-blue-600 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"/>
                                </svg>
                                <h4 class="text-lg font-semibold text-gray-900">Afrique du Sud</h4>
                            </div>
                            <div class="space-y-2 text-gray-700">
                                <div class="flex items-center">
                                    <svg class="w-4 h-4 text-green-600 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z"/>
                                    </svg>
                                    <a href="tel:+27658687861" class="hover:text-blue-600 transition">+27 65 868 7861</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Email -->
                    <div class="mt-6 text-center">
                        <a href="mailto:info@zbinvestments-ci.com" class="inline-flex items-center text-blue-600 hover:text-blue-700 font-semibold text-lg transition">
                            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"/>
                                <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"/>
                            </svg>
                            info@zbinvestments-ci.com
                        </a>
                    </div>
                </div>

                <!-- Message de remerciement -->
                <div class="text-center">
                    <p class="text-lg text-gray-600 mb-4">
                        Merci de votre patience et de votre compréhension.
                    </p>
                    <p class="text-md text-gray-500">
                        Nous vous invitons à revenir très bientôt !
                    </p>
                </div>
            </div>

            <!-- Footer -->
            <div class="bg-gray-50 px-8 py-6 text-center border-t border-gray-200">
                <p class="text-gray-600 mb-2">
                    <span class="font-semibold text-gray-900">ZB Investments</span> - Votre partenaire immobilier de confiance
                </p>
                <p class="text-sm text-gray-500">
                    © {{ date('Y') }} HorizonImmo. Tous droits réservés.
                </p>
            </div>
        </div>

        <!-- Bouton de rechargement -->
        <div class="text-center mt-8">
            <button onclick="location.reload()" class="bg-gradient-to-r from-blue-600 to-green-600 hover:from-blue-700 hover:to-green-700 text-white font-semibold py-3 px-8 rounded-full shadow-lg transition-all duration-200 transform hover:scale-105">
                <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                </svg>
                Actualiser la page
            </button>
        </div>
    </div>
</body>
</html>
