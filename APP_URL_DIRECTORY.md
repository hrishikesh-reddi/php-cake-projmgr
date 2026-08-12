# ProjMgr — Application URLs, Commands & Review Directory

This document serves as a complete reference for all localhost URLs, application feature routes, authentication mechanisms, and server start commands across all project versions in this repository.

---

## 🚀 Quick Start Commands

### 1. Main Consolidated Application (Root Directory)
Start the primary CakePHP 5 application:
```bash
bin/cake server -p 8765
# OR
php -S 127.0.0.1:8765 -t webroot
```
* **Base URL:** `http://localhost:8765`

---

## 🌐 Complete Application Page Directory

### 1. 🔑 Authentication & User Management
- **Login:** `http://localhost:8765/login`
- **Logout:** `http://localhost:8765/logout`
- **Register:** `http://localhost:8765/register`
- **User List:** `http://localhost:8765/users`
- **User Profile:** `http://localhost:8765/users/profile`
- **User Statistics:** `http://localhost:8765/users/stats`
- **View User:** `http://localhost:8765/users/view/{id}`

---

### 2. 🎯 Milestones Module
- **Milestones List:** `http://localhost:8765/milestones`
- **Add Milestone:** `http://localhost:8765/milestones/add`
- **View Milestone:** `http://localhost:8765/milestones/view/{id}`
- **Edit Milestone:** `http://localhost:8765/milestones/edit/{id}`

---

### 3. 📁 Projects Module
- **Projects List:** `http://localhost:8765/projects`
- **Create Project:** `http://localhost:8765/projects/add` *(Code/Short Name locked after creation)*
- **View Project:** `http://localhost:8765/projects/view/{id}`
- **Edit Project:** `http://localhost:8765/projects/edit/{id}`
- **Toggle Project Status:** `http://localhost:8765/projects/{id}/status`

---

### 4. ✅ Tasks Module
- **Tasks List:** `http://localhost:8765/tasks` *(Displays color warning badges for over-allocation)*
- **Create Task:** `http://localhost:8765/tasks/add` *(Requires associated Project)*
- **View Task:** `http://localhost:8765/tasks/view/{id}`
- **Edit Task:** `http://localhost:8765/tasks/edit/{id}`
- **Update Task Effort:** `http://localhost:8765/tasks/{id}/status`

---

### 5. 👥 Employees Module
- **Employee Directory:** `http://localhost:8765/employees`
- **Add Employee:** `http://localhost:8765/employees/add`
- **View Employee:** `http://localhost:8765/employees/view/{id}`
- **Edit Employee:** `http://localhost:8765/employees/edit/{id}`

---

### 6. 📊 Dashboard & Reports
- **Main Dashboard / Forecasting:** `http://localhost:8765/dashboard` or `http://localhost:8765/`
- **Weekly Status Report:** `http://localhost:8765/reports/weekly`
- **Employee Performance:** `http://localhost:8765/reports/employee-performance`
- **Project Budget Report:** `http://localhost:8765/reports/project-budget`

---

### 7. ⏱️ Timesheets Module
- **Timesheet Log:** `http://localhost:8765/timesheets`
- **Log Hours:** `http://localhost:8765/timesheets/add`
- **View Entry:** `http://localhost:8765/timesheets/view/{id}`

---

### 8. 🛠️ Master Data Tables
| Feature | List URL | Add URL | Edit URL |
| :--- | :--- | :--- | :--- |
| **Project Types** | `http://localhost:8765/project-types` | `/project-types/add` | `/project-types/edit/{id}` |
| **Project Statuses** | `http://localhost:8765/project-statuses` | `/project-statuses/add` | `/project-statuses/edit/{id}` |
| **Task Types** | `http://localhost:8765/task-types` | `/task-types/add` | `/task-types/edit/{id}` |
| **Task Statuses** | `http://localhost:8765/task-statuses` | `/task-statuses/add` | `/task-statuses/edit/{id}` |
| **Departments** | `http://localhost:8765/departments` | `/departments/add` | `/departments/edit/{id}` |
| **Divisions** | `http://localhost:8765/divisions` | `/divisions/add` | `/divisions/edit/{id}` |
| **Roles** | `http://localhost:8765/roles` | `/roles/add` | `/roles/edit/{id}` |
| **Menus** | `http://localhost:8765/menus` | `/menus/add` | `/menus/edit/{id}` |

---

## 🔒 Auth & Session Mechanism Summary

1. **Authentication:**
   - Hashed using PHP BCRYPT (`password_verify`).
   - Session stored at key `Auth.User`.
2. **Access Control:**
   - Public Actions: `login`, `logout`, `register`.
   - All other routes require an active session (`$this->requireAuth = true`).
3. **Boss Tracking Specs:**
   - **`last_login_dt`** updated on every login.
   - **`failed_login_count`** incremented on failed attempts.

---

## 📁 Repository Project Versions Summary

| Version Name | Directory Path | Framework | Start Command | Local URL |
| :--- | :--- | :--- | :--- | :--- |
| **Current Consolidated** | `./` (Root) | CakePHP 5 | `bin/cake server -p 8765` | `http://localhost:8765` |
| **Boss Reference** | `./boss_actual/ProjMgr` | Node.js / React | `npm start` | `http://localhost:3000` |
| **Intern Work** | `./intern_work/ProjMgrCake` | CakePHP | `bin/cake server -p 8766` | `http://localhost:8766` |
