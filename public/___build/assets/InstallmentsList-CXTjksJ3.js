import{a as u}from"./axios-B4uVmeYG.js";import{S as p}from"./sweetalert2-z6gKu1nJ.js";import h from"./Search-D14QtKw0.js";import{C as m,D as f,f as b}from"./utils-B-CemkDS.js";import{r as l,o as s,c as a,a as t,b as c,F as y,h as v,t as n,w as g}from"./app-e3q45BkK.js";import{_ as k}from"./_plugin-vue_export-helper-DlAUqK2U.js";const x={data:function(){return{installments:{current_installment:"",total_installments:"",status:"",due_date:"",date_received:"",description:"",identification_code:"",observations:"",type_installment:"",id_transact:"",id_locator:"",id_property:"",payment_method:"",id_check:"",installment_value:"",insurance_value:"",insurance_number:"",installment_total_value:"",id_renter:"",property:{},locator:{},renter:{}},search:{},status_account:m,category_account_receive:f,formatDate:b}},components:{Search:h},methods:{getInstallments(o){return this.validateCategory(o)?u.get("/installments",{params:o}).then(r=>{this.installments=r.data.installments.data}).catch(r=>{p.fire({position:"top-end",icon:"error",title:r.response.data.message,showConfirmButton:!1,timer:2500})}):!1},validateCategory(o){return!0}}},D={class:"container-fluid"},C={class:"col-md-12"},I=t("h2",null,"Parcelas de Imóveis",-1),w={class:"card card-primary"},S=t("div",{class:"card-header"},[t("h3",{class:"card-title"}," Contas ")],-1),B={key:0,class:"card-body table-responsive p-0",style:{}},N={key:0,class:"scrollable text-left"},P={class:"table table-head-fixed text-nowrap text-left table-striped"},E=t("thead",null,[t("tr",null,[t("th",{class:"md='auto'"},"ID"),t("th",{class:"md='auto'"},"Imóvel"),t("th",{class:"md='auto'"},"Descrição"),t("th",{class:"md='auto'"},"Locatário"),t("th",{class:"md='auto'"},"Proprietário"),t("th",{class:"md='auto'"},"Data Vencimento"),t("th",{class:"md='auto'"})])],-1),F={key:0},L=t("button",{type:"button",class:"btn btn-outline-info",title:"Fazer Repasse",style:{"margin-top":"-0.5em"}},[t("i",{class:"fas fa-dollar-sign",style:{padding:"0.3em"}})],-1),R={key:1},V=t("button",{type:"button",class:"btn btn-outline-secondary",style:{"margin-top":"-0.5em"},title:"Nenhuma Ação",disabled:""},[t("i",{class:"fas fa-hand-paper"})],-1),$=[V],q={key:2},z=["href"],A=t("button",{type:"button",class:"btn btn-outline-info",style:{"margin-top":"-0.5em"},title:"Imprimir Recibo de Parcela"},[t("i",{class:"fas fa-print"})],-1),O=[A],j={key:3},G={key:1},H=t("table",{class:"table table-head-fixed text-nowrap"},[t("tbody",null,[t("tr",{class:"text-center"},[t("td",{class:"text-center"},[t("b",null,"Nenhuma conta encontrado.")])])])],-1),J=[H],K={key:1},M=t("table",{class:"table table-head-fixed text-nowrap"},[t("tbody",null,[t("tr",{class:"text-center"},[t("td",{class:"text-center"},[t("b",null,"Preencha os filtros e faça sua pesquisa.")])])])],-1),Q=[M];function T(o,r,U,W,X,i){const d=l("search"),_=l("router-link");return s(),a("div",D,[t("div",C,[I,c(d,{route:"installment",onSearch:i.getInstallments},null,8,["onSearch"]),t("div",w,[S,o.installments&&o.installments.length>0?(s(),a("div",B,[o.installments&&o.installments.length>0?(s(),a("div",N,[t("table",P,[E,t("tbody",null,[(s(!0),a(y,null,v(o.installments,e=>(s(),a("tr",{key:e.id},[t("td",null,[t("b",null,n(e.id),1)]),t("td",null,[t("b",null,n(e.property?e.property.reference:""),1)]),t("td",null,n(e.description),1),t("td",null,n(e.renter&&e.renter.people?e.renter.people.name+" "+e.renter.people.surname:""),1),t("td",null,n(e.locator&&e.locator.people?e.locator.people.name+" "+e.locator.people.surname:""),1),t("td",null,n(e.date_received?"RECEBIDO":o.formatDate(e.due_date)),1),e.status!=2?(s(),a("td",F,[c(_,{to:"/installment/"+e.id+"/pay-off",class:"small-box-footer"},{default:g(()=>[L]),_:2},1032,["to"])])):(s(),a("td",R,$)),e.status==2?(s(),a("td",q,[t("a",{href:"/receipt/"+e.id+"/installment",target:"_blank"},O,8,z)])):(s(),a("td",j))]))),128))])])])):(s(),a("div",G,J))])):(s(),a("div",K,Q))])])])}const ot=k(x,[["render",T]]);export{ot as default};
