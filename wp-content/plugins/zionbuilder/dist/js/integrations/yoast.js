!function(){var t={};t.g=function(){if("object"==typeof globalThis)return globalThis;try{return this||new Function("return this")()}catch(t){if("object"==typeof window)return window}}(),function(){var i;t.g.importScripts&&(i=t.g.location+"");var n=t.g.document;if(!i&&n&&(n.currentScript&&(i=n.currentScript.src),!i)){var o=n.getElementsByTagName("script");o.length&&(i=o[o.length-1].src)}if(!i)throw new Error("Automatic publicPath is not supported in this browser");i=i.replace(/#.*$/,"").replace(/\?.*$/,"").replace(/\/[^\/]+$/,"/"),t.p=i+"../../"}(),t.p=window.zionBuilderPaths[{}.appName],function(){"use strict";const t=window.YoastSEO;class i{constructor(){void 0!==t&&void 0!==t.analysis&&void 0!==t.analysis.worker&&(t.app.registerPlugin("ZionBuilderIntegration",{status:"ready"}),this.registerModifications())}registerModifications(){const i=this.addContent.bind(this);t.app.registerModification("content",i,"ZionBuilderIntegration",10)}addContent(t){const{is_editor_enabled:i=!1}=window.ZnPbEditPostData?window.ZnPbEditPostData.data:{};return i&&window.zb_yoast_data&&window.zb_yoast_data.page_content&&(t+=window.zb_yoast_data.page_content),t}}void 0!==t&&void 0!==t.app?new i:window.jQuery(window).on("YoastSEO:ready",(function(){new i}))}()}();