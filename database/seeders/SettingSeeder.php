<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
                Setting::firstOrCreate([
            'key' => 'smtp_host',
            'value' => 'smtp.hostinger.com',
            'label' => 'SMTP Host',
            'type' => 'string',
        ]);
        Setting::firstOrCreate([
            'key' => 'smtp_port',
            'value' => '465',
            'label' => 'SMTP Port',
            'type' => 'integer',
        ]);
        Setting::firstOrCreate([
            'key' => 'smtp_username',
            'value' => 'noreply@magiteck.online',
            'label' => 'SMTP Username',
            'type' => 'string',
        ]);
        Setting::firstOrCreate([
            'key' => 'smtp_password',
            'value' => 'Mysupport@@2024',
            'label' => 'SMTP Password',
            'type' => 'password',
        ]);
        // Parametr email from
        Setting::firstOrCreate([
            'key' => 'email_from',
            'value' => 'noreply@magiteck.online',
            'label' => 'Email From',
            'type' => 'string',
        ]);

        // Parametre email from name
        Setting::firstOrCreate([
            'key' => 'email_from_name',
            'value' => 'Ars',
            'label' => 'Email From Name',
            'type' => 'string',
        ]);

        // Parametre email
        Setting::firstOrCreate([
            'key' => 'admin_email',
            'value' => 's0qVZ@example.com',
            'label' => 'Admin Email',
            'type' => 'string',
        ]);

        // Parametre email contact
        Setting::firstOrCreate([
            'key' => 'contact_email',
            'value' => 's0qVZ@example.com',
            'label' => 'Contact Email',
            'type' => 'string',
        ]);

        // Parametre site
        Setting::firstOrCreate([
            'key' => 'site_name',
            'value' => 'Ars',
            'label' => 'Site Name',
            'type' => 'string',
        ]);

        Setting::firstOrCreate([
            'key' => 'site_email',
            'value' => 'ars@presidence.bj',
            'label' => 'Site E-mail',
            'type' => 'string',
        ]);

        Setting::firstOrCreate([
            'key' => 'site_telephone',
            'value' => '(229) 01 91 16 37 37',
            'label' => 'Site Téléphone',
            'type' => 'string',
        ]);

        Setting::firstOrCreate([
            'key' => 'localisation_name',
            'value' => '',
            'label' => 'Localisation',
            'type' => 'string',
        ]);

        Setting::firstOrCreate([
            'key' => 'localisation_iframe_src',
            'value' => '',
            'label' => 'Localisation Iframe',
            'type' => 'string',
        ]);

        Setting::firstOrCreate([
            'key' => 'site_adresse',
            'value' => 'Guinkomey, Cotonou, Littoral BJ',
            'label' => 'Site Adresse',
            'type' => 'string',
        ]);

        Setting::firstOrCreate([
            'key' => 'site_map_link',
            'value' => '',
            'label' => 'Site Map Link',
            'type' => 'string',
        ]);

        Setting::firstOrCreate([
            'key' => 'site_description',
            'value' => 'Ars',
            'label' => 'Site Description',
            'type' => 'string',
        ]);

        Setting::firstOrCreate([
            'key' => 'site_keywords',
            'value' => 'Ars',
            'label' => 'Site Keywords',
            'type' => 'string',
        ]);

        Setting::firstOrCreate([
            'key' => 'site_author',
            'value' => 'Ars',
            'label' => 'Site Author',
            'type' => 'string',
        ]);

        Setting::firstOrCreate([
            'key' => 'site_logo',
            'value' => 'https://via.placeholder.com/150',
            'label' => 'Site Logo',
            'type' => 'string',
        ]);

        Setting::firstOrCreate([
            'key' => 'site_favicon',
            'value' => 'https://via.placeholder.com/150',
            'label' => 'Site Favicon',
            'type' => 'string',
        ]);

        Setting::firstOrCreate([
            'key' => 'site_whatsapp',
            'value' => '',
            'label' => 'Site Favicon',
            'type' => 'string',
        ]);

        Setting::firstOrCreate([
            'key' => 'site_instagram',
            'value' => '',
            'label' => 'Site Favicon',
            'type' => 'string',
        ]);

        Setting::firstOrCreate([
            'key' => 'site_linkedin',
            'value' => '',
            'label' => 'Site Favicon',
            'type' => 'string',
        ]);

        Setting::firstOrCreate([
            'key' => 'site_x',
            'value' => '',
            'label' => 'Site Favicon',
            'type' => 'string',
        ]);

        Setting::firstOrCreate([
            'key' => 'site_youtube',
            'value' => '',
            'label' => 'Site Favicon',
            'type' => 'string',
        ]);

        Setting::firstOrCreate([
            'key' => 'site_facebook',
            'value' => '',
            'label' => 'Site Favicon',
            'type' => 'string',
        ]);

        // parametre maintenance
        Setting::firstOrCreate([
            'key' => 'site_maintenance',
            'value' => '1',
            'label' => 'Site Maintenance',
            'type' => 'boolean',
        ]);

        // parametre unfollowed
        Setting::firstOrCreate([
            'key' => 'unfollowed_link',
            'value' => '',
            'label' => 'Lien de désabonnement',
            'type' => 'string',
        ]);

        // parametre otp
        Setting::firstOrCreate([
            'key' => 'otp_channel',
            'value' => 'sms',
            'label' => 'Canal OTP (sms/email)',
            'type' => 'string',
        ]);

        // parametre otp
        Setting::firstOrCreate([
            'key' => 'sms_url',
            'value' => 'https://api.afriksms.com/api/web/web_v1/outbounds/send',
            'label' => 'URL API SMS',
            'type' => 'string',
        ]);

        // parametre otp
        Setting::firstOrCreate([
            'key' => 'sms_username',
            'value' => '26277048',
            'label' => 'Identifiant API SMS',
            'type' => 'string',
        ]);

        // parametre otp
        Setting::firstOrCreate([
            'key' => 'sms_password',
            'value' => 'cAytEKDuNP1Da7LpP5RJ0M-AeESrFeBa',
            'label' => 'Mot de passe API SMS',
            'type' => 'password',
        ]);

        // parametre otp
        Setting::firstOrCreate([
            'key' => 'sms_from',
            'value' => 'ARS',
            'label' => 'Expéditeur API SMS',
            'type' => 'string',
        ]);

        // parametre copyright
        Setting::firstOrCreate([
            'key' => 'copyright',
            'value' => 'Copyright © 2022 Ars. Tous droits réservés.',
            'label' => 'Copyright',
            'type' => 'string',
        ]);

        // parametre session timeout
        Setting::firstOrCreate([
            'key' => 'session_timeout',
            'value' => '10',
            'label' => 'Session Timeout',
            'type' => 'integer',
        ]);

        // parametre recaptcha
        Setting::firstOrCreate([
            'key' => 'login_recaptcha_active',
            'value' => '0',
            'label' => 'ReCaptcha',
            'type' => 'boolean',
        ]);

        Setting::firstOrCreate([
            'key' => 'recaptcha_key',
            'value' => '6LdDjvkpAAAAALQ_MzjdQaJozSvvSJl6YwNrEqGX',
            'label' => 'ReCaptcha Key',
            'type' => 'password',
        ]);

        Setting::firstOrCreate([
            'key' => 'recaptcha_secret',
            'value' => '6LdDjvkpAAAAAKgt1u5Lbg0jTKVvaOYMowmwSnRk',
            'label' => 'ReCaptcha Secret',
            'type' => 'password',
        ]);

        // parametre tentive de connexion
        Setting::firstOrCreate([
            'key' => 'login_attempts',
            'value' => '3',
            'label' => 'Login Attempt',
            'type' => 'integer',
        ]);

        // parametre duree de tentaive de connexion en minute
        Setting::firstOrCreate([
            'key' => 'login_attempt_duration',
            'value' => '60',
            'label' => 'Login Attempt Duration',
            'type' => 'integer',
        ]);

        // parametre reinitialisation mot de passe
        Setting::firstOrCreate([
            'key' => 'password_reset_expire',
            'value' => '60',
            'label' => 'Password Reset Expire',
            'type' => 'integer',
        ]);

        Setting::firstOrCreate([
            'key' => 'password_reset_throttle',
            'value' => '60',
            'label' => 'Password Reset Throttle',
            'type' => 'integer',
        ]);

        Setting::firstOrCreate([
            'key' => 'migrated',
            'value' => '1',
            'label' => 'migrated',
            'type' => 'boolean',
        ]);

        // parametre contact mail
        Setting::firstOrCreate([
            'key' => 'contact_mail',
            'value' => 'W6LlH@example.com',
            'label' => 'Contact Mail',
            'type' => 'string',
        ]);

        // parametre documentation base path
        Setting::firstOrCreate([
            'key' => 'documentation_base_path',
            'value' => '../../aacom_storage/documentation',
            'label' => 'Documentation Base Path',
            'type' => 'string',
        ]);

        Setting::firstOrCreate([
            'key' => 'contact_mail',
            'value' => 'W6LlH@example.com',
            'label' => 'Contact Mail',
            'type' => 'string',
        ]);
        
        Setting::firstOrCreate([
            'key' => 'article_slider_limit',
            'value' => '5',
            'label' => 'Nombre d\'articles dans le slider',
            'type' => 'integer',
        ]);
    }
}
