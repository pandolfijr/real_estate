import{a as i}from"./axios-B4uVmeYG.js";import{S as s}from"./sweetalert2-z6gKu1nJ.js";import p from"./Search-D14QtKw0.js";import{f,d as _}from"./utils-B-CemkDS.js";import{r as l,o as n,c,a as t,b as d,F as b,h as x,t as r,w as B}from"./app-e3q45BkK.js";import{_ as C}from"./_plugin-vue_export-helper-DlAUqK2U.js";const g={data:function(){return{transactions:{},formatDate:f,contract_status:_}},components:{Search:p},methods:{getTransactions(e){i.get("/transactions",{params:e}).then(o=>{this.transactions=o.data.transactions.data}).catch(o=>{s.fire({position:"top-end",icon:"error",title:o.response.data.message,showConfirmButton:!1,timer:2500})})},delete(e){i.delete("/transactions/"+e).then(o=>{s.fire({text:o.data.message,icon:"success"})}).catch(o=>{s.fire({position:"top-end",icon:"error",title:o.response.data.message,showConfirmButton:!1,timer:4500})})},restore(e){i.post("/transaction/"+e+"/restore").then(o=>{s.fire({text:o.data.message,icon:"success"})}).catch(o=>{s.fire({position:"top-end",icon:"error",title:o.response.data.message,showConfirmButton:!1,timer:2500})})},deleteTransaction(e){s.fire({title:"Você tem certeza?",text:"Ao clicar em SIM, proprietário será removido.",icon:"warning",showCancelButton:!0,confirmButtonColor:"#3085d6",cancelButtonColor:"#d33",confirmButtonText:"Sim",cancelButtonText:"Cancelar"}).then(o=>{o.isConfirmed&&this.delete(e)})},restoreTransaction(e){s.fire({title:"Você tem certeza?",text:"Ao clicar em SIM, o proprietário será restaurado.",icon:"warning",showCancelButton:!0,confirmButtonColor:"#3085d6",cancelButtonColor:"#d33",confirmButtonText:"Sim",cancelButtonText:"Cancelar"}).then(o=>{o.isConfirmed&&this.restore(e)})}},beforeMount(){this.getTransactions()}},y={class:"container-fluid"},w={class:"col-md-12"},T=t("h2",null,"Transações",-1),S={class:"card card-primary"},v=t("div",{class:"card-header"},[t("h3",{class:"card-title"}," Transações ")],-1),k={class:"card-body table-responsive p-0",style:{}},D={key:0,class:"scrollable text-left"},V={class:"table table-head-fixed text-nowrap text-left table-striped"},F=t("thead",null,[t("tr",null,[t("th",{class:"md='auto'"},"Referência"),t("th",{class:"md='auto'"},"Propriedade "),t("th",{class:"md='auto'"},"Proprietário"),t("th",{class:"md='auto'"},"Locatário "),t("th",{class:"md='auto'"},"Status do Contrato"),t("th",{class:"md='auto'"},"Data Inicial"),t("th",{class:"md='auto'"},"Data Final"),t("th",{class:"md='auto'"})])],-1),I=t("button",{type:"button",class:"btn btn-outline-info",style:{"margin-top":"-0.5em"}},[t("i",{class:"fas fa-solid fa-eye"})],-1),L={key:1},M=t("table",{class:"table table-head-fixed text-nowrap"},[t("tbody",null,[t("tr",{class:"text-center"},[t("td",{class:"text-center"},[t("b",null,"Nenhuma transação encontrada.")])])])],-1),N=[M];function $(e,o,z,A,P,u){const m=l("search"),h=l("router-link");return n(),c("div",y,[t("div",w,[T,d(m,{route:"transaction",onSearch:u.getTransactions},null,8,["onSearch"]),t("div",S,[v,t("div",k,[e.transactions&&e.transactions.length>0?(n(),c("div",D,[t("table",V,[F,t("tbody",null,[(n(!0),c(b,null,x(e.transactions,a=>(n(),c("tr",{key:a.id},[t("td",null,[t("b",null,r(a.property.reference),1)]),t("td",null,r(a.property.description),1),t("td",null,r(a.locator.people.name+" "+a.locator.people.surname),1),t("td",null,r(a.renter.people.name+" "+a.renter.people.surname),1),t("td",null,r(e.contract_status[a.contract_status]),1),t("td",null,r(e.formatDate(a.contract_start_date)),1),t("td",null,r(e.formatDate(a.contract_end_date)),1),t("td",null,[d(h,{to:"/transaction/"+a.id+"/edit",class:"small-box-footer"},{default:B(()=>[I]),_:2},1032,["to"])])]))),128))])])])):(n(),c("div",L,N))])])])])}const J=C(g,[["render",$]]);export{J as default};