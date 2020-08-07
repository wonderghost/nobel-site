<template>
    <div>
        <Loading :active.sync="isLoading" 
        :can-cancel="true" 
        :is-full-page="fullPage"></Loading>
        <div class="uk-section uk-section-muted uk-flex uk-flex-middle uk-animation-fade" uk-height-viewport>
            <div class="uk-width-1-1">
                <div class="uk-container">
                    <div class="uk-grid-margin uk-grid uk-grid-stack" uk-grid>
                        <div class="uk-width-1-1@m">
                            <div class="uk-margin uk-width-large uk-margin-auto uk-card uk-card-default uk-card-body uk-box-shadow-large">
                                <h3 class="uk-card-title uk-text-center">Login</h3>
                                <div v-for="err in errors" :key="err" uk-alert class="uk-alert-danger uk-border-rounded">
                                    <a class="uk-alert-close" uk-close></a>
                                    <p>{{err}}</p>
                                </div>
                                <form @submit.prevent="logIn()">
                                    <div class="uk-margin">
                                        <div class="uk-inline uk-width-1-1">
                                            <span class="uk-form-icon" uk-icon="icon: mail"></span>
                                            <input v-model="dataForm.email" class="uk-input uk-form-large uk-border-rounded" type="email">
                                        </div>
                                    </div>
                                    <div class="uk-margin">
                                        <div class="uk-inline uk-width-1-1">
                                            <span class="uk-form-icon" uk-icon="icon: lock"></span>
                                            <input v-model="dataForm.password" class="uk-input uk-form-large uk-border-rounded" type="password">	
                                        </div>
                                    </div>
                                    <div class="uk-margin">
                                        <button class="uk-button uk-button-primary uk-border-rounded uk-button-large uk-width-1-1">Login <span uk-icon="icon : arrow-right"></span></button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>  
    </div>
</template>
<script>
import Loading from 'vue-loading-overlay';
 // Import component
import 'vue-loading-overlay/dist/vue-loading.css';
 // Import stylesheet

    export default {
        components : {
            Loading
        },    
        mounted() {
            
        },
        data(){
            return {
                dataForm : {
                    _token : document.querySelector("meta[name=csrf-token]").value,
                    email : "",
                    password : ""
                },
                errors : [],
                isLoading : false,
                fullPage : true
            }
        },
        methods : {
            logIn : async function () {
                try {
                    this.isLoading = true
                    let response = await axios.post('/log-in',this.dataForm)
                    if(response && response.data == 'done') {
                        alert("Success !")
                        location.reload()
                    }
                } catch(error) {
                    this.isLoading = false
                    if(error.response.data.errors) {
                        let errorTab = error.response.data.errors
                        for (var prop in errorTab) {
                            this.errors.push(errorTab[prop][0])
                        }
                    } else {
                        this.errors.push(error.response.data)
                    }
                }
            }
        },
        computed : {

        }
    }
</script>
