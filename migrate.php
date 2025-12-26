<?php

require_once __DIR__ . '/bootstrap.php';

use Illuminate\Database\Capsule\Manager as Capsule;

if (!Capsule::schema()->hasTable('todos')) {
    Capsule::schema()->create('todos', function ($table) {
        $table->increments('id');
        $table->string('title');
        $table->boolean('completed')->default(false);
        $table->timestamps();
    });
    echo "Table 'todos' created successfully.\n";
} else {
    echo "Table 'todos' already exists.\n";
}
