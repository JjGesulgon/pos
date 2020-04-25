<template>
    <div>
        <div class="row">
            <div class="col-md-3">
                <div class="card text-white mb-3 profit-card-graph-bg">
                    <div class="card-header">Profit</div>
                    <div class="card-body">
                        <h5 class="card-title">&#8369; 148,589 Today</h5>
                        <p class="card-text">
                            <br>
                            Profit Graph
                            <br>
                        </p>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card text-white mb-3 sales-card-graph-bg">
                    <div class="card-header">Sales</div>
                    <div class="card-body">
                        <h5 class="card-title">27&#37;</h5>
                        <p class="card-text">
                            <br>
                            Sales Graph
                            <br>
                        </p>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card text-white mb-3 sales-card-graph-bg">
                    <div class="card-header">Sales</div>
                    <div class="card-body">
                        <h5 class="card-title">&#37;27</h5>
                        <p class="card-text">
                            <br>
                            Sales Graph
                            <br>
                        </p>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card text-white mb-3 sales-card-graph-bg">
                    <div class="card-header">Sales</div>
                    <div class="card-body">
                        <h5 class="card-title">27&#37;</h5>
                        <p class="card-text">
                            <br>
                            Sales Graph
                            <br>
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="card text-white mb-3 profit-card-graph-bg">
                    <div class="card-header">Revenue for 2018</div>
                    <div class="card-body">
                        <h5 class="card-title">&#8369; 1,642,829</h5>
                        <p class="card-text">
                            <br>
                            This Year / Last Year Graph
                            <br><br><br><br>
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-4">
                <div class="card text-white mb-3 profit-card-graph-bg">
                    <div class="card-header">Todays Profit</div>
                    <div class="card-body">
                        <h5 class="card-title">&#8369; 24,498</h5>
                        <p class="card-text">
                            <br>
                            Today / Yesterday Graph
                            <br>
                        </p>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card text-white mb-3 profit-card-graph-bg">
                    <div class="card-header">Current Week Profit</div>
                    <div class="card-body">
                        <h5 class="card-title">&#8369; 87,249</h5>
                        <p class="card-text">
                            <br>
                            Current Week/ Last Week Graph
                            <br>
                        </p>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card text-white mb-3 profit-card-graph-bg">
                    <div class="card-header">Current Month Profit</div>
                    <div class="card-body">
                        <h5 class="card-title">&#8369; 343,407</h5>
                        <p class="card-text">
                            <br>
                            Current Month/ Last Month Graph
                            <br>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {

        };
    },

    mounted() {
        // 
    },

    methods: {
        // Add ES6 methods here
    },

    computed: {
        // Add ES6 methods here that needs caching
    }
}
</script>

<style>
.profit-card-graph-bg {
    background: #43A047;
    background: -webkit-linear-gradient(45deg, #004eff 0%, #1de9b6 100%);
    background: linear-gradient(45deg, #004eff 0%, #1de9b6 100%);
    box-shadow: 0 4px 15px 0 rgba(77, 182, 172, 0.5);
}

.sales-card-graph-bg {
    background: #43A047;
    background: -webkit-linear-gradient(45deg, #00bfa5 0%, #1de9b6 100%);
    background: linear-gradient(45deg, #00bfa5 0%, #1de9b6 100%);
    box-shadow: 0 4px 15px 0 rgba(77, 182, 172, 0.5);
}
</style>
