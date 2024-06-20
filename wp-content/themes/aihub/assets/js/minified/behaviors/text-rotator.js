class LiquidTextRotatorBehavior extends LiquidBehavior{static name="liquidTextRotator";static viewModelEvents={"change:computedStyles":"initialize"};static modelEvents={"change:activeItem":"onActiveItemChange"};options(){return{initialIndex:0,stayDuration:3,leaveDuration:1,enterDuration:1}}get ui(){return{itemsWrapper:".lqd-text-rotator-items",items:".lqd-text-rotator-item"}}initialize(){if(this.isDestroyed)return;const e=this.getOption("initialIndex");this.model.set({activeItem:e}),this.addDelayCall(),this.view.el.setAttribute("data-lqd-text-rotator-initiated","true")}addDelayCall(){if(this.isDestroyed)return;const e=this.getOption("stayDuration"),i=this.getOption("enterDuration"),s=this.getUI("items").length;this.enterCall?.kill(),this.stayCall=gsap.delayedCall(e,()=>{if(this.isDestroyed)return;const t=this.model.get("activeItem")||0,a=t>=s-1?0:t+1;this.model.set({activeItem:a}),this.stayCall?.kill(),this.enterCall=gsap.delayedCall(i,this.addDelayCall.bind(this))})}onActiveItemChange(e,i){const s=this.getUI("itemsWrapper")[0],t=this.getUI("items"),a=this.view.model.get("rect")?.elements[i]?.rect?.width,l=e.previous("activeItem");s.style.setProperty("--lqd-tr-width",`${a}px`),t.forEach(o=>o.classList.remove("lqd-is-active","lqd-was-active")),t[i].classList.add("lqd-is-active"),l!=null&&l>=0&&t[l].classList.add("lqd-was-active")}destroy(){this.stayCall?.kill(),this.enterCall?.kill(),super.destroy()}}window.liquid?.app?window.liquid?.app?.model?.set("loadedBehaviors",[...window.liquid.app.model.get("loadedBehaviors"),LiquidTextRotatorBehavior]):window.liquid?.loadedBehaviors?.push(LiquidTextRotatorBehavior);
