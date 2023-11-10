<script>



import VueDrawingCanvas from "vue-drawing-canvas";
import { Modal } from 'flowbite-vue'
import { ref } from 'vue';
import { useAuthStore } from '../../stores/auth';
import {show_alerta, show_toast } from '../../functions';


export default {
  name: "ServeDev",
  components: {
    VueDrawingCanvas, Modal
  },
  props:{
        edicion:{type:Boolean,default:false},
        //firma_digital:{type:String,default:this.authStore.firmaManoAlzada}
    },
    emits:['update'],
  data() {
    return {
      authStore : useAuthStore(),
        form: ref({
          firma_digital: '',
        }),
        isShowModal: ref(false),

      initialImage: [
        {
          type: "dash",
          from: {
            x: 262,
            y: 154,
          },
          coordinates: [],
          color: "#000000",
          width: 5,
          fill: false,
        },
      ],
      x: 0,
      y: 0,
      image: this.firma_digital,
      eraser: false,
      disabled: false,
      fillShape: false,
      line: 5,
      color: "#000000",
      strokeType: "dash",
      lineCap: "round",
      lineJoin: "round",
      backgroundColor: "#FFFFFF",
      backgroundImage: null,
      watermark_old:null,
        watermark: {
            // Specifies your watermark type. Type can be either "Text" or "Image"
            //
            // type: String
            // required: true
            // validator: (value) => { return ["Text", "Image"].includes(value) }
            type: "Text",
            // Specifies your watermark source
            // If type is "Text" enter your watermark text here
            // if type if "Image" enter your uploaded file createObjectURL(event.target.files[0]) Work best with .png file
            //
            // type: String
            // required: true
            source: '',
            // The x-axis coordinate of the point at which to begin drawing the watermark,
            // in pixels
            //
            // type: Number
            // required: true
            x: 400,
            // The y-axis coordinate of the point at which to begin drawing the watermark,
            // in pixels
            //
            // type: Number
            // required: true
            y: 100,
            // Specifies width and height for your watermark image
            //
            // type: Object
            // required: false
            imageStyle: {
                // The width to draw the image in the canvas
                //
                // type: Number
                // required: false
                // default: () => this.width
                width: 600,
                // The height to draw the image in the canvas
                //
                // type: Number
                // required: false
                // default: () => this.height
                height: 400
            },
            // Specifies text style for your watermark
            //
            // type: Object
            // required: false
            fontStyle: {
                // The maximum number of pixels wide the text may be once rendered.
                // If not specified, there is no limit to the width of the text.
                //
                // type: Number
                // required: false
                width: 600,
                // Sets the height of text in pixels. Usually this value has same value with font
                //
                // type: Number
                // required: false
                // default: () => 20
                lineHeight: 50,
                // Specifies the color, gradient, or pattern to use for the text
                //
                // type: String
                // required: false
                // default: () => '#000000'
                color: "rgba(231, 10, 10, 0.34)",
                // Specifies the current text style to use when drawing text.
                // font: '{fontWeight} {fontSize} {fontFamily}'
                //
                // type: String
                // required: false
                // default: () => '20px serif'
                font: 'bold 30px serif',
                // Specifies drawing type to use when drawing text.
                //
                // type: String
                // required: false
                // validator: (value) => { return ["fill", "stroke"].includes(value) }
                // default: () => 'fill'
                drawType: 'fill',
                // Specifies the current text alignment used when drawing text
                // The alignment is relative to the x value
                //
                // type: String
                // required: false
                // validator: (value) => { return ["left", "right", "center", "start", "end"].includes(value) }
                // default: () => 'start'
                textAlign: 'center',
                // Specifies the current text baseline used when drawing text
                //
                // type: String
                // required: false
                // validator: (value) => { return ["top", "hanging", "middle", "alphabetic", "ideographic", "bottom"].includes(value) }
                // default: () => 'alphabetic'
                textBaseline: 'alphabetic',
                // The rotation angle, clockwise in radians
                //
                // type: Number
                // required: false
                rotate: 0
            }
},
      additionalImages: [],
    };
  },
  mounted() {
    const authStore = useAuthStore()
    this.form.firma_digital=authStore.firmaManoAlzada
    this.image=this.firma_digital;
    if ("vue-drawing-canvas" in window.localStorage) {
      this.initialImage = JSON.parse(
        window.localStorage.getItem("vue-drawing-canvas")
      );
    }
  },
  methods: {
    save(){
        this.form.firma_digital=this.image;
        console.log(this.form.firma_digital)
        this.sendRequestWithFiles('POST',this.form,'/api/firma_digitalizada');
        //this.form.post(route('firma_digitalizada.store'));
    },

    formReset(){
        this.form.reset();
    },
    formRellenar(){
        this.form.firma_digital="456";
    },
    async setImage(event) {
      let URL = window.URL;
      this.backgroundImage = URL.createObjectURL(event.target.files[0]);
      await this.$refs.VueCanvasDrawing.redraw();
    },
    async setWatermarkImage(event) {
      let URL = window.URL;
      this.watermark = {
        type: "Image",
        source: URL.createObjectURL(event.target.files[0]),
        x: 0,
        y: 0,
        imageStyle: {
          width: 600,
          height: 400,
        },
      };
      await this.$refs.VueCanvasDrawing.redraw();
    },
    getCoordinate(event) {
      let coordinates = this.$refs.VueCanvasDrawing.getCoordinates(event);
      this.x = coordinates.x;
      this.y = coordinates.y;
    },
    getStrokes() {
      window.localStorage.setItem(
        "vue-drawing-canvas",
        JSON.stringify(this.$refs.VueCanvasDrawing.getAllStrokes())
      );
      alert(
        "Strokes saved, reload your browser to see the canvas with previously saved image"
      );
    },
    removeSavedStrokes() {
      window.localStorage.removeItem("vue-drawing-canvas");
      alert("Strokes cleared from local storage");
    },
    closeModal() {
      this.isShowModal = false
    },
    async  sendRequestWithFiles(method, params, url, redirect=''){
    const authStore = useAuthStore();
    let res;
    const config = {
        headers: {
            'Authorization': 'Bearer '+authStore.authToken,
        }
    };
    //await axios.post('/api/get_coordenadas',form,config)
    await axios(
        {
            method:method, url:url, data:params,headers:config.headers
        }
    )
    .then(
        (response) => {
            console.log(response)
            //res= response.data.status,
            show_toast(response.data.message,'success','')
            //this.$emit('update')
            authStore.refreshFirma();
            //this.form.firma_digital=this.authStore.firmaManoAlzada
            
            this.closeModal()
            //emit('update')
            // setTimeout(
            //      ()=>(redirect!=='')?window.location.href=redirect:'',2000
            //  )
        }
    )
    .catch((e)=>{
        //let desc='';
        res = e.data;
        console.log('errores')
        console.log(e)
        //this.form.errors=e.response.data.errors
        show_alerta(e.response.data.message,'error','')
    });
    return res;
}
  },
};
</script>

<template>
  <img v-if="this.authStore.firmaManoAlzada" :src="this.authStore.firmaManoAlzada" alt="Imagen Firma Digital" @dblclick="this.isShowModal=!this.isShowModal">
  <button v-else  @click="this.isShowModal=!this.isShowModal" type="button" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                  Agregar/Cambiar Firma
  </button>
  <Teleport to="body">
    <Modal :size="'lg'" v-if="isShowModal" @close="closeModal">
      <template #body>
        <section class="space-y-6 grid">
          <header>
              <h2 class="text-lg font-medium text-gray-900">Firma Digitalizada</h2>
          </header>

          <div class="w-1/5 inline-block">
          <p>Vista Previa:</p>
          <img class="" height="400" width="200" :src="image" style="border: solid 1px #000000" />
          
        </div>    
        <div class="w-2/5 inline-block">
          <p>Firma Manuscrita</p>
          <vue-drawing-canvas
            class=""
            ref="VueCanvasDrawing"
            v-model:image="image"
            :width="800"
            :height="214"
            :stroke-type="strokeType"
            :line-cap="lineCap"
            :line-join="lineJoin"
            :fill-shape="fillShape"
            :eraser="eraser"
            :lineWidth="line"
            :color="color"
            :background-color="backgroundColor"
            :background-image="backgroundImage"
            :watermark="watermark"
            :initial-image="initialImage"
            saveAs="png"
            outputWidth=600
            outputHeight=160

            :styles="{
              border: 'solid 1px #000',
            }"
            :lock="disabled"
            @mousemove="getCoordinate($event)"
            :additional-images="additionalImages"
          />
          <p>
            x-axis: <strong>{{ x }}</strong
            >, y-axis: <strong>{{ y }}</strong>
          </p>
          <div class="button-container">
            <button type="button" @click.prevent="disabled = !disabled">
              <svg
                xmlns="http://www.w3.org/2000/svg"
                width="16"
                height="16"
                fill="currentColor"
                class="bi bi-lock"
                viewBox="0 0 16 16"
              >
                <path
                  v-if="!disabled"
                  d="M11 1a2 2 0 0 0-2 2v4a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V9a2 2 0 0 1 2-2h5V3a3 3 0 0 1 6 0v4a.5.5 0 0 1-1 0V3a2 2 0 0 0-2-2zM3 8a1 1 0 0 0-1 1v5a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V9a1 1 0 0 0-1-1H3z"
                />
                <path
                  v-else
                  d="M8 1a2 2 0 0 1 2 2v4H6V3a2 2 0 0 1 2-2zm3 6V3a3 3 0 0 0-6 0v4a2 2 0 0 0-2 2v5a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2zM5 8h6a1 1 0 0 1 1 1v5a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1V9a1 1 0 0 1 1-1z"
                />
              </svg>
              <span v-if="!disabled">Unlock</span>
              <span v-else>Lock</span>
            </button>
            <button type="button" @click.prevent="$refs.VueCanvasDrawing.undo()">
              <svg
                xmlns="http://www.w3.org/2000/svg"
                width="16"
                height="16"
                fill="currentColor"
                class="bi bi-arrow-counterclockwise"
                viewBox="0 0 16 16"
              >
                <path
                  fill-rule="evenodd"
                  d="M8 3a5 5 0 1 1-4.546 2.914.5.5 0 0 0-.908-.417A6 6 0 1 0 8 2v1z"
                />
                <path
                  d="M8 4.466V.534a.25.25 0 0 0-.41-.192L5.23 2.308a.25.25 0 0 0 0 .384l2.36 1.966A.25.25 0 0 0 8 4.466z"
                />
              </svg>
              Undo
            </button>
            <button type="button" @click.prevent="$refs.VueCanvasDrawing.redo()">
              <svg
                xmlns="http://www.w3.org/2000/svg"
                width="16"
                height="16"
                fill="currentColor"
                class="bi bi-arrow-clockwise"
                viewBox="0 0 16 16"
              >
                <path
                  fill-rule="evenodd"
                  d="M8 3a5 5 0 1 0 4.546 2.914.5.5 0 0 1 .908-.417A6 6 0 1 1 8 2v1z"
                />
                <path
                  d="M8 4.466V.534a.25.25 0 0 1 .41-.192l2.36 1.966c.12.1.12.284 0 .384L8.41 4.658A.25.25 0 0 1 8 4.466z"
                />
              </svg>
              Redo
            </button>
            <button
              type="button"
              @click.prevent="$refs.VueCanvasDrawing.redraw()"
            >
              <svg
                xmlns="http://www.w3.org/2000/svg"
                width="16"
                height="16"
                fill="currentColor"
                class="bi bi-arrow-repeat"
                viewBox="0 0 16 16"
              >
                <path
                  d="M11.534 7h3.932a.25.25 0 0 1 .192.41l-1.966 2.36a.25.25 0 0 1-.384 0l-1.966-2.36a.25.25 0 0 1 .192-.41zm-11 2h3.932a.25.25 0 0 0 .192-.41L2.692 6.23a.25.25 0 0 0-.384 0L.342 8.59A.25.25 0 0 0 .534 9z"
                />
                <path
                  fill-rule="evenodd"
                  d="M8 3c-1.552 0-2.94.707-3.857 1.818a.5.5 0 1 1-.771-.636A6.002 6.002 0 0 1 13.917 7H12.9A5.002 5.002 0 0 0 8 3zM3.1 9a5.002 5.002 0 0 0 8.757 2.182.5.5 0 1 1 .771.636A6.002 6.002 0 0 1 2.083 9H3.1z"
                />
              </svg>
              Refresh
            </button>
            <button type="button" @click.prevent="$refs.VueCanvasDrawing.reset()">
              <svg
                xmlns="http://www.w3.org/2000/svg"
                width="16"
                height="16"
                fill="currentColor"
                class="bi bi-file-earmark"
                viewBox="0 0 16 16"
              >
                <path
                  d="M14 4.5V14a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V2a2 2 0 0 1 2-2h5.5L14 4.5zm-3 0A1.5 1.5 0 0 1 9.5 3V1H4a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1V4.5h-2z"
                />
              </svg>
              Reset
            </button>
          </div>
          
        </div>
        <div class="flex items-center gap-4">
          
                  
                  
                  <button @click="save()" type="button" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                    Guardar Firma
                  </button>

                  

                  
      </div>
          </section>
      </template>
    </Modal>
    </Teleport>

</template>

<style scoped>
@import url("https://fonts.googleapis.com/css2?family=Roboto:ital,wght@1,700&display=swap");
body {
  font-family: "Roboto", sans-serif;
}
.flex-row {
  display: flex;
  flex-direction: row;
}
.button-container {
  display: flex;
  flex-direction: row;
}
.button-container > * {
  margin-top: 15px;
  margin-right: 10px;
}
</style>