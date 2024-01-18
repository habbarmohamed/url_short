require('./bootstrap');


import { createApp } from "vue";
import Vue from 'vue'

import router from "./router";
import Home from "./components/Home.vue";



/* import the fontawesome core */
import { library } from '@fortawesome/fontawesome-svg-core'

/* import font awesome icon component */
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'

/* import specific icons */
import { fas } from '@fortawesome/free-solid-svg-icons'
import { far } from '@fortawesome/free-regular-svg-icons'
import { fab } from '@fortawesome/free-brands-svg-icons'

/* add icons to the library */
library.add(fas, far, fab)


createApp({
    components: {
        Home,
    }
})
.use(FontAwesomeIcon)
.use(router)
.mount('#app')