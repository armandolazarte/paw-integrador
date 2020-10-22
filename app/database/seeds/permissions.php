<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;


class permissions extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        Permission::create(['name' => 'articles']);
        Permission::create(['name' => 'newArticles']);
        Permission::create(['name' => 'editArticles']);
        Permission::create(['name' => 'destroyArticles']);
        Permission::create(['name' => 'categories']);
        Permission::create(['name' => 'newCategories']);
        Permission::create(['name' => 'editCategories']);
        Permission::create(['name' => 'destroyCategories']);
        Permission::create(['name' => 'purchases']);
        Permission::create(['name' => 'incomes']);
        Permission::create(['name' => 'newIncomes']);
        Permission::create(['name' => 'editIncomes']);
        Permission::create(['name' => 'destroyIncomes']);
        Permission::create(['name' => 'providers']);
        Permission::create(['name' => 'newProviders']);
        Permission::create(['name' => 'editProviders']);
        Permission::create(['name' => 'destroyProviders']);
        Permission::create(['name' => 'sales']);
        Permission::create(['name' => 'showSales']);
        Permission::create(['name' => 'destroySales']);
        Permission::create(['name' => 'newSales']);
        Permission::create(['name' => 'clients']);
        Permission::create(['name' => 'editClients']);
        Permission::create(['name' => 'destroyClients']);
        Permission::create(['name' => 'newClients']);
        Permission::create(['name' => 'clientsCategories']);
        Permission::create(['name' => 'newClientsCategories']);
        Permission::create(['name' => 'editClientCategories']);
        Permission::create(['name' => 'destroyClientCategories']);
        Permission::create(['name' => 'users']);
        Permission::create(['name' => 'editUsers']);
        Permission::create(['name' => 'destroyUsers']);
    }
}
