<template>
  <div>
    <Loading :active.sync="isLoading" 
        :can-cancel="true" 
        :is-full-page="fullPage"></Loading>

      <div class="uk-container">
        <ul class="uk-subnav uk-margin-top" uk-switcher="animation: uk-animation-slide-left-medium, uk-animation-slide-right-medium">
            <li><a href="#" class="uk-button uk-button-small uk-button-primary uk-border-rounded" style="color : #fff"> Toutes les sections</a></li>
            <li><a href="#" class="uk-button uk-button-small uk-button-primary uk-border-rounded" style="color : #fff">Ajouter une sous section</a></li>
        </ul>

        <!-- MODAL EDIT SECTION -->
        <div id="modal-edit-section" uk-modal>
            <div class="uk-modal-dialog uk-modal-body">
                <h2 class="uk-modal-title">Section</h2>
                <form @submit.prevent="sendEditSectionRequest()" uk-grid class="uk-grid-small">
                  <div class="uk-width-1-1@m uk-margin-small">
                    <label for="">Titre *</label>
                    <input v-model="editSectionData.title" type="text" class=" uk-input uk-border-rounded" placeholder="Titre de la section">
                  </div>
                  <div class="uk-width-1-3@m uk-margin-small">
                    <label for="">Position</label>
                    <input type="number" v-model="editSectionData.position" class="uk-input uk-border-rounded">
                  </div>
                  <div class="uk-width-1-1@m">
                    <button type="submit" class="uk-button uk-button-small uk-button-primary uk-border-rounded">Validez</button>                  
                  </div>
                </form>
                <p class="uk-text-right">
                    <button class="uk-button uk-button-small uk-button-danger uk-border-rounded uk-modal-close" type="button">Fermer</button>
                </p>
            </div>
        </div> 
        <!-- // -->
        <!-- MODAL EDIT SOUS SECTION -->
        <!-- This is the modal -->
        <div id="modal-edit" uk-modal>
            <div class="uk-modal-dialog uk-modal-body">
                <h2 class="uk-modal-title">Sous section</h2>
                <form @submit.prevent="sendEditRequest()" uk-grid class="uk-grid-small">
                  <div class="uk-width-1-1@m">
                    <input type="checkbox" value="delete" v-model="editFormData.deleteState">
                    <span class="uk-alert-danger">Supprimer</span>
                  </div>
                  <div class="uk-width-1-1@m uk-margin-small">
                    <label for="">Titre *</label>
                    <input v-model="editFormData.title" type="text" class=" uk-input uk-border-rounded" placeholder="Titre de la section">
                  </div>
                  <div class="uk-width-1-1@m uk-margin-small">
                    <label for="">Section *</label>
                    <span class="uk-input uk-border-rounded">{{editFormData.id_section}}</span>
                  </div>
                  <div class="uk-width-1-3@m uk-margin-small">
                    <label for="">Position</label>
                    <input type="number" v-model="editFormData.position" class="uk-input uk-border-rounded" placeholder="Position">
                  </div>
                  <div class="uk-margin-small">
                    <input type="file" @change="editFileUpdload()">
                    <img :src="'/illustration-img/'+editFormData.illustration" height="200" width="200" alt="">
                  </div>
                  <div class="uk-width-1-1@m uk-margin-small">
                    <label for="">Description *</label>
                    <wysiwyg v-model="editFormData.description" />
                  </div>
                  <div class="uk-width-1-1@m">
                    <button type="submit" class="uk-button uk-button-small uk-button-primary uk-border-rounded">Validez</button>                  
                  </div>
                </form>
                <p class="uk-text-right">
                    <button class="uk-button uk-button-small uk-button-danger uk-border-rounded uk-modal-close" type="button">Fermer</button>
                </p>
            </div>
        </div>  
        <!-- // -->

        <ul class="uk-switcher uk-margin">
          <li>
            <div class="uk-width-1-2@m">
              <ul uk-accordion>
                  <li v-for="s in sousSectionList" :key="s.section.slug" class="uk-close">
                      <a class="uk-accordion-title" href="#">{{s.section.title}}</a>
                      <a class="uk-button-small" @click="editSection(s.section)"><span uk-icon="pencil"></span> Editer</a>
                      <div class="uk-accordion-content">
                        <ul class="uk-list">
                          <li v-for="ss in s.sous_section" :key="ss.slug"><a @click="editSSection(ss)" href="#">{{ss.title}}</a></li>
                        </ul>
                      </div>
                  </li>
              </ul>            
            </div>
          </li>
          <li>
            <!-- add sections -->
              <form @submit.prevent="addSousSection()" class="uk-width-1-2@m uk-margin-bottom">
                <div v-for="err in errors" :key="err" uk-alert class="uk-alert-danger uk-border-rounded">
                    <a class="uk-alert-close" uk-close></a>
                    <p>{{err}}</p>
                </div>
                <div class="uk-width-1-1@m uk-margin-small">
                  <label for="">Titre *</label>
                  <input type="text" v-model="dataForm.title" class=" uk-input uk-border-rounded" placeholder="Titre de la section">
                </div>
                <div class="uk-width-1-1@m uk-margin-small">
                  <label for="">Section *</label>
                  <select v-model="dataForm.section_slug" class="uk-select uk-border-rounded">
                    <option value="">-- Section --</option>
                    <option :value="s.slug" v-for="s in sectionsList" :key="s.slug" >{{s.title}}</option>
                  </select>
                </div>
                <div class="uk-margin-small">
                  <input type="file" @change="fileUpload">
                </div>
                <div class="uk-width-1-1@m uk-margin-small">
                  <label for="">Description *</label>
                  <wysiwyg v-model="dataForm.content" />
                </div>
                <button class="uk-button uk-button-small uk-button-primary uk-border-rounded">Validez</button>
              </form>
            <!-- // -->
          </li>
        </ul>
      </div>
  </div>
</template>
<script>
import Loading from 'vue-loading-overlay';
 // Import component
import 'vue-loading-overlay/dist/vue-loading.css';
 // Import stylesheet
import wysiwyg from "vue-wysiwyg";
Vue.use(wysiwyg, {});

export default {
  components :  {
    Loading
  },
  created() {
    this.sectionList()
  },
  mounted() {
  },
  data() {
    return {
      isLoading : false,
      fullPage : true,
      dataForm : {
        _token : document.querySelector("meta[name=csrf-token]").content,
        title : "",
        content : "",
        image : "",
        section_slug : ""
      },
      sectionsList : [],
      sousSectionList : [],
      errors : [],
      activeSection : "",
      editFormData : {},
      editSectionData : {}
    }
  },
  methods : {
    editSSection :async function (ss) {
      try { 
          this.editFormData = ss
          UIkit.modal($("#modal-edit")).show()
      } catch(error) {
          alert(error)
      }
    },
    editSection : function (s) {
      this.editSectionData = s
      UIkit.modal($("#modal-edit-section")).show()
    },
    editFileUpdload : function (e) {
      this.editFormData.illustration = e.target.files[0]
    },
    fileUpload : function (e) {
      this.dataForm.image = e.target.files[0]
    },
    sectionList : async function () {
      try {
          let response = await axios.get('/get-sections')
          if(response) {
            this.sectionsList = response.data.section
            this.sousSectionList = response.data.sous_section
          }
      } catch(error) {
          alert(error)
      }
    },
    sendEditSectionRequest : async function () {
      try {
        this.isLoading = true
        UIkit.modal($("#modal-edit-section")).hide()
        let response = await axios.post('/edit-section',{
          _token : document.querySelector("meta[name=csrf-token").content,
          title : this.editSectionData.title,
          position : this.editSectionData.position,
          slug : this.editSectionData.slug
        })
        if(response && response.data == 'done') {
          this.isLoading = false
          UIkit.modal($("#modal-edit-section")).hide()
          alert("Success")
          Object.assign(this.$data,this.$options.data())
          this.sectionList()
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
    },
    sendEditRequest : async function () {
      try {
        this.isLoading = true
          this.editFormData._token = document.querySelector("meta[name=csrf-token]").content
          let response = await axios.post('/edit-sous-section',this.editFormData)
          if(response && response.data) {
            this.isLoading = false
            alert("Success !")
            UIkit.modal($("#modal-edit")).hide()
            Object.assign(this.$data,this.$options.data())
            this.sectionList()
          }
      } catch(error) {
        this.isLoading = false
          alert(error)
      }
    },
    addSousSection : async function () {
      try {
        this.isLoading = true
        var theForm = new FormData()
        theForm.append('_token',this.dataForm._token)
        theForm.append('title',this.dataForm.title)
        theForm.append('content',this.dataForm.content)
        theForm.append('image',this.dataForm.image)
        theForm.append('section',this.dataForm.section_slug)

          
        let response = await axios.post('/add-sous-section',theForm,{
          headers : {
            'content-type'  : 'multipart/form-data'
          }
        })
          
        if(response && response.data == 'done') {
          this.isLoading = false
          alert("Success!")
          Object.assign(this.$data,this.$options.data())
          this.sectionList()
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
  }
}
</script>