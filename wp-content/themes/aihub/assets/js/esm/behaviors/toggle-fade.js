"use strict";import n from"./base.js";class i extends n{static name="liquidEffectsFadeToggle";get viewEvents(){const e=this.getChangeProp(),t=this.getChangeProp("closedItems");return{[`change:${e}`]:"onOpenedElements",[`change:${t}`]:"onClosedElements"}}options(){return{duration:.7,changePropPrefix:null}}onOpenedElements({targets:e}){e?.length&&this.fade(e,"in")}onClosedElements({targets:e}){e?.length&&this.fade(e,"out")}fade(e,t){e.forEach(o=>{o.animate([{opacity:t==="in"?0:1},{opacity:t==="in"?1:0}],{duration:this.getOption("duration")*1e3})})}}window.liquid?.app?window.liquid?.app?.model?.set("loadedBehaviors",[...window.liquid.app.model.get("loadedBehaviors"),i]):window.liquid?.loadedBehaviors?.push(i);export default i;