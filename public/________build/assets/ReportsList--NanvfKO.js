import{a as o}from"./axios-B4uVmeYG.js";import{o as t,c as a,a as s}from"./app-GEmCaaeo.js";import{_ as r}from"./_plugin-vue_export-helper-DlAUqK2U.js";const l={data:function(){return{settings:{}}},computed:{},methods:{getData(){o.get("/settings").then(e=>{this.settings=e.data.settings}).catch(e=>{console.error("Houve um problema com a requisição:",e)})}}},c={class:"content-header"},i=s("div",{class:"container-fluid"},[s("div",{class:"row",style:{"margin-bottom":"2.5em"}},[s("div",{class:"col-md-12"},[s("div",{class:"card card-primary"},[s("div",{class:"card-header"},[s("h3",{class:"card-title"},"Preencha os Filtros e Gere o Relatório")]),s("div",{class:"card-body"},[s("div",{class:"row"},[s("div",{class:"form-group col-sm-3"},[s("input",{type:"number",name:"dormitorios",class:"form-control float-right",placeholder:"Dormitórios",min:"0"})]),s("div",{class:"form-group col-sm-3"},[s("input",{type:"number",name:"suites",class:"form-control float-right",placeholder:"Suítes",min:"0"})]),s("div",{class:"form-group col-sm-3"},[s("input",{type:"number",name:"banheiros",class:"form-control float-right",min:"0",placeholder:"Banheiros"})]),s("div",{class:"form-group col-sm-3"},[s("input",{type:"number",name:"vagas",class:"form-control float-right",placeholder:"Vagas de Garagem",min:"0"})])]),s("div",{class:"row"},[s("div",{class:"col-md-1 form-group"},[s("input",{type:"text",class:"form-control",name:"valor_min",id:"valor_min",onkeypress:"$(this).mask('000.000.000.000.000,00', {reverse: true});",placeholder:"Valor Mínimo"})]),s("div",{class:"col-md-1 form-group"},[s("input",{type:"text",class:"form-control",name:"valor_max",id:"valor_max",onkeypress:"$(this).mask('000.000.000.000.000,00', {reverse: true});",placeholder:"Valor Máximo"})]),s("div",{class:"col-sm-2 form-group"},[s("select",{class:"custom-select",id:"selectStatusImovel",name:"id_status_imovel"},[s("option",{value:""},"Status")])]),s("div",{class:"col-sm-2 form-group"},[s("select",{class:"custom-select",id:"selectStatusImovel",name:"finalidade"},[s("option",{value:""},"Finalidade")])]),s("div",{class:"col-md-2 form-group"},[s("select",{name:"cidade",id:"cidade",class:"custom-select"},[s("option",{value:""},"Cidade... ")])]),s("div",{class:"col-sm-4",style:{"text-align":"left"}},[s("button",{type:"submit",class:"btn btn-primary"},"Gerar Relatório")])])])])])])],-1),m=[i];function n(e,d,p,u,v,f){return t(),a("div",c,m)}const y=r(l,[["render",n]]);export{y as default};
