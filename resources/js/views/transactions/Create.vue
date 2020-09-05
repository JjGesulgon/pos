<template>
    <div class="row">
        <div class="col-md-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <router-link class="text-primary" :to="{ name: 'transactions.index' }">Transactions</router-link>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">
                        Create New Transaction
                    </li>
                </ol>
            </nav>
        </div>
        <div class="col-md-6">
            <div class="card" >
                <div class="card-header">
                    <div class="row clearfix">
                        <div class="float-left col-md-6">
                            Items
                        </div>
                        <div class="float-right col-md-6">
                            <input type="text" class="form-control form-control-sm" v-model="itemName" @input="onSearch" placeholder="Search Item">
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table table-hover table-sm">
                        <caption>
                            <div class="row">
                                <div class="col-md-9">
                                    List of Items
                                </div>
                                <div class="col-md-3">
                                    <div class="progress" height="30px;" v-if="showProgress">
                                        <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%;"></div>
                                    </div>
                                </div>
                            </div>
                        </caption>
                        <thead>
                            <tr>
                                <th scope="col">Brand Name</th>
                                <th scope="col">Name</th>
                                <th scope="col">Measuring Mass</th>
                                <th scope="col">Unit Of Measurement</th>
                                <th scope="col">Price</th>
                                <th scope="col">Options</th>
                            </tr>
                        </thead>
                        <tbody v-if="items">
                            <tr v-for="item in items" :key="item.id">
                                <td>{{ item.brand.name }}</td>
                                <td>{{ item.name }} {{ item.identifier }} {{ item.item_type.name }}</td>
                                <td>{{ item.sales_item_prices[0].measuring_mass.mass }}</td>
                                <td>{{ item.sales_item_prices[0].unit_of_measurement.abbreviation }}</td>
                                <td v-if="item.default_sales_item_price">{{ item.default_sales_item_price }}</td>
                                <td v-else>{{ item.sales_item_prices[0].price }}</td>
                                <td>
                                    <div v-if="item.stocks_available != 0">
                                        <label class="text-secondary clickableText" @click.prevent="addToCart(item)">
                                            <i class="fas fa-cart-arrow-down"></i>&nbsp;
                                            <strong>Add to Cart</strong>
                                        </label>
                                    </div>
                                    <div v-else>
                                        <label class="text-danger">
                                            <i class="fas fa-exclamation-circle"></i>&nbsp;
                                            <strong>Not Available</strong>
                                        </label>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <br>

            <div class="modal fade" id="checkout-modal" tabindex="-1" role="dialog" aria-labelledby="checkout" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="search">Confirm Payment</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <table class="table table-hover table-sm card-title">
                                <thead>
                                    <tr>
                                        <th scope="col">Name</th>
                                        <th scope="col">Price</th>
                                        <th scope="col">qty</th>
                                        <th scope="col">Total Price</th>
                                    </tr>
                                </thead>
                                <tbody v-if="cart">
                                    <tr v-for="item in cart" :key="item.id">
                                        <td>{{ item.name }}</td>
                                        <td>{{ item.amount }}</td>
                                        <td>{{ item.qty }}</td>
                                        <td>
                                            {{ (item.qty * item.amount).toFixed(2) }}
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <div class="card-text">
                                <br><br>
                                <div class="float-right">
                                    <div>
                                        <strong>Total Bill:</strong>
                                        {{ priceSummation() }}
                                    </div>
                                    <div>
                                        <strong>Cash:</strong>
                                        <input type="number" id="cash" name="cash" v-model="cash" disabled>
                                    </div>
                                    <div>
                                        <strong>Change:</strong>
                                        {{ (this.cash - priceSummation()).toFixed(2)}}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="container mb-4" v-if="this.ifReady">
                            <div class="progress" height="30px;">
                                <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%;"></div>
                            </div>
                        </div>
                        <div class="modal-footer" v-else>
                            <button type="button" class="btn btn-success btn-sm" @click.prevent="createNewTransaction()">Proceed</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card">
                <div class="card-header"><i class="fas fa-shopping-cart"></i>&nbsp; Cart</div>
                <div class="card-body">
                    <table class="table table-hover table-sm card-title">
                        <thead>
                            <tr>
                                <th scope="col">Name</th>
                                <th scope="col">Price</th>
                                <th scope="col">qty</th>
                                <th scope="col">Total Price</th>
                                <th scope="col">Options</th>
                            </tr>
                        </thead>
                        <tbody v-if="cart">
                            <tr v-for="item in cart" :key="item.id">
                                <td>{{ item.name }}</td>
                                <td>{{ item.amount }}</td>
                                <td>
                                    <input type="number" id="qty" name="quantity" v-model="item.qty" v-bind:max="item.stocks_available">
                                </td>
                                <td>
                                    {{ (item.qty * item.amount).toFixed(2) }}
                                </td>
                                <td>
                                    <label class="text-danger clickableText" @click.prevent="removeFromCart(item)">
                                        <i class="fas fa-trash-alt"></i>&nbsp;
                                        <strong>Remove</strong>
                                    </label>
                                </td>
                            </tr>
                            <tr v-if="priceSummation() != 0">
                                <td scope="row" colspan="5"><br></td>
                            </tr>
                            <tr v-if="priceSummation() != 0">
                                <td scope="row" colspan="5"></td>
                            </tr>
                            <tr class="no-border" v-if="priceSummation() != 0">
                                <td scope="row" colspan="4"></td>
                                <td scope="row">
                                    <strong>Total Bill:</strong>
                                    {{ priceSummation() }}
                                </td>
                            </tr>
                            <tr class="no-border" v-if="priceSummation() != 0">
                                <td scope="row" colspan="4"></td>
                                <td scope="row">
                                    <strong>Cash:</strong>
                                    <input type="number" id="cash" name="cash" v-model="cash">
                                </td>
                            </tr>
                            <tr class="no-border" v-if="priceSummation() != 0">
                                <td scope="row" colspan="4"></td>
                                <td scope="row">
                                    <strong>Change:</strong>
                                    {{ (this.cash - priceSummation()).toFixed(2)}}
                                </td>
                            </tr>
                            <tr class="no-border" v-if="priceSummation() != 0">
                                <td scope="row" colspan="4"></td>
                                <td scope="row">
                                    <button type="button" class="btn btn-success btn-sm" @click.prevent="openCheckoutModal()">
                                        <i class="fas fa-cash-register"></i>&nbsp;
                                        Checkout
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                items: null,
                name: '',
                itemName: '',
                cart: [],
                cash: 0,
                order_by: 'desc',
                error: null,
                showProgress: false,
                pageNumbers: [],
                ifReady: false
            };
        },

        computed: {
            // subTotalAmount() {
            //     return this.purchase_order_items.map((purchase_order_item) => {
            //         return (purchase_order_item.quantity * purchase_order_item.unit_price);
            //     });
            // },
            // totalAmount() {
            //     return this.purchase_order_items.reduce((total, purchase_order_item) => {
            //         return total + (purchase_order_item.quantity * purchase_order_item.unit_price);
            //     }, 0);
            // }
        },

        methods: {
            onSearch() {
                this.search(this.itemName, this);
            },
            search: _.debounce((itemName, vm) => {
                axios.get('/api/items/search-for-sales', {
                    params: {
                        name: itemName,
                        identifier: itemName,
                        name_from_item_type: itemName,
                        name_from_brand: itemName
                    }
                }).then(res => {
                    vm.items = res.data;
                });
            }, 250),
            clear() {
                this.name = '';
                this.amount = '';
                this.order_by = 'desc';
            },
            openSearchModal() {
                $('#search-modal').modal('show');
            },
            openCheckoutModal() {
                if((parseInt(this.cash).toFixed(2) - this.priceSummation()) < 0){
                    alert('Insufficient Funds')
                }else{
                    $('#checkout-modal').modal('show');
                }
            },
            addToCart(item) {
                const found = this.cart.some(el => el.id === item.id);
                if (!found){
                    var cartItem = {
                        id: item.id,
                        name: item.name,
                        amount: item.default_sales_item_price ? item.default_sales_item_price : item.sales_item_prices[0].price,
                        stocks_available: item.stock_keeping_unit,
                        qty: 1
                    }
                    this.cart.push(cartItem);
                    console.log(this.cart);   
                }else {
                    alert('Item already exists in cart');
                }
            },
            priceSummation() {
                var total = 0;
                this.cart.forEach(el => {
                 total += (el.amount * el.qty)
             })
                return total.toFixed(2);
            },
            removeFromCart(item) {
                this.cart.splice(this.cart.findIndex(x => x.id = item.id), 1);
            },
            createNewTransaction() {
                if((parseInt(this.cash).toFixed(2) - this.priceSummation()) < 0){
                    alert('Insufficient Funds');
                } else{
                    this.ifReady = true;
                    var transaction = {
                        total_amount: this.priceSummation(),
                        cart: this.cart
                    }

                    axios.post('/api/transactions', transaction).then(res => {
                        for(let cartItem = 0; cartItem < this.cart.length; cartItem++){
                            let data = {
                                name: this.cart[cartItem].name,
                                amount: this.cart[cartItem].amount,
                                stocks_available: this.cart[cartItem].stocks_available - this.cart[cartItem].qty
                            };

                            axios.patch('/api/items/' + this.cart[cartItem].id, data).then(res => {
                                console.log('Item Update Successful');
                            }).catch(err => {
                                console.log(err);
                            });
                        }

                        $('#checkout-modal').modal('hide');

                        Broadcast.$emit('ToastMessage', {
                            message: 'Transaction Created Successfully'
                        });

                        this.cart = [];
                        this.cash = '';
                        
                        this.$router.go();
                    }).catch(err => {
                        this.ifReady = true;
                        console.log(err);
                    });
                }
            }
        }
    }
</script>

<style>
.clickableText:hover {
    text-decoration: underline;
    cursor: pointer
}

.table > tbody > tr.no-border > td,
.table > tbody > tr.no-border > th {
  border-top: none;
}
</style>
