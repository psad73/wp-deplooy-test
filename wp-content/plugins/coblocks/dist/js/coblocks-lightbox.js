!function(e){var t={};function n(o){if(t[o])return t[o].exports;var c=t[o]={i:o,l:!1,exports:{}};return e[o].call(c.exports,c,c.exports,n),c.l=!0,c.exports}n.m=e,n.c=t,n.d=function(e,t,o){n.o(e,t)||Object.defineProperty(e,t,{enumerable:!0,get:o})},n.r=function(e){"undefined"!=typeof Symbol&&Symbol.toStringTag&&Object.defineProperty(e,Symbol.toStringTag,{value:"Module"}),Object.defineProperty(e,"__esModule",{value:!0})},n.t=function(e,t){if(1&t&&(e=n(e)),8&t)return e;if(4&t&&"object"==typeof e&&e&&e.__esModule)return e;var o=Object.create(null);if(n.r(o),Object.defineProperty(o,"default",{enumerable:!0,value:e}),2&t&&"string"!=typeof e)for(var c in e)n.d(o,c,function(t){return e[t]}.bind(null,c));return o},n.n=function(e){var t=e&&e.__esModule?function(){return e.default}:function(){return e};return n.d(t,"a",t),t},n.o=function(e,t){return Object.prototype.hasOwnProperty.call(e,t)},n.p="",n(n.s=549)}({549:function(e,t){!function(){"use strict";const{closeLabel:e,leftLabel:t,rightLabel:n}=coblocksLigthboxData,o=document.getElementsByClassName("has-lightbox");Array.from(o).forEach((function(o,c){o.className+=" lightbox-"+c+" ",function(o){const c=document.createElement("div");c.setAttribute("class","coblocks-lightbox");const r=document.createElement("div");r.setAttribute("class","coblocks-lightbox__background");const i=document.createElement("div");i.setAttribute("class","coblocks-lightbox__heading");const l=document.createElement("button");l.setAttribute("class","coblocks-lightbox__close"),l.setAttribute("aria-label",e);const a=document.createElement("span");a.setAttribute("class","coblocks-lightbox__count");const s=document.createElement("div");s.setAttribute("class","coblocks-lightbox__image");const u=document.createElement("img"),b=document.createElement("figcaption");b.setAttribute("class","coblocks-lightbox__caption");const d=document.createElement("button");d.setAttribute("class","coblocks-lightbox__arrow coblocks-lightbox__arrow--left");const g=document.createElement("button");g.setAttribute("class","coblocks-lightbox__arrow coblocks-lightbox__arrow--right");const m=document.createElement("div");m.setAttribute("class","arrow-right"),m.setAttribute("aria-label",n);const f=document.createElement("div");f.setAttribute("class","arrow-left"),f.setAttribute("aria-label",t);const h=[`.has-lightbox.lightbox-${o} > :not(.carousel-nav) figure img`,`figure.has-lightbox.lightbox-${o} > img`,`.has-lightbox.lightbox-${o} > figure[class^="align"] img`].join(", "),p=[`.has-lightbox.lightbox-${o} > :not(.carousel-nav) figure figcaption`].join(", "),x=document.querySelectorAll(h),y=document.querySelectorAll(p);let k;i.append(a,l),s.append(u,b),d.append(f),g.append(m),c.append(r,i,s,d,g),x.length>0&&(document.getElementsByTagName("BODY")[0].append(c),1===x.length&&(g.remove(),d.remove()));y.length>0&&Array.from(y).forEach((function(e,t){e.addEventListener("click",(function(){E(t)}))}));Array.from(x).forEach((function(e,t){e.closest("figure").addEventListener("click",(function(){E(t)}))})),d.addEventListener("click",(function(){k=0===k?x.length-1:k-1,E(k)})),g.addEventListener("click",(function(){k=k===x.length-1?0:k+1,E(k)})),r.addEventListener("click",(function(){c.style.display="none"})),l.addEventListener("click",(function(){c.style.display="none"}));const v={preloaded:!1,setPreloadImages:()=>{v.preloaded||(v.preloaded=!0,Array.from(x).forEach((function(e,t){v["img-"+t]=new window.Image,v["img-"+t].src=e.attributes.src.value,v["img-"+t]["data-caption"]=x[t]&&x[t].nextElementSibling?function(e){let t=e.nextElementSibling;for(;t;){if(t.matches("figcaption"))return t.innerHTML;t=t.nextElementSibling}return""}(x[t]):""})),document.onkeydown=function(e){if(void 0!==c&&"none"!==c)switch((e=e||window.event).keyCode){case 27:l.click();break;case 37:case 65:d.click();break;case 39:case 68:g.click()}})}};function E(e){v.setPreloadImages(),k=e,c.style.display="flex",r.style.backgroundImage=`url(${v["img-"+k].src})`,u.src=v["img-"+k].src,b.innerHTML=v["img-"+k]["data-caption"],a.textContent=`${k+1} / ${x.length}`}}(c)}))}()}});