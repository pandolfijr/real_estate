import{p as A,s as B,a as N,o as I,i as T,b as E,c as F}from"./utils-B-CemkDS.js";import{S as w}from"./sweetalert2-z6gKu1nJ.js";import{a as g}from"./axios-B4uVmeYG.js";import{r as S,i as L,o as r,c as i,a as e,t as u,j as n,v as d,k as b,F as m,h,e as c,n as R,b as v,m as k,l as q,d as K,q as M,w as D}from"./app-e3q45BkK.js";import{_ as z}from"./_plugin-vue_export-helper-DlAUqK2U.js";const H={data:function(){return{data:{},property:{reference:"",description:"",address:"",number:"",district:"",display_address:"",status:1,purpose:"",type:"",cep:"",area:"",bedrooms:"",suites:"",bathrooms:"",parking_space:"",emphasis:"",sale_value:"",rental_value:"",iptu_value:"",condo_value:"",chronic_problem:"",apartment_number:"",court:"",tower:"",floor:"",lot:"",id_city:"",id_locator:"",id_condo:"",administrative_tax_percentual:"",administrative_tax_value:""},config:{decimal:".",thousands:"",precision:2,masked:!0},main:"",cities:{},locators:{},images:[],exclude:[],condos:{},setting:{},disable_address:!1,properties_type:A,status_properties:B,purpose:N,options:I,isNumber:T,phoneMask:E,onError:F}},methods:{getProperty(){g.get("/properties/"+this.$route.params.id).then(o=>{var s;this.property=o.data.property,this.property.pictures&&this.property.pictures.length>0&&(this.main=(s=this.property.pictures.find(p=>p.main===1))==null?void 0:s.id),this.property.id_condo&&(this.disable_address=!0)}).catch(o=>{console.error("Houve um problema com a requisição:",o)})},saveProperty(){this.handlesSpecialCharacters(),this.images.length>0&&(this.property.images=this.images),this.property.main=this.main??"",this.property.exclude=this.exclude??[],this.property.main=this.main??"",g.post("/properties",this.property).then(o=>{w.fire({position:"top-end",icon:"success",title:o.data.message,showConfirmButton:!1,timer:2500}),this.$router.go(-1)}).catch(o=>{o&&o.response.data.errors?o=this.onError(o):o=o.response.data,w.fire({position:"top-end",icon:"error",title:o.message,showConfirmButton:!1,timer:2500})})},updateProperty(){this.handlesSpecialCharacters(),this.images.length>0&&(this.property.images=this.images),this.property.main=this.main??"",this.property.exclude=this.exclude??[],this.property.main=this.main??"",g.put("/properties/"+this.$route.params.id,this.property).then(o=>{w.fire({position:"top-end",icon:"success",title:o.data.message,showConfirmButton:!1,timer:2500}),this.$router.go(-1)}).catch(o=>{w.fire({position:"top-end",icon:"error",title:o.response.data.message,showConfirmButton:!1,timer:2500})})},handleFileChange(o){this.images=[];const s=o.target.files;if(s.length>0)for(let p=0;p<s.length;p++){const V=s[p];this.convertToBase64(V)}},handleFileUpload(o){const s=o.target.files,p=1024;for(let V=0;V<s.length;V++){const U=s[V],a=new FileReader;a.onload=y=>{const _=new Image;_.src=y.target.result,_.onload=()=>{const C=document.createElement("canvas"),t=C.getContext("2d");let l=_.width,f=_.height;l>f?l>p&&(f*=p/l,l=p):f>p&&(l*=p/f,f=p),C.width=l,C.height=f,t.drawImage(_,0,0,l,f);const P=C.toDataURL("image/jpeg");this.images.push(P)}},a.readAsDataURL(U)}},convertToBase64(o){const s=new FileReader;s.readAsDataURL(o),s.onload=()=>{this.images.push(s.result)}},back(){this.$router.go(-1)},getCities(){g.get("/cities",{}).then(o=>{this.cities=o.data.cities}).catch(o=>{console.error("Houve um problema com a requisição:",o)})},getLocators(){g.get("/locators",{}).then(o=>{this.locators=o.data.locators.data}).catch(o=>{console.error("Houve um problema com a requisição:",o)})},handlesSpecialCharacters(){this.property.cep=this.property.cep!=null?this.property.cep.replace(/[.\-\s()/]/g,""):""},treatExcludes(o){if(this.exclude.includes(o)){const s=this.exclude.indexOf(o);this.exclude.splice(s,1)}},getCondos(){g.get("/condos").then(o=>{this.condos=o.data.condos.data}).catch(o=>{console.error("Houve um problema com a requisição:",o)})},treatCondo(o){o!=""?(this.select_condo=this.condos.find(s=>s.id==o),this.property.id_city=this.select_condo.city.id,this.property.cep=this.select_condo.cep,this.property.number=this.select_condo.number,this.property.address=this.select_condo.address,this.property.district=this.select_condo.district,this.disable_address=!0):(this.property.id_city="",this.property.cep="",this.property.address="",this.property.number="",this.disable_address=!1,this.property.district="")},treatPropertyType(o){this.validateCondo(o)?this.disable_address=!0:(this.property.id_condo="",this.treatCondo(""))},treatValues(){let o=0;const s=this.property.iptu_value?parseFloat(this.property.iptu_value):0,p=this.property.condo_value?parseFloat(this.property.condo_value):0;this.property.purpose==1?o=this.property.sale_value?parseFloat(this.property.sale_value):0:this.property.purpose==2&&(o=this.property.rental_value?parseFloat(this.property.rental_value):0),this.property.administrative_tax_value=(o+s+p)*(this.property.administrative_tax_percentual/100)},validateCondo(o){if(o)return[1,5,10,12,18,21].includes(parseInt(o))},getSettings(){g.get("/settings/1").then(o=>{this.setting=o.data.setting,(this.property.administrative_tax_percentual=="0.00"||!this.property.administrative_tax_percentual)&&(this.property.administrative_tax_percentual=this.setting.administrative_tax)}).catch(o=>{console.error("Houve um problema com a requisição:",o)})}},created(){this.getCities(),this.getLocators(),this.getCondos(),this.$route.params.id&&this.getProperty(),this.getSettings()}},j={class:"container-fluid"},G={class:"col-md-12"},Q=e("h2",null,"Imóveis",-1),O={class:"card card-primary"},J={class:"card-header"},W={key:0,class:"card-title"},X={key:1,class:"card-title"},Y={key:2,class:"card-title"},Z={class:"card-body"},$={class:"row"},x={class:"col-sm-2"},ee={class:"form-group"},oe=e("label",{for:"inputReference"},"Ref.",-1),te={type:"text",class:"form-control",id:"inputReference",title:"Gerado Automáticamente após salvar",readonly:"",name:"reference"},se={class:"col-sm-6"},re={class:"form-group"},ie=e("label",{for:"InputDescription"},"Descrição do Imóvel",-1),le={class:"col-sm-4"},ae={class:"form-group"},ne=e("label",{for:"inputLocator"},"Proprietário do Imóvel",-1),de=e("option",{value:""},"Selecione... ",-1),pe=["id","value"],ue={class:"row"},ce={class:"col-sm-3"},me={class:"form-group"},he=e("label",{for:"inputPurpose"},"Finalidade",-1),ye=e("option",{value:""},"Selecione...",-1),_e=["value"],ve={class:"col-sm-3"},fe={class:"form-group"},ge=e("label",{for:"inputStatus"},"Status",-1),be=e("option",{value:""},"Selecione...",-1),Ve=["value"],Ce={class:"col-sm-3"},ke={class:"form-group"},we=e("label",{for:"inputType"},"Tipo de Imóvel",-1),Ue=e("option",{value:""},"Selecione...",-1),Se=["id","value"],De={class:"col-sm-3"},Pe={class:"form-group"},Ae=e("label",{for:"inputDisplayAddress"},"Exibir Endereço",-1),Be=e("option",{value:""},"Selecione...",-1),Ne=["value"],Ie={class:"row"},Te={key:0,class:"col-sm-2"},Ee={class:"form-group"},Fe=e("label",{for:"inputCondo"},"Cond./Prédio",-1),Le=e("option",{value:""},"Selecione...",-1),Re=["id","value"],qe={class:"form-group"},Ke=e("label",{for:"inputAddress"},"Endereço",-1),Me=["disabled"],ze={class:"col-sm-1"},He={class:"form-group"},je=e("label",{for:"inputNumber"},"Número",-1),Ge=["disabled"],Qe={class:"col-sm-2"},Oe={class:"form-group"},Je=e("label",{for:"inputDistrict"},"Bairro",-1),We=["disabled"],Xe={class:"col-sm-2"},Ye={class:"form-group"},Ze=e("label",{for:"inputCep"},"CEP",-1),$e=["disabled"],xe={class:"col-sm-2"},eo={class:"form-group"},oo=e("label",{for:"inputCity"},"Cidade",-1),to=["disabled"],so=e("option",{value:""},"Selecione...",-1),ro=["id","value"],io={key:0,class:"row"},lo={class:"col-sm-2"},ao={class:"form-group"},no=e("label",{for:"inputApartmentNumber"},"Nº Apto.",-1),po={class:"col-sm-2"},uo={class:"form-group"},co=e("label",{for:"inputFloor"},"Andar",-1),mo={class:"col-sm-2"},ho={class:"form-group"},yo=e("label",{for:"inputCourt"},"Quadra",-1),_o={class:"col-sm-2"},vo={class:"form-group"},fo=e("label",{for:"inputTower"},"Torre",-1),go={class:"col-sm-2"},bo={class:"form-group"},Vo=e("label",{for:"inputLot"},"Lote",-1),Co=e("div",{class:"row"},null,-1),ko=e("div",{class:"row"},[e("div",{class:"col-sm-12"},[e("div",{class:"card-footer"})])],-1),wo={class:"row"},Uo={class:"col-sm-2"},So={class:"form-group"},Do=e("label",{for:"inputArea"},"Área (m²)",-1),Po={class:"col-sm-2"},Ao={class:"form-group"},Bo=e("label",{for:"inputBedrooms"},"Dormitórios",-1),No={class:"col-sm-2"},Io={class:"form-group"},To=e("label",{for:"inputSuites"},"Suítes",-1),Eo={class:"col-sm-2"},Fo={class:"form-group"},Lo=e("label",{for:"inputBathrooms"},"Banheiros",-1),Ro={class:"col-sm-2"},qo={class:"form-group"},Ko=e("label",{for:"inputParkingSpace"},"Vagas na Garagem",-1),Mo=e("div",{class:"row"},[e("div",{class:"col-sm-12"},[e("div",{class:"card-footer"})])],-1),zo={class:"row"},Ho={key:0,class:"col-sm-3"},jo={class:"form-group"},Go=e("label",{for:"inputSaleValue"},"Valor Venda",-1),Qo={class:"input-group"},Oo=e("div",{class:"input-group-prepend"},[e("span",{class:"input-group-text"},[e("i",{class:"fas fa-dollar-sign"})])],-1),Jo={key:1,class:"col-sm-3"},Wo={class:"form-group"},Xo=e("label",{for:"inputRentalValue"},"Valor Locação",-1),Yo={class:"input-group"},Zo=e("div",{class:"input-group-prepend"},[e("span",{class:"input-group-text"},[e("i",{class:"fas fa-dollar-sign"})])],-1),$o={class:"col-sm-3"},xo={class:"form-group"},et=e("label",{for:"inputIptuValue"},"Valor IPTU",-1),ot={class:"input-group"},tt=e("div",{class:"input-group-prepend"},[e("span",{class:"input-group-text"},[e("i",{class:"fas fa-dollar-sign"})])],-1),st={key:2,class:"col-sm-3"},rt={class:"form-group"},it=e("label",{for:"inputCondoValue"},"Valor Condomínio",-1),lt={class:"input-group"},at=e("div",{class:"input-group-prepend"},[e("span",{class:"input-group-text"},[e("i",{class:"fas fa-dollar-sign"})])],-1),nt=e("div",{class:"row"},[e("div",{class:"col-sm-12"},[e("div",{class:"card-footer"})])],-1),dt={class:"row"},pt={class:"col-sm-4"},ut={class:"form-group"},ct=e("label",{for:"inputSaleValue"},"Valor Percentual Taxa Adm.",-1),mt={class:"input-group"},ht=e("div",{class:"input-group-prepend"},[e("span",{class:"input-group-text"},[e("i",{class:"fas fa-percentage"})])],-1),yt={class:"col-sm-4"},_t={class:"form-group"},vt=e("label",{for:"inputRentalValue"},"Comissão Imobiliária R$",-1),ft={class:"input-group"},gt=e("div",{class:"input-group-prepend"},[e("span",{class:"input-group-text"},[e("i",{class:"fas fa-dollar-sign"})])],-1),bt=e("div",{class:"row"},[e("div",{class:"col-sm-12"},[e("div",{class:"card-footer"})])],-1),Vt={class:"row"},Ct={class:"col-sm-12"},kt={class:"form-group"},wt=e("label",{for:"inputChronicProblem"},"Problemas Crônicos",-1),Ut={class:"input-group"},St=e("div",{class:"row"},[e("div",{class:"col-sm-12"},[e("div",{class:"card-footer"})])],-1),Dt=e("br",null,null,-1),Pt={key:1,class:"col-sm-12"},At={class:"row",style:{"text-align":"center","margin-top":"2em"}},Bt=["src"],Nt={key:2,class:"row"},It=e("div",{class:"col-sm-12"},[e("div",{class:"card-footer"})],-1),Tt=[It],Et={class:"modal-footer justify-content-center"},Ft={key:0},Lt={key:0,class:"col-md-12"},Rt={class:"card card-primary"},qt=e("div",{class:"card-header"},[e("h3",{class:"card-title"},"Imagens do Imóvel")],-1),Kt={class:"card-body"},Mt={class:"container"},zt={class:"row",style:{"text-align":"center"}},Ht=["src"],jt=e("br",null,null,-1),Gt={key:0},Qt={style:{color:"#f89d52"}},Ot=e("b",null,"Principal: ",-1),Jt=["id","value","checked","onClick"],Wt=e("br",null,null,-1),Xt={key:0,style:{color:"#c82333"}},Yt=e("b",null,"Excluir:",-1),Zt=["id","value"],$t={key:1,class:"card card-primary"},xt={class:"card-header"},es={class:"card-title"},os={class:"card-body"},ts={class:"scrollable text-left"},ss={class:"table table-head-fixed text-nowrap text-left"},rs=e("thead",null,[e("tr",null,[e("th",{class:"md='auto'"},"ID"),e("th",{class:"md='auto'"},"Nome Completo do locador/comprador"),e("th",{class:"md='auto'"},"Contato"),e("th",{class:"md='auto'"},"E-mail"),e("th",{class:"md='auto'"},"Ver Proprietário"),e("th",{class:"md='auto'"},"Ver Transação")])],-1),is=e("button",{type:"button",class:"btn btn-outline-primary",style:{"margin-top":"-0.5em"}},[e("i",{class:"fas fa-solid fa-eye"})],-1),ls={class:"col-sm-1"},as=e("button",{type:"button",class:"btn btn-outline-primary",style:{"margin-top":"-0.5em"}},[e("i",{class:"fas fa-solid fa-eye"})],-1);function ns(o,s,p,V,U,a){const y=S("money3"),_=S("router-link"),C=L("mask");return r(),i("div",j,[e("div",G,[Q,e("div",O,[e("div",J,[o.property.id_transaction?(r(),i("h3",W,"Visualizar Imóvel")):o.property.id?(r(),i("h3",X,"Editar")):(r(),i("h3",Y,"Cadastrar"))]),e("div",Z,[e("div",$,[e("div",x,[e("div",ee,[oe,e("div",te,u(o.property.reference),1)])]),e("div",se,[e("div",re,[ie,n(e("input",{type:"text",class:"form-control",id:"InputDescription",placeholder:"Descreva o Imóvel",name:"description",maxlength:"100","onUpdate:modelValue":s[0]||(s[0]=t=>o.property.description=t)},null,512),[[d,o.property.description]])])]),e("div",le,[e("div",ae,[ne,n(e("select",{class:"custom-select",id:"inputLocator",name:"id_locator",required:"","onUpdate:modelValue":s[1]||(s[1]=t=>o.property.id_locator=t)},[de,(r(!0),i(m,null,h(o.locators,t=>(r(),i("option",{key:t.id,id:t.id,value:t.id},u(t.people.name+" "+t.people.surname),9,pe))),128))],512),[[b,o.property.id_locator]])])])]),e("div",ue,[e("div",ce,[e("div",me,[he,n(e("select",{class:"custom-select",id:"inputPurpose",name:"purpose",required:"","onUpdate:modelValue":s[2]||(s[2]=t=>o.property.purpose=t)},[ye,(r(!0),i(m,null,h(o.purpose,(t,l)=>(r(),i("option",{key:l,value:l},u(t),9,_e))),128))],512),[[b,o.property.purpose]])])]),e("div",ve,[e("div",fe,[ge,n(e("select",{class:"custom-select",id:"inputStatus",name:"status",disabled:"","onUpdate:modelValue":s[3]||(s[3]=t=>o.property.status=t)},[be,(r(!0),i(m,null,h(o.status_properties,(t,l)=>(r(),i("option",{key:l,value:l},u(t),9,Ve))),128))],512),[[b,o.property.status]])])]),e("div",Ce,[e("div",ke,[we,n(e("select",{id:"inputType",class:"form-control",name:"type",required:"",onChange:s[4]||(s[4]=t=>a.treatPropertyType(t.target.value)),"onUpdate:modelValue":s[5]||(s[5]=t=>o.property.type=t)},[Ue,(r(!0),i(m,null,h(o.properties_type,t=>(r(),i("option",{key:t.id,id:t.id,value:t.id},u(t.description),9,Se))),128))],544),[[b,o.property.type]])])]),e("div",De,[e("div",Pe,[Ae,n(e("select",{class:"custom-select",id:"inputDisplayAddress",name:"display_address","onUpdate:modelValue":s[6]||(s[6]=t=>o.property.display_address=t)},[Be,(r(!0),i(m,null,h(o.options,(t,l)=>(r(),i("option",{key:l,value:l},u(t),9,Ne))),128))],512),[[b,o.property.display_address]])])])]),e("div",Ie,[a.validateCondo(o.property.type)?(r(),i("div",Te,[e("div",Ee,[Fe,n(e("select",{class:"custom-select",id:"inputCondo",name:"condo",required:"",onChange:s[7]||(s[7]=t=>a.treatCondo(t.target.value)),"onUpdate:modelValue":s[8]||(s[8]=t=>o.property.id_condo=t)},[Le,(r(!0),i(m,null,h(o.condos,t=>(r(),i("option",{key:t.id,id:t.id,value:t.id},u(t.description),9,Re))),128))],544),[[b,o.property.id_condo]])])])):c("",!0),e("div",{class:R(a.validateCondo(o.property.type)?"col-sm-3":"col-sm-5")},[e("div",qe,[Ke,n(e("input",{type:"text",class:"form-control",id:"inputAddress",maxlength:"100",placeholder:"Digite o Endereço",name:"address","onUpdate:modelValue":s[9]||(s[9]=t=>o.property.address=t),disabled:a.validateCondo(o.property.type)},null,8,Me),[[d,o.property.address]])])],2),e("div",ze,[e("div",He,[je,n(e("input",{type:"text",class:"form-control",id:"inputNumber",placeholder:"No.",onKeypress:s[10]||(s[10]=t=>o.isNumber(t)),name:"number",maxlength:"5","onUpdate:modelValue":s[11]||(s[11]=t=>o.property.number=t),disabled:a.validateCondo(o.property.type)},null,40,Ge),[[d,o.property.number]])])]),e("div",Qe,[e("div",Oe,[Je,n(e("input",{type:"text",class:"form-control",id:"inputDistrict",placeholder:"Digite o Bairro",maxlength:"20",name:"district","onUpdate:modelValue":s[12]||(s[12]=t=>o.property.district=t),disabled:a.validateCondo(o.property.type)},null,8,We),[[d,o.property.district]])])]),e("div",Xe,[e("div",Ye,[Ze,n(e("input",{type:"text",class:"form-control cep",id:"cep",placeholder:"Digite o CEP",masked:"false",name:"cep","onUpdate:modelValue":s[13]||(s[13]=t=>o.property.cep=t),disabled:a.validateCondo(o.property.type)},null,8,$e),[[C,"#####-###"],[d,o.property.cep]])])]),e("div",xe,[e("div",eo,[oo,n(e("select",{class:"custom-select",id:"inputCity",name:"city",required:"","onUpdate:modelValue":s[14]||(s[14]=t=>o.property.id_city=t),disabled:a.validateCondo(o.property.type)},[so,(r(!0),i(m,null,h(o.cities,(t,l)=>(r(),i("option",{key:l,id:l,value:t.id},u(t.name),9,ro))),128))],8,to),[[b,o.property.id_city]])])])]),a.validateCondo(o.property.type)?(r(),i("div",io,[e("div",lo,[e("div",ao,[no,n(e("input",{type:"text",class:"form-control",id:"apartment_number",placeholder:"Digite o Número do Apartamento",onKeypress:s[15]||(s[15]=t=>o.isNumber(t)),name:"apartment_number","onUpdate:modelValue":s[16]||(s[16]=t=>o.property.apartment_number=t)},null,544),[[d,o.property.apartment_number]])])]),e("div",po,[e("div",uo,[co,n(e("input",{type:"text",class:"form-control",id:"floor",placeholder:"Digite o Andar do Apartamento",onKeypress:s[17]||(s[17]=t=>o.isNumber(t)),name:"floor","onUpdate:modelValue":s[18]||(s[18]=t=>o.property.floor=t)},null,544),[[d,o.property.floor]])])]),e("div",mo,[e("div",ho,[yo,n(e("input",{type:"text",class:"form-control",id:"court",placeholder:"Digite a Quadra do Apartamento",name:"court","onUpdate:modelValue":s[19]||(s[19]=t=>o.property.court=t)},null,512),[[d,o.property.court]])])]),e("div",_o,[e("div",vo,[fo,n(e("input",{type:"text",class:"form-control",id:"tower",placeholder:"Digite a Torre do Apartamento",name:"tower","onUpdate:modelValue":s[20]||(s[20]=t=>o.property.tower=t)},null,512),[[d,o.property.tower]])])]),e("div",go,[e("div",bo,[Vo,n(e("input",{type:"text",class:"form-control",id:"lot",placeholder:"Digite o Lote do Apartamento",name:"lot","onUpdate:modelValue":s[21]||(s[21]=t=>o.property.lot=t)},null,512),[[d,o.property.lot]])])])])):c("",!0),Co,ko,e("div",wo,[e("div",Uo,[e("div",So,[Do,n(e("input",{type:"text",class:"form-control",id:"inputArea",placeholder:"Área m²",onKeypress:s[22]||(s[22]=t=>o.isNumber(t)),maxlength:"5",name:"area","onUpdate:modelValue":s[23]||(s[23]=t=>o.property.area=t)},null,544),[[d,o.property.area]])])]),e("div",Po,[e("div",Ao,[Bo,n(e("input",{type:"text",class:"form-control",id:"inputBedrooms",maxlength:"2",onKeypress:s[24]||(s[24]=t=>o.isNumber(t)),placeholder:"Dormitórios",name:"bedrooms","onUpdate:modelValue":s[25]||(s[25]=t=>o.property.bedrooms=t)},null,544),[[d,o.property.bedrooms]])])]),e("div",No,[e("div",Io,[To,n(e("input",{type:"text",class:"form-control",id:"inputSuites",placeholder:"Suítes",onKeypress:s[26]||(s[26]=t=>o.isNumber(t)),"onUpdate:modelValue":s[27]||(s[27]=t=>o.property.suites=t),maxlength:"2",name:"suites"},null,544),[[d,o.property.suites]])])]),e("div",Eo,[e("div",Fo,[Lo,n(e("input",{type:"text",class:"form-control",id:"inputBathrooms",onKeypress:s[28]||(s[28]=t=>o.isNumber(t)),"onUpdate:modelValue":s[29]||(s[29]=t=>o.property.bathrooms=t),placeholder:"Banheiros",maxlength:"2",name:"bathrooms"},null,544),[[d,o.property.bathrooms]])])]),e("div",Ro,[e("div",qo,[Ko,n(e("input",{type:"text",class:"form-control",id:"inputParkingSpace",placeholder:"Vagas",onKeypress:s[30]||(s[30]=t=>o.isNumber(t)),"onUpdate:modelValue":s[31]||(s[31]=t=>o.property.parking_space=t),maxlength:"2",name:"parking_space"},null,544),[[d,o.property.parking_space]])])])]),Mo,e("div",zo,[o.property.purpose==1||o.property.purpose==3?(r(),i("div",Ho,[e("div",jo,[Go,e("div",Qo,[Oo,v(y,k({class:"form-control",modelValue:o.property.sale_value,"onUpdate:modelValue":s[32]||(s[32]=t=>o.property.sale_value=t)},o.config,{id:"inputSaleValue",placeholder:"Venda",name:"sale_value",onBlur:s[33]||(s[33]=t=>a.treatValues())}),null,16,["modelValue"])])])])):c("",!0),o.property.purpose==2||o.property.purpose==3||o.property.purpose==4?(r(),i("div",Jo,[e("div",Wo,[Xo,e("div",Yo,[Zo,v(y,k({class:"form-control",modelValue:o.property.rental_value,"onUpdate:modelValue":s[34]||(s[34]=t=>o.property.rental_value=t)},o.config,{id:"inputRentalValue",placeholder:"Locacao",name:"rental_value",onBlur:s[35]||(s[35]=t=>a.treatValues())}),null,16,["modelValue"])])])])):c("",!0),e("div",$o,[e("div",xo,[et,e("div",ot,[tt,v(y,k({class:"form-control",modelValue:o.property.iptu_value,"onUpdate:modelValue":s[36]||(s[36]=t=>o.property.iptu_value=t)},o.config,{id:"inputIptuValue",placeholder:"Iptu",name:"iptu_value",onBlur:s[37]||(s[37]=t=>a.treatValues())}),null,16,["modelValue"])])])]),a.validateCondo(o.property.type)?(r(),i("div",st,[e("div",rt,[it,e("div",lt,[at,v(y,k({class:"form-control",modelValue:o.property.condo_value,"onUpdate:modelValue":s[38]||(s[38]=t=>o.property.condo_value=t)},o.config,{id:"inputCondoValue",placeholder:"Valor do Condomínio",name:"condo_value",onBlur:s[39]||(s[39]=t=>a.treatValues())}),null,16,["modelValue"])])])])):c("",!0)]),nt,e("div",dt,[e("div",pt,[e("div",ut,[ct,e("div",mt,[ht,v(y,k({class:"form-control",modelValue:o.property.administrative_tax_percentual,"onUpdate:modelValue":s[40]||(s[40]=t=>o.property.administrative_tax_percentual=t)},o.config,{id:"inputAdministrativeTaxPercentual",max:"100",name:"administrative_tax_percentual",onBlur:s[41]||(s[41]=t=>a.treatValues())}),null,16,["modelValue"])])])]),e("div",yt,[e("div",_t,[vt,e("div",ft,[gt,v(y,k({class:"form-control",modelValue:o.property.administrative_tax_value,"onUpdate:modelValue":s[42]||(s[42]=t=>o.property.administrative_tax_value=t)},o.config,{id:"inputAdministrativeTaxValue",name:"administrative_tax_value",readonly:""}),null,16,["modelValue"])])])])]),bt,e("div",Vt,[e("div",Ct,[e("div",kt,[wt,e("div",Ut,[n(e("input",{type:"text",class:"form-control numero",id:"inputChronicProblem",placeholder:"Descreva os problemas crônicos do imóvel","onUpdate:modelValue":s[43]||(s[43]=t=>o.property.chronic_problem=t),maxlength:"255",name:"chronic_problem"},null,512),[[d,o.property.chronic_problem]])])])])]),St,Dt,o.property.id_transaction?c("",!0):(r(),i("div",Pt,[e("input",{type:"file",onChange:s[44]||(s[44]=(...t)=>a.handleFileUpload&&a.handleFileUpload(...t)),multiple:""},null,32),e("div",At,[(r(!0),i(m,null,h(o.images,(t,l)=>(r(),i("div",{key:l,class:"col-sm-2"},[e("img",{src:t,alt:"Imagem",style:{"max-width":"100px","max-height":"100px"}},null,8,Bt)]))),128))])])),o.property.id_transaction?c("",!0):(r(),i("div",Nt,Tt))]),e("div",Et,[o.property.id_transaction?c("",!0):(r(),i("div",Ft,[o.property.id?(r(),i("button",{key:0,type:"submit",class:"btn btn-primary",onClick:s[45]||(s[45]=t=>a.updateProperty())},"Atualizar")):(r(),i("button",{key:1,type:"submit",class:"btn btn-primary",onClick:s[46]||(s[46]=t=>a.saveProperty())},"Salvar"))])),e("button",{class:"btn btn-danger",onClick:s[47]||(s[47]=t=>a.back())},"Voltar")])])]),o.property.pictures&&o.property.pictures.length>0?(r(),i("div",Lt,[e("div",Rt,[qt,e("div",Kt,[e("div",Mt,[e("div",zt,[(r(!0),i(m,null,h(o.property.pictures,t=>(r(),i("div",{key:t.id,class:"col-4 col-lg-2",style:{"margin-top":"1em"}},[e("img",{src:"/"+t.folder+"/"+t.description,width:"100",height:"100",style:{"margin-bottom":"1em"}},null,8,Ht),jt,o.property.id_transaction?c("",!0):(r(),i("div",Gt,[e("div",Qt,[Ot,n(e("input",{type:"radio",id:t.id,value:t.id,"onUpdate:modelValue":s[48]||(s[48]=l=>o.main=l),style:{"margin-left":"0.1em"},checked:t.main,onClick:l=>a.treatExcludes(t.id)},null,8,Jt),[[q,o.main]]),K(),Wt]),o.main!=t.id?(r(),i("div",Xt,[Yt,n(e("input",{type:"checkbox",id:t.id,value:t.id,"onUpdate:modelValue":s[49]||(s[49]=l=>o.exclude=l),style:{"margin-left":"1em"}},null,8,Zt),[[M,o.exclude]])])):c("",!0)]))]))),128))])])])])])):c("",!0),o.property.renter?(r(),i("div",$t,[e("div",xt,[e("h3",es,"Imóvel "+u(o.status_properties[o.property.status])+" para "+u(o.property.renter.people.name),1)]),e("div",os,[e("div",ts,[e("table",ss,[rs,e("tbody",null,[e("tr",null,[e("td",null,u(o.property.renter.id),1),e("td",null,u(o.property.renter.people.name+" "+o.property.renter.people.surname),1),e("td",null,u(o.phoneMask(o.property.renter.people.cellphone)),1),e("td",null,u(o.property.renter.people.email),1),e("td",null,[v(_,{to:"/renter/"+o.property.id_renter+"/edit",class:"small-box-footer"},{default:D(()=>[is]),_:1},8,["to"])]),e("td",ls,[v(_,{to:"/transaction/"+o.property.id_transaction+"/edit",class:"small-box-footer"},{default:D(()=>[as]),_:1},8,["to"])])])])])])])])):c("",!0)])}const hs=z(H,[["render",ns]]);export{hs as default};
