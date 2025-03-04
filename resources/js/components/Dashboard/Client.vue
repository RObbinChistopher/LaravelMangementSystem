<template>
    <div class="container">

        <div class="main-container">
            <p class="moving-text">Earn More as You Sell More Simple & Rewarding!</p>
            <!-- <p style="text-align: center; font-size: 13px;" class="mb-3">Once the client completes the payment, your commission will be transferred
                to
                your
                account.</p> -->
            <div class="spinner2 d-flex justify-content-center" v-if="userAgentLoading">
                <div class="spinner-border" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
            </div>
            <div v-else>
                <h6 class="text">Affiliate Commission Tiers and Your Achievements :</h6>

                <!-- Tier Cards -->
                <div class="tiers mb-3">
                    <div v-for="(tier, index) in updatedTiers" :key="index" class="tier-card"
                        :class="{ 'unlocked': isTierUnlocked(tier), 'locked': !isTierUnlocked(tier) }">
                        <p>Sales: ${{ tier.minSales }}+</p>
                        <p class="amount mb-0">Commission: Rs. {{ tier.commission }}</p>
                        <!-- <p class="amount" style="text-align: end;">Times : {{ tier.count }}</p> -->
                    </div>
                </div>
                <!-- <div class="row p-3">
                <div class="col-md-4 tier-card unlocked p-3" v-for="item in userAgent">
                    <div class="info-item">
                        <strong>Name:</strong> <span>{{ item.name }}</span>
                    </div>
                    <div class="info-item">
                        <strong>Status:</strong> <span class="important-text">{{ item.status }}</span>
                    </div>
                    <div class="info-item">
                        <strong>Business:</strong> <span>{{ item.business_name }} ({{ item.business_industry }})</span>
                    </div>
                    <div class="info-item">
                        <strong>Website Type:</strong> <span>{{ item.website_type }}</span>
                    </div>
                    <div class="info-item">
                        <strong>Budget:</strong> <span>${{ item.website_estimated_budget }}</span>
                    </div>
                    <div class="info-item">
                        <strong>Launch Date:</strong> <span>{{ item.website_desired_launch_date }}</span>
                    </div>
                </div>
            </div> -->
                <div v-if="userAgent.length > 0">
                    <h6 class="text">My Client Data and Pending Payments:</h6>
                    <p v-for="item in userAgent" class="agent-client-paymentdata"><strong>{{ item.name }}</strong> is
                        looking to
                        develop a <strong>{{
                            item.website_type }}</strong> website for their business, <strong>{{ item.business_name
                            }}</strong>,
                        which
                        operates in the <strong>{{ item.business_industry }}</strong> industry. With an estimated budget
                        of
                        <strong>{{ item.website_estimated_budget }}</strong>, they aim to
                        launch the website by <strong>{{ item.website_desired_launch_date }}</strong>. Currently, the
                        payment
                        status for this project is pending.

                        <strong>Once the client completes the payment, your commission will be transferred to your
                            account.</strong>
                    </p>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <label class="mt-3 text">Enter Money:</label>
                        <div class="input-group mb-3">
                            <span class="input-group-text" id="basic-addon1">$</span>
                            <input v-model="money" type="number" class="form-control" placeholder="Enter amount" />
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label class="mt-3 text">Enter Percentage:</label>
                        <div class="input-group mb-3">
                            <span class="input-group-text" id="basic-addon1">%</span>
                            <input v-model="percentage" type="number" class="form-control"
                                placeholder="Enter percentage" />
                        </div>
                    </div>
                </div>
                <p class="result">Calculated Commission: Rs. {{ convertedCommission }} PKR</p>
            </div>
        </div>
    </div>
</template>

<script>
import { mapActions, mapState } from 'vuex';
export default {
    data() {
        return {
            sales: 800,
            money: 0,
            percentage: 0,
            usdToPkrRate: 280, // Default rate, updated via API
            tiers: [
                { name: "Tier 1", minSales: 0, commission: 6500, count: 0 },
                { name: "Tier 2", minSales: 350, commission: 10000, count: 0 },
                { name: "Tier 3", minSales: 650, commission: 16500, count: 0 },
                { name: "Tier 4", minSales: 1000, commission: 22500, count: 0 },
                { name: "Tier 5", minSales: 1400, commission: "7% commission", count: 0 },
            ],
        };
    },
    computed: {
        ...mapState('agent', ['userAgent', 'userAgentLoading', 'agent', 'agentLoading']),
        updatedTiers() {
            return this.tiers.map(tier => {
                let matchingBusiness = this.agent?.businesses?.find(business => business.Tier === tier.name);
                return {
                    ...tier,
                    count: matchingBusiness ? matchingBusiness.count : 0
                };
            });
        },

        convertedCommission() {
            let amountInUsd = (this.money * this.percentage) / 100;
            return (amountInUsd * this.usdToPkrRate).toFixed(2);
        }

    },
    methods: {
        ...mapActions('agent', ['fetchUserPaymentStatus', 'fetchAffiliatePaymentRange']),
        isTierUnlocked(tier) {
            // Check if the user has a business and if its Tier matches the current tier
            if (this.agent && this.agent.businesses && this.agent.businesses.length > 0) {
                return this.agent.businesses.some(business => business.Tier === tier.name);
            }
            return false;
        },
        async fetchExchangeRate() {
            try {
                const response = await fetch("https://api.exchangerate-api.com/v4/latest/USD");
                const data = await response.json();
                this.usdToPkrRate = data.rates.PKR;
            } catch (error) {
                console.error("Error fetching exchange rate:", error);
            }
        },
        convertToPKR(amount) {
            if (typeof amount === "string") return amount; // For percentage-based tiers
            return (amount * this.usdToPkrRate).toLocaleString();
        }
    },
    mounted() {
        this.fetchExchangeRate(); // Fetch rate when component loads
        this.fetchUserPaymentStatus();
        this.fetchAffiliatePaymentRange();
    }
};
</script>

<style scoped>
.agent-client-paymentdata {
    background: #e9edf1;
    border: 1px solid #99519e;
    padding: 6px 14px;
    border-radius: 8px;
}

.important-text {
    font-weight: 900;
    text-transform: uppercase;
}

.info-item {
    display: flex;
    gap: 10px;
}

.info-item strong {
    width: 50%;
    /* Adjust width of label */
    text-align: left;
}

.info-item span {
    width: 50%;
    /* Adjust width of value */
    text-align: left;
    /* Ensure text is left-aligned */
}

.payment-card {
    border: 1px solid red;
}

.input-section {
    margin: 10px 0;
}

.input-section label {
    display: block;
    margin-top: 10px;
}

.input-section input {
    width: 100%;
    padding: 8px;
    margin-top: 5px;
    border: 1px solid #ccc;
    border-radius: 5px;
}

.result {
    font-size: 18px;
    font-weight: bold;
    margin-top: 15px;
}

.progress-container {
    width: 100%;
    height: 12px;
    background: #ddd;
    border-radius: 6px;
    margin-bottom: 20px;
    position: relative;
}

.progress-bar {
    height: 100%;
    background: #99519e;
    border-radius: 6px;
    transition: width 0.5s ease-in-out;
}

/* Tier Cards */
.tiers {
    display: flex;
    flex-direction: row;
    gap: 10px;
}

.tier-card {
    padding: 15px;
    border-radius: 8px;
    border: 1px solid #ccc;
    transition: all 0.3s ease-in-out;
}

.tier-card.unlocked {
    background: #e9edf1;
    border-color: #99519e;
}

.tier-card.locked {
    background: #f8f8f8;
    opacity: 0.6;
}

.tier-card h3 {
    margin: 0;
    font-size: 18px;
}

.amount {
    font-weight: bold;
    color: #333;
}

.moving-text {
    text-align: center;
    font-size: xx-large;
    color: #99519e;
    font-weight: 900;
}

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