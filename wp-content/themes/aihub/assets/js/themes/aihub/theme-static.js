"use strict";(()=>{(()=>{"use strict";liquid.behaviors.push({el:document.querySelector("#lqd-menu-default"),behaviors:[{behaviorClass:LiquidGetElementComputedStylesBehavior,options:{getRect:!0,includeSelf:!0}},{behaviorClass:LiquidToggleBehavior,options:{changePropPrefix:"lqdMenuToggle",ui:{togglableTriggers:".lqd-trigger",togglableElements:".lqd-menu-wrap"},triggerElements:["click @togglableTriggers"]}},{behaviorClass:LiquidEffectsSlideToggleBehavior,options:{changePropPrefix:"lqdMenuToggle",keepHiddenClassname:!1}}]}),liquid.behaviors.push({el:document.querySelector("#lqd-search-default"),behaviors:[{behaviorClass:LiquidToggleBehavior,options:{changePropPrefix:"lqdSearchToggle",toggleAllTriggers:!0,ignoreEnterOnFocus:!0,toggleOffOnEscPress:!0,toggleOffOnOutsideClick:!0,triggerElements:["click @togglableTriggers"]}},{behaviorClass:LiquidEffectsSlideToggleBehavior,options:{changePropPrefix:"lqdSearchToggle"}}]}),_.extend(window.liquid,Backbone.Events),fastdom=fastdom.extend(fastdomPromised);let e=new LiquidApp({layoutRegions:{liquidPageHeader:{el:"lqd-page-header-wrap",contentWrap:"lqd-page-header"},liquidPageContent:{el:"lqd-page-content-wrap",contentWrap:"lqd-page-content"},liquidPageFooter:{el:"lqd-page-footer-wrap",contentWrap:"lqd-page-footer"}}});window.liquid.app=e,e.start()})();})();
