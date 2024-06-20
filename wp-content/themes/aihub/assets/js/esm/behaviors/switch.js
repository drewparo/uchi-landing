"use strict";import{getElementFromString as l}from"../utils/getElementFromString.js";import{STATE_CLASSNAMES as s}from"../lib/consts.js";import h from"./base.js";class n extends h{static name="liquidSwitch";static initialModelProps={isOn:!1};static domEvents={"click @switcher:not([type=checkbox])":"onSwitcherChange","change @switcher[type=checkbox]":"onSwitcherChange"};static modelEvents={"change:isOn":"onModelChange"};options(){return{useLocalStorage:!1,attrs:[]}}get ui(){return{switcher:"input[type=checkbox]"}}initialize(){this.handleInitialValues()}handleInitialValues(){if(!this.getOption("useLocalStorage"))return;this.getOption("attrs").forEach(({attr:i,val:o,el:r})=>{l(r,this.view.el).getAttribute(i)===o.on&&this.getUI("switcher").forEach(c=>{c.classList.add(s.ACTIVE),c.checked=!0})})}onModelChange(t,e){this.onSwitchChange(e?"on":"off")}onSwitcherChange(t){const e=t.currentTarget;this.model.set({isOn:e?.checked})}onSwitchChange(t){const e=this.getOption("useLocalStorage");this.getOption("attrs").forEach(o=>{this.handleHtmlAttrs(t,o),e&&this.handleLocalStorate(t,o)})}handleHtmlAttrs(t,{attr:e,el:i,val:o}){l(i).setAttribute(e,o[t]),t==="on"?this.getUI("switcher").forEach(a=>{a.classList.add(s.ACTIVE),a.checked=!0}):this.getUI("switcher").forEach(a=>{a.classList.remove(s.ACTIVE),a.checked=!1})}handleLocalStorate(t,{key:e,val:i}){localStorage.setItem(e,i[t])}}window.liquid?.app?window.liquid?.app?.model?.set("loadedBehaviors",[...window.liquid.app.model.get("loadedBehaviors"),n]):window.liquid?.loadedBehaviors?.push(n);export default n;
