<template>
    <div>
        <div class="container mt-5">
            <div class="text-center">
                <h1>Shorten Your Loooong Links :)</h1>
                <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Reprehenderit beatae voluptatum aspernatur culpa sunt illo natus aliquid quaerat labore.</p>
            </div>
            <form id="shortenForm" class="mt-3">
                <!-- Input field for the long URL -->
                <div class="input-group">
                <input type="text" id="urlInput" class="form-control" placeholder="Enter the link here" v-model="long" required>
                <div class="input-group-append">
                    <button type="submit" class="btn btn-primary" @click="store">Shorten Now!</button>
                </div>
                </div>
            </form>
            <!-- Container to display the shortened URL and Copy button -->
            <div id="shortenedURLContainer" class="mt-3" v-if="shorten">
                <h2>Shortened URL:</h2>
                <div class="input-group">
                <input type="text" id="shortenedURL" class="form-control" readonly>
                <div class="input-group-append">
                    <button id="copyButton" class="btn btn-secondary">Copy</button>
                </div>
                </div>
            </div>
            <!-- Container to display the saved shortened URLs -->
            <div class="mt-5">
                <h2>Saved Shortened URLs:</h2>
                <FontAwesomeIcon icon="fas fa-user" size="2xl" />

                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Shortened URL</th>
                            <th>Full URL</th>
                            <th>Website</th>
                            <th>Visits</th>
                            <th>Date Time</th>
                        </tr>
                    </thead>
                    <tbody>
                            <tr v-for="(row, i) in links" :key="i">
                                <td>
                                    <span>{{  row.short }}</span>
                                    <span>
                                        <a href="javascript:void(0)" class="btn btn-link">
                                        </a>
                                    </span>
                                </td>
                                <td>
                                    {{  row.long }}
                                </td>
                                <td>
                                    
                                </td>
                                <td>
                                    0
                                </td>
                                <td>
                                    {{  getDate(row.created_at) + ' ' + getTime(row.created_at) }}
                                </td>
                            </tr>
                        
                    </tbody>
                </table>
            </div>
            </div>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    name : 'AddAttributeComponent',
    data () {
        return {
            loaded : true, 
            shorten : false, 
            long : '',

            links: null
        }
    },
    computed : {
           
    },

    methods: {
        back(){ this.$router.go(-1) },
        clear () {
            this.long = null;
        },

        loadData() {
            axios.get('/api/link', 
            // {
            // headers: {
            //       Authorization: 'Bearer ' + this.currentUser.token,
            //     }
            // }
            )
            .then((res) => {
                this.links = res.data.links;
                this.loaded = false;
            })
            .catch((error) => {
                alert(error);
            })  
        },

        store (e) { 
            e.preventDefault();
            let self = this;
                let request = {
                    long : self.long,
                };
                axios.post('/api/link', request, 
                // {
                //     headers: {
                //         Authorization: 'Bearer ' + self.currentUser.token,
                //     }
                // }
                )
                .then((res) => {
                    this.clear();
                    this.loadData();
                })
                .catch((error) => {
                    alert(error);
                })
            
        },

        getDate(datetime) {
                let date = new Date(datetime).toJSON().slice(0,10).replace(/-/g,'/')
                return date
        },

        getTime(datetime) {
                let time = new Date(datetime).toLocaleTimeString();
                return time 
        },
    },
    mounted() {
        this.loadData();
    }
}
</script>