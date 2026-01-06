# 🚀 MS CRM - Customer Relationship Management System

Simple and easy CRM system for managing contacts, organizations and business interactions.

## 📋 Features

- ✅ **Dashboard** with real-time stats
- ✅ **Contact Management** (full CRUD)
- ✅ **Organization Management** (government, NGOs, companies, communities)
- ✅ **Interaction Timeline** (emails, calls, meetings, events, notes)
- ✅ **Audience Segments** (dynamic and static)
- ✅ **Complete Audit Trail**
- ✅ **Search and Filters**
- ✅ **Multi-language** (Spanish/English)
- ✅ **Dark Mode**
- ✅ **Responsive Design** (mobile, tablet, desktop)

## 🛠️ Tech Stack

- **Backend:** Laravel 11 + PHP 8.4
- **Frontend:** Livewire 3 + Flux UI
- **Database:** MySQL
- **Auth:** Laravel Fortify (with 2FA)
- **Testing:** Pest PHP
- **Build:** Vite

## 🚀 Quick Start

### What You Need
- PHP 8.4+
- Composer
- Node.js & NPM
- MySQL 8.0+

### Installation

1. **Clone the repo**
```bash
git clone [repo-url]
cd ms
```

2. **Install stuff**
```bash
composer install
npm install
```

3. **Set up your environment**
```bash
cp .env.example .env
```

Edit `.env` with your MySQL info:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=ms_crm
DB_USERNAME=root
DB_PASSWORD=your_password
```

4. **Set up database**
```bash
php artisan key:generate
php artisan migrate:fresh --seed
```

5. **Build assets**
```bash
npm run build
# or for dev:
npm run dev
```

6. **Start it up**
```bash
php artisan serve
```

Open: `http://localhost:8000`

**Login:**
- Email: `test@example.com`
- Password: `password`

## 📊 Sample Data

The seeder creates:
- **1 Test User**
- **5 Organizations** (different types)
- **8 Contacts** (linked to organizations)
- **10 Interactions** (past and upcoming)

Reset data anytime:
```bash
php artisan migrate:fresh --seed
```

## 🏗️ What's Inside

```
app/
├── Livewire/              # UI components
│   ├── Dashboard.php
│   ├── Contacts/          # Contact pages
│   └── Organizations/     # Organization pages
├── Models/                # Database models
resources/
├── views/livewire/        # Blade templates
└── js/ & css/             # Frontend assets
routes/
└── web.php                # App routes
database/
├── migrations/            # DB structure
└── seeders/               # Sample data
```

## 🌐 Languages

Switch between English and Spanish. Files in `lang/en/` and `lang/es/`.

Change default in `config/app.php`:
```php
'locale' => 'en', // or 'es'
```

## 🧪 Testing

```bash
php artisan test
```

## 📝 Main Features

### Contacts
- Basic info (name, email, phone, job title)
- Link to organizations
- Track interactions
- Custom tags and fields
- Status: active/inactive
- Source: manual/import/form/api

### Organizations
- Types: government, NGO, company, community, other
- Industry, website, contact info
- Manage contacts
- Address (JSON format)
- Custom fields and tags
- Status: active/inactive/archived

### Interactions
- Types: email, call, meeting, event, note
- Details: subject, description, duration
- Results: positive, neutral, negative
- Schedule future interactions
- Full history

### Segments
- Dynamic (with rules)
- Static (manual)
- Use for campaigns

### Campaigns
- Types: email, event, survey
- Status: draft, scheduled, active, completed, cancelled
- Performance tracking

## 🔐 Security

- Laravel Fortify authentication
- Two-Factor Authentication (2FA)
- Soft deletes
- Audit tracking (created_by/updated_by)
- Real-time validation
- CSRF protection

## 🎨 UI/UX

- Flux UI components
- Tailwind CSS
- Dark mode
- Fully responsive
- Keyboard navigation

## 🔄 Dev Commands

```bash
npm run dev              # Hot reload
npm run build            # Production build
php artisan optimize:clear    # Clear cache
php artisan pail         # View logs
php artisan queue:work   # Run queue
php artisan make:livewire Name  # New component
```

## ⚙️ Environment Setup

```env
APP_NAME="MS CRM"
APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=ms_crm
DB_USERNAME=root
DB_PASSWORD=
```

### Subdirectory Setup (cPanel)

If installing in a subdirectory like `https://domain.com/ms_crm`:

**1. Update `.env` on server:**
```env
APP_ENV=production
APP_DEBUG=false
APP_URL=https://automata.pe/ms_crm
```

**2. Check `.htaccess` has:**
```apache
RewriteBase /ms_crm/
```

**3. Clear cache:**
```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

**4. Set permissions:**
```bash
chmod -R 775 storage bootstrap/cache
```

## 🚦 Coming Soon

- [ ] REST API
- [ ] PDF/Excel exports
- [ ] Real-time notifications
- [ ] File management
- [ ] Custom dashboards
- [ ] Email integration
- [ ] Webhooks
- [ ] Roles & permissions
- [ ] Multi-tenancy

## 📈 Dashboard

Shows:
- Total Contacts
- Total Organizations  
- Monthly Interactions
- Recent activity
- Upcoming events

## 📄 License

Proprietary software.

## 👥 Support

Contact the dev team for help.

---

**Made with ❤️ using Laravel + Livewire**
