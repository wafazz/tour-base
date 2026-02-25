# Tour Base

**Digital Job Matching Platform** — Connecting Travel Agencies with Tour Leaders & Guides.

Built with Laravel 12, Filament 3, Livewire 3, and Tailwind CSS 4.

---

## Overview

Tour Base is a multi-panel platform that streamlines the hiring process between travel agencies and freelance tour guides/leaders. Agencies post tour jobs, guides browse and apply, and admins oversee the entire workflow — from user approval to invoicing.

### Key Features

- **Multi-role system** — Admin, Agency, and Guide panels with role-based access
- **Registration with approval** — New users require admin approval before accessing their panel
- **Job posting & application** — Agencies post jobs, guides apply with cover letters
- **Application workflow** — Shortlist, accept, or reject applicants with status tracking
- **Auto-invoicing** — Invoices auto-generated on candidate acceptance (6% SST included)
- **PDF invoices** — Branded Navy + Gold PDF generation via DomPDF
- **Notifications** — Database + email notifications with Filament bell icon (7 notification types)
- **Rating & reviews** — Agencies rate guides after job completion
- **Dashboard analytics** — Charts, stats, and reports on each panel
- **System settings** — Admin-configurable site name, branding, contact info, social links
- **PWA support** — Installable web app with offline fallback

---

## Tech Stack

| Layer | Technology |
|-------|-----------|
| Framework | Laravel 12 |
| Admin Panels | Filament 3.3 (multi-panel) |
| Reactivity | Livewire 3 |
| Styling | Tailwind CSS 4 |
| Database | MySQL 8 |
| PDF | DomPDF |
| Auth | Laravel built-in + Filament auth |
| Notifications | Laravel Notifications (database + mail) |

---

## Panels

### Admin Panel (`/admin`)
- **Dashboard**: 6 stat cards + 6 chart/table widgets
- **Resources**: Users, Tour Jobs, Applications, Invoices
- **Pages**: Reports, System Settings
- **Actions**: Approve/reject users and jobs, mark invoices paid

### Agency Panel (`/agency`)
- **Dashboard**: 6 stat cards + 6 chart/table widgets
- **Resources**: Tour Jobs (scoped CRUD), Invoices (scoped + PDF), Reviews
- **Pages**: Agency Profile, Agency Reports
- **Relation Manager**: View applicants per job — profile modal, shortlist/accept/reject
- **Auto-invoice**: Generated on candidate acceptance with 6% SST

### Guide Panel (`/guide`)
- **Dashboard**: 6 stat cards + 4 chart/table widgets
- **Resources**: Available Jobs (browse + apply), My Applications, My Reviews
- **Pages**: Guide Profile (license, skills, languages, documents), Guide Reports
- **Apply**: One-click apply with cover letter from job listing or detail page

---

## Database

12 migrations with 9 models:

| Table | Purpose |
|-------|---------|
| `users` | All users (admin, agency, guide) with role + approval status |
| `guide_profiles` | License, experience, skills, languages, social links |
| `agency_profiles` | Company name, MOTAC license, address, logo |
| `tour_jobs` | Job listings (inbound/outbound, location, dates, salary) |
| `applications` | Guide applications with status (pending/shortlisted/accepted/rejected) |
| `invoices` | Auto-generated invoices with SST calculation |
| `reviews` | Agency-to-guide ratings and comments |
| `documents` | Guide uploaded documents (license, passport, certs) |
| `notifications` | Laravel database notifications |
| `settings` | Key-value system settings |

> Note: `tour_jobs` used instead of `jobs` to avoid conflict with Laravel's queue table.

---

## Notifications

7 notification classes (database + mail channels):

| Notification | Trigger | Recipient |
|-------------|---------|-----------|
| AccountApproved | Admin approves user | User |
| AccountRejected | Admin rejects user | User |
| JobApproved | Admin approves job | Agency |
| JobRejected | Admin rejects job | Agency |
| NewApplication | Guide applies to job | Agency |
| ApplicationStatusChanged | Agency shortlists/accepts/rejects | Guide |
| InvoiceGenerated | Candidate accepted | Agency |

Bell icon with unread counter on all 3 panels, polling every 30 seconds.

---

## Installation

### Requirements
- PHP 8.2+
- Composer
- Node.js & npm
- MySQL 8

### Setup

```bash
# Clone the repository
git clone https://github.com/wafazz/tour-base.git
cd tour-base

# Install dependencies
composer install
npm install

# Environment
cp .env.example .env
php artisan key:generate
```

Configure `.env`:
```env
DB_DATABASE=tour_base
DB_USERNAME=root
DB_PASSWORD=
```

```bash
# Database
php artisan migrate --seed

# Storage symlink (required for logo/document uploads)
php artisan storage:link

# Build assets
npm run build

# Serve
php artisan serve
```

---

## Default Credentials

| Role | Email | Password | Panel |
|------|-------|----------|-------|
| Admin | admin@tourbase.com | password | `/admin` |
| Agency | agency@tourbase.com | password | `/agency` |
| Guide | guide@tourbase.com | password | `/guide` |

---

## Project Structure

```
app/
├── Filament/
│   ├── Admin/
│   │   ├── Resources/        # UserResource, TourJobResource, ApplicationResource, InvoiceResource
│   │   ├── Pages/             # Reports, SystemSettings
│   │   └── Widgets/           # 7 dashboard widgets
│   ├── Agency/
│   │   ├── Resources/         # TourJobResource, InvoiceResource, ReviewResource
│   │   ├── Pages/             # AgencyProfile, AgencyReports, AgencyRegister
│   │   └── Widgets/           # 6 dashboard widgets
│   └── Guide/
│       ├── Resources/         # AvailableJobResource, ApplicationResource, ReviewResource
│       ├── Pages/             # GuideProfile, GuideReports, GuideRegister
│       └── Widgets/           # 4 dashboard widgets
├── Models/                    # 9 models
├── Notifications/             # 7 notification classes
└── Providers/
    └── Filament/              # AdminPanelProvider, AgencyPanelProvider, GuidePanelProvider

public/
├── icons/                     # PWA icons (192x192, 512x512)
├── manifest.webmanifest       # PWA manifest
├── sw.js                      # Service worker
└── offline.html               # Offline fallback page
```

---

## Mail

Default mail driver is `log` (development). For production, update `.env`:

```env
MAIL_MAILER=smtp
# or use Resend, Mailgun, etc.
```

---

## Theme

- **Primary**: Navy Blue `#1B2A4A`
- **Accent**: Gold `#D4A843`

Applied across all panels, PDF invoices, PWA offline page, and branding.

---

## License

This project is proprietary software developed by [Codex Lure](https://codexlure.tech).
