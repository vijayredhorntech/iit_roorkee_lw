<div>
    <div class="w-full grid xl:grid-cols-5 lg:grid-cols-3 md:grid-cols-4 sm:grid-cols-2 grid-cols-1 gap-2">
        <a href="{{route('lab.list')}}">
            <div class="w-full border-[1px] border-t-[4px] border-ternary/20 border-t-primary bg-white flex gap-2 items-center justify-between p-4">
                <div class="flex flex-col gap-2">
                    <span class="font-semibold text-black text-md">Labs</span>
                    <span class="font-bold text-2xl text-primary">{{$totalLabs}}</span>
                </div>
                <div>
                    <i class="fa-solid fa-flask text-4xl text-primary"></i>
                </div>
            </div>
        </a>

        <!-- Total PIs -->
        <a href="{{route('pi.list')}}">
            <div class="w-full border-[1px] border-t-[4px] border-warning/20 border-t-warning bg-white flex gap-2 items-center justify-between p-4">
                <div class="flex flex-col gap-2">
                    <span class="font-semibold text-black text-md">Principal Investigators</span>
                    <span class="font-bold text-2xl text-warning">{{$totalPis}}</span>
                </div>
                <div>
                    <i class="fa fa-user-tie text-4xl text-warning"></i>
                </div>
            </div>
        </a>

        <!-- Total Students -->
        <a href="{{route('student.list')}}">
            <div class="w-full border-[1px] border-t-[4px] border-success/20 border-t-success bg-white flex gap-2 items-center justify-between p-4">
                <div class="flex flex-col gap-2">
                    <span class="font-semibold text-black text-md">Students</span>
                    <span class="font-bold text-2xl text-success">{{$totalStudents}}</span>
                </div>
                <div>
                    <i class="fa fa-user-graduate text-4xl text-success"></i>
                </div>
            </div>
        </a>

        <!-- Total Categories -->
        <a href="{{route('instrument.instrument-category')}}">
            <div class="w-full border-[1px] border-t-[4px] border-danger/20 border-t-danger bg-white flex gap-2 items-center justify-between p-4">
                <div class="flex flex-col gap-2">
                    <span class="font-semibold text-black text-md">Instrument Categories</span>
                    <span class="font-bold text-2xl text-danger">{{$instrumentCategories}}</span>
                </div>
                <div>
                    <i class="fa fa-list text-4xl text-danger"></i>
                </div>
            </div>
        </a>
        <!-- Total Instruments -->
        <a href="{{route('instrument.instrument')}}">
            <div class="w-full border-[1px] border-t-[4px] border-primary/20 border-t-primary bg-white flex gap-2 items-center justify-between p-4">
                <div class="flex flex-col gap-2">
                    <span class="font-semibold text-black text-md">Instruments</span>
                    <span class="font-bold text-2xl text-primary">{{$totalInstruments}}</span>
                </div>
                <div>
                    <i class="fa fa-microscope text-4xl text-primary"></i>
                </div>
            </div>
        </a>

        <a href="{{route('instrument.instrument')}}">
            <!-- Instruments Not Working -->
            <div class="w-full border-[1px] border-t-[4px] border-warning/20 border-t-warning bg-white flex gap-2 items-center justify-between p-4">
                <div class="flex flex-col gap-2">
                    <span class="font-semibold text-black text-md">Instruments Down</span>
                    <span class="font-bold text-2xl text-warning">{{$instrumentUnderMaintenance}}</span>
                </div>
                <div>
                    <i class="fa fa-battery-quarter text-4xl text-warning"></i>
                </div>
            </div>
        </a>

        <!-- Pending Services -->
        <a href="{{route('instrument.service')}}">
            <div class="w-full border-[1px] border-t-[4px] border-success/20 border-t-success bg-white flex gap-2 items-center justify-between p-4">
                <div class="flex flex-col gap-2">
                    <span class="font-semibold text-black text-md">Under Services</span>
                    <span class="font-bold text-2xl text-success">{{$underService}}</span>
                </div>
                <div>
                    <i class="fa fa-wrench text-4xl text-success"></i>
                </div>
            </div>
        </a>
        <!-- Pending Approvals -->
        <a href="{{route('instrument.complaints')}}">
            <div class="w-full border-[1px] border-t-[4px] border-danger/20 border-t-danger bg-white flex gap-2 items-center justify-between p-4">
                <div class="flex flex-col gap-2">
                    <span class="font-semibold text-black text-md">Complaints</span>
                    <span class="font-bold text-2xl text-danger">{{$totalComplaints}}</span>
                </div>
                <div>
                    <i class="fa fa-exclamation-triangle text-4xl text-danger"></i>
                </div>
            </div>
        </a>
        <!-- Active Bookings -->
        <a href="{{route('bookings.create')}}">
            <div class="w-full border-[1px] border-t-[4px] border-primary/20 border-t-primary bg-white flex gap-2 items-center justify-between p-4">
                <div class="flex flex-col gap-2">
                    <span class="font-semibold text-black text-md">Active Bookings</span>
                    <span class="font-bold text-2xl text-primary"> {{$activeBookings}} </span>
                </div>
                <div>
                    <i class="fa fa-calendar-check text-4xl text-primary"></i>
                </div>
            </div>
        </a>


        <!-- Monthly Collection -->
        <div class="w-full border-[1px] border-t-[4px] border-success/20 border-t-success bg-white flex gap-2 items-center justify-between p-4">
            <div class="flex flex-col gap-2">
                <span class="font-semibold text-black text-md">Collection <span class="text-xs">(This Month)</span></span>
                <span class="font-bold text-2xl text-success">₹{{$thisMonthCollection}}</span>
            </div>
            <div>
                <i class="fa fa-money-bill-trend-up text-4xl text-success"></i>
            </div>
        </div>


    </div>

    <div class="w-full mt-6 border-[1px] border-t-[4px] border-ternary/20 border-t-primary bg-white flex gap-2 flex-col xl:col-span-1 lg:col-span-2 md:col-span-2 ">
        <div class="bg-primary/10 px-4 py-2 border-b-[2px] border-b-primary/20">
            <span class="font-semibold text-ternary text-lg">This Month booking stats</span>
        </div>
        <div class="w-full overflow-x-auto p-4">
            <div id="dayWiseLabBooking"></div>
        </div>
    </div>


    <div class="w-full grid xl:grid-cols-3 lg:grid-cols-3 md:grid-cols-3 grid-cols-1 gap-2 mt-6">
        <div class="w-full border-[1px] border-t-[4px] border-ternary/20 border-t-primary bg-white flex gap-2 flex-col xl:col-span-1 lg:col-span-2 md:col-span-2 ">
            <div class="bg-primary/10 px-4 py-2 border-b-[2px] border-b-primary/20">
                <span class="font-semibold text-primary text-lg">Top Booked Instruments</span>
            </div>
            <div class="w-full overflow-x-auto p-4">
                <div id="topInstrumentsBooked"></div>
            </div>
        </div>
        <div class="w-full border-[1px] border-t-[4px] border-ternary/20 border-t-success bg-white flex gap-2 flex-col ">
            <div class="bg-success/10 px-4 py-2 border-b-[2px] border-b-success/20">
                <span class="font-semibold text-success text-lg">Most Serviced Instruments</span>
            </div>

            <div class="w-full overflow-x-auto p-4">
                <div id="mostServicedInstruments"></div>
            </div>
        </div>
        <div class="w-full border-[1px] border-t-[4px] border-ternary/20 border-t-warning bg-white flex gap-2 flex-col">
            <div class="bg-warning/10 px-4 py-2 border-b-[2px] border-b-warning/20">
                <span class="font-semibold text-warning text-lg">Top Students </span>
            </div>

            <div class="w-full overflow-x-auto p-4">
                <div id="topStudentWithMostBookings"></div>
            </div>
        </div>

    </div>

    <script>
        // Make sure this code is placed at the end of your HTML file or in the right place in your script
        document.addEventListener('DOMContentLoaded', function() {
            // Day-wise booking chart (your existing code)
            document.addEventListener('livewire:initialized', () => {
                const options = {
                    series: [{
                        name: 'Confirmed Bookings',
                        data: @json($dayWiseBookings['confirmed'])
                    },
                        {
                            name: 'Cancelled Bookings',
                            data: @json($dayWiseBookings['cancelled'])
                        }],
                    chart: {
                        type: 'bar',
                        height: 250,
                        toolbar: {
                            show: false
                        }
                    },
                    plotOptions: {
                        bar: {
                            borderRadius: 1,
                            horizontal: false,
                            columnWidth: '70%',
                        }
                    },
                    dataLabels: {
                        enabled: false
                    },
                    xaxis: {
                        categories: @json($dayWiseBookings['dates']),
                        labels: {
                            style: {
                                fontSize: '12px'
                            }
                        }
                    },
                    yaxis: {
                        title: {
                            text: 'Number of Bookings'
                        }
                    },
                    colors: ['#001A6E', '#DC2626'],
                    fill: {
                        opacity: 0.9
                    },
                    legend: {
                        position: 'top'
                    }
                };

                const chart = new ApexCharts(document.querySelector("#dayWiseLabBooking"), options);
                chart.render();

                // Initialize Top Booked Instruments Chart
                initTopBookedInstrumentsChart();

                // Initialize Most Serviced Instruments Chart
                initMostServicedInstrumentsChart();

                // Initialize Top Students Chart
                initTopStudentsChart();

                Livewire.on('refreshDayWiseBookings', () => {
                    chart.updateSeries([{
                        data: @json($dayWiseBookings['confirmed'])
                    },
                        {
                            data: @json($dayWiseBookings['cancelled'])
                        }]);
                    chart.updateOptions({
                        xaxis: {
                            categories: @json($dayWiseBookings['dates'])
                        }
                    });
                });
            });
        });

        // Top Booked Instruments Chart initialization function
        function initTopBookedInstrumentsChart() {
            // Check if element exists and data is available
            if (!document.querySelector("#topInstrumentsBooked")) {
                console.error("Element #topInstrumentsBooked not found");
                return;
            }

            const seriesData = @json(array_column($topBookedInstruments, 'count'));
            const labelsData = @json(array_column($topBookedInstruments, 'name'));

            if (seriesData.length === 0) {
                console.warn("No data available for top booked instruments");
                return;
            }

            const topInstrumentsOptions = {
                series: seriesData,
                chart: {
                    type: 'pie',
                    height: 250
                },
                labels: labelsData,
                colors: ['#001A6E', '#22C55E', '#DC2626'],
                legend: {
                    position: 'bottom'
                },
                tooltip: {
                    y: {
                        formatter: function(value) {
                            return value + ' bookings'
                        }
                    }
                },
                responsive: [{
                    breakpoint: 480,
                    options: {
                        chart: {
                            width: 200
                        },
                        legend: {
                            position: 'bottom'
                        }
                    }
                }]
            };

            try {
                const topInstrumentsChart = new ApexCharts(document.querySelector("#topInstrumentsBooked"), topInstrumentsOptions);
                topInstrumentsChart.render();

                Livewire.on('refreshTopInstruments', () => {
                    topInstrumentsChart.updateSeries(@json(array_column($topBookedInstruments, 'count')));
                    topInstrumentsChart.updateOptions({
                        labels: @json(array_column($topBookedInstruments, 'name'))
                    });
                });
            } catch (error) {
                console.error("Error initializing top instruments chart:", error);
            }
        }

        // Most Serviced Instruments Chart initialization function
        function initMostServicedInstrumentsChart() {
            // Debug output
            console.log("Initializing Most Serviced Instruments chart");

            // Check if element exists
            if (!document.querySelector("#mostServicedInstruments")) {
                console.error("Element #mostServicedInstruments not found");
                return;
            }

            const seriesData = @json(array_column($mostServicedInstruments, 'count'));
            const labelsData = @json(array_column($mostServicedInstruments, 'name'));

            console.log("Most serviced data:", seriesData);
            console.log("Most serviced labels:", labelsData);

            if (seriesData.length === 0) {
                console.warn("No data available for most serviced instruments");
                return;
            }

            const mostServicedOptions = {
                series: seriesData,
                chart: {
                    type: 'pie',
                    height: 250
                },
                labels: labelsData,
                colors: ['#22C55E', '#001A6E', '#DC2626'],
                legend: {
                    position: 'bottom'
                },
                tooltip: {
                    y: {
                        formatter: function(value) {
                            return value + ' services'
                        }
                    }
                },
                responsive: [{
                    breakpoint: 480,
                    options: {
                        chart: {
                            width: 200
                        },
                        legend: {
                            position: 'bottom'
                        }
                    }
                }]
            };

            try {
                const mostServicedChart = new ApexCharts(document.querySelector("#mostServicedInstruments"), mostServicedOptions);
                mostServicedChart.render();

                Livewire.on('refreshMostServiced', () => {
                    mostServicedChart.updateSeries(@json(array_column($mostServicedInstruments, 'count')));
                    mostServicedChart.updateOptions({
                        labels: @json(array_column($mostServicedInstruments, 'name'))
                    });
                });
            } catch (error) {
                console.error("Error initializing most serviced chart:", error);
            }
        }

        // Top Students Chart initialization function
        function initTopStudentsChart() {
            if (!document.querySelector("#topStudentWithMostBookings")) {
                console.error("Element #topStudentWithMostBookings not found");
                return;
            }

            const seriesData = @json(array_column($topStudentWithMostBookings, 'count'));
            const labelsData = @json(array_column($topStudentWithMostBookings, 'name'));

            if (seriesData.length === 0) {
                console.warn("No data available for top students");
                return;
            }

            const topStudentsOptions = {
                series: seriesData,
                chart: {
                    type: 'pie',
                    height: 250
                },
                labels: labelsData,
                colors: ['#22C55E', '#001A6E', '#DC2626'],
                legend: {
                    position: 'bottom'
                },
                tooltip: {
                    y: {
                        formatter: function(value) {
                            return value + ' bookings'
                        }
                    }
                },
                responsive: [{
                    breakpoint: 480,
                    options: {
                        chart: {
                            width: 200
                        },
                        legend: {
                            position: 'bottom'
                        }
                    }
                }]
            };

            try {
                const topStudentsChart = new ApexCharts(document.querySelector("#topStudentWithMostBookings"), topStudentsOptions);
                topStudentsChart.render();

                Livewire.on('refreshTopStudents', () => {
                    topStudentsChart.updateSeries(@json(array_column($topStudentWithMostBookings, 'count')));
                    topStudentsChart.updateOptions({
                        labels: @json(array_column($topStudentWithMostBookings, 'name'))
                    });
                });
            } catch (error) {
                console.error("Error initializing top students chart:", error);
            }
        }
    </script>

</div>
