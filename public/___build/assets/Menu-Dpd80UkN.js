import{r as c,c as n,a as t,b as o,w as s,e as r,o as i,d as a}from"./app-e3q45BkK.js";import{_ as d}from"./_plugin-vue_export-helper-DlAUqK2U.js";const u={data:function(){return{currentUrl:window.location.pathname.split("/").pop(),pathSegment:window.location.pathname.split("/").slice(1).join("/")}},computed:{},methods:{},beforeMount(){}},_={id:"main"},m={id:"header",class:"header fixed-top","data-scrollto-offset":"0"},f={class:"container-fluid d-flex align-items-center justify-content-between"},p=t("img",{src:"/images_setting/1/logo_menu_1_20230211.png",class:"img-fluid",alt:""},null,-1),h={id:"navbar",class:"navbar",style:{"margin-left":"-3em"}},b={class:"d-flex justify-content-center"},g={class:"col-md-1",style:{"margin-right":"1em","margin-top":"1em"}},x={key:0,type:"button",class:"btn button-search","data-bs-toggle":"collapse","data-bs-target":"#faq-content-1","aria-expanded":"false"},v=t("i",{class:"bi bi-search"},null,-1),w=[v];function y(l,k,C,N,V,$){const e=c("router-link");return i(),n("main",_,[t("header",m,[t("div",f,[o(e,{to:"/",class:"logo d-flex align-items-center scrollto me-auto me-lg-0"},{default:s(()=>[p]),_:1}),t("nav",h,[t("ul",b,[t("li",null,[o(e,{to:"/",class:"small-box-footer"},{default:s(()=>[a(" Início ")]),_:1})]),t("li",null,[o(e,{to:"/all_properties",class:"small-box-footer"},{default:s(()=>[a(" Imóveis ")]),_:1})]),t("li",null,[o(e,{to:"/about",class:"small-box-footer"},{default:s(()=>[a(" Sobre nós ")]),_:1})]),t("li",null,[o(e,{to:{path:"/about",hash:"#onfocus"},class:"small-box-footer"},{default:s(()=>[a(" Financiamentos ")]),_:1})]),t("li",null,[o(e,{to:{path:"/",hash:"#contato"},class:"small-box-footer"},{default:s(()=>[a(" Contato ")]),_:1})])])]),t("div",g,[!l.pathSegment.includes("property_details")&&l.currentUrl!="about"?(i(),n("button",x,w)):r("",!0)])])])])}const S=d(u,[["render",y]]);export{S as default};
