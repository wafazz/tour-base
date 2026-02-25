

# Tour Base — Implementation Planning

> **Project**: Tour Base — Digital Job Matching Platform
> **Platform**: Web Application (responsive, mobile-friendly)
> **Theme**: Navy Blue + Gold
> **Created**: 2026-02-25
> **Based on**: Functional Specification Document (FSD)

---

## 1. Project Summary

Tour Base is a digital job matching platform connecting **Travel Agencies** with **Tour Leaders/Guides**. Agencies post tour jobs (inbound/outbound), guides browse and apply, and an admin oversees the entire operation including user verification, job approval, invoicing, and reporting.

---

## 2. Proposed Tech Stack

| Layer | Technology |
|-------|-----------|
| Backend | Laravel 12 (PHP 8.3+) |
| Frontend | Blade + Livewire 3 + Alpine.js |
| Admin Panel | Filament 3 |
| CSS | Tailwind CSS 4 (Navy Blue + Gold theme) |
| Database | MySQL 8 |
| Auth | Laravel built-in (session-based) + role middleware |
| Notifications | Laravel Notifications (database + email) |
| Email | Resend / Mailtrap |
| File Storage | Laravel Storage (public disk) |
| Invoice | DomPDF / Snappy (PDF generation) |
| Build Tool | Vite |

---

## 3. User Roles & Permissions

### Role 1: Tour Leader / Guide
- Register with email/phone + document upload
- Cannot login until Admin approves account
- Create and manage profile (license, certs, experience, languages, social links)
- Browse job offers (inbound & outbound)
- Apply for jobs (one-click apply)
- Get notifications (new jobs, application status changes)
- View application history ("My Applications")

### Role 2: Travel Agency
- Register with company info + MOTAC reg. no. + contact person
- Cannot login until Admin approves account
- Post new jobs (title, description, dates, inbound/outbound, requirements)
- Jobs require Admin approval before going live
- Manage job offers (Active, Closed, Pending)
- Review applicants with profile preview
- Select & confirm candidate
- Receive auto-generated invoice upon confirmation
- Download/view invoices in dashboard
- Rate/review guides after job completion

### Role 3: Admin
- Approve/reject user registrations (both Guide & Agency)
- Approve/reject job posts
- Monitor all activity (users, jobs, applications)
- Generate invoices for agencies
- View reports (monthly jobs, revenue, activity logs)
- Manage system notifications
- Manage invoices & update payment status

---

## 4. Database Design

### Core Tables

```
users
├── id, name, email, phone, password, role (guide|agency|admin)
├── email_verified_at, status (pending|approved|rejected)
├── avatar, created_at, updated_at

guide_profiles
├── id, user_id (FK)
├── license_no, experience_years, skills (JSON)
├── languages (JSON), social_links (JSON)
├── bio, documents (JSON — uploaded files)
├── created_at, updated_at

agency_profiles
├── id, user_id (FK)
├── company_name, motac_reg_no, contact_person
├── company_address, company_phone, company_logo
├── created_at, updated_at

jobs
├── id, agency_id (FK → users)
├── title, description, requirements (text)
├── type (inbound|outbound), location
├── start_date, end_date, salary/fee
├── status (pending|active|closed)
├── admin_approved_at, created_at, updated_at

applications
├── id, job_id (FK), guide_id (FK → users)
├── status (pending|shortlisted|accepted|rejected)
├── cover_letter (nullable), applied_at
├── created_at, updated_at

invoices
├── id, application_id (FK), agency_id (FK), guide_id (FK)
├── invoice_number, amount, tax, total
├── payment_status (pending|paid)
├── issued_at, paid_at
├── created_at, updated_at

reviews
├── id, agency_id (FK), guide_id (FK), job_id (FK)
├── rating (1-5), comment
├── created_at, updated_at

notifications
├── id, user_id, type, title, message
├── data (JSON), read_at
├── created_at, updated_at

documents
├── id, user_id (FK)
├── type (license|passport|cert|other)
├── file_path, original_name
├── verified_at, created_at, updated_at
```

---

## 5. Implementation Phases

### Phase 1A: Foundation (Setup & Auth)
**Priority: Critical | Estimated: 2-3 days**

- [ ] Laravel 12 project scaffold
- [ ] Database migrations (all tables above)
- [ ] Models with relationships & factories
- [ ] Seeder (demo admin, agencies, guides, jobs)
- [ ] Tailwind CSS 4 config (Navy Blue `#1B2A4A` + Gold `#D4A843`)
- [ ] Base layout (app.blade.php) — sidebar + topbar + notification bell
- [ ] Auth system: Register (Guide / Agency selection), Login, Logout
- [ ] Role-based middleware (`EnsureApproved`, `EnsureRole:guide`, `EnsureRole:agency`)
- [ ] Registration flow: after register → "Pending Approval" page (no access until admin approves)

### Phase 1B: Admin Panel
**Priority: Critical | Estimated: 2-3 days**

- [ ] Filament 3 admin panel at `/admin`
- [ ] Dashboard overview (stat cards: total users, active jobs, applications, revenue)
- [ ] User Management resource (approve/reject with verification doc preview)
- [ ] Job Management resource (approve/reject job posts)
- [ ] Application monitoring (view all applications across jobs)
- [ ] Invoice management (list, update payment status)
- [ ] Reports page (active jobs count, application count, revenue by month, active users by role)
- [ ] System notification management

### Phase 1C: Agency Dashboard
**Priority: High | Estimated: 3-4 days**

- [ ] Agency dashboard (overview stats: my jobs, applicants, invoices)
- [ ] Profile management (company info, MOTAC reg, contact person, logo)
- [ ] Create new job form (title, description, dates, type, requirements, salary)
- [ ] My Jobs listing (tabs: Active, Pending, Closed)
- [ ] Job detail view with applicant list
- [ ] Applicant review — profile preview modal/page
- [ ] Select & confirm candidate action
- [ ] Auto-generate invoice on candidate confirmation (PDF)
- [ ] Invoice list with download & payment status
- [ ] Rating/review system for guides (after job completion)
- [ ] Notification inbox

### Phase 1D: Guide Dashboard
**Priority: High | Estimated: 2-3 days**

- [ ] Guide dashboard (overview stats: applied jobs, accepted, notifications)
- [ ] Profile management (license, experience, skills, languages, social links, documents)
- [ ] Document upload for verification (license, passports, certs)
- [ ] Browse available jobs (with filters: type, location, date, salary range)
- [ ] Job detail view with one-click apply
- [ ] My Applications page (status: Pending, Shortlisted, Accepted, Rejected)
- [ ] Notification inbox
- [ ] View reviews received from agencies

### Phase 1E: Notifications & Polish
**Priority: Medium | Estimated: 1-2 days**

- [ ] Real-time notifications (database driver + polling or Pusher)
- [ ] Email notifications:
  - New job posted → matching guides
  - Application received → agency
  - Application status update → guide
  - Account approved/rejected → user
  - Invoice generated → agency
- [ ] Notification bell with unread counter (top-right)
- [ ] Mark as read / mark all as read

---

## 6. UI/UX Flow

### Agency Flow
```
Register → Pending Approval → Login → Dashboard
  → Post Job → Await Admin Approval → Job Live
  → Applicants received → Review profiles → Select candidate → Confirm
  → Receive invoice & applicant documents → Download/Pay
```

### Tour Leader / Guide Flow
```
Register → Upload Documents → Pending Approval → Login → Dashboard
  → Browse Jobs → View Details → Apply (one-click)
  → Receive notifications (status updates)
  → Confirmed → Job added to "My Applications"
```

### Admin Flow
```
Login → Dashboard overview
  → Approve/Reject new users (with document verification)
  → Approve/Reject job posts
  → Monitor all applications
  → Manage invoices & update payment status
  → Run monthly reports
```

---

## 7. UI/UX Guidelines

- **Layout**: Dashboard-style navigation
  - Left sidebar: Jobs, Applications, Profile, Notifications
  - Main panel for active content
- **Branding**: Navy blue (`#1B2A4A`) background/highlights, gold (`#D4A843`) accent for buttons/headers
- **Responsive**: Mobile-first, optimized for mobile browsers
- **Icons**: Icon + Text Labels for clarity (Heroicons)
- **Notification Bell**: Top-right corner with unread counter badge
- **Tables**: DataTable with search, sort, pagination
- **Forms**: Clean sections with validation feedback
- **Cards**: Rounded corners, subtle shadows, consistent spacing

---

## 8. Key Pages / Routes

### Public
| Route | Page |
|-------|------|
| `/` | Landing page (marketing) |
| `/login` | Login |
| `/register` | Register (role selection) |

### Guide (auth + role:guide + approved)
| Route | Page |
|-------|------|
| `/guide/dashboard` | Dashboard overview |
| `/guide/profile` | Profile management |
| `/guide/jobs` | Browse available jobs |
| `/guide/jobs/{id}` | Job detail + apply |
| `/guide/applications` | My applications |
| `/guide/notifications` | Notification inbox |

### Agency (auth + role:agency + approved)
| Route | Page |
|-------|------|
| `/agency/dashboard` | Dashboard overview |
| `/agency/profile` | Company profile |
| `/agency/jobs` | My posted jobs |
| `/agency/jobs/create` | Create new job |
| `/agency/jobs/{id}` | Job detail + applicants |
| `/agency/jobs/{id}/applicants` | Applicant list |
| `/agency/invoices` | Invoice list |
| `/agency/reviews` | Write/manage reviews |
| `/agency/notifications` | Notification inbox |

### Admin (Filament at `/admin`)
| Route | Page |
|-------|------|
| `/admin` | Dashboard (stats + charts) |
| `/admin/users` | User management |
| `/admin/jobs` | Job management |
| `/admin/applications` | Application monitoring |
| `/admin/invoices` | Invoice management |
| `/admin/reports` | Reports & analytics |
| `/admin/notifications` | System notifications |

---

## 9. Future Enhancements (Phase 2)

These are NOT part of initial build — tracked for future reference:

- [ ] In-app chat between Agency & Guide
- [ ] Payment gateway integration for direct payment collection
- [ ] AI-driven job-guide matching (skills/language/experience scoring)

---

## 10. Development Order (Recommended)

```
Step 1: Laravel scaffold + DB migrations + models + seeder
Step 2: Tailwind Navy+Gold theme + base layout
Step 3: Auth (register/login with role + pending approval flow)
Step 4: Admin panel (Filament — user/job approval, dashboard)
Step 5: Agency dashboard (profile, post jobs, review applicants)
Step 6: Guide dashboard (profile, browse jobs, apply, my applications)
Step 7: Invoice system (auto-generate PDF on confirm)
Step 8: Notification system (database + email)
Step 9: Reviews & ratings
Step 10: Testing, polish, responsive fixes
```

---

## 11. To Do Schedule (5-Day Sprint)

> **Strategy**: Use Filament 3 multi-panel for ALL 3 roles (Admin, Agency, Guide).
> This eliminates custom Blade dashboard builds and saves 60%+ frontend work.
> Filament handles tables, forms, navigation, auth, and notifications natively.

### Day 1 — Foundation & Auth
| # | Task | Status |
|---|------|--------|
| 1 | Laravel 12 project scaffold | [x] |
| 2 | All database migrations (users, guide_profiles, agency_profiles, jobs, applications, invoices, reviews, notifications, documents) | [x] |
| 3 | Models with relationships & factories | [x] |
| 4 | DatabaseSeeder (demo admin, agencies, guides, jobs) | [x] |
| 5 | Install Filament 3 with **3 panels**: Admin (`/admin`), Agency (`/agency`), Guide (`/guide`) | [x] |
| 6 | Tailwind CSS 4 config — Navy Blue `#1B2A4A` + Gold `#D4A843` | [x] |
| 7 | Auth: Register page with role selection (Guide / Agency) | [x] |
| 8 | Pending approval middleware — block login until admin approves | [x] |
| 9 | "Pending Approval" landing page for unapproved users | [x] |

### Day 2 — Admin Panel (Filament)
| # | Task | Status |
|---|------|--------|
| 1 | Admin dashboard — stat widgets (total users, active jobs, total applications, revenue) | [x] |
| 2 | User Management resource (list, approve/reject action, document preview) | [x] |
| 3 | Job Management resource (list, approve/reject action, status badges) | [x] |
| 4 | Application resource (monitor all applications across jobs) | [x] |
| 5 | Invoice resource (list, update payment status: Pending/Paid) | [x] |
| 6 | Reports page — simple stat cards (active jobs, app count, revenue by month, users by role) | [x] |

### Day 3 — Agency Panel (Filament)
| # | Task | Status |
|---|------|--------|
| 1 | Agency dashboard — stat widgets (my jobs, total applicants, invoices) | [x] |
| 2 | Agency profile page (company info, MOTAC reg, contact person, logo upload) | [x] |
| 3 | Job resource — CRUD (title, description, dates, type, requirements, salary) | [x] |
| 4 | Job detail: applicant list with guide profile preview (modal/slide-over) | [x] |
| 5 | Select & confirm candidate action (button on applicant row) | [x] |
| 6 | Auto-generate invoice on candidate confirmation (DomPDF) | [x] |
| 7 | Invoice resource — list with PDF download & payment status badge | [x] |
| 8 | Rating/review form for guides (after job completion) | [x] |

### Day 4 — Guide Panel (Filament)
| # | Task | Status |
|---|------|--------|
| 1 | Guide dashboard — stat widgets (applied jobs, accepted count, pending count) | [x] |
| 2 | Guide profile page (license, experience, skills, languages, social links, bio) | [x] |
| 3 | Document upload section (license, passport, certs — file upload) | [x] |
| 4 | Browse Jobs resource — list all active/approved jobs (filters: type, location, date) | [x] |
| 5 | One-click apply action (button on job row / detail page) | [x] |
| 6 | My Applications resource (status badges: Pending/Shortlisted/Accepted/Rejected) | [x] |
| 7 | View received reviews from agencies | [x] |

### Day 5 — Notifications, Polish & Testing
| # | Task | Status |
|---|------|--------|
| 1 | Database notifications — Filament native notification system | [x] |
| 2 | Notification bell with unread counter (top-right, all 3 panels) | [x] |
| 3 | Email notifications (key events): account approved, application status change, invoice generated | [x] |
| 4 | Mark as read / mark all as read | [x] |
| 5 | Responsive testing across all panels | [x] |
| 6 | Bug fixes & edge cases | [x] |
| 7 | Final data seeder cleanup | [x] |

### What Gets Deferred to Post-Sprint
- Fancy landing/marketing page (simple login redirect for now)
- Advanced report charts (simple stat cards first)
- In-app chat (Phase 2)
- Payment gateway integration (Phase 2)
- AI-driven job matching (Phase 2)
