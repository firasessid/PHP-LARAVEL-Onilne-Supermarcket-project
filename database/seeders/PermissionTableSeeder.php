<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [
           'role-list',
           'role-create',
           'role-edit',
           'role-delete',
           'product-list',
           'product-create',
           'product-edit',
           'product-delete',
           'user-list',
           'user-create',
           'user-edit',
           'user-delete',
           'brand-list',
           'brand-create',
           'brand-edit',
           'brand-delete',
           'ray-list',
           'ray-create',
           'ray-edit',
           'ray-delete',
           'category-list',
           'category-create',
           'category-edit',
           'category-delete',
           'subcategory-list',
           'subcategory-create',
           'subcategory-edit',
           'subcategory-delete',
            'pridective-sales',
            'sales-regression',
            'products-statistics',  
            'shippings',
            'order-list',
            'order-delete',
            'dashboard',
            'transaction',   
            'deal-list',
            'deal-create',
            'deal-edit',
            'deal-delete',
            'coupon-list',
            'coupon-create',
            'coupon-edit',
            'coupon-delete',

        ];

        foreach ($permissions as $permission) {
             Permission::create(['name' => $permission]);
        }
    }
}
