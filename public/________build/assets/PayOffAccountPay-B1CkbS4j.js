import{C as V,A as D,B as C,g as B,c as F}from"./utils-B-CemkDS.js";import{S as _}from"./sweetalert2-z6gKu1nJ.js";import{a as m}from"./axios-B4uVmeYG.js";import{r as S,o as s,c as n,a as t,t as c,e as b,j as i,v as p,b as h,m as u,k as v,F as f,h as y,u as k,s as $}from"./app-GEmCaaeo.js";import{_ as w}from"./_plugin-vue_export-helper-DlAUqK2U.js";const A={watch:{},data:function(){return{data:{},casher_account:{},account:{id:"",description:"",original_value:"",penalty_value:"",final_value:"",type:"",status:1,payment_method:"",category:"",observations:"",discharge_date:"",expect_date:"",id_supplier:"",id_check:"",id_bank_account:"",supplier:{name:""}},config:{decimal:",",thousands:".",prefix:"R$ ",precision:2,masked:!1},status_account:V,category_account_pay:D,payment_method:C,getCurrentDate:B,onError:F}},methods:{getAccount(){m.get("/accounts-pay/"+this.$route.params.id).then(o=>{this.account=o.data.account,this.account.discharge_date||(this.account.discharge_date=this.getCurrentDate()),this.account.id_bank_account==null&&(this.account.id_bank_account="")}).catch(o=>{console.error("Houve um problema com a requisição:",o)})},updateAccount(){this.account.action=2,m.put("/accounts-pay/"+this.$route.params.id,this.account).then(o=>{_.fire({position:"top-end",icon:"success",title:o.data.message,showConfirmButton:!1,timer:2500}),this.$router.go(-1)}).catch(o=>{_.fire({position:"top-end",icon:"error",title:o.response.data.message,showConfirmButton:!1,timer:2500})})},back(){this.$router.go(-1)},getBankAccounts(){m.get("/casher-account").then(o=>{this.casher_account=o.data.casher_account.data}).catch(o=>{o=this.onError(o),_.fire({position:"top-end",icon:"error",title:o.message,showConfirmButton:!1,timer:2500})})},treatValues(){const o=this.account.original_value?parseFloat(this.account.original_value):0,e=this.account.penalty_value?parseFloat(this.account.penalty_value):0,g=this.account.discount_value?parseFloat(this.account.discount_value):0;this.account.final_value=o+e-g}},beforeMount(){this.getBankAccounts(),this.$route.params.id&&this.getAccount(),this.treatValues()}},P={class:"container-fluid"},U={class:"col-md-12"},I={key:0},O={key:1},E={class:"card card-primary"},M=t("div",{class:"card-header"},[t("h3",{class:"card-title"},"Conta à Pagar")],-1),R={class:"card-body"},q={class:"row"},L={class:"col-sm-4"},N={class:"form-group"},j=t("label",{for:"inputCategory"},"Categoria",-1),z={class:"form-control",id:"inputCategory",name:"category",readonly:""},Q={key:0,class:"col-sm-8"},H={class:"form-group"},T=t("label",{for:"inputIdAccount"},"Fornecedor",-1),G={class:"form-control",id:"inputSupplier",name:"supplier",readonly:""},J={key:1,class:"col-sm-4"},K={class:"form-group"},W=t("label",{for:"inputIdImovel"},"Imóvel",-1),X={class:"form-control",id:"inputSupplier",name:"supplier",readonly:""},Y={key:2,class:"col-sm-4"},Z={class:"form-group"},x=t("label",{for:"inputIdAccount"},"Proprietário",-1),oo={key:0,class:"form-control",readonly:""},to={key:1,class:"form-control",readonly:""},ao={class:"row"},eo={class:"col-sm-3"},so={class:"form-group"},no=t("label",{for:"inputDescription"},"Descrição",-1),co={class:"col-sm-3"},io={class:"form-group"},lo=t("label",{for:"inputExpectDate"},"Data Vencimento",-1),ro={class:"col-sm-3"},uo={class:"form-group"},po=t("label",{for:"inputOriginalValue"},"Valor Original",-1),_o={class:"input-group"},mo=t("div",{class:"input-group-prepend"},[t("span",{class:"input-group-text"},[t("i",{class:"fas fa-dollar-sign"})])],-1),ho={class:"col-sm-3"},vo={class:"form-group"},fo=t("label",{for:"inputObservations"},"Observações",-1),yo=t("div",{class:"row"},[t("div",{class:"col-sm-12"},[t("div",{class:"card-footer"})])],-1),go={class:"row"},bo={class:"col-sm-4"},ko={class:"form-group"},Vo=t("label",{for:"inputPaymentMethod"},"Método de Pagamento",-1),Do=t("option",{value:""},"Selecione a opção",-1),Co=["value"],Bo={key:1,class:"form-control",readonly:""},Fo={class:"col-sm-4"},So={class:"form-group"},$o=t("label",{for:"inputDischargeDate"},"Data Quitação",-1),wo={key:1,class:"form-control",readonly:""},Ao={class:"col-sm-4"},Po={class:"form-group"},Uo=t("label",{for:"inputStatus"},"Status",-1),Io=t("option",null,"Selecione o status",-1),Oo=["value"],Eo={key:1,class:"form-control",readonly:""},Mo={class:"row"},Ro={class:"col-sm-3"},qo={class:"form-group"},Lo=t("label",{for:"inputPenaltyValue"},"Valor Multa",-1),No={key:0,class:"input-group"},jo=t("div",{class:"input-group-prepend"},[t("span",{class:"input-group-text"},[t("i",{class:"fas fa-dollar-sign"})])],-1),zo={key:1,class:"form-group"},Qo={class:"form-control",readonly:""},Ho={class:"col-sm-3"},To={class:"form-group"},Go=t("label",{for:"inputDiscountValue"},"Valor Desconto",-1),Jo={key:0,class:"input-group"},Ko=t("div",{class:"input-group-prepend"},[t("span",{class:"input-group-text"},[t("i",{class:"fas fa-dollar-sign"})])],-1),Wo={key:1,class:"form-group"},Xo={class:"form-control",readonly:""},Yo={class:"col-sm-3"},Zo={class:"form-group"},xo=t("label",{for:"inputFinalValue"},"Valor Final",-1),ot={key:0,class:"input-group"},tt=t("div",{class:"input-group-prepend"},[t("span",{class:"input-group-text"},[t("i",{class:"fas fa-dollar-sign"})])],-1),at={key:1,class:"form-group"},et={class:"form-control",readonly:""},st={class:"col-sm-3"},nt={class:"form-group"},ct=t("label",{for:"inputObservations"},"Conta para Retirada",-1),it=["disabled"],lt=t("option",{value:""},"Selecione... ",-1),rt=["id","disabled","value"],dt={key:1,class:"form-control",readonly:""},ut=t("div",{class:"row"},null,-1),pt=t("br",null,null,-1),_t={class:"modal-footer justify-content-center"},mt=["title","disabled"];function ht(o,e,g,vt,ft,l){const r=S("money3");return s(),n("div",P,[t("div",U,[o.account.id_casher?(s(),n("h2",O,"Visualizar Conta Paga")):(s(),n("h2",I,"Baixar Conta")),t("div",E,[M,t("div",R,[t("div",q,[t("div",L,[t("div",N,[j,t("div",z,c(o.category_account_pay[o.account.category]),1)])]),o.account.category!=6?(s(),n("div",Q,[t("div",H,[T,t("div",G,c(o.account.supplier.name),1)])])):(s(),n("div",J,[t("div",K,[W,t("div",X,c("["+o.account.property.reference+"] - "+o.account.property.description),1)])])),o.account.category==6?(s(),n("div",Y,[t("div",Z,[x,o.account.id?(s(),n("div",oo,c(o.account.locator.people.name+" "+o.account.locator.people.surname),1)):(s(),n("div",to,c(o.property&&o.property.locator?o.property.locator.people.name+" "+o.property.locator.people.surname:""),1))])])):b("",!0)]),t("div",ao,[t("div",eo,[t("div",so,[no,i(t("input",{type:"text",class:"form-control",id:"inputDescription",placeholder:"Descreva a Conta",name:"description","onUpdate:modelValue":e[0]||(e[0]=a=>o.account.description=a),readonly:""},null,512),[[p,o.account.description]])])]),t("div",co,[t("div",io,[lo,i(t("input",{type:"date",class:"form-control",id:"inputExpectDate",placeholder:"Informe a Data Esperada",name:"expect_date","onUpdate:modelValue":e[1]||(e[1]=a=>o.account.expect_date=a),readonly:""},null,512),[[p,o.account.expect_date]])])]),t("div",ro,[t("div",uo,[po,t("div",_o,[mo,h(r,u({class:"form-control",modelValue:o.account.original_value,"onUpdate:modelValue":e[2]||(e[2]=a=>o.account.original_value=a)},o.config,{id:"inputOriginalValue",placeholder:"Venda",name:"original_value",readonly:""}),null,16,["modelValue"])])])]),t("div",ho,[t("div",vo,[fo,i(t("input",{type:"text",class:"form-control",id:"inputObservations",placeholder:"Descreva a Observação",name:"observations",readonly:"","onUpdate:modelValue":e[3]||(e[3]=a=>o.account.observations=a)},null,512),[[p,o.account.observations]])])])]),yo,t("div",go,[t("div",bo,[t("div",ko,[Vo,o.account.id_casher?(s(),n("div",Bo,c(o.payment_method[o.account.payment_method]),1)):i((s(),n("select",{key:0,class:"custom-select",id:"inputPaymentMethod",name:"payment_method","onUpdate:modelValue":e[4]||(e[4]=a=>o.account.payment_method=a)},[Do,(s(!0),n(f,null,y(o.payment_method,(a,d)=>(s(),n("option",{key:d,value:d},c(a),9,Co))),128))],512)),[[v,o.account.payment_method]])])]),t("div",Fo,[t("div",So,[$o,o.account.id_casher?(s(),n("div",wo,c(o.account.discharge_date),1)):i((s(),n("input",{key:0,type:"date",class:"form-control",id:"inputDischargeDate",placeholder:"Informe a data de Quitação",name:"discharge_date","onUpdate:modelValue":e[5]||(e[5]=a=>o.account.discharge_date=a),required:""},null,512)),[[p,o.account.discharge_date]])])]),t("div",Ao,[t("div",Po,[Uo,o.account.id_casher?(s(),n("div",Eo,c(o.status_account[o.account.status]),1)):i((s(),n("select",{key:0,class:"custom-select",id:"inputStatus",name:"status","onUpdate:modelValue":e[6]||(e[6]=a=>o.account.status=a),onBlur:e[7]||(e[7]=a=>l.treatValues())},[Io,(s(!0),n(f,null,y(o.status_account,(a,d)=>(s(),n("option",{key:d,value:d},c(a),9,Oo))),128))],544)),[[v,o.account.status]])])])]),t("div",Mo,[t("div",Ro,[t("div",qo,[Lo,o.account.id_casher?(s(),n("div",zo,[t("div",Qo," R$ "+c(o.account.penalty_value),1)])):(s(),n("div",No,[jo,h(r,u({class:"form-control",modelValue:o.account.penalty_value,"onUpdate:modelValue":e[8]||(e[8]=a=>o.account.penalty_value=a)},o.config,{id:"inputPenaltyValue",placeholder:"Locacao",name:"penalty_value",onBlur:e[9]||(e[9]=a=>l.treatValues())}),null,16,["modelValue"])]))])]),t("div",Ho,[t("div",To,[Go,o.account.id_casher?(s(),n("div",Wo,[t("div",Xo," R$ "+c(o.account.discount_value?o.account.discount_value:"0.00"),1)])):(s(),n("div",Jo,[Ko,h(r,u({class:"form-control",modelValue:o.account.discount_value,"onUpdate:modelValue":e[10]||(e[10]=a=>o.account.discount_value=a)},o.config,{id:"inputDiscountValue",placeholder:"Locacao",name:"discount value",onBlur:e[11]||(e[11]=a=>l.treatValues())}),null,16,["modelValue"])]))])]),t("div",Yo,[t("div",Zo,[xo,o.account.id_casher?(s(),n("div",at,[t("div",et," R$ "+c(o.account.final_value),1)])):(s(),n("div",ot,[tt,o.account.final_value?(s(),k(r,u({key:0,class:"form-control",modelValue:o.account.final_value,"onUpdate:modelValue":e[12]||(e[12]=a=>o.account.final_value=a)},o.config,{id:"inputFinalValue",placeholder:"Iptu",name:"final_value",readonly:""}),null,16,["modelValue"])):(s(),k(r,u({key:1,class:"form-control",modelValue:o.account.original_value,"onUpdate:modelValue":e[13]||(e[13]=a=>o.account.original_value=a)},o.config,{id:"inputFinalValue",placeholder:"Iptu",name:"final_value",readonly:""}),null,16,["modelValue"]))]))])]),t("div",st,[t("div",nt,[ct,o.account.id_casher?(s(),n("div",dt,c(o.account.bank_account.id+" - "+o.account.bank_account.bank_name+" - "+o.account.bank_account.account_name),1)):i((s(),n("select",{key:0,class:"custom-select",id:"inputIdAccount",name:"id_bank_account",required:"","onUpdate:modelValue":e[14]||(e[14]=a=>o.account.id_bank_account=a),disabled:o.account.status!=2},[lt,(s(!0),n(f,null,y(o.casher_account,a=>(s(),n("option",{key:a.bank_account.id,id:a.bank_account.id,disabled:parseFloat(o.account.final_value)>parseFloat(a.current_value),style:$(parseFloat(o.account.final_value)>parseFloat(a.current_value)?"background-color: #e9ecef; color: red;":""),value:a.bank_account.id},c(a.bank_account.bank_name+" - "+a.bank_account.account_name),13,rt))),128))],8,it)),[[v,o.account.id_bank_account]])])])]),ut,pt]),t("div",_t,[o.account.id_casher?b("",!0):(s(),n("button",{key:0,type:"submit",class:"btn btn-primary",onClick:e[15]||(e[15]=a=>l.updateAccount()),title:o.account.status!=2?"Altere o Status para Pago":"",disabled:o.account.status!=2||!o.account.id_bank_account},"Baixar",8,mt)),t("button",{class:"btn btn-danger",onClick:e[16]||(e[16]=a=>l.back())},"Voltar")])])])])}const Dt=w(A,[["render",ht]]);export{Dt as default};
