# A simple failed jobs viewer for your Filament apps.

This package provides a `Failed Jobs` resource that allows you to view your Failed jobs in a simple UI.
If you are using the Job Batches Feature, a `Job Batches` resource is displayed also.

![image-1.png](./image-1.png)
![image-2.png](./image-2.png)

## Installation

You should install the package via Composer:

```bash
composer require amvisor/filament-failed-jobs
php artisan vendor:publish --tag=filament-failed-jobs
```

### Authorization

If you would like to prevent certain users from accessing your page, you should register an FailedJobsPolicy/JobBatchesPolicy:

```php
use App\Policies\FailedJobPolicy;
use Amvisor\FilamentFailedJobs\Models\FailedJob;
use Amvisor\FilamentFailedJobs\Models\JobBatch;

class AuthServiceProvider extends ServiceProvider
{
	protected $policies = [
		FailedJob::class => FailedJobPolicy::class,
		JobBatch::class  => JobBatchPolicy::class,
	];
}
```

```php
namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class FailedJobPolicy
{
	use HandlesAuthorization;

	public function viewAny(User $user): bool
	{
		return $user->can('manage_failed_jobs');
	}
}
```
(same for JobBatchPolicy, if necessary).

This will prevent the navigation item(s) from being registered.

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
