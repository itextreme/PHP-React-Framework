# TaskFlow: The Unified PHP-React Framework

TaskFlow is a state-of-the-art web framework that bridges the gap between traditional **PHP Backend power** and **Modern React Frontend speed**. It provides a "Next.js-like" developer experience while keeping the simplicity and robustness of the PHP ecosystem.

## ✨ What makes TaskFlow Special?

Unlike separate Backend/Frontend setups, TaskFlow is a **Unified Architecture**:

- **Single Entry Point**: Our custom-built `public/index.php` acts as an intelligent router. It handles API requests, serves static assets with proper MIME types, and manages SPA routing automatically.
- **Eloquent ORM for React**: Leverage the world-class **Laravel Eloquent ORM** directly in your React project without the overhead of a full Laravel installation.
- **Vite-PHP Synergy**: A custom dev-server setup that proxies API requests seamlessly, allowing you to build with Vite's HMR while hitting a real PHP backend.
- **Production Ready**: Includes `.htaccess` for Apache and Nginx templates, ensuring your "React App" is as easy to deploy as any traditional PHP site.

---

## 🛠️ Usage Instructions

### 1. Prerequisites

- PHP 8.1+
- Node.js & npm
- Composer

### 2. Setup

Clone the repository and install all dependencies in one go:

```bash
npm install && composer install
```

### 2. Database Setup

Initialize the SQLite database, run migrations, and add sample data:

```bash
touch database/database.sqlite
npm run migrate
npm run seed
```

### 4. Direct Development (The Magic)

Run the following command to start both the PHP backend and the Vite frontend simultaneously:

```bash
npm run dev
```

- **Frontend**: [http://localhost:5173](http://localhost:5173) (With Hot Module Replacement)
- **Backend API**: Running on `localhost:8000` (Proxied via `/api/*`)

### 5. Production Build & Preview

When you're ready to deploy, generate the optimized build:

```bash
npm run build
```

To preview the _actual_ production environment (including the PHP router):

```bash
npm run preview
```

Visit [http://localhost:8008](http://localhost:8008).

---

## 📂 Architecture Overview

```text
├── app/              # Eloquent Models (App\Models)
├── database/         # SQLite persistent storage
├── public/           # The Web Root
│   ├── index.php     # THE BRAINS: API Router + Asset Server
│   └── dist/         # Production build output
├── src/              # React components & logic
├── bootstrap.php     # Eloquent & Env Configuration
└── package.json      # Command center for scripts
```

## 📜 Available Scripts

| Script            | Description                                                   |
| :---------------- | :------------------------------------------------------------ |
| `npm run dev`     | **Recommended Dev Loop**: Runs PHP and Vite concurrently.     |
| `npm run build`   | Compiles your frontend for production.                        |
| `npm run preview` | Runs the production code through the PHP router on port 8008. |
| `npm run migrate` | Syncs your Eloquent models with the SQLite database.          |
| `npm run seed`    | Populates the database with beautiful sample tasks.           |

---

Built for performance, scalability, and developer joy by **MrbeanDev**.
