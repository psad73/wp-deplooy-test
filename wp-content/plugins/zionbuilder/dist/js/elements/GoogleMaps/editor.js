!function(){var e={};e.g=function(){if("object"==typeof globalThis)return globalThis;try{return this||new Function("return this")()}catch(e){if("object"==typeof window)return window}}(),function(){var t;e.g.importScripts&&(t=e.g.location+"");var o=e.g.document;if(!t&&o&&(o.currentScript&&(t=o.currentScript.src),!t)){var r=o.getElementsByTagName("script");r.length&&(t=r[r.length-1].src)}if(!t)throw new Error("Automatic publicPath is not supported in this browser");t=t.replace(/#.*$/,"").replace(/\?.*$/,"").replace(/\/[^\/]+$/,"/"),e.p=t+"../../../"}(),e.p=window.zionBuilderPaths[{}.appName],function(){"use strict";var e=zb.editor,t=zb.vue,o={name:"google_maps",props:["options","element","api"],computed:{location(){return encodeURIComponent(this.options.location||"Chicago")},zoom(){return this.options.zoom||15},mapType(){return"terrain"===this.options.map_type?"k":""}},render:function(e,o,r,n,i,p){return(0,t.openBlock)(),(0,t.createBlock)("div",null,[(0,t.renderSlot)(e.$slots,"start"),(0,t.createVNode)("iframe",{src:`https://www.google.com/maps?api=1&q=${p.location}&z=${p.zoom}&output=embed&t=${p.mapType}`,frameborder:"0",style:{border:"0","margin-bottom":"0"},allowfullscreen:""},null,8,["src"]),(0,t.renderSlot)(e.$slots,"end")])}};(0,e.registerElementComponent)({elementType:"google_maps",component:o})}()}();