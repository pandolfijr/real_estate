import{a as l}from"./axios-B4uVmeYG.js";import{S as r}from"./sweetalert2-z6gKu1nJ.js";import p from"./Search-vYh6-uUS.js";import{s as f}from"./utils-B-CemkDS.js";import{r as d,o as a,c as n,a as t,b as u,F as b,h as g,t as i,w as C,n as x}from"./app-CaSvgjMt.js";import{_ as v}from"./_plugin-vue_export-helper-DlAUqK2U.js";const B={data:function(){return{properties:{locator:{people:{}}},status_properties:f,currentPage:1,itemsPerPage:30,totalItems:0}},computed:{totalPages(){return Math.ceil(this.totalItems/this.itemsPerPage)}},components:{Search:p},methods:{getProperties(s){l.get("/properties",{params:s}).then(o=>{this.properties=o.data.properties.data}).catch(o=>{r.fire({position:"top-end",icon:"error",title:o.response.data.message,showConfirmButton:!1,timer:2500})})},delete(s){l.delete("/properties/"+s).then(o=>{r.fire({text:o.data.message,icon:"success"})}).catch(o=>{r.fire({position:"top-end",icon:"error",title:o.response.data.message,showConfirmButton:!1,timer:2500})})},restore(s){l.post("/property/"+s+"/restore").then(o=>{r.fire({text:o.data.message,icon:"success"})}).catch(o=>{r.fire({position:"top-end",icon:"error",title:o.response.data.message,showConfirmButton:!1,timer:2500})})},deleteProperty(s){r.fire({title:"Você tem certeza?",text:"Ao clicar em SIM, o imóvel será removido.",icon:"warning",showCancelButton:!0,confirmButtonColor:"#3085d6",cancelButtonColor:"#d33",confirmButtonText:"Sim",cancelButtonText:"Cancelar"}).then(o=>{o.isConfirmed&&this.delete(s)})},restoreProperty(s){r.fire({title:"Você tem certeza?",text:"Ao clicar em SIM, o imóvel será restaurado.",icon:"warning",showCancelButton:!0,confirmButtonColor:"#3085d6",cancelButtonColor:"#d33",confirmButtonText:"Sim",cancelButtonText:"Cancelar"}).then(o=>{o.isConfirmed&&this.restore(s)})},updatePage(s){this.currentPage=s,this.getProperties()}}},P={class:"container-fluid"},k={class:"col-md-12"},S=t("h2",null,"Imóveis",-1),w={class:"card card-primary"},y=t("div",{class:"card-header"},[t("h3",{class:"card-title"},"Imóveis")],-1),I={class:"card-body table-responsive p-0"},F={key:0,class:"scrollable text-left"},N={class:"table table-head-fixed text-nowrap text-left table-striped"},T=t("thead",null,[t("tr",null,[t("th",{class:"md='auto'"},"Referência"),t("th",{class:"md='auto'"},"Nome"),t("th",{class:"md='auto'"},"Status"),t("th",{class:"md='auto'"},"Proprietário"),t("th",{class:"md='auto'"},"Locatário/Comprador"),t("th",{class:"md='auto'"}),t("th",{class:"md='auto'"})])],-1),V={type:"button",class:"btn btn-outline-primary",title:"Editar",style:{"margin-top":"-0.5em"}},$={key:0,style:{"text-align":"center"}},z=["onClick"],A=t("i",{class:"fas fa-plus"},null,-1),E=[A],L=["onClick"],M=t("i",{class:"fas fa-trash"},null,-1),q=[M],R={key:1},D=t("button",{type:"button",class:"btn btn-outline-secondary",style:{"margin-top":"-0.5em"},title:"Nenhuma Ação",disabled:""},[t("i",{class:"fas fa-hand-paper"})],-1),j=[D],G={key:1},H=t("table",{class:"table table-head-fixed text-nowrap"},[t("tbody",null,[t("tr",{class:"text-center"},[t("td",{class:"text-center"},[t("b",null,"Selecione o Status e clique em Buscar para pesquisar os imóveis")])])])],-1),J=[H];function K(s,o,O,Q,U,c){const m=d("search"),h=d("router-link");return a(),n("div",P,[t("div",k,[S,u(m,{route:"property",onSearch:c.getProperties},null,8,["onSearch"]),t("div",w,[y,t("div",I,[s.properties.length>0?(a(),n("div",F,[t("table",N,[T,t("tbody",null,[(a(!0),n(b,null,g(s.properties,e=>(a(),n("tr",{key:e.id},[t("td",null,[t("b",null,i(e.reference),1)]),t("td",null,i(e.description),1),t("td",null,i(s.status_properties[e.status]),1),t("td",null,i(e&&e.locator&&e.locator.people?e.locator.people.name+" "+e.locator.people.surname:" - "),1),t("td",null,i(e&&e.renter&&e.renter.people?e.renter.people.name+" "+e.renter.people.surname:" - "),1),t("td",null,[u(h,{to:"/property/"+e.id+"/edit",class:"small-box-footer"},{default:C(()=>[t("button",V,[t("i",{class:x(e.id_transaction?"fas fa-solid fa-eye":"fas fa-pencil-alt")},null,2)])]),_:2},1032,["to"])]),t("td",null,[e.id_transaction?(a(),n("div",R,j)):(a(),n("div",$,[e.deleted_at?(a(),n("button",{key:0,type:"button",class:"btn btn-outline-success",onClick:_=>s.restoreCustomer(e.id),"data-toggle":"modal",style:{"margin-top":"-0.5em"},title:"Restaurar Fiador"},E,8,z)):(a(),n("button",{key:1,type:"button",class:"btn btn-outline-danger",onClick:_=>c.deleteProperty(e.id),"data-toggle":"modal",style:{"margin-top":"-0.5em"},title:"Excluir Fiador"},q,8,L))]))])]))),128))])])])):(a(),n("div",G,J))])])])])}const st=v(B,[["render",K]]);export{st as default};