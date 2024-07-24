import{O as u,P as c}from"./utils-B-CemkDS.js";import{S as n}from"./sweetalert2-z6gKu1nJ.js";import{a as d}from"./axios-B4uVmeYG.js";import{i as m,o as p,c as f,a as s,j as r,v as i}from"./app-e3q45BkK.js";import{_ as h}from"./_plugin-vue_export-helper-DlAUqK2U.js";const _={data:function(){return{user:{id:"",name:"",cellphone:"",cpf:"",email:"",type:"",status:""},status:u,users_type:c}},methods:{getUser(){d.get("/users/"+this.$route.params.id).then(e=>{this.user=e.data.user}).catch(e=>{console.error("Houve um problema com a requisição:",e)})},updateUser(){d.put("/users/"+this.$route.params.id,this.user).then(e=>{console.log("entrei aqui"),n.fire({position:"top-end",icon:"success",title:e.data.message,showConfirmButton:!1,timer:2500}),setTimeout(()=>{this.$router.go(-1)},2500)}).catch(e=>{n.fire({position:"top-end",icon:"error",title:e.response.data.message,showConfirmButton:!1,timer:2500}),console.error("Houve um problema com a requisição:",e)})},back(){this.$router.go(-1)}},beforeMount(){this.$route.params.id&&this.getUser()}},v={class:"container-fluid"},g={class:"col-md-12"},b=s("h2",null,"Usuários",-1),y={class:"card card-primary"},U=s("div",{class:"card-header"},[s("h3",{class:"card-title"},"Editar Meu Usuário ")],-1),w={class:"card-body"},C={class:"row"},k={class:"col-sm-4"},$={class:"form-group"},E=s("label",{for:"inputName"},"Nome",-1),V={class:"col-sm-4"},q={class:"form-group"},B=s("label",{for:"inputCellphone"},"Celular",-1),D={class:"col-sm-4"},N={class:"form-group"},P=s("label",{for:"inputCpf"},"CPF",-1),M={class:"row"},S={class:"col-sm-6"},T={class:"form-group"},j=s("label",{for:"inputEmail"},"Email",-1),F={class:"col-sm-6"},H={class:"form-group"},x=s("label",{for:"inputPassword"},"Senha",-1),z={class:"modal-footer justify-content-center"};function A(e,o,I,O,G,a){const l=m("mask");return p(),f("div",v,[s("div",g,[b,s("div",y,[U,s("div",w,[s("div",C,[s("div",k,[s("div",$,[E,r(s("input",{type:"text",class:"form-control",id:"inputName",name:"name","onUpdate:modelValue":o[0]||(o[0]=t=>e.user.name=t),placeholder:"Digite o Nome",required:"",maxlength:"50"},null,512),[[i,e.user.name]])])]),s("div",V,[s("div",q,[B,r(s("input",{type:"text",class:"form-control",id:"inputCellphone",placeholder:"Informe o celular",name:"cellphone","onUpdate:modelValue":o[1]||(o[1]=t=>e.user.cellphone=t),masked:"false",required:""},null,512),[[i,e.user.cellphone],[l,["(##) ####-####","(##) #####-####"]]])])]),s("div",D,[s("div",N,[P,r(s("input",{type:"text",class:"form-control",id:"inputCpf",placeholder:"Digite o CPF","onUpdate:modelValue":o[2]||(o[2]=t=>e.user.cpf=t),name:"cpf"},null,512),[[i,e.user.cpf],[l,"###.###.###-##"]])])])]),s("div",M,[s("div",S,[s("div",T,[j,r(s("input",{type:"text",class:"form-control",id:"inputEmail",placeholder:"Digite o Email",name:"email",maxlength:"140","onUpdate:modelValue":o[3]||(o[3]=t=>e.user.email=t),required:""},null,512),[[i,e.user.email]])])]),s("div",F,[s("div",H,[x,r(s("input",{type:"password",class:"form-control",id:"inputPassword",placeholder:"************","onUpdate:modelValue":o[4]||(o[4]=t=>e.user.password=t),name:"password"},null,512),[[i,e.user.password]])])])])]),s("div",z,[s("button",{type:"submit",class:"btn btn-primary",onClick:o[5]||(o[5]=t=>a.updateUser())},"Atualizar"),s("button",{class:"btn btn-danger",onClick:o[6]||(o[6]=t=>a.back())},"Voltar")])])])])}const W=h(_,[["render",A]]);export{W as default};
