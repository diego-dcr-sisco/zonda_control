@extends('layouts.app')
@section('login')
    <style>
        /* Paleta de colores ZONDA */
        :root {
            --zonda-dark-blue: #182A41;
            --zonda-blue-gray: #304054;
            --zonda-terracotta: #C3523E;
            --zonda-purple-blue: #344290;
            --zonda-deep-blue: #1D2D83;
            --zonda-light-accent: #f5f7fa;
        }
        
        .bg-zonda {
            background: var(--zonda-dark-blue);
            background: linear-gradient(90deg, var(--zonda-dark-blue) 0%, var(--zonda-blue-gray) 15%, var(--zonda-terracotta) 50%, var(--zonda-purple-blue) 85%, var(--zonda-deep-blue) 100%);
        }
        
        /* Animación de gradiente en movimiento */
        @keyframes gradientMove {
            0% {
                background-position: 0% 50%;
            }
            50% {
                background-position: 100% 50%;
            }
            100% {
                background-position: 0% 50%;
            }
        }
        
        .bg-animated {
            background: linear-gradient(-45deg, 
                var(--zonda-dark-blue), 
                var(--zonda-blue-gray), 
                var(--zonda-terracotta), 
                var(--zonda-purple-blue), 
                var(--zonda-deep-blue)
            );
            background-size: 400% 400%;
            animation: gradientMove 15s ease infinite;
            position: relative;
            overflow: hidden;
        }
        
        /* Partículas animadas en el fondo */
        .particles {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            overflow: hidden;
            z-index: 1;
        }
        
        .particle {
            position: absolute;
            border-radius: 50%;
            animation: float 25s infinite linear;
            filter: blur(1px);
        }
        
        @keyframes float {
            0% {
                transform: translateY(100vh) translateX(0) rotate(0deg);
                opacity: 0;
            }
            10% {
                opacity: 0.3;
            }
            90% {
                opacity: 0.3;
            }
            100% {
                transform: translateY(-100px) translateX(calc(100vw * var(--x-mult))) rotate(720deg);
                opacity: 0;
            }
        }
        
        /* Efectos de brillo */
        .glow-effect {
            position: absolute;
            width: 400px;
            height: 400px;
            border-radius: 50%;
            filter: blur(60px);
            animation: glowMove 12s ease-in-out infinite alternate;
            z-index: 1;
        }
        
        .glow-terracotta {
            background: radial-gradient(circle, 
                rgba(195, 82, 62, 0.2) 0%, 
                rgba(195, 82, 62, 0) 70%);
        }
        
        .glow-purple {
            background: radial-gradient(circle, 
                rgba(52, 66, 144, 0.2) 0%, 
                rgba(52, 66, 144, 0) 70%);
            animation: glowMove2 10s ease-in-out infinite alternate-reverse;
        }
        
        @keyframes glowMove {
            0% {
                transform: translate(-150px, -150px) scale(1);
            }
            100% {
                transform: translate(150px, 150px) scale(1.2);
            }
        }
        
        @keyframes glowMove2 {
            0% {
                transform: translate(120px, -120px) scale(1);
            }
            100% {
                transform: translate(-120px, 120px) scale(1.1);
            }
        }
        
        /* Contenedor del formulario */
        .form-container {
            position: relative;
            z-index: 2;
        }
        
        /* Animación de entrada para el card */
        @keyframes cardEntrance {
            from {
                opacity: 0;
                transform: translateY(40px) scale(0.95);
            }
            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }
        
        .card-animated {
            animation: cardEntrance 0.7s cubic-bezier(0.34, 1.56, 0.64, 1);
            background: white !important;
            border-radius: 16px !important;
            overflow: hidden;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.25);
        }
        
        /* Título "Control Maestro ZONDA" */
        .system-title {
            background: linear-gradient(45deg, 
                var(--zonda-dark-blue), 
                var(--zonda-terracotta),
                var(--zonda-purple-blue)
            );
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
            font-size: 1.8rem;
            font-weight: 800;
            letter-spacing: 1px;
            text-transform: uppercase;
            position: relative;
            padding-bottom: 12px;
            margin-bottom: 15px;
        }
        
        .system-title::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 25%;
            width: 50%;
            height: 3px;
            background: linear-gradient(90deg, 
                var(--zonda-dark-blue), 
                var(--zonda-terracotta), 
                var(--zonda-purple-blue)
            );
            border-radius: 3px;
        }
        
        /* Subtítulo */
        .system-subtitle {
            color: var(--zonda-blue-gray);
            font-size: 0.95rem;
            font-weight: 400;
            letter-spacing: 1px;
            text-transform: uppercase;
            margin-bottom: 30px;
            opacity: 0.8;
        }
        
        /* Botón de login */
        .btn-login {
            background: linear-gradient(45deg, 
                var(--zonda-terracotta) 0%, 
                var(--zonda-purple-blue) 50%, 
                var(--zonda-deep-blue) 100%);
            border: none !important;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
            color: white;
            font-weight: 600;
            letter-spacing: 0.5px;
            padding: 14px 0;
            border-radius: 10px !important;
            box-shadow: 0 6px 20px rgba(195, 82, 62, 0.3);
        }
        
        .btn-login:hover {
            transform: translateY(-3px) scale(1.02);
            box-shadow: 0 12px 25px rgba(195, 82, 62, 0.4);
        }
        
        .btn-login:active {
            transform: translateY(-1px) scale(1.01);
        }
        
        .btn-login::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, 
                transparent, 
                rgba(255, 255, 255, 0.2), 
                transparent);
            transition: left 0.7s;
        }
        
        .btn-login:hover::before {
            left: 100%;
        }
        
        /* Inputs */
        .input-group {
            transition: all 0.3s ease;
            border-radius: 8px;
            overflow: hidden;
            border: 2px solid #e0e0e0;
        }
        
        .input-group:focus-within {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(24, 42, 65, 0.1);
            border-color: var(--zonda-terracotta);
        }
        
        .input-group:focus-within .input-group-text {
            background-color: rgba(195, 82, 62, 0.1);
            border-color: var(--zonda-terracotta);
            color: var(--zonda-terracotta);
        }
        
        .form-control {
            border: none !important;
            padding: 12px 15px;
            font-size: 1rem;
            transition: all 0.3s ease;
        }
        
        .form-control:focus {
            box-shadow: none !important;
        }
        
        .form-control::placeholder {
            color: #999;
            font-size: 0.95rem;
        }
        
        .input-group-text {
            background-color: #f8f9fa;
            border: none;
            color: #6c757d;
            padding: 12px 15px;
            border-right: 1px solid #e0e0e0;
        }
        
        /* Labels */
        .form-label {
            color: var(--zonda-dark-blue);
            font-weight: 600;
            margin-bottom: 8px;
            font-size: 0.95rem;
            display: block;
        }
        
        /* Botón mostrar/ocultar contraseña */
        .btn-eye {
            background-color: #f8f9fa !important;
            border: none !important;
            color: #6c757d !important;
            transition: all 0.3s ease;
            border-left: 1px solid #e0e0e0 !important;
            padding: 0 20px;
        }
        
        .btn-eye:hover {
            background-color: rgba(195, 82, 62, 0.1) !important;
            color: var(--zonda-terracotta) !important;
        }
        
        /* Alertas */
        .alert-danger {
            background: linear-gradient(45deg, rgba(195, 82, 62, 0.1), rgba(220, 53, 69, 0.05));
            border: 1px solid rgba(195, 82, 62, 0.2);
            color: var(--zonda-terracotta);
            border-radius: 8px;
            animation: fadeIn 0.5s ease;
        }
        
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            .system-title {
                font-size: 1.4rem;
            }
            
            .card {
                margin: 0 15px;
            }
            
            .glow-effect {
                width: 250px;
                height: 250px;
            }
        }
        
        /* Animación del logo */
        @keyframes logoFloat {
            0%, 100% {
                transform: translateY(0);
            }
            50% {
                transform: translateY(-8px);
            }
        }
        
        .logo-float {
            animation: logoFloat 5s ease-in-out infinite;
            filter: drop-shadow(0 4px 8px rgba(0, 0, 0, 0.1));
        }
        
        /* Mensaje de seguridad */
        .security-message {
            text-align: center;
            margin-top: 20px;
            padding-top: 15px;
            border-top: 1px solid #f0f0f0;
        }
        
        .security-message small {
            color: var(--zonda-blue-gray);
            font-size: 0.8rem;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 5px;
        }
    </style>

    <div class="container-fluid vh-100 bg-zonda bg-animated p-0 position-relative">
        <!-- Partículas animadas -->
        <div class="particles" id="particles"></div>
        
        <!-- Efectos de brillo -->
        <div class="glow-effect glow-terracotta" style="top: 20%; left: 5%;"></div>
        <div class="glow-effect glow-purple" style="bottom: 20%; right: 5%;"></div>
        
        <div class="row g-0 h-100 justify-content-center align-items-center">
            <div class="col-lg-4 col-10 form-container">
                <div class="card shadow-lg border-0 card-animated">
                    <!-- Logo y título -->
                    <div class="card-header bg-transparent border-0 pt-5 pb-3">
                        <div class="text-center">
                            <img src="{{ asset('images/logo.png') }}" 
                                 class="img-fluid logo-float" 
                                 alt="Logo ZONDA"
                                 style="max-height: 100px; margin-bottom: 15px;">
                            
                            <h1 class="system-title mb-2">
                                Control Maestro ZONDA
                            </h1>
                            
                            <div class="system-subtitle mb-0">
                                Acceso al Sistema
                            </div>
                        </div>
                    </div>

                    <div class="card-body px-4 pt-0 pb-4">
                        @if ($errors->any())
                            <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
                                <div class="d-flex align-items-center">
                                    <i class="bi bi-exclamation-triangle-fill me-2"></i>
                                    <div class="small">
                                        @foreach ($errors->all() as $error)
                                            <div class="mb-1">{{ $error }}</div>
                                        @endforeach
                                    </div>
                                </div>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        @endif

                        <form method="POST" action="{{ route('login') }}" id="loginForm">
                            @csrf

                            <!-- Campo de email -->
                            <div class="mb-4">
                                <label for="email" class="form-label">Usuario</label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="bi bi-person"></i>
                                    </span>
                                    <input type="text" 
                                           class="form-control" 
                                           id="email" 
                                           name="email"
                                           placeholder="Ingresa tu usuario" 
                                           value="{{ old('email') }}"
                                           maxlength="50" 
                                           required 
                                           autofocus>
                                </div>
                            </div>

                            <!-- Campo de contraseña -->
                            <div class="mb-4">
                                <label for="password" class="form-label">Contraseña</label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="bi bi-lock"></i>
                                    </span>
                                    <input type="password" 
                                           class="form-control" 
                                           id="password" 
                                           name="password"
                                           placeholder="Ingresa tu contraseña" 
                                           maxlength="50" 
                                           required>
                                    <button class="btn btn-eye" 
                                            type="button"
                                            onclick="togglePassword()" 
                                            id="togglePasswordBtn">
                                        <i id="eye-icon-pass" class="bi bi-eye"></i>
                                    </button>
                                </div>
                            </div>

                            <!-- Botón de submit -->
                            <div class="mb-3">
                                <button type="submit" class="btn btn-login w-100 py-3 fw-bold">
                                    <span class="position-relative">
                                        <i class="bi bi-box-arrow-in-right me-2"></i>
                                        Iniciar Sesión
                                    </span>
                                </button>
                            </div>
                        </form>

                        <!-- Mensaje de seguridad -->
                        <div class="security-message">
                            <small>
                                <i class="bi bi-shield-check"></i>
                                Acceso protegido por encriptación SSL
                            </small>
                        </div>
                    </div>
                    
                    <!-- Footer del card -->
                    <div class="card-footer bg-transparent border-0 text-center py-3">
                        <small class="text-muted">
                            <i class="bi bi-c-circle me-1"></i>
                            {{ date('Y') }} ZONDA Systems • v{{ config('app.version', '2.0.0') }}
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function togglePassword() {
            var passwordInput = $('#password');
            var eyeIcon = $('#eye-icon-pass');
            var toggleBtn = $('#togglePasswordBtn');

            if (passwordInput.attr('type') == 'text') {
                passwordInput.attr('type', 'password');
                eyeIcon.removeClass('bi-eye-slash').addClass('bi-eye');
                toggleBtn.find('i').css('color', '#6c757d');
                toggleBtn.style.backgroundColor = '#f8f9fa';
            } else {
                passwordInput.attr('type', 'text');
                eyeIcon.removeClass('bi-eye').addClass('bi-eye-slash');
                toggleBtn.find('i').css('color', '#C3523E');
                toggleBtn.style.backgroundColor = 'rgba(195, 82, 62, 0.1)';
            }
        }

        // Crear partículas animadas
        function createParticles() {
            const particlesContainer = document.getElementById('particles');
            const particleCount = 25;
            
            for (let i = 0; i < particleCount; i++) {
                const particle = document.createElement('div');
                particle.classList.add('particle');
                
                // Tamaño aleatorio
                const size = Math.random() * 60 + 30;
                particle.style.width = `${size}px`;
                particle.style.height = `${size}px`;
                
                // Posición inicial aleatoria
                particle.style.left = `${Math.random() * 100}%`;
                
                // Dirección aleatoria en X
                const xMult = Math.random() * 2 - 1;
                particle.style.setProperty('--x-mult', xMult);
                
                // Retraso de animación aleatorio
                particle.style.animationDelay = `${Math.random() * 25}s`;
                
                // Duración de animación aleatoria
                const duration = 20 + Math.random() * 30;
                particle.style.animationDuration = `${duration}s`;
                
                // Opacidad aleatoria
                const opacity = 0.1 + Math.random() * 0.2;
                particle.style.opacity = opacity;
                
                // Color aleatorio basado en la paleta ZONDA
                const colors = [
                    'rgba(195, 82, 62, 0.08)',
                    'rgba(52, 66, 144, 0.08)',
                    'rgba(29, 45, 131, 0.08)',
                    'rgba(24, 42, 65, 0.08)'
                ];
                particle.style.background = colors[Math.floor(Math.random() * colors.length)];
                
                particlesContainer.appendChild(particle);
            }
        }

        // Efectos de entrada
        document.addEventListener('DOMContentLoaded', function() {
            createParticles();
            
            // Animar inputs uno por uno
            const inputs = document.querySelectorAll('.form-control');
            inputs.forEach((input, index) => {
                setTimeout(() => {
                    input.style.opacity = '0';
                    input.style.transform = 'translateY(10px)';
                    input.offsetHeight;
                    input.style.transition = 'all 0.4s ease';
                    input.style.opacity = '1';
                    input.style.transform = 'translateY(0)';
                }, 300 + (index * 150));
            });
            
            // Efecto al enviar el formulario
            const form = document.getElementById('loginForm');
            form.addEventListener('submit', function(e) {
                const submitBtn = this.querySelector('button[type="submit"]');
                const originalHTML = submitBtn.innerHTML;
                
                submitBtn.innerHTML = `
                    <span class="position-relative">
                        <span class="spinner-border spinner-border-sm me-2"></span>
                        Verificando acceso...
                    </span>
                `;
                submitBtn.disabled = true;
                
                // Restaurar después de 3 segundos si hay error
                setTimeout(() => {
                    if (submitBtn.disabled) {
                        submitBtn.innerHTML = originalHTML;
                        submitBtn.disabled = false;
                    }
                }, 3000);
            });
            
            // Efecto hover en el card
            const card = document.querySelector('.card');
            card.addEventListener('mouseenter', () => {
                card.style.transform = 'translateY(-5px) scale(1.01)';
                card.style.boxShadow = '0 25px 50px rgba(0, 0, 0, 0.3)';
            });
            
            card.addEventListener('mouseleave', () => {
                card.style.transform = 'translateY(0) scale(1)';
                card.style.boxShadow = '0 20px 40px rgba(0, 0, 0, 0.25)';
            });
            
            // Efecto de enfoque en labels
            const labels = document.querySelectorAll('.form-label');
            labels.forEach(label => {
                const inputId = label.getAttribute('for');
                const input = document.getElementById(inputId);
                
                if (input) {
                    input.addEventListener('focus', () => {
                        label.style.color = 'var(--zonda-terracotta)';
                        label.style.fontWeight = '700';
                    });
                    
                    input.addEventListener('blur', () => {
                        if (!input.value) {
                            label.style.color = '';
                            label.style.fontWeight = '';
                        }
                    });
                }
            });
            
            // Autofocus en email
            const emailInput = document.getElementById('email');
            if (emailInput && !emailInput.value) {
                setTimeout(() => {
                    emailInput.focus();
                }, 600);
            }
            
            // Enter key para submit
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Enter' && !e.target.matches('button')) {
                    const submitBtn = document.querySelector('button[type="submit"]');
                    if (submitBtn && !submitBtn.disabled) {
                        submitBtn.click();
                    }
                }
            });
        });
    </script>
@endsection