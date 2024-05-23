<?php

// Include Laravel's autoload file to autoload Laravel components
require __DIR__.'/../vendor/autoload.php';
use Illuminate\Database\Capsule\Manager as Capsule;
use App\Models\Note;
use Carbon\Carbon;

// Bootstrap Laravel
$app = require_once __DIR__.'/../bootstrap/app.php';

// Set up database connection
$capsule = new Capsule;
$capsule->addConnection([
    'driver'    => 'mariadb',
    'host'      => '127.0.0.1',
    'database'  => 'note_curd',
    'username'  => 'root',
    'password'  => '',
    'charset'   => 'utf8mb4',
    'collation' => 'utf8mb4_unicode_ci',
    'prefix'    => '',
]);$capsule->setAsGlobal();
$capsule->bootEloquent();

// Get the current timestamp
$currentTime = Carbon::now();

// Get the latest note added before the end of the current date
$latestNote = Note::whereDate('created_at', '<=', $currentTime)
    ->latest()
    ->first();

if ($latestNote) {
    // Update the tag_end column for the latest note with the current timestamp
    $latestNote->update(['tag_end' => $currentTime]);
    echo "Tag_end column updated for the latest note added before the end of the day.\n";
} else {
    echo "No notes found to update tag_end column.\n";
}

//command to run script => php scripts/update_tag_end.php
