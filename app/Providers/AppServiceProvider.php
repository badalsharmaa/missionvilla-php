<?php

namespace App\Providers;

use App\Content\Contracts\ContentRepository;
use App\Content\DatabaseContentRepository;
use App\Content\FileContentRepository;
use App\Content\Media\LifeGalleryManifest;
use App\Content\SectionRegistry;
use App\Content\Sections\AboutCoreValuesSection;
use App\Content\Sections\AboutGeographySection;
use App\Content\Sections\AboutHeroSection;
use App\Content\Sections\AboutPhilosophySection;
use App\Content\Sections\AboutTeamCommitmentSection;
use App\Content\Sections\CareOptionsSection;
use App\Content\Sections\FaqFeaturedSection;
use App\Content\Sections\HeroCinematicSection;
use App\Content\Sections\IntroShuttersSection;
use App\Content\Sections\LifeGallerySection;
use App\Content\Sections\LivingOptionsCareSection;
use App\Content\Sections\LivingOptionsFaqSection;
use App\Content\Sections\SuitesFloorPlansHeroSection;
use App\Content\Sections\SuitesFloorPlansFormatsSection;
use App\Content\Sections\SuitesFloorPlansDiagramSection;
use App\Content\Sections\SuitesFloorPlansFeaturesSection;
use App\Content\Sections\SuitesFloorPlansFaqSection;
use App\Content\Sections\LifeAtMissionVillaHeroSection;
use App\Content\Sections\LifeAtMissionVillaPillarsSection;
use App\Content\Sections\LifeAtMissionVillaRhythmSection;
use App\Content\Sections\LifeAtMissionVillaEngagementSection;
use App\Content\Sections\LifeAtMissionVillaFaqSection;
use App\Content\Sections\ServicesAmenitiesHeroSection;
use App\Content\Sections\ServicesAmenitiesExplorerSection;
use App\Content\Sections\ServicesAmenitiesDiptychSection;
use App\Content\Sections\ServicesAmenitiesDisclosuresSection;
use App\Content\Sections\ServicesAmenitiesCareBridgeSection;
use App\Content\Sections\GalleryHeroSection;
use App\Content\Sections\GalleryMasonrySection;
use App\Content\Sections\GalleryVirtualTourSection;
use App\Content\Sections\GalleryPathwaysSection;
use App\Content\Sections\LivingOptionsHeroSection;
use App\Content\Sections\LivingOptionsSettingSection;
use App\Content\Sections\LivingOptionsSuitesSection;
use App\Content\Sections\MemoryCareCareComfortSection;
use App\Content\Sections\MemoryCareDailyLifeSection;
use App\Content\Sections\MemoryCareHeroSection;
use App\Content\Sections\MemoryCareLegaciesSection;
use App\Content\Sections\RespiteCareCaregiverSection;
use App\Content\Sections\RespiteCareFaqSection;
use App\Content\Sections\RespiteCareHeroSection;
use App\Content\Sections\RespiteCareInclusionsSection;
use App\Content\Sections\RespiteCareScenariosSection;
use App\Content\Sections\RespiteCareStorySection;
use App\Content\Sections\RespiteCareTimelineSection;
use App\Content\Sections\SuitesSpacesSection;
use App\Content\Sections\VisitCtaSection;
use App\Content\Sections\WhyFamiliesSection;
use App\Integrations\Leads\LeadDestination;
use App\Integrations\Leads\UnconfiguredLeadDestination;
use App\Models\User;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\RateLimiter;
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
            new WhyFamiliesSection(new LifeGalleryManifest(public_path())),
            new SuitesSpacesSection,
            new FaqFeaturedSection,
            new VisitCtaSection,
            new MemoryCareHeroSection,
            new MemoryCareLegaciesSection,
            new MemoryCareDailyLifeSection,
            new MemoryCareCareComfortSection,
            new RespiteCareHeroSection,
            new RespiteCareScenariosSection,
            new RespiteCareInclusionsSection,
            new RespiteCareStorySection,
            new RespiteCareCaregiverSection,
            new RespiteCareTimelineSection,
            new RespiteCareFaqSection,
            new LivingOptionsHeroSection,
            new LivingOptionsCareSection,
            new LivingOptionsSuitesSection,
            new LivingOptionsSettingSection,
            new LivingOptionsFaqSection,
            new SuitesFloorPlansHeroSection,
            new SuitesFloorPlansFormatsSection,
            new SuitesFloorPlansDiagramSection,
            new SuitesFloorPlansFeaturesSection,
            new SuitesFloorPlansFaqSection,
            new LifeAtMissionVillaHeroSection,
            new LifeAtMissionVillaPillarsSection,
            new LifeAtMissionVillaRhythmSection,
            new LifeAtMissionVillaEngagementSection,
            new LifeAtMissionVillaFaqSection,
            new ServicesAmenitiesHeroSection,
            new ServicesAmenitiesExplorerSection,
            new ServicesAmenitiesDiptychSection,
            new ServicesAmenitiesDisclosuresSection,
            new ServicesAmenitiesCareBridgeSection,
            new GalleryHeroSection,
            new GalleryMasonrySection,
            new GalleryVirtualTourSection,
            new GalleryPathwaysSection,
            new AboutHeroSection,
            new AboutPhilosophySection,
            new AboutGeographySection,
            new AboutCoreValuesSection,
            new AboutTeamCommitmentSection,
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
        // Abuse protection for the public inquiry endpoint (per IP).
        RateLimiter::for('inquiries', function (Request $request) {
            $cfg = config('missionvilla.inquiries');

            return [
                Limit::perMinute($cfg['per_minute'])->by('inquiry-min:'.$request->ip()),
                Limit::perDay($cfg['per_day'])->by('inquiry-day:'.$request->ip()),
            ];
        });

        // Role-based access control for the future admin.
        Gate::define('edit-content', fn (User $user) => $user->isEditor());
        Gate::define('publish-content', fn (User $user) => $user->isAdmin());
        Gate::define('manage-media', fn (User $user) => $user->isEditor());
        Gate::define('manage-users', fn (User $user) => $user->isAdmin());
        Gate::define('manage-settings', fn (User $user) => $user->isAdmin());
        Gate::define('view-leads', fn (User $user) => $user->isAdmin());
    }
}
