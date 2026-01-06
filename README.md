# 🚀 CRM - Sistema de Gestión de Relaciones

Sistema CRM modular y escalable para la gestión de comunidades, stakeholders y relacionamiento institucional.

## 📋 Características

- ✅ **Dashboard Ejecutivo** con KPIs en tiempo real
- ✅ **Gestión de Contactos** completa (CRUD)
- ✅ **Gestión de Organizaciones** (gobiernos, ONGs, empresas, comunidades)
- ✅ **Timeline de Interacciones** (emails, llamadas, reuniones, eventos, notas)
- ✅ **Segmentación de Audiencias** dinámica y estática
- ✅ **Campañas** (email, eventos, encuestas)
- ✅ **Auditoría Completa** de todas las acciones
- ✅ **Búsqueda y Filtros** avanzados
- ✅ **Dark Mode** completo
- ✅ **Responsive Design** (móvil, tablet, desktop)

## 🛠️ Stack Tecnológico

- **Backend:** Laravel 12 + PHP 8.2
- **Frontend:** Livewire 3 + Flux UI
- **Base de Datos:** SQLite (dev) / MySQL (prod)
- **Autenticación:** Laravel Fortify
- **Testing:** Pest PHP
- **Build:** Vite

## 🚀 Instalación

### Requisitos Previos
- PHP 8.2+
- Composer
- Node.js & NPM

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
php artisan key:generate
```

4. **Ejecutar migraciones y seeders**
```bash
php artisan migrate --seed
# O específicamente el seeder del CRM:
php artisan db:seed --class=CRMSeeder
```

5. **Compilar assets**
```bash
npm run build
# O en modo desarrollo:
npm run dev
```

6. **Iniciar el servidor**
```bash
# Opción 1: Servidor completo con queue, logs y vite
composer run dev

# Opción 2: Solo servidor
php artisan serve
```

7. **Acceder al sistema**
- URL: http://localhost:8000
- Email: `admin@crm.test`
- Password: `password`

## 📊 Datos de Prueba

El sistema incluye un seeder completo con datos de prueba:

- **1 Usuario Admin** (admin@crm.test / password)
- **4 Organizaciones** (Gobierno, ONG, Empresa, Comunidad)
- **6 Contactos** con diferentes roles
- **6 Interacciones** variadas
- **3 Segmentos** de audiencia
- **3 Campañas** en diferentes estados

Para cargar los datos:
```bash
php artisan db:seed --class=CRMSeeder
```

## 🔑 Credenciales por Defecto

**Usuario Administrador:**
- Email: `admin@crm.test`
- Password: `password`

⚠️ **IMPORTANTE:** Cambiar estas credenciales en producción.

## 📁 Estructura del Proyecto

```
app/
├── Livewire/               # Componentes Livewire
│   ├── Dashboard.php
│   └── Contacts/
│       ├── Index.php
│       ├── Create.php
│       └── Show.php
└── Models/                 # Modelos Eloquent
    ├── Organization.php
    ├── Contact.php
    ├── Interaction.php
    ├── Segment.php
    ├── Campaign.php
    └── Activity.php

database/
├── migrations/             # Migraciones de BD
└── seeders/
    └── CRMSeeder.php

resources/views/livewire/   # Vistas Livewire
├── dashboard.blade.php
└── contacts/
    ├── index.blade.php
    ├── create.blade.php
    └── show.blade.php
```

## 🎯 Rutas Principales

### Dashboard
- `GET /dashboard` - Dashboard principal con KPIs

### Contacts
- `GET /contacts` - Lista de contactos
- `GET /contacts/create` - Crear nuevo contacto
- `GET /contacts/{id}` - Perfil de contacto con interacciones

### Organizations
- `GET /organizations` - Lista de organizaciones

## 📖 Documentación

Para más información detallada:

- **[CRM_ARCHITECTURE.md](CRM_ARCHITECTURE.md)** - Arquitectura completa del sistema
- **[CRM_EXECUTIVE_SUMMARY.md](CRM_EXECUTIVE_SUMMARY.md)** - Resumen ejecutivo
- **[CRM_STATUS.md](CRM_STATUS.md)** - Estado actual del proyecto

## 🧪 Testing

Ejecutar tests:
```bash
php artisan test
# O con Pest:
./vendor/bin/pest
```

## 🚢 Deployment

### Preparar para Producción

1. **Configurar variables de entorno**
```bash
APP_ENV=production
APP_DEBUG=false
APP_URL=https://tu-dominio.com
```

2. **Cambiar base de datos a MySQL/PostgreSQL**
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=crm_db
DB_USERNAME=root
DB_PASSWORD=
```

3. **Optimizar aplicación**
```bash
composer install --optimize-autoloader --no-dev
php artisan config:cache
php artisan route:cache
php artisan view:cache
npm run build
```

4. **Ejecutar migraciones en producción**
```bash
php artisan migrate --force
```

## 🔐 Seguridad

- ✅ Middleware de autenticación en todas las rutas protegidas
- ✅ Validación de formularios
- ✅ CSRF Protection
- ✅ Password hashing (bcrypt)
- ✅ SQL Injection protection (Eloquent)
- ⚠️ 2FA disponible (configurar en settings)

## 📈 Roadmap

### Fase 1: MVP (✅ Completado)
- [x] Base de datos
- [x] Modelos
- [x] Dashboard
- [x] CRUD de contactos
- [x] Sistema de interacciones

### Fase 2: Escalamiento
- [ ] Módulo de organizaciones completo
- [ ] Importación/Exportación CSV
- [ ] Reportes avanzados
- [ ] Búsqueda global

### Fase 3: Automatización
- [ ] Motor de automatización
- [ ] Workflows
- [ ] Plantillas de email
- [ ] Segmentos dinámicos

### Fase 4: Campañas
- [ ] Email marketing
- [ ] Tracking de emails
- [ ] Formularios
- [ ] Landing pages

### Fase 5: Multi-tenant
- [ ] Sistema de tenants
- [ ] Planes y suscripciones
- [ ] Facturación

## 🤝 Contribuir

Las contribuciones son bienvenidas! Por favor:

1. Fork el proyecto
2. Crea tu feature branch (`git checkout -b feature/AmazingFeature`)
3. Commit tus cambios (`git commit -m 'Add some AmazingFeature'`)
4. Push al branch (`git push origin feature/AmazingFeature`)
5. Abre un Pull Request

## 📝 Licencia

MIT License - ver el archivo [LICENSE](LICENSE) para más detalles.

## 💬 Soporte

Para preguntas o soporte:
- Documentación: Ver archivos `CRM_*.md`
- Issues: Abrir un issue en GitHub
- Email: [tu-email@ejemplo.com]

## 👥 Autores

- **Tu Nombre** - *Desarrollo inicial* - [GitHub](https://github.com/tu-usuario)

## 🙏 Agradecimientos

- Laravel Team
- Livewire Team
- Flux UI Team
- Comunidad Open Source

---

**Desarrollado con ❤️ usando Laravel + Livewire + Flux UI**

**Versión:** 1.0.0 MVP  
**Última actualización:** 2026-01-06
