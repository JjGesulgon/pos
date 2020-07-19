<template>
    <div>
        <div v-if="ifReady">
            <div class="card">
                <div class="card-header">
                    <router-link class="text-primary" :to="{ name: 'corporations.index' }">Corporations</router-link>
                    /
                    <span class="text-secondary">Select Corporation</span>
                </div>
                <div class="card-body">
                    <form v-on:submit.prevent="selectCorporation()">
                        <div class="form-group">
                            <label for="name">Select Corporation</label>
                            
                            <select class="form-control" v-model="selectedCorporation" required>
                                <option v-for="corporation in corporations" :value="corporation">{{ corporation.name }}</option>
                            </select>
                        </div>

                        <button type="submit" class="btn btn-success btn-sm">Select Corporation</button>
                    </form>
                </div>
            </div>
        </div>
        <div v-else>
            <div class="progress">
                <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%;"></div>
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
