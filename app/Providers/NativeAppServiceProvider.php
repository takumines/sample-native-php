<?php

namespace App\Providers;

use Native\Laravel\Dialog;
use Native\Laravel\Facades\ContextMenu;
use Native\Laravel\Facades\Dock;
use Native\Laravel\Facades\MenuBar;
use Native\Laravel\Facades\Notification;
use Native\Laravel\Facades\Window;
use Native\Laravel\Facades\GlobalShortcut;
use Native\Laravel\Menu\Menu;

class NativeAppServiceProvider
{
    /**
     * Executed once the native application has been booted.
     * Use this method to open windows, register global shortcuts, etc.
     */
    public function boot(): void
    {
        Menu::new()
            ->appMenu()
            ->submenu('About', Menu::new()
                ->link('https://beyondco.de', 'Beyond Code')
                ->link('https://simonhamp.me', 'Simon Hamp')
            )
            ->submenu('View', Menu::new()
                ->toggleFullscreen()
                ->separator()
                ->link('https://laravel.com', 'Learn More', 'CmdOrCtrl+L')
                ->quit()
            )
            ->submenu('Page', Menu::new()
                ->link(route('atti'), 'あっち')
                ->separator()
                ->link(route('kotti'), 'こっち')
            )
            ->submenu('Company', Menu::new()
                ->link('https://nomadori.com', 'Nomadori')
            )
            ->register();

        Window::open()
            ->width(800)
            ->height(800);

        MenuBar::create()
            ->showDockIcon()
            ->label('Status: Online');

        Dock::menu(
            Menu::new()
                ->event(DockItemClicked::class, 'Settings')
                ->submenu('Help',
                    Menu::new()
                        ->event(DockItemClicked::class, 'About')
                        ->event(DockItemClicked::class, 'Learn More…')
                )
            );

        Notification::title('Hello from NativePHP')
            ->message('This is a detail message coming from your Laravel app.')
            ->show();

        ContextMenu::register(
            Menu::new()
                ->event(ContextMenuClicked::class, 'Do something')
        );

        GlobalShortcut::new()
            ->key('CmdOrCtrl+Shift+I')
            ->event(ShortcutPressed::class)
            ->register();

    }
}
