import{a as h}from"./axios-B4uVmeYG.js";import{S as u}from"./sweetalert2-z6gKu1nJ.js";import _ from"./Search-vYh6-uUS.js";import{r as l,o as a,c as i,a as t,b as r,F as p,h as f,t as n,w as b}from"./app-CaSvgjMt.js";import{_ as x}from"./_plugin-vue_export-helper-DlAUqK2U.js";import"./utils-B-CemkDS.js";const v={data:function(){return{cities:{}}},components:{Search:_},methods:{getCities(e){h.get("/cities",{params:e}).then(s=>{this.cities=s.data.cities}).catch(s=>{u.fire({position:"top-end",icon:"error",title:s.response.data.message,showConfirmButton:!1,timer:2500}),console.error("Houve um problema com a requisição:",s)})}},beforeMount(){this.getCities()}},g={class:"container-fluid"},y={class:"col-md-12"},C=t("h2",null,"Cidades",-1),k={class:"card card-primary"},w=t("div",{class:"card-header"},[t("h3",{class:"card-title"},"Cidades")],-1),S={class:"card-body table-responsive p-0"},B={key:0,class:"scrollable text-left"},N={class:"table table-head-fixed text-nowrap text-left table-striped"},E=t("thead",null,[t("tr",null,[t("th",{class:"md='auto'"},"ID"),t("th",{class:"md='auto'"},"Nome"),t("th",{class:"md='auto'"},"Estado"),t("th",{class:"md='auto'"})])],-1),$=t("button",{type:"button",class:"btn btn-outline-primary",title:"Editar",style:{"margin-top":"-0.5em"}},[t("i",{class:"fas fa-pencil-alt"})],-1),D={key:1},F=t("table",{class:"table table-head-fixed text-nowrap"},[t("tbody",null,[t("tr",{class:"text-center"},[t("td",{class:"text-center"},[t("b",null,"Nenhuma cidade encontrada.")])])])],-1),L=[F];function V(e,s,q,H,I,c){const d=l("search"),m=l("router-link");return a(),i("div",g,[t("div",y,[C,r(d,{route:"city",onSearch:c.getCities},null,8,["onSearch"]),t("div",k,[w,t("div",S,[e.cities&&e.cities.length>0?(a(),i("div",B,[t("table",N,[E,t("tbody",null,[(a(!0),i(p,null,f(e.cities,o=>(a(),i("tr",{key:o.id},[t("td",null,[t("b",null,n(o.id),1)]),t("td",null,n(o.name),1),t("td",null,n(o.state.name),1),t("td",null,[r(m,{to:"/city/"+o.id+"/edit",class:"small-box-footer"},{default:b(()=>[$]),_:2},1032,["to"])])]))),128))])])])):(a(),i("div",D,L))])])])])}const K=x(v,[["render",V]]);export{K as default};