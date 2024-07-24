import{a as o}from"./axios-B4uVmeYG.js";import{g as h}from"./utils-B-CemkDS.js";import{r as _,o as c,c as i,a as s,t as a,b as l,w as n,d as t,e as d,F as u,f as m}from"./app-GEmCaaeo.js";import{_ as f}from"./_plugin-vue_export-helper-DlAUqK2U.js";const p={watch:{},data:function(){return{properties:"",locators:"",renters:"",users:"",date_now:"",accounts_pay:[],accounts_receive:[],installments_receive:[],getCurrentDate:h}},computed:{},methods:{getTotalProperties(){o.get("/property-total").then(e=>{this.properties=e.data.properties?e.data.properties:0}).catch(e=>{console.error("Houve um problema com a requisição:",e)})},getTotalRenters(){o.get("/renters-total").then(e=>{this.renters=e.data.renters?e.data.renters:0}).catch(e=>{console.error("Houve um problema com a requisição:",e)})},getTotalLocators(){o.get("/locators-total").then(e=>{this.locators=e.data.locators?e.data.locators:0}).catch(e=>{console.error("Houve um problema com a requisição:",e)})},getTotalUsers(){o.get("/users-total").then(e=>{this.users=e.data.users?e.data.users:0}).catch(e=>{console.error("Houve um problema com a requisição:",e)})},navigateToUsuario(){this.$router.push("/users-list")},getAccountsToPay(){o.get("/accounts-pay",{params:{expect_date:this.date_now,status:1}}).then(e=>{this.accounts_pay=e.data.accounts.data}).catch(e=>{Swal.fire({position:"top-end",icon:"error",title:e.response.data.message,showConfirmButton:!1,timer:2500})})},getAccountsToReceive(){o.get("/accounts-receive",{params:{expect_date:this.date_now,status:1}}).then(e=>{this.accounts_receive=e.data.accounts.data}).catch(e=>{Swal.fire({position:"top-end",icon:"error",title:e.response.data.message,showConfirmButton:!1,timer:2500})})},getInstallmentsToReceive(){o.get("/installments",{params:{status:1,due_date:this.date_now}}).then(e=>{this.installments_receive=e.data.installments.data}).catch(e=>{Swal.fire({position:"top-end",icon:"error",title:e.response.data.message,showConfirmButton:!1,timer:2500})})}},created(){this.date_now=this.getCurrentDate(),this.getTotalProperties(),this.getTotalRenters(),this.getTotalLocators(),this.getTotalUsers(),this.getAccountsToPay(),this.getAccountsToReceive(),this.getInstallmentsToReceive()}},g=m('<div class="content-header"><div class="container-fluid"><div class="row mb-2"><div class="col-sm-6"><h1 class="m-0">Dashboard</h1></div></div></div></div>',1),v={class:"content"},b={class:"container-fluid"},y={class:"row"},w={class:"col-lg-3 col-6"},T={class:"small-box bg-success"},C={class:"inner"},k=s("p",null,"Imóveis Cadastrados",-1),H=s("div",{class:"icon"},[s("i",{class:"fas fa-house-user",style:{"font-size":"48px",color:"#fff"}})],-1),x=s("i",{class:"fas fa-arrow-circle-right"},null,-1),P={class:"col-lg-3 col-6"},R={class:"small-box bg-success"},B={class:"inner"},D=s("p",null,"Locatários",-1),I=s("div",{class:"icon"},[s("i",{class:"fas fa-user-circle",style:{"font-size":"48px",color:"#fff"}})],-1),N=s("i",{class:"fas fa-arrow-circle-right"},null,-1),S={class:"col-lg-3 col-6"},V={class:"small-box bg-success",style:{color:"#fff"}},$={class:"inner",style:{color:"#fff"}},q=s("p",null,"Proprietários",-1),z=s("div",{class:"icon"},[s("i",{class:"fas fa-users",style:{"font-size":"48px",color:"#fff"}})],-1),A=s("i",{class:"fas fa-arrow-circle-right"},null,-1),M={class:"col-lg-3 col-6"},U={class:"small-box bg-success"},j={class:"inner"},L=s("p",null,"Usuários",-1),F=s("div",{class:"icon"},[s("i",{class:"fas fa-user-friends",style:{"font-size":"48px",color:"#fff"}})],-1),E=s("i",{class:"fas fa-arrow-circle-right"},null,-1),G={key:0,class:"card card-primary"},J=s("div",{class:"card-header"}," Informações ",-1),K={class:"form-control",style:{height:"5em"}},O={key:0,style:{margin:"1em"}},Q=s("b",null,"hoje!",-1),W=s("br",null,null,-1),X={key:1,style:{margin:"1em"}},Y=s("b",null,"hoje!",-1),Z=s("br",null,null,-1),ss={key:2,style:{margin:"1em"}},es=s("b",null,"hoje!",-1),ts=s("br",null,null,-1);function os(e,as,cs,is,rs,ls){const r=_("router-link");return c(),i(u,null,[g,s("section",v,[s("div",b,[s("div",y,[s("div",w,[s("div",T,[s("div",C,[s("h3",null,a(e.properties),1),k]),H,l(r,{to:"/properties-list/",class:"small-box-footer"},{default:n(()=>[t(" Mais informações "),x]),_:1})])]),s("div",P,[s("div",R,[s("div",B,[s("h3",null,a(e.renters),1),D]),I,l(r,{to:"/renters-list/",class:"small-box-footer"},{default:n(()=>[t(" Mais informações "),N]),_:1})])]),s("div",S,[s("div",V,[s("div",$,[s("h3",null,a(e.locators),1),q]),z,l(r,{to:"/locators-list/",class:"small-box-footer"},{default:n(()=>[t(" Mais informações "),A]),_:1})])]),s("div",M,[s("div",U,[s("div",j,[s("h3",null,a(e.users),1),L]),F,l(r,{to:"/users-list/",class:"small-box-footer"},{default:n(()=>[t(" Mais informações "),E]),_:1})])])]),e.accounts_pay.length>0||e.accounts_receive.length>0||e.installments_receive.length>0?(c(),i("div",G,[J,s("div",K,[e.accounts_pay.length>0?(c(),i("span",O,[t(" Há "),s("b",null,a(e.accounts_pay.length)+" Conta(s) à Pagar",1),t(" com vencimento para "),Q,t(),W])):d("",!0),e.accounts_receive.length>0?(c(),i("span",X,[t(" Há "),s("b",null,a(e.accounts_receive.length)+" Conta(s) à Receber",1),t(" com vencimento para "),Y,Z])):d("",!0),e.installments_receive.length>0?(c(),i("span",ss,[t(" Há "),s("b",null,a(e.installments_receive.length)+" Parcela(s) de Imóvel à receber",1),t(" com vencimento para "),es,ts])):d("",!0)])])):d("",!0)])])],64)}const us=f(p,[["render",os]]);export{us as default};
