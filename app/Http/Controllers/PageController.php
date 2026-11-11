<?php

namespace App\Http\Controllers;

use App\Content\Contracts\ContentRepository;
use App\Content\SectionRegistry;
use Illuminate\Contracts\View\View;

class PageController extends Controller
{
    public function __construct(
        private readonly ContentRepository $content,
        private readonly SectionRegistry $registry,
    ) {}

    public function home(): View
    {
        return $this->render('home');
    }

    public function livingOptions(): View
    {
        return $this->render('living-options');
    }

    public function memoryCare(): View
    {
        return $this->render('memory-care');
    }

    public function respiteCare(): View
    {
        return $this->render('respite-care');
    }

    public function suitesFloorPlans(): View
    {
        return $this->render('suites-and-floor-plans');
    }

    public function lifeAtMissionVilla(): View
    {
        return $this->render('life-at-mission-villa');
    }

    public function servicesAmenities(): View
    {
        return $this->render('services-and-amenities');
    }

    public function gallery(): View
    {
        return $this->render('gallery');
    }

    public function about(): View
    {
        return $this->render('about');
    }

    private function render(string $slug): View
    {
        $page = $this->content->findPublishedPage($slug) ?? abort(404);

        return view('pages.page', [
            'page' => $page,
            'registry' => $this->registry,
        ]);
    }
}
