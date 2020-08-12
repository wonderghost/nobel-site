<template>
    <div>
        <nav class="uk-navbar-container bg-nav uk-box-shadow-small" uk-sticky="animation: uk-animation-slide-top " uk-navbar>
            <div class="uk-navbar-left">
                <a style="color : #000 !important" class="uk-navbar-item uk-logo" href="/"><img src="/img/logo.png" alt=""></a>
            </div>
            <div class="uk-navbar-left uk-visible@m">
                <ul class="uk-navbar-nav">
                    <!-- <li><a href="/" class="menu-link"><span uk-icon="home"></span></a></li> -->
                    <li v-for="i in withParent" :key="i.section.slug">
                        <a class="menu-link uk-padding-small" :href="'/section/'+i.section.slug">{{i.section.title}}</a>
                        <div class="uk-border-rounded" uk-dropdown="offset: 0" v-if="i.sous_section.length > 0">   
                            <ul class="uk-nav uk-dropdown-nav">
                                <li class="" v-for="k in i.sous_section" :key="k.slug"><a class="" :href="'/section/'+i.section.slug+'#'+k.slug"><span uk-icon="icon : link"></span> {{k.title}}</a></li>
                            </ul>
                        </div>
                    </li>
                    <li><a class="menu-link" href="#contact-us" uk-scroll>Contactez Nous</a></li>
                </ul>
            </div>
            <div class="uk-navbar-right uk-visible@m">
                <ul class="uk-navbar-nav">
                    <li v-if="user">
                        <a href="#" class="menu-link">Admin</a>
                        <div uk-dropdown="pos: bottom-justify">
                            <ul class="uk-nav uk-dropdown-nav">
                                <li><a href="/home">Gestion du Contenu</a></li>
                                <li>
                                    <a class="" @click="logOut()">Logout <span uk-icon="icon : sign-out"></span></a>
                                </li>
                            </ul>
                        </div>
                    </li>
                </ul>
            </div>
            <!-- mobile menu -->
            <div class="uk-navbar-right uk-hidden@m">
                <a class="uk-button uk-button-default uk-border-rounded uk-margin-right" uk-toggle="target: #offcanvas-nav" style="color : #fff !important;"><span uk-icon="menu"></span></a>
            </div>

            <div id="offcanvas-nav" uk-offcanvas="overlay: true;mode : slide ; flip : true ;">
                <div class="uk-offcanvas-bar">

                    <ul class="uk-nav uk-nav-default">
                        <li><a href="/" class="menu-link">Acceuil</a></li>
                        <li v-for="i in withParent" :key="i.section.slug" class="uk-parent">
                        <a class="menu-link" :href="'/section/'+i.section.slug">{{i.section.title}}</a>
                        <ul class="uk-nav-sub" v-if="i.sous_section.length > 0">
                            <li class="" v-for="k in i.sous_section" :key="k.slug"><a class="menu-link" :href="'/section/'+i.section.slug+'#'+k.slug"><span uk-icon="icon : link"></span> {{k.title}}</a></li>
                        </ul>
                    </li>
                    </ul>

                </div>
            </div>            
            <!-- // -->
        </nav>        
    </div>
</template>
<script>
    export default {
        props : {
            user : String
        },
        mounted() {
            this.sectionList()
        },
        data() {
            return {
                sectionsList : []
            }
        },
        methods : {
            sectionList : async function () {
                try {
                    let response = await axios.get('/get-section')
                    if(response) {
                        this.sectionsList = response.data.sous_section
                        this.$store.commit('setSection',response.data.sous_section)
                    }
                } catch(error) {
                    alert(error)
                }
            },
            logOut : async function () {
                try {
                    let response = await axios.post('/logout')
                    if(response) {
                        location.reload()
                    }
                } catch(error) {
                    alert(error)
                }
            }
        },
        computed : {
            // avec sous menu 
            withParent() {
                return this.sectionsList.filter((s) => {
                    return s.section.parent == 1
                })
            },
        }
    }
</script>
