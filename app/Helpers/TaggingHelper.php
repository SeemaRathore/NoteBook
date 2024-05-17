<?php

namespace App\Helpers;

class TaggingHelper
{
    public static function getTags(): array
    {
        return [
            'work' => 'Work',
            'personal' => 'Personal',
            'urgent' => 'Urgent',
            'meeting' => 'Meeting',
            'deadline' => 'Deadline',
            'home' => 'Home',
            'school' => 'School',
            'health' => 'Health',
            'project' => 'Project',
            'assignment' => 'Assignment',
            'appointment' => 'Appointment',
            'shopping' => 'Shopping',
            'fitness' => 'Fitness',
            'finance' => 'Finance',
        ];
    }
}
