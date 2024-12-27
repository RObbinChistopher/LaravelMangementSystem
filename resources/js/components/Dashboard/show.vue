<template>
    <div class="container">
        <div class="main-container">
            <div class="row">
                <div class="col-md-12" v-for="item in service">
                    <div class="alert alert-danger" role="alert">
                        <b>{{ item.client_name }}</b> chose a <b>{{ item.package }}</b> <b>{{ item.service }}</b>
                        service for <b>${{
                            item.total_payment }}</b>, paying <b>${{ item.initial_payment }}</b> initially and the
                        remaining
                        <b>${{ item.remaining_payment }}</b> due on <b>{{ item.starting_date }}</b>, with the service
                        ending date on <b>{{ item.ending_date }}</b>.
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="parent-accordion mb-3" id="parent-accordion">
                        <div class="row" style="padding: 12px 10px;">
                            <div class="col-md-4 show-content-card-right common-class">
                                <div class="dashboard-card">
                                    <div class="d-flex justify-content-between align-items-baseline">
                                        <p class="text">Urgent Milestones</p>
                                        <i class="fas fa-project-diagram text"></i>
                                    </div>
                                    <p class="text mb-2"
                                        v-if="dashboard && dashboard.tasks && dashboard.tasks.urgent !== undefined">
                                        {{ dashboard.tasks.urgent || '0' }}
                                    </p>


                                </div>

                            </div>
                            <div class="col-md-4 show-content-card-right show-content-left-card common-class">
                                <div class="dashboard-card">
                                    <div class="d-flex justify-content-between align-items-baseline">
                                        <p class="text">Medium Milestones</p>
                                        <i class="fas fa-project-diagram text"></i>
                                    </div>
                                    <p class="text mb-2" v-if="dashboard && dashboard.tasks && dashboard.tasks.medium !== undefined">
                                        {{ dashboard.tasks.medium || '0' }}</p>
                                </div>
                            </div>
                            <div class="col-md-4 show-content-left-card common-class">
                                <div class="dashboard-card">
                                    <div class="d-flex justify-content-between align-items-baseline">
                                        <p class="text">Lower Milestones</p>
                                        <i class="fas fa-project-diagram text"></i>
                                    </div>
                                    <p class="text mb-2" v-if="dashboard && dashboard.tasks && dashboard.tasks.lower !== undefined">
                                        {{ dashboard.tasks.lower || '0' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="parent-accordion mb-3" id="parent-accordion">
                        <div class="row" style="padding: 12px 10px;">
                            <div class="col-md-4 show-content-card-right common-class">
                                <div class="dashboard-card">
                                    <div class="d-flex justify-content-between align-items-baseline">
                                        <p class="text">Complete Milestones</p>
                                        <i class="fas fa-project-diagram text"></i>
                                    </div>
                                    <p class="text mb-2"
                                        v-if="dashboard && dashboard.milestones && dashboard.milestones.complete !== undefined">
                                        {{ dashboard.milestones.complete || '0' }}</p>
                                </div>

                            </div>
                            <div class="col-md-4 show-content-card-right show-content-left-card common-class">
                                <div class="dashboard-card">
                                    <div class="d-flex justify-content-between align-items-baseline">
                                        <p class="text">Progress Milestones</p>
                                        <i class="fas fa-project-diagram text"></i>
                                    </div>
                                    <p class="text mb-2"
                                        v-if="dashboard && dashboard.milestones && dashboard.milestones.progress !== undefined">{{
                                            dashboard.milestones.progress || '0' }}</p>
                                </div>
                            </div>
                            <div class="col-md-4 show-content-left-card common-class">
                                <div class="dashboard-card">
                                    <div class="d-flex justify-content-between align-items-baseline">
                                        <p class="text">Incomplete Milestones</p>
                                        <i class="fas fa-project-diagram text"></i>
                                    </div>
                                    <p class="text mb-2"
                                        v-if="dashboard && dashboard.milestones && dashboard.milestones.incomplete !== undefined">
                                        {{ dashboard.milestones.incomplete || '0' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-3" style="padding: 0 16px">
                        <div class="col-md-12 col-12 p-0">
                            <div class="project-filter">
                                <div class="btn-group mb-3">
                                    <button type="button" class="btn btn-danger dropdown-toggle text change-btn"
                                        data-bs-toggle="dropdown" aria-expanded="false">
                                        Filter By Projects
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li v-for="item in dashboard.project" :key="item.id">
                                            <a class="dropdown-item" href="#" @click="selectProject(item)">
                                                {{ item.name }}
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="service-detail text" v-if="selectedProject.name">
                                    {{ selectedProject.name }}
                                </div>
                            </div>

                            <div class="parent-accordion p-3" id="parent-accordion" style="margin-bottom: 4rem;">
                                <div>
                                    <doughnut-chart :chart-data="chartData" :chart-options="chartOptions"
                                        class="circle-chat"></doughnut-chart>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-1 col-12"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import { defineComponent, reactive, computed } from 'vue';
import { DoughnutChart } from 'vue-chart-3';
import { Chart as ChartJS, Title, Tooltip, Legend, ArcElement, CategoryScale, LinearScale, DoughnutController } from 'chart.js';
import { mapActions, mapState } from 'vuex';

ChartJS.register(Title, Tooltip, Legend, ArcElement, CategoryScale, LinearScale, DoughnutController);

export default defineComponent({
    name: 'DoughnutGraph',
    components: {
        DoughnutChart,
    },
    setup() {
        const selectedProject = reactive({
            name: '',
            percentage: 0
        });

        const chartData = reactive({
            labels: ['Completed', 'Remaining'], // Default labels
            datasets: [
                {
                    label: 'Project Completion',
                    data: [selectedProject.percentage, 100 - selectedProject.percentage], // Dynamically adjust data
                    backgroundColor: ['#99519e', '#d3d3d3'], // Colors for completed and remaining
                    borderWidth: 0,
                },
            ],
        });

        // Function to handle project selection
        const selectProject = (project) => {
            selectedProject.name = project.name;
            selectedProject.percentage = project.percentage;

            // Update the chart data when a project is selected
            chartData.datasets[0].data = [project.percentage, 100 - project.percentage];
            chartData.labels = [
                `Completed ${project.percentage}%`,
                `Remaining ${100 - project.percentage}%`
            ]; // Update chart labels
        };

        const chartOptions = reactive({
            responsive: true,
            plugins: {
                legend: {
                    display: false,
                },
                tooltip: {
                    enabled: false,
                },
                centerText: {
                    id: 'centerText',
                    beforeDraw(chart) {
                        const { width, height, ctx } = chart;
                        ctx.save();

                        // Text for the percentage
                        const percentage = `${chart.data.datasets[0].data[0]}%`; // First dataset's value
                        const fontSize = (height / 5).toFixed(2); // Dynamically calculate font size
                        ctx.font = `bold ${fontSize}px Arial`;
                        ctx.fillStyle = '#626262'; // Text color
                        ctx.textAlign = 'center';
                        ctx.textBaseline = 'middle';
                        ctx.fillText(percentage, width / 2, height / 2);

                        ctx.restore();
                    },
                },
            },
            elements: {
                arc: {
                    borderWidth: 0,
                },
            },
            cutout: '75%', // Create the ring effect
        });

        return {
            chartData,
            chartOptions,
            selectProject,
            selectedProject, // Expose selected project to the template
        };
    },
    methods: {
        ...mapActions('service', ['fetchMessageOnEndPackage']),
        ...mapActions('dashboard', ['fetchDashboardCount']),
    },
    computed: {
        ...mapState('service', ['service', 'servicesLoading']),
        ...mapState('dashboard', ['dashboard', 'dashboardLoading']),
    },
    mounted() {
        this.fetchMessageOnEndPackage();
        this.fetchDashboardCount();
    },
});
</script>


<style scoped>
.project-filter {
    display: flex;
    gap: 10px
}

.service-detail {
    background: #e9edf1;
    padding: 4px 10px;
    border-radius: 5px;
    height: 35px;
}

.circle-chat {
    height: 250px !important;
}

/* Add custom styles here */
.line-chart-wrapper {
    height: 200px;
    /* Adjust the height as needed */
}

.text {
    color: #626262 !important;
    font-size: 0.9rem;
    font-weight: 700;
}

.container {
    max-width: 1000px !important;
    margin: 1.5rem auto !important;
}

.main-container {
    margin: auto 6rem;
}

.save-btn {
    background: var(--viseTech);
    color: white !important;
    padding: 6px 15px;
    border-radius: 6px;
    margin-top: 1rem;
    margin-bottom: 3rem;
    margin-left: 0.3rem;
    border: none;
}

.save-btn:hover {
    background-color: var(--viseTechHover);
}

.save-btn::placeholder {
    background-color: var(--viseTechHover);
}

.dashboard-card {
    background: #e9edf1;
    border-radius: 10px;
    padding: 7px 10px 1px 10px;
}

.show-content-card-right {
    padding-right: 0;
}

.show-content-left-card {
    padding-left: 7px;
}

.change-btn {
    background: #99519e;
    border-color: #99519e;
    height: 35px;
    color: white !important;
    box-shadow: none;
    font-size: 13px;
}

.circle-chat {
    height: 250px !important;
    position: relative;
    display: flex;
    justify-content: center;
    align-items: center;
}

.chart-container {
    width: 100%;
    max-width: 300px;
    margin: auto;
}

@media screen and (max-width: 600px) {
    .main-container {
        margin: auto 2rem !important;
    }

    .common-class {
        margin-bottom: 1rem;
        padding: 0 15px
    }
}
</style>