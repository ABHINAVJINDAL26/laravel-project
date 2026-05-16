Production deploy guide for Railway

This repo is best deployed on Railway as a Docker service. Use MongoDB Atlas for the recipe/blog data and a managed MySQL database for Laravel framework tables such as users, sessions, cache, and jobs.

Why Railway is the proper fit
1. The Dockerfile already installs the MongoDB PHP extension.
2. The app uses MongoDB models, but Laravel also needs SQL-backed framework tables.
3. Railway can host the web service plus a managed MySQL database in the same project.
4. The built frontend is already committed in `public/build`, so no frontend build is required on the platform.

Use this env template
1. Copy `.env.production.example` for production values.
2. Generate a fresh `APP_KEY` locally and paste it into Railway.
3. Set `APP_URL` to your Railway domain after the first deploy.

Railway setup
1. Push this repo to GitHub.
2. In Railway, create a new project from the GitHub repo.
3. Add a MySQL plugin/service in the same Railway project.
4. Add a Web Service and let Railway deploy from the Dockerfile.
5. Set the environment variables from `.env.production.example`.
6. Copy the Railway MySQL connection details into `DB_HOST`, `DB_PORT`, `DB_DATABASE`, `DB_USERNAME`, and `DB_PASSWORD`.
7. Put your MongoDB Atlas connection string in `DB_URI`.
8. Set `APP_URL` to the public Railway URL.
9. Run `php artisan migrate --force` once the service is up.

Recommended production env values
```text
APP_NAME=Laravel
APP_ENV=production
APP_DEBUG=false
APP_URL=https://your-railway-domain.up.railway.app

DB_CONNECTION=mysql
DB_HOST=<railway-mysql-host>
DB_PORT=3306
DB_DATABASE=<railway-mysql-database>
DB_USERNAME=<railway-mysql-user>
DB_PASSWORD=<railway-mysql-password>
DB_URI=<your-mongodb-atlas-uri>

SESSION_DRIVER=database
CACHE_STORE=database
QUEUE_CONNECTION=database
FILESYSTEM_DISK=local
```

What to do after deploy
1. Confirm `/` loads without errors.
2. Run migrations if you have not already.
3. Test login/register, recipe listing, and blog pages.
4. If you see session or queue issues, recheck the MySQL env values first.

Notes
1. Do not deploy with a hardcoded MongoDB URI inside PHP config.
2. Do not use `APP_URL=http://localhost` in production.
3. Keep `public/build` in the repo so the image includes the compiled assets.

Render note
1. Render can still run the Docker image, but Railway is the cleaner option for this repo because it gives you the MySQL service this app needs without extra platform wiring.
