# 🚀 MS CRM - Sistema de Gestión de Relaciones

Sistema CRM modular y escalable para la gestión de contactos, organizaciones e interacciones empresariales.

## 📋 Características

- ✅ **Dashboard Ejecutivo** con KPIs en tiempo real
- ✅ **Gestión de Contactos** completa (CRUD)
- ✅ **Gestión de Organizaciones** (gobiernos, ONGs, empresas, comunidades)
- ✅ **Timeline de Interacciones** (emails, llamadas, reuniones, eventos, notas)
- ✅ **Segmentación de Audiencias** dinámica y estática
- ✅ **Auditoría Completa** de todas las acciones
- ✅ **Búsqueda y Filtros** avanzados
- ✅ **Sistema Multiidioma** (Español/Inglés)
- ✅ **Dark Mode** completo
- ✅ **Responsive Design** (móvil, tablet, desktop)

## 🛠️ Stack Tecnológico

- **Backend:** Laravel 11 + PHP 8.2
- **Frontend:** Livewire 3 + Flux UI
- **Base de Datos:** MySQL
- **Autenticación:** Laravel Fortify (con 2FA)
- **Testing:** Pest PHP
- **Build:** Vite

## 🚀 Instalación

### Requisitos Previos
- PHP 8.2+
- Composer
- Node.js & NPM
- MySQL 8.0+

### Pasos de Instalación

1. **Clonar el repositorio**
```bash
git clone [url-del-repo]
cd ms
```

2. **Instalar dependencias**
```bash
composer install
npm install
```

3. **Configurar el entorno**
```bash
cp .env.example .env
```

Editar `.env` con tus credenciales de MySQL:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=ms_crm
DB_USERNAME=root
DB_PASSWORD=tu_password
```

4. **Generar key y migrar base de datos**
```bash
php artisan key:generate
php artisan migrate:fresh --seed
```

5. **Compilar assets**
```bash
npm run build
# o para desarrollo:
npm run dev
```

6. **Iniciar servidor**
```bash
php artisan serve
```

Acceder a: `http://localhost:8000`

**Credenciales por defecto:**
- Email: `test@example.com`
- Password: `password`

## 📊 Datos de Prueba

El seeder incluye datos realistas:
- **1 Usuario** de prueba
- **5 Organizaciones** de diferentes tipos (gobierno, ONG, empresa, comunidad)
- **8 Contactos** vinculados a organizaciones con diferentes roles
- **10 Interacciones** (6 pasadas y 4 próximas) con variedad de tipos y resultados

Para regenerar los datos:
```bash
php artisan migrate:fresh --seed
```

## 🏗️ Estructura del Proyecto

```
app/
├── Livewire/
│   ├── Dashboard.php           # Dashboard principal con KPIs
│   ├── Contacts/               # CRUD de contactos
│   │   ├── Index.php
│   │   ├── Create.php
│   │   ├── Show.php
│   │   └── Edit.php
│   ├── Organizations/          # CRUD de organizaciones
│   │   ├── Index.php
│   │   ├── Create.php
│   │   ├── Show.php
│   │   └── Edit.php
│   └── Actions/                # Acciones rápidas
├── Models/
│   ├── User.php
│   ├── Contact.php
│   ├── Organization.php
│   ├── Interaction.php
│   ├── Segment.php
│   ├── Campaign.php
│   └── Activity.php
resources/
├── views/
│   ├── components/
│   │   ├── app-logo.blade.php
│   │   └── layouts/
│   └── livewire/
│       ├── dashboard.blade.php
│       ├── contacts/
│       └── organizations/
├── js/
│   └── app.js
└── css/
    └── app.css
routes/
└── web.php                     # Rutas principales
database/
├── migrations/                 # Esquema de base de datos
└── seeders/
    └── DatabaseSeeder.php      # Datos de prueba
```

## 🌐 Internacionalización

El sistema soporta múltiples idiomas. Los archivos de traducción están en:

```
lang/
├── en/                         # Inglés
│   ├── contacts.php
│   ├── organizations.php
│   ├── interactions.php
│   └── navigation.php
└── es/                         # Español
    ├── contacts.php
    ├── organizations.php
    ├── interactions.php
    └── navigation.php
```

Para cambiar el idioma por defecto, editar `config/app.php`:
```php
'locale' => 'es', // o 'en'
```

## 🧪 Testing

Ejecutar pruebas con Pest:
```bash
php artisan test
# o directamente con Pest
./vendor/bin/pest
```

## 📝 Modelos Principales

### Contact
Gestión de contactos individuales con:
- Información básica (nombre, email, teléfono, posición)
- Relación con organizaciones
- Seguimiento de interacciones
- Segmentación por tags y campos personalizados
- Estados: active, inactive
- Fuentes: manual, import, form, api

### Organization
Gestión de organizaciones con:
- **Tipos**: gobierno, ONG, empresa, comunidad, otro
- Información completa (industria, web, contacto)
- Gestión de contactos asociados
- Dirección estructurada (JSON)
- Campos personalizados y tags
- Estados: active, inactive, archived

### Interaction
Seguimiento de interacciones con:
- **Tipos**: email, call, meeting, event, note
- Información detallada (asunto, descripción, duración)
- Outcomes: positive, neutral, negative
- Próximas interacciones y recordatorios
- Timeline histórico completo
- Vinculación a contactos y organizaciones

### Segment
Segmentación de audiencias:
- Segmentación dinámica con reglas
- Segmentación estática manual
- Integración con campañas
- Tipos: dynamic, static

### Campaign
Gestión de campañas:
- Tipos: email, event, survey
- Estados: draft, scheduled, active, completed, cancelled
- Métricas de rendimiento
- Vinculación a segmentos

## 🔐 Seguridad

- **Autenticación**: Laravel Fortify con soporte completo
- **Two-Factor Authentication (2FA)**: Disponible para usuarios
- **Soft Deletes**: Habilitado en todos los modelos críticos
- **Auditoría**: Tracking de created_by/updated_by
- **Validación**: Componentes Livewire con validación en tiempo real
- **Proteción CSRF**: Habilitada en todos los formularios

## 🎨 UI/UX

- **Flux UI Components**: Sistema de componentes moderno y consistente
- **Tailwind CSS**: Utilidad-first CSS framework
- **Dark Mode**: Soporte completo con toggle
- **Responsive**: Optimizado para móvil, tablet y desktop
- **Accesibilidad**: Componentes accesibles y navegación por teclado

## 🔄 Desarrollo

### Comandos útiles

```bash
# Desarrollo con hot reload
npm run dev

# Build para producción
npm run build

# Limpiar cache de Laravel
php artisan optimize:clear

# Ver logs en tiempo real
php artisan pail

# Ejecutar queue workers
php artisan queue:work

# Crear nuevo componente Livewire
php artisan make:livewire NombreComponente
```

### Variables de entorno importantes

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

MAIL_MAILER=smtp
# ... configuración de email
```

### Configuración para Subdirectorio (cPanel)

Si instalas en un subdirectorio como `https://dominio.com/ms_crm`, sigue estos pasos:

**1. Configura el `.env` en el servidor:**
```env
APP_ENV=production
APP_DEBUG=false
APP_URL=https://automata.pe/ms_crm
ASSET_URL=https://automata.pe/ms_crm
```

**2. Limpia y cachea la configuración:**
```bash
php artisan config:clear
php artisan cache:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

**3. Da permisos a las carpetas:**
```bash
chmod -R 775 storage bootstrap/cache
```

El sistema ahora usará correctamente las rutas con el subdirectorio `/ms_crm`.

## 🚦 Roadmap

Futuras mejoras planificadas:

- [ ] API REST para integraciones externas
- [ ] Exportación de reportes (PDF/Excel)
- [ ] Sistema de notificaciones en tiempo real
- [ ] Gestión de archivos y documentos
- [ ] Dashboard personalizable por usuario
- [ ] Integración con email (IMAP/SMTP)
- [ ] Webhooks para eventos
- [ ] Sistema de permisos y roles
- [ ] Multi-tenancy
- [ ] Módulo de reportes avanzados

## 📈 Métricas del Dashboard

El dashboard muestra:
- **Total de Contactos**: Contador con tendencia
- **Total de Organizaciones**: Contador con tendencia
- **Interacciones del Mes**: Contador con tendencia
- **Interacciones Recientes**: Lista de las últimas interacciones
- **Próximas Interacciones**: Calendario de actividades agendadas

## 🤝 Contribución

Este es un proyecto privado. Para contribuir, contactar al equipo de desarrollo.

## 📄 Licencia

Este proyecto es software propietario.

## 👥 Soporte

Para soporte y consultas, contactar al equipo de desarrollo.

---

**Desarrollado con ❤️ usando Laravel + Livewire**
