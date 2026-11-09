<?php

namespace App\Providers;

use App\Content\Contracts\ContentRepository;
use App\Content\DatabaseContentRepository;
use App\Content\FileContentRepository;
use App\Content\Media\LifeGalleryManifest;
use App\Content\SectionRegistry;
use App\Content\Sections\CareOptionsSection;
use App\Content\Sections\HeroCinematicSection;
use App\Content\Sections\IntroShuttersSection;
use App\Content\Sections\LifeGallerySection;
use App\Integrations\Leads\LeadDestination;
use App\Integrations\Leads\UnconfiguredLeadDestination;
use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        // Approved section components. Add a schema here only after the
        // section is approved (docs/SECTION_STATUS.md).
        $this->app->singleton(SectionRegistry::class, fn () => new SectionRegistry([
            new IntroShuttersSection,
            new HeroCinematicSection,
            new CareOptionsSection,
            new LifeGallerySection(new LifeGalleryManifest(public_path())),
        ]));

        $this->app->singleton(ContentRepository::class, function ($app) {
            $registry = $app->make(SectionRegistry::class);

            return config('missionvilla.content_source') === 'database'
                ? new DatabaseContentRepository($registry)
                : new FileContentRepository($registry, base_path('content/pages'));
        });

        // Swap for a verified Synergy Hub adapter once its contract is confirmed.
        $this->app->bind(LeadDestination::class, UnconfiguredLeadDestination::class);
    }

    public function boot(): void
    {
        // Role-based access control for the future admin.
        Gate::define('edit-content', fn (User $user) => $user->isEditor());
        Gate::define('publish-content', fn (User $user) => $user->isAdmin());
        Gate::define('manage-media', fn (User $user) => $user->isEditor());
        Gate::define('manage-users', fn (User $user) => $user->isAdmin());
        Gate::define('manage-settings', fn (User $user) => $user->isAdmin());
        Gate::define('view-leads', fn (User $user) => $user->isAdmin());
    }
}
