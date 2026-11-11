@php
    /** @var array $data Normalised by App\Content\Sections\AboutTeamCommitmentSection */
    $site = config('missionvilla');
    $roles = $data['roles'];
    $petPolicy = $data['pet_policy'];
    $directCall = $data['direct_call'];
@endphp
@push('section-assets')
    @vite(['resources/css/sections/about-team-commitment.css', 'resources/js/sections/about-team-commitment.js'])
@endpush
{{--
    ABOUT SECTION 05 · CARE TEAM STEWARDSHIP & PET POLICY
--}}
<section class="about-team" aria-labelledby="about-team-heading" id="team-and-policies" data-about-team>
    <div class="about-team__inner">
        <div class="about-team__grid">
            {{-- Left 7 Columns: Care Team Stewardship & Role Explorer (No Fake Bios) --}}
            <div class="about-team__explorer">
                <div class="about-team__explorer-header">
                    <div class="about-team__badges">
                        <span class="about-team__kicker">{{ $data['eyebrow'] }}</span>
                        <span class="about-team__status-badge">{{ $data['badge'] }}</span>
                    </div>

                    <h2 id="about-team-heading" class="about-team__title">
                        {!! $data['heading'] !!}
                    </h2>

                    <p class="about-team__intro">
                        {{ $data['intro'] }}
                    </p>
                </div>

                {{-- Role Selector Buttons --}}
                <div class="about-team__roles-grid" role="tablist" aria-label="Care Team Departments">
                    @foreach ($roles as $idx => $role)
                        <button
                            type="button"
                            role="tab"
                            id="role-tab-{{ $role['id'] }}"
                            aria-controls="role-panel-{{ $role['id'] }}"
                            aria-selected="{{ $idx === 0 ? 'true' : 'false' }}"
                            class="about-team__role-btn {{ $idx === 0 ? 'about-team__role-btn--active' : '' }}"
                            data-role-tab="{{ $role['id'] }}"
                        >
                            <span class="about-team__role-dept">{{ $role['department_tag'] }}</span>
                            <span class="about-team__role-name">{{ $role['role_title'] }}</span>
                        </button>
                    @endforeach
                </div>

                {{-- Active Role Details Panel --}}
                <div class="about-team__panels">
                    @foreach ($roles as $idx => $role)
                        <div
                            role="tabpanel"
                            id="role-panel-{{ $role['id'] }}"
                            aria-labelledby="role-tab-{{ $role['id'] }}"
                            class="about-team__role-detail {{ $idx === 0 ? 'about-team__role-detail--active' : '' }}"
                            data-role-panel="{{ $role['id'] }}"
                            {{ $idx !== 0 ? 'hidden' : '' }}
                        >
                            <div class="about-team__detail-header">
                                <span class="about-team__detail-title">{{ $role['role_title'] }}</span>
                                <span class="about-team__detail-location">On-Site Daly City Team</span>
                            </div>

                            <p class="about-team__detail-support">
                                {{ $role['how_they_support'] }}
                            </p>

                            <div class="about-team__detail-footer">
                                <div class="about-team__question">
                                    <span class="about-team__question-label">Suggested Question for Your Tour:</span>
                                    <p class="about-team__question-text">“{{ $role['tour_question'] }}”</p>
                                </div>

                                <button
                                    type="button"
                                    class="about-team__inquiry-btn"
                                    data-inquiry="schedule_visit"
                                    data-inquiry-source="about-team"
                                    data-care="memory_care"
                                    data-note="Question for tour: {{ $role['tour_question'] }}"
                                >
                                    <span>Add to Tour Inquiry</span>
                                    <svg class="about-team__inquiry-arrow" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                        <line x1="7" y1="17" x2="17" y2="7"/>
                                        <polyline points="7 7 17 7 17 17"/>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- Right 5 Columns: Pet Policy & Direct Contact Bridge --}}
            <div class="about-team__sidebar">
                {{-- Conditional Pet Policy Herbarium Card --}}
                <div class="about-team__pet-card herbarium-mount">
                    <div class="about-team__pet-header">
                        <div class="about-team__pet-badge">
                            <svg class="about-team__paw-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                <circle cx="12" cy="12" r="3"/>
                                <circle cx="7" cy="8" r="2"/>
                                <circle cx="17" cy="8" r="2"/>
                                <circle cx="5" cy="14" r="1.5"/>
                                <circle cx="19" cy="14" r="1.5"/>
                            </svg>
                            <span>{{ $petPolicy['badge'] }}</span>
                        </div>

                        <h3 class="about-team__pet-title">{{ $petPolicy['headline'] }}</h3>

                        <p class="about-team__pet-summary">{{ $petPolicy['summary'] }}</p>

                        <ul class="about-team__pet-list">
                            @foreach ($petPolicy['confirmation_items'] as $item)
                                <li class="about-team__pet-item">
                                    <svg class="about-team__check-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" aria-hidden="true">
                                        <polyline points="20 6 9 17 4 12"/>
                                    </svg>
                                    <span>{{ $item }}</span>
                                </li>
                            @endforeach
                        </ul>
                    </div>

                    <div class="about-team__pet-footer">
                        <span class="about-team__pet-status">
                            Status: {{ $petPolicy['verification_status'] }}
                        </span>

                        <button
                            type="button"
                            class="about-team__pet-btn"
                            data-inquiry="schedule_visit"
                            data-inquiry-source="about-team"
                            data-care="exploring"
                            data-note="{{ $petPolicy['inquiry_note'] }}"
                        >
                            <span>Confirm Pet Policy on Tour</span>
                            <svg class="about-team__btn-arrow" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                <line x1="7" y1="17" x2="17" y2="7"/>
                                <polyline points="7 7 17 7 17 17"/>
                            </svg>
                        </button>
                    </div>
                </div>

                {{-- Direct Team Conversation Bridge Card --}}
                <div class="about-team__direct-card">
                    <div class="about-team__direct-header">
                        <span class="about-team__direct-badge">{{ $directCall['badge'] }}</span>
                        <svg class="about-team__shield-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                            <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
                        </svg>
                    </div>

                    <h3 class="about-team__direct-title">{{ $directCall['title'] }}</h3>

                    <div class="about-team__direct-desc">
                        {!! $directCall['description'] !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
