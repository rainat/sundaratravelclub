import{s as D,Q as i,bT as b,k as n,P as h,m as x,a6 as k,e as f,A as g,w as C,u as r,C as z,H as B,i as v,O as R,o as _,ab as V}from"./stepForm.e05178e0.js";import{e as M}from"./catalogForm.56b17c33.js";import P from"./EventsListForm.58068e01.js";import"./customizeForm.1e799d7b.js";const S={name:"EventsListFormWrapper"},F=Object.assign(S,{setup(T){let e=v("shortcodeData"),p=D({sbsNew:i(b),cbf:i(M),elf:i(P)}),s=n(!1),c=n(!1),m=e.value.trigger_type&&e.value.trigger_type==="class"?[...document.getElementsByClassName(e.value.trigger)]:[document.getElementById(e.value.trigger)];function y(o){c.value=o}let u=n(100);m.forEach(o=>{o.addEventListener("click",t=>{t.preventDefault(),t.stopPropagation(),s.value=!0,setTimeout(()=>{window.dispatchEvent(new Event("resize"))},u.value)})}),h(c,o=>{o&&m.forEach(t=>{t.dispatchEvent(new Event("click"))})});function E(){s.value=!1}x(()=>{k("renderPopup",{resizeAfter:u})});const l=v("settings");let a=f(()=>l.customizedData&&"elf"in l.customizedData?l.customizedData[e.value.triggered_form].colors:R[e.value.triggered_form].colors),w=f(()=>({"--am-c-primary":a.value.colorPrimary,"--am-c-success":a.value.colorSuccess,"--am-c-error":a.value.colorError,"--am-c-warning":a.value.colorWarning,"--am-c-main-bgr":a.value.colorMainBgr,"--am-c-main-heading-text":a.value.colorMainHeadingText,"--am-c-main-text":a.value.colorMainText}));return(o,t)=>(_(),g(B,{modelValue:r(s),"onUpdate:modelValue":t[0]||(t[0]=d=>z(s)?s.value=d:s=d),"append-to-body":!0,"modal-class":`amelia-v2-booking am-forms-dialog am-${r(e).triggered_form}`,"close-on-click-modal":!1,"close-on-press-escape":!1,"custom-styles":r(w),"used-for-shortcode":!0,onClosed:E},{default:C(()=>[(_(),g(V(r(p)[r(e).triggered_form]),{ref:"aaa",onIsRestored:y},null,512))]),_:1},8,["modelValue","modal-class","custom-styles"]))}});export{F as default};