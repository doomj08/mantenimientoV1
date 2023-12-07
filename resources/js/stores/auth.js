import axios from "axios";
import { defineStore } from "pinia";
import {show_alerta } from '../functions';

export const useAuthStore = defineStore('auth',{
    state: ()=>({ authUser: null, authToken: null, firmaManoAlzada:null}),
    getters:{
        user:(state)=>state.authUser,
        token:(state)=>state.authToken,
        firma_mano_alzada:(state)=>state.firmaManoAlzada,
    },
    actions:{
        async getToken(){
            await axios.get('/sanctum/csrf-cookie');
        },
        async login(form){
            await this.getToken();
            await axios.post('/api/auth/login',form).then(
                (res)=>{
                    console.log(res.data)
                    this.authToken = res.data.token,
                    this.authUser = res.data.user,
                    this.firmaManoAlzada=res.data.firma_mano_alzada.firma_digital
                    this.router.push('/');
                }
            ).catch(
                (errors)=>{
                    console.log(errors)
                    show_alerta(errors, 'error','');
                }
            )
        },
        async refreshFirma(){
            await this.getToken();
            await axios.get('/api/firma_digitalizada').then(
                (res)=>{
                    this.firmaManoAlzada=res.data.firma_mano_alzada.firma_digital
                }
            ).catch(
                (errors)=>{
                    console.log(errors)
                    show_alerta(errors.response.data, 'error','');
                }
            )
        },
        async register(form){
            
            await this.getToken();
            await axios.post('/api/auth/register',form).then(
                (res)=>{
                    show_alerta(res.data.message,'success','');
                    setTimeout( ()=> this.router.push('/login'),2000);
                }
            ).catch(
                (errors)=>{
                    console.log(errors)
                    let desc = '';
                    errors.response.data.errors.map(
                        (e)=>{desc = desc +' ' +e}
                    )
                    show_alerta(desc, 'error','');
                }
            )
        },
        async logout(){
            //await axios.get('/api/auth/logout',this.authToken);
            this.authToken=null;
            this.authUser=null;
            this.router.push('/login');
        },
    },
    persist:true
});