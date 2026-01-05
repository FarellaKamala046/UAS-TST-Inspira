<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Inspira OOTD - Microservice</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --bg-gradient: linear-gradient(135deg, #fff5f7 0%, #ffffff 100%);
            --accent-pink: #ff4d8d;
            --accent-light: #ffebf2;
            --text-dark: #2d3436;
            --shadow-premium: 0 20px 40px rgba(255, 77, 141, 0.08); /* Soft shadow pink tipis */
        }

        body {
            background: var(--bg-gradient);
            font-family: 'Plus Jakarta Sans', sans-serif;
            color: var(--text-dark);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .main-card {
            background: white;
            border-radius: 40px; /* Sudut sangat membulat agar modern */
            border: 1px solid rgba(255, 77, 141, 0.1);
            box-shadow: var(--shadow-premium);
            padding: 50px;
            max-width: 900px;
            width: 100%;
            position: relative;
            overflow: hidden;
        }

        /* Hiasan lingkaran di background agar tidak sepi */
        .main-card::before {
            content: "";
            position: absolute;
            top: -50px; right: -50px;
            width: 150px; height: 150px;
            background: var(--accent-light);
            border-radius: 50%;
            z-index: 0;
        }

        .content-wrapper { position: relative; z-index: 1; }

        h1 {
            font-weight: 800;
            font-size: 2.8rem;
            background: linear-gradient(to right, #c62828, #ff4d8d);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            margin-bottom: 10px;
        }

        .status-badge {
            display: inline-block;
            background: #e3fcef;
            color: #00a854;
            padding: 6px 16px;
            border-radius: 100px;
            font-size: 0.85rem;
            font-weight: 700;
            margin-bottom: 30px;
        }

        /* List Step Modern */
        .step-container {
            display: flex;
            flex-direction: column;
            gap: 20px;
            margin-top: 30px;
        }

        .step-card {
            background: #ffffff;
            border: 1px solid #f0f0f0;
            border-radius: 24px;
            padding: 20px 25px;
            display: flex;
            align-items: center;
            gap: 20px;
            transition: all 0.3s ease;
            text-decoration: none;
            color: inherit;
        }

        .step-card:hover {
            transform: translateX(10px);
            border-color: var(--accent-pink);
            box-shadow: 0 10px 25px rgba(255, 77, 141, 0.1);
        }

        .step-number {
            width: 45px; height: 45px;
            background: var(--accent-light);
            color: var(--accent-pink);
            border-radius: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 800;
            font-size: 1.2rem;
            flex-shrink: 0;
        }

        .step-content h3 {
            font-size: 1.1rem;
            font-weight: 700;
            margin: 0;
        }

        .step-content p {
            font-size: 0.9rem;
            color: #636e72;
            margin: 0;
        }

        .footer-text {
            margin-top: 40px;
            font-size: 0.8rem;
            color: #b2bec3;
            text-align: center;
        }

        code {
            background: #f8f9fa;
            padding: 2px 6px;
            border-radius: 5px;
            color: var(--accent-pink);
            font-weight: 600;
        }
    </style>
</head>
<body>

<div class="main-card">
    <div class="content-wrapper">
        <h1>Inspira OOTD System</h1>
        <div class="status-badge">● Microservice Online - v1.1</div>
        
        <p class="text-muted">Gunakan panduan di bawah ini untuk menguji layanan API secara mandiri:</p>

        <div class="step-container">
            <a href="/api/looks" class="step-card" target="_blank">
                <div class="step-number">1</div>
                <div class="step-content">
                    <h3>Lihat Koleksi (Public)</h3>
                    <p>Akses endpoint <code>/api/looks</code> untuk melihat data inspirasi fashion.</p>
                </div>
            </a>

            <div class="step-card">
                <div class="step-number">2</div>
                <div class="step-content">
                    <h3>Registrasi & Login (Auth)</h3>
                    <p>Gunakan Postman untuk <code>POST</code> ke <code>/api/login</code> agar mendapat Token.</p>
                </div>
            </div>

            <div class="step-card">
                <div class="step-number">3</div>
                <div class="step-content">
                    <h3>Akses Fitur Terkunci</h3>
                    <p>Masukkan token pada <b>Header Authorization</b> untuk mencoba simpan OOTD.</p>
                </div>
            </div>
        </div>

        <div class="footer-text">
            Developed on STB Armbian with Docker Isolation | UAS TST 2025
        </div>
    </div>
</div>

</body>
</html>