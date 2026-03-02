<style>
    /* Navbar Container */
    .nav-flex-column {
        padding: 1rem 0.5rem;
        height: 100%;
        background: #212529;
        overflow-x: hidden;
        overflow-y: auto;
    }

    /* Nav Header */
    .nav-header {
        padding: 1.25rem 1rem 0.75rem;
        color: #6c757d;
        font-size: 0.688rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.1em;
        margin: 0 0.5rem 1rem;
        border-bottom: 2px solid rgba(255, 255, 255, 0.08);
        position: relative;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .nav-header::after {
        content: '';
        position: absolute;
        bottom: -2px;
        left: 0;
        width: 40px;
        height: 2px;
        background: linear-gradient(90deg, #667eea 0%, #764ba2 100%);
        border-radius: 1px;
    }

    /* Nav Items */
    .nav-item {
        margin-bottom: 0.375rem;
        animation: fadeInLeft 0.5s ease forwards;
        opacity: 0;
        list-style: none;
    }

    @keyframes fadeInLeft {
        from {
            opacity: 0;
            transform: translateX(-10px);
        }
        to {
            opacity: 1;
            transform: translateX(0);
        }
    }

    .nav-item:nth-child(2) { animation-delay: 0.1s; }
    .nav-item:nth-child(3) { animation-delay: 0.2s; }
    .nav-item:nth-child(4) { animation-delay: 0.3s; }
    .nav-item:nth-child(5) { animation-delay: 0.4s; }
    .nav-item:nth-child(6) { animation-delay: 0.5s; }

    /* Navbar Links */
    .navbar-item {
        color: #adb5bd;
        text-decoration: none;
        background: transparent;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        padding: 0.875rem 0.75rem;
        display: flex;
        align-items: center;
        font-size: 0.875rem;
        font-weight: 500;
        border-radius: 10px;
        margin: 0;
        position: relative;
        overflow: hidden;
        border: 1px solid transparent;
        width: 100%;
    }

    .navbar-item span {
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        flex: 1;
    }

    /* Left Border Indicator */
    .navbar-item::before {
        content: '';
        position: absolute;
        left: 0;
        top: 50%;
        transform: translateY(-50%) scaleY(0);
        height: 60%;
        width: 3px;
        background: linear-gradient(180deg, #667eea 0%, #764ba2 100%);
        transition: transform 0.3s ease;
        border-radius: 0 2px 2px 0;
        z-index: 2;
    }

    /* Icon Styling */
    .navbar-item i {
        margin-right: 0.75rem;
        font-size: 1.125rem;
        width: 24px;
        min-width: 24px;
        text-align: center;
        transition: all 0.3s ease;
        position: relative;
        z-index: 1;
        flex-shrink: 0;
    }

    /* Hover Effect */
    .navbar-item:hover {
        color: #ffffff;
        background: rgba(102, 126, 234, 0.12);
        border-color: rgba(102, 126, 234, 0.2);
    }

    .navbar-item:hover::before {
        transform: translateY(-50%) scaleY(1);
    }

    .navbar-item:hover i {
        transform: scale(1.1);
        color: #764ba2;
    }

    /* Glow Effect on Hover */
    .navbar-item::after {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: radial-gradient(circle at center, rgba(102, 126, 234, 0.15) 0%, transparent 70%);
        transition: opacity 0.4s ease;
        opacity: 0;
        pointer-events: none;
    }

    .navbar-item:hover::after {
        opacity: 1;
    }

    /* Active State */
    .navbar-item.active {
        color: #ffffff;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-color: transparent;
        box-shadow: 
            0 2px 8px rgba(102, 126, 234, 0.4),
            inset 0 1px 0 rgba(255, 255, 255, 0.15);
        font-weight: 600;
    }

    .navbar-item.active::before {
        display: none;
    }

    .navbar-item.active i {
        color: #ffffff;
        filter: drop-shadow(0 1px 2px rgba(0, 0, 0, 0.3));
        transform: none;
    }

    /* Active State Subtle Shine */
    .navbar-item.active::after {
        content: '';
        position: absolute;
        top: 0;
        left: -150%;
        width: 100%;
        height: 100%;
        background: linear-gradient(
            90deg,
            transparent 0%,
            rgba(255, 255, 255, 0.15) 50%,
            transparent 100%
        );
        animation: shine 4s ease-in-out infinite;
        pointer-events: none;
    }

    @keyframes shine {
        0%, 100% {
            left: -150%;
        }
        50% {
            left: 150%;
        }
    }

    /* Divider between items */
    .nav-divider {
        height: 1px;
        background: linear-gradient(
            90deg,
            transparent 0%,
            rgba(255, 255, 255, 0.1) 50%,
            transparent 100%
        );
        margin: 0.75rem 0.5rem;
    }

    /* Scrollbar Styling for Navbar */
    .nav-flex-column::-webkit-scrollbar {
        width: 4px;
    }

    .nav-flex-column::-webkit-scrollbar-track {
        background: rgba(255, 255, 255, 0.05);
        border-radius: 2px;
    }

    .nav-flex-column::-webkit-scrollbar-thumb {
        background: rgba(102, 126, 234, 0.4);
        border-radius: 2px;
    }

    .nav-flex-column::-webkit-scrollbar-thumb:hover {
        background: rgba(102, 126, 234, 0.6);
    }

    /* Responsive adjustments */
    @media (max-width: 768px) {
        .nav-flex-column {
            padding: 0.75rem 0.25rem;
        }
        
        .navbar-item {
            font-size: 0.813rem;
            padding: 0.75rem 0.625rem;
        }

        .navbar-item i {
            font-size: 1rem;
            margin-right: 0.625rem;
            width: 20px;
            min-width: 20px;
        }

        .nav-header {
            font-size: 0.625rem;
            padding: 1rem 0.75rem 0.625rem;
            margin: 0 0.25rem 0.75rem;
        }
        
        .nav-divider {
            margin: 0.5rem 0.25rem;
        }
    }
</style>

<nav class="nav flex-column nav-flex-column">
    <!-- Header -->
    <div class="nav-header">
        <i class="fas fa-bars me-2"></i>Navegación
    </div>
    
    @isset($navigation)
        @foreach ($navigation as $key_nav => $route_nav)
            <li class="nav-item">
                <a class="nav-link navbar-item {{ request()->is($route_nav) ? 'active' : '' }}" 
                   href="{{ $route_nav }}"
                   title="{{ $key_nav }}">
                    <i class="fas fa-{{ $loop->index == 0 ? 'home' : ($loop->index == 1 ? 'chart-bar' : ($loop->index == 2 ? 'credit-card' : ($loop->index == 3 ? 'users' : 'cog'))) }}"></i>
                    <span>{{ $key_nav }}</span>
                </a>
            </li>
            
            @if($loop->index == 1)
                <div class="nav-divider"></div>
            @endif
        @endforeach
    @endisset
</nav>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">