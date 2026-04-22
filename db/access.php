<?php
defined('MOODLE_INTERNAL') || die();

$capabilities = [
    'qbank/kia_generator:generatequestions' => [
        'captype' => 'write',
        'contextlevel' => CONTEXT_COURSE,
        'archetypes' => [
            'manager' => CAP_ALLOW,
            //'editingteacher' => CAP_PREVENT,
            'teacher' => CAP_PREVENT,
            'student' => CAP_PREVENT,
            'guest' => CAP_PREVENT,
        ],
    ],
];