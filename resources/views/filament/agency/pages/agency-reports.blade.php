<x-filament-panels::page>

    {{-- ============ JOBS OVERVIEW ============ --}}
    <x-filament::section heading="Jobs Overview" icon="heroicon-o-briefcase">
        <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 1rem; margin-bottom: 1.25rem;">
            <div style="position: relative; overflow: hidden; border-radius: 0.75rem; padding: 1.25rem; color: white; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1); background: linear-gradient(135deg, #1B2A4A 0%, #2d4a7a 100%);">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" style="position: absolute; right: -0.5rem; top: -0.5rem; height: 4rem; width: 4rem; opacity: 0.15;"><path fill-rule="evenodd" d="M7.5 5.25a3 3 0 0 1 3-3h3a3 3 0 0 1 3 3v.205c.933.085 1.857.197 2.774.334 1.454.218 2.476 1.483 2.476 2.917v3.033c0 1.211-.734 2.352-1.936 2.752A24.726 24.726 0 0 1 12 15.75c-2.73 0-5.357-.442-7.814-1.259-1.202-.4-1.936-1.541-1.936-2.752V8.706c0-1.434 1.022-2.7 2.476-2.917A48.814 48.814 0 0 1 7.5 5.455V5.25Z" clip-rule="evenodd"/></svg>
                <div style="font-size: 1.875rem; font-weight: 800; letter-spacing: -0.025em;">{{ $totalJobs }}</div>
                <div style="font-size: 0.875rem; font-weight: 500; margin-top: 0.25rem; opacity: 0.8;">Total Jobs</div>
            </div>
            <div style="position: relative; overflow: hidden; border-radius: 0.75rem; padding: 1.25rem; color: white; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1); background: linear-gradient(135deg, #059669 0%, #10b981 100%);">
                <div style="font-size: 1.875rem; font-weight: 800; letter-spacing: -0.025em;">{{ $activeJobs }}</div>
                <div style="font-size: 0.875rem; font-weight: 500; margin-top: 0.25rem; opacity: 0.8;">Active</div>
            </div>
            <div style="position: relative; overflow: hidden; border-radius: 0.75rem; padding: 1.25rem; color: white; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1); background: linear-gradient(135deg, #d97706 0%, #f59e0b 100%);">
                <div style="font-size: 1.875rem; font-weight: 800; letter-spacing: -0.025em;">{{ $pendingJobs }}</div>
                <div style="font-size: 0.875rem; font-weight: 500; margin-top: 0.25rem; opacity: 0.8;">Pending</div>
            </div>
            <div style="position: relative; overflow: hidden; border-radius: 0.75rem; padding: 1.25rem; color: white; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1); background: linear-gradient(135deg, #D4A843 0%, #b8922e 100%);">
                <div style="font-size: 1.875rem; font-weight: 800; letter-spacing: -0.025em;">RM {{ number_format($avgFee, 0) }}</div>
                <div style="font-size: 0.875rem; font-weight: 500; margin-top: 0.25rem; opacity: 0.8;">Avg Fee</div>
            </div>
        </div>

        {{-- Job status bars --}}
        <div style="display: flex; flex-direction: column; gap: 0.75rem; margin-bottom: 1.25rem;">
            @php $maxJob = max($activeJobs, $pendingJobs, $closedJobs, 1); @endphp
            @foreach([
                ['Active', $activeJobs, '#22c55e'],
                ['Pending', $pendingJobs, '#f59e0b'],
                ['Closed', $closedJobs, '#9ca3af'],
            ] as [$label, $count, $barColor])
            <div>
                <div style="display: flex; justify-content: space-between; font-size: 0.75rem; margin-bottom: 0.375rem;">
                    <span style="font-weight: 600; color: {{ $barColor }};">{{ $label }}</span>
                    <span style="font-weight: 700; color: #374151;">{{ $count }}</span>
                </div>
                <div style="height: 0.75rem; width: 100%; border-radius: 9999px; background: #f3f4f6; overflow: hidden;">
                    <div style="height: 100%; border-radius: 9999px; transition: all 0.5s; width: {{ ($count / $maxJob) * 100 }}%; background: {{ $barColor }};"></div>
                </div>
            </div>
            @endforeach
        </div>

        {{-- Inbound / Outbound --}}
        <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 0.75rem;">
            <div style="border-radius: 0.75rem; border: 1px solid rgba(59,130,246,0.2); padding: 1rem; text-align: center; background: rgba(59,130,246,0.06);">
                <div style="font-size: 1.5rem; font-weight: 700; color: #3b82f6;">{{ $inboundJobs }}</div>
                <div style="font-size: 0.75rem; color: #6b7280; margin-top: 0.25rem;">Inbound</div>
            </div>
            <div style="border-radius: 0.75rem; border: 1px solid rgba(212,168,67,0.2); padding: 1rem; text-align: center; background: rgba(212,168,67,0.06);">
                <div style="font-size: 1.5rem; font-weight: 700; color: #D4A843;">{{ $outboundJobs }}</div>
                <div style="font-size: 0.75rem; color: #6b7280; margin-top: 0.25rem;">Outbound</div>
            </div>
        </div>
    </x-filament::section>

    {{-- ============ APPLICATIONS & REVENUE (side by side) ============ --}}
    <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 1.5rem;">

        {{-- Applications --}}
        <x-filament::section heading="Applications" icon="heroicon-o-paper-airplane">
            <div style="display: flex; align-items: center; gap: 1.5rem; margin-bottom: 1.25rem;">
                {{-- Acceptance rate ring --}}
                <div style="position: relative; height: 7rem; width: 7rem; flex-shrink: 0;">
                    <svg style="height: 7rem; width: 7rem; transform: rotate(-90deg);" viewBox="0 0 36 36">
                        <path d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831"
                              fill="none" stroke-width="3.5" style="stroke: rgba(156,163,175,0.2);"/>
                        <path d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831"
                              fill="none" stroke-width="3.5" style="stroke: #22c55e;"
                              stroke-dasharray="{{ $acceptanceRate }}, 100" stroke-linecap="round"/>
                    </svg>
                    <div style="position: absolute; inset: 0; display: flex; flex-direction: column; align-items: center; justify-content: center;">
                        <span style="font-size: 1.25rem; font-weight: 800; color: #1f2937;">{{ $acceptanceRate }}%</span>
                        <span style="font-size: 10px; color: #6b7280;">Accept Rate</span>
                    </div>
                </div>
                <div style="flex: 1; display: grid; grid-template-columns: repeat(2, 1fr); gap: 0.625rem;">
                    @foreach([
                        ['Total', $totalApplications, '#374151', 'rgba(55,65,81,0.06)', '#6b7280'],
                        ['Pending', $pendingApplications, '#d97706', 'rgba(245,158,11,0.06)', '#f59e0b'],
                        ['Shortlisted', $shortlistedApplications, '#2563eb', 'rgba(59,130,246,0.06)', '#3b82f6'],
                        ['Accepted', $acceptedApplications, '#16a34a', 'rgba(34,197,94,0.06)', '#22c55e'],
                    ] as [$label, $count, $textColor, $bgColor, $borderColor])
                    <div style="border-radius: 0.5rem; border: 1px solid {{ $borderColor }}30; padding: 0.625rem; text-align: center; background: {{ $bgColor }};">
                        <div style="font-size: 1.125rem; font-weight: 700; color: {{ $textColor }};">{{ $count }}</div>
                        <div style="font-size: 10px; color: #6b7280;">{{ $label }}</div>
                    </div>
                    @endforeach
                </div>
            </div>

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

        {{-- Revenue --}}
        <x-filament::section heading="Revenue & Invoices" icon="heroicon-o-banknotes">
            <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 0.75rem; margin-bottom: 1.25rem;">
                <div style="border-radius: 0.75rem; padding: 1rem; color: white; background: linear-gradient(135deg, #059669 0%, #10b981 100%);">
                    <div style="font-size: 1.5rem; font-weight: 800;">RM {{ number_format($totalRevenue, 2) }}</div>
                    <div style="font-size: 0.75rem; font-weight: 500; margin-top: 0.25rem; opacity: 0.8;">Total Paid</div>
                </div>
                <div style="border-radius: 0.75rem; padding: 1rem; color: white; background: linear-gradient(135deg, #d97706 0%, #f59e0b 100%);">
                    <div style="font-size: 1.5rem; font-weight: 800;">RM {{ number_format($pendingRevenue, 2) }}</div>
                    <div style="font-size: 0.75rem; font-weight: 500; margin-top: 0.25rem; opacity: 0.8;">Pending</div>
                </div>
            </div>

            <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 0.75rem; margin-bottom: 1.25rem;">
                <div style="border-radius: 0.75rem; border: 1px solid #e5e7eb; padding: 0.75rem; text-align: center;">
                    <div style="font-size: 1.25rem; font-weight: 700; color: #1f2937;">{{ $totalInvoices }}</div>
                    <div style="font-size: 0.75rem; color: #6b7280;">Total</div>
                </div>
                <div style="border-radius: 0.75rem; border: 1px solid rgba(34,197,94,0.2); padding: 0.75rem; text-align: center; background: rgba(34,197,94,0.06);">
                    <div style="font-size: 1.25rem; font-weight: 700; color: #16a34a;">{{ $paidInvoices }}</div>
                    <div style="font-size: 0.75rem; color: #6b7280;">Paid</div>
                </div>
                <div style="border-radius: 0.75rem; border: 1px solid rgba(245,158,11,0.2); padding: 0.75rem; text-align: center; background: rgba(245,158,11,0.06);">
                    <div style="font-size: 1.25rem; font-weight: 700; color: #d97706;">{{ $pendingInvoiceCount }}</div>
                    <div style="font-size: 0.75rem; color: #6b7280;">Unpaid</div>
                </div>
            </div>

            {{-- Collection rate bar --}}
            <div>
                <div style="display: flex; justify-content: space-between; font-size: 0.75rem; margin-bottom: 0.375rem;">
                    <span style="font-weight: 600; color: #374151;">Collection Rate</span>
                    <span style="font-weight: 700; color: #16a34a;">{{ $collectionRate }}%</span>
                </div>
                <div style="height: 0.75rem; width: 100%; border-radius: 9999px; background: #f3f4f6; overflow: hidden;">
                    <div style="height: 100%; border-radius: 9999px; background: #22c55e; width: {{ $collectionRate }}%;"></div>
                </div>
            </div>
        </x-filament::section>
    </div>

    {{-- ============ MONTHLY REVENUE TABLE ============ --}}
    <x-filament::section heading="Monthly Revenue Breakdown" icon="heroicon-o-table-cells">
        <div style="overflow: hidden; border-radius: 0.75rem; border: 1px solid #e5e7eb;">
            <table style="width: 100%; font-size: 0.875rem; border-collapse: collapse;">
                <thead>
                    <tr style="background: #1B2A4A; color: white;">
                        <th style="padding: 0.75rem 1rem; text-align: left; font-weight: 600; font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.05em;">Month</th>
                        <th style="padding: 0.75rem 1rem; text-align: right; font-weight: 600; font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.05em;">Paid</th>
                        <th style="padding: 0.75rem 1rem; text-align: right; font-weight: 600; font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.05em;">Pending</th>
                        <th style="padding: 0.75rem 1rem; text-align: right; font-weight: 600; font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.05em;">Total</th>
                        <th style="padding: 0.75rem 1rem; text-align: left; font-weight: 600; font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.05em; width: 25%;">Breakdown</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($monthlyRevenue as $row)
                        @php $rowMax = max($row['total'], 1); @endphp
                        <tr style="border-bottom: 1px solid #f3f4f6;">
                            <td style="padding: 0.875rem 1rem; font-weight: 600; color: #374151;">{{ $row['month'] }}</td>
                            <td style="padding: 0.875rem 1rem; text-align: right; font-weight: 600; color: #16a34a;">RM {{ number_format($row['paid'], 2) }}</td>
                            <td style="padding: 0.875rem 1rem; text-align: right; font-weight: 600; color: #d97706;">RM {{ number_format($row['pending'], 2) }}</td>
                            <td style="padding: 0.875rem 1rem; text-align: right; font-weight: 700; color: #1f2937;">RM {{ number_format($row['total'], 2) }}</td>
                            <td style="padding: 0.875rem 1rem;">
                                <div style="display: flex; height: 0.75rem; border-radius: 9999px; overflow: hidden; background: #f3f4f6;">
                                    @if($row['paid'] > 0)
                                        <div style="height: 100%; width: {{ ($row['paid'] / $rowMax) * 100 }}%; background: #22c55e;"></div>
                                    @endif
                                    @if($row['pending'] > 0)
                                        <div style="height: 100%; width: {{ ($row['pending'] / $rowMax) * 100 }}%; background: #f59e0b;"></div>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div style="display: flex; gap: 1.25rem; margin-top: 0.75rem; font-size: 0.75rem; color: #6b7280;">
            <span style="display: flex; align-items: center; gap: 0.375rem;"><span style="display: inline-block; width: 0.75rem; height: 0.75rem; border-radius: 0.25rem; background: #22c55e;"></span> Paid</span>
            <span style="display: flex; align-items: center; gap: 0.375rem;"><span style="display: inline-block; width: 0.75rem; height: 0.75rem; border-radius: 0.25rem; background: #f59e0b;"></span> Pending</span>
        </div>
    </x-filament::section>

    {{-- ============ LEADERBOARDS ============ --}}
    <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 1.5rem;">

        {{-- Top Guides --}}
        <x-filament::section heading="Top Guides" icon="heroicon-o-trophy">
            @forelse($topGuides as $i => $app)
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
                        <div style="font-size: 0.875rem; font-weight: 600; color: #1f2937; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">{{ $app->guide->name ?? 'Unknown' }}</div>
                    </div>
                    <span style="display: inline-flex; align-items: center; border-radius: 9999px; padding: 0.25rem 0.625rem; font-size: 0.75rem; font-weight: 700; background: rgba(34,197,94,0.1); color: #16a34a;">
                        {{ $app->accepted_count }} jobs
                    </span>
                </div>
            @empty
                <div style="text-align: center; padding: 1.5rem 0;">
                    <div style="color: #9ca3af; font-size: 0.875rem;">No accepted guides yet</div>
                </div>
            @endforelse
        </x-filament::section>

        {{-- Top Locations --}}
        <x-filament::section heading="Top Locations" icon="heroicon-o-map-pin">
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

        {{-- Reviews Given --}}
        <x-filament::section heading="Reviews Given" icon="heroicon-o-star">
            <div style="display: flex; align-items: center; gap: 1.25rem;">
                <div style="text-align: center;">
                    <div style="font-size: 2.25rem; font-weight: 800; color: #D4A843;">{{ number_format($avgRating, 1) }}</div>
                    <div style="margin-top: 0.25rem; font-size: 0.875rem; color: #D4A843;">
                        {{ str_repeat('★', round($avgRating)) }}{{ str_repeat('☆', 5 - round($avgRating)) }}
                    </div>
                </div>
                <div>
                    <div style="font-size: 0.875rem; color: #4b5563;">
                        <span style="font-weight: 700; color: #1f2937;">{{ $totalReviews }}</span> reviews given
                    </div>
                    <div style="font-size: 0.75rem; color: #6b7280; margin-top: 0.125rem;">Average rating you've given</div>
                </div>
            </div>
        </x-filament::section>
    </div>

    {{-- ============ MONTHLY ACTIVITY ============ --}}
    @if($monthlyJobs->sum('jobs') > 0 || $monthlyJobs->sum('apps') > 0)
    <x-filament::section heading="Monthly Activity" icon="heroicon-o-calendar">
        <div style="display: flex; flex-direction: column; gap: 0.625rem;">
            @php $maxActivity = max($monthlyJobs->max('apps'), $monthlyJobs->max('jobs'), 1); @endphp
            @foreach($monthlyJobs as $row)
                <div style="display: flex; align-items: center; gap: 0.75rem;">
                    <span style="width: 5rem; font-size: 0.75rem; font-weight: 500; color: #6b7280; flex-shrink: 0;">{{ $row['month'] }}</span>
                    <div style="flex: 1; display: flex; gap: 2px; height: 1.75rem;">
                        @if($row['jobs'] > 0)
                        <div style="height: 100%; border-radius: 0.375rem 0 0 0.375rem; display: flex; align-items: center; justify-content: center; font-size: 0.75rem; color: white; font-weight: 600; padding: 0 0.5rem; width: {{ max(($row['jobs'] / $maxActivity) * 100, 12) }}%; background: #1B2A4A;">
                            {{ $row['jobs'] }}
                        </div>
                        @endif
                        @if($row['apps'] > 0)
                        <div style="height: 100%; border-radius: 0 0.375rem 0.375rem 0; display: flex; align-items: center; justify-content: center; font-size: 0.75rem; color: white; font-weight: 600; padding: 0 0.5rem; width: {{ max(($row['apps'] / $maxActivity) * 100, 12) }}%; background: #D4A843;">
                            {{ $row['apps'] }}
                        </div>
                        @endif
                        @if($row['jobs'] === 0 && $row['apps'] === 0)
                        <div style="height: 100%; border-radius: 0.375rem; background: #f3f4f6; flex: 1;"></div>
                        @endif
                    </div>
                    <span style="width: 2rem; font-size: 0.75rem; font-weight: 700; color: #4b5563; text-align: right; flex-shrink: 0;">{{ $row['jobs'] + $row['apps'] }}</span>
                </div>
            @endforeach
        </div>
        <div style="display: flex; gap: 1.25rem; margin-top: 0.75rem; font-size: 0.75rem; color: #6b7280;">
            <span style="display: flex; align-items: center; gap: 0.375rem;"><span style="display: inline-block; width: 0.75rem; height: 0.75rem; border-radius: 0.25rem; background: #1B2A4A;"></span> Jobs Posted</span>
            <span style="display: flex; align-items: center; gap: 0.375rem;"><span style="display: inline-block; width: 0.75rem; height: 0.75rem; border-radius: 0.25rem; background: #D4A843;"></span> Applications</span>
        </div>
    </x-filament::section>
    @endif

</x-filament-panels::page>
