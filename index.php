<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AI-Powered Smart City Complaint System</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <style>
        .hero-bg {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            position: relative;
            overflow: hidden;
        }
        .hero-bg::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grain" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="25" cy="25" r="1" fill="%23ffffff" opacity="0.1"/><circle cx="75" cy="75" r="1" fill="%23ffffff" opacity="0.1"/><circle cx="50" cy="10" r="0.5" fill="%23ffffff" opacity="0.1"/></pattern></defs><rect width="100" height="100" fill="url(%23grain)"/></svg>');
        }
        .card-hover {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }
        .card-hover:hover {
            transform: translateY(-8px) scale(1.02);
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
            border-color: rgba(59, 130, 246, 0.3);
        }
        .feature-card {
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.1) 0%, rgba(255, 255, 255, 0.05) 100%);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        .glass-effect {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        .animate-float {
            animation: float 6s ease-in-out infinite;
        }
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
        }
        .gradient-text {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
    </style>
</head>
<body class="bg-gray-50">
    <!-- Navigation ---->
    <nav class="bg-white shadow-lg">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <h1 class="text-2xl font-bold text-gray-900">AI Smart City</h1>
                </div>
                <div class="flex items-center space-x-4">
                    <a href="public/" class="text-gray-700 hover:text-blue-600 px-3 py-2 rounded-md text-sm font-medium">
                        View Public Map
                    </a>
                    <?php if (!empty($_SESSION['user'])): ?>
                    <a href="public/<?php echo $_SESSION['user']['role']; ?>/dashboard" class="bg-blue-600 text-white px-3 py-2 rounded-md text-sm font-medium hover:bg-blue-700">
                        Go to Dashboard
                    </a>
                    <a href="public/logout" class="text-gray-700 hover:text-red-600 px-3 py-2 rounded-md text-sm font-medium">
                        Logout
                    </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </nav>

    <!-- Setup Notice -->
    <!-- <div class="bg-yellow-100 border-l-4 border-yellow-500 p-4">
        <div class="flex">
            <div class="flex-shrink-0">
                <svg class="h-5 w-5 text-yellow-400" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                </svg>
            </div>
            <div class="ml-3">
                <p class="text-sm text-yellow-700">
                    <strong>Setup Required:</strong> Make sure you've imported the database schema and created an admin user before using the application.
                </p>
            </div>
        </div>
    </div> -->

    <!-- Hero Section -->
    <div class="hero-bg relative">
        <!-- Floating Elements -->
        <div class="absolute inset-0 overflow-hidden">
            <!-- Circles -->
            <div class="animate-float absolute top-20 left-10 w-16 h-16 bg-white bg-opacity-10 rounded-full"></div>
            <div class="animate-float absolute bottom-32 left-1/4 w-8 h-8 bg-white bg-opacity-15 rounded-full" style="animation-delay: 4s;"></div>
            <div class="animate-float absolute bottom-20 right-1/3 w-6 h-6 bg-white bg-opacity-25 rounded-full" style="animation-delay: 3s;"></div>

            <!-- Squares/Rounded Squares -->
            <div class="animate-float absolute top-40 right-20 w-12 h-12 bg-white bg-opacity-20 rounded-lg" style="animation-delay: 2s;"></div>
            <div class="animate-float absolute top-1/3 right-10 w-20 h-20 bg-white bg-opacity-5 rounded-lg" style="animation-delay: 1s;"></div>
            <div class="animate-float absolute top-1/4 left-1/3 w-10 h-10 bg-blue-200 bg-opacity-20 rounded-lg" style="animation-delay: 5s;"></div>

            <!-- Triangles -->
            <div class="animate-float absolute top-16 right-1/4 w-0 h-0 border-l-8 border-r-8 border-b-16 border-l-transparent border-r-transparent border-b-white border-opacity-10" style="animation-delay: 6s;"></div>
            <div class="animate-float absolute bottom-40 left-16 w-0 h-0 border-l-6 border-r-6 border-b-12 border-l-transparent border-r-transparent border-b-purple-200 border-opacity-15" style="animation-delay: 7s;"></div>

            <!-- Hexagons -->
            <div class="animate-float absolute top-1/2 left-20 w-14 h-12 bg-green-200 bg-opacity-10 rounded-lg transform rotate-45" style="animation-delay: 8s;"></div>
            <div class="animate-float absolute bottom-24 right-32 w-10 h-8 bg-red-200 bg-opacity-15 rounded-lg transform rotate-45" style="animation-delay: 9s;"></div>

            <!-- Dots -->
            <div class="animate-float absolute top-32 left-1/2 w-4 h-4 bg-yellow-200 bg-opacity-20 rounded-full" style="animation-delay: 10s;"></div>
            <div class="animate-float absolute bottom-16 right-16 w-3 h-3 bg-pink-200 bg-opacity-25 rounded-full" style="animation-delay: 11s;"></div>
        </div>

        <div class="relative max-w-7xl mx-auto py-16 px-4 sm:py-24 sm:px-6 lg:px-8">
            <div class="text-center">
                <div class="mb-6">
                    <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-medium bg-white bg-opacity-20 text-white backdrop-blur-sm border border-white border-opacity-30">
                        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                        </svg>
                        AI-Powered Smart City Platform
                    </span>
                </div>
                <h1 class="text-4xl font-extrabold text-white sm:text-5xl md:text-6xl leading-tight">
                    Transform Your City with
                    <span class="block gradient-text">Smart Complaint Management</span>
                </h1>
                <p class="mt-6 max-w-md mx-auto text-base text-blue-100 sm:text-lg md:mt-8 md:text-xl md:max-w-3xl leading-relaxed">
                    Revolutionize civic engagement with our AI-powered platform. Citizens report issues instantly,
                    authorities resolve them efficiently. Track progress on interactive maps and drive meaningful change.
                </p>
                <div class="mt-8 flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="public/register" class="inline-flex items-center px-8 py-4 border border-transparent text-base font-medium rounded-lg text-blue-600 bg-white hover:bg-gray-50 transform hover:scale-105 transition-all duration-200 shadow-lg">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                        </svg>
                        Get Started Free
                    </a>
                    <a href="public/" class="inline-flex items-center px-8 py-4 border border-white border-opacity-30 text-base font-medium rounded-lg text-white bg-transparent hover:bg-white hover:bg-opacity-10 backdrop-blur-sm transform hover:scale-105 transition-all duration-200">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"></path>
                        </svg>
                        View Live Map
                    </a>
                </div>

                <!-- Stats Preview -->
                <div class="mt-12 grid grid-cols-3 gap-8 max-w-md mx-auto">
                    <div class="text-center">
                        <div class="text-2xl font-bold text-white">500+</div>
                        <div class="text-sm text-blue-100">Complaints Resolved</div>
                    </div>
                    <div class="text-center">
                        <div class="text-2xl font-bold text-white">24/7</div>
                        <div class="text-sm text-blue-100">Real-time Tracking</div>
                    </div>
                    <div class="text-center">
                        <div class="text-2xl font-bold text-white">AI</div>
                        <div class="text-sm text-blue-100">Smart Classification</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Login Options -->
    <div class="max-w-7xl mx-auto py-16 px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-extrabold text-gray-900">
                Choose Your Access Level
            </h2>
            <p class="mt-4 text-lg text-gray-600">
                Select how you'd like to access the system
            </p>
        </div>

        <div class="grid grid-cols-1 gap-8 sm:grid-cols-2 lg:grid-cols-3">

            <!-- Citizen Access -->
            <div class="card-hover bg-white rounded-lg shadow-md overflow-hidden">
                <div class="p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-12 h-12 bg-blue-500 rounded-lg flex items-center justify-center">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-lg font-medium text-gray-900">Citizen Portal</h3>
                            <p class="text-sm text-gray-500">Report issues and track complaints</p>
                        </div>
                    </div>
                    <div class="mt-6 space-y-3">
                        <a href="public/register" class="w-full bg-blue-600 text-white px-4 py-2 rounded-md text-sm font-medium hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 block text-center">
                            Register as Citizen
                        </a>
                        <a href="public/login" class="w-full bg-gray-100 text-gray-700 px-4 py-2 rounded-md text-sm font-medium hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 block text-center">
                            Login as Citizen
                        </a>
                    </div>
                </div>
            </div>

            <!-- Authority Access -->
            <div class="card-hover bg-white rounded-lg shadow-md overflow-hidden">
                <div class="p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-12 h-12 bg-green-500 rounded-lg flex items-center justify-center">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-lg font-medium text-gray-900">Authority Portal</h3>
                            <p class="text-sm text-gray-500">Manage and resolve complaints</p>
                        </div>
                    </div>
                    <div class="mt-6 space-y-3">
                        <a href="public/login?role=authority" class="w-full bg-green-600 text-white px-4 py-2 rounded-md text-sm font-medium hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 block text-center">
                            Login as Officer
                        </a>
                        <p class="text-xs text-gray-500 text-center">
                            Contact admin to create officer account
                        </p>
                    </div>
                </div>
            </div>

            <!-- Admin Access -->
            <div class="card-hover bg-white rounded-lg shadow-md overflow-hidden">
                <div class="p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-12 h-12 bg-purple-500 rounded-lg flex items-center justify-center">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-lg font-medium text-gray-900">Admin Portal</h3>
                            <p class="text-sm text-gray-500">System administration & analytics</p>
                        </div>
                    </div>
                    <div class="mt-6 space-y-3">
                        <a href="public/login?role=admin" class="w-full bg-purple-600 text-white px-4 py-2 rounded-md text-sm font-medium hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2 block text-center">
                            Login as Admin
                        </a>
                        <p class="text-xs text-gray-500 text-center">
                            Administrative access only
                        </p>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <!-- How It Works Section -->
    <div class="bg-white py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-extrabold text-gray-900 mb-4">
                    How It Works
                </h2>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                    Simple, efficient, and transparent process from complaint submission to resolution.
                </p>
            </div>

            <div class="relative">
                <!-- Connection Line -->
                <div class="hidden md:block absolute top-24 left-1/2 transform -translate-x-1/2 w-full max-w-4xl">
                    <div class="flex justify-between">
                        <div class="w-4 h-4 bg-blue-500 rounded-full"></div>
                        <div class="w-4 h-4 bg-green-500 rounded-full"></div>
                        <div class="w-4 h-4 bg-purple-500 rounded-full"></div>
                        <div class="w-4 h-4 bg-red-500 rounded-full"></div>
                    </div>
                    <div class="absolute top-2 left-2 right-2 h-px bg-gradient-to-r from-blue-500 via-green-500 via-purple-500 to-red-500"></div>
                </div>

                <div class="grid grid-cols-1 gap-12 md:grid-cols-4 relative z-10">
                    <!-- Step 1 -->
                    <div class="text-center">
                        <div class="mx-auto w-16 h-16 bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl flex items-center justify-center shadow-lg mb-6">
                            <span class="text-2xl font-bold text-white">1</span>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-900 mb-3">Report Issue</h3>
                        <p class="text-gray-600 leading-relaxed">Citizens submit complaints through our user-friendly interface with location tracking and detailed descriptions.</p>
                    </div>

                    <!-- Step 2 -->
                    <div class="text-center">
                        <div class="mx-auto w-16 h-16 bg-gradient-to-br from-green-500 to-green-600 rounded-2xl flex items-center justify-center shadow-lg mb-6">
                            <span class="text-2xl font-bold text-white">2</span>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-900 mb-3">AI Classification</h3>
                        <p class="text-gray-600 leading-relaxed">Our AI automatically categorizes and prioritizes complaints, routing them to the appropriate department.</p>
                    </div>

                    <!-- Step 3 -->
                    <div class="text-center">
                        <div class="mx-auto w-16 h-16 bg-gradient-to-br from-purple-500 to-purple-600 rounded-2xl flex items-center justify-center shadow-lg mb-6">
                            <span class="text-2xl font-bold text-white">3</span>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-900 mb-3">Authority Response</h3>
                        <p class="text-gray-600 leading-relaxed">Officers receive notifications and work on resolving issues with real-time status updates.</p>
                    </div>

                    <!-- Step 4 -->
                    <div class="text-center">
                        <div class="mx-auto w-16 h-16 bg-gradient-to-br from-red-500 to-red-600 rounded-2xl flex items-center justify-center shadow-lg mb-6">
                            <span class="text-2xl font-bold text-white">4</span>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-900 mb-3">Resolution & Feedback</h3>
                        <p class="text-gray-600 leading-relaxed">Complaints are resolved and citizens receive notifications with options to provide feedback.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Features Section -->
    <div class="bg-gradient-to-br from-gray-50 to-blue-50 py-20 relative overflow-hidden">
        <!-- Background Pattern -->
        <div class="absolute inset-0 opacity-5">
            <div class="absolute top-10 left-10 w-32 h-32 bg-blue-500 rounded-full"></div>
            <div class="absolute bottom-10 right-10 w-24 h-24 bg-purple-500 rounded-lg"></div>
            <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-40 h-40 bg-green-500 rounded-full"></div>
        </div>

        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-extrabold text-gray-900 mb-4">
                    Powerful Features for Smart Cities
                </h2>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                    Our comprehensive platform combines cutting-edge AI technology with intuitive design to streamline civic engagement and urban management.
                </p>
            </div>

            <div class="grid grid-cols-1 gap-8 sm:grid-cols-2 lg:grid-cols-4">
                <!-- AI Classification -->
                <div class="feature-card p-8 rounded-2xl text-center transform hover:scale-105 transition-all duration-300">
                    <div class="mx-auto h-16 w-16 flex items-center justify-center rounded-2xl bg-gradient-to-br from-blue-500 to-blue-600 text-white shadow-lg">
                        <svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                    </div>
                    <h3 class="mt-6 text-xl font-semibold text-gray-900">AI Classification</h3>
                    <p class="mt-3 text-gray-600 leading-relaxed">Intelligent algorithms automatically categorize and prioritize complaints for optimal resolution efficiency.</p>
                </div>

                <!-- GIS Mapping -->
                <div class="feature-card p-8 rounded-2xl text-center transform hover:scale-105 transition-all duration-300">
                    <div class="mx-auto h-16 w-16 flex items-center justify-center rounded-2xl bg-gradient-to-br from-green-500 to-green-600 text-white shadow-lg">
                        <svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"></path>
                        </svg>
                    </div>
                    <h3 class="mt-6 text-xl font-semibold text-gray-900">GIS Mapping</h3>
                    <p class="mt-3 text-gray-600 leading-relaxed">Interactive maps with precise location tracking and real-time complaint visualization.</p>
                </div>

                <!-- Analytics -->
                <div class="feature-card p-8 rounded-2xl text-center transform hover:scale-105 transition-all duration-300">
                    <div class="mx-auto h-16 w-16 flex items-center justify-center rounded-2xl bg-gradient-to-br from-purple-500 to-purple-600 text-white shadow-lg">
                        <svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                    </div>
                    <h3 class="mt-6 text-xl font-semibold text-gray-900">Advanced Analytics</h3>
                    <p class="mt-3 text-gray-600 leading-relaxed">Comprehensive reporting and data insights to drive informed decision-making and policy development.</p>
                </div>

                <!-- Secure Access -->
                <div class="feature-card p-8 rounded-2xl text-center transform hover:scale-105 transition-all duration-300">
                    <div class="mx-auto h-16 w-16 flex items-center justify-center rounded-2xl bg-gradient-to-br from-red-500 to-red-600 text-white shadow-lg">
                        <svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                        </svg>
                    </div>
                    <h3 class="mt-6 text-xl font-semibold text-gray-900">Secure Access</h3>
                    <p class="mt-3 text-gray-600 leading-relaxed">Enterprise-grade security with role-based permissions and comprehensive data protection.</p>
                </div>
            </div>

            <!-- Additional Features Row -->
            <div class="mt-16 grid grid-cols-1 gap-6 sm:grid-cols-3">
                <div class="glass-effect p-6 rounded-xl text-center">
                    <div class="text-3xl font-bold text-blue-600 mb-2">24/7</div>
                    <div class="text-gray-700 font-medium">Always Available</div>
                    <div class="text-sm text-gray-500 mt-1">Round-the-clock complaint submission</div>
                </div>
                <div class="glass-effect p-6 rounded-xl text-center">
                    <div class="text-3xl font-bold text-green-600 mb-2">AI</div>
                    <div class="text-gray-700 font-medium">Smart Routing</div>
                    <div class="text-sm text-gray-500 mt-1">Automatic assignment to right department</div>
                </div>
                <div class="glass-effect p-6 rounded-xl text-center">
                    <div class="text-3xl font-bold text-purple-600 mb-2">Real-time</div>
                    <div class="text-gray-700 font-medium">Live Updates</div>
                    <div class="text-sm text-gray-500 mt-1">Instant notifications and status tracking</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-white">
        <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <p class="text-base text-gray-500">
                    &copy; 2025 AI-Powered Smart City Complaint System. Built for efficient civic engagement.
                </p>
            </div>
        </div>
    </footer>

    <!-- Quick Access Modal (Optional) -->
    <div id="quickAccessModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden" id="my-modal">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="mt-3 text-center">
                <h3 class="text-lg font-medium text-gray-900" id="modal-title">Quick Access</h3>
                <div class="mt-2 px-7 py-3">
                    <p class="text-sm text-gray-500" id="modal-content">
                        Choose your preferred access method above.
                    </p>
                </div>
                <div class="flex items-center px-4 py-3">
                    <button id="closeModal" class="px-4 py-2 bg-blue-500 text-white text-base font-medium rounded-md w-full shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-300">
                        Close
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Simple modal functionality (optional)
        const modal = document.getElementById('quickAccessModal');
        const closeModal = document.getElementById('closeModal');

        // You can add modal triggers here if needed
        closeModal.onclick = function() {
            modal.classList.add('hidden');
        }

        // Close modal when clicking outside
        window.onclick = function(event) {
            if (event.target == modal) {
                modal.classList.add('hidden');
            }
        }
    </script>
</body>
</html>