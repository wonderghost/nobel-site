<template>
    <div>
        <flux-parallax
            :src="'/illustration-img/'+pageSlug+'.jpg'"
            type="relative"
            offset="100%"
            style="height:400px;">
            <div class="uk-text-center">
                <h1 class="service-header" v-if="serviceData.service">{{serviceData.service.title}}</h1>
                <hr class="uk-divider-small">
                <div class="uk-overlay uk-overlay-primary" style="background : rgba(0,0,0,0.3) !important">
                    <span class="uk-margin-right" v-for="(s,index) in serviceData.sous_service" :key="index"><a class="uk-text-capitalize uk-text-bold" :href="'#'+s.slug" uk-scroll>{{s.title}}</a></span>
                </div>
            </div>
        </flux-parallax>   
        
        <div class="uk-section uk-section-default uk-margin-remove uk-padding-small">
            <div class="uk-container uk-container-large">
                <ul class="uk-breadcrumb">
                    <li><a href="/"><span uk-icon="icon : home"></span></a></li>
                    <li v-if="serviceData.service"><span>{{serviceData.service.title}}</span></li>
                </ul>         
            </div>
        </div>

        <div v-for="(ss,index) in serviceData.sous_service" :key="index" class="uk-section uk-section-default" :id="ss.slug">
            <div class="uk-container">
                <div class="uk-grid-small" uk-grid>
                    <template v-if="index % 2 == 0">
                        <div class="uk-width-1-2@m">
                            <h2>{{ss.title}}</h2>
                            <p v-html="ss.description"></p>
                        </div>
                        <div class="uk-width-1-2@m">
                            <img :src="'/illustration-img/'+ss.illustration" class="uk-border-rounded" alt="" style="width : 100% !important;">
                        </div>
                    </template>
                    <template v-else>
                        <div class="uk-width-1-2@m">

                        </div>
                        <div class="uk-width-1-2@m">
                            <h2>{{ss.title}}</h2>
                            <p v-html="ss.description"></p>
                        </div>
                    </template>
                </div>
            </div>
        </div>
        <!-- contact us button -->
        <button @click="showContact()" class="uk-button uk-button-primary uk-border-rounded contact-btn uk-visible@m"><span uk-icon="icon : mail"></span> Contactez Nous </button>
        <!-- CONTACT FORM  -->
        <transition name="fade">
            <div v-if="contactFormState" class="uk-width-1-3@m contact-form uk-box-shadow-small uk-border-rounded">
                <a class="uk-alert-close" @click="showContact()" uk-close></a>
                <contact-us></contact-us>
            </div>
        </transition>
        <!-- // -->
        <!-- // -->
    </div>
</template>
<script>
import {
   VueFlux,
   Transitions,
   FluxParallax
} from 'vue-flux'

export default {
    props : {
        pageSlug : String,
        url : String
    },  
    components: {
        'vue-flux'  : VueFlux,
        'flux-parallax' : FluxParallax,
    },
    created() {
        
    },
    mounted() {
        this.getInfos()
    },
    data() {
        return {
            serviceData : {},
            contactFormState : false
        }
    },
    methods : {
        showContact : function () {
            try {
                if(!this.contactFormState) {
                    this.contactFormState = true
                }
                else {
                    this.contactFormState = false
                }
            } catch(error) {
                alert(error)
            }
        },
        getInfos : async function () {
            try {
                let response = await axios.post('/service/getinfos-service',{
                    _token : document.querySelector("meta[name=csrf-token]").content,
                    slug : this.pageSlug
                })
                this.serviceData = response.data
            } catch(error) {
                alert(error)
            }
        }
    }
}
</script>
