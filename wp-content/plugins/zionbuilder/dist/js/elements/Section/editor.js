!function(){var t={};t.g=function(){if("object"==typeof globalThis)return globalThis;try{return this||new Function("return this")()}catch(t){if("object"==typeof window)return window}}(),function(){var e;t.g.importScripts&&(e=t.g.location+"");var o=t.g.document;if(!e&&o&&(o.currentScript&&(e=o.currentScript.src),!e)){var n=o.getElementsByTagName("script");n.length&&(e=n[n.length-1].src)}if(!e)throw new Error("Automatic publicPath is not supported in this browser");e=e.replace(/#.*$/,"").replace(/\?.*$/,"").replace(/\/[^\/]+$/,"/"),t.p=e+"../../../"}(),t.p=window.zionBuilderPaths[{}.appName],function(){"use strict";var t=zb.editor,e=zb.vue,o={name:"zion_section",props:["options","api","element"],computed:{topMask(){return this.shapes.top},bottomMask(){return this.shapes.bottom},htmlTag(){return/^[a-z0-9]+$/i.test(this.options.tag)?this.options.tag:"section"},shapes(){return this.options.shapes||{}}},render:function(t,o,n,s,r,a){const i=(0,e.resolveComponent)("SvgMask"),p=(0,e.resolveComponent)("SortableContent");return(0,e.openBlock)(),(0,e.createBlock)((0,e.resolveDynamicComponent)(a.htmlTag),{class:"zb-section"},{default:(0,e.withCtx)((()=>[(0,e.renderSlot)(t.$slots,"start"),void 0!==a.topMask&&a.topMask.shape?((0,e.openBlock)(),(0,e.createBlock)(i,{key:0,shapePath:a.topMask.shape,color:a.topMask.color,flip:a.topMask.flip,position:"top"},null,8,["shapePath","color","flip"])):(0,e.createCommentVNode)("v-if",!0),void 0!==a.bottomMask&&a.bottomMask.shape?((0,e.openBlock)(),(0,e.createBlock)(i,{key:1,shapePath:a.bottomMask.shape,color:a.bottomMask.color,flip:a.bottomMask.flip,position:"bottom"},null,8,["shapePath","color","flip"])):(0,e.createCommentVNode)("v-if",!0),(0,e.createVNode)(p,(0,e.mergeProps)(n.api.getAttributesForTag("inner_content_styles"),{element:n.element,class:["zb-section__innerWrapper",n.api.getStyleClasses("inner_content_styles")]}),null,16,["element","class"]),(0,e.renderSlot)(t.$slots,"end")])),_:3})}};(0,t.registerElementComponent)({elementType:"zion_section",component:o})}()}();