# ⚙️ PROJECT SETUP

## 📥 Clone Repository

```bash
https://github.com/Argiiahm/Absensi-Karyawan
```

## 📂 Masuk Folder Project

```bash
cd Absensi-Karyawan
```

## 📦 Install Dependency

```bash
composer install
npm install
```

## 🔑 Setup ENV

```bash
cp .env.example .env
php artisan key:generate
```

## 🗄️ Setup Database

Buat database baru di MySQL lalu ubah `.env`

```env
DB_DATABASE=absensi-karyawan
DB_USERNAME=root
DB_PASSWORD=
```

## 🚀 Jalankan Migration

```bash
php artisan migrate --seed
```

## ▶️ Run Project

```bash
php artisan serve
npm run dev
```
