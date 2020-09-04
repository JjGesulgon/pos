<template>
    <div>
        <form v-on:submit.prevent="update()">
            <div v-if="$parent.ifReady">
                <slot></slot>
            </div>
            <div v-else>
                <div class="progress">
                    <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%;"></div>
                </div>
            </div>

            <br>

            <button class="btn btn-outline-secondary btn-sm" @click="backToIndex()">
                <i class="fas fa-chevron-left"></i>&nbsp; Back
            </button>
            <button v-if="$parent.ifReady" type="submit" class="btn btn-success btn-sm">
                <i class="fas fa-edit"></i>&nbsp; Update {{ singularName }}
            </button>
        </form>
    </div>
</template>

<script>
    export default {
        props: {
            apiPath: String,
            routePrefixName: String,
            singularName: String,
            fieldColumns: null,
            toastMessage: String
        },

        watch: {
            fieldColumns: function(newValue, oldValue) {
                //
            }
        },

        methods: {
            backToIndex() {
                this.$router.push({ name: `${this.routePrefixName}.index` });
            },
            update() {
                this.$parent.ifReady = false;

                axios.patch(`${this.apiPath}` + '/' + this.$route.params.id, this.fieldColumns).then(() => {
                    Broadcast.$emit('ToastMessage', {
                        toastMessage: `${this.toastMessage} updated successfully.`
                    });

                    this.$router.push({
                        name: `${this.routePrefixName}.view`,
                        params: { id: this.$route.params.id }
                    });
                }).catch(err => {
                    this.$parent.ifReady = true;
                    console.log(err);
                });
            }
        }
    }
</script>

