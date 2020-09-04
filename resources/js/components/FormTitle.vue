<template>
    <div class="clearfix">
        <div class="float-left">
            <h4>{{ title }} <slot name="title-small"></slot></h4>
        </div>
        <div class="float-right">
            <slot name="float-right">
                <router-link v-if="showRightSide == true" class="btn btn-sm btn-success mr-1" :to="{ name: `${routePrefixName}.create` }">
                    <i class="fas fa-plus"></i>
                    &nbsp;
                    <strong>Create New {{ singularName }}</strong>
                </router-link>
                <button v-if="showRightSide == true" type="button" class="btn btn-sm btn-primary mr-1" @click.prevent="$parent.$refs.searchModal.openSearchModal()">
                    <i class="fas fa-search"></i>
                    &nbsp;
                    <strong>Search {{ pluralName }}</strong>
                </button>
                <button v-if="showRightSide == true && showClearSearch" type="button" class="btn btn-sm btn-info" @click.prevent="clearSearch()">
                    <i class="fas fa-eraser"></i>
                    &nbsp;
                    <strong>Clear Search</strong>
                </button>
            </slot>
            <slot name="other-buttons"></slot>
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            routePrefixName: {
                type: String,
                required: false
            },
            title: {
                type: String,
                required: true
            },
            singularName: {
                type: String,
                required: false
            },
            pluralName: {
                type: String,
                required: false
            },
            showRightSide: {
                type: Boolean,
                required: false
            },
            parameters: {
                type: Object,
                required: false
            }
        },

        data() {
            return {
                showClearSearch: false
            };
        },

        watch: {
            parameters: function() {
                let checker     = false;
                let queryParams = {};

                for (const [key, value] of Object.entries(this.$route.query)) {
                    queryParams[key] = value;
                }

                if (queryParams['order_by'] == 'asc') {
                    console.log('order by is true');
                    checker = true;
                }

                delete queryParams.order_by;
                delete queryParams.page;
                delete queryParams.per_page;

                let parameters = Object.entries(queryParams);

                for (const [key, value] of Object.entries(parameters)) {
                    if (value[1] !== "") {
                        checker = true;
                    }
                }

                setTimeout(() => {
                    this.showClearSearch = checker;
                }, 100);
            }
        },

        methods: {
            clearSearch() {
                this.$parent.$refs.searchModal.clearParameters();

                setTimeout(() => {
                    this.$parent.$refs.searchModal.search();
                }, 100);
            }
        }
    }
</script>
