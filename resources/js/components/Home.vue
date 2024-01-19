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
                    <a href="javascript:void(0)" @click="refresh" class="btn btn-outline-primary mx-1">
                        Refresh
                    </a>
                    <!--  Modal trigger button  -->
                    <button
                        type="button"
                        class="btn btn-primary"
                        data-bs-toggle="modal"
                        data-bs-target="#modalId"
                    >
                        Stats
                    </button>
                    
                    <!-- Modal Body-->
                    <div
                        class="modal fade"
                        id="modalId"
                        tabindex="-1"
                        role="dialog"
                        aria-labelledby="modalTitleId"
                        aria-hidden="true"
                    >
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="modalTitleId">
                                        Most visited
                                    </h5>
                                    <button
                                        type="button"
                                        class="btn-close"
                                        data-bs-dismiss="modal"
                                        aria-label="Close"
                                    ></button>
                                </div>
                                <div class="modal-body">
                                    <div class="container-fluid">
                                        <!-- Horizontal under breakpoint -->
                                        <ul
                                            class="list-group list-group-vertical"
                                        >
                                            <li class="list-group-item" v-for="(item, j) in most" :key="j">
                                                <div class="progress">
                                                    <span class="badge bg-info me-1">{{ item.visits }}</span>
                                                    <div
                                                        class="progress-bar bg-info"
                                                        role="progressbar"
                                                        :aria-valuenow="item.visits"
                                                        :style="'width:' + item.percent * 10000 + '%'"
                                                        aria-valuemin="0"
                                                        aria-valuemax="100"
                                                    >
                                                        {{ item.long }}
                                                    </div>
                                                </div>
                                                <small>{{ item.long }}</small>
                                                
                                            </li>
                                        </ul>
                                        
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button
                                        type="button"
                                        class="btn btn-secondary"
                                        data-bs-dismiss="modal"
                                    >
                                        Close
                                    </button>
                                    <button type="button" class="btn btn-primary">Save</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    
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
                                    <span>
                                        <a :href="`/visit/${row.short}`" target="_blank" class="btn btn-link btn-sm">
                                            view
                                        </a>
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
    name : 'Home',
    data () {
        return {
            loaded : true, 
            shorten : false, 
            long : '',
            old_short : null,

            links: null,
            most: null,
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
            axios.get('/api/link')
            .then((res) => {
                this.links = res.data.links;
                this.most = res.data.most;
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
                axios.post('/api/link', request)
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