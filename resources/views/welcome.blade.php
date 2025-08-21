<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Laravel') }} - Welcome</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        .welcome-bg {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        
        .quiz-card {
            transition: all 0.3s ease;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }
        
        .quiz-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }
        
        .feature-icon {
            width: 3rem;
            height: 3rem;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            background-color: #e0f2fe;
            color: #0ea5e9;
        }
        
        .btn-primary {
            background-color: #3b82f6;
            color: white;
            padding: 0.75rem 1.5rem;
            border-radius: 0.5rem;
            font-weight: 500;
            transition: all 0.2s ease;
            border: none;
        }
        
        .btn-primary:hover {
            background-color: #2563eb;
            transform: translateY(-2px);
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        }
        
        .btn-secondary {
            background-color: #f3f4f6;
            color: #4b5563;
            padding: 0.75rem 1.5rem;
            border-radius: 0.5rem;
            font-weight: 500;
            transition: all 0.2s ease;
            border: 1px solid #d1d5db;
        }
        
        .btn-secondary:hover {
            background-color: #e5e7eb;
            transform: translateY(-2px);
        }
        
        .stat-card {
            background: white;
            border-radius: 0.75rem;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        }
    </style>
</head>
<body class="font-sans antialiased">
    <div class="min-h-screen welcome-bg">
        <!-- Navigation -->
        <nav class="bg-white bg-opacity-90 backdrop-blur-sm shadow-sm">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 flex items-center">
                            <svg class="w-8 h-8 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.5-3.5 2.5-.879 0-1.933-.308-2.5-1m0 0V9m0 6h.01M9 15h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <span class="ml-2 text-xl font-bold text-gray-900">QuizMaster</span>
                        </div>
                    </div>
                    <div class="flex items-center">
                        @auth
                            <a href="{{ route('quizzes.index') }}" class="btn-primary">
                                Dashboard
                            </a>
                        @else
                            <div class="flex space-x-4">
                                <a href="{{ route('login') }}" class="btn-secondary">
                                    Login
                                </a>
                                <a href="{{ route('register') }}" class="btn-primary">
                                    Register
                                </a>
                            </div>
                        @endauth
                    </div>
                </div>
            </div>
        </nav>

        <!-- Hero Section -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 md:py-24">
            <div class="text-center">
                <h1 class="text-4xl md:text-6xl font-extrabold text-white tracking-tight">
                    Welcome to <span class="block text-indigo-200">QuizMaster</span>
                </h1>
                <p class="mt-6 max-w-lg mx-auto text-xl text-indigo-100">
                    Test your knowledge with our interactive quizzes. Create, take, and track your learning progress.
                </p>
                <div class="mt-10 flex justify-center gap-4">
                    @auth
                        <a href="{{ route('quizzes.index') }}" class="btn-primary">
                            View Quizzes
                        </a>
                    @else
                        <a href="{{ route('register') }}" class="btn-primary">
                            Get Started
                        </a>
                        <a href="{{ route('login') }}" class="btn-secondary">
                            Sign In
                        </a>
                    @endauth
                </div>
            </div>
        </div>

        <!-- Stats Section -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="stat-card p-6 text-center">
                    <div class="text-3xl font-bold text-indigo-600">50+</div>
                    <div class="mt-2 text-gray-600">Available Quizzes</div>
                </div>
                <div class="stat-card p-6 text-center">
                    <div class="text-3xl font-bold text-indigo-600">1000+</div>
                    <div class="mt-2 text-gray-600">Questions</div>
                </div>
                <div class="stat-card p-6 text-center">
                    <div class="text-3xl font-bold text-indigo-600">5000+</div>
                    <div class="mt-2 text-gray-600">Users</div>
                </div>
            </div>
        </div>

        <!-- Features Section -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
            <div class="text-center">
                <h2 class="text-3xl font-bold text-white">Why Choose QuizMaster?</h2>
                <p class="mt-4 text-xl text-indigo-100">Everything you need for an engaging learning experience</p>
            </div>

            <div class="mt-16 grid grid-cols-1 md:grid-cols-3 gap-12">
                <div class="quiz-card bg-white rounded-xl p-6">
                    <div class="feature-icon mx-auto">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </div>
                    <h3 class="mt-6 text-xl font-bold text-gray-900 text-center">Create Quizzes</h3>
                    <p class="mt-2 text-gray-600 text-center">
                        Build custom quizzes with multiple question types including multiple choice, true/false, and short answer.
                    </p>
                </div>

                <div class="quiz-card bg-white rounded-xl p-6">
                    <div class="feature-icon mx-auto">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0 0v-13M12 6.253v13m0-13c1.168-.776 2.754-1.253 4.5-1.253s3.332.477 4.5 1.253v13C20.832 18.477 19.246 18 17.5 18s-3.332.477-4.5 1.253"></path>
                        </svg>
                    </div>
                    <h3 class="mt-6 text-xl font-bold text-gray-900 text-center">Track Progress</h3>
                    <p class="mt-2 text-gray-600 text-center">
                        Monitor your learning with detailed results and performance analytics for each quiz attempt.
                    </p>
                </div>

                <div class="quiz-card bg-white rounded-xl p-6">
                    <div class="feature-icon mx-auto">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h3 class="mt-6 text-xl font-bold text-gray-900 text-center">Engaging Experience</h3>
                    <p class="mt-2 text-gray-600 text-center">
                        Enjoy a beautiful, intuitive interface designed to make learning fun and effective.
                    </p>
                </div>
            </div>
        </div>

        <!-- CTA Section -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
            <div class="bg-white rounded-2xl shadow-xl p-8 md:p-12 text-center">
                <h2 class="text-3xl font-bold text-gray-900">Ready to Test Your Knowledge?</h2>
                <p class="mt-4 text-xl text-gray-600">
                    Join thousands of students and educators using QuizMaster to enhance learning.
                </p>
                <div class="mt-8">
                    @auth
                        <a href="{{ route('quizzes.index') }}" class="btn-primary">
                            Start Taking Quizzes
                        </a>
                    @else
                        <a href="{{ route('register') }}" class="btn-primary">
                            Create Your Account
                        </a>
                    @endauth
                </div>
            </div>
        </div>

        <!-- Footer -->
        <footer class="bg-white bg-opacity-10 backdrop-blur-sm">
            <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
                <div class="text-center">
                    <p class="text-indigo-100">
                        &copy; {{ date('Y') }} QuizMaster. All rights reserved.
                    </p>
                </div>
            </div>
        </footer>
    </div>
</body>
</html>
