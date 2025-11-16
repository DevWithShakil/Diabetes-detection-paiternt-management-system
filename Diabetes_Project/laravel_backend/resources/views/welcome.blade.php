<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Diabetes Detection & Patient Management</title>

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: #eef2f7;
            font-family: 'Poppins', sans-serif;
        }

        /* HERO SECTION */
        .hero-section {
            background: linear-gradient(135deg, #0062ff, #00c2ff);
            color: white;
            border-radius: 20px;
            padding: 70px 50px;
            box-shadow: 0 12px 40px rgba(0,0,0,0.15);
        }

        .hero-title {
            font-size: 48px;
            font-weight: 700;
        }

        .sub-text {
            font-size: 18px;
            opacity: .9;
        }

        /* FEATURES */
        .feature-box {
            background: white;
            border-radius: 15px;
            padding: 25px;
            text-align: center;
            transition: .3s;
            box-shadow: 0 4px 20px rgba(0,0,0,0.08);
        }
        .feature-box:hover {
            transform: translateY(-6px);
            box-shadow: 0 6px 25px rgba(0,0,0,0.12);
        }
        .feature-icon {
            font-size: 36px;
            margin-bottom: 15px;
        }

        /* AUTH CARD */
        .auth-card {
            background: white;
            border-radius: 18px;
            padding: 35px;
            box-shadow: 0 8px 30px rgba(0,0,0,0.12);
        }

        .tab-btn {
            font-weight: 600;
            border-radius: 50px;
        }
        .tab-btn.active {
            background: #0062ff;
            color: white !important;
        }
    </style>
</head>
<body>

<!-- NAVBAR -->
<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm py-3">
    <div class="container">
        <h3 class="fw-bold text-primary m-0">🔬 Diabetes Management System</h3>
    </div>
</nav>

<div class="container mt-5">
    <div class="row g-4 align-items-center">

        <!-- LEFT: HERO + FEATURES -->
        <div class="col-lg-7">

            <div class="hero-section mb-4">
                <h1 class="hero-title">Your Health, Powered by AI</h1>
                <p class="sub-text mt-3">A complete platform for diabetes prediction, doctor appointments, medical reports and intelligent patient management.</p>
                <a href="#auth" class="btn btn-light btn-lg mt-3 fw-semibold px-5">Get Started →</a>
            </div>

            <div class="row g-4 mt-2">
                <div class="col-md-4">
                    <div class="feature-box">
                        <div class="feature-icon">🤖</div>
                        <h5 class="fw-bold">AI Prediction</h5>
                        <p class="small">Instant diabetes prediction using ML.</p>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="feature-box">
                        <div class="feature-icon">🩺</div>
                        <h5 class="fw-bold">Specialist Doctors</h5>
                        <p class="small">Consult verified diabetes experts.</p>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="feature-box">
                        <div class="feature-icon">📊</div>
                        <h5 class="fw-bold">Smart Reports</h5>
                        <p class="small">Access detailed medical insights.</p>
                    </div>
                </div>
            </div>

        </div>

        <!-- RIGHT: LOGIN | REGISTER -->
        <div class="col-lg-5" id="auth">
            <div class="auth-card">

                <div class="d-flex mb-4">
                    <button class="btn tab-btn flex-fill active" id="loginTab">Login</button>
                    <button class="btn tab-btn flex-fill" id="registerTab">Register</button>
                </div>

                <!-- LOGIN FORM -->
                <div id="loginForm">
                    <form method="POST" action="/login">
                        @csrf
                        <div class="mb-3">
                            <label class="fw-semibold">Email</label>
                            <input type="email" name="email" class="form-control form-control-lg" required>
                        </div>
                        <div class="mb-3">
                            <label class="fw-semibold">Password</label>
                            <input type="password" name="password" class="form-control form-control-lg" required>
                        </div>
                        <button class="btn btn-primary w-100 btn-lg">Log In</button>
                    </form>
                </div>

                <!-- REGISTER FORM -->
                <div id="registerForm" style="display:none;">
                    <form method="POST" action="/register">
                        @csrf
                        <div class="mb-3">
                            <label class="fw-semibold">Full Name</label>
                            <input type="text" name="name" class="form-control form-control-lg" required>
                        </div>
                        <div class="mb-3">
                            <label class="fw-semibold">Email</label>
                            <input type="email" name="email" class="form-control form-control-lg" required>
                        </div>
                        <div class="mb-3">
                            <label class="fw-semibold">Password</label>
                            <input type="password" name="password" class="form-control form-control-lg" required>
                        </div>
                        <div class="mb-3">
                            <label class="fw-semibold">Confirm Password</label>
                            <input type="password" name="password_confirmation" class="form-control form-control-lg" required>
                        </div>
                        <button class="btn btn-success w-100 btn-lg">Create Account</button>
                    </form>
                </div>

            </div>
        </div>

    </div>
</div>

<script>
    const loginTab = document.getElementById('loginTab');
    const registerTab = document.getElementById('registerTab');
    const loginForm = document.getElementById('loginForm');
    const registerForm = document.getElementById('registerForm');

    loginTab.addEventListener('click', () => {
        loginTab.classList.add('active');
        registerTab.classList.remove('active');
        loginForm.style.display = 'block';
        registerForm.style.display = 'none';
    });

    registerTab.addEventListener('click', () => {
        registerTab.classList.add('active');
        loginTab.classList.remove('active');
        registerForm.style.display = 'block';
        loginForm.style.display = 'none';
    });
</script>

</body>
</html>
