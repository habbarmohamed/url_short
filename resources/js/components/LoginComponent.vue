<template>
    <div class="limiter">
        <div class="container-login100">
            
            <div class="wrap-login100">
                <form class="login100-form validate-form" @submit.prevent="authenticate">
               
                    <div class="form-group row" v-if="authError">
                        <p class="error typingEffect">
                            <svg id="Capa_1" style="vertical-align: baseline;" enable-background="new 0 0 337.646 337.646" height="20" viewBox="0 0 337.646 337.646" width="20" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"><linearGradient id="SVGID_1_" gradientUnits="userSpaceOnUse" x1="285.032" x2="52.616" y1="350.615" y2="118.195"><stop offset="0" stop-color="#e63c46"/><stop offset="1" stop-color="#eaa953"/></linearGradient><g><g><path d="m258.35 162.972-4.072-7.056c-1.955-3.335-.837-7.624 2.498-9.579s7.624-.837 9.579 2.498c.016.027.031.054.047.081l4.072 7.056c1.955 3.335.837 7.624-2.498 9.579s-7.624.837-9.579-2.498c-.016-.026-.032-.054-.047-.081zm-10.992-33.04c3.347-1.932 4.495-6.212 2.564-9.56l-48.48-83.956c-10.398-18.013-33.43-24.187-51.443-13.789-5.727 3.306-10.483 8.062-13.789 13.789l-131.16 227.16c-10.398 18.016-4.223 41.05 13.792 51.448 5.723 3.303 12.215 5.043 18.824 5.044h262.32c20.801-.002 37.662-16.867 37.66-37.668-.001-6.608-1.74-13.1-5.044-18.824l-45.716-79.2c-1.933-3.349-6.215-4.497-9.564-2.564s-4.497 6.215-2.564 9.564l45.72 79.2c6.532 11.32 2.652 25.792-8.668 32.324-3.595 2.075-7.673 3.167-11.824 3.168h-262.32c-13.069-.002-23.662-10.599-23.66-23.668.001-4.151 1.093-8.229 3.168-11.824l131.16-227.172c6.532-11.317 21.001-15.197 32.319-8.665 3.599 2.077 6.588 5.066 8.665 8.665l48.48 83.968c1.931 3.346 6.21 4.493 9.556 2.562.002 0 .003-.001.004-.002zm-54.2 68.14c-.001 13.438-10.896 24.331-24.334 24.33-13.436-.001-24.329-10.893-24.33-24.33v-71.004c.001-13.438 10.896-24.331 24.334-24.33 13.436.001 24.329 10.893 24.33 24.33zm-14-71.004c0-5.706-4.626-10.332-10.332-10.332s-10.332 4.626-10.332 10.332v71.004c0 5.706 4.626 10.332 10.332 10.332s10.332-4.626 10.332-10.332zm14 130.088c-.004 13.438-10.902 24.328-24.34 24.324s-24.328-10.902-24.324-24.34c.004-13.435 10.897-24.324 24.332-24.324 13.435.016 24.321 10.905 24.332 24.34zm-14 0c-.002-5.706-4.63-10.33-10.336-10.328s-10.33 4.63-10.328 10.336c.002 5.705 4.627 10.328 10.332 10.328 5.705-.006 10.328-4.631 10.332-10.336z" fill="url(#SVGID_1_)"/></g></g></svg>
                            {{authError}}
                        </p>
                    </div>
                    
                    <span class="login100-form-title p-b-43 mb-3 mt-5">
                        Connectez-vous pour continuer
                    </span>
                    
                    
                    <div class="wrap-input100 validate-input" data-validate="Valid email is required: ex@abc.xyz">
                        <input class="input100" type="text" name="email" v-model="formLogin.email">
                        <span class="label-input100" v-if="formLogin.email == ''">Email</span>
                        <span class="label-input100" v-else style="top: 9px;font-size: 13px;">Email</span>
                    </div>
                    <div class="wrap-input100 validate-input" :class="`${authError ? 'red-border' : ''}`" data-validate="Password is required">
                        <input class="input100" :type="type" name="pass" v-model="formLogin.password">
                        <span class="focus-input100"></span>
                        <span class="label-input100" v-if="formLogin.password == ''">Mot de passe</span>
                        <span class="label-input100" v-else style="top: 9px;font-size: 13px;">Mot de passe</span>
                    </div>
                    <div class="flex-sb-m w-full p-t-3 p-b-32">
                        <div class="contact100-form-checkbox mb-3">
                            <input class="input-checkbox100" @change="showPassword" id="showpwd" type="checkbox" name="show-pwd">
                            <label class="label-checkbox100" for="showpwd">
                            Afficher mot de passe
                            </label>
                        </div>
                    </div>
                    <div class="container-login100-form-btn mt-5">
                        <button class="login100-form-btn" v-if="loaded == false ">
                            Se connecter
                        </button>
                        <button class="buttonload login100-form-btn" v-if="loaded == true ">
                            <i class="fa fa-spinner fa-spin"></i>
                            Loading...
                        </button>
                    </div>
                </form>
            <div class="login100-more" style="background-image: url('/public/assets/img/logo_app.jpg');">
            </div>
            </div>
        </div>
    </div>
</template>

<script>

import axios from 'axios'

export default {
    data() {
        return{

            type: 'password',
            formLogin: {
                email: '',
                password: ''
            },

            error: null,

            loaded: false
            

        }
        
    },

    methods: {
        // handleLogin() {
        //     auth.signin(this, this.email, this.password)
        // }
        showPassword() {
            if(this.type === 'password') {
                this.type = 'text'
            } else {
                this.type = 'password'
            } 
        },
        authenticate(){
            this.$store.dispatch('login');
            this.loaded = true
            login(this.$data.formLogin)
                .then(res => {
                    this.loaded = false;
                    this.$store.commit("loginSuccess", res);
                    this.$router.push({path: '/dashboard'});
                    
                })
                .catch(error => {
                    this.loaded = false;
                    this.$store.commit("loginFailed", {error});
                })
        },
    },

}
</script>

<style >
.buttonload {
  color: white; /* White text */
  padding: 12px 24px; /* Some padding */
  font-size: 16px; /* Set a font-size */
}

/* Add a right margin to each icon */
.fa {
  margin-left: -12px;
  margin-right: 8px;
}
.error{color:#ff0707 !important;}
a{font-size:14px;line-height:1.7;color:#666;margin:0;transition:all .4s;-webkit-transition:all .4s;-o-transition:all .4s;-moz-transition:all .4s}
a:focus{outline:none!important}a:hover{text-decoration:none;color:#6675df}
h1,h2,h3,h4,h5,h6{margin:0}
p{font-size:14px;line-height:1.7;color:#666;margin:0}
ul,li{margin:0;list-style-type:none}
input{outline:none;border:none}
textarea{outline:none;border:none}
textarea:focus,input:focus{border-color:transparent!important}
input:focus::-webkit-input-placeholder{color:transparent}
input:focus:-moz-placeholder{color:transparent}
input:focus::-moz-placeholder{color:transparent}
input:focus:-ms-input-placeholder{color:transparent}
textarea:focus::-webkit-input-placeholder{color:transparent}
textarea:focus:-moz-placeholder{color:transparent}
textarea:focus::-moz-placeholder{color:transparent}
textarea:focus:-ms-input-placeholder{color:transparent}
input::-webkit-input-placeholder{color:#999}
input:-moz-placeholder{color:#999}
input::-moz-placeholder{color:#999}
input:-ms-input-placeholder{color:#999}
textarea::-webkit-input-placeholder{color:#999}
textarea:-moz-placeholder{color:#999}
textarea::-moz-placeholder{color:#999}
textarea:-ms-input-placeholder{color:#999}
label{display:block;margin:0}
button{outline:none!important;border:none;background:0 0}
button:hover{cursor:pointer}iframe{border:none!important}
.txt1{font-size:13px;line-height:1.4;color:#555}
.txt2{font-size:13px;line-height:1.4;color:#999}
.size1{width:355px;max-width:100%}.size2{width:calc(100% - 43px)}
.bg1{background:#3b5998}.bg2{background:#1da1f2}
.bg3{background:#cd201f}.limiter{width:100%;margin:0 auto}
.container-login100{width:100%;min-height:100vh;display:-webkit-box;display:-webkit-flex;display:-moz-box;display:-ms-flexbox;display:flex;flex-wrap:wrap;justify-content:center;align-items:center;background:#f2f2f2}
.wrap-login100{width:100%;background:#fff;overflow:hidden;display:-webkit-box;display:-webkit-flex;display:-moz-box;display:-ms-flexbox;display:flex;flex-wrap:wrap;align-items:stretch;flex-direction:row-reverse}
.login100-more{width:calc(100% - 560px);background-repeat:no-repeat;background-size:cover;background-position:center;position:relative;z-index:1}
.login100-more::before{content:"";display:block;position:absolute;z-index:-1;width:100%;height:100%;top:0;left:0;background:rgba(0,0,0,.1)}
.login100-form{width: 560px;
    min-height: 100vh;
    display: block;
    /*background-color: #f7f7f7;*/
    background-color:#ffffff;
    padding: 10px 55px 0px}
.login100-form-title{width:100%;display:block;font-size:20px;color:#333;text-align:center}
.wrap-input100{display:-webkit-box;display:-webkit-flex;display:-moz-box;display:-ms-flexbox;display:flex;flex-wrap:wrap;align-items:flex-end;width:100%;height:80px;position:relative;border:1px solid #e6e6e6;border-radius:10px;margin-bottom:10px; margin-top:10px;}
.label-input100{font-size:18px;color:#999;line-height:1.2;display:block;position:absolute;pointer-events:none;width:100%;padding-left:24px;left:0;top:30px;-webkit-transition:all .4s;-o-transition:all .4s;-moz-transition:all .4s;transition:all .4s}
.input100{display:block;width:100%;background:0 0;font-size:18px;color:#555;line-height:1.2;padding:0 26px}
input.input100{height:100%;-webkit-transition:all .4s;-o-transition:all .4s;-moz-transition:all .4s;transition:all .4s}.focus-input100{position:absolute;display:block;width:calc(100% + 2px);height:calc(100% + 2px);top:-1px;left:-1px;pointer-events:none;border:1px solid #6675df;border-radius:10px;visibility:hidden;opacity:0;-webkit-transition:all .4s;-o-transition:all .4s;-moz-transition:all .4s;transition:all .4s;-webkit-transform:scaleX(1.1) scaleY(1.3);-moz-transform:scaleX(1.1) scaleY(1.3);-ms-transform:scaleX(1.1) scaleY(1.3);-o-transform:scaleX(1.1) scaleY(1.3);transform:scaleX(1.1) scaleY(1.3)}.input100:focus+.focus-input100{visibility:visible;opacity:1;-webkit-transform:scale(1);-moz-transform:scale(1);-ms-transform:scale(1);-o-transform:scale(1);transform:scale(1)}.eff-focus-selection{visibility:visible;opacity:1;-webkit-transform:scale(1);-moz-transform:scale(1);-ms-transform:scale(1);-o-transform:scale(1);transform:scale(1)}.input100:focus{height:48px}.input100:focus+.focus-input100+.label-input100{top:14px;font-size:13px}.has-val{height:48px!important}.has-val+.focus-input100+.label-input100{top:14px;font-size:13px}.input-checkbox100{display:none}.label-checkbox100{font-size:13px;color:#999;line-height:1.4;display:block;position:relative;padding-left:26px;cursor:pointer}
.label-checkbox100::before{content:"\2714";font-size:13px;color:transparent;display:-webkit-box;
display:-webkit-flex;display:-moz-box;display:-ms-flexbox;display:flex;justify-content:center;align-items:center;position:absolute;width:18px;height:18px;border-radius:2px;background:#fff;
border:1px solid #0eb0b0;left:0;top:50%;-webkit-transform:translateY(-50%);-moz-transform:translateY(-50%);-ms-transform:translateY(-50%);-o-transform:translateY(-50%);transform:translateY(-50%)}.input-checkbox100:checked+.label-checkbox100::before{color:#0eb0b0}.container-login100-form-btn{width:100%;display:-webkit-box;display:-webkit-flex;display:-moz-box;display:-ms-flexbox;display:flex;flex-wrap:wrap;justify-content:center}.login100-form-btn{display:-webkit-box;display:-webkit-flex;display:-moz-box;display:-ms-flexbox;display:flex;justify-content:center;align-items:center;padding:0 20px;width:100%;height:50px;border-radius:10px;background:#0eb0b0;font-size:12px;color:#fff;line-height:1.2;text-transform:uppercase;letter-spacing:1px;-webkit-transition:all .4s;-o-transition:all .4s;-moz-transition:all .4s;transition:all .4s}.login100-form-btn:hover{background:#333}@media(max-width:992px){.login100-form{width:50%;padding-left:30px;padding-right:30px}.login100-more{width:50%}}@media(max-width:768px){.login100-form{width:100%}.login100-more{display:none}}@media(max-width:576px){.login100-form{padding-left:15px;padding-right:15px;padding-top:70px}}.validate-input{position:relative}.alert-validate::before{content:attr(data-validate);position:absolute;z-index:100;max-width:70%;background-color:#fff;border:1px solid #c80000;border-radius:2px;padding:4px 25px 4px 10px;top:50%;-webkit-transform:translateY(-50%);-moz-transform:translateY(-50%);-ms-transform:translateY(-50%);-o-transform:translateY(-50%);transform:translateY(-50%);right:12px;pointer-events:none;color:#c80000;font-size:13px;line-height:1.4;text-align:left;visibility:hidden;opacity:0;-webkit-transition:opacity .4s;-o-transition:opacity .4s;-moz-transition:opacity .4s;transition:opacity .4s}.alert-validate::after{content:"\f12a";display:block;position:absolute;z-index:110;color:#c80000;font-size:16px;top:50%;-webkit-transform:translateY(-50%);-moz-transform:translateY(-50%);-ms-transform:translateY(-50%);-o-transform:translateY(-50%);transform:translateY(-50%);right:18px}.alert-validate:hover:before{visibility:visible;opacity:1}@media(max-width:992px){.alert-validate::before{visibility:visible;opacity:1}}.login100-form-social-item{width:36px;height:36px;font-size:18px;color:#fff;border-radius:50%}.login100-form-social-item:hover{background:#333;color:#fff}

.typingEffect {
    color: #e82525;
    white-space: nowrap;
    overflow: hidden;
    border-right: 2px solid #d24848;
    -webkit-animation: type 4s steps(30, end), cursorblink 1s step-end infinite;
    animation: type 2s steps(30, end), cursorblink 1s step-end infinite;
}

@keyframes type {
   from { width: 0; }
   to { width:460px; }
}
 
@keyframes cursorblink{
  from, to {border-color: transparent}
  50%{ border-color:#424242}
} 

/* input:not([value=""]):not(:focus):invalid {
  background-color: red ;
} */
input:not(:empty):not(:invalid){
 border: 1px red solid;
}

</style>