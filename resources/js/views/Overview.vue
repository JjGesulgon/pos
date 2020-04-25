<template>
    <div>
        <div class="row">
            <div class="col-md-12">
                <div class="card mb-3 profit-card-graph-bg">
                    <div class="card-header">POS Overview</div>
                    <div class="card-body">
                        <h5 class="card-title">Basic Transaction and Inventory System</h5>
                        <!-- <p class="card-text">
                            <br>
                            This Year / Last Year Graph
                        </p> -->
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
.lettering{
        font-size: 45px;
        color: #717171;
        line-height: 25px;
}

.profit-card-graph-bg {
    /* background: #43A047;
    background: -webkit-linear-gradient(45deg, #004eff 0%, #1de9b6 100%);
    background: linear-gradient(45deg, #004eff 0%, #1de9b6 100%); */
    box-shadow: 0 4px 15px 0 rgba(96, 99, 98, 0.5);
}

.sales-card-graph-bg {
    /* background: #43A047;
    background: -webkit-linear-gradient(45deg, #00bfa5 0%, #1de9b6 100%);
    background: linear-gradient(45deg, #00bfa5 0%, #1de9b6 100%); */
    box-shadow: 0 4px 15px 0 rgba(96, 99, 98, 0.5);
}
</style>
