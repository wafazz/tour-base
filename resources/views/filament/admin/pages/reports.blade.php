<x-filament-panels::page>

    {{-- ============ USERS ============ --}}
    <x-filament::section heading="Users" icon="heroicon-o-users">
        <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 1rem; margin-bottom: 1.25rem;">
            <div style="position: relative; overflow: hidden; border-radius: 0.75rem; padding: 1.25rem; color: white; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1); background: linear-gradient(135deg, #1B2A4A 0%, #2d4a7a 100%);">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" style="position: absolute; right: -0.5rem; top: -0.5rem; height: 4rem; width: 4rem; opacity: 0.15;"><path d="M8.25 6.75a3.75 3.75 0 1 1 7.5 0 3.75 3.75 0 0 1-7.5 0ZM15.75 9.75a3 3 0 1 1 6 0 3 3 0 0 1-6 0ZM2.25 9.75a3 3 0 1 1 6 0 3 3 0 0 1-6 0ZM6.31 15.117A6.745 6.745 0 0 1 12 12a6.745 6.745 0 0 1 6.709 7.498.75.75 0 0 1-.372.568A12.696 12.696 0 0 1 12 21.75c-2.305 0-4.47-.612-6.337-1.684a.75.75 0 0 1-.372-.568 6.787 6.787 0 0 1 1.019-4.38Z"/></svg>
                <div style="font-size: 1.875rem; font-weight: 800; letter-spacing: -0.025em;">{{ $totalUsers }}</div>
                <div style="font-size: 0.875rem; font-weight: 500; margin-top: 0.25rem; opacity: 0.8;">Total Users</div>
            </div>
            <div style="position: relative; overflow: hidden; border-radius: 0.75rem; padding: 1.25rem; color: white; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1); background: linear-gradient(135deg, #2563eb 0%, #3b82f6 100%);">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" style="position: absolute; right: -0.5rem; top: -0.5rem; height: 4rem; width: 4rem; opacity: 0.15;"><path fill-rule="evenodd" d="M4.5 3.75a3 3 0 0 0-3 3v10.5a3 3 0 0 0 3 3h15a3 3 0 0 0 3-3V6.75a3 3 0 0 0-3-3h-15Zm4.125 3a2.125 2.125 0 1 0 0 4.25 2.125 2.125 0 0 0 0-4.25Zm-3.873 8.703a4.126 4.126 0 0 1 7.746 0 .75.75 0 0 1-.351.634 7.466 7.466 0 0 1-3.522.888 7.466 7.466 0 0 1-3.522-.888.75.75 0 0 1-.351-.634ZM15 9.75a.75.75 0 0 0 0 1.5h3.75a.75.75 0 0 0 0-1.5H15ZM14.25 12a.75.75 0 0 1 .75-.75h3.75a.75.75 0 0 1 0 1.5H15a.75.75 0 0 1-.75-.75ZM15 13.5a.75.75 0 0 0 0 1.5h1.5a.75.75 0 0 0 0-1.5H15Z" clip-rule="evenodd"/></svg>
                <div style="font-size: 1.875rem; font-weight: 800; letter-spacing: -0.025em;">{{ $totalGuides }}</div>
                <div style="font-size: 0.875rem; font-weight: 500; margin-top: 0.25rem; opacity: 0.8;">Guides</div>
            </div>
            <div style="position: relative; overflow: hidden; border-radius: 0.75rem; padding: 1.25rem; color: white; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1); background: linear-gradient(135deg, #D4A843 0%, #b8922e 100%);">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" style="position: absolute; right: -0.5rem; top: -0.5rem; height: 4rem; width: 4rem; opacity: 0.15;"><path fill-rule="evenodd" d="M4.5 2.25a.75.75 0 0 0 0 1.5v16.5h-.75a.75.75 0 0 0 0 1.5h16.5a.75.75 0 0 0 0-1.5h-.75V3.75a.75.75 0 0 0 0-1.5h-15ZM9 6a.75.75 0 0 0 0 1.5h1.5a.75.75 0 0 0 0-1.5H9Zm-.75 3.75A.75.75 0 0 1 9 9h1.5a.75.75 0 0 1 0 1.5H9a.75.75 0 0 1-.75-.75ZM9 12a.75.75 0 0 0 0 1.5h1.5a.75.75 0 0 0 0-1.5H9Zm3.75-5.25A.75.75 0 0 1 13.5 6H15a.75.75 0 0 1 0 1.5h-1.5a.75.75 0 0 1-.75-.75ZM13.5 9a.75.75 0 0 0 0 1.5H15a.75.75 0 0 0 0-1.5h-1.5Zm-.75 3.75a.75.75 0 0 1 .75-.75H15a.75.75 0 0 1 0 1.5h-1.5a.75.75 0 0 1-.75-.75ZM9 19.5v-2.25a.75.75 0 0 1 .75-.75h4.5a.75.75 0 0 1 .75.75v2.25H9Z" clip-rule="evenodd"/></svg>
                <div style="font-size: 1.875rem; font-weight: 800; letter-spacing: -0.025em;">{{ $totalAgencies }}</div>
                <div style="font-size: 0.875rem; font-weight: 500; margin-top: 0.25rem; opacity: 0.8;">Agencies</div>
            </div>
            <div style="position: relative; overflow: hidden; border-radius: 0.75rem; padding: 1.25rem; color: white; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1); background: linear-gradient(135deg, #059669 0%, #10b981 100%);">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" style="position: absolute; right: -0.5rem; top: -0.5rem; height: 4rem; width: 4rem; opacity: 0.15;"><path fill-rule="evenodd" d="M15.22 6.268a.75.75 0 0 1 .968-.431l5.942 2.28a.75.75 0 0 1 .431.97l-2.28 5.94a.75.75 0 1 1-1.4-.537l1.63-4.251-1.086.484a11.2 11.2 0 0 0-5.45 5.173.75.75 0 0 1-1.199.19L9 12.312l-6.22 6.22a.75.75 0 0 1-1.06-1.061l6.75-6.75a.75.75 0 0 1 1.06 0l3.606 3.606a12.695 12.695 0 0 1 5.68-4.974l1.086-.483-4.251-1.632a.75.75 0 0 1-.43-.969Z" clip-rule="evenodd"/></svg>
                <div style="font-size: 1.875rem; font-weight: 800; letter-spacing: -0.025em;">{{ $newUsersThisMonth }}</div>
                <div style="font-size: 0.875rem; font-weight: 500; margin-top: 0.25rem; opacity: 0.8;">New This Month</div>
            </div>
        </div>

        {{-- User status breakdown --}}
        <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 0.75rem; margin-bottom: 1.25rem;">
            <div style="display: flex; align-items: center; gap: 0.75rem; border-radius: 0.75rem; border: 1px solid rgba(34,197,94,0.2); padding: 1rem; background: rgba(34,197,94,0.06);">
                <div style="display: flex; height: 2.5rem; width: 2.5rem; align-items: center; justify-content: center; border-radius: 9999px; background: rgba(34,197,94,0.15);">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" style="height: 1.25rem; width: 1.25rem; color: #22c55e;"><path fill-rule="evenodd" d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12Zm13.36-1.814a.75.75 0 1 0-1.22-.872l-3.236 4.53L9.53 12.22a.75.75 0 0 0-1.06 1.06l2.25 2.25a.75.75 0 0 0 1.14-.094l3.75-5.25Z" clip-rule="evenodd"/></svg>
                </div>
                <div>
                    <div style="font-size: 1.25rem; font-weight: 700; color: #16a34a;">{{ $approvedUsers }}</div>
                    <div style="font-size: 0.75rem; color: #6b7280;">Approved</div>
                </div>
            </div>
            <div style="display: flex; align-items: center; gap: 0.75rem; border-radius: 0.75rem; border: 1px solid rgba(245,158,11,0.2); padding: 1rem; background: rgba(245,158,11,0.06);">
                <div style="display: flex; height: 2.5rem; width: 2.5rem; align-items: center; justify-content: center; border-radius: 9999px; background: rgba(245,158,11,0.15);">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" style="height: 1.25rem; width: 1.25rem; color: #f59e0b;"><path fill-rule="evenodd" d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25ZM12.75 6a.75.75 0 0 0-1.5 0v6c0 .414.336.75.75.75h4.5a.75.75 0 0 0 0-1.5h-3.75V6Z" clip-rule="evenodd"/></svg>
                </div>
                <div>
                    <div style="font-size: 1.25rem; font-weight: 700; color: #d97706;">{{ $pendingUsers }}</div>
                    <div style="font-size: 0.75rem; color: #6b7280;">Pending</div>
                </div>
            </div>
            <div style="display: flex; align-items: center; gap: 0.75rem; border-radius: 0.75rem; border: 1px solid rgba(239,68,68,0.2); padding: 1rem; background: rgba(239,68,68,0.06);">
                <div style="display: flex; height: 2.5rem; width: 2.5rem; align-items: center; justify-content: center; border-radius: 9999px; background: rgba(239,68,68,0.15);">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" style="height: 1.25rem; width: 1.25rem; color: #ef4444;"><path fill-rule="evenodd" d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25Zm-1.72 6.97a.75.75 0 1 0-1.06 1.06L10.94 12l-1.72 1.72a.75.75 0 1 0 1.06 1.06L12 13.06l1.72 1.72a.75.75 0 1 0 1.06-1.06L13.06 12l1.72-1.72a.75.75 0 1 0-1.06-1.06L12 10.94l-1.72-1.72Z" clip-rule="evenodd"/></svg>
                </div>
                <div>
                    <div style="font-size: 1.25rem; font-weight: 700; color: #dc2626;">{{ $rejectedUsers }}</div>
                    <div style="font-size: 0.75rem; color: #6b7280;">Rejected</div>
                </div>
            </div>
        </div>

        {{-- Monthly Registrations --}}
        @if($monthlyRegistrations->sum('total') > 0)
        <div>
            <h4 style="font-size: 0.875rem; font-weight: 600; color: #4b5563; margin-bottom: 0.75rem;">Monthly Registrations</h4>
            <div style="display: flex; flex-direction: column; gap: 0.625rem;">
                @php $maxReg = max($monthlyRegistrations->max('total'), 1); @endphp
                @foreach($monthlyRegistrations as $row)
                    <div style="display: flex; align-items: center; gap: 0.75rem;">
                        <span style="width: 5rem; font-size: 0.75rem; font-weight: 500; color: #6b7280; flex-shrink: 0;">{{ $row['month'] }}</span>
                        <div style="flex: 1; display: flex; gap: 2px; height: 1.75rem;">
                            @if($row['guides'] > 0)
                            <div style="height: 100%; border-radius: 0.375rem 0 0 0.375rem; display: flex; align-items: center; justify-content: center; font-size: 0.75rem; color: white; font-weight: 600; padding: 0 0.5rem; width: {{ max(($row['guides'] / $maxReg) * 100, 12) }}%; background: #3b82f6;">
                                {{ $row['guides'] }}
                            </div>
                            @endif
                            @if($row['agencies'] > 0)
                            <div style="height: 100%; border-radius: 0 0.375rem 0.375rem 0; display: flex; align-items: center; justify-content: center; font-size: 0.75rem; color: white; font-weight: 600; padding: 0 0.5rem; width: {{ max(($row['agencies'] / $maxReg) * 100, 12) }}%; background: #D4A843;">
                                {{ $row['agencies'] }}
                            </div>
                            @endif
                            @if($row['total'] === 0)
                            <div style="height: 100%; border-radius: 0.375rem; background: #f3f4f6; flex: 1;"></div>
                            @endif
                        </div>
                        <span style="width: 2rem; font-size: 0.75rem; font-weight: 700; color: #4b5563; text-align: right; flex-shrink: 0;">{{ $row['total'] }}</span>
                    </div>
                @endforeach
            </div>
            <div style="display: flex; gap: 1.25rem; margin-top: 0.75rem; font-size: 0.75rem; color: #6b7280;">
                <span style="display: flex; align-items: center; gap: 0.375rem;"><span style="display: inline-block; width: 0.75rem; height: 0.75rem; border-radius: 0.25rem; background: #3b82f6;"></span> Guides</span>
                <span style="display: flex; align-items: center; gap: 0.375rem;"><span style="display: inline-block; width: 0.75rem; height: 0.75rem; border-radius: 0.25rem; background: #D4A843;"></span> Agencies</span>
            </div>
        </div>
        @endif
    </x-filament::section>

    {{-- ============ JOBS & APPLICATIONS (side by side) ============ --}}
    <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 1.5rem;">

        {{-- Jobs Overview --}}
        <x-filament::section heading="Jobs Overview" icon="heroicon-o-briefcase">
            <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 0.75rem; margin-bottom: 1.25rem;">
                <div style="border-radius: 0.75rem; border: 1px solid #e5e7eb; padding: 1rem; text-align: center;">
                    <div style="font-size: 1.875rem; font-weight: 800; color: #1f2937;">{{ $totalJobs }}</div>
                    <div style="font-size: 0.75rem; color: #6b7280; margin-top: 0.25rem;">Total Jobs</div>
                </div>
                <div style="border-radius: 0.75rem; padding: 1rem; text-align: center; background: linear-gradient(135deg, #1B2A4A 0%, #2d4a7a 100%); color: white;">
                    <div style="font-size: 1.875rem; font-weight: 800;">RM {{ number_format($avgFee, 0) }}</div>
                    <div style="font-size: 0.75rem; font-weight: 500; margin-top: 0.25rem; opacity: 0.8;">Avg Fee</div>
                </div>
            </div>

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
    </div>

    {{-- ============ REVENUE ============ --}}
    <x-filament::section heading="Revenue & Invoices" icon="heroicon-o-banknotes">
        <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 1rem; margin-bottom: 1.5rem;">
            <div style="position: relative; overflow: hidden; border-radius: 0.75rem; padding: 1.25rem; color: white; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1); background: linear-gradient(135deg, #059669 0%, #10b981 100%);">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" style="position: absolute; right: -0.5rem; top: -0.5rem; height: 4rem; width: 4rem; opacity: 0.15;"><path d="M12 7.5a2.25 2.25 0 1 0 0 4.5 2.25 2.25 0 0 0 0-4.5Z"/><path fill-rule="evenodd" d="M1.5 4.875C1.5 3.839 2.34 3 3.375 3h17.25c1.035 0 1.875.84 1.875 1.875v12.75c0 1.035-.84 1.875-1.875 1.875H3.375A1.875 1.875 0 0 1 1.5 17.625V4.875ZM12 9.75a.75.75 0 0 0 0 1.5h.008a.75.75 0 0 0 0-1.5H12Z" clip-rule="evenodd"/></svg>
                <div style="font-size: 1.5rem; font-weight: 800; letter-spacing: -0.025em;">RM {{ number_format($totalRevenue, 2) }}</div>
                <div style="font-size: 0.75rem; font-weight: 500; margin-top: 0.25rem; opacity: 0.8;">Total Revenue</div>
            </div>
            <div style="position: relative; overflow: hidden; border-radius: 0.75rem; padding: 1.25rem; color: white; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1); background: linear-gradient(135deg, #d97706 0%, #f59e0b 100%);">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" style="position: absolute; right: -0.5rem; top: -0.5rem; height: 4rem; width: 4rem; opacity: 0.15;"><path fill-rule="evenodd" d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25ZM12.75 6a.75.75 0 0 0-1.5 0v6c0 .414.336.75.75.75h4.5a.75.75 0 0 0 0-1.5h-3.75V6Z" clip-rule="evenodd"/></svg>
                <div style="font-size: 1.5rem; font-weight: 800; letter-spacing: -0.025em;">RM {{ number_format($pendingRevenue, 2) }}</div>
                <div style="font-size: 0.75rem; font-weight: 500; margin-top: 0.25rem; opacity: 0.8;">Pending Revenue</div>
            </div>
            <div style="position: relative; overflow: hidden; border-radius: 0.75rem; padding: 1.25rem; color: white; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1); background: linear-gradient(135deg, #1B2A4A 0%, #2d4a7a 100%);">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" style="position: absolute; right: -0.5rem; top: -0.5rem; height: 4rem; width: 4rem; opacity: 0.15;"><path fill-rule="evenodd" d="M5.625 1.5c-1.036 0-1.875.84-1.875 1.875v17.25c0 1.035.84 1.875 1.875 1.875h12.75c1.035 0 1.875-.84 1.875-1.875V12.75A3.75 3.75 0 0 0 16.5 9h-1.875a1.875 1.875 0 0 1-1.875-1.875V5.25A3.75 3.75 0 0 0 9 1.5H5.625Z" clip-rule="evenodd"/></svg>
                <div style="font-size: 1.5rem; font-weight: 800; letter-spacing: -0.025em;">{{ $totalInvoices }}</div>
                <div style="font-size: 0.75rem; font-weight: 500; margin-top: 0.25rem; opacity: 0.8;">Total Invoices</div>
            </div>
            <div style="position: relative; overflow: hidden; border-radius: 0.75rem; padding: 1.25rem; color: white; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1); background: linear-gradient(135deg, #7c3aed 0%, #8b5cf6 100%);">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" style="position: absolute; right: -0.5rem; top: -0.5rem; height: 4rem; width: 4rem; opacity: 0.15;"><path fill-rule="evenodd" d="M2.25 13.5a8.25 8.25 0 0 1 8.25-8.25.75.75 0 0 1 .75.75v6.75H18a.75.75 0 0 1 .75.75 8.25 8.25 0 0 1-16.5 0Z" clip-rule="evenodd"/><path fill-rule="evenodd" d="M12.75 3a.75.75 0 0 1 .75-.75 8.25 8.25 0 0 1 8.25 8.25.75.75 0 0 1-.75.75h-7.5a.75.75 0 0 1-.75-.75V3Z" clip-rule="evenodd"/></svg>
                <div style="font-size: 1.5rem; font-weight: 800; letter-spacing: -0.025em;">{{ $collectionRate }}%</div>
                <div style="font-size: 0.75rem; font-weight: 500; margin-top: 0.25rem; opacity: 0.8;">Collection Rate</div>
            </div>
        </div>

        {{-- Monthly Revenue Table --}}
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

        {{-- Top Agencies --}}
        <x-filament::section heading="Top Agencies" icon="heroicon-o-building-office">
            @forelse($topAgencies as $i => $agency)
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
                        <div style="font-size: 0.875rem; font-weight: 600; color: #1f2937; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">{{ $agency->name }}</div>
                    </div>
                    <span style="display: inline-flex; align-items: center; border-radius: 9999px; padding: 0.25rem 0.625rem; font-size: 0.75rem; font-weight: 700; background: rgba(27,42,74,0.1); color: #1B2A4A;">
                        {{ $agency->tour_jobs_count }} jobs
                    </span>
                </div>
            @empty
                <div style="text-align: center; padding: 1.5rem 0;">
                    <div style="color: #9ca3af; font-size: 0.875rem;">No agencies yet</div>
                </div>
            @endforelse
        </x-filament::section>

        {{-- Top Guides --}}
        <x-filament::section heading="Top Guides" icon="heroicon-o-trophy">
            @forelse($topGuides as $i => $guide)
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
                        <div style="font-size: 0.875rem; font-weight: 600; color: #1f2937; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">{{ $guide->name }}</div>
                        <div style="font-size: 0.75rem; color: #6b7280;">
                            {{ $guide->total_apps }} applied
                            @if($guide->reviews_received_avg_rating)
                                <span style="color: #D4A843;"> &middot; {{ str_repeat('★', round($guide->reviews_received_avg_rating)) }}</span>
                                <span style="color: #9ca3af;">{{ number_format($guide->reviews_received_avg_rating, 1) }}</span>
                            @endif
                        </div>
                    </div>
                    <span style="display: inline-flex; align-items: center; border-radius: 9999px; padding: 0.25rem 0.625rem; font-size: 0.75rem; font-weight: 700; background: rgba(34,197,94,0.1); color: #16a34a;">
                        {{ $guide->accepted_count }}
                    </span>
                </div>
            @empty
                <div style="text-align: center; padding: 1.5rem 0;">
                    <div style="color: #9ca3af; font-size: 0.875rem;">No guides yet</div>
                </div>
            @endforelse
        </x-filament::section>

        {{-- Locations & Reviews --}}
        <div style="display: flex; flex-direction: column; gap: 1.5rem;">
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

            <x-filament::section heading="Reviews" icon="heroicon-o-star">
                <div style="display: flex; align-items: center; gap: 1.25rem;">
                    <div style="text-align: center;">
                        <div style="font-size: 2.25rem; font-weight: 800; color: #D4A843;">{{ number_format($avgRating, 1) }}</div>
                        <div style="margin-top: 0.25rem; font-size: 0.875rem; color: #D4A843;">
                            {{ str_repeat('★', round($avgRating)) }}{{ str_repeat('☆', 5 - round($avgRating)) }}
                        </div>
                    </div>
                    <div>
                        <div style="font-size: 0.875rem; color: #4b5563;">
                            <span style="font-weight: 700; color: #1f2937;">{{ $totalReviews }}</span> total reviews
                        </div>
                        <div style="font-size: 0.75rem; color: #6b7280; margin-top: 0.125rem;">Average across all guides</div>
                    </div>
                </div>
            </x-filament::section>
        </div>
    </div>

</x-filament-panels::page>
