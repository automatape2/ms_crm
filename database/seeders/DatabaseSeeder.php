<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Organization;
use App\Models\Contact;
use App\Models\Interaction;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create main user
        $user = User::firstOrCreate(
            ['email' => 'test@example.com'],
            [
                'name' => 'Test User',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ]
        );

        // Create Organizations
        $organizations = [
            [
                'name' => 'Municipalidad de San José',
                'type' => 'gobierno',
                'industry' => 'Gobierno Local',
                'email' => 'contacto@sanjose.gob',
                'phone' => '+506 2222-3333',
                'website' => 'https://sanjose.gob.cr',
                'status' => 'active',
                'address' => [
                    'street' => 'Avenida Central',
                    'city' => 'San José',
                    'country' => 'Costa Rica',
                ],
                'tags' => ['gobierno', 'municipal', 'prioritario'],
                'created_by' => $user->id,
            ],
            [
                'name' => 'Fundación Verde',
                'type' => 'ong',
                'industry' => 'Medio Ambiente',
                'email' => 'info@fundacionverde.org',
                'phone' => '+506 2444-5555',
                'website' => 'https://fundacionverde.org',
                'status' => 'active',
                'address' => [
                    'street' => 'Barrio Escalante',
                    'city' => 'San José',
                    'country' => 'Costa Rica',
                ],
                'tags' => ['ong', 'ambiente', 'sostenibilidad'],
                'created_by' => $user->id,
            ],
            [
                'name' => 'TechCR Solutions',
                'type' => 'empresa',
                'industry' => 'Tecnología',
                'email' => 'ventas@techcr.com',
                'phone' => '+506 2100-2000',
                'website' => 'https://techcr.com',
                'status' => 'active',
                'address' => [
                    'street' => 'Escazú Corporate Center',
                    'city' => 'San José',
                    'country' => 'Costa Rica',
                ],
                'tags' => ['empresa', 'tecnología', 'socio'],
                'created_by' => $user->id,
            ],
            [
                'name' => 'Asociación Vecinal Barrio Amón',
                'type' => 'comunidad',
                'industry' => 'Desarrollo Comunitario',
                'email' => 'barrioamon@gmail.com',
                'phone' => '+506 8888-9999',
                'status' => 'active',
                'address' => [
                    'street' => 'Barrio Amón',
                    'city' => 'San José',
                    'country' => 'Costa Rica',
                ],
                'tags' => ['comunidad', 'vecinos'],
                'created_by' => $user->id,
            ],
            [
                'name' => 'Cámara de Comercio',
                'type' => 'empresa',
                'industry' => 'Comercio',
                'email' => 'info@camara.co.cr',
                'phone' => '+506 2221-0005',
                'website' => 'https://camara.co.cr',
                'status' => 'inactive',
                'address' => [
                    'city' => 'San José',
                    'country' => 'Costa Rica',
                ],
                'tags' => ['comercio', 'asociación'],
                'created_by' => $user->id,
            ],
        ];

        $createdOrgs = [];
        foreach ($organizations as $orgData) {
            $createdOrgs[] = Organization::create($orgData);
        }

        // Create Contacts
        $contacts = [
            [
                'first_name' => 'María',
                'last_name' => 'González',
                'email' => 'maria.gonzalez@sanjose.gob',
                'phone' => '+506 8888-1111',
                'position' => 'Directora de Comunicación',
                'organization_id' => $createdOrgs[0]->id,
                'status' => 'active',
                'source' => 'manual',
                'tags' => ['gobierno', 'comunicación'],
                'created_by' => $user->id,
            ],
            [
                'first_name' => 'Carlos',
                'last_name' => 'Ramírez',
                'email' => 'carlos@fundacionverde.org',
                'phone' => '+506 8888-2222',
                'position' => 'Director Ejecutivo',
                'organization_id' => $createdOrgs[1]->id,
                'status' => 'active',
                'source' => 'manual',
                'tags' => ['ong', 'director'],
                'created_by' => $user->id,
            ],
            [
                'first_name' => 'Ana',
                'last_name' => 'Mora',
                'email' => 'ana.mora@techcr.com',
                'phone' => '+506 8888-3333',
                'position' => 'Gerente de Proyectos',
                'organization_id' => $createdOrgs[2]->id,
                'status' => 'active',
                'source' => 'form',
                'tags' => ['tecnología', 'proyectos'],
                'created_by' => $user->id,
            ],
            [
                'first_name' => 'Luis',
                'last_name' => 'Vargas',
                'email' => 'luis.vargas@techcr.com',
                'phone' => '+506 8888-4444',
                'position' => 'CTO',
                'organization_id' => $createdOrgs[2]->id,
                'status' => 'active',
                'source' => 'import',
                'tags' => ['tecnología', 'ejecutivo'],
                'created_by' => $user->id,
            ],
            [
                'first_name' => 'Patricia',
                'last_name' => 'Jiménez',
                'email' => 'patricia.jimenez@gmail.com',
                'phone' => '+506 8888-5555',
                'position' => 'Presidenta',
                'organization_id' => $createdOrgs[3]->id,
                'status' => 'active',
                'source' => 'manual',
                'tags' => ['comunidad', 'liderazgo'],
                'created_by' => $user->id,
            ],
            [
                'first_name' => 'Roberto',
                'last_name' => 'Chen',
                'email' => 'roberto.chen@email.com',
                'phone' => '+506 8888-6666',
                'position' => 'Consultor Independiente',
                'organization_id' => null,
                'status' => 'active',
                'source' => 'form',
                'tags' => ['consultor', 'freelance'],
                'created_by' => $user->id,
            ],
            [
                'first_name' => 'Laura',
                'last_name' => 'Sánchez',
                'email' => 'laura@fundacionverde.org',
                'phone' => '+506 8888-7777',
                'position' => 'Coordinadora de Proyectos',
                'organization_id' => $createdOrgs[1]->id,
                'status' => 'active',
                'source' => 'manual',
                'tags' => ['ong', 'proyectos'],
                'created_by' => $user->id,
            ],
            [
                'first_name' => 'Jorge',
                'last_name' => 'Alpízar',
                'email' => 'jorge.alpizar@sanjose.gob',
                'phone' => '+506 8888-8888',
                'position' => 'Alcalde',
                'organization_id' => $createdOrgs[0]->id,
                'status' => 'active',
                'source' => 'manual',
                'tags' => ['gobierno', 'alcalde', 'vip'],
                'created_by' => $user->id,
            ],
        ];

        $createdContacts = [];
        foreach ($contacts as $contactData) {
            $createdContacts[] = Contact::create($contactData);
        }

        // Create Interactions (past and upcoming)
        $interactions = [
            // Past interactions (this month)
            [
                'type' => 'meeting',
                'subject' => 'Reunión inicial sobre proyecto de sostenibilidad',
                'description' => 'Discutimos las posibilidades de colaboración en proyectos ambientales',
                'date' => now()->subDays(5),
                'duration' => 60,
                'outcome' => 'positive',
                'contact_id' => $createdContacts[1]->id,
                'organization_id' => $createdOrgs[1]->id,
                'next_steps' => 'Enviar propuesta detallada la próxima semana',
                'created_by' => $user->id,
            ],
            [
                'type' => 'email',
                'subject' => 'Seguimiento: Propuesta de colaboración',
                'description' => 'Email de seguimiento sobre la propuesta enviada',
                'date' => now()->subDays(3),
                'outcome' => 'positive',
                'contact_id' => $createdContacts[2]->id,
                'organization_id' => $createdOrgs[2]->id,
                'next_steps' => 'Agendar demo del producto',
                'created_by' => $user->id,
            ],
            [
                'type' => 'call',
                'subject' => 'Llamada de seguimiento - proyecto municipal',
                'description' => 'Revisión del estado del proyecto de digitalización',
                'date' => now()->subDays(7),
                'duration' => 30,
                'outcome' => 'neutral',
                'contact_id' => $createdContacts[0]->id,
                'organization_id' => $createdOrgs[0]->id,
                'next_steps' => 'Esperar aprobación de presupuesto',
                'created_by' => $user->id,
            ],
            [
                'type' => 'meeting',
                'subject' => 'Demo del sistema CRM',
                'description' => 'Presentación de las funcionalidades principales del CRM',
                'date' => now()->subDays(10),
                'duration' => 90,
                'outcome' => 'positive',
                'contact_id' => $createdContacts[3]->id,
                'organization_id' => $createdOrgs[2]->id,
                'next_steps' => 'Preparar cotización formal',
                'created_by' => $user->id,
            ],
            [
                'type' => 'event',
                'subject' => 'Feria de Tecnología 2026',
                'description' => 'Participación en stand de la feria',
                'date' => now()->subDays(15),
                'duration' => 480,
                'outcome' => 'positive',
                'contact_id' => $createdContacts[2]->id,
                'organization_id' => $createdOrgs[2]->id,
                'created_by' => $user->id,
            ],
            [
                'type' => 'call',
                'subject' => 'Consulta sobre servicios',
                'description' => 'Primera llamada con contacto nuevo',
                'date' => now()->subDays(2),
                'duration' => 20,
                'outcome' => 'neutral',
                'contact_id' => $createdContacts[5]->id,
                'next_steps' => 'Enviar información detallada por email',
                'created_by' => $user->id,
            ],
            // Upcoming interactions
            [
                'type' => 'meeting',
                'subject' => 'Reunión trimestral - Avances del proyecto',
                'description' => 'Revisión de objetivos y resultados del trimestre',
                'date' => now()->addDays(3),
                'duration' => 120,
                'contact_id' => $createdContacts[7]->id,
                'organization_id' => $createdOrgs[0]->id,
                'created_by' => $user->id,
            ],
            [
                'type' => 'call',
                'subject' => 'Llamada de seguimiento - propuesta',
                'description' => 'Verificar recepción de propuesta y resolver dudas',
                'date' => now()->addDays(1),
                'duration' => 30,
                'contact_id' => $createdContacts[1]->id,
                'organization_id' => $createdOrgs[1]->id,
                'created_by' => $user->id,
            ],
            [
                'type' => 'meeting',
                'subject' => 'Workshop: Implementación de CRM',
                'description' => 'Capacitación inicial para el equipo',
                'date' => now()->addDays(7),
                'duration' => 180,
                'contact_id' => $createdContacts[2]->id,
                'organization_id' => $createdOrgs[2]->id,
                'created_by' => $user->id,
            ],
            [
                'type' => 'email',
                'subject' => 'Envío de reportes mensuales',
                'description' => 'Compartir dashboard de métricas del mes',
                'date' => now()->addDays(5),
                'contact_id' => $createdContacts[4]->id,
                'organization_id' => $createdOrgs[3]->id,
                'created_by' => $user->id,
            ],
        ];

        foreach ($interactions as $interactionData) {
            Interaction::create($interactionData);
        }

        $this->command->info('✅ Database seeded successfully!');
        $this->command->info('📊 Created:');
        $this->command->info('   - 1 User (test@example.com / password)');
        $this->command->info('   - ' . count($organizations) . ' Organizations');
        $this->command->info('   - ' . count($contacts) . ' Contacts');
        $this->command->info('   - ' . count($interactions) . ' Interactions');
    }
}

