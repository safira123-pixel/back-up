# introduce

<h5>Pembuatan Sistem Informasi Kurikulum Alsavedutech menggunakan framework laravel versi 10 dengan versi php 8.2</h5>

# Composer Run

```Bash
composer install
```

# Migrate Run

```Bash
php artisan migrate
# migrate refresh ketika ada update/perubahan schema column table
php artisan migrate:refresh
# jika ingin rollback table nya jalan kan perintah di bawah ini
php artisan migrate:rollback

```

# Start Server

```Bash
php -S localhost:8000 -t public || php artisan serve
```

# Seeder Run

```Bash
php artisan db:seed
```
