<?php

namespace Fuel\Migrations;

class Create_users
{
    public function up()
    {
        \DBUtil::create_table('users', array(
            'id'             => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true, 'unsigned' => true),
            'username'       => array('constraint' => 30, 'type' => 'varchar'),
            'password'       => array('constraint' => 255, 'type' => 'varchar'),
            'group'          => array('constraint' => 11, 'type' => 'int', 'default' => 1),
            'email'          => array('constraint' => 255, 'type' => 'varchar'), //dummyメールアドレス
            'last_login'     => array('constraint' => 25, 'type' => 'varchar'),
            'login_hash'     => array('constraint' => 255, 'type' => 'varchar'),
            'profile_fields' => array('type' => 'text'),
            'created_at'     => array('constraint' => 11, 'type' => 'int', 'null' => true),
            'updated_at'     => array('constraint' => 11, 'type' => 'int', 'null' => true),
        ), array('id'));

        // 高速化と重複防止のためのインデックス作成
        \DBUtil::create_index('users', 'username', 'username_idx', 'UNIQUE');
        \DBUtil::create_index('users', 'email', 'email_idx', 'UNIQUE');
    }

    public function down()
    {
        \DBUtil::drop_table('users');
    }
}