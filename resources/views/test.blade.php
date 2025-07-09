<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>اختبار CSS - مشروع كارو</title>
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@100;300;400;500;700;900&display=swap" rel="stylesheet">
    
    <!-- CSS الرئيسي -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    
    <!-- Custom inline styles -->
    <style>
        /* Additional page-specific styles */
        .logo h2 {
            background: linear-gradient(45deg, #007bff, #0056b3);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        
        .stats-grid {
            display: flex;
            justify-content: space-around;
            text-align: center;
            flex-wrap: wrap;
            gap: 1rem;
        }
        
        .stat-item h2 {
            margin: 0;
            font-size: 2rem;
        }
        
        .stat-item p {
            margin: 0;
            color: #666;
        }
    </style>
</head>
<body>
    <header class="header">
        <div class="container">
            <nav class="nav">
                <div class="logo">
                    <h2>مشروع كارو 🚗</h2>
                </div>
                <ul class="nav-links">
                    <li><a href="#home">الرئيسية</a></li>
                    <li><a href="#about">حولنا</a></li>
                    <li><a href="#services">الخدمات</a></li>
                    <li><a href="#contact">اتصل بنا</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <main class="main-content">
        <div class="container">
            <div class="text-center mb-5">
                <h1>مرحباً بك في مشروع كارو! 🎉</h1>
                <p>هذا مثال لاختبار الأنماط المولدة باستخدام Laravel Mix و Sass</p>
            </div>

            <div class="card">
                <h3>معلومات النظام ⚙️</h3>
                <ul>
                    <li><strong>Laravel Version:</strong> {{ app()->version() }}</li>
                    <li><strong>PHP Version:</strong> {{ PHP_VERSION }}</li>
                    <li><strong>Environment:</strong> {{ app()->environment() }}</li>
                    <li><strong>CSS Build:</strong> ✅ نجح البناء</li>
                    <li><strong>JavaScript Build:</strong> ✅ نجح البناء</li>
                </ul>
            </div>

            <div class="card">
                <h3>اختبار الأزرار 🔘</h3>
                <p>مجموعة من الأزرار لاختبار الأنماط:</p>
                <div class="mt-3">
                    <button class="btn btn-primary">زر أساسي</button>
                    <a href="#" class="btn btn-primary">رابط بشكل زر</a>
                </div>
            </div>

            <div class="card">
                <h3>اختبار التخطيط المتجاوب 📱</h3>
                <p>هذا التخطيط متجاوب ويعمل على جميع الأجهزة. قم بتصغير وتكبير النافذة لاختبار الاستجابة.</p>
                
                <div class="grid grid-auto mt-3">
                    <div class="card">
                        <h4>كارت فرعي 1</h4>
                        <p>محتوى تجريبي للكارت الأول</p>
                    </div>
                    <div class="card">
                        <h4>كارت فرعي 2</h4>
                        <p>محتوى تجريبي للكارت الثاني</p>
                    </div>
                    <div class="card">
                        <h4>كارت فرعي 3</h4>
                        <p>محتوى تجريبي للكارت الثالث</p>
                    </div>
                </div>
            </div>

            <div class="card">
                <h3>إحصائيات سريعة 📊</h3>
                <div class="stats-grid">
                    <div class="stat-item">
                        <h2 style="color: #007bff;">150+</h2>
                        <p>مستخدم نشط</p>
                    </div>
                    <div class="stat-item">
                        <h2 style="color: #28a745;">50+</h2>
                        <p>خدمة متاحة</p>
                    </div>
                    <div class="stat-item">
                        <h2 style="color: #ffc107;">99%</h2>
                        <p>معدل التوفر</p>
                    </div>
                    <div class="stat-item">
                        <h2 style="color: #dc3545;">24/7</h2>
                        <p>دعم فني</p>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <footer class="footer">
        <div class="container">
            <p>&copy; 2025 مشروع كارو. جميع الحقوق محفوظة. 🚗</p>
            <p>تم بناء CSS بنجاح باستخدام Laravel Mix</p>
        </div>
    </footer>

    <!-- Custom JavaScript -->
    <script src="{{ asset('js/app.js') }}"></script>
    <script>
        // Additional custom JavaScript
        document.addEventListener('DOMContentLoaded', function() {
            console.log('🎉 صفحة اختبار CSS تم تحميلها بنجاح!');
            
            // Animate cards on scroll (simple example)
            const cards = document.querySelectorAll('.card');
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.style.transform = 'translateY(0)';
                        entry.target.style.opacity = '1';
                    }
                });
            });
            
            cards.forEach(card => {
                card.style.transform = 'translateY(20px)';
                card.style.opacity = '0.8';
                card.style.transition = 'all 0.5s ease';
                observer.observe(card);
            });
        });
    </script>
</body>
</html> 