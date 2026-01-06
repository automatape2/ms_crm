<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Organization;
use App\Models\Contact;
use App\Models\Interaction;
use App\Models\Segment;
use App\Models\Campaign;
use Illuminate\Support\Facades\Hash;

class CRMSeeder extends Seeder
{
    public function run(): void
    {
        // Create admin user
        $admin = User::firstOrCreate(
            ['email' => 'admin@crm.test'],
            [
                'name' => 'Admin CRM',
                'password' => Hash::make('password'),
            ]
        );

        // Create organizations
        $organizations = [
            [
                'name' => 'Municipio de Ejemplo',
                'type' => 'gobierno',
                'industry' => 'Administración Pública',
                'email' => 'contacto@municipio.gob',
                'phone' => '+1234567890',
                'address' => [
                    'street' => 'Av. Principal 123',
                    'city' => 'Ciudad Ejemplo',
                    'state' => 'Estado',
                    'country' => 'País',
                    'zip' => '12345',
                ],
                'tags' => ['gobierno-local', 'prioridad-alta'],
                'status' => 'active',
                'created_by' => $admin->id,
            ],
            [
                'name' => 'Fundación Esperanza',
                'type' => 'ong',
                'industry' => 'Desarrollo Social',
                'email' => 'info@fundacionesperanza.org',
                'phone' => '+1234567891',
                'website' => 'https://fundacionesperanza.org',
                'address' => [
                    'street' => 'Calle Social 456',
                    'city' => 'Ciudad Solidaria',
                    'state' => 'Estado',
                    'country' => 'País',
                    'zip' => '12346',
                ],
                'tags' => ['ong', 'educacion', 'comunidad'],
                'status' => 'active',
                'created_by' => $admin->id,
            ],
            [
                'name' => 'Tech Innovations SA',
                'type' => 'empresa',
                'industry' => 'Tecnología',
                'email' => 'contacto@techinnovations.com',
                'phone' => '+1234567892',
                'website' => 'https://techinnovations.com',
                'address' => [
                    'street' => 'Parque Tecnológico 789',
                    'city' => 'Ciudad Tech',
                    'state' => 'Estado',
                    'country' => 'País',
                    'zip' => '12347',
                ],
                'tags' => ['empresa', 'tecnologia', 'innovacion'],
                'status' => 'active',
                'created_by' => $admin->id,
            ],
            [
                'name' => 'Comunidad Los Pinos',
                'type' => 'comunidad',
                'industry' => 'Desarrollo Comunitario',
                'email' => 'junta@lospinos.org',
                'phone' => '+1234567893',
                'address' => [
                    'street' => 'Barrio Los Pinos',
                    'city' => 'Ciudad Comunal',
                    'state' => 'Estado',
                    'country' => 'País',
                    'zip' => '12348',
                ],
                'tags' => ['comunidad', 'vecinos', 'organizacion-base'],
                'status' => 'active',
                'created_by' => $admin->id,
            ],
        ];

        $orgModels = [];
        foreach ($organizations as $orgData) {
            $orgModels[] = Organization::create($orgData);
        }

        // Create contacts
        $contacts = [
            [
                'first_name' => 'María',
                'last_name' => 'González',
                'email' => 'maria.gonzalez@municipio.gob',
                'phone' => '+1234567800',
                'position' => 'Directora de Comunicaciones',
                'organization_id' => $orgModels[0]->id,
                'tags' => ['stakeholder-clave', 'comunicaciones'],
                'status' => 'active',
                'source' => 'manual',
                'created_by' => $admin->id,
            ],
            [
                'first_name' => 'Carlos',
                'last_name' => 'Rodríguez',
                'email' => 'carlos.rodriguez@municipio.gob',
                'phone' => '+1234567801',
                'position' => 'Alcalde',
                'organization_id' => $orgModels[0]->id,
                'tags' => ['stakeholder-clave', 'autoridad', 'decision-maker'],
                'status' => 'active',
                'source' => 'manual',
                'created_by' => $admin->id,
            ],
            [
                'first_name' => 'Ana',
                'last_name' => 'Martínez',
                'email' => 'ana@fundacionesperanza.org',
                'phone' => '+1234567802',
                'position' => 'Directora Ejecutiva',
                'organization_id' => $orgModels[1]->id,
                'tags' => ['ong', 'educacion'],
                'status' => 'active',
                'source' => 'manual',
                'created_by' => $admin->id,
            ],
            [
                'first_name' => 'Pedro',
                'last_name' => 'López',
                'email' => 'pedro.lopez@techinnovations.com',
                'phone' => '+1234567803',
                'position' => 'CEO',
                'organization_id' => $orgModels[2]->id,
                'tags' => ['empresa', 'tecnologia', 'decision-maker'],
                'status' => 'active',
                'source' => 'manual',
                'created_by' => $admin->id,
            ],
            [
                'first_name' => 'Laura',
                'last_name' => 'Fernández',
                'email' => 'laura.fernandez@techinnovations.com',
                'phone' => '+1234567804',
                'position' => 'Gerente de Proyectos',
                'organization_id' => $orgModels[2]->id,
                'tags' => ['empresa', 'proyectos'],
                'status' => 'active',
                'source' => 'manual',
                'created_by' => $admin->id,
            ],
            [
                'first_name' => 'Roberto',
                'last_name' => 'Sánchez',
                'email' => 'roberto@lospinos.org',
                'phone' => '+1234567805',
                'position' => 'Presidente Junta de Vecinos',
                'organization_id' => $orgModels[3]->id,
                'tags' => ['comunidad', 'lider-comunitario'],
                'status' => 'active',
                'source' => 'manual',
                'created_by' => $admin->id,
            ],
        ];

        $contactModels = [];
        foreach ($contacts as $contactData) {
            $contactModels[] = Contact::create($contactData);
        }

        // Create interactions
        $interactions = [
            [
                'contact_id' => $contactModels[0]->id,
                'organization_id' => $orgModels[0]->id,
                'type' => 'meeting',
                'subject' => 'Reunión inicial - Presentación del proyecto',
                'description' => 'Primera reunión para presentar nuestro proyecto de relacionamiento institucional. La directora mostró gran interés.',
                'date' => now()->subDays(15),
                'duration' => 60,
                'outcome' => 'positive',
                'next_steps' => 'Enviar propuesta detallada la próxima semana',
                'created_by' => $admin->id,
            ],
            [
                'contact_id' => $contactModels[1]->id,
                'organization_id' => $orgModels[0]->id,
                'type' => 'call',
                'subject' => 'Llamada de seguimiento con el Alcalde',
                'description' => 'Seguimiento sobre la propuesta enviada. El alcalde solicita más información sobre el presupuesto.',
                'date' => now()->subDays(8),
                'duration' => 20,
                'outcome' => 'neutral',
                'next_steps' => 'Preparar documento con desglose de presupuesto',
                'created_by' => $admin->id,
            ],
            [
                'contact_id' => $contactModels[2]->id,
                'organization_id' => $orgModels[1]->id,
                'type' => 'email',
                'subject' => 'Email de contacto inicial',
                'description' => 'Envío de información sobre posibles colaboraciones en programas educativos.',
                'date' => now()->subDays(20),
                'duration' => null,
                'outcome' => 'positive',
                'next_steps' => 'Agendar reunión para la próxima semana',
                'created_by' => $admin->id,
            ],
            [
                'contact_id' => $contactModels[3]->id,
                'organization_id' => $orgModels[2]->id,
                'type' => 'meeting',
                'subject' => 'Presentación de alianza estratégica',
                'description' => 'Reunión con el CEO para explorar oportunidades de colaboración tecnológica.',
                'date' => now()->subDays(5),
                'duration' => 90,
                'outcome' => 'positive',
                'next_steps' => 'Elaborar acuerdo marco de colaboración',
                'created_by' => $admin->id,
            ],
            [
                'contact_id' => $contactModels[5]->id,
                'organization_id' => $orgModels[3]->id,
                'type' => 'event',
                'subject' => 'Asamblea comunitaria',
                'description' => 'Participación en asamblea de vecinos para presentar iniciativas de desarrollo social.',
                'date' => now()->subDays(3),
                'duration' => 120,
                'outcome' => 'positive',
                'next_steps' => 'Coordinar talleres comunitarios para el próximo mes',
                'created_by' => $admin->id,
            ],
            [
                'contact_id' => $contactModels[0]->id,
                'organization_id' => $orgModels[0]->id,
                'type' => 'note',
                'subject' => 'Nota: Cumpleaños de la Directora',
                'description' => 'Recordatorio: María cumple años el 15 de febrero. Considerar enviar felicitación.',
                'date' => now(),
                'duration' => null,
                'outcome' => null,
                'next_steps' => null,
                'created_by' => $admin->id,
            ],
        ];

        foreach ($interactions as $interactionData) {
            Interaction::create($interactionData);
        }

        // Create segments
        $segments = [
            [
                'name' => 'Stakeholders Gubernamentales',
                'description' => 'Contactos de entidades gubernamentales y autoridades',
                'conditions' => [
                    'organization_type' => 'gobierno',
                ],
                'contact_count' => 2,
                'is_dynamic' => true,
                'created_by' => $admin->id,
            ],
            [
                'name' => 'Decision Makers',
                'description' => 'Personas con poder de decisión en sus organizaciones',
                'conditions' => [
                    'tags' => ['decision-maker'],
                ],
                'contact_count' => 2,
                'is_dynamic' => true,
                'created_by' => $admin->id,
            ],
            [
                'name' => 'Contactos Recientes',
                'description' => 'Contactos con interacciones en los últimos 30 días',
                'conditions' => [
                    'last_interaction' => 30,
                ],
                'contact_count' => 4,
                'is_dynamic' => true,
                'created_by' => $admin->id,
            ],
        ];

        $segmentModels = [];
        foreach ($segments as $segmentData) {
            $segmentModels[] = Segment::create($segmentData);
        }

        // Create campaigns
        $campaigns = [
            [
                'name' => 'Newsletter Mensual - Enero 2026',
                'description' => 'Newsletter mensual con novedades y actualizaciones del proyecto',
                'type' => 'email',
                'status' => 'completed',
                'segment_id' => null,
                'scheduled_at' => now()->subDays(10),
                'started_at' => now()->subDays(10),
                'completed_at' => now()->subDays(9),
                'stats' => [
                    'sent' => 100,
                    'opened' => 75,
                    'clicked' => 30,
                    'replied' => 5,
                ],
                'created_by' => $admin->id,
            ],
            [
                'name' => 'Invitación Evento de Lanzamiento',
                'description' => 'Invitación al evento de lanzamiento del nuevo programa',
                'type' => 'event',
                'status' => 'scheduled',
                'segment_id' => $segmentModels[1]->id,
                'scheduled_at' => now()->addDays(7),
                'started_at' => null,
                'completed_at' => null,
                'stats' => null,
                'created_by' => $admin->id,
            ],
            [
                'name' => 'Encuesta de Satisfacción Q1',
                'description' => 'Encuesta trimestral de satisfacción y feedback',
                'type' => 'survey',
                'status' => 'draft',
                'segment_id' => $segmentModels[2]->id,
                'scheduled_at' => null,
                'started_at' => null,
                'completed_at' => null,
                'stats' => null,
                'created_by' => $admin->id,
            ],
        ];

        foreach ($campaigns as $campaignData) {
            Campaign::create($campaignData);
        }

        $this->command->info('✅ CRM data seeded successfully!');
        $this->command->info('📊 Created:');
        $this->command->info("   - 1 Admin user (email: admin@crm.test, password: password)");
        $this->command->info("   - " . count($organizations) . " Organizations");
        $this->command->info("   - " . count($contacts) . " Contacts");
        $this->command->info("   - " . count($interactions) . " Interactions");
        $this->command->info("   - " . count($segments) . " Segments");
        $this->command->info("   - " . count($campaigns) . " Campaigns");
    }
}
