# 🗄️ Railway Database Setup Guide

## MySQL Setup (Recommended untuk Shared Hosting Compatibility)

### Step 1: Add MySQL Service

1. Di Railway dashboard, click **"+ Add Service"**
2. Select **"MySQL"**
3. MySQL service akan auto-provision dengan environment variables:
    - `MYSQLHOST`
    - `MYSQLPORT`
    - `MYSQLDATABASE`
    - `MYSQLUSER`
    - `MYSQLPASSWORD`

### Step 2: Environment Variables

Tambahkan di Railway Variables:

```env
DB_CONNECTION=mysql
DB_HOST=${MYSQLHOST}
DB_PORT=${MYSQLPORT}
DB_DATABASE=${MYSQLDATABASE}
DB_USERNAME=${MYSQLUSER}
DB_PASSWORD=${MYSQLPASSWORD}
```

### Step 3: Migration Commands

Setelah deploy, run di Railway console:

```bash
php artisan migrate --force
php artisan db:seed --force
php artisan storage:link
```

## PostgreSQL Setup (Railway Default)

### Step 1: Add PostgreSQL Service

1. Di Railway dashboard, click **"+ Add Service"**
2. Select **"PostgreSQL"**
3. PostgreSQL service akan auto-provision dengan environment variables:
    - `PGHOST`
    - `PGPORT`
    - `PGDATABASE`
    - `PGUSER`
    - `PGPASSWORD`

### Step 2: Environment Variables

Tambahkan di Railway Variables:

```env
DB_CONNECTION=pgsql
DB_HOST=${PGHOST}
DB_PORT=${PGPORT}
DB_DATABASE=${PGDATABASE}
DB_USERNAME=${PGUSER}
DB_PASSWORD=${PGPASSWORD}
```

## 🔄 Migration ke Shared Hosting

### MySQL → Shared Hosting (Easy)

-   Export MySQL dump dari Railway
-   Import langsung ke shared hosting MySQL
-   Update .env file dengan shared hosting credentials

### PostgreSQL → Shared Hosting (Need Conversion)

-   Export PostgreSQL data
-   Convert data types (serial → AUTO_INCREMENT, boolean → TINYINT)
-   Import ke shared hosting MySQL

## ✅ Recommendation

**Gunakan MySQL di Railway** untuk kemudahan migration ke shared hosting nanti!
