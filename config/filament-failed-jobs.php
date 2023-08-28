<?php

return [
    'resources' => [
        'enabled' => true,
        'label' => 'Failed Job',
        'plural_label' => 'Failed Jobs',
        'navigation_group' => 'Settings',
        'navigation_icon' => 'heroicon-o-cpu-chip',
        'navigation_sort' => null,
        'navigation_count_badge' => false,
        'resource' => Amvisor\FilamentFailedJobs\Resources\FailedJobsResource::class,
    ],
    'pruning' => [
        'enabled' => true,
        'retention_days' => 7,
    ],
];
