<?php

use App\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionsTableSeeder extends Seeder
{
    public function run()
    {
        $permissions = [
            [
                'id'    => 1,
                'title' => 'user_management_access',
            ],
            [
                'id'    => 2,
                'title' => 'permission_create',
            ],
            [
                'id'    => 3,
                'title' => 'permission_edit',
            ],
            [
                'id'    => 4,
                'title' => 'permission_show',
            ],
            [
                'id'    => 5,
                'title' => 'permission_delete',
            ],
            [
                'id'    => 6,
                'title' => 'permission_access',
            ],
            [
                'id'    => 7,
                'title' => 'role_create',
            ],
            [
                'id'    => 8,
                'title' => 'role_edit',
            ],
            [
                'id'    => 9,
                'title' => 'role_show',
            ],
            [
                'id'    => 10,
                'title' => 'role_delete',
            ],
            [
                'id'    => 11,
                'title' => 'role_access',
            ],
            [
                'id'    => 12,
                'title' => 'user_create',
            ],
            [
                'id'    => 13,
                'title' => 'user_edit',
            ],
            [
                'id'    => 14,
                'title' => 'user_show',
            ],
            [
                'id'    => 15,
                'title' => 'user_delete',
            ],
            [
                'id'    => 16,
                'title' => 'user_access',
            ],
            [
                'id'    => 17,
                'title' => 'category_create',
            ],
            [
                'id'    => 18,
                'title' => 'category_edit',
            ],
            [
                'id'    => 19,
                'title' => 'category_show',
            ],
            [
                'id'    => 20,
                'title' => 'category_delete',
            ],
            [
                'id'    => 21,
                'title' => 'category_access',
            ],
            [
                'id'    => 22,
                'title' => 'post_create',
            ],
            [
                'id'    => 23,
                'title' => 'post_edit',
            ],
            [
                'id'    => 24,
                'title' => 'post_show',
            ],
            [
                'id'    => 25,
                'title' => 'post_delete',
            ],
            [
                'id'    => 26,
                'title' => 'post_access',
            ],
            [
                'id'    => 27,
                'title' => 'tag_create',
            ],
            [
                'id'    => 28,
                'title' => 'tag_edit',
            ],
            [
                'id'    => 29,
                'title' => 'tag_show',
            ],
            [
                'id'    => 30,
                'title' => 'tag_delete',
            ],
            [
                'id'    => 31,
                'title' => 'tag_access',
            ],
            [
                'id'    => 32,
                'title' => 'post_management_access',
            ],
            [
                'id'    => 33,
                'title' => 'profile_password_edit',
            ],
            [
                'id'    => 34,
                'title' => 'product_category_create',
            ],
            [
                'id'    => 35,
                'title' => 'product_category_edit',
            ],
            [
                'id'    => 36,
                'title' => 'product_category_show',
            ],
            [
                'id'    => 37,
                'title' => 'product_category_delete',
            ],
            [
                'id'    => 38,
                'title' => 'product_category_access',
            ],
            [
                'id'    => 39,
                'title' => 'product_tag_create',
            ],
            [
                'id'    => 40,
                'title' => 'product_tag_edit',
            ],
            [
                'id'    => 41,
                'title' => 'product_tag_show',
            ],
            [
                'id'    => 42,
                'title' => 'product_tag_delete',
            ],
            [
                'id'    => 43,
                'title' => 'product_tag_access',
            ],
            [
                'id'    => 44,
                'title' => 'product_create',
            ],
            [
                'id'    => 45,
                'title' => 'product_edit',
            ],
            [
                'id'    => 46,
                'title' => 'product_show',
            ],
            [
                'id'    => 47,
                'title' => 'product_delete',
            ],
            [
                'id'    => 48,
                'title' => 'product_access',
            ],
            [
                'id'    => 49,
                'title' => 'brand_create',
            ],
            [
                'id'    => 50,
                'title' => 'brand_edit',
            ],
            [
                'id'    => 51,
                'title' => 'brand_show',
            ],
            [
                'id'    => 52,
                'title' => 'brand_delete',
            ],
            [
                'id'    => 53,
                'title' => 'brand_access',
            ]
        ];

        Permission::insert($permissions);
    }
}