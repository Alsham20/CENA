<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // create permissions

        Permission::create(['name' => 'list audits']);
        Permission::create(['name' => 'view audits']);

        Permission::create(['name' => 'create articles']);
        Permission::create(['name' => 'view articles']);
        Permission::create(['name' => 'list articles']);
        Permission::create(['name' => 'edit articles']);
        Permission::create(['name' => 'delete articles']);
        Permission::create(['name' => 'delete corbeille']);
        Permission::create(['name' => 'restore corbeille']);
        Permission::create(['name' => 'list corbeille']);
        Permission::create(['name' => 'list archive']);
        Permission::create(['name' => 'publish articles']);
        Permission::create(['name' => 'unpublish articles']);
        Permission::create(['name' => 'unarchive articles']);
        Permission::create(['name' => 'archive articles']);

        Permission::create(['name' => 'create videos']);
        Permission::create(['name' => 'view videos']);
        Permission::create(['name' => 'list videos']);
        Permission::create(['name' => 'edit videos']);
        Permission::create(['name' => 'delete videos']);
        Permission::create(['name' => 'publish videos']);
        Permission::create(['name' => 'unpublish videos']);

        Permission::create(['name' => 'create pages']);
        Permission::create(['name' => 'view pages']);
        Permission::create(['name' => 'list pages']);
        Permission::create(['name' => 'edit pages']);
        Permission::create(['name' => 'delete pages']);
        Permission::create(['name' => 'publish pages']);
        Permission::create(['name' => 'unpublish pages']);

        Permission::create(['name' => 'create menus']);
        Permission::create(['name' => 'list menus']);
        Permission::create(['name' => 'edit menus']);
        Permission::create(['name' => 'delete menus']);
        Permission::create(['name' => 'publish menus']);
        Permission::create(['name' => 'unpublish menus']);

        Permission::create(['name' => 'edit categories']);
        Permission::create(['name' => 'delete categories']);
        Permission::create(['name' => 'create categories']);
        Permission::create(['name' => 'list categories']);
        Permission::create(['name' => 'view categories']);

        Permission::create(['name' => 'list roles']);
        Permission::create(['name' => 'edit roles']);
        Permission::create(['name' => 'delete roles']);
        Permission::create(['name' => 'create roles']);
        Permission::create(['name' => 'view roles']);

        Permission::create(['name' => 'list settings']);
        Permission::create(['name' => 'edit settings']);
        Permission::create(['name' => 'delete settings']);
        Permission::create(['name' => 'create settings']);
        Permission::create(['name' => 'view settings']);

        Permission::create(['name' => 'list faqs']);
        Permission::create(['name' => 'edit faqs']);
        Permission::create(['name' => 'view faqs']);
        Permission::create(['name' => 'delete faqs']);
        Permission::create(['name' => 'create faqs']);
        Permission::create(['name' => 'publish faqs']);
        Permission::create(['name' => 'unpublish faqs']);

        Permission::create(['name' => 'list permissions']);

        Permission::create(['name' => 'list users']);
        Permission::create(['name' => 'edit users']);
        Permission::create(['name' => 'delete users']);
        Permission::create(['name' => 'create users']);
        Permission::create(['name' => 'view users']);
        Permission::create(['name' => 'suspend users']);
        Permission::create(['name' => 'unsuspend users']);

        Permission::create(['name' => 'list medias']);
        Permission::create(['name' => 'edit medias']);
        Permission::create(['name' => 'delete medias']);
        Permission::create(['name' => 'create medias']);
        Permission::create(['name' => 'view medias']);

        Permission::create(['name' => 'list teams']);
        Permission::create(['name' => 'edit teams']);
        Permission::create(['name' => 'delete teams']);
        Permission::create(['name' => 'create teams']);
        Permission::create(['name' => 'view teams']);

        Permission::create(['name' => 'list events']);
        Permission::create(['name' => 'edit events']);
        Permission::create(['name' => 'delete events']);
        Permission::create(['name' => 'create events']);
        Permission::create(['name' => 'view events']);
        Permission::create(['name' => 'publish events']);
        Permission::create(['name' => 'unpublish events']);
        Permission::create(['name' => 'receive event notifications']);

        Permission::create(['name' => 'list elections']);
        Permission::create(['name' => 'edit elections']);
        Permission::create(['name' => 'delete elections']);
        Permission::create(['name' => 'create elections']);
        Permission::create(['name' => 'view elections']);
        Permission::create(['name' => 'publish elections']);
        Permission::create(['name' => 'unpublish elections']);
        Permission::create(['name' => 'unarchive elections']);
        Permission::create(['name' => 'archive elections']);

        Permission::create(['name' => 'list resultats']);
        Permission::create(['name' => 'edit resultats']);
        Permission::create(['name' => 'delete resultats']);
        Permission::create(['name' => 'create resultats']);
        Permission::create(['name' => 'view resultats']);
        Permission::create(['name' => 'publish resultats']);
        Permission::create(['name' => 'unpublish resultats']);
        Permission::create(['name' => 'unarchive resultats']);
        Permission::create(['name' => 'archive resultats']);

        Permission::create(['name' => 'list sites']);
        Permission::create(['name' => 'edit sites']);
        Permission::create(['name' => 'delete sites']);
        Permission::create(['name' => 'create sites']);
        Permission::create(['name' => 'view sites']);

        Permission::create(['name' => 'list marches_publics']);
        Permission::create(['name' => 'edit marches_publics']);
        Permission::create(['name' => 'delete marches_publics']);
        Permission::create(['name' => 'create marches_publics']);
        Permission::create(['name' => 'view marches_publics']);
        Permission::create(['name' => 'publish marches_publics']);
        Permission::create(['name' => 'unpublish marches_publics']);

        Permission::create(['name' => 'list documentation']);
        Permission::create(['name' => 'edit documentation']);
        Permission::create(['name' => 'delete documentation']);
        Permission::create(['name' => 'create documentation']);
        Permission::create(['name' => 'view documentation']);

        Permission::create(['name' => 'list followers']);
        Permission::create(['name' => 'list campaigns']);
        Permission::create(['name' => 'edit campaigns']);
        Permission::create(['name' => 'publish campaigns']);
        Permission::create(['name' => 'unpublish campaigns']);
        Permission::create(['name' => 'view campaigns']);
        Permission::create(['name' => 'delete campaigns']);
        Permission::create(['name' => 'delete followers']);
        Permission::create(['name' => 'create campaigns']);
        Permission::create(['name' => 'create followers']);
        Permission::create(['name' => 'unfollow followers']);
        Permission::create(['name' => 'follow followers']);

        Permission::create(['name' => 'edit sliders']);
        Permission::create(['name' => 'delete sliders']);
        Permission::create(['name' => 'create sliders']);
        Permission::create(['name' => 'list sliders']);
        Permission::create(['name' => 'view sliders']);



        // create roles and assign created permissions

        // this can be done as separate statements
        $role = Role::create(['name' => 'writer']);
        $role = Role::create(['name' => 'suscriber']);

        // or may be done by chaining
        $role = Role::create(['name' => 'admin']);

        $role = Role::create(['name' => 'super-admin']);
        $role->givePermissionTo(Permission::all());
    }
}
