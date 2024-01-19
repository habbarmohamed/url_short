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
                <input type="text" id="shortenedURL" v-model="old_short" class="form-control" v-on:focus="$event.target.select()" ref="clone" readonly>
                <div class="input-group-append">
                    <button id="copyButton" class="btn btn-secondary" @click="copy(old_short)">Copy</button>
                </div>
                </div>
            </div>
            <!-- Container to display the saved shortened URLs -->
            <div class="mt-5">
                <h2>Saved Shortened URLs:</h2>
                <div class="d-flex justify-content-end my-2">
                    <a href="javascript:void(0)" @click="refresh" class="btn btn-outline-primary">
                        Refresh
                    </a>
                </div>

                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Shortened URL</th>
                            <th>Full URL</th>
                            <th>Visits</th>
                            <th>Date Time</th>
                        </tr>
                    </thead>
                    <tbody>
                            <tr v-for="(row, i) in links" :key="i">
                                <td>
                                    <span>{{  row.short }}</span>
                                    <span>
                                        <button type="button" @click="copy(row.short)" class="btn btn-link btn-sm">
                                            copy
                                        </button>
                                    </span>
                                </td>
                                <td>
                                    {{  row.long }}
                                </td>
                                <td>
                                    {{  row.visits }}
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
            old_short : null,

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
                    this.shorten = true;
                    this.old_short = res.data.data.short;
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

        copy(short) {
            navigator.clipboard.writeText(`127.0.0.1:8000/visit/${short}`);
            alert('copied');
        },

        refresh() {
            this.loadData();
        }
    },
    mounted() {
        this.loadData();
    }
}
</script>