<template>
    <div>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><router-link :to="{ name: 'corporations.index' }">Corporations</router-link></li>
                <li class="breadcrumb-item active" aria-current="page">View Corporations</li>
            </ol>
        </nav>

        <div class="card">
            <div class="card-body">
                <div class="clearfix">
                    <div class="float-left">
                        <h4>Select Corporation</h4>
                    </div>
                </div>

                <br>

                <div v-if="ifReady">
                    <form v-on:submit.prevent="selectCorporation">
                        <div class="form-group">
                            <label for="select-corporation">Select Corporation</label>
                            <select id="select-corporation" class="form-control" v-model="selectedCorporation" required>
                                <option :key="corporation.id" v-for="corporation in corporations" :value="corporation">{{ corporation.name }}</option>
                            </select>
                        </div>

                        <button type="submit" class="btn btn-success btn-sm">Select Corporation</button>
                    </form>
                </div>
                <div v-else>
                    <div class="progress">
                        <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%;"></div>
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
                selectedCorporation: null,
                corporations: [],
                ifReady: false
            };
        },

        created() {
            if (localStorage.getItem('corporations') != null) {
                let promise = new Promise((resolve, reject) => {
                    this.corporations = JSON.parse(localStorage.getItem('corporations'));
                    resolve();
                });

                promise.then(() => {
                    this.ifReady = true;
                });
            } else {
                let promise = new Promise((resolve, reject) => {
                    axios.get('/api/corporations/get-all-corporations').then(res => {
                        this.corporations = res.data.corporations;
                        localStorage.setItem('corporations', JSON.stringify(res.data.corporations));
                        resolve();
                    });
                });

                promise.then(() => {
                    this.ifReady = true;
                });
            }
        },

        methods: {
            selectCorporation() {
                this.ifReady = false;

                let promise = new Promise((resolve, reject) => {
                    this.$store.commit('selectCorporation', this.selectedCorporation);

                    localStorage.setItem('selectedCorporation', JSON.stringify(this.selectedCorporation));

                    axios.defaults.headers.common['CORPORATION-ID'] = this.selectedCorporation.id;

                    Broadcast.$emit('ChangeCorporation', { corporation: this.selectedCorporation });

                    resolve();
                });

                promise.then(() => {
                    this.$router.push({ name: 'overview' });
                });
            }
        }
    }
</script>
