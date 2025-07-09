# دليل تشغيل CSS في مشروع كارو 🚗

## المتطلبات الأساسية
- Node.js (الإصدار 14 أو أحدث)
- NPM
- Laravel 10+
- PHP 8.1+

## خطوات تشغيل CSS

### 1. تثبيت التبعيات
```bash
npm install
```

### 2. بناء ملفات CSS (مرة واحدة)
```bash
npm run dev
```

### 3. تشغيل CSS في وضع المراقبة (للتطوير)
```bash
npm run watch
```

### 4. بناء ملفات CSS للإنتاج
```bash
npm run production
```

## الملفات المهمة

### ملفات المصدر
- `resources/sass/app.scss` - ملف Sass الرئيسي
- `resources/sass/_variables.scss` - متغيرات CSS
- `resources/js/app.js` - ملف JavaScript الرئيسي

### ملفات الإخراج
- `public/css/app.css` - ملف CSS المترجم
- `public/js/app.js` - ملف JavaScript المترجم

### ملفات الإعداد
- `webpack.mix.js` - إعداد Laravel Mix
- `package.json` - تبعيات NPM

## اختبار CSS

### زيارة صفحة الاختبار
```
http://localhost:8000/test-css
```

أو الصفحة الرئيسية:
```
http://localhost:8000/
```

## الأوامر المفيدة

### تشغيل الخادم
```bash
php artisan serve
```

### مراقبة التغييرات مع إعادة التحميل التلقائي
```bash
npm run watch
```

### تحديث CSS فقط
```bash
npm run build-css
```

## إضافة أنماط جديدة

### في ملف Sass
```scss
// في resources/sass/app.scss
.my-custom-class {
    color: #007bff;
    font-weight: bold;
}
```

### في HTML
```html
<div class="my-custom-class">النص هنا</div>
```

## نصائح للتطوير

1. **استخدم وضع المراقبة**: `npm run watch` لإعادة بناء CSS تلقائياً
2. **تحقق من Console**: للتأكد من عدم وجود أخطاء
3. **استخدم Dev Tools**: لفحص الأنماط في المتصفح
4. **اختبر على أجهزة مختلفة**: للتأكد من الاستجابة

## حل المشاكل الشائعة

### خطأ "Module not found"
```bash
npm install
npm run dev
```

### خطأ في Bootstrap
```bash
npm install bootstrap
npm run dev
```

### CSS لا يظهر
1. تأكد من وجود الملف: `public/css/app.css`
2. تحقق من الرابط في HTML: `{{ asset('css/app.css') }}`
3. امسح الكاش: `php artisan view:clear`

## إضافة Bootstrap (اختياري)

### تثبيت Bootstrap
```bash
npm install bootstrap @popperjs/core
```

### في resources/sass/app.scss
```scss
@import '~bootstrap/scss/bootstrap';
```

## متغيرات CSS المخصصة

### في resources/sass/_variables.scss
```scss
// الألوان الأساسية
$primary-color: #007bff;
$secondary-color: #6c757d;
$success-color: #28a745;

// الخطوط
$font-family-base: 'Roboto', Arial, sans-serif;
$font-size-base: 16px;
```

## الدعم العربي (RTL)

```css
body {
    direction: rtl;
    text-align: right;
}
```

---

## تم إعداد CSS بنجاح! ✅

- ✅ تثبيت Laravel Mix
- ✅ إعداد Sass
- ✅ بناء ملفات CSS
- ✅ إنشاء صفحة اختبار
- ✅ إضافة Routes
- ✅ دعم العربية (RTL)

**الخادم يعمل على**: http://localhost:8001/test-css

للمساعدة: راجع هذا الملف أو اتصل بفريق التطوير 🚀 