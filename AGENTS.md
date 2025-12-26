# AGENTS.md - MRBEANDEV TEMPLATES

## Current State

This workspace contains several project templates and a newly created PHP + React robust framework.

### Active Project: `php-react-app`

A Next.js-like unified framework combining PHP (Backend/Eloquent) and React (Frontend/Vite) into a single coexisting project.

#### Speciality & "The Magic"

- **Unified Router**: `public/index.php` is the brain—it routes API requests, serves static files with correct MIME types, and handles SPA fallback.
- **Eloquent in React**: First-class ORM support (Laravel Eloquent) inside a React ecosystem without the bloat of a full framework.
- **DX Sync**: `npm run dev` merges two stacks into one reactive loop.
- **MIME Robustness**: Native support for CSS, JS, WOFF2, WebP, etc., even when using a basic PHP development server.

#### Folder Structure

- `/app/Models`: Eloquent models.
- `/src`: React source code and components.
- `/static`: Vite static assets (favicon, etc.).
- `/public`: The web root.
    - `index.php`: The unified router and API controller.
    - `/dist`: Build output from Vite (Production only).
- `bootstrap.php`: Shared Eloquent and Environment setup.
- `migrate.php`: Database schema management.
- `package.json`: Unified dependencies and scripts.

#### Setup & Usage

1. **Installation**:
    ```bash
    composer install
    npm install
    ```
2. **Database**:
    ```bash
    npm run migrate # Syncs your Eloquent models with the SQLite database.
    npm run seed # Populates the database with beautiful sample data.
    ```
3. **Development**:

    ```bash
    npm run dev
    ```

    _This starts both the PHP server (8000) and Vite server (5173). Access the app via Vite's URL for HMR._

4. **Production Build**:
    ```bash
    npm run build
    ```
    _After building, the PHP server (on port 8000) will serve the production-ready React app directly._

## Coding Standards

- Use Eloquent for all database operations.
- All API routes MUST start with `/api` in `public/index.php`.
- Use Shadcn UI for premium design aesthetics.
- Keep PHP logic in `app/` and React logic in `src/`.
