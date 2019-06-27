<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class GivePermissions extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role=Role::findByName('admin');
        $role->givePermissionTo('articles');
        $role->givePermissionTo('newArticles');
        $role->givePermissionTo('editArticles');
        $role->givePermissionTo('categories');
        $role->givePermissionTo('newCategories');
        $role->givePermissionTo('editCategories');
        $role->givePermissionTo('destroyCategories');
        $role->givePermissionTo('purchases');
        $role->givePermissionTo('incomes');
        $role->givePermissionTo('newIncomes');
        $role->givePermissionTo('editIncomes');
        $role->givePermissionTo('destroyIncomes');
        $role->givePermissionTo('editIncomes');
        $role->givePermissionTo('providers');
        $role->givePermissionTo('newProviders');
        $role->givePermissionTo('editProviders');
        $role->givePermissionTo('destroyProviders');
        $role->givePermissionTo('sales');
        $role->givePermissionTo('showSales');
        $role->givePermissionTo('destroySales');
        $role->givePermissionTo('newSales');
        $role->givePermissionTo('clients');
        $role->givePermissionTo('editClients');
        $role->givePermissionTo('destroyClients');
        $role->givePermissionTo('newClients');
        $role->givePermissionTo('clientsCategories');
        $role->givePermissionTo('newClientsCategories');
        $role->givePermissionTo('editClientCategories');
        $role->givePermissionTo('destroyClientCategories');
        $role->givePermissionTo('users');
        $role->givePermissionTo('editUsers');
        $role->givePermissionTo('destroyUsers');

        $role=Role::findByName('compras');
        $role->givePermissionTo('articles');
        $role->givePermissionTo('newArticles');
        $role->givePermissionTo('editArticles');
        $role->givePermissionTo('categories');
        $role->givePermissionTo('newCategories');
        $role->givePermissionTo('editCategories');
        $role->givePermissionTo('destroyCategories');
        $role->givePermissionTo('purchases');
        $role->givePermissionTo('incomes');
        $role->givePermissionTo('newIncomes');
        $role->givePermissionTo('editIncomes');
        $role->givePermissionTo('destroyIncomes');
        $role->givePermissionTo('editIncomes');
        $role->givePermissionTo('providers');
        $role->givePermissionTo('newProviders');
        $role->givePermissionTo('editProviders');
        $role->givePermissionTo('destroyProviders');

        $role=Role::findByName('ventas');
        $role->givePermissionTo('sales');
        $role->givePermissionTo('showSales');
        $role->givePermissionTo('destroySales');
        $role->givePermissionTo('newSales');
        $role->givePermissionTo('clients');
        $role->givePermissionTo('editClients');
        $role->givePermissionTo('destroyClients');
        $role->givePermissionTo('newClients');
        $role->givePermissionTo('clientsCategories');
        $role->givePermissionTo('newClientsCategories');
        $role->givePermissionTo('editClientCategories');
        $role->givePermissionTo('destroyClientCategories');
        $role->givePermissionTo('users');
        $role->givePermissionTo('editUsers');
        $role->givePermissionTo('destroyUsers');

    }
}
