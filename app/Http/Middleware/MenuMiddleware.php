<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class MenuMiddleware{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next){


        \App::setLocale(\App\Model\Settings::get('language'));


        \Menu::make('MainMenu', function($menu) {

            $prefix = \Config::get('horizontcms.backend_prefix');

            $menu->add("<span class='glyphicon glyphicon-th-large' aria-hidden='true'></span> ".trans('navbar.dashboard'), $prefix."/dashboard");

            if(\Auth::user()->hasPermission("blogpost")){
            $menu->add(trans('navbar.news'), '#')->id('news');
            $menu->find('news')->add("<i class='fa fa-newspaper-o'></i> ".trans('navbar.posted_news'), admin_link('blogpost-index'));
            $menu->find('news')->add("<i class='fa fa-pencil'></i> ".trans('navbar.create_post'), admin_link('blogpost-create'));
            $menu->find('news')->add("<i class='fa fa-list-ul'></i> ".trans('navbar.categories'), admin_link('blogpost_category-index'));
            }

            if(\Auth::user()->hasPermission("user")){
            $menu->add(trans('navbar.users'), '#')->id('users');
            $menu->find('users')->add("<i class='fa fa-users'></i> ".trans('navbar.user_list'), admin_link('user-index'));
            $menu->find('users')->add("<i class='fa fa-user-plus'></i> ".trans('navbar.user_add'),admin_link('user-create'));
            $menu->find('users')->add("<i class='fa fa-gavel'></i> ".trans('navbar.user_groups'), admin_link('user_role-index'));
            }

            if(\Auth::user()->hasPermission("page")){
            $menu->add(trans('navbar.pages'), '#')->id('pages');
            $menu->find('pages')->add("<i class='fa fa-files-o'></i> ".trans('navbar.page_list'), admin_link('page-index'));
            $menu->find('pages')->add("<i class='fa fa-pencil-square-o'></i> ".trans('navbar.page_add'), admin_link('page-create'));
            }


            if(\Auth::user()->hasPermission("media")){
            $menu->add(trans('navbar.media'), '#')->id('media');
            $menu->find('media')->add("<i class='fa fa-picture-o'></i> ".trans('navbar.header_images'), admin_link('headerimage-index'));
            $menu->find('media')->add("<i class='fa fa-folder-open-o'></i> ".trans('navbar.filemanager'), $prefix.'/file-manager');
           // $menu->find('media')->add("<i class='fa fa-camera-retro'></i> ".trans('navbar.gallery'), $prefix.'/gallery');
            }


            if(\Auth::user()->hasPermission("themes&apps")){
            $menu->add(trans('navbar.themes_apps'), '#')->id('themes_apps');
            $menu->find('themes_apps')->add("<i class='fa fa-desktop'></i> ".trans('navbar.theme'), $prefix.'/theme');
            $menu->find('themes_apps')->add("<i class='fa fa-cubes'></i> ".trans('navbar.plugin'), $prefix.'/plugin');
           // $menu->find('themes_apps')->add("<i class='fa fa-code'></i> ".trans('navbar.develop'), $prefix.'/develop');
            }

        });
  

        \Menu::make('RightMenu', function($menu) {

            $prefix = \Config::get('horizontcms.backend_prefix');

           // $menu->add('current_user', $request->user()->username)->id('current_user');

            if(\Auth::user()->hasPermission("settings")){
                $menu->add("<i class='fa fa-cogs'></i> ", $prefix.'/settings')->id('settings');
            }


                $menu->add("<i class='fa fa-power-off'></i> ", '#')->id('shutdown');
                $menu->find('shutdown')->add("<i class='fa fa-lock'></i> ".trans('navbar.lock_screen'), ['url'=>'#', 'onclick'=>'event.preventDefault();localStorage.locksession=\'true\'','data-target'=>"#lock_screen",'data-toggle'=>"modal",'data-backdrop'=>'static','data-keyboard'=> 'false'])->id('lock_screen');
                $menu->find('lock_screen')->divide();
                $menu->find('shutdown')->add("<i class='fa fa-external-link'></i> ".trans('navbar.visit_site',['site_name' => \App\Model\Settings::get('site_name')]), '');
                $menu->find('shutdown')->add("<i class='fa fa-sign-out'></i> ".trans('navbar.logout'), ['onclick' => 'event.preventDefault(); document.getElementById(\'logout-form\').submit();']);

        

        });


        return $next($request);
    }
}
