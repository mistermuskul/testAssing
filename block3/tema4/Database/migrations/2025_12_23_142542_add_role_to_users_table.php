<?php

use Illuminate\Database\Capsule\Manager as Capsule;

class AddRoleToUsersTable
{
    public function up()
    {
        Capsule::schema()->table('users', function ($table) {
            $table->string('role')->default('user')->after('password');
        });
    }

    public function down()
    {
        if (Capsule::schema()->hasTable('users') && Capsule::schema()->hasColumn('users', 'role')) {
            Capsule::schema()->table('users', function ($table) {
                $table->dropColumn('role');
            });
        }
    }
}
