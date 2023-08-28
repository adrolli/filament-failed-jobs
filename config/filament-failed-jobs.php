<?php

return [
    'resources' => [
        'jobs' => [
            'enabled' => true,
            'label' => 'Job',
            'plural_label' => 'Jobs',
            'navigation_group' => 'Job queues',
            'navigation_icon' => 'heroicon-o-cpu-chip',
            'navigation_sort' => 1,
            'navigation_count_badge' => false,
            'resource' => Amvisor\FilamentFailedJobs\Resources\JobsResource::class,
        ],
        'failed_jobs' => [
            'enabled' => true,
            'label' => 'Failed Job',
            'plural_label' => 'Failed Jobs',
            'navigation_group' => 'Job queues',
            'navigation_icon' => 'heroicon-o-exclamation-circle',
            'navigation_sort' => 2,
            'navigation_count_badge' => false,
            'resource' => Amvisor\FilamentFailedJobs\Resources\FailedJobsResource::class,
        ],
        'job_batches' => [
            'enabled' => true,
            'label' => 'Job Batch',
            'plural_label' => 'Job Batches',
            'navigation_group' => 'Job queues',
            'navigation_icon' => 'heroicon-o-inbox-stack',
            'navigation_sort' => 3,
            'navigation_count_badge' => false,
            'resource' => Amvisor\FilamentFailedJobs\Resources\JobBatchesResource::class,
        ],
    ],
    'pruning' => [
        'enabled' => true,
        'retention_days' => 7,
    ],
];
