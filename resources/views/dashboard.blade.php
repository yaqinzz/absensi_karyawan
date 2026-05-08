<x-app-layout>
    <x-slot name="header">
        <h2 class="font-h2 text-h2 font-semibold text-on-surface">Dashboard Overview</h2>
    </x-slot>

    <!-- Statistics Bento Grid -->
    <section class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-lg">
        <!-- Total Employees -->
        <div class="bg-surface-container-lowest p-lg rounded-xl border border-outline-variant hover:shadow-md transition-shadow">
            <div class="flex justify-between items-start mb-md">
                <div class="p-sm bg-primary-fixed rounded-lg text-primary">
                    <span class="material-symbols-outlined">group</span>
                </div>
                <span class="text-on-secondary-container bg-secondary-container px-sm py-base rounded text-xs font-bold">+12%</span>
            </div>
            <p class="text-on-surface-variant text-body-md mb-base">Total Employees</p>
            <h3 class="font-h1 text-h1 text-on-surface">1,248</h3>
        </div>
        
        <!-- Present Today -->
        <div class="bg-surface-container-lowest p-lg rounded-xl border border-outline-variant hover:shadow-md transition-shadow">
            <div class="flex justify-between items-start mb-md">
                <div class="p-sm bg-secondary-container text-on-secondary-fixed-variant rounded-lg">
                    <span class="material-symbols-outlined">check_circle</span>
                </div>
                <span class="text-on-surface-variant text-xs">Today</span>
            </div>
            <p class="text-on-surface-variant text-body-md mb-base">Present Today</p>
            <h3 class="font-h1 text-h1 text-on-surface">1,102</h3>
        </div>
        
        <!-- Late Today -->
        <div class="bg-surface-container-lowest p-lg rounded-xl border border-outline-variant hover:shadow-md transition-shadow">
            <div class="flex justify-between items-start mb-md">
                <div class="p-sm bg-tertiary-fixed text-on-tertiary-fixed-variant rounded-lg">
                    <span class="material-symbols-outlined">schedule</span>
                </div>
                <span class="text-error bg-error-container px-sm py-base rounded text-xs font-bold">+3%</span>
            </div>
            <p class="text-on-surface-variant text-body-md mb-base">Late Today</p>
            <h3 class="font-h1 text-h1 text-on-surface">45</h3>
        </div>
        
        <!-- Total Payroll -->
        <div class="bg-surface-container-lowest p-lg rounded-xl border border-outline-variant hover:shadow-md transition-shadow">
            <div class="flex justify-between items-start mb-md">
                <div class="p-sm bg-primary-container text-on-primary-container rounded-lg">
                    <span class="material-symbols-outlined">payments</span>
                </div>
                <span class="text-on-surface-variant text-xs">Monthly</span>
            </div>
            <p class="text-on-surface-variant text-body-md mb-base">Total Payroll</p>
            <h3 class="font-h1 text-h1 text-on-surface">Rp 4.28 M</h3>
        </div>
    </section>

    <!-- Main Insights Layout -->
    <section class="grid grid-cols-1 lg:grid-cols-3 gap-lg mt-lg">
        <!-- Recent Attendance Table -->
        <div class="lg:col-span-2 bg-surface-container-lowest rounded-xl border border-outline-variant overflow-hidden">
            <div class="px-lg py-md border-b border-outline-variant flex justify-between items-center">
                <h3 class="font-h3 text-h3 text-on-surface">Recent Attendance</h3>
                <button class="text-primary font-semibold text-body-md hover:underline">View All</button>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left font-data-table border-collapse">
                    <thead>
                        <tr class="bg-surface-container-low text-on-surface-variant border-b border-outline-variant">
                            <th class="px-lg py-md font-bold text-label-caps">EMPLOYEE NAME</th>
                            <th class="px-lg py-md font-bold text-label-caps">DEPARTMENT</th>
                            <th class="px-lg py-md font-bold text-label-caps">CHECK IN</th>
                            <th class="px-lg py-md font-bold text-label-caps">STATUS</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-outline-variant">
                        <tr class="hover:bg-surface-container-low transition-colors group">
                            <td class="px-lg py-md flex items-center gap-sm">
                                <div class="w-8 h-8 rounded-full bg-primary-fixed flex items-center justify-center text-primary font-bold text-xs">JS</div>
                                <span class="font-medium text-on-surface">Jordan Smith</span>
                            </td>
                            <td class="px-lg py-md text-on-surface-variant">Engineering</td>
                            <td class="px-lg py-md text-on-surface-variant">08:52 AM</td>
                            <td class="px-lg py-md">
                                <span class="inline-flex items-center px-sm py-base rounded-full bg-secondary-container text-on-secondary-fixed-variant text-xs font-bold">Present</span>
                            </td>
                        </tr>
                        <tr class="hover:bg-surface-container-low transition-colors group">
                            <td class="px-lg py-md flex items-center gap-sm">
                                <div class="w-8 h-8 rounded-full bg-tertiary-fixed flex items-center justify-center text-tertiary font-bold text-xs">MA</div>
                                <span class="font-medium text-on-surface">Maria Alvez</span>
                            </td>
                            <td class="px-lg py-md text-on-surface-variant">Marketing</td>
                            <td class="px-lg py-md text-on-surface-variant">09:15 AM</td>
                            <td class="px-lg py-md">
                                <span class="inline-flex items-center px-sm py-base rounded-full bg-tertiary-fixed text-on-tertiary-fixed-variant text-xs font-bold">Late</span>
                            </td>
                        </tr>
                        <tr class="hover:bg-surface-container-low transition-colors group">
                            <td class="px-lg py-md flex items-center gap-sm">
                                <div class="w-8 h-8 rounded-full bg-surface-variant flex items-center justify-center text-primary font-bold text-xs">RK</div>
                                <span class="font-medium text-on-surface">Robert Kim</span>
                            </td>
                            <td class="px-lg py-md text-on-surface-variant">HR & Admin</td>
                            <td class="px-lg py-md text-on-surface-variant">08:45 AM</td>
                            <td class="px-lg py-md">
                                <span class="inline-flex items-center px-sm py-base rounded-full bg-secondary-container text-on-secondary-fixed-variant text-xs font-bold">Present</span>
                            </td>
                        </tr>
                        <tr class="hover:bg-surface-container-low transition-colors group">
                            <td class="px-lg py-md flex items-center gap-sm">
                                <div class="w-8 h-8 rounded-full bg-error-container flex items-center justify-center text-error font-bold text-xs">LW</div>
                                <span class="font-medium text-on-surface">Linda Wu</span>
                            </td>
                            <td class="px-lg py-md text-on-surface-variant">Sales</td>
                            <td class="px-lg py-md text-on-surface-variant">--:--</td>
                            <td class="px-lg py-md">
                                <span class="inline-flex items-center px-sm py-base rounded-full bg-error-container text-error text-xs font-bold">Absent</span>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Monthly Attendance Trends -->
        <div class="bg-surface-container-lowest rounded-xl border border-outline-variant p-lg flex flex-col">
            <div class="flex justify-between items-center mb-xl">
                <h3 class="font-h3 text-h3 text-on-surface">Attendance Trends</h3>
                <span class="material-symbols-outlined text-outline">more_horiz</span>
            </div>
            <!-- Visual Chart Component -->
            <div class="flex-grow flex items-end justify-between gap-base h-48 mb-lg px-md">
                <div class="w-full bg-primary-container/20 rounded-t-lg relative group">
                    <div class="absolute bottom-0 w-full bg-primary rounded-t-lg h-[45%] transition-all group-hover:h-[50%]"></div>
                    <span class="absolute -bottom-6 left-1/2 -translate-x-1/2 text-[10px] font-bold text-on-surface-variant">JAN</span>
                </div>
                <div class="w-full bg-primary-container/20 rounded-t-lg relative group">
                    <div class="absolute bottom-0 w-full bg-primary rounded-t-lg h-[65%] transition-all group-hover:h-[70%]"></div>
                    <span class="absolute -bottom-6 left-1/2 -translate-x-1/2 text-[10px] font-bold text-on-surface-variant">FEB</span>
                </div>
                <div class="w-full bg-primary-container/20 rounded-t-lg relative group">
                    <div class="absolute bottom-0 w-full bg-primary rounded-t-lg h-[55%] transition-all group-hover:h-[60%]"></div>
                    <span class="absolute -bottom-6 left-1/2 -translate-x-1/2 text-[10px] font-bold text-on-surface-variant">MAR</span>
                </div>
                <div class="w-full bg-primary-container/20 rounded-t-lg relative group">
                    <div class="absolute bottom-0 w-full bg-primary rounded-t-lg h-[85%] transition-all group-hover:h-[90%]"></div>
                    <span class="absolute -bottom-6 left-1/2 -translate-x-1/2 text-[10px] font-bold text-on-surface-variant">APR</span>
                </div>
                <div class="w-full bg-primary-container/20 rounded-t-lg relative group">
                    <div class="absolute bottom-0 w-full bg-primary rounded-t-lg h-[75%] transition-all group-hover:h-[80%]"></div>
                    <span class="absolute -bottom-6 left-1/2 -translate-x-1/2 text-[10px] font-bold text-on-surface-variant">MAY</span>
                </div>
                <div class="w-full bg-primary-container/20 rounded-t-lg relative group">
                    <div class="absolute bottom-0 w-full bg-primary rounded-t-lg h-[92%] transition-all group-hover:h-[95%]"></div>
                    <span class="absolute -bottom-6 left-1/2 -translate-x-1/2 text-[10px] font-bold text-on-surface-variant">JUN</span>
                </div>
            </div>
            <div class="mt-xl space-y-md">
                <div class="flex justify-between items-center text-body-md">
                    <span class="text-on-surface-variant">Avg. Daily Attendance</span>
                    <span class="font-bold">94.2%</span>
                </div>
                <div class="w-full bg-surface-container-low h-2 rounded-full overflow-hidden">
                    <div class="bg-secondary h-full w-[94.2%]"></div>
                </div>
                <p class="text-xs text-on-surface-variant italic">System processed 24,582 logs this month.</p>
            </div>
        </div>
    </section>

    <!-- Bottom Quick Actions -->
    <section class="grid grid-cols-1 md:grid-cols-2 gap-lg mt-lg">
        <!-- System Notifications Card -->
        <div class="p-lg bg-surface-container-low rounded-xl flex items-center gap-lg border border-outline-variant">
            <div class="w-16 h-16 rounded-full bg-on-secondary-fixed flex items-center justify-center shrink-0">
                <span class="material-symbols-outlined text-secondary-fixed text-3xl">verified_user</span>
            </div>
            <div>
                <h4 class="font-h3 text-h3 text-on-surface">Security Audit Passed</h4>
                <p class="text-on-surface-variant text-body-md">The last quarterly payroll compliance audit was completed successfully with zero discrepancies found.</p>
            </div>
        </div>
        <!-- Export / Reporting Card -->
        <div class="p-lg bg-primary-container rounded-xl flex items-center justify-between gap-lg text-on-primary-container">
            <div>
                <h4 class="font-h3 text-h3 font-bold">Month-End Summary</h4>
                <p class="opacity-80 text-body-md">Generate the consolidated tax and payroll report for the current fiscal month.</p>
            </div>
            <button class="shrink-0 bg-white text-primary font-bold px-lg py-md rounded-full hover:bg-opacity-90 transition-all flex items-center gap-sm">
                <span class="material-symbols-outlined">download</span>
                Export PDF
            </button>
        </div>
    </section>

    <!-- Floating Action Button for Dashboard -->
    <button class="fixed bottom-lg right-lg w-14 h-14 bg-primary text-on-primary rounded-full shadow-lg flex items-center justify-center hover:scale-105 transition-transform z-50">
        <span class="material-symbols-outlined text-2xl">add</span>
    </button>
</x-app-layout>
