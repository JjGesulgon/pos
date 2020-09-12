<template>
    <div>
        <div class="row mt-3">
            <div class="col-12">
                <div class="row">
                    <div class="col-md-3 col-sm-12">
                        <div class="card card-min">
                            <div class="card-body row">
                                <div class="col-md-12 col-sm-12 text-center  center">
                                    <h1 v-if="totalTransactions">{{ totalTransactions.length }}</h1>
                                    <h1 v-else>0</h1>
                                </div>
                            </div>
                            <div class="card-footer text-center">
                                <strong>
                                    Today's Transactions
                                </strong>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3 col-sm-12">
                        <div class="card card-min">
                            <div class="card-body row">
                                <div class="col-md-12 col-sm-12 text-center  center">
                                    <h1>{{ total_sales_today }} PHP</h1>
                                </div>
                            </div>
                            <div class="card-footer text-center">
                                <strong>
                                    Today's Total Sales
                                </strong>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3 col-sm-12">
                        <div class="card card-min">
                            <div class="card-body row">
                                <div class="col-md-12 col-sm-12 text-center  center">
                                    <h1>{{ total_sales_week }} PHP</h1>
                                </div>
                            </div>
                            <div class="card-footer text-center">
                                <strong>
                                    This Week's Total Sales
                                </strong>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3 col-sm-12">
                        <div class="card card-min">
                            <div class="card-body row">
                                <div class="col-md-12 col-sm-12 text-center  center">
                                    <h1>{{ total_sales_month }} PHP</h1>
                                </div>
                            </div>
                            <div class="card-footer text-center">
                                <strong>
                                    This Month's Total Sales
                                </strong>
                            </div>
                        </div>
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
            ifReady: false,
            totalTransactions: null,
            totalWeekTransactions: null,
            totalMonthTransactions: null,
            totalWeekSales: null,
            totalMonthSales: null,
          };
      },

      mounted() {
        let promise = new Promise((resolve, reject) => {
          //Get All Transactions Today
          this.getFilteredTransactionList(this.getCurrentDateStart(), this.getCurrentDateEnd(), 'today');

          //Get All Transactions This Week
          this.getFilteredTransactionList(this.getWeekStartDate(), this.getCurrentDateEnd(), 'week');

          //Get All Transactions This Month
          this.getFilteredTransactionList(this.getMonthStartDate(), this.getCurrentDateEnd(), 'month');
        });

        promise.then(() => {
            this.ifReady = true;
        });
      },

      computed:{
        total_sales_today: function () {
          if (this.totalTransactions){
            return this.totalTransactions.reduce((totalAmount, transaction_item) => {
              return totalAmount += parseFloat(transaction_item.grand_total_amount);
            }, 0);
          }
          return 0;
        },

        total_sales_week: function () {
          if (this.totalWeekTransactions){
            return this.totalWeekTransactions.reduce((totalAmount, transaction_item) => {
                    return totalAmount += parseFloat(transaction_item.grand_total_amount);
            }, 0);
          }
          return 0;
        },

        total_sales_month: function () {
          if (this.totalMonthTransactions){
            return this.totalMonthTransactions.reduce((totalAmount, transaction_item) => {
                    return totalAmount += parseFloat(transaction_item.grand_total_amount);
            }, 0);
          }
          return 0;
        },
      },

      methods:{
        getFilteredTransactionList(start, end, span){
          var data = {
            startDate: start,
            endDate: end
          }
          axios.post('/api/transactions/get-total-transactions', data ).then(res => {
              switch(span){
                case 'today':
                  this.totalTransactions = res.data.transaction;
                  break;
                case 'week':
                  this.totalWeekTransactions = res.data.transaction;
                  break;
                case 'month':
                  this.totalMonthTransactions = res.data.transaction;
                  break;
              }
              
              resolve();
          }).catch(err => {
              return err;
          });
        },

        getCurrentDateStart(){
          return this.formatToISODate(new Date());
        },

        getWeekStartDate() {
          var d = new Date();
          var day = d.getDay(),
          diff = d.getDate() - day + (day == 0 ? -6:1); // adjust when day is sunday

          var date = new Date(d.setDate(diff))
          var userTimezoneOffset = date.getTimezoneOffset() * 60000;
          var x = new Date(date.getTime() - userTimezoneOffset);
          var firstDay = new Date(x.toDateString())

          return this.formatToISODate(firstDay)
        },

        getMonthStartDate(){
          var date = new Date();
          var firstDay = new Date(date.getFullYear(), date.getMonth(), 1);

          return this.formatToISODate(firstDay)
        },

        getCurrentDateEnd(){
          var tzoffset = (new Date()).getTimezoneOffset() * 60000; //offset in milliseconds
          var localISOTime = (new Date(Date.now() - tzoffset)).toISOString().slice(0, -1);

          return localISOTime;
        },

        formatToISODate(date){
          var today = date;
          var dd = today.getDate();
          var mm = today.getMonth()+1;
          var yyyy = today.getFullYear();

          if(dd<10) dd='0'+dd;
          if(mm<10) mm='0'+mm;

          return (yyyy+'-'+mm+'-'+dd+'T00:00:00');
        }
      },
    }
</script>
