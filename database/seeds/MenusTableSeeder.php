<?php

use Illuminate\Database\Seeder;
use App\Menu;

class MenusTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        DB::table('menus')->insert([
            "name"=>"Usuarios",
            "description"=>"Usuarios de tu sitio",
            "route"=>"/users",
            "icon"=>"fa fa-users",
            "permissions_name"=>"view_users",
            "position"=>19
        ]);

        DB::table('menus')->insert([
            "name"=>"Banners",
            "description"=>"Banners de tu sitio",
            "route"=>"/banners",
            "icon"=>"fa fa-images",
            "permissions_name"=>"view_users",
            "position"=>20
        ]);

        DB::table('menus')->insert([
            "name"=>"Extras",
            "description"=>"Configuraciones extra de tu sitio",
            "route"=>"/extras",
            "icon"=>"fa fa-circle",
            "permissions_name"=>"view_users",
            "position"=>20
        ]);

        $extra=Menu::where('name','Extras')->first();
        DB::table('menus')->insert([
            "name"=>"Terminos y Condiciones",
            "description"=>"Terminos y Condiciones",
            "route"=>"/terminos",
            "icon"=>"fa fa-hand-paper-o",
            "parent"=>$extra->id,
            "permissions_name"=>"configuration"
        ]);
        // DB::table('menus')->insert([
        //     "name"=>"Nosotros / Historia",
        //     "description"=>"",
        //     "route"=>"/historia",
        //     "icon"=>"fa fa-hand-paper-o",
        //     "parent"=>$extra->id,
        //     "permissions_name"=>"configuration"
        // ]);
        DB::table('menus')->insert([
            "name"=>"Redes Sociales",
            "description"=>"",
            "route"=>"/redes",
            "icon"=>"fa fa-hand-paper-o",
            "parent"=>$extra->id,
            "permissions_name"=>"configuration"
        ]);

        DB::table('menus')->insert([
            "name"=>"Configuracion",
            "description"=>"Configuracion de tu sitio",
            "icon"=>"fa fa-cogs",
            "permissions_name"=>"configuration",
            "position"=>20
        ]);
        
        $conf=Menu::where('name','Configuracion')->first();
        DB::table('menus')->insert([
            "name"=>"Roles",
            "description"=>"Roles de tu sitio",
            "route"=>"/roles",
            "icon"=>"fa fa-hand-paper-o",
            "parent"=>$conf->id,
            "permissions_name"=>"configuration"
        ]);
        //nuevo
        DB::table('menus')->insert([
            "name"=>"Clientes",
            "description"=>"clientes",
            "route"=>"/customers",
            "icon"=>"fa fa-users",
            "permissions_name"=>"view_users",
            "position"=>2
        ]);

        DB::table('menus')->insert([
            "name"=>"Pedidos",
            "description"=>"Pedidos de tu sitio",
            "route"=>"/orders",
            "icon"=>"fa fa-file",
            "permissions_name"=>"view_users",
            "position"=>3
        ]);

        DB::table('menus')->insert([
            "name"=>"Productos",
            "description"=>"Productos de tu sitio",
            "route"=>"/products",
            "icon"=>"fa fa-box",
            "permissions_name"=>"view_users",
            "position"=>4
        ]);

        DB::table('menus')->insert([
            "name"=>"Categorias",
            "description"=>"Categorias de tu sitio",
            "route"=>"/categorias",
            "icon"=>"fa fa-folder",
            "permissions_name"=>"view_users",
            "position"=>5
        ]);

        DB::table('menus')->insert([
            "name"=>"Subcategorias",
            "description"=>"Subcategorias de tu sitio",
            "route"=>"/subcategorias",
            "icon"=>"fa fa-folder-open",
            "permissions_name"=>"view_users",
            "position"=>6
        ]);

        // DB::table('menus')->insert([
        //     "name"=>"Noticias",
        //     "description"=>"Noticias de tu sitio",
        //     "route"=>"/news",
        //     "icon"=>"fa fa-file",
        //     "permissions_name"=>"view_users",
        //     "position"=>7
        // ]);
        
    }
}
