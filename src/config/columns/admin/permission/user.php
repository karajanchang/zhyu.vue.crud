<?php

return [
    'model' => App\Models\User::class,
    'title' => '使用者管理',
    //'orderby' => ['id' => 'asc'],
    'index_buttons' => [
        'draggable' => true,
        'width' => 250,
        [
            'label' => '修改',
            'url' => '/admin/permission/user/{id}/edit',
            'css' => 'is-info',
            'type'=> 'update'
        ],
        [
            'label' => '刪除',
            'url' => '/admin/permission/user/{id}',
            'css' => 'is-danger',
            'type'=> 'delete'
        ],
        [
            'label' => '角色管理',
            'url' => '/admin/permission/user/{id}/role-set',
            'css' => 'is-primary',
        ],
    ],
    'form_buttons' => [
        [
            'label' => '取消',
            'url' => '/admin/permission/user',
            'css' => 'is-default',
            'type'=> 'cancel'
        ],
        [
            'label' => '送出',
            'css' => 'is-primary',
            'type'=> 'submit'
        ],
    ],
    'columns' => [
        'name' =>
            [
                'name' => '使用者名稱',
                'type' => 'text',
                'rules' => [
                    'store' =>  'required|string',
                    'update' =>  'required|string',
                ],
                'params' => [
                    'sortable', 'searchable',
                    'header-class' => '',
                    'cell-class' => '',
                ],
            ],
        'email' =>
            [
                'name' => 'E-Mail',
                'type' => 'text',
                'rules' => [
                    'store' =>  'required|email',
                    'update' =>  'required|email',
                ],
                'params' => [
                    'sortable', 'searchable',
                    'header-class' => '',
                    'cell-class' => '',
                ],
            ],
        'password' =>
            [
                'name' => '密碼',
                'type' => 'password',
                'rules' => [
                    'store' =>  'required|string',
                    'update' =>  'nullable|string',
                ],
                'params' => [
                    'sortable', 'searchable',
                    'header-class' => '',
                    'cell-class' => '',
                ],
                'display_index' => false,
                'display_form' => true,
            ],
        'is_online' =>
            [
                'name' => '是否有效',
                'type' => 'checkbox',
                'rules' => [
                    'store' =>  'nullable|integer',
                    'update' =>  'nullable|integer',
                ],
                'params' => [
                    'sortable', 'searchable',
                    'header-class' => '',
                    'cell-class' => '',
                ],
                'display_index' => true,
                'display_form' => true,
            ],
        'orderby' =>
            [
                'name' => '排序',
                'type' => 'integer',
                'rules' => [
                    'store' =>  'required|integer',
                    'update' =>  'required|integer',
                ],
                'params' => [
                    'sortable', 'searchable',
                    'header-class' => '',
                    'cell-class' => '',
                ],
            ],

    ],
    'joins' => [
        /*
        'fac_members_id' => [
            'members', 'posts.members_id', '=', 'members.id'
        ],
        */
    ],
];
