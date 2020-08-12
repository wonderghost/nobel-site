<template>
   <div>
  <!--  -->
    <div class="">
        <flux-parallax
        src="/img/ban.jpeg"
        type="relative"
        offset="300%"
        style="height:500px;">
        <!-- <div class="uk-text-center uk-overlay uk-overlay-primary uk-position-center uk-border-rounded" style="background : rgba(0,0,0,0.3) !important;">
            <h2 class="para-header">Heading</h2>
            <div class="uk-container">
                <p class="con-header">Lorem ipsum dolor sit amet consectetur adipisicing elit. Consectetur soluta at rem eum ab non quas, laboriosam vero ad nesciunt dolor eligendi et corporis aliquid ipsam voluptatem? Quaerat, voluptates delectus!</p>
                <a href="#about-us" uk-scroll class="uk-button uk-button-primary uk-border-rounded uk-text-capitalize">En savoir plus <span uk-icon="icon : arrow-right"></span></a>
                <button class="uk-button uk-button-small uk-button-primary uk-border-rounded" v-if="user">Edit</button>
            </div>
        </div> -->
        </flux-parallax>
    </div>
    <!--  -->       
    <div v-if="aboutUs[0]" id="about-us" class="uk-container uk-margin-top uk-margin-bottom uk-padding-large">
        <h3>A propos</h3>
        <p v-html="aboutUs[0].sous_section[0].description.substring(0,900)">...</p>
        
        <a v-if="aboutUs[0]" :href="'/section/'+aboutUs[0].section.slug" class="uk-button uk-button-small uk-text-capitalize  uk-border-rounded btn-bg">En savoir Plus <span uk-icon="icon : arrow-right"></span></a>
    </div>
<!-- TOUS NOS SERVICES -->
    <flux-parallax
    src="/img/ban.jpeg"
    type="relative"
    offset="100%"
    style="height:200px;">
        <div class="uk-text-center">
            <h2 class="secon-header uk-text-capitalize">Decouvrez Tous nos services  </h2>
            <hr class="uk-divider-small">
        </div>
    </flux-parallax>
<!-- // -->    
        <div class="uk-section uk-section-default">

            <div class="uk-container uk-container-large"> 
                <div class="uk-grid-small uk-grid-column-small  uk-child-width-1-4@m" uk-scrollspy="target: > div; delay: 500" uk-grid>
                    <template v-if="services[0]">
                        <div :uk-scrollspy-class="scrollAnimation[index]" style="box-shadow : none !important" v-for="(s,index) in services[0].sous_section.slice(0,4)" :key="index" class="uk-card uk-card-default uk-card-body uk-border-rounded">
                            <h4>{{s.title}}</h4>
                            <p v-html="s.description.substring(0,200)">...</p>
                            <a :href="'/section/'+services[0].section.slug+'#'+s.slug" class="uk-button uk-button-small uk-border-rounded uk-text-capitalize btn-bg">En savoir plus <span uk-icon="icon : arrow-right"></span></a>
                        </div>
                    </template>
                </div>
                <div class="uk-flex uk-flex-center">
                    <a v-if="services[0]" :href="'/section/'+services[0].section.slug" class="uk-button-small uk-button uk-margin-top">Voir plus <span uk-icon="icon : more"></span></a>
                </div>
            </div>
        </div>


        <hr class="uk-divider-small uk-text-center">

        <!-- CONTACT US -->
        <div class="uk-section uk-section-default" id="contact-us">
            <div class="uk-container uk-container-large">
                <div class="uk-grid-small" uk-grid>
                    <div class="uk-width-2-3@m uk-width-1-1@s">
                        <!-- MAPS -->
                        <!-- <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d995.4841106410481!2d-13.661288253383795!3d9.547774946840587!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0xf1cd1331c633d57%3A0x8558b37657f954e9!2sMadina%2C%20Conakry%2C%20Guin%C3%A9e!5e1!3m2!1sfr!2s!4v1595123368054!5m2!1sfr!2s" width="900" height="600" frameborder="0" style="border:0;" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe> -->
                        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d15738.65334502074!2d-13.676554772469995!3d9.537949740700983!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0xf1cd1331c633d57%3A0x8558b37657f954e9!2sMadina%2C%20Conakry%2C%20Guin%C3%A9e!5e0!3m2!1sfr!2s!4v1597257772872!5m2!1sfr!2s" width="900" height="600" frameborder="0" style="border:0;" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe>
                        <!-- // -->
                    </div>
                <div class="uk-width-1-3@m uk-width-1-1@s uk-margin-remove">
                    <contact-us></contact-us>
                </div>
                </div>
            </div>
        </div>
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
        components: {
            'vue-flux'  : VueFlux,
            'flux-parallax' : FluxParallax,
        },
        props : {
            user : String
        },
        mounted() {
            
        },
        data() {
            return {
                scrollAnimation : [
                    "uk-animation-slide-top",
                    "uk-animation-slide-left",
                    "uk-animation-slide-bottom",
                    "uk-animation-slide-right",
                    "uk-animation-slide-top",
                    "uk-animation-slide-left",
                    "uk-animation-slide-bottom",
                    "uk-animation-slide-right"
                ],
            }
        },
        methods : {

        },
        computed : {
            sectionList() {
                return this.$store.state.sectionList
            },
            services() {
                return this.sectionList.filter((s) => {
                    return s.section.slug == 'services'
                })
            },
            aboutUs() {
                return this.sectionList.filter((s) => {
                    return s.section.slug == 'a-propos'
                })
            }
        }
    }
</script>
