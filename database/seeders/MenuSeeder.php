<?php

namespace Database\Seeders;

use App\Models\Menu;
use App\Models\MenuEmplacement;
use Illuminate\Database\Seeder;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Menu Emplacement
        $menu_emplacement = MenuEmplacement::create([
            'label' => 'Admin Sidebar',
            'code_menu' => 'admin-sidebar',
        ]);

        $dashboard = Menu::create([
            'label' => 'Dashboard',
            'primary_title' => 'Dashboard',
            'secondary_title' => 'Dashboard',
            'url' => parse_url(route('dashboard'))['path'],
            'icon' => 'uil-home-alt',
            'permission' => '',
            'position' => 0,
            'new_tab' => false,
            'menu_emplacement_id' => $menu_emplacement->id,
            'parent_id' => null,
        ]);

        // Roles
        $role = Menu::create([
            'label' => 'Roles',
            'primary_title' => 'Roles',
            'secondary_title' => 'Roles',
            'url' => parse_url(route('roles.index'))['path'],
            'icon' => 'uil-boombox',
            'permission' => 'list roles',
            'position' => 1,
            'new_tab' => false,
            'menu_emplacement_id' => $menu_emplacement->id,
            'parent_id' => null,
        ]);

        $role_list = Menu::create([
            'label' => 'Liste des roles',
            'primary_title' => 'Roles',
            'secondary_title' => 'Roles',
            'url' => parse_url(route('roles.index'))['path'],
            'icon' => 'uil-boombox',
            'permission' => 'list roles',
            'position' => 1,
            'new_tab' => false,
            'menu_emplacement_id' => $menu_emplacement->id,
            'parent_id' => $role->id,
        ]);

        $role_create = Menu::create([
            'label' => 'Ajouter un role',
            'primary_title' => 'Roles',
            'secondary_title' => 'Roles',
            'url' => parse_url(route('roles.create'))['path'],
            'icon' => 'uil-boombox',
            'permission' => 'create roles',
            'position' => 2,
            'new_tab' => false,
            'menu_emplacement_id' => $menu_emplacement->id,
            'parent_id' => $role->id,
        ]);

        // Permissions
        $permission = Menu::create([
            'label' => 'Permissions',
            'primary_title' => 'Permissions',
            'secondary_title' => 'Permissions',
            'url' => parse_url(route('roles.permissions.index'))['path'],
            'icon' => 'uil-shield-check',
            'permission' => 'list permissions',
            'position' => 2,
            'new_tab' => false,
            'menu_emplacement_id' => $menu_emplacement->id,
            'parent_id' => null,
        ]);

        $permission_list = Menu::create([
            'label' => 'Liste des permissions',
            'primary_title' => 'Permissions',
            'secondary_title' => 'Permissions',
            'url' => parse_url(route('roles.permissions.index'))['path'],
            'icon' => 'uil-boombox',
            'permission' => 'list permissions',
            'position' => 1,
            'new_tab' => false,
            'menu_emplacement_id' => $menu_emplacement->id,
            'parent_id' => $permission->id,
        ]);


        // Utilisateurs
        $user = Menu::create([
            'label' => 'Utilisateurs',
            'primary_title' => 'Utilisateurs',
            'secondary_title' => 'Utilisateurs',
            'url' => parse_url(route('users.index'))['path'],
            'icon' => 'uil-user',
            'permission' => 'list users',
            'position' => 3,
            'new_tab' => false,
            'menu_emplacement_id' => $menu_emplacement->id,
            'parent_id' => null,
        ]);

        $user_list = Menu::create([
            'label' => 'Liste des utilisateurs',
            'primary_title' => 'Utilisateurs',
            'secondary_title' => 'Utilisateurs',
            'url' => parse_url(route('users.index'))['path'],
            'icon' => 'uil-user',
            'permission' => 'list users',
            'position' => 1,
            'new_tab' => false,
            'menu_emplacement_id' => $menu_emplacement->id,
            'parent_id' => $user->id,
        ]);

        $user_create = Menu::create([
            'label' => 'Ajouter un utilisateur',
            'primary_title' => 'Utilisateurs',
            'secondary_title' => 'Utilisateurs',
            'url' => parse_url(route('users.create'))['path'],
            'icon' => 'uil-user',
            'permission' => 'create users',
            'position' => 2,
            'new_tab' => false,
            'menu_emplacement_id' => $menu_emplacement->id,
            'parent_id' => $user->id,
        ]);

        // Categories
        $category = Menu::create([
            'label' => 'Catégories',
            'primary_title' => 'Catégories',
            'secondary_title' => 'Catégories',
            'url' => parse_url(route('categories.index'))['path'],
            'icon' => 'uil-tag-alt',
            'permission' => 'list categories',
            'position' => 4,
            'new_tab' => false,
            'menu_emplacement_id' => $menu_emplacement->id,
            'parent_id' => null,
        ]);

        $category_list = Menu::create([
            'label' => 'Liste des catégories',
            'primary_title' => 'Catégories',
            'secondary_title' => 'Catégories',
            'url' => parse_url(route('categories.index'))['path'],
            'icon' => 'uil-tag-alt',
            'permission' => 'list categories',
            'position' => 1,
            'new_tab' => false,
            'menu_emplacement_id' => $menu_emplacement->id,
            'parent_id' => $category->id,
        ]);

        $category_create = Menu::create([
            'label' => 'Ajouter une catégorie',
            'primary_title' => 'Catégories',
            'secondary_title' => 'Catégories',
            'url' => parse_url(route('categories.create'))['path'],
            'icon' => 'uil-tag-alt',
            'permission' => 'create categories',
            'position' => 2,
            'new_tab' => false,
            'menu_emplacement_id' => $menu_emplacement->id,
            'parent_id' => $category->id,
        ]);

        // Articles
        $article = Menu::create([
            'label' => 'Articles',
            'primary_title' => 'Articles',
            'secondary_title' => 'Articles',
            'url' => parse_url(route('articles.index'))['path'],
            'icon' => 'uil-newspaper',
            'permission' => 'list articles',
            'position' => 5,
            'new_tab' => false,
            'menu_emplacement_id' => $menu_emplacement->id,
            'parent_id' => null,
        ]);

        $article_list = Menu::create([
            'label' => 'Liste des articles',
            'primary_title' => 'Articles',
            'secondary_title' => 'Articles',
            'url' => parse_url(route('articles.index'))['path'],
            'icon' => 'uil-newspaper',
            'permission' => 'list articles',
            'position' => 1,
            'new_tab' => false,
            'menu_emplacement_id' => $menu_emplacement->id,
            'parent_id' => $article->id,
        ]);

        $article_create = Menu::create([
            'label' => 'Ajouter un article',
            'primary_title' => 'Articles',
            'secondary_title' => 'Articles',
            'url' => parse_url(route('articles.create'))['path'],
            'icon' => 'uil-newspaper',
            'permission' => 'create articles',
            'position' => 2,
            'new_tab' => false,
            'menu_emplacement_id' => $menu_emplacement->id,
            'parent_id' => $article->id,
        ]);

        $article_corbeille = Menu::create([
            'label' => 'Corbeille',
            'primary_title' => 'Corbeille',
            'secondary_title' => 'Corbeille',
            'url' => parse_url(route('articles.corbeille'))['path'],
            'icon' => 'uil-newspaper',
            'permission' => 'list corbeille',
            'position' => 3,
            'new_tab' => false,
            'menu_emplacement_id' => $menu_emplacement->id,
            'parent_id' => $article->id,
        ]);

        $article_archive = Menu::create([
            'label' => 'Archive',
            'primary_title' => 'Archive',
            'secondary_title' => 'Archive',
            'url' => parse_url(route('articles.archive'))['path'],
            'icon' => 'uil-newspaper',
            'permission' => 'list archive',
            'position' => 4,
            'new_tab' => false,
            'menu_emplacement_id' => $menu_emplacement->id,
            'parent_id' => $article->id,
        ]);

        // Vidéo
        $video = Menu::create([
            'label' => 'Vidéos',
            'primary_title' => 'Vidéos',
            'secondary_title' => 'Vidéos',
            'url' => parse_url(route('videos.index'))['path'],
            'icon' => 'uil-video',
            'permission' => 'list videos',
            'position' => 6,
            'new_tab' => false,
            'menu_emplacement_id' => $menu_emplacement->id,
            'parent_id' => null,
        ]);

        $video_list = Menu::create([
            'label' => 'Liste des videos',
            'primary_title' => 'Videos',
            'secondary_title' => 'Videos',
            'url' => parse_url(route('videos.index'))['path'],
            'icon' => 'uil-video',
            'permission' => 'list videos',
            'position' => 1,
            'new_tab' => false,
            'menu_emplacement_id' => $menu_emplacement->id,
            'parent_id' => $video->id,
        ]);

        $video_create = Menu::create([
            'label' => 'Ajouter une vidéo',
            'primary_title' => 'Videos',
            'secondary_title' => 'Videos',
            'url' => parse_url(route('videos.create'))['path'],
            'icon' => 'uil-video',
            'permission' => 'create videos',
            'position' => 2,
            'new_tab' => false,
            'menu_emplacement_id' => $menu_emplacement->id,
            'parent_id' => $video->id,
        ]);

        // Pages
        $page = Menu::create([
            'label' => 'Pages',
            'primary_title' => 'Pages',
            'secondary_title' => 'Pages',
            'url' => parse_url(route('pages.index'))['path'],
            'icon' => 'uil-file-alt',
            'permission' => 'list pages',
            'position' => 7,
            'new_tab' => false,
            'menu_emplacement_id' => $menu_emplacement->id,
            'parent_id' => null,
        ]);

        $page_list = Menu::create([
            'label' => 'Liste des pages',
            'primary_title' => 'Pages',
            'secondary_title' => 'Pages',
            'url' => parse_url(route('pages.index'))['path'],
            'icon' => 'uil-file-alt',
            'permission' => 'list pages',
            'position' => 1,
            'new_tab' => false,
            'menu_emplacement_id' => $menu_emplacement->id,
            'parent_id' => $page->id,
        ]);

        $page_create = Menu::create([
            'label' => 'Ajouter une page',
            'primary_title' => 'Pages',
            'secondary_title' => 'Pages',
            'url' => parse_url(route('pages.create'))['path'],
            'icon' => 'uil-file-alt',
            'permission' => 'create pages',
            'position' => 2,
            'new_tab' => false,
            'menu_emplacement_id' => $menu_emplacement->id,
            'parent_id' => $page->id,
        ]);

        // Medias
        $media = Menu::create([
            'label' => 'Médias',
            'primary_title' => 'Médias',
            'secondary_title' => 'Médias',
            'url' => parse_url(route('medias.index'))['path'],
            'icon' => 'uil-images',
            'permission' => 'list medias',
            'position' => 8,
            'new_tab' => false,
            'menu_emplacement_id' => $menu_emplacement->id,
            'parent_id' => null,
        ]);

        $media_list = Menu::create([
            'label' => 'Liste des médias',
            'primary_title' => 'Médias',
            'secondary_title' => 'Médias',
            'url' => parse_url(route('medias.index'))['path'],
            'icon' => 'uil-images',
            'permission' => 'list medias',
            'position' => 1,
            'new_tab' => false,
            'menu_emplacement_id' => $menu_emplacement->id,
            'parent_id' => $media->id,
        ]);

        // Menus
        $menu = Menu::create([
            'label' => 'Menus',
            'primary_title' => 'Menus',
            'secondary_title' => 'Menus',
            'url' => parse_url(route('menus.index'))['path'],
            'icon' => 'uil-list-ul',
            'permission' => 'list menus',
            'position' => 9,
            'new_tab' => false,
            'menu_emplacement_id' => $menu_emplacement->id,
            'parent_id' => null,
        ]);

        $menu_list = Menu::create([
            'label' => 'Liste des menus',
            'primary_title' => 'Menus',
            'secondary_title' => 'Menus',
            'url' => parse_url(route('menus.index'))['path'],
            'icon' => 'uil-list-ul',
            'permission' => 'list menus',
            'position' => 1,
            'new_tab' => false,
            'menu_emplacement_id' => $menu_emplacement->id,
            'parent_id' => $menu->id,
        ]);
        $menu_create = Menu::create([
            'label' => 'Ajouter un menu',
            'primary_title' => 'Menus',
            'secondary_title' => 'Menus',
            'url' => parse_url(route('menus.create'))['path'],
            'icon' => 'uil-list-ul',
            'permission' => 'create menus',
            'position' => 2,
            'new_tab' => false,
            'menu_emplacement_id' => $menu_emplacement->id,
            'parent_id' => $menu->id,
        ]);

        // Emplacements menus
        $menu_emplacement_ = Menu::create([
            'label' => 'Emplacements menus',
            'primary_title' => 'Emplacements menus',
            'secondary_title' => 'Emplacements menus',
            'url' => parse_url(route('menu-emplacements.index'))['path'],
            'icon' => 'uil-list-ul',
            'permission' => 'list menus',
            'position' => 3,
            'new_tab' => false,
            'menu_emplacement_id' => $menu_emplacement->id,
            'parent_id' => $menu->id,
        ]);

        // Parametres
        $parametres = Menu::create([
            'label' => 'Paramètres',
            'primary_title' => 'Paramètres',
            'secondary_title' => 'Paramètres',
            'url' => parse_url(route('settings.index'))['path'],
            'icon' => 'uil-sliders-v',
            'permission' => 'list settings',
            'position' => 10,
            'new_tab' => false,
            'menu_emplacement_id' => $menu_emplacement->id,
            'parent_id' => null,
        ]);

        $parametres_list = Menu::create([
            'label' => 'Liste des paramètres',
            'primary_title' => 'Paramètres',
            'secondary_title' => 'Paramètres',
            'url' => parse_url(route('settings.index'))['path'],
            'icon' => 'uil-setting',
            'permission' => 'list settings',
            'position' => 1,
            'new_tab' => false,
            'menu_emplacement_id' => $menu_emplacement->id,
            'parent_id' => $parametres->id,
        ]);

        $parametres_create = Menu::create([
            'label' => 'Ajouter un paramètre',
            'primary_title' => 'Paramètres',
            'secondary_title' => 'Paramètres',
            'url' => parse_url(route('settings.create'))['path'],
            'icon' => 'uil-setting',
            'permission' => 'create settings',
            'position' => 2,
            'new_tab' => false,
            'menu_emplacement_id' => $menu_emplacement->id,
            'parent_id' => $parametres->id,
        ]);

        // Faqs
        $faqs = Menu::create([
            'label' => 'FAQs',
            'primary_title' => 'FAQs',
            'secondary_title' => 'FAQs',
            'url' => parse_url(route('faqs.index'))['path'],
            'icon' => 'uil-question-circle',
            'permission' => 'list faqs',
            'position' => 11,
            'new_tab' => false,
            'menu_emplacement_id' => $menu_emplacement->id,
            'parent_id' => null,
        ]);

        $faqs_list = Menu::create([
            'label' => 'Liste des FAQs',
            'primary_title' => 'FAQs',
            'secondary_title' => 'FAQs',
            'url' => parse_url(route('faqs.index'))['path'],
            'icon' => 'uil-question-circle',
            'permission' => 'list faqs',
            'position' => 1,
            'new_tab' => false,
            'menu_emplacement_id' => $menu_emplacement->id,
            'parent_id' => $faqs->id,
        ]);

        $faqs_create = Menu::create([
            'label' => 'Ajouter une FAQ',
            'primary_title' => 'FAQs',
            'secondary_title' => 'FAQs',
            'url' => parse_url(route('faqs.create'))['path'],
            'icon' => 'uil-question-circle',
            'permission' => 'create faqs',
            'position' => 2,
            'new_tab' => false,
            'menu_emplacement_id' => $menu_emplacement->id,
            'parent_id' => $faqs->id,
        ]);

        // Equipes
        $teams = Menu::create([
            'label' => 'Membres du Conseil',
            'primary_title' => 'Membres du Conseil',
            'secondary_title' => 'Membres du Conseil',
            'url' => parse_url(route('teams.index'))['path'],
            'icon' => 'uil-users-alt',
            'permission' => 'list teams',
            'position' => 12,
            'new_tab' => false,
            'menu_emplacement_id' => $menu_emplacement->id,
            'parent_id' => null,
        ]);

        $teams_list = Menu::create([
            'label' => 'Liste des membres du conseil',
            'primary_title' => 'Membres du Conseil',
            'secondary_title' => 'Membres du Conseil',
            'url' => parse_url(route('teams.index'))['path'],
            'icon' => '',
            'permission' => 'list teams',
            'position' => 1,
            'new_tab' => false,
            'menu_emplacement_id' => $menu_emplacement->id,
            'parent_id' => $teams->id,
        ]);

        $teams_create = Menu::create([
            'label' => 'Ajouter un membre',
            'primary_title' => 'Membres du Conseil',
            'secondary_title' => 'Membres du Conseil',
            'url' => parse_url(route('teams.create'))['path'],
            'icon' => '',
            'permission' => 'create teams',
            'position' => 2,
            'new_tab' => false,
            'menu_emplacement_id' => $menu_emplacement->id,
            'parent_id' => $teams->id,
        ]);

        //Élections
        $elections = Menu::create([
            'label' => 'Elections',
            'primary_title' => 'Elections',
            'secondary_title' => 'Elections',
            'url' => parse_url(route('elections.index'))['path'],
            'icon' => 'uil-box',
            'permission' => 'list elections',
            'position' => 13,
            'new_tab' => false,
            'menu_emplacement_id' => $menu_emplacement->id,
            'parent_id' => null,
        ]);

        $elections_list = Menu::create([
            'label' => 'Liste des élections',
            'primary_title' => 'Elections',
            'secondary_title' => 'Elections',
            'url' => parse_url(route('elections.index'))['path'],
            'icon' => '',
            'permission' => 'list elections',
            'position' => 1,
            'new_tab' => false,
            'menu_emplacement_id' => $menu_emplacement->id,
            'parent_id' => $elections->id,
        ]);

        $elections_create = Menu::create([
            'label' => 'Ajouter une élection',
            'primary_title' => 'Nouvelle élection',
            'secondary_title' => 'Nouvelle élection',
            'url' => parse_url(route('elections.create'))['path'],
            'icon' => '',
            'permission' => 'create elections',
            'position' => 2,
            'new_tab' => false,
            'menu_emplacement_id' => $menu_emplacement->id,
            'parent_id' => $elections->id,
        ]);

        $resultats_list = Menu::create([
            'label' => 'Liste des résultats',
            'primary_title' => 'Résultats',
            'secondary_title' => 'Résultats',
            'url' => parse_url(route('resultats.index'))['path'],
            'icon' => '',
            'permission' => 'list resultats',
            'position' => 3,
            'new_tab' => false,
            'menu_emplacement_id' => $menu_emplacement->id,
            'parent_id' => $elections->id,
        ]);

        $resultats_create = Menu::create([
            'label' => 'Ajouter un résultat',
            'primary_title' => 'Nouveau résultat',
            'secondary_title' => 'Nouveau résultat',
            'url' => parse_url(route('resultats.create'))['path'],
            'icon' => '',
            'permission' => 'create resultats',
            'position' => 4,
            'new_tab' => false,
            'menu_emplacement_id' => $menu_emplacement->id,
            'parent_id' => $elections->id,
        ]);


        // Evenements
        $events = Menu::create([
            'label' => 'Evènements',
            'primary_title' => 'Evènements',
            'secondary_title' => 'Evènements',
            'url' => parse_url(route('events.index'))['path'],
            'icon' => 'uil-calendar-alt',
            'permission' => 'list events',
            'position' => 14,
            'new_tab' => false,
            'menu_emplacement_id' => $menu_emplacement->id,
            'parent_id' => null,
        ]);

        $events_list = Menu::create([
            'label' => 'Liste des évènements',
            'primary_title' => 'Evènements',
            'secondary_title' => 'Evènements',
            'url' => parse_url(route('events.index'))['path'],
            'icon' => '',
            'permission' => 'list events',
            'position' => 1,
            'new_tab' => false,
            'menu_emplacement_id' => $menu_emplacement->id,
            'parent_id' => $events->id,
        ]);

        $events_create = Menu::create([
            'label' => 'Ajouter un évènement',
            'primary_title' => 'Nouvel évènement',
            'secondary_title' => 'Nouvel évènement',
            'url' => parse_url(route('events.create'))['path'],
            'icon' => '',
            'permission' => 'create events',
            'position' => 2,
            'new_tab' => false,
            'menu_emplacement_id' => $menu_emplacement->id,
            'parent_id' => $events->id,
        ]);

        // Activités
        $activities = Menu::create([
            'label' => 'Activités',
            'primary_title' => 'Activités',
            'secondary_title' => 'Activités',
            'url' => parse_url(route('activities.index'))['path'],
            'icon' => 'uil-box',
            'permission' => 'list activities',
            'position' => 15,
            'new_tab' => false,
            'menu_emplacement_id' => $menu_emplacement->id,
            'parent_id' => null,
        ]);

        $activities_list = Menu::create([
            'label' => 'Liste des activités',
            'primary_title' => 'Activités',
            'secondary_title' => 'Activités',
            'url' => parse_url(route('activities.index'))['path'],
            'icon' => '',
            'permission' => 'list activities',
            'position' => 3,
            'new_tab' => false,
            'menu_emplacement_id' => $menu_emplacement->id,
            'parent_id' => $activities->id,
        ]);

        $activities_create = Menu::create([
            'label' => 'Ajouter une activité',
            'primary_title' => 'Nouvelle activité',
            'secondary_title' => 'Nouvelle activité',
            'url' => parse_url(route('activities.create'))['path'],
            'icon' => '',
            'permission' => 'create activities',
            'position' => 4,
            'new_tab' => false,
            'menu_emplacement_id' => $menu_emplacement->id,
            'parent_id' => $activities->id,
        ]);

        // Documentation
        $documentation = Menu::create([
            'label' => 'Documentations',
            'primary_title' => 'Documentations',
            'secondary_title' => 'Documentations',
            'url' => parse_url(route('documentation.index'))['path'],
            'icon' => 'uil-file-alt',
            'permission' => 'list documentation',
            'position' => 16,
            'new_tab' => false,
            'menu_emplacement_id' => $menu_emplacement->id,
            'parent_id' => null,
        ]);

        $ressources_utiles_list = Menu::create([
            'label' => 'Liste des documentations',
            'primary_title' => 'Liste des documentations',
            'secondary_title' => 'Liste des documentations',
            'url' => parse_url(route('documentation.index'))['path'],
            'icon' => '',
            'permission' => 'list documentation',
            'position' => 1,
            'new_tab' => false,
            'menu_emplacement_id' => $menu_emplacement->id,
            'parent_id' => $documentation->id,
        ]);

        $ressources_utiles_create = Menu::create([
            'label' => 'Ajouter une documentation',
            'primary_title' => 'Nouvelle documentation',
            'secondary_title' => 'Nouvelle documentation',
            'url' => parse_url(route('documentation.create'))['path'],
            'icon' => '',
            'permission' => 'create documentation',
            'position' => 2,
            'new_tab' => false,
            'menu_emplacement_id' => $menu_emplacement->id,
            'parent_id' => $documentation->id,
        ]);

        // Newsletters
        $newsletter = Menu::create([
            'label' => 'Newsletter',
            'primary_title' => 'Newsletter',
            'secondary_title' => 'Newsletter',
            'url' => parse_url(route('newsletters.index'))['path'],
            'icon' => 'uil-newspaper',
            'permission' => 'list followers',
            'position' => 17,
            'new_tab' => false,
            'menu_emplacement_id' => $menu_emplacement->id,
            'parent_id' => null,
        ]);

        $follower_list = Menu::create([
            'label' => 'Liste des abonnés',
            'primary_title' => 'Liste des abonnés',
            'secondary_title' => 'Liste des abonnés',
            'url' => parse_url(route('newsletters.index'))['path'],
            'icon' => '',
            'permission' => 'list followers',
            'position' => 1,
            'new_tab' => false,
            'menu_emplacement_id' => $menu_emplacement->id,
            'parent_id' => $newsletter->id,
        ]);

        $follower_create = Menu::create([
            'label' => 'Ajouter des abonnés',
            'primary_title' => 'Ajouter des abonnés',
            'secondary_title' => 'Ajouter des abonnés',
            'url' => parse_url(route('newsletters.create-follower'))['path'],
            'icon' => '',
            'permission' => 'create followers',
            'position' => 2,
            'new_tab' => false,
            'menu_emplacement_id' => $menu_emplacement->id,
            'parent_id' => $newsletter->id,
        ]);
    }
}
