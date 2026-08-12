# ProjMgr — Architecture & Build Plan

## Project Goal

Rebuild the company's internal project-management tool (originally a React + Node "GemPrism/ProjMgr") as a **CakePHP 5 + MySQL** application hosted on SiteGround. Centralize all internal apps, keep it sustainable, and grow into a forecasting tool (budget adherence, employee performance, task effort tracking).

## Stack

- CakePHP 5.4.1 (PHP 8.5 local / 8.1+ target)
- MySQL 8 (geminitools DB, 61 tables)
- Server: PHP built-in for dev (`php -S 127.0.0.1:8765 -t webroot`)
- Tests: PHPUnit 10 + SchemaLoader (schema.sql), not migrations (migrations plugin is PHP 8.5-incompatible)

## Database (geminitools)

Core tables already mapped in CakePHP models:

| CakePHP Table | DB table |
|---|---|
| ProjectsTable | projects |
| TasksTable | task_t |
| EmployeesTable | users_t |
| ProjectStatusesTable | project_status_t |
| TaskStatusesTable | taskstatus_t |
| TaskTypesTable | tasktypes_t |
| ProjectTypesTable | project_type_t |
| ProjectResourcesTable | project_resources_t |

Key columns already used:
- projects: budget, cost_approved, estimated_hours, progress, status_id, type_id, project_manager, account_manager, start_date, end_date, scope
- task_t: estimated_hours_nm, revised_efforts_nm, spent_hours_nm, completion, task_status_nm, task_type_nm, project_id_nm, created_by_nm, parent_task_nm, milestone_id_nm
- users_t: employee_id, display_name_tx, email_tx, password_tx (bcrypt in beforeSave), department_id, designation, reporting_manager_nm, activate_yn_nm

## Boss Requirements (from audio)

1. Project creation + edit with field-level validation (project code/short_name locked after create) — DONE in V1
2. Projects and Tasks MUST be associated (every task belongs to a project) — DONE in V1
3. Build as PHP/CakePHP app — DONE in V1
4. User management module: users, passwords, last-login, login failure attempts, user statistics
5. Budget/task-effort visualization: task exceeding allocated effort shows warning color
6. Forecasting: budget adherence, employee performance, resource utilization
7. Sprint-based work, functional flow first then CSS later
8. Login/auth (password must be in table to log in — hashed)

## V2 Deliverables (this build)

| # | Module | Owner Agent |
|---|---|---|
| 1 | Authentication (login/logout, session auth, access control) | Agent A |
| 2 | User Management (CRUD + user stats + last-login/failure tracking) | Agent A |
| 3 | Task Effort/Budget visualization (warning colors for overspent tasks) | Agent B |
| 4 | Timesheets / Time logging module | Agent B |
| 5 | Master data screens (statuses, types, departments, etc.) | Agent C |
| 6 | RBAC (roles/menus) | Agent C |
| 7 | Dashboard + Forecasting (budget adherence, resource utilization, employee performance) | Agent D |
| 8 | Weekly status reports | Agent D |
| 9 | Testing & verification loop | Agent E |

## Parallel Work Rules

- Every agent owns its OWN files (controllers/models/templates).
- Shared files (routes.php, AppController, layout) follow the convention: controllers register routes via `config/routes_<agent>.php` included from the central `config/routes.php`.
- No agent touches another agent's files.
- All agents must run `php -l` on every PHP file before finishing.
- All agents must verify their page loads on the running dev server.

## Dev Server

`php -S 127.0.0.1:8765 -t webroot` (running on port 8765).
MySQL: `127.0.0.1:3307`, db `geminitools`, user `projmgr`, pass `projmgr_pass`.

## Testing

- `php vendor/bin/phpunit` — unit/integration tests (schema loaded from tests/schema.sql into `geminitools_test`).
- Functional: curl the dev server and assert HTTP 200 + expected content.