<?php

require_once __DIR__ . '/bootstrap.php';

use App\Models\Todo;

// Sample tasks to seed
$tasks = [
    ['title' => '🚀 Initialize TaskFlow project', 'completed' => true],
    ['title' => '🐘 Setup Eloquent ORM with SQLite', 'completed' => true],
    ['title' => '⚛️ Build high-performance React frontend', 'completed' => false],
    ['title' => '🎨 Apply premium mesh-gradient styling', 'completed' => false],
    ['title' => '🌓 Implement robust theme toggle', 'completed' => true],
    ['title' => '📜 Update documentation & README', 'completed' => false],
];

echo "🌱 Seeding sample todos...\n";

// Clear existing todos if you want a fresh start (optional)
// Todo::truncate(); 

foreach ($tasks as $task) {
    echo "Creating: {$task['title']}... ";
    Todo::create($task);
    echo "✅\n";
}

echo "🎉 Database seeded successfully!\n";
