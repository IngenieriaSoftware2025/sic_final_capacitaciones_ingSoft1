
    <style>
        body {
            background: linear-gradient(135deg,rgb(34, 45, 96) 0%,rgb(75, 87, 162) 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
        }
        
        .welcome-container {
            background: white;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }
        
        .header-section {
            background: linear-gradient(45deg, #2c3e50, #3498db);
            color: white;
            text-align: center;
            padding: 3rem 2rem;
        }
        
        .welcome-title {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
        }
        
        .welcome-subtitle {
            font-size: 1.2rem;
            opacity: 0.9;
        }
        
        .content-section {
            padding: 3rem 2rem;
            text-align: center;
        }
        
        .login-btn {
            background: linear-gradient(45deg, #28a745, #20c997);
            border: none;
            padding: 1rem 3rem;
            font-size: 1.2rem;
            font-weight: 600;
            border-radius: 50px;
            color: white;
            text-decoration: none;
            display: inline-block;
            transition: all 0.3s ease;
        }
        
        .login-btn:hover {
            background: linear-gradient(45deg, #218838, #1abc9c);
            color: white;
            text-decoration: none;
            transform: translateY(-2px);
        }
        
        .footer-info {
            background: #f8f9fa;
            padding: 1.5rem;
            text-align: center;
            font-size: 0.9rem;
            color: #6c757d;
        }
        
        @media (max-width: 768px) {
            .welcome-title {
                font-size: 2rem;
            }
            .content-section {
                padding: 2rem 1rem;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6 col-md-8">
                <div class="welcome-container">
                    <div class="header-section">
                        <h1 class="welcome-title">Bienvenido</h1>
                        <p class="welcome-subtitle">Gestión de Aplicaciones MINDEF</p>
                    </div>
                    
                    <div class="content-section">
                        <div class="mt-4">
                            <a href="/sic_final_capacitaciones_ingSoft1/loginn" class="login-btn">
                                INICIAR SESIÓN
                            </a>
                        </div>
                    </div>
                    
                    <div class="footer-info">
                        <p class="mb-0">
                            Sistema Seguro • Comando de Informática y Tecnología, 2025
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>