# ProjMgr CakePHP V1 — Setup Guide

## Prerequisites
- PHP 8.1+
- Composer (already installed)
- Docker Desktop (already downloaded)
- MySQL 8 (via Docker — no local install needed)

---

## Step 1 — Start the MySQL Docker container

```powershell
# Copy your SQL dump into the docker/ folder first:
Copy-Item "C:\Users\choco\Downloads\Dump20230122.sql" ".\docker\Dump20230122.sql"

# Start MySQL (first run imports the dump automatically — takes ~2-3 min):
cd docker
docker compose up -d

# Watch the import progress:
docker logs -f projmgr_mysql
# When you see "ready for connections" a second time, import is done.
```

Connection details once running:
| Setting  | Value         |
|----------|---------------|
| Host     | 127.0.0.1     |
| Port     | 3306          |
| Database | geminitools   |
| User     | projmgr       |
| Password | projmgr_pass  |

---

## Step 2 — Create the CakePHP app

```powershell
# Navigate to where you want the project:
cd C:\Projects   # or wherever you keep code

# Scaffold a fresh CakePHP 4.x app:
composer create-project --prefer-dist cakephp/app:^4.5 ProjMgrCake

cd ProjMgrCake
```

---

## Step 3 — Overlay the custom files

Extract the `ProjMgrCake_custom_files.zip` (the file I delivered) into `C:\Projects\ProjMgrCake\`.
When Windows asks about overwriting, choose **Yes to All** — we're replacing:
- `config/app_local.php` (database connection)
- `config/routes.php` (URL routes)
- `src/Controller/` (Projects, Tasks, Employees controllers)
- `src/Model/Table/` (all Table classes)
- `src/Model/Entity/` (all Entity classes)
- `templates/` (all views)

---

## Step 4 — Run the app

```powershell
# From C:\Projects\ProjMgrCake:
bin/cake server

# Or use PHP's built-in server:
php -S localhost:8765 -t webroot
```

Open http://localhost:8765 in your browser.

---

## V1 Routes Available

| URL                        | Action                   |
|----------------------------|--------------------------|
| `/`                        | Projects dashboard       |
| `/projects`                | List all projects        |
| `/projects/add`            | Create a project         |
| `/projects/{id}/edit`      | Update a project         |
| `/projects/{id}/status`    | Get project status       |
| `/tasks`                   | List all tasks           |
| `/tasks/add`               | Create a task            |
| `/tasks/{id}/edit`         | Update a task            |
| `/tasks/{id}/status`       | Get task status          |
| `/employees`               | List all employees       |
| `/employees/add`           | Add an employee          |
| `/employees/{id}/edit`     | Update an employee       |
| `/employees/{id}/status`   | Get employee status      |

---

## File Structure (what was added)

```
ProjMgrCake/
├── config/
│   ├── app_local.php          ← DB connection config
│   └── routes.php             ← Custom V1 routes
├── src/
│   ├── Controller/
│   │   ├── ProjectsController.php
│   │   ├── TasksController.php
│   │   └── EmployeesController.php
│   └── Model/
│       ├── Table/
│       │   ├── ProjectsTable.php      (→ projects)
│       │   ├── TasksTable.php         (→ task_t)
│       │   ├── EmployeesTable.php     (→ users_t)
│       │   ├── ProjectStatusesTable.php
│       │   ├── TaskStatusesTable.php
│       │   ├── TaskTypesTable.php
│       │   └── ProjectTypesTable.php
│       └── Entity/
│           ├── Project.php
│           ├── Task.php
│           └── Employee.php
├── templates/
│   ├── Projects/   (index, add, edit, view, status)
│   ├── Tasks/      (index, add, edit, view, status)
│   └── Employees/  (index, add, edit, view, status)
└── docker/
    ├── docker-compose.yml
    └── Dump20230122.sql   ← (copy here after extracting)
```

---

## What's in V2 (next sprint)
- JWT authentication / login
- Project risk detection (AI layer)
- Timesheets module
- Weekly status reports
- Resource utilization dashboard
