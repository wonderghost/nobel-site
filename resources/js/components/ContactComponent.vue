<template>
    <div>
        <Loading :active.sync="isLoading" 
        :can-cancel="true" 
        :is-full-page="fullPage"></Loading>

        <h4>Contactez Nous</h4>
        <div v-for="err in errors" :key="err" class="uk-width-1-1@m uk-alert-danger" uk-alert>
            <a class="uk-alert-close" uk-close></a>
            <p>{{err}}</p>
        </div>
        <form @submit.prevent="contactUs()" class="uk-width-1-1@m">
            <div class="uk-margin-small">
                <label for="">Nom Complet *</label>
                <input v-model="dataForm.nom_complet" type="text" class="uk-input uk-border-rounded" placeholder="Nom et Prenom">
            </div>
            <div class="uk-margin-small">
                <label for="">Email *</label>
                <input v-model="dataForm.email" type="email" class="uk-input uk-border-rounded" placeholder="Adresse Email (ex : xyz@gmail.com )">
            </div>
            <div class="uk-margin-small">
                <label for="">Objet *</label>
                <input v-model="dataForm.objet" type="text" class="uk-input uk-border-rounded" placeholder="Objet ">
            </div>
            <div class="uk-margin-small">
                <label for="">Message *</label>
                <textarea v-model="dataForm.message" class="uk-textarea uk-border-rounded" cols="30" rows="10"></textarea>
            </div>
            <button type="submit" class="uk-button uk-button-small uk-border-rounded uk-button-primary">Envoyez</button>
        </form>        
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
        data() {
            return {
                isLoading : false,
                fullPage : true,
                dataForm : {
                    _token : document.querySelector("meta[name=csrf-token]").content,
                    nom_complet : "",
                    email : "",
                    objet : "",
                    message : ""
                },
                errors : []
            }
        },
        methods : {
            contactUs : async function () {
                try {
                    let response = await axios.post('/contact-us',this.dataForm)
                    console.log(response.data)
                } catch(error) {
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
        }
    }
</script>
