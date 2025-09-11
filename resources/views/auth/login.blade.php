<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión - Vilba</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'vilba-orange': '#FF6B35',
                        'vilba-dark': '#1E293B',
                        'vilba-gray': '#64748B'
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-gradient-to-br from-vilba-orange to-orange-600 min-h-screen flex items-center justify-center p-4">
    <div class="w-full max-w-sm mx-auto">
        <!-- Logo y Header -->
        <div class="text-center mb-8">
            <img src="{{ asset('assets/img/logo/Vilba-logo.png') }}" alt="Vilba Logo" class="mx-auto h-16 w-auto mb-4">
            <h1 class="text-white text-xl font-bold mb-2">Servicios Industriales</h1>
        </div>
        
        <!-- Card de Login -->
        <div class="bg-vilba-dark rounded-lg shadow-xl p-6">
            <h2 class="text-white text-xl font-semibold text-center mb-6">
                Iniciar Sesión
            </h2>
        
            @if(session('success'))
                <div class="bg-green-500 text-white px-4 py-3 rounded-lg mb-4" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif
            
            <form action="{{ route('login') }}" method="POST" id="loginForm" class="space-y-4">
                @csrf
                
                <!-- Campo Email -->
                <div>
                    <label for="email" class="block text-white text-sm font-medium mb-2">Ingresa tu correo</label>
                    <input id="email" name="email" type="email" autocomplete="email" required 
                           class="w-full px-4 py-3 bg-gray-700 border border-gray-600 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-vilba-orange focus:border-transparent" 
                           placeholder="Correo Electrónico" value="{{ old('email') }}">
                    @error('email')
                        <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- Campo Contraseña -->
                <div>
                    <label for="password" class="block text-white text-sm font-medium mb-2">Ingresa tu contraseña</label>
                    <div class="relative">
                        <input id="password" name="password" type="password" autocomplete="current-password" required 
                               class="w-full px-4 py-3 pr-12 bg-gray-700 border border-gray-600 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-vilba-orange focus:border-transparent" 
                               placeholder="Contraseña">
                        <button type="button" id="togglePassword" class="absolute inset-y-0 right-0 pr-3 flex items-center">
                            <svg id="eyeIcon" class="h-5 w-5 text-gray-400 hover:text-white transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                        </button>
                    </div>
                    @error('password')
                        <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Botón de Iniciar Sesión -->
                <div class="pt-4">
                    <button type="submit" 
                            class="w-full bg-vilba-orange hover:bg-orange-600 text-white font-semibold py-3 px-4 rounded-lg transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:ring-offset-2 focus:ring-offset-vilba-dark">
                        Iniciar Sesión
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Funcionalidad para mostrar/ocultar contraseña
        document.getElementById('togglePassword').addEventListener('click', function() {
            const passwordInput = document.getElementById('password');
            const eyeIcon = document.getElementById('eyeIcon');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                eyeIcon.innerHTML = `
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.878 9.878L3 3m6.878 6.878L21 21" />
                `;
            } else {
                passwordInput.type = 'password';
                eyeIcon.innerHTML = `
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                `;
            }
        });
    </script>
</body>
</html>