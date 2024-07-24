import{F as V,B as D,G as I,c as P,g as B,f as C}from"./utils-B-CemkDS.js";import{S as u}from"./sweetalert2-z6gKu1nJ.js";import{a as _}from"./axios-B4uVmeYG.js";import{r as $,o as a,c as o,a as t,t as l,j as c,v as g,b as p,m,k as h,F as v,h as f,u as b,e as k}from"./app-GEmCaaeo.js";import{_ as R}from"./_plugin-vue_export-helper-DlAUqK2U.js";const S={data:function(){return{data:{},bank_accounts:{},locators:{},renters:{},installment:{id:"",current_installment:"",total_installments:"",status:"",due_date:"",date_received:"",description:"",identification_code:"",observations:"",type_installment:"",id_transact:"",id_locator:"",id_property:"",payment_method:"",id_check:"",installment_value:"",insurance_value:"",insurance_number:"",installment_total_value:"",id_renter:"",discount_value:"",penalty_value:"",id_casher:"",action:2,property:{reference:""},renter:{people:{}},locator:{people:{}}},config:{decimal:",",thousands:".",prefix:"R$ ",precision:2,masked:!1},status_account_receive:V,payment_method:D,types_installment:I,onError:P,getCurrentDate:B,formatDate:C}},computed:{},methods:{getInstallment(){_.get("/installments/"+this.$route.params.id).then(e=>{this.installment=e.data.installment,this.installment.discharge_date||(this.installment.discharge_date=this.getCurrentDate()),this.installment.id_bank_account==null&&(this.installment.id_bank_account="")}).catch(e=>{console.error("Houve um problema com a requisição:",e)})},updateInstallment(){this.installment.action=1,_.put("/installments/"+this.$route.params.id,this.installment).then(e=>{u.fire({position:"top-end",icon:"success",title:e.data.message,showConfirmButton:!1,timer:2500}),this.$router.go(-1)}).catch(e=>{u.fire({position:"top-end",icon:"error",title:e.response.data.message,showConfirmButton:!1,timer:2500})})},back(){this.$router.go(-1)},getBankAccounts(e){_.get("/bank-accounts",{params:e}).then(s=>{this.bank_accounts=s.data.bank_accounts.data}).catch(s=>{u.fire({position:"top-end",icon:"error",title:s.response.data.message,showConfirmButton:!1,timer:2500})})},treatValues(){const e=this.installment.installment_value?parseFloat(this.installment.installment_value):0,s=this.installment.penalty_value?parseFloat(this.installment.penalty_value):0,y=this.installment.discount_value?parseFloat(this.installment.discount_value):0;this.installment.installment_total_value=e+s-y}},created(){this.$route.params.id&&this.getInstallment(),this.getBankAccounts(),this.treatValues()}},w={class:"container-fluid"},F={class:"col-md-12"},U={key:0},A={key:1},L={class:"card card-primary"},M=t("div",{class:"card-header"},[t("h3",{class:"card-title"},"Conta à Receber")],-1),T={class:"card-body"},q={class:"row"},z={class:"col-sm-2"},E={class:"form-group"},N=t("label",{for:"inputIdAccount"},"Parcela Atual",-1),j={class:"form-control",id:"inputCurrentInstallment",name:"current_installment",readonly:""},O={class:"col-sm-2"},Q={class:"form-group"},G=t("label",{for:"inputIdAccount"},"Total de Parcelas",-1),H={class:"form-control",id:"inputTotalInstallment",name:"total_installment",readonly:""},J={class:"col-sm-4"},K={class:"form-group"},W=t("label",{for:"inputDescription"},"Descrição",-1),X={class:"form-control",readonly:"true"},Y={class:"col-sm-2"},Z={class:"form-group"},x=t("label",{for:"inputDescription"},"Status",-1),tt={class:"form-control",readonly:"true"},et={class:"col-sm-2"},st={class:"form-group"},nt=t("label",{for:"inputCheckDueDate"},"Data de Vencimento",-1),at={class:"row"},ot={class:"col-sm-3"},lt={class:"form-group"},it=t("label",{for:"inputLocator"},"Locatário",-1),dt={class:"form-control",readonly:"true"},rt={class:"col-sm-3"},ct={class:"form-group"},mt=t("label",{for:"inputIdLocator"},"Proprietário do Imóvel",-1),ut={class:"form-control",readonly:"true"},_t={class:"col-sm-3"},pt={class:"form-group"},ht=t("label",{for:"inputIdLocator"},"Descrição do Imóvel",-1),vt={key:0,class:"form-control",readonly:"true"},ft={key:1,class:"form-control",readonly:"true"},yt={class:"col-sm-3"},gt={class:"form-group"},bt=t("label",{for:"inputFinalValue"},"Valor Parcela",-1),kt={class:"input-group"},Vt=t("div",{class:"input-group-prepend"},[t("span",{class:"input-group-text"},[t("i",{class:"fas fa-dollar-sign"})])],-1),Dt={class:"row"},It={class:"col-sm-4"},Pt={class:"form-group"},Bt=t("label",{for:"inputPaymentMethod"},"Método de Pagamento",-1),Ct=t("option",{value:""},"Selecione a opção",-1),$t=["value"],Rt={key:1,class:"form-control",readonly:""},St={class:"col-sm-4"},wt={class:"form-group"},Ft=t("label",{for:"inputDischargeDate"},"Data Quitação",-1),Ut={key:1,class:"form-control",readonly:""},At={class:"col-sm-4"},Lt={class:"form-group"},Mt=t("label",{for:"inputStatus"},"Status",-1),Tt=t("option",null,"Selecione o status",-1),qt=["value"],zt={key:1,class:"form-control",readonly:""},Et={class:"row"},Nt={class:"col-sm-3"},jt={class:"form-group"},Ot=t("label",{for:"inputPenaltyValue"},"Valor Multa",-1),Qt={key:0,class:"input-group"},Gt=t("div",{class:"input-group-prepend"},[t("span",{class:"input-group-text"},[t("i",{class:"fas fa-dollar-sign"})])],-1),Ht={key:1,class:"form-group"},Jt={class:"form-control",readonly:""},Kt={class:"col-sm-3"},Wt={class:"form-group"},Xt=t("label",{for:"inputDiscountValue"},"Valor Desconto",-1),Yt={key:0,class:"input-group"},Zt=t("div",{class:"input-group-prepend"},[t("span",{class:"input-group-text"},[t("i",{class:"fas fa-dollar-sign"})])],-1),xt={key:1,class:"form-group"},te={class:"form-control",readonly:""},ee={class:"col-sm-3"},se={class:"form-group"},ne=t("label",{for:"inputInstallmentValue"},"Valor Final",-1),ae={key:0,class:"input-group"},oe=t("div",{class:"input-group-prepend"},[t("span",{class:"input-group-text"},[t("i",{class:"fas fa-dollar-sign"})])],-1),le={key:1,class:"form-group"},ie={class:"form-control",readonly:""},de={class:"col-sm-3"},re={class:"form-group"},ce=t("label",{for:"inputObservations"},"Conta para Recebimento",-1),me=t("option",{value:""},"Selecione...",-1),ue=["id","value"],_e={key:1,class:"form-control",readonly:""},pe=t("br",null,null,-1),he={class:"modal-footer justify-content-center"},ve=["title","disabled"],fe={key:0,class:"card card-primary"},ye=t("div",{class:"card-header"},[t("h3",{class:"card-title"},"Repasse Realizado ao Proprietário")],-1),ge={class:"card-body"},be={class:"scrollable text-left"},ke={class:"table table-head-fixed text-nowrap text-left"},Ve=t("thead",null,[t("tr",null,[t("th",{class:"col-sm-1"},"ID"),t("th",{class:"col-sm-1"},"ID Registro Transferência"),t("th",{class:"col-sm-2"},"Banco"),t("th",{class:"col-sm-2"},"Valor"),t("th",{class:"col-sm-2"},"Data De Transferência")])],-1),De={class:"col-sm-1"},Ie={class:"col-sm-1"},Pe={key:0,class:"col-sm-2"},Be={key:1},Ce={class:"col-sm-1"},$e={class:"col-sm-1"};function Re(e,s,y,Se,we,i){const d=$("money3");return a(),o("div",w,[t("div",F,[e.installment.id_casher?(a(),o("h2",A,"Visualizar Parcela Paga")):(a(),o("h2",U,"Baixar Parcela de Imóvel")),t("div",L,[M,t("div",T,[t("div",q,[t("div",z,[t("div",E,[N,t("div",j,l(e.installment.current_installment),1)])]),t("div",O,[t("div",Q,[G,t("div",H,l(e.installment.total_installments),1)])]),t("div",J,[t("div",K,[W,t("div",X,l(e.installment.description)+" | "+l(e.installment.property.reference?e.installment.property.reference:""),1)])]),t("div",Y,[t("div",Z,[x,t("div",tt,l(e.types_installment[e.installment.type_installment]),1)])]),t("div",et,[t("div",st,[nt,c(t("input",{type:"date",class:"form-control",id:"inputCheckDueDate",name:"due_date","onUpdate:modelValue":s[0]||(s[0]=n=>e.installment.due_date=n),disabled:""},null,512),[[g,e.installment.due_date]])])])]),t("div",at,[t("div",ot,[t("div",lt,[it,t("div",dt,l(e.installment.renter.people.name),1)])]),t("div",rt,[t("div",ct,[mt,t("div",ut,l(e.installment.locator.people.name),1)])]),t("div",_t,[t("div",pt,[ht,e.installment&&e.installment.property&&e.installment.property.description?(a(),o("div",vt,l(e.installment.property.description.length>30?e.installment.property.description.substring(0,30)+"...":e.installment.property.description),1)):(a(),o("div",ft))])]),t("div",yt,[t("div",gt,[bt,t("div",kt,[Vt,p(d,m({class:"form-control",modelValue:e.installment.installment_value,"onUpdate:modelValue":s[1]||(s[1]=n=>e.installment.installment_value=n)},e.config,{id:"inputInstallmentValue",placeholder:"Valor Parcela",name:"installment_value",readonly:""}),null,16,["modelValue"])])])])]),t("div",Dt,[t("div",It,[t("div",Pt,[Bt,e.installment.id_casher?(a(),o("div",Rt,l(e.payment_method[e.installment.payment_method]),1)):c((a(),o("select",{key:0,class:"custom-select",id:"inputPaymentMethod",name:"payment_method","onUpdate:modelValue":s[2]||(s[2]=n=>e.installment.payment_method=n)},[Ct,(a(!0),o(v,null,f(e.payment_method,(n,r)=>(a(),o("option",{key:r,value:r},l(n),9,$t))),128))],512)),[[h,e.installment.payment_method]])])]),t("div",St,[t("div",wt,[Ft,e.installment.id_casher?(a(),o("div",Ut,l(e.installment.discharge_date),1)):c((a(),o("input",{key:0,type:"date",class:"form-control",id:"inputDischargeDate",placeholder:"Informe a data de Quitação",name:"discharge_date","onUpdate:modelValue":s[3]||(s[3]=n=>e.installment.discharge_date=n),required:""},null,512)),[[g,e.installment.discharge_date]])])]),t("div",At,[t("div",Lt,[Mt,e.installment.id_casher?(a(),o("div",zt,l(e.status_account_receive[e.installment.status]),1)):c((a(),o("select",{key:0,class:"custom-select",id:"inputStatus",name:"status","onUpdate:modelValue":s[4]||(s[4]=n=>e.installment.status=n),onBlur:s[5]||(s[5]=n=>i.treatValues())},[Tt,(a(!0),o(v,null,f(e.status_account_receive,(n,r)=>(a(),o("option",{key:r,value:r},l(n),9,qt))),128))],544)),[[h,e.installment.status]])])])]),t("div",Et,[t("div",Nt,[t("div",jt,[Ot,e.installment.id_casher?(a(),o("div",Ht,[t("div",Jt," R$ "+l(e.installment.penalty_value?e.installment.penalty_value:"0.00"),1)])):(a(),o("div",Qt,[Gt,p(d,m({class:"form-control",modelValue:e.installment.penalty_value,"onUpdate:modelValue":s[6]||(s[6]=n=>e.installment.penalty_value=n)},e.config,{id:"inputPenaltyValue",placeholder:"Locacao",name:"penalty_value",onBlur:s[7]||(s[7]=n=>i.treatValues())}),null,16,["modelValue"])]))])]),t("div",Kt,[t("div",Wt,[Xt,e.installment.id_casher?(a(),o("div",xt,[t("div",te," R$ "+l(e.installment.discount_value?e.installment.discount_value:"0.00"),1)])):(a(),o("div",Yt,[Zt,p(d,m({class:"form-control",modelValue:e.installment.discount_value,"onUpdate:modelValue":s[8]||(s[8]=n=>e.installment.discount_value=n)},e.config,{id:"inputDiscountValue",placeholder:"Locacao",name:"discount value",onBlur:s[9]||(s[9]=n=>i.treatValues())}),null,16,["modelValue"])]))])]),t("div",ee,[t("div",se,[ne,e.installment.id_casher?(a(),o("div",le,[t("div",ie," R$ "+l(e.installment.installment_total_value),1)])):(a(),o("div",ae,[oe,e.installment.installment_total_value?(a(),b(d,m({key:0,class:"form-control",modelValue:e.installment.installment_total_value,"onUpdate:modelValue":s[10]||(s[10]=n=>e.installment.installment_total_value=n)},e.config,{id:"inputFinalValue",name:"installment_total_value",readonly:""}),null,16,["modelValue"])):(a(),b(d,m({key:1,class:"form-control",modelValue:e.installment.installment_total_value,"onUpdate:modelValue":s[11]||(s[11]=n=>e.installment.installment_total_value=n)},e.config,{id:"inputFinalValue",name:"final_value",readonly:""}),null,16,["modelValue"]))]))])]),t("div",de,[t("div",re,[ce,e.installment.id_casher?(a(),o("div",_e,l(e.instal)+" "+l(e.installment.bank_account.id+" - "+e.installment.bank_account.bank_name+" - "+e.installment.bank_account.account_name),1)):c((a(),o("select",{key:0,class:"custom-select",id:"inputIdAccount",name:"id_bank_account",required:"","onUpdate:modelValue":s[12]||(s[12]=n=>e.installment.id_bank_account=n)},[me,(a(!0),o(v,null,f(e.bank_accounts,n=>(a(),o("option",{key:n.id,id:n.id,value:n.id},l(n.id+" - "+n.bank_name+" - "+n.account_name),9,ue))),128))],512)),[[h,e.installment.id_bank_account]])])])]),pe]),t("div",he,[e.installment.id_casher?k("",!0):(a(),o("button",{key:0,type:"submit",class:"btn btn-primary",onClick:s[13]||(s[13]=n=>i.updateInstallment()),title:e.installment.status!=2?"Altere o Status para Recebido":"",disabled:e.installment.status!=2||!e.installment.id_bank_account}," Baixar ",8,ve)),t("button",{class:"btn btn-danger",onClick:s[14]||(s[14]=n=>i.back())},"Voltar")])])]),e.installment.id_bank_account_transfer?(a(),o("div",fe,[ye,t("div",ge,[t("div",be,[t("table",ke,[Ve,t("tbody",null,[t("tr",null,[t("td",De,l(e.installment.id),1),t("td",Ie,l(e.installment.casher.id),1),e.installment.bank_account?(a(),o("td",Pe,l(e.installment.bank_account.bank_name+" | "+e.installment.bank_account.account_name),1)):(a(),o("td",Be,"Parcela em Aberto | Repasse Realizado")),t("td",Ce,[t("b",null,"R$ "+l(e.installment.casher.account_value),1)]),t("td",$e,[t("b",null,l(e.formatDate(e.installment.casher.date_current_action)),1)])])])])])])])):k("",!0)])}const Te=R(S,[["render",Re]]);export{Te as default};
