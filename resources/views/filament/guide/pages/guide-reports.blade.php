<x-filament-panels::page>

    {{-- ============ APPLICATION OVERVIEW ============ --}}
    <x-filament::section heading="Application Overview" icon="heroicon-o-paper-airplane">
        <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 1rem; margin-bottom: 1.25rem;">
            <div style="position: relative; overflow: hidden; border-radius: 0.75rem; padding: 1.25rem; color: white; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1); background: linear-gradient(135deg, #1B2A4A 0%, #2d4a7a 100%);">
                <div style="font-size: 1.875rem; font-weight: 800; letter-spacing: -0.025em;">{{ $totalApplications }}</div>
                <div style="font-size: 0.875rem; font-weight: 500; margin-top: 0.25rem; opacity: 0.8;">Total Applied</div>
            </div>
            <div style="position: relative; overflow: hidden; border-radius: 0.75rem; padding: 1.25rem; color: white; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1); background: linear-gradient(135deg, #059669 0%, #10b981 100%);">
                <div style="font-size: 1.875rem; font-weight: 800; letter-spacing: -0.025em;">{{ $acceptedApplications }}</div>
                <div style="font-size: 0.875rem; font-weight: 500; margin-top: 0.25rem; opacity: 0.8;">Accepted</div>
            </div>
            <div style="position: relative; overflow: hidden; border-radius: 0.75rem; padding: 1.25rem; color: white; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1); background: linear-gradient(135deg, #d97706 0%, #f59e0b 100%);">
                <div style="font-size: 1.875rem; font-weight: 800; letter-spacing: -0.025em;">{{ $pendingApplications }}</div>
                <div style="font-size: 0.875rem; font-weight: 500; margin-top: 0.25rem; opacity: 0.8;">Pending</div>
            </div>
            <div style="position: relative; overflow: hidden; border-radius: 0.75rem; padding: 1.25rem; color: white; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1); background: linear-gradient(135deg, #D4A843 0%, #b8922e 100%);">
                <div style="font-size: 1.875rem; font-weight: 800; letter-spacing: -0.025em;">{{ $acceptanceRate }}%</div>
                <div style="font-size: 0.875rem; font-weight: 500; margin-top: 0.25rem; opacity: 0.8;">Success Rate</div>
            </div>
        </div>

        {{-- Status bars --}}
        <div style="display: flex; flex-direction: column; gap: 0.625rem;">
            @php $maxApp = max($pendingApplications, $shortlistedApplications, $acceptedApplications, $rejectedApplications, 1); @endphp
            @foreach([
                ['Pending', $pendingApplications, '#f59e0b'],
                ['Shortlisted', $shortlistedApplications, '#3b82f6'],
                ['Accepted', $acceptedApplications, '#22c55e'],
                ['Rejected', $rejectedApplications, '#ef4444'],
            ] as [$label, $count, $barColor])
            <div style="display: flex; align-items: center; gap: 0.625rem;">
                <span style="width: 5rem; font-size: 0.75rem; font-weight: 600; flex-shrink: 0; color: {{ $barColor }};">{{ $label }}</span>
                <div style="flex: 1; height: 0.625rem; border-radius: 9999px; background: #f3f4f6; overflow: hidden;">
                    <div style="height: 100%; border-radius: 9999px; transition: all 0.5s; width: {{ $maxApp > 0 ? ($count / $maxApp) * 100 : 0 }}%; background: {{ $barColor }};"></div>
                </div>
                <span style="width: 2rem; font-size: 0.75rem; font-weight: 700; color: #4b5563; text-align: right; flex-shrink: 0;">{{ $count }}</span>
            </div>
            @endforeach
        </div>
    </x-filament::section>

    {{-- ============ EARNINGS & REVIEWS (side by side) ============ --}}
    <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 1.5rem;">

        {{-- Earnings --}}
        <x-filament::section heading="Earnings Overview" icon="heroicon-o-banknotes">
            <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 0.75rem; margin-bottom: 1.25rem;">
                <div style="border-radius: 0.75rem; padding: 1.25rem; color: white; background: linear-gradient(135deg, #059669 0%, #10b981 100%);">
                    <div style="font-size: 1.5rem; font-weight: 800;">RM {{ number_format($totalEarnings, 2) }}</div>
                    <div style="font-size: 0.75rem; font-weight: 500; margin-top: 0.25rem; opacity: 0.8;">Total Earnings</div>
                </div>
                <div style="border-radius: 0.75rem; padding: 1.25rem; color: white; background: linear-gradient(135deg, #1B2A4A 0%, #2d4a7a 100%);">
                    <div style="font-size: 1.5rem; font-weight: 800;">RM {{ number_format($avgJobFee, 0) }}</div>
                    <div style="font-size: 0.75rem; font-weight: 500; margin-top: 0.25rem; opacity: 0.8;">Avg Job Fee</div>
                </div>
            </div>

            {{-- Job type breakdown --}}
            <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 0.75rem;">
                <div style="border-radius: 0.75rem; border: 1px solid rgba(59,130,246,0.2); padding: 1rem; text-align: center; background: rgba(59,130,246,0.06);">
                    <div style="font-size: 1.5rem; font-weight: 700; color: #3b82f6;">{{ $inboundAccepted }}</div>
                    <div style="font-size: 0.75rem; color: #6b7280; margin-top: 0.25rem;">Inbound Jobs</div>
                </div>
                <div style="border-radius: 0.75rem; border: 1px solid rgba(212,168,67,0.2); padding: 1rem; text-align: center; background: rgba(212,168,67,0.06);">
                    <div style="font-size: 1.5rem; font-weight: 700; color: #D4A843;">{{ $outboundAccepted }}</div>
                    <div style="font-size: 0.75rem; color: #6b7280; margin-top: 0.25rem;">Outbound Jobs</div>
                </div>
            </div>
        </x-filament::section>

        {{-- Reviews --}}
        <x-filament::section heading="My Reviews" icon="heroicon-o-star">
            <div style="display: flex; align-items: center; gap: 1.5rem; margin-bottom: 1.25rem;">
                {{-- Rating ring --}}
                <div style="position: relative; height: 7rem; width: 7rem; flex-shrink: 0;">
                    <svg style="height: 7rem; width: 7rem; transform: rotate(-90deg);" viewBox="0 0 36 36">
                        <path d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831"
                              fill="none" stroke-width="3.5" style="stroke: rgba(156,163,175,0.2);"/>
                        <path d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831"
                              fill="none" stroke-width="3.5" style="stroke: #D4A843;"
                              stroke-dasharray="{{ ($avgRating / 5) * 100 }}, 100" stroke-linecap="round"/>
                    </svg>
                    <div style="position: absolute; inset: 0; display: flex; flex-direction: column; align-items: center; justify-content: center;">
                        <span style="font-size: 1.25rem; font-weight: 800; color: #D4A843;">{{ number_format($avgRating, 1) }}</span>
                        <span style="font-size: 10px; color: #6b7280;">out of 5</span>
                    </div>
                </div>
                <div style="flex: 1;">
                    <div style="font-size: 0.875rem; color: #4b5563; margin-bottom: 0.5rem;">
                        <span style="font-weight: 700; color: #1f2937;">{{ $totalReviews }}</span> reviews received
                    </div>
                    <div style="font-size: 0.875rem; color: #D4A843;">
                        {{ str_repeat('★', round($avgRating)) }}{{ str_repeat('☆', 5 - round($avgRating)) }}
                    </div>
                </div>
            </div>

            {{-- Rating distribution --}}
            <div style="display: flex; flex-direction: column; gap: 0.5rem;">
                @php $maxRating = max(max($ratingDistribution), 1); @endphp
                @foreach($ratingDistribution as $stars => $count)
                <div style="display: flex; align-items: center; gap: 0.5rem;">
                    <span style="width: 3rem; font-size: 0.75rem; font-weight: 600; color: #D4A843; flex-shrink: 0;">{{ $stars }} {{ str_repeat('★', 1) }}</span>
                    <div style="flex: 1; height: 0.5rem; border-radius: 9999px; background: #f3f4f6; overflow: hidden;">
                        <div style="height: 100%; border-radius: 9999px; background: #D4A843; width: {{ ($count / $maxRating) * 100 }}%;"></div>
                    </div>
                    <span style="width: 1.5rem; font-size: 0.75rem; font-weight: 700; color: #4b5563; text-align: right; flex-shrink: 0;">{{ $count }}</span>
                </div>
                @endforeach
            </div>
        </x-filament::section>
    </div>

    {{-- ============ MONTHLY APPLICATIONS ============ --}}
    @if($monthlyApplications->sum('applied') > 0)
    <x-filament::section heading="Monthly Applications" icon="heroicon-o-calendar">
        <div style="display: flex; flex-direction: column; gap: 0.625rem;">
            @php $maxMonthly = max($monthlyApplications->max('applied'), 1); @endphp
            @foreach($monthlyApplications as $row)
                <div style="display: flex; align-items: center; gap: 0.75rem;">
                    <span style="width: 5rem; font-size: 0.75rem; font-weight: 500; color: #6b7280; flex-shrink: 0;">{{ $row['month'] }}</span>
                    <div style="flex: 1; display: flex; gap: 2px; height: 1.75rem;">
                        @if($row['applied'] > 0)
                        <div style="height: 100%; border-radius: 0.375rem 0 0 0.375rem; display: flex; align-items: center; justify-content: center; font-size: 0.75rem; color: white; font-weight: 600; padding: 0 0.5rem; width: {{ max(($row['applied'] / $maxMonthly) * 100, 15) }}%; background: #1B2A4A;">
                            {{ $row['applied'] }}
                        </div>
                        @endif
                        @if($row['accepted'] > 0)
                        <div style="height: 100%; border-radius: 0 0.375rem 0.375rem 0; display: flex; align-items: center; justify-content: center; font-size: 0.75rem; color: white; font-weight: 600; padding: 0 0.5rem; width: {{ max(($row['accepted'] / $maxMonthly) * 100, 15) }}%; background: #22c55e;">
                            {{ $row['accepted'] }}
                        </div>
                        @endif
                        @if($row['applied'] === 0)
                        <div style="height: 100%; border-radius: 0.375rem; background: #f3f4f6; flex: 1;"></div>
                        @endif
                    </div>
                    <span style="width: 2rem; font-size: 0.75rem; font-weight: 700; color: #4b5563; text-align: right; flex-shrink: 0;">{{ $row['applied'] }}</span>
                </div>
            @endforeach
        </div>
        <div style="display: flex; gap: 1.25rem; margin-top: 0.75rem; font-size: 0.75rem; color: #6b7280;">
            <span style="display: flex; align-items: center; gap: 0.375rem;"><span style="display: inline-block; width: 0.75rem; height: 0.75rem; border-radius: 0.25rem; background: #1B2A4A;"></span> Applied</span>
            <span style="display: flex; align-items: center; gap: 0.375rem;"><span style="display: inline-block; width: 0.75rem; height: 0.75rem; border-radius: 0.25rem; background: #22c55e;"></span> Accepted</span>
        </div>
    </x-filament::section>
    @endif

    {{-- ============ LEADERBOARDS ============ --}}
    <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 1.5rem;">

        {{-- Top Agencies --}}
        <x-filament::section heading="Agencies I've Worked With" icon="heroicon-o-building-office">
            @forelse($topAgencies as $i => $app)
                <div style="display: flex; align-items: center; gap: 0.75rem; padding: 0.75rem 0; {{ !$loop->last ? 'border-bottom: 1px solid #f3f4f6;' : '' }}">
                    @php
                        $rankColors = [
                            0 => ['bg' => 'linear-gradient(135deg, #D4A843, #b8922e)', 'text' => 'white'],
                            1 => ['bg' => 'linear-gradient(135deg, #94a3b8, #64748b)', 'text' => 'white'],
                            2 => ['bg' => 'linear-gradient(135deg, #c2844a, #a3703f)', 'text' => 'white'],
                        ];
                        $rstyle = $rankColors[$i] ?? null;
                    @endphp
                    <div style="display: flex; height: 2.25rem; width: 2.25rem; align-items: center; justify-content: center; border-radius: 9999px; font-size: 0.75rem; font-weight: 700; flex-shrink: 0; {{ $rstyle ? 'background: ' . $rstyle['bg'] . '; color: ' . $rstyle['text'] . ';' : 'background: #f3f4f6; color: #6b7280;' }}">
                        {{ $i + 1 }}
                    </div>
                    <div style="flex: 1; min-width: 0;">
                        <div style="font-size: 0.875rem; font-weight: 600; color: #1f2937; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">{{ $app->tourJob->agency->name ?? 'Unknown' }}</div>
                    </div>
                    <span style="display: inline-flex; align-items: center; border-radius: 9999px; padding: 0.25rem 0.625rem; font-size: 0.75rem; font-weight: 700; background: rgba(34,197,94,0.1); color: #16a34a;">
                        {{ $app->accepted_count }} jobs
                    </span>
                </div>
            @empty
                <div style="text-align: center; padding: 1.5rem 0;">
                    <div style="color: #9ca3af; font-size: 0.875rem;">No accepted jobs yet</div>
                </div>
            @endforelse
        </x-filament::section>

        {{-- Top Locations --}}
        <x-filament::section heading="My Top Locations" icon="heroicon-o-map-pin">
            @php $maxLoc = $topLocations->max('job_count') ?: 1; @endphp
            @forelse($topLocations as $loc)
                <div style="display: flex; align-items: center; gap: 0.625rem; padding: 0.375rem 0;">
                    <span style="flex: 1; font-size: 0.875rem; font-weight: 500; color: #374151; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">{{ $loc->location }}</span>
                    <div style="width: 6rem; height: 0.625rem; border-radius: 9999px; background: #f3f4f6; overflow: hidden; flex-shrink: 0;">
                        <div style="height: 100%; border-radius: 9999px; width: {{ ($loc->job_count / $maxLoc) * 100 }}%; background: #1B2A4A;"></div>
                    </div>
                    <span style="font-size: 0.75rem; font-weight: 700; color: #4b5563; width: 1.5rem; text-align: right; flex-shrink: 0;">{{ $loc->job_count }}</span>
                </div>
            @empty
                <div style="text-align: center; padding: 1rem 0;">
                    <div style="color: #9ca3af; font-size: 0.875rem;">No locations yet</div>
                </div>
            @endforelse
        </x-filament::section>
    </div>

</x-filament-panels::page>
