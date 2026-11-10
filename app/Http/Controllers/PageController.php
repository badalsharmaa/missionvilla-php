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

    public function memoryCare(): View
    {
        return $this->render('memory-care');
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
