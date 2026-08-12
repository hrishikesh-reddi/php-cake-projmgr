# Summary of Audio Transcriptions

## Overview

These three audio recordings capture a project lead/manager discussing the development of an internal project management application for their organization. The speaker outlines technical requirements, development philosophy, sprint planning, and expectations for the team.

---

## Key Points from Each Audio

### Audio 1 — Progress Tracking & Office Coordination
- The project needs to evolve into a **forecasting tool** to track whether projects stay within budget and monitor employee performance.
- The team is expected to provide regular **progress updates via a team chat group** (likely Microsoft Teams).
- A shared space for finance-related files should be set up.
- The speaker will be in the office for **two days this week** (possibly tomorrow, the day after, or Friday).
- An **internal review is scheduled before Friday**.
- The speaker wants to know what progress has been made and what **two directions** the team is pursuing.
- A follow-up call is planned to discuss progress.

### Audio 2 — User Management, Budget Visualization & AI Philosophy
- The current application **lacks user management**.
- A **user management module** is needed, containing:
  - User credentials (username, password)
  - Login tracking (last login, failed attempts)
  - User statistics
- **Task visualization** is required — tasks should be displayed with visual indicators.
- If a task **exceeds its allocated budget/effort**, it should be highlighted in a different color to indicate overallocation.
- A **$70 plan** is referenced (possibly a hosting or tool budget).
- The speaker shares a cautionary tale about a friend who over-relied on **AI bots/agents** and ended up spending excessively without building something sustainable.
- **Key message on AI usage:**
  - AI can build applications quickly, but the team must **understand the code**.
  - If bugs or issues arise, the team should be able to **read, debug, and fix the code** themselves.
  - Real learning comes from understanding **application frameworks**, not just using AI tools.
  - This is a **non-commercial internal project**, so the focus should be on **learning and skill development**.
- The team is asked to come up with an **estimation and plan** for how they will build the application.

### Audio 3 — Sprint Planning, Tech Stack & Architecture
- The speaker wants to follow a **sprint-based approach**, focusing on **one activity at a time**.
- **First sprint priority: Product Creation / Project Management module**.
  - Ability to create and edit projects.
  - **Field-level validation:** Some fields should be editable, others should be locked after creation.
  - Certain data (like creation details) should **not be modifiable** once set.
- **Tech Stack Decision:**
  - The application must be built in **PHP** (not React/Node).
  - Reason: The organization has already invested in **SiteGround hosting** (2-year contract) and wants all internal applications centralized there.
  - Existing applications like **Academy Place** (CRM for sales team) are already hosted on SiteGround.
- The speaker has provided **database credentials, passwords, and local environment setup** details.
  - Database: **MySQL**
  - The existing app runs on **Node.js**, but the new build should be **PHP**.
- **Critical Missing Feature:**
  - **Projects and tasks must be associated** — every task should belong to a project.
  - This relationship is currently missing and needs to be implemented.
- UI/UX mentions: CSS work, vision options, lead status, deliverables, and patterns.

---

## Speaker's Main Motive

The speaker's primary motive is to **build a sustainable, internal project management application using PHP and MySQL, hosted on SiteGround, that can be used by all employees across the organization.**

More specifically, the speaker wants to:

1. **Centralize Internal Tools** — Keep all company applications on a single hosting platform (SiteGround) rather than scattering them across different frameworks and hosts.

2. **Develop Team Capability** — Ensure the team learns and understands the application frameworks deeply, rather than blindly relying on AI tools to generate code. The emphasis is on **learning, debugging, and owning the codebase**.

3. **Deliver Practical Business Value** — The app must support real workflows: project creation, task association, budget forecasting, employee performance tracking, and user management with proper access controls.

4. **Follow a Structured Sprint Approach** — Start with the core project management module, enforce data validation rules, and build iteratively with regular reviews and progress tracking.

5. **Ensure Sustainability** — Build something the team can maintain long-term without depending on external AI services or complex, hard-to-debug architectures.

---

*Generated from transcriptions of Audio Files: New Recording 25, New Recording 24, and New Recording 23.*
