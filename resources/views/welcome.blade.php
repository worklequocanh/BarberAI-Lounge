<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Barber AI Lounge - Tiệm Tóc Nam Cao Cấp & Trợ Lý AI</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        :root {
            --primary: #435ebe;
            --primary-light: #5a8dee;
            --primary-dark: #2c3e80;
            --secondary: #ff7976;
            --accent: #e7a740;
            --bg-dark: #0f172a;
            --card-bg: rgba(30, 41, 59, 0.7);
            --card-border: rgba(255, 255, 255, 0.1);
            --text-main: #f8fafc;
            --text-muted: #94a3b8;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        body {
            background-color: var(--bg-dark);
            color: var(--text-main);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            overflow-x: hidden;
            background-image: 
                radial-gradient(circle at 15% 20%, rgba(67, 94, 190, 0.25) 0%, transparent 40%),
                radial-gradient(circle at 85% 75%, rgba(231, 167, 64, 0.15) 0%, transparent 40%),
                radial-gradient(circle at 50% 50%, rgba(15, 23, 42, 0.9) 0%, var(--bg-dark) 100%);
        }

        /* Navbar */
        .navbar {
            padding: 24px 8%;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid var(--card-border);
            backdrop-filter: blur(12px);
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .brand-logo {
            display: flex;
            align-items: center;
            gap: 12px;
            text-decoration: none;
            color: #fff;
            font-weight: 800;
            font-size: 1.5rem;
            letter-spacing: -0.5px;
        }

        .brand-logo i {
            font-size: 1.8rem;
            color: #5a8dee;
        }

        .brand-logo span {
            background: linear-gradient(135deg, #5a8dee, #e7a740);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .nav-links {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .btn-admin {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: linear-gradient(135deg, var(--primary), var(--primary-light));
            color: #ffffff;
            padding: 10px 22px;
            border-radius: 99px;
            font-weight: 600;
            font-size: 0.95rem;
            text-decoration: none;
            transition: all 0.3s ease;
            box-shadow: 0 4px 20px rgba(67, 94, 190, 0.4);
            border: 1px solid rgba(255, 255, 255, 0.15);
        }

        .btn-admin:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(67, 94, 190, 0.6);
            background: linear-gradient(135deg, var(--primary-light), var(--primary));
        }

        /* Hero Section */
        .hero {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            padding: 60px 8%;
            position: relative;
        }

        .hero-content {
            max-width: 900px;
            z-index: 2;
        }

        .badge-pill {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: rgba(90, 141, 238, 0.15);
            border: 1px solid rgba(90, 141, 238, 0.3);
            color: #7aa7ff;
            padding: 8px 18px;
            border-radius: 99px;
            font-size: 0.88rem;
            font-weight: 600;
            margin-bottom: 24px;
        }

        .hero-title {
            font-size: 3.5rem;
            font-weight: 800;
            line-height: 1.15;
            margin-bottom: 20px;
            letter-spacing: -1px;
        }

        .hero-title .highlight {
            background: linear-gradient(135deg, #60a5fa 0%, #f59e0b 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .hero-subtitle {
            font-size: 1.15rem;
            color: var(--text-muted);
            line-height: 1.6;
            margin-bottom: 36px;
            max-width: 700px;
            margin-inline: auto;
        }

        .hero-actions {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 16px;
            flex-wrap: wrap;
            margin-bottom: 50px;
        }

        .btn-large {
            padding: 14px 32px;
            font-size: 1.05rem;
            font-weight: 700;
            border-radius: 12px;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            transition: all 0.3s ease;
        }

        .btn-primary-hero {
            background: linear-gradient(135deg, #435ebe, #2563eb);
            color: #fff;
            box-shadow: 0 10px 30px rgba(37, 99, 235, 0.4);
            border: 1px solid rgba(255, 255, 255, 0.15);
        }

        .btn-primary-hero:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 35px rgba(37, 99, 235, 0.6);
            color: #fff;
        }

        .btn-secondary-hero {
            background: rgba(30, 41, 59, 0.8);
            border: 1px solid var(--card-border);
            color: var(--text-main);
            backdrop-filter: blur(10px);
        }

        .btn-secondary-hero:hover {
            background: rgba(51, 65, 85, 0.9);
            transform: translateY(-3px);
            color: #fff;
        }

        /* Quick Info Cards */
        .grid-features {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 20px;
            margin-top: 20px;
            text-align: left;
        }

        .card-feature {
            background: var(--card-bg);
            border: 1px solid var(--card-border);
            padding: 24px;
            border-radius: 16px;
            backdrop-filter: blur(10px);
            transition: all 0.3s ease;
        }

        .card-feature:hover {
            border-color: rgba(90, 141, 238, 0.4);
            transform: translateY(-4px);
        }

        .card-feature i {
            font-size: 2rem;
            color: #60a5fa;
            margin-bottom: 14px;
            display: inline-block;
        }

        .card-feature h3 {
            font-size: 1.1rem;
            font-weight: 700;
            margin-bottom: 8px;
            color: #fff;
        }

        .card-feature p {
            color: var(--text-muted);
            font-size: 0.9rem;
            line-height: 1.5;
        }

        /* Footer */
        footer {
            padding: 24px 8%;
            text-align: center;
            border-top: 1px solid var(--card-border);
            color: var(--text-muted);
            font-size: 0.9rem;
        }

        @media (max-width: 768px) {
            .hero-title {
                font-size: 2.3rem;
            }
            .navbar {
                padding: 16px 5%;
            }
        }
    </style>
</head>

<body>
    <!-- Navigation Bar -->
    <header class="navbar">
        <a href="{{ url('/') }}" class="brand-logo">
            <i class="bi bi-scissors"></i>
            <div>Barber<span>AI</span> Lounge</div>
        </a>

        <div class="nav-links">
            <a href="{{ route('admin.dashboard') }}" class="btn-admin">
                <i class="bi bi-speedometer2"></i>
                Vào Dashboard Quản Trị
            </a>
        </div>
    </header>

    <!-- Hero Content -->
    <main class="hero">
        <div class="hero-content">
            <div class="badge-pill">
                <i class="bi bi-stars"></i>
                Hệ Thống Tiệm Tóc Đột Phá Với Trợ Lý AI
            </div>

            <h1 class="hero-title">
                Khám Phá Phong Cách Mới<br>
                Cùng <span class="highlight">Barber AI Lounge</span>
            </h1>

            <p class="hero-subtitle">
                Giải pháp kết hợp dịch vụ làm đẹp nam giới chuẩn salon cao cấp và công nghệ AI nhận diện dáng mặt, gợi ý kiểu tóc hoàn hảo nhất cho phái mạnh.
            </p>

            <div class="hero-actions">
                <a href="{{ route('admin.dashboard') }}" class="btn-large btn-primary-hero">
                    <i class="bi bi-grid-fill"></i>
                    Bảng Điều Khiển Admin
                </a>

                <a href="#features" class="btn-large btn-secondary-hero">
                    <i class="bi bi-info-circle"></i>
                    Tính Năng Dự Án
                </a>
            </div>

            <!-- Features -->
            <div class="grid-features" id="features">
                <div class="card-feature">
                    <i class="bi bi-calendar2-week-fill text-primary"></i>
                    <h3>Đặt Lịch Nhanh Chóng</h3>
                    <p>Quản lý lịch hẹn theo thời gian thực, lựa chọn thợ cắt tóc và dịch vụ yêu thích dễ dàng.</p>
                </div>

                <div class="card-feature">
                    <i class="bi bi-cpu-fill" style="color: #e7a740;"></i>
                    <h3>AI Gợi Ý Mẫu Tóc</h3>
                    <p>Phân tích khuôn mặt qua ảnh chụp, đưa ra gợi ý các kiểu tóc phù hợp nhất với tỉ lệ mặt.</p>
                </div>

                <div class="card-feature">
                    <i class="bi bi-person-badge-fill" style="color: #34d399;"></i>
                    <h3>Quản Lý Stylist & Ca</h3>
                    <p>Theo dõi lịch làm việc tuần, chấm công, ngày nghỉ phép và đánh giá chất lượng tay nghề thợ.</p>
                </div>

                <div class="card-feature">
                    <i class="bi bi-shield-check text-info"></i>
                    <h3>Hệ Thống Phân Quyền</h3>
                    <p>Bảo mật cao với cơ chế RBAC phân cấp quản trị viên, nhân viên, thợ cắt tóc và khách hàng.</p>
                </div>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer>
        <p>&copy; {{ date('Y') }} Barber AI Lounge. Phát triển trên nền tảng Laravel 13 & PHP 8.3.</p>
    </footer>
</body>

</html>
