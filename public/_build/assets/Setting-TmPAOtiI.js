import{c as g,i as f}from"./utils-B-CemkDS.js";import{S as r}from"./sweetalert2-z6gKu1nJ.js";import{a as p}from"./axios-B4uVmeYG.js";import{r as v,i as b,o as a,c as d,a as t,t as c,j as i,v as n,k as y,F as w,h as k,d as h,b as V,m as C}from"./app-CaSvgjMt.js";import{_ as T}from"./_plugin-vue_export-helper-DlAUqK2U.js";const I={data:function(){return{data:{},setting:{id:"",fantasy_name:"",company_name:"",owner_name:"",menu_logo:"",icon_logo:"",map:"",address:"",number:"",district:"",cep:"",first_email:"",second_email:"",third_email:"",first_telephone:"",second_telephone:"",third_telephone:"",first_whatsapp:"",second_whatsapp:"",third_whatsapp:"",twitter:"",facebook:"",instagram:"",skype:"",linkedin:"",youtube:"",opening_time:"",closing_time:"",id_city:""},cities:{},config:{decimal:".",thousands:"",precision:2,masked:!0},onError:g,isNumber:f}},computed:{},methods:{getSettings(){p.get("/settings/"+this.$route.params.id).then(s=>{this.setting=s.data.setting}).catch(s=>{console.error("Houve um problema com a requisição:",s)})},saveSetting(){this.handlesSpecialCharacters(),p.post("/settings",this.setting).then(s=>{r.fire({position:"top-end",icon:"success",title:s.data.message,showConfirmButton:!1,timer:2500}),this.$router.go(-1)}).catch(s=>{s=this.onError(s),r.fire({position:"top-end",icon:"error",title:s.message,showConfirmButton:!1,timer:2500})})},updateSetting(){this.handlesSpecialCharacters(),p.put("/settings/"+this.$route.params.id,this.setting).then(s=>{r.fire({position:"top-end",icon:"success",title:s.data.message,showConfirmButton:!1,timer:2500}),this.$router.go(-1)}).catch(s=>{r.fire({position:"top-end",icon:"error",title:s.response.data.message,showConfirmButton:!1,timer:2500})})},handlesSpecialCharacters(){this.setting.first_telephone=this.setting.first_telephone!=null?this.setting.first_telephone.replace(/[.\-\s()/]/g,""):"",this.setting.second_telephone=this.setting.second_telephone!=null?this.setting.second_telephone.replace(/[.\-\s()/]/g,""):"",this.setting.third_telephone=this.setting.third_telephone!=null?this.setting.third_telephone.replace(/[.\-\s()/]/g,""):"",this.setting.first_whatsapp=this.setting.first_whatsapp!=null?this.setting.first_whatsapp.replace(/[.\-\s()/]/g,""):"",this.setting.second_whatsapp=this.setting.second_whatsapp!=null?this.setting.second_whatsapp.replace(/[.\-\s()/]/g,""):"",this.setting.third_whatsapp=this.setting.third_whatsapp!=null?this.setting.third_whatsapp.replace(/[.\-\s()/]/g,""):"",this.setting.cep=this.setting.cep!=null?this.setting.cep.replace(/[.\-\s()/]/g,""):""},getCities(){p.get("/cities").then(s=>{this.cities=s.data.cities}).catch(s=>{console.error("Houve um problema com a requisição:",s)})},back(){this.getCities(),this.$router.go(-1)}},beforeMount(){this.getSettings(),this.getCities()}},U={class:"container-fluid"},S={class:"col-md-12"},F=t("h2",null,"Configurações",-1),E={class:"card card-primary"},N={class:"card-header"},A={class:"card-title"},W={class:"card-body"},D={class:"row"},$={class:"col-sm-6"},B={class:"form-group"},L=t("label",{for:"inputFantasyName"},"Nome Fantasia",-1),M={class:"col-sm-6"},P={class:"form-group"},q=t("label",{for:"inputCompanyName"},"Nome da Empresa",-1),H=t("div",{class:"row"},[t("div",{class:"col-sm-12"},[t("div",{class:"card-footer"})])],-1),O={class:"row"},Y={class:"col-sm-5"},j={class:"form-group"},z=t("label",{for:"inputOwnerName"},"Nome do Proprietário",-1),R={class:"col-sm-6"},G={class:"form-group"},J=t("label",{for:"InputAddress"},"Endereço",-1),K={class:"col-sm-1"},Q={class:"form-group"},X=t("label",{for:"inputNumber"},"Número",-1),Z={class:"row"},x={class:"col-sm-2"},tt={class:"form-group"},st=t("label",{for:"inputDistrict"},"Bairro",-1),et={class:"col-sm-4"},ot={class:"form-group"},it=t("label",{for:"inputIdCity"},"Cidade",-1),nt=t("option",{value:""},"Selecione a Cidade",-1),lt=["id","value"],at={class:"col-sm-3"},dt={class:"form-group"},rt=t("label",{for:"inputCep"},"CEP",-1),pt=t("div",{class:"row"},[t("div",{class:"col-sm-12"},[t("div",{class:"card-footer"})])],-1),ct={class:"row"},mt=t("div",{class:"col-sm-3"},[t("label",{class:"form-label",for:"customFile"},"Logo Menu"),t("br"),t("input",{class:"form-label",type:"file",id:"customFile",name:"menu_logo"})],-1),ut={class:"col-sm-3"},ht=t("label",{class:"form-label",for:"customFile"},"Logo Atual",-1),_t=t("br",null,null,-1),gt=t("div",{class:"col-sm-3"},[t("label",{class:"form-label",for:"customFile"},"Logo Ícone"),t("br"),t("input",{class:"form-label",type:"file",id:"customFile",name:"icon_logo"})],-1),ft={class:"col-sm-3"},vt=t("label",{class:"form-label",for:"customFile"},"Logo Ícone Atual",-1),bt=t("br",null,null,-1),yt=t("br",null,null,-1),wt=t("div",{class:"row"},[t("div",{class:"col-sm-12"},[t("div",{class:"card-footer"})])],-1),kt={class:"row"},Vt={class:"col-sm-12"},Ct={class:"form-group"},Tt=t("label",{for:"inputMap"},"Mapa",-1),It=t("div",{class:"row"},[t("div",{class:"col-sm-12"},[t("div",{class:"card-footer"})])],-1),Ut={class:"row"},St={class:"col-sm-4"},Ft={class:"form-group"},Et=t("label",{for:"inputFirstEmail"},"E-mail 1",-1),Nt={class:"col-sm-4"},At={class:"form-group"},Wt=t("label",{for:"inputSecondEmail"},"E-mail 2",-1),Dt={class:"col-sm-4"},$t={class:"form-group"},Bt=t("label",{for:"inputThirdEmail"},"E-mail 3",-1),Lt=t("div",{class:"row"},[t("div",{class:"col-sm-12"},[t("div",{class:"card-footer"})])],-1),Mt={class:"row"},Pt={class:"col-sm-4"},qt={class:"form-group"},Ht=t("label",{for:"inputFirstTelephone"},"Telefone 1",-1),Ot={class:"col-sm-4"},Yt={class:"form-group"},jt=t("label",{for:"inputSecondTelephone"},"Telefone 2",-1),zt={class:"col-sm-4"},Rt={class:"form-group"},Gt=t("label",{for:"inputThirdTelephone"},"Telefone 3",-1),Jt=t("div",{class:"row"},[t("div",{class:"col-sm-12"},[t("div",{class:"card-footer"})])],-1),Kt={class:"row"},Qt={class:"col-sm-4"},Xt={class:"form-group"},Zt=t("label",{for:"inputFirstWhatsapp"},"WhatsApp 1",-1),xt={class:"col-sm-4"},ts={class:"form-group"},ss=t("label",{for:"InputSecondWhatsapp"},"WhatsApp 2",-1),es={class:"col-sm-4"},os={class:"form-group"},is=t("label",{for:"inputThirdWhatsapp"},"WhatsApp 3",-1),ns=t("div",{class:"row"},[t("div",{class:"col-sm-12"},[t("div",{class:"card-footer"})])],-1),ls={class:"row"},as={class:"col-sm-2"},ds={class:"form-group"},rs=t("label",{for:"inputFacebook"},"Facebook",-1),ps={class:"col-sm-2"},cs={class:"form-group"},ms=t("label",{for:"inputInstagram"},"Instagram",-1),us={class:"col-sm-2"},hs={class:"form-group"},_s=t("label",{for:"inputLinkedin"},"Linkedin",-1),gs={class:"col-sm-2"},fs={class:"form-group"},vs=t("label",{for:"inputTwitter"},"Twitter",-1),bs={class:"col-sm-2"},ys={class:"form-group"},ws=t("label",{for:"inputSkype"},"Skype",-1),ks={class:"col-sm-2"},Vs={class:"form-group"},Cs=t("label",{for:"inputYoutube"},"Youtube",-1),Ts=t("div",{class:"row"},[t("div",{class:"col-sm-12"},[t("div",{class:"card-footer"})])],-1),Is={class:"row"},Us={class:"col-sm-3"},Ss={class:"form-group"},Fs=t("label",{for:"inputOpeningTime"},"Horário de Abertura",-1),Es={class:"col-sm-3"},Ns={class:"form-group"},As=t("label",{for:"inputClosingTime"},"Horário de Fechamento",-1),Ws={class:"col-sm-3"},Ds={class:"form-group"},$s=t("label",{for:"InputPercentualAdministrativeTax"},"R$ Taxa Administ.",-1),Bs={class:"input-group"},Ls=t("div",{class:"input-group-prepend"},[t("span",{class:"input-group-text"},[t("i",{class:"fas fa-solid fa-percent"})])],-1),Ms=t("div",{class:"row"},[t("div",{class:"col-sm-12"},[t("div",{class:"card-footer"})])],-1),Ps={class:"modal-footer justify-content-center"};function qs(s,e,Hs,Os,Ys,m){const _=v("money3"),l=b("mask");return a(),d("div",U,[t("div",S,[F,t("div",E,[t("div",N,[t("h3",A,c(s.setting.id?"Editar Configuração":"Cadastrar Configuração"),1)]),t("div",W,[t("div",D,[t("div",$,[t("div",B,[L,i(t("input",{type:"text",class:"form-control",id:"inputFantasyName",placeholder:"Descreva o Nome Fantasia",name:"fantasy_name",maxlength:"30","onUpdate:modelValue":e[0]||(e[0]=o=>s.setting.fantasy_name=o)},null,512),[[n,s.setting.fantasy_name]])])]),t("div",M,[t("div",P,[q,i(t("input",{type:"text",class:"form-control",id:"inputCompanyName",placeholder:"Descreva o Nome da Empresa",name:"company_name",maxlength:"50","onUpdate:modelValue":e[1]||(e[1]=o=>s.setting.company_name=o)},null,512),[[n,s.setting.company_name]])])])]),H,t("div",O,[t("div",Y,[t("div",j,[z,i(t("input",{type:"text",class:"form-control",id:"inputOwnerName",placeholder:"Descreva o Nome do Proprietário",name:"owner_name","onUpdate:modelValue":e[2]||(e[2]=o=>s.setting.owner_name=o),maxlength:"100"},null,512),[[n,s.setting.owner_name]])])]),t("div",R,[t("div",G,[J,i(t("input",{type:"text",class:"form-control",id:"InputAddress",maxlength:"100",placeholder:"Digite o Endereço",name:"address","onUpdate:modelValue":e[3]||(e[3]=o=>s.setting.address=o)},null,512),[[n,s.setting.address]])])]),t("div",K,[t("div",Q,[X,i(t("input",{type:"text",class:"form-control numero",id:"inputNumber",placeholder:"No.",name:"number",maxlength:"5","onUpdate:modelValue":e[4]||(e[4]=o=>s.setting.number=o)},null,512),[[n,s.setting.number]])])])]),t("div",Z,[t("div",x,[t("div",tt,[st,i(t("input",{type:"text",class:"form-control",id:"inputDistrict",placeholder:"Digite o Bairro",maxlength:"30",name:"district","onUpdate:modelValue":e[5]||(e[5]=o=>s.setting.district=o)},null,512),[[n,s.setting.district]])])]),t("div",et,[t("div",ot,[it,i(t("select",{class:"custom-select",id:"inputIdCity",name:"id_city",required:"","onUpdate:modelValue":e[6]||(e[6]=o=>s.setting.id_city=o)},[nt,(a(!0),d(w,null,k(s.cities,(o,u)=>(a(),d("option",{key:u,id:u,value:o.id},c(o.name),9,lt))),128))],512),[[y,s.setting.id_city]])])]),t("div",at,[t("div",dt,[rt,i(t("input",{type:"text",class:"form-control",id:"cep",placeholder:"Digite o CEP",maxlength:"9","onUpdate:modelValue":e[7]||(e[7]=o=>s.setting.cep=o),name:"cep"},null,512),[[n,s.setting.cep]])])])]),pt,t("div",ct,[mt,t("div",ut,[ht,_t,h(" Arquivo: "+c(s.setting.menu_logo),1)]),gt,t("div",ft,[vt,bt,h(" Arquivo: "+c(s.setting.icon_logo),1)])]),yt,wt,t("div",kt,[t("div",Vt,[t("div",Ct,[Tt,i(t("input",{type:"text",class:"form-control",id:"inputMap",placeholder:"Cole aqui o Iframe do Mapa",name:"map","onUpdate:modelValue":e[8]||(e[8]=o=>s.setting.map=o)},null,512),[[n,s.setting.map]])])])]),It,t("div",Ut,[t("div",St,[t("div",Ft,[Et,i(t("input",{type:"text",class:"form-control",id:"inputFirstEmail",placeholder:"Informe o E-mail 1",name:"first_email","onUpdate:modelValue":e[9]||(e[9]=o=>s.setting.first_email=o)},null,512),[[n,s.setting.first_email]])])]),t("div",Nt,[t("div",At,[Wt,i(t("input",{type:"text",class:"form-control",id:"inputSecondEmail",placeholder:"Informe o E-mail 2",name:"second_email","onUpdate:modelValue":e[10]||(e[10]=o=>s.setting.second_email=o)},null,512),[[n,s.setting.second_email]])])]),t("div",Dt,[t("div",$t,[Bt,i(t("input",{type:"text",class:"form-control",id:"inputThirdEmail",placeholder:"Informe o E-mail 3",name:"third_email","onUpdate:modelValue":e[11]||(e[11]=o=>s.setting.third_email=o)},null,512),[[n,s.setting.third_email]])])])]),Lt,t("div",Mt,[t("div",Pt,[t("div",qt,[Ht,i(t("input",{type:"text",class:"form-control",id:"inputFirstTelephone",placeholder:"Informe o Telefone 1",name:"first_telephone",masked:"false","onUpdate:modelValue":e[12]||(e[12]=o=>s.setting.first_telephone=o)},null,512),[[l,["(##) ####-####","(##) #####-####"]],[n,s.setting.first_telephone]])])]),t("div",Ot,[t("div",Yt,[jt,i(t("input",{type:"text",class:"form-control",id:"inputSecondTelephone",placeholder:"Informe o Telefone 2",name:"second_telephone",masked:"false","onUpdate:modelValue":e[13]||(e[13]=o=>s.setting.second_telephone=o)},null,512),[[l,["(##) ####-####","(##) #####-####"]],[n,s.setting.second_telephone]])])]),t("div",zt,[t("div",Rt,[Gt,i(t("input",{type:"text",class:"form-control",id:"inputThirdTelephone",placeholder:"Informe o Telefone 3",name:"third_telephone",masked:"false","onUpdate:modelValue":e[14]||(e[14]=o=>s.setting.third_telephone=o)},null,512),[[l,["(##) ####-####","(##) #####-####"]],[n,s.setting.third_telephone]])])])]),Jt,t("div",Kt,[t("div",Qt,[t("div",Xt,[Zt,i(t("input",{type:"text",class:"form-control",id:"inputFirstWhatsapp",placeholder:"Informe o WhatsApp 1",name:"first_whatsapp",masked:"false","onUpdate:modelValue":e[15]||(e[15]=o=>s.setting.first_whatsapp=o)},null,512),[[l,["(##) ####-####","(##) #####-####"]],[n,s.setting.first_whatsapp]])])]),t("div",xt,[t("div",ts,[ss,i(t("input",{type:"text",class:"form-control",id:"InputSecondWhatsapp",placeholder:"Informe o WhatsApp 2",name:"second_whatsapp",masked:"false","onUpdate:modelValue":e[16]||(e[16]=o=>s.setting.second_whatsapp=o)},null,512),[[l,["(##) ####-####","(##) #####-####"]],[n,s.setting.second_whatsapp]])])]),t("div",es,[t("div",os,[is,i(t("input",{type:"text",class:"form-control",id:"inputThirdWhatsapp",placeholder:"Informe o WhatsApp 3",name:"third_whatsapp",masked:"false","onUpdate:modelValue":e[17]||(e[17]=o=>s.setting.third_whatsapp=o)},null,512),[[l,["(##) ####-####","(##) #####-####"]],[n,s.setting.third_whatsapp]])])])]),ns,t("div",ls,[t("div",as,[t("div",ds,[rs,i(t("input",{type:"text",class:"form-control",id:"inputFacebook",placeholder:"Informe o Facebook",name:"facebook","onUpdate:modelValue":e[18]||(e[18]=o=>s.setting.facebook=o)},null,512),[[n,s.setting.facebook]])])]),t("div",ps,[t("div",cs,[ms,i(t("input",{type:"text",class:"form-control",id:"inputInstagram",placeholder:"Informe o Instagram",name:"instagram","onUpdate:modelValue":e[19]||(e[19]=o=>s.setting.instagram=o)},null,512),[[n,s.setting.instagram]])])]),t("div",us,[t("div",hs,[_s,i(t("input",{type:"text",class:"form-control",id:"inputLinkedin",placeholder:"Informe o Linkedin",name:"linkedin","onUpdate:modelValue":e[20]||(e[20]=o=>s.setting.linkedin=o)},null,512),[[n,s.setting.linkedin]])])]),t("div",gs,[t("div",fs,[vs,i(t("input",{type:"text",class:"form-control",id:"inputTwitter",placeholder:"Informe o Twitter",name:"twitter","onUpdate:modelValue":e[21]||(e[21]=o=>s.setting.twitter=o)},null,512),[[n,s.setting.twitter]])])]),t("div",bs,[t("div",ys,[ws,i(t("input",{type:"text",class:"form-control",id:"inputSkype",placeholder:"Informe o Skype",name:"skype","onUpdate:modelValue":e[22]||(e[22]=o=>s.setting.skype=o)},null,512),[[n,s.setting.skype]])])]),t("div",ks,[t("div",Vs,[Cs,i(t("input",{type:"text",class:"form-control",id:"inputYoutube",placeholder:"Informe o Youtube",name:"youtube","onUpdate:modelValue":e[23]||(e[23]=o=>s.setting.youtube=o)},null,512),[[n,s.setting.youtube]])])])]),Ts,t("div",Is,[t("div",Us,[t("div",Ss,[Fs,i(t("input",{type:"text",class:"form-control",id:"inputOpeningTime",placeholder:"Hora de Abertura",name:"opening_time","onUpdate:modelValue":e[24]||(e[24]=o=>s.setting.opening_time=o)},null,512),[[n,s.setting.opening_time]])])]),t("div",Es,[t("div",Ns,[As,i(t("input",{type:"text",class:"form-control",id:"inputClosingTime",placeholder:"Hora de Fechamento",name:"closing_time","onUpdate:modelValue":e[25]||(e[25]=o=>s.setting.closing_time=o)},null,512),[[n,s.setting.closing_time]])])]),t("div",Ws,[t("div",Ds,[$s,t("div",Bs,[Ls,V(_,C({class:"form-control",modelValue:s.setting.administrative_tax,"onUpdate:modelValue":e[26]||(e[26]=o=>s.setting.administrative_tax=o)},s.config,{id:"inputValueProperty",name:"property_value"}),null,16,["modelValue"])])])])]),Ms]),t("div",Ps,[s.setting.id?(a(),d("button",{key:0,type:"submit",class:"btn btn-primary",onClick:e[27]||(e[27]=o=>m.updateSetting())},"Atualizar")):(a(),d("button",{key:1,type:"submit",class:"btn btn-primary",onClick:e[28]||(e[28]=o=>m.saveSetting())},"Salvar")),t("button",{class:"btn btn-danger",onClick:e[29]||(e[29]=o=>m.back())},"Voltar")])])])])}const Ks=T(I,[["render",qs]]);export{Ks as default};
