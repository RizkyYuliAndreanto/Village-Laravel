# Railway Deployment Instructions

## IMPORTANT: Dockerfile Deployment Only

This project is configured to use **DOCKERFILE** builder, NOT nixpacks or Procfile.

### Railway Configuration:
- **Builder**: DOCKERFILE (see railway.json)
- **Start Command**: Defined in Dockerfile CMD
- **Web Server**: Apache (port 80)
- **No artisan serve**: Using production Apache server

### If Railway still shows ServeCommand errors:
1. Delete any existing Railway service
2. Create new Railway service from GitHub
3. Ensure "Builder" is set to "Dockerfile" in Railway dashboard
4. Do NOT set custom start commands in Railway dashboard

### Environment Variables Required:
- APP_KEY (generate with: php artisan key:generate --show)
- Database variables (MYSQLHOST, MYSQLUSER, etc.)
- All other vars from .env.railway template

### Startup Process:
1. Docker builds image with Apache + PHP 8.3
2. Apache starts on port 80 (not artisan serve)
3. Laravel optimizations run automatically
4. MySQL connection established
5. Application ready for traffic

✅ NO MORE ARTISAN SERVE ERRORS!