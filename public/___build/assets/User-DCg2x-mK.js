import{O as v,P as b}from"./utils-B-CemkDS.js";import{S as u}from"./sweetalert2-z6gKu1nJ.js";import{a as p}from"./axios-B4uVmeYG.js";import{i as g,o as i,c as r,a as s,t as m,j as a,v as n,k as h,F as f,h as _}from"./app-e3q45BkK.js";import{_ as y}from"./_plugin-vue_export-helper-DlAUqK2U.js";const U={data:function(){return{user:{id:"",name:"",cellphone:"",cpf:"",email:"",type:"",status:""},status:v,users_type:b}},methods:{getUser(){p.get("/users/"+this.$route.params.id).then(e=>{this.user=e.data.user}).catch(e=>{console.error("Houve um problema com a requisição:",e)})},saveUser(){p.post("/users",this.user).then(e=>{u.fire({position:"top-end",icon:"success",title:e.data.message,showConfirmButton:!1,timer:2500}),this.$router.go(-1)}).catch(e=>{u.fire({position:"top-end",icon:"error",title:e.response.data.message,showConfirmButton:!1,timer:2500}),console.error("Houve um problema com a requisição:",e)})},updateUser(){p.put("/users/"+this.$route.params.id,this.user).then(e=>{u.fire({position:"top-end",icon:"success",title:e.data.message,showConfirmButton:!1,timer:2500}),this.$router.go(-1)}).catch(e=>{u.fire({position:"top-end",icon:"error",title:e.response.data.message,showConfirmButton:!1,timer:2500}),console.error("Houve um problema com a requisição:",e)})},back(){this.$router.go(-1)}},beforeMount(){this.$route.params.id&&this.getUser()}},C={class:"container-fluid"},w={class:"col-md-12"},k=s("h2",null,"Usuários",-1),S={class:"card card-primary"},$={class:"card-header"},V={class:"card-title"},q={class:"card-body"},B={class:"row"},D={class:"col-sm-4"},E={class:"form-group"},N=s("label",{for:"inputName"},"Nome",-1),P={class:"col-sm-4"},T={class:"form-group"},F=s("label",{for:"inputCellphone"},"Celular",-1),H={class:"col-sm-4"},M={class:"form-group"},j=s("label",{for:"inputCpf"},"CPF",-1),z={class:"row"},A={class:"col-sm-3"},I={class:"form-group"},L=s("label",{for:"inputEmail"},"Email",-1),O={class:"col-sm-3"},G={class:"form-group"},J=s("label",{for:"inputPassword"},"Senha",-1),K={class:"col-sm-3"},Q={class:"form-group"},R=s("label",{for:"inputType"},"Tipo",-1),W=s("option",{value:""},"Selecione o Tipo",-1),X=["value"],Y={class:"col-sm-3"},Z={class:"form-group"},x=s("label",{for:"inputStatus"},"Status",-1),ss=s("option",{value:""},"Selecione o Status",-1),es=["value"],os={class:"modal-footer justify-content-center"};function ts(e,o,is,rs,as,d){const c=g("mask");return i(),r("div",C,[s("div",w,[k,s("div",S,[s("div",$,[s("h3",V,m(e.user.id?"Editar Usuário":"Cadastrar Usuário"),1)]),s("div",q,[s("div",B,[s("div",D,[s("div",E,[N,a(s("input",{type:"text",class:"form-control",id:"inputName",name:"name","onUpdate:modelValue":o[0]||(o[0]=t=>e.user.name=t),placeholder:"Digite o Nome",required:"",maxlength:"50"},null,512),[[n,e.user.name]])])]),s("div",P,[s("div",T,[F,a(s("input",{type:"text",class:"form-control",id:"inputCellphone",placeholder:"Informe o celular",name:"cellphone","onUpdate:modelValue":o[1]||(o[1]=t=>e.user.cellphone=t),masked:"false",required:""},null,512),[[n,e.user.cellphone],[c,["(##) ####-####","(##) #####-####"]]])])]),s("div",H,[s("div",M,[j,a(s("input",{type:"text",class:"form-control",id:"inputCpf",placeholder:"Digite o CPF","onUpdate:modelValue":o[2]||(o[2]=t=>e.user.cpf=t),name:"cpf"},null,512),[[n,e.user.cpf],[c,"###.###.###-##"]])])])]),s("div",z,[s("div",A,[s("div",I,[L,a(s("input",{type:"text",class:"form-control",id:"inputEmail",placeholder:"Digite o Email",name:"email",maxlength:"140","onUpdate:modelValue":o[3]||(o[3]=t=>e.user.email=t),required:""},null,512),[[n,e.user.email]])])]),s("div",O,[s("div",G,[J,a(s("input",{type:"password",class:"form-control",id:"inputPassword",placeholder:"************","onUpdate:modelValue":o[4]||(o[4]=t=>e.user.password=t),name:"password"},null,512),[[n,e.user.password]])])]),s("div",K,[s("div",Q,[R,a(s("select",{class:"custom-select",id:"inputType",name:"type","onUpdate:modelValue":o[5]||(o[5]=t=>e.user.type=t),required:""},[W,(i(!0),r(f,null,_(e.users_type,(t,l)=>(i(),r("option",{key:l,value:l},m(t),9,X))),128))],512),[[h,e.user.type]])])]),s("div",Y,[s("div",Z,[x,a(s("select",{class:"custom-select",id:"inputStatus",name:"status",required:"","onUpdate:modelValue":o[6]||(o[6]=t=>e.user.status=t)},[ss,(i(!0),r(f,null,_(e.status,(t,l)=>(i(),r("option",{key:l,value:l},m(t),9,es))),128))],512),[[h,e.user.status]])])])])]),s("div",os,[e.user.id?(i(),r("button",{key:0,type:"submit",class:"btn btn-primary",onClick:o[7]||(o[7]=t=>d.updateUser())},"Atualizar")):(i(),r("button",{key:1,type:"submit",class:"btn btn-primary",onClick:o[8]||(o[8]=t=>d.saveUser())},"Salvar")),s("button",{class:"btn btn-danger",onClick:o[9]||(o[9]=t=>d.back())},"Voltar")])])])])}const ms=y(U,[["render",ts]]);export{ms as default};