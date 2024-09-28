<!DOCTYPE html>
<html class="no-js" lang="en" prefix="og: http://ogp.me/ns#">

<!-- Mirrored from www.wealthfront.com/blog by HTTrack Website Copier/3.x [XR&CO'2014], Sun, 08 Sep 2024 20:22:53 GMT -->
<!-- Added by HTTrack --><meta http-equiv="content-type" content="text/html;charset=UTF-8" /><!-- /Added by HTTrack -->
<head>
  <meta charset="UTF-8" /><script type="text/javascript">(window.NREUM||(NREUM={})).init={ajax:{deny_list:["bam.nr-data.net"]}};(window.NREUM||(NREUM={})).loader_config={licenseKey:"f361777eb6",applicationID:"953697885"};;/*! For license information please see nr-loader-rum-1.265.1.min.js.LICENSE.txt */
(()=>{var e,t,r={8122:(e,t,r)=>{"use strict";r.d(t,{a:()=>i});var n=r(944);function i(e,t){try{if(!e||"object"!=typeof e)return(0,n.R)(3);if(!t||"object"!=typeof t)return(0,n.R)(4);const r=Object.create(Object.getPrototypeOf(t),Object.getOwnPropertyDescriptors(t)),o=0===Object.keys(r).length?e:r;for(let a in o)if(void 0!==e[a])try{if(null===e[a]){r[a]=null;continue}Array.isArray(e[a])&&Array.isArray(t[a])?r[a]=Array.from(new Set([...e[a],...t[a]])):"object"==typeof e[a]&&"object"==typeof t[a]?r[a]=i(e[a],t[a]):r[a]=e[a]}catch(e){(0,n.R)(1,e)}return r}catch(e){(0,n.R)(2,e)}}},2555:(e,t,r)=>{"use strict";r.d(t,{Vp:()=>c,fn:()=>s,x1:()=>u});var n=r(384),i=r(8122);const o={beacon:n.NT.beacon,errorBeacon:n.NT.errorBeacon,licenseKey:void 0,applicationID:void 0,sa:void 0,queueTime:void 0,applicationTime:void 0,ttGuid:void 0,user:void 0,account:void 0,product:void 0,extra:void 0,jsAttributes:{},userAttributes:void 0,atts:void 0,transactionName:void 0,tNamePlain:void 0},a={};function s(e){try{const t=c(e);return!!t.licenseKey&&!!t.errorBeacon&&!!t.applicationID}catch(e){return!1}}function c(e){if(!e)throw new Error("All info objects require an agent identifier!");if(!a[e])throw new Error("Info for ".concat(e," was never set"));return a[e]}function u(e,t){if(!e)throw new Error("All info objects require an agent identifier!");a[e]=(0,i.a)(t,o);const r=(0,n.nY)(e);r&&(r.info=a[e])}},9417:(e,t,r)=>{"use strict";r.d(t,{D0:()=>g,gD:()=>h,xN:()=>p});var n=r(993);const i=e=>{if(!e||"string"!=typeof e)return!1;try{document.createDocumentFragment().querySelector(e)}catch{return!1}return!0};var o=r(2614),a=r(944),s=r(384),c=r(8122);const u="[data-nr-mask]",d=()=>{const e={mask_selector:"*",block_selector:"[data-nr-block]",mask_input_options:{color:!1,date:!1,"datetime-local":!1,email:!1,month:!1,number:!1,range:!1,search:!1,tel:!1,text:!1,time:!1,url:!1,week:!1,textarea:!1,select:!1,password:!0}};return{ajax:{deny_list:void 0,block_internal:!0,enabled:!0,harvestTimeSeconds:10,autoStart:!0},distributed_tracing:{enabled:void 0,exclude_newrelic_header:void 0,cors_use_newrelic_header:void 0,cors_use_tracecontext_headers:void 0,allowed_origins:void 0},feature_flags:[],generic_events:{enabled:!0,harvestTimeSeconds:30,autoStart:!0},harvest:{tooManyRequestsDelay:60},jserrors:{enabled:!0,harvestTimeSeconds:10,autoStart:!0},logging:{enabled:!0,harvestTimeSeconds:10,autoStart:!0,level:n.p_.INFO},metrics:{enabled:!0,autoStart:!0},obfuscate:void 0,page_action:{enabled:!0},page_view_event:{enabled:!0,autoStart:!0},page_view_timing:{enabled:!0,harvestTimeSeconds:30,long_task:!1,autoStart:!0},privacy:{cookies_enabled:!0},proxy:{assets:void 0,beacon:void 0},session:{expiresMs:o.wk,inactiveMs:o.BB},session_replay:{autoStart:!0,enabled:!1,harvestTimeSeconds:60,preload:!1,sampling_rate:10,error_sampling_rate:100,collect_fonts:!1,inline_images:!1,inline_stylesheet:!0,fix_stylesheets:!0,mask_all_inputs:!0,get mask_text_selector(){return e.mask_selector},set mask_text_selector(t){i(t)?e.mask_selector="".concat(t,",").concat(u):""===t||null===t?e.mask_selector=u:(0,a.R)(5,t)},get block_class(){return"nr-block"},get ignore_class(){return"nr-ignore"},get mask_text_class(){return"nr-mask"},get block_selector(){return e.block_selector},set block_selector(t){i(t)?e.block_selector+=",".concat(t):""!==t&&(0,a.R)(6,t)},get mask_input_options(){return e.mask_input_options},set mask_input_options(t){t&&"object"==typeof t?e.mask_input_options={...t,password:!0}:(0,a.R)(7,t)}},session_trace:{enabled:!0,harvestTimeSeconds:10,autoStart:!0},soft_navigations:{enabled:!0,harvestTimeSeconds:10,autoStart:!0},spa:{enabled:!0,harvestTimeSeconds:10,autoStart:!0},ssl:void 0}},l={},f="All configuration objects require an agent identifier!";function g(e){if(!e)throw new Error(f);if(!l[e])throw new Error("Configuration for ".concat(e," was never set"));return l[e]}function p(e,t){if(!e)throw new Error(f);l[e]=(0,c.a)(t,d());const r=(0,s.nY)(e);r&&(r.init=l[e])}function h(e,t){if(!e)throw new Error(f);var r=g(e);if(r){for(var n=t.split("."),i=0;i<n.length-1;i++)if("object"!=typeof(r=r[n[i]]))return;r=r[n[n.length-1]]}return r}},3371:(e,t,r)=>{"use strict";r.d(t,{V:()=>f,f:()=>l});var n=r(8122),i=r(384),o=r(6154),a=r(9324);let s=0;const c={buildEnv:a.F3,distMethod:a.Xs,version:a.xv,originTime:o.WN},u={customTransaction:void 0,disabled:!1,isolatedBacklog:!1,loaderType:void 0,maxBytes:3e4,onerror:void 0,origin:""+o.gm.location,ptid:void 0,releaseIds:{},appMetadata:{},session:void 0,denyList:void 0,timeKeeper:void 0,obfuscator:void 0},d={};function l(e){if(!e)throw new Error("All runtime objects require an agent identifier!");if(!d[e])throw new Error("Runtime for ".concat(e," was never set"));return d[e]}function f(e,t){if(!e)throw new Error("All runtime objects require an agent identifier!");d[e]={...(0,n.a)(t,u),...c},Object.hasOwnProperty.call(d[e],"harvestCount")||Object.defineProperty(d[e],"harvestCount",{get:()=>++s});const r=(0,i.nY)(e);r&&(r.runtime=d[e])}},9324:(e,t,r)=>{"use strict";r.d(t,{F3:()=>i,Xs:()=>o,xv:()=>n});const n="1.265.1",i="PROD",o="CDN"},6154:(e,t,r)=>{"use strict";r.d(t,{OF:()=>c,RI:()=>i,Vr:()=>d,WN:()=>l,bv:()=>o,gm:()=>a,mw:()=>s,sb:()=>u});var n=r(1863);const i="undefined"!=typeof window&&!!window.document,o="undefined"!=typeof WorkerGlobalScope&&("undefined"!=typeof self&&self instanceof WorkerGlobalScope&&self.navigator instanceof WorkerNavigator||"undefined"!=typeof globalThis&&globalThis instanceof WorkerGlobalScope&&globalThis.navigator instanceof WorkerNavigator),a=i?window:"undefined"!=typeof WorkerGlobalScope&&("undefined"!=typeof self&&self instanceof WorkerGlobalScope&&self||"undefined"!=typeof globalThis&&globalThis instanceof WorkerGlobalScope&&globalThis),s=Boolean("hidden"===a?.document?.visibilityState),c=/iPad|iPhone|iPod/.test(a.navigator?.userAgent),u=c&&"undefined"==typeof SharedWorker,d=((()=>{const e=a.navigator?.userAgent?.match(/Firefox[/\s](\d+\.\d+)/);Array.isArray(e)&&e.length>=2&&e[1]})(),!!a.navigator?.sendBeacon),l=Date.now()-(0,n.t)()},4777:(e,t,r)=>{"use strict";r.d(t,{J:()=>o});var n=r(944);const i={agentIdentifier:"",ee:void 0};class o{constructor(e){try{if("object"!=typeof e)return(0,n.R)(8);this.sharedContext={},Object.assign(this.sharedContext,i),Object.entries(e).forEach((([e,t])=>{Object.keys(i).includes(e)&&(this.sharedContext[e]=t)}))}catch(e){(0,n.R)(9,e)}}}},1687:(e,t,r)=>{"use strict";r.d(t,{Ak:()=>c,Ze:()=>l,x3:()=>u});var n=r(7836),i=r(3606),o=r(860),a=r(2646);const s={};function c(e,t){const r={staged:!1,priority:o.P[t]||0};d(e),s[e].get(t)||s[e].set(t,r)}function u(e,t){e&&s[e]&&(s[e].get(t)&&s[e].delete(t),g(e,t,!1),s[e].size&&f(e))}function d(e){if(!e)throw new Error("agentIdentifier required");s[e]||(s[e]=new Map)}function l(e="",t="feature",r=!1){if(d(e),!e||!s[e].get(t)||r)return g(e,t);s[e].get(t).staged=!0,f(e)}function f(e){const t=Array.from(s[e]);t.every((([e,t])=>t.staged))&&(t.sort(((e,t)=>e[1].priority-t[1].priority)),t.forEach((([t])=>{s[e].delete(t),g(e,t)})))}function g(e,t,r=!0){const o=e?n.ee.get(e):n.ee,s=i.i.handlers;if(!o.aborted&&o.backlog&&s){if(r){const e=o.backlog[t],r=s[t];if(r){for(let t=0;e&&t<e.length;++t)p(e[t],r);Object.entries(r).forEach((([e,t])=>{Object.values(t||{}).forEach((t=>{t[0]?.on&&t[0]?.context()instanceof a.y&&t[0].on(e,t[1])}))}))}}o.isolatedBacklog||delete s[t],o.backlog[t]=null,o.emit("drain-"+t,[])}}function p(e,t){var r=e[1];Object.values(t[r]||{}).forEach((t=>{var r=e[0];if(t[0]===r){var n=t[1],i=e[3],o=e[2];n.apply(i,o)}}))}},7836:(e,t,r)=>{"use strict";r.d(t,{P:()=>c,ee:()=>u});var n=r(384),i=r(8990),o=r(3371),a=r(2646),s=r(5607);const c="nr@context:".concat(s.W),u=function e(t,r){var n={},s={},d={},l=!1;try{l=16===r.length&&(0,o.f)(r).isolatedBacklog}catch(e){}var f={on:p,addEventListener:p,removeEventListener:function(e,t){var r=n[e];if(!r)return;for(var i=0;i<r.length;i++)r[i]===t&&r.splice(i,1)},emit:function(e,r,n,i,o){!1!==o&&(o=!0);if(u.aborted&&!i)return;t&&o&&t.emit(e,r,n);for(var a=g(n),c=h(e),d=c.length,l=0;l<d;l++)c[l].apply(a,r);var p=v()[s[e]];p&&p.push([f,e,r,a]);return a},get:m,listeners:h,context:g,buffer:function(e,t){const r=v();if(t=t||"feature",f.aborted)return;Object.entries(e||{}).forEach((([e,n])=>{s[n]=t,t in r||(r[t]=[])}))},abort:function(){f._aborted=!0,Object.keys(f.backlog).forEach((e=>{delete f.backlog[e]}))},isBuffering:function(e){return!!v()[s[e]]},debugId:r,backlog:l?{}:t&&"object"==typeof t.backlog?t.backlog:{},isolatedBacklog:l};return Object.defineProperty(f,"aborted",{get:()=>{let e=f._aborted||!1;return e||(t&&(e=t.aborted),e)}}),f;function g(e){return e&&e instanceof a.y?e:e?(0,i.I)(e,c,(()=>new a.y(c))):new a.y(c)}function p(e,t){n[e]=h(e).concat(t)}function h(e){return n[e]||[]}function m(t){return d[t]=d[t]||e(f,t)}function v(){return f.backlog}}(void 0,"globalEE"),d=(0,n.Zm)();d.ee||(d.ee=u)},2646:(e,t,r)=>{"use strict";r.d(t,{y:()=>n});class n{constructor(e){this.contextId=e}}},9908:(e,t,r)=>{"use strict";r.d(t,{d:()=>n,p:()=>i});var n=r(7836).ee.get("handle");function i(e,t,r,i,o){o?(o.buffer([e],i),o.emit(e,t,r)):(n.buffer([e],i),n.emit(e,t,r))}},3606:(e,t,r)=>{"use strict";r.d(t,{i:()=>o});var n=r(9908);o.on=a;var i=o.handlers={};function o(e,t,r,o){a(o||n.d,i,e,t,r)}function a(e,t,r,i,o){o||(o="feature"),e||(e=n.d);var a=t[o]=t[o]||{};(a[r]=a[r]||[]).push([e,i])}},3878:(e,t,r)=>{"use strict";r.d(t,{DD:()=>c,jT:()=>a,sp:()=>s});var n=r(6154);let i=!1,o=!1;try{const e={get passive(){return i=!0,!1},get signal(){return o=!0,!1}};n.gm.addEventListener("test",null,e),n.gm.removeEventListener("test",null,e)}catch(e){}function a(e,t){return i||o?{capture:!!e,passive:i,signal:t}:!!e}function s(e,t,r=!1,n){window.addEventListener(e,t,a(r,n))}function c(e,t,r=!1,n){document.addEventListener(e,t,a(r,n))}},5607:(e,t,r)=>{"use strict";r.d(t,{W:()=>n});const n=(0,r(9566).bz)()},9566:(e,t,r)=>{"use strict";r.d(t,{LA:()=>s,bz:()=>a});var n=r(6154);const i="xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx";function o(e,t){return e?15&e[t]:16*Math.random()|0}function a(){const e=n.gm?.crypto||n.gm?.msCrypto;let t,r=0;return e&&e.getRandomValues&&(t=e.getRandomValues(new Uint8Array(30))),i.split("").map((e=>"x"===e?o(t,r++).toString(16):"y"===e?(3&o()|8).toString(16):e)).join("")}function s(e){const t=n.gm?.crypto||n.gm?.msCrypto;let r,i=0;t&&t.getRandomValues&&(r=t.getRandomValues(new Uint8Array(e)));const a=[];for(var s=0;s<e;s++)a.push(o(r,i++).toString(16));return a.join("")}},2614:(e,t,r)=>{"use strict";r.d(t,{BB:()=>a,H3:()=>n,g:()=>u,iL:()=>c,tS:()=>s,uh:()=>i,wk:()=>o});const n="NRBA",i="SESSION",o=144e5,a=18e5,s={STARTED:"session-started",PAUSE:"session-pause",RESET:"session-reset",RESUME:"session-resume",UPDATE:"session-update"},c={SAME_TAB:"same-tab",CROSS_TAB:"cross-tab"},u={OFF:0,FULL:1,ERROR:2}},1863:(e,t,r)=>{"use strict";function n(){return Math.floor(performance.now())}r.d(t,{t:()=>n})},944:(e,t,r)=>{"use strict";function n(e,t){"function"==typeof console.debug&&console.debug("New Relic Warning: https://github.com/newrelic/newrelic-browser-agent/blob/main/docs/warning-codes.md#".concat(e),t)}r.d(t,{R:()=>n})},5284:(e,t,r)=>{"use strict";r.d(t,{t:()=>c,B:()=>s});var n=r(7836),i=r(6154);const o="newrelic";const a=new Set,s={};function c(e,t){const r=n.ee.get(t);s[t]??={},e&&"object"==typeof e&&(a.has(t)||(r.emit("rumresp",[e]),s[t]=e,a.add(t),function(e={}){try{i.gm.dispatchEvent(new CustomEvent(o,{detail:e}))}catch(e){}}({loaded:!0})))}},8990:(e,t,r)=>{"use strict";r.d(t,{I:()=>i});var n=Object.prototype.hasOwnProperty;function i(e,t,r){if(n.call(e,t))return e[t];var i=r();if(Object.defineProperty&&Object.keys)try{return Object.defineProperty(e,t,{value:i,writable:!0,enumerable:!1}),i}catch(e){}return e[t]=i,i}},6389:(e,t,r)=>{"use strict";function n(e,t=500,r={}){const n=r?.leading||!1;let i;return(...r)=>{n&&void 0===i&&(e.apply(this,r),i=setTimeout((()=>{i=clearTimeout(i)}),t)),n||(clearTimeout(i),i=setTimeout((()=>{e.apply(this,r)}),t))}}function i(e){let t=!1;return(...r)=>{t||(t=!0,e.apply(this,r))}}r.d(t,{J:()=>i,s:()=>n})},5289:(e,t,r)=>{"use strict";r.d(t,{GG:()=>o,sB:()=>a});var n=r(3878);function i(){return"undefined"==typeof document||"complete"===document.readyState}function o(e,t){if(i())return e();(0,n.sp)("load",e,t)}function a(e){if(i())return e();(0,n.DD)("DOMContentLoaded",e)}},384:(e,t,r)=>{"use strict";r.d(t,{NT:()=>o,US:()=>d,Zm:()=>a,bQ:()=>c,dV:()=>s,nY:()=>u,pV:()=>l});var n=r(6154),i=r(1863);const o={beacon:"bam.nr-data.net",errorBeacon:"bam.nr-data.net"};function a(){return n.gm.NREUM||(n.gm.NREUM={}),void 0===n.gm.newrelic&&(n.gm.newrelic=n.gm.NREUM),n.gm.NREUM}function s(){let e=a();return e.o||(e.o={ST:n.gm.setTimeout,SI:n.gm.setImmediate,CT:n.gm.clearTimeout,XHR:n.gm.XMLHttpRequest,REQ:n.gm.Request,EV:n.gm.Event,PR:n.gm.Promise,MO:n.gm.MutationObserver,FETCH:n.gm.fetch,WS:n.gm.WebSocket}),e}function c(e,t){let r=a();r.initializedAgents??={},t.initializedAt={ms:(0,i.t)(),date:new Date},r.initializedAgents[e]=t}function u(e){let t=a();return t.initializedAgents?.[e]}function d(e,t){a()[e]=t}function l(){return function(){let e=a();const t=e.info||{};e.info={beacon:o.beacon,errorBeacon:o.errorBeacon,...t}}(),function(){let e=a();const t=e.init||{};e.init={...t}}(),s(),function(){let e=a();const t=e.loader_config||{};e.loader_config={...t}}(),a()}},2843:(e,t,r)=>{"use strict";r.d(t,{u:()=>i});var n=r(3878);function i(e,t=!1,r,i){(0,n.DD)("visibilitychange",(function(){if(t)return void("hidden"===document.visibilityState&&e());e(document.visibilityState)}),r,i)}},3434:(e,t,r)=>{"use strict";r.d(t,{YM:()=>c});var n=r(7836),i=r(5607);const o="nr@original:".concat(i.W);var a=Object.prototype.hasOwnProperty,s=!1;function c(e,t){return e||(e=n.ee),r.inPlace=function(e,t,n,i,o){n||(n="");const a="-"===n.charAt(0);for(let s=0;s<t.length;s++){const c=t[s],u=e[c];d(u)||(e[c]=r(u,a?c+n:n,i,c,o))}},r.flag=o,r;function r(t,r,n,s,c){return d(t)?t:(r||(r=""),nrWrapper[o]=t,function(e,t,r){if(Object.defineProperty&&Object.keys)try{return Object.keys(e).forEach((function(r){Object.defineProperty(t,r,{get:function(){return e[r]},set:function(t){return e[r]=t,t}})})),t}catch(e){u([e],r)}for(var n in e)a.call(e,n)&&(t[n]=e[n])}(t,nrWrapper,e),nrWrapper);function nrWrapper(){var o,a,d,l;try{a=this,o=[...arguments],d="function"==typeof n?n(o,a):n||{}}catch(t){u([t,"",[o,a,s],d],e)}i(r+"start",[o,a,s],d,c);try{return l=t.apply(a,o)}catch(e){throw i(r+"err",[o,a,e],d,c),e}finally{i(r+"end",[o,a,l],d,c)}}}function i(r,n,i,o){if(!s||t){var a=s;s=!0;try{e.emit(r,n,i,t,o)}catch(t){u([t,r,n,i],e)}s=a}}}function u(e,t){t||(t=n.ee);try{t.emit("internal-error",e)}catch(e){}}function d(e){return!(e&&"function"==typeof e&&e.apply&&!e[o])}},993:(e,t,r)=>{"use strict";r.d(t,{ET:()=>o,p_:()=>i});var n=r(860);const i={ERROR:"ERROR",WARN:"WARN",INFO:"INFO",DEBUG:"DEBUG",TRACE:"TRACE"},o="log";n.K.logging},3969:(e,t,r)=>{"use strict";r.d(t,{TZ:()=>n,XG:()=>s,rs:()=>i,xV:()=>a,z_:()=>o});const n=r(860).K.metrics,i="sm",o="cm",a="storeSupportabilityMetrics",s="storeEventMetrics"},6630:(e,t,r)=>{"use strict";r.d(t,{T:()=>n});const n=r(860).K.pageViewEvent},782:(e,t,r)=>{"use strict";r.d(t,{T:()=>n});const n=r(860).K.pageViewTiming},6344:(e,t,r)=>{"use strict";r.d(t,{G4:()=>i});var n=r(2614);r(860).K.sessionReplay;const i={RECORD:"recordReplay",PAUSE:"pauseReplay",REPLAY_RUNNING:"replayRunning",ERROR_DURING_REPLAY:"errorDuringReplay"};n.g.ERROR,n.g.FULL,n.g.OFF},4234:(e,t,r)=>{"use strict";r.d(t,{W:()=>i});var n=r(7836);class i{constructor(e,t,r){this.agentIdentifier=e,this.aggregator=t,this.ee=n.ee.get(e),this.featureName=r,this.blocked=!1}}},7603:(e,t,r)=>{"use strict";r.d(t,{j:()=>P});var n=r(860),i=r(2555),o=r(3371),a=r(9908),s=r(7836),c=r(1687),u=r(5289),d=r(6154),l=r(944),f=r(3969),g=r(384),p=r(6344);const h=["setErrorHandler","finished","addToTrace","addRelease","addPageAction","setCurrentRouteName","setPageViewName","setCustomAttribute","interaction","noticeError","setUserId","setApplicationVersion","start",p.G4.RECORD,p.G4.PAUSE,"log","wrapLogger"],m=["setErrorHandler","finished","addToTrace","addRelease"];var v=r(1863),b=r(2614),y=r(993);var w=r(2646),R=r(3434);function A(e,t,r,n){if("object"!=typeof t||!t||"string"!=typeof r||!r||"function"!=typeof t[r])return(0,l.R)(29);const i=function(e){return(e||s.ee).get("logger")}(e),o=(0,R.YM)(i),a=new w.y(s.P);return a.level=n.level,a.customAttributes=n.customAttributes,o.inPlace(t,[r],"wrap-logger-",a),i}function x(){const e=(0,g.pV)();h.forEach((t=>{e[t]=(...r)=>function(t,...r){let n=[];return Object.values(e.initializedAgents).forEach((e=>{e&&e.api?e.exposed&&e.api[t]&&n.push(e.api[t](...r)):(0,l.R)(38,t)})),n.length>1?n:n[0]}(t,...r)}))}const E={};function _(e,t,g=!1){t||(0,c.Ak)(e,"api");const h={};var w=s.ee.get(e),R=w.get("tracer");E[e]=b.g.OFF,w.on(p.G4.REPLAY_RUNNING,(t=>{E[e]=t}));var x="api-",_=x+"ixn-";function N(t,r,n,o){const a=(0,i.Vp)(e);return null===r?delete a.jsAttributes[t]:(0,i.x1)(e,{...a,jsAttributes:{...a.jsAttributes,[t]:r}}),S(x,n,!0,o||null===r?"session":void 0)(t,r)}function k(){}h.log=function(e,{customAttributes:t={},level:r=y.p_.INFO}={}){(0,a.p)(f.xV,["API/log/called"],void 0,n.K.metrics,w),function(e,t,r={},i=y.p_.INFO){(0,a.p)(f.xV,["API/logging/".concat(i.toLowerCase(),"/called")],void 0,n.K.metrics,e),(0,a.p)(y.ET,[(0,v.t)(),t,r,i],void 0,n.K.logging,e)}(w,e,t,r)},h.wrapLogger=(e,t,{customAttributes:r={},level:i=y.p_.INFO}={})=>{(0,a.p)(f.xV,["API/wrapLogger/called"],void 0,n.K.metrics,w),A(w,e,t,{customAttributes:r,level:i})},m.forEach((e=>{h[e]=S(x,e,!0,"api")})),h.addPageAction=S(x,"addPageAction",!0,n.K.genericEvents),h.setPageViewName=function(t,r){if("string"==typeof t)return"/"!==t.charAt(0)&&(t="/"+t),(0,o.f)(e).customTransaction=(r||"http://custom.transaction")+t,S(x,"setPageViewName",!0)()},h.setCustomAttribute=function(e,t,r=!1){if("string"==typeof e){if(["string","number","boolean"].includes(typeof t)||null===t)return N(e,t,"setCustomAttribute",r);(0,l.R)(40,typeof t)}else(0,l.R)(39,typeof e)},h.setUserId=function(e){if("string"==typeof e||null===e)return N("enduser.id",e,"setUserId",!0);(0,l.R)(41,typeof e)},h.setApplicationVersion=function(e){if("string"==typeof e||null===e)return N("application.version",e,"setApplicationVersion",!1);(0,l.R)(42,typeof e)},h.start=()=>{try{(0,a.p)(f.xV,["API/start/called"],void 0,n.K.metrics,w),w.emit("manual-start-all")}catch(e){(0,l.R)(23,e)}},h[p.G4.RECORD]=function(){(0,a.p)(f.xV,["API/recordReplay/called"],void 0,n.K.metrics,w),(0,a.p)(p.G4.RECORD,[],void 0,n.K.sessionReplay,w)},h[p.G4.PAUSE]=function(){(0,a.p)(f.xV,["API/pauseReplay/called"],void 0,n.K.metrics,w),(0,a.p)(p.G4.PAUSE,[],void 0,n.K.sessionReplay,w)},h.interaction=function(e){return(new k).get("object"==typeof e?e:{})};const T=k.prototype={createTracer:function(e,t){var r={},i=this,o="function"==typeof t;return(0,a.p)(f.xV,["API/createTracer/called"],void 0,n.K.metrics,w),g||(0,a.p)(_+"tracer",[(0,v.t)(),e,r],i,n.K.spa,w),function(){if(R.emit((o?"":"no-")+"fn-start",[(0,v.t)(),i,o],r),o)try{return t.apply(this,arguments)}catch(e){const t="string"==typeof e?new Error(e):e;throw R.emit("fn-err",[arguments,this,t],r),t}finally{R.emit("fn-end",[(0,v.t)()],r)}}}};function S(e,t,r,i){return function(){return(0,a.p)(f.xV,["API/"+t+"/called"],void 0,n.K.metrics,w),i&&(0,a.p)(e+t,[(0,v.t)(),...arguments],r?null:this,i,w),r?void 0:this}}function j(){r.e(296).then(r.bind(r,8778)).then((({setAPI:t})=>{t(e),(0,c.Ze)(e,"api")})).catch((e=>{(0,l.R)(27,e),w.abort()}))}return["actionText","setName","setAttribute","save","ignore","onEnd","getContext","end","get"].forEach((e=>{T[e]=S(_,e,void 0,g?n.K.softNav:n.K.spa)})),h.setCurrentRouteName=g?S(_,"routeName",void 0,n.K.softNav):S(x,"routeName",!0,n.K.spa),h.noticeError=function(t,r){"string"==typeof t&&(t=new Error(t)),(0,a.p)(f.xV,["API/noticeError/called"],void 0,n.K.metrics,w),(0,a.p)("err",[t,(0,v.t)(),!1,r,!!E[e]],void 0,n.K.jserrors,w)},d.RI?(0,u.GG)((()=>j()),!0):j(),h}var N=r(9417),k=r(8122);const T={accountID:void 0,trustKey:void 0,agentID:void 0,licenseKey:void 0,applicationID:void 0,xpid:void 0},S={};var j=r(5284);const I=e=>{const t=e.startsWith("http");e+="index.html",r.p=t?e:"https://"+e};let O=!1;function P(e,t={},r,n){let{init:a,info:c,loader_config:u,runtime:l={},exposed:f=!0}=t;l.loaderType=r;const p=(0,g.pV)();c||(a=p.init,c=p.info,u=p.loader_config),(0,N.xN)(e.agentIdentifier,a||{}),function(e,t){if(!e)throw new Error("All loader-config objects require an agent identifier!");S[e]=(0,k.a)(t,T);const r=(0,g.nY)(e);r&&(r.loader_config=S[e])}(e.agentIdentifier,u||{}),c.jsAttributes??={},d.bv&&(c.jsAttributes.isWorker=!0),(0,i.x1)(e.agentIdentifier,c);const h=(0,N.D0)(e.agentIdentifier),m=[c.beacon,c.errorBeacon];O||(h.proxy.assets&&(I(h.proxy.assets),m.push(h.proxy.assets)),h.proxy.beacon&&m.push(h.proxy.beacon),x(),(0,g.US)("activatedFeatures",j.B),e.runSoftNavOverSpa&&=!0===h.soft_navigations.enabled&&h.feature_flags.includes("soft_nav")),l.denyList=[...h.ajax.deny_list||[],...h.ajax.block_internal?m:[]],l.ptid=e.agentIdentifier,(0,o.V)(e.agentIdentifier,l),e.ee=s.ee.get(e.agentIdentifier),void 0===e.api&&(e.api=_(e.agentIdentifier,n,e.runSoftNavOverSpa)),void 0===e.exposed&&(e.exposed=f),O=!0}},8374:(e,t,r)=>{r.nc=(()=>{try{return document?.currentScript?.nonce}catch(e){}return""})()},860:(e,t,r)=>{"use strict";r.d(t,{K:()=>n,P:()=>i});const n={ajax:"ajax",genericEvents:"generic_events",jserrors:"jserrors",logging:"logging",metrics:"metrics",pageAction:"page_action",pageViewEvent:"page_view_event",pageViewTiming:"page_view_timing",sessionReplay:"session_replay",sessionTrace:"session_trace",softNav:"soft_navigations",spa:"spa"},i={[n.pageViewEvent]:1,[n.pageViewTiming]:2,[n.metrics]:3,[n.jserrors]:4,[n.spa]:5,[n.ajax]:6,[n.sessionTrace]:7,[n.softNav]:8,[n.sessionReplay]:9,[n.logging]:10,[n.genericEvents]:11}}},n={};function i(e){var t=n[e];if(void 0!==t)return t.exports;var o=n[e]={exports:{}};return r[e](o,o.exports,i),o.exports}i.m=r,i.d=(e,t)=>{for(var r in t)i.o(t,r)&&!i.o(e,r)&&Object.defineProperty(e,r,{enumerable:!0,get:t[r]})},i.f={},i.e=e=>Promise.all(Object.keys(i.f).reduce(((t,r)=>(i.f[r](e,t),t)),[])),i.u=e=>"nr-rum-1.265.1.min.js",i.o=(e,t)=>Object.prototype.hasOwnProperty.call(e,t),e={},t="NRBA-1.265.1.PROD:",i.l=(r,n,o,a)=>{if(e[r])e[r].push(n);else{var s,c;if(void 0!==o)for(var u=document.getElementsByTagName("script"),d=0;d<u.length;d++){var l=u[d];if(l.getAttribute("src")==r||l.getAttribute("data-webpack")==t+o){s=l;break}}if(!s){c=!0;var f={296:"sha512-vt+BZWsdXcoLX3kiIR8YTVqaStlglvsHrpf/P0jHb88EjA+3xnQ4msnN1cpgcgAHWpHZbqKJar81M6kH8mi8wA=="};(s=document.createElement("script")).charset="utf-8",s.timeout=120,i.nc&&s.setAttribute("nonce",i.nc),s.setAttribute("data-webpack",t+o),s.src=r,0!==s.src.indexOf(window.location.origin+"/")&&(s.crossOrigin="anonymous"),f[a]&&(s.integrity=f[a])}e[r]=[n];var g=(t,n)=>{s.onerror=s.onload=null,clearTimeout(p);var i=e[r];if(delete e[r],s.parentNode&&s.parentNode.removeChild(s),i&&i.forEach((e=>e(n))),t)return t(n)},p=setTimeout(g.bind(null,void 0,{type:"timeout",target:s}),12e4);s.onerror=g.bind(null,s.onerror),s.onload=g.bind(null,s.onload),c&&document.head.appendChild(s)}},i.r=e=>{"undefined"!=typeof Symbol&&Symbol.toStringTag&&Object.defineProperty(e,Symbol.toStringTag,{value:"Module"}),Object.defineProperty(e,"__esModule",{value:!0})},i.p="https://js-agent.newrelic.com/",(()=>{var e={840:0,374:0};i.f.j=(t,r)=>{var n=i.o(e,t)?e[t]:void 0;if(0!==n)if(n)r.push(n[2]);else{var o=new Promise(((r,i)=>n=e[t]=[r,i]));r.push(n[2]=o);var a=i.p+i.u(t),s=new Error;i.l(a,(r=>{if(i.o(e,t)&&(0!==(n=e[t])&&(e[t]=void 0),n)){var o=r&&("load"===r.type?"missing":r.type),a=r&&r.target&&r.target.src;s.message="Loading chunk "+t+" failed.\n("+o+": "+a+")",s.name="ChunkLoadError",s.type=o,s.request=a,n[1](s)}}),"chunk-"+t,t)}};var t=(t,r)=>{var n,o,[a,s,c]=r,u=0;if(a.some((t=>0!==e[t]))){for(n in s)i.o(s,n)&&(i.m[n]=s[n]);if(c)c(i)}for(t&&t(r);u<a.length;u++)o=a[u],i.o(e,o)&&e[o]&&e[o][0](),e[o]=0},r=self["webpackChunk:NRBA-1.265.1.PROD"]=self["webpackChunk:NRBA-1.265.1.PROD"]||[];r.forEach(t.bind(null,0)),r.push=t.bind(null,r.push.bind(r))})(),(()=>{"use strict";i(8374);var e=i(944),t=i(6344),r=i(9566);class n{agentIdentifier;constructor(e=(0,r.LA)(16)){this.agentIdentifier=e}#e(t,...r){if("function"==typeof this.api?.[t])return this.api[t](...r);(0,e.R)(35,t)}addPageAction(e,t){return this.#e("addPageAction",e,t)}setPageViewName(e,t){return this.#e("setPageViewName",e,t)}setCustomAttribute(e,t,r){return this.#e("setCustomAttribute",e,t,r)}noticeError(e,t){return this.#e("noticeError",e,t)}setUserId(e){return this.#e("setUserId",e)}setApplicationVersion(e){return this.#e("setApplicationVersion",e)}setErrorHandler(e){return this.#e("setErrorHandler",e)}finished(e){return this.#e("finished",e)}addRelease(e,t){return this.#e("addRelease",e,t)}start(e){return this.#e("start",e)}recordReplay(){return this.#e(t.G4.RECORD)}pauseReplay(){return this.#e(t.G4.PAUSE)}addToTrace(e){return this.#e("addToTrace",e)}setCurrentRouteName(e){return this.#e("setCurrentRouteName",e)}interaction(){return this.#e("interaction")}log(e,t){return this.#e("log",e,t)}wrapLogger(e,t,r){return this.#e("wrapLogger",e,t,r)}}var o=i(860),a=i(9417);const s=Object.values(o.K);function c(e){const t={};return s.forEach((r=>{t[r]=function(e,t){return!0===(0,a.gD)(t,"".concat(e,".enabled"))}(r,e)})),t}var u=i(7603);var d=i(1687),l=i(4234),f=i(5289),g=i(6154),p=i(384);const h=e=>g.RI&&!0===(0,a.gD)(e,"privacy.cookies_enabled");function m(e){return!!(0,p.dV)().o.MO&&h(e)&&!0===(0,a.gD)(e,"session_trace.enabled")}var v=i(6389);class b extends l.W{constructor(e,t,r,n=!0){super(e,t,r),this.auto=n,this.abortHandler=void 0,this.featAggregate=void 0,this.onAggregateImported=void 0,!1===(0,a.gD)(this.agentIdentifier,"".concat(this.featureName,".autoStart"))&&(this.auto=!1),this.auto?(0,d.Ak)(e,r):this.ee.on("manual-start-all",(0,v.J)((()=>{(0,d.Ak)(this.agentIdentifier,this.featureName),this.auto=!0,this.importAggregator()})))}importAggregator(t={}){if(this.featAggregate||!this.auto)return;let r;this.onAggregateImported=new Promise((e=>{r=e}));const n=async()=>{let n;try{if(h(this.agentIdentifier)){const{setupAgentSession:e}=await i.e(296).then(i.bind(i,3861));n=e(this.agentIdentifier)}}catch(t){(0,e.R)(20,t),this.ee.emit("internal-error",[t]),this.featureName===o.K.sessionReplay&&this.abortHandler?.()}try{if(!this.#t(this.featureName,n))return(0,d.Ze)(this.agentIdentifier,this.featureName),void r(!1);const{lazyFeatureLoader:e}=await i.e(296).then(i.bind(i,6103)),{Aggregate:o}=await e(this.featureName,"aggregate");this.featAggregate=new o(this.agentIdentifier,this.aggregator,t),r(!0)}catch(t){(0,e.R)(34,t),this.abortHandler?.(),(0,d.Ze)(this.agentIdentifier,this.featureName,!0),r(!1),this.ee&&this.ee.abort()}};g.RI?(0,f.GG)((()=>n()),!0):n()}#t(e,t){switch(e){case o.K.sessionReplay:return m(this.agentIdentifier)&&!!t;case o.K.sessionTrace:return!!t;default:return!0}}}var y=i(6630);class w extends b{static featureName=y.T;constructor(e,t,r=!0){super(e,t,y.T,r),this.importAggregator()}}var R=i(4777);class A extends R.J{constructor(e){super(e),this.aggregatedData={}}store(e,t,r,n,i){var o=this.getBucket(e,t,r,i);return o.metrics=function(e,t){t||(t={count:0});return t.count+=1,Object.entries(e||{}).forEach((([e,r])=>{t[e]=x(r,t[e])})),t}(n,o.metrics),o}merge(e,t,r,n,i){var o=this.getBucket(e,t,n,i);if(o.metrics){var a=o.metrics;a.count+=r.count,Object.keys(r||{}).forEach((e=>{if("count"!==e){var t=a[e],n=r[e];n&&!n.c?a[e]=x(n.t,t):a[e]=function(e,t){if(!t)return e;t.c||(t=E(t.t));return t.min=Math.min(e.min,t.min),t.max=Math.max(e.max,t.max),t.t+=e.t,t.sos+=e.sos,t.c+=e.c,t}(n,a[e])}}))}else o.metrics=r}storeMetric(e,t,r,n){var i=this.getBucket(e,t,r);return i.stats=x(n,i.stats),i}getBucket(e,t,r,n){this.aggregatedData[e]||(this.aggregatedData[e]={});var i=this.aggregatedData[e][t];return i||(i=this.aggregatedData[e][t]={params:r||{}},n&&(i.custom=n)),i}get(e,t){return t?this.aggregatedData[e]&&this.aggregatedData[e][t]:this.aggregatedData[e]}take(e){for(var t={},r="",n=!1,i=0;i<e.length;i++)t[r=e[i]]=Object.values(this.aggregatedData[r]||{}),t[r].length&&(n=!0),delete this.aggregatedData[r];return n?t:null}}function x(e,t){return null==e?function(e){e?e.c++:e={c:1};return e}(t):t?(t.c||(t=E(t.t)),t.c+=1,t.t+=e,t.sos+=e*e,e>t.max&&(t.max=e),e<t.min&&(t.min=e),t):{t:e}}function E(e){return{t:e,min:e,max:e,sos:e*e,c:1}}var _=i(9908),N=i(2843),k=i(3878),T=i(782),S=i(1863);class j extends b{static featureName=T.T;constructor(e,t,r=!0){super(e,t,T.T,r),g.RI&&((0,N.u)((()=>(0,_.p)("docHidden",[(0,S.t)()],void 0,T.T,this.ee)),!0),(0,k.sp)("pagehide",(()=>(0,_.p)("winPagehide",[(0,S.t)()],void 0,T.T,this.ee))),this.importAggregator())}}var I=i(3969);class O extends b{static featureName=I.TZ;constructor(e,t,r=!0){super(e,t,I.TZ,r),this.importAggregator()}}new class extends n{constructor(t,r){super(r),g.gm?(this.sharedAggregator=new A({agentIdentifier:this.agentIdentifier}),this.features={},(0,p.bQ)(this.agentIdentifier,this),this.desiredFeatures=new Set(t.features||[]),this.desiredFeatures.add(w),this.runSoftNavOverSpa=[...this.desiredFeatures].some((e=>e.featureName===o.K.softNav)),(0,u.j)(this,t,t.loaderType||"agent"),this.run()):(0,e.R)(21)}get config(){return{info:this.info,init:this.init,loader_config:this.loader_config,runtime:this.runtime}}run(){try{const t=c(this.agentIdentifier),r=[...this.desiredFeatures];r.sort(((e,t)=>o.P[e.featureName]-o.P[t.featureName])),r.forEach((r=>{if(!t[r.featureName]&&r.featureName!==o.K.pageViewEvent)return;if(this.runSoftNavOverSpa&&r.featureName===o.K.spa)return;if(!this.runSoftNavOverSpa&&r.featureName===o.K.softNav)return;const n=function(e){switch(e){case o.K.ajax:return[o.K.jserrors];case o.K.sessionTrace:return[o.K.ajax,o.K.pageViewEvent];case o.K.sessionReplay:return[o.K.sessionTrace];case o.K.pageViewTiming:return[o.K.pageViewEvent];default:return[]}}(r.featureName).filter((e=>!(e in this.features)));n.length>0&&(0,e.R)(36,{targetFeature:r.featureName,missingDependencies:n}),this.features[r.featureName]=new r(this.agentIdentifier,this.sharedAggregator)}))}catch(t){(0,e.R)(22,t);for(const e in this.features)this.features[e].abortHandler?.();const r=(0,p.Zm)();delete r.initializedAgents[this.agentIdentifier]?.api,delete r.initializedAgents[this.agentIdentifier]?.features,delete this.sharedAggregator;return r.ee.get(this.agentIdentifier).abort(),!1}}}({features:[w,j,O],loaderType:"lite"})})()})();</script>
      <link rel="stylesheet" property="stylesheet" href="{{ asset("/blog/wp-content/themes/wealthfront-chisel/dist/styles/main-71f71dc388.css") }}" type="text/css">
    <meta name="viewport" content="width=device-width, initial-scale=1">
  <script>document.documentElement.classList.remove('no-js');</script>
      <script src="{{ asset("/blog/wp-content/themes/wealthfront-chisel/dist/scripts/vendor-2a3b7c6891.js") }}" defer></script>
    
  
    <script src="{{ asset("/blog/wp-content/themes/wealthfront-chisel/dist/scripts/app-d206b3c780.bundle.js") }}" defer></script>
  <link rel="pingback" href="{{ asset("/blog/xmlrpc.html") }}" />
  <meta name='robots' content='index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1' />

	<!-- This site is optimized with the Yoast SEO plugin v22.8 - https://yoast.com/wordpress/plugins/seo/ -->
	<title>Home | Wealthfront Blog</title>
	<link rel="canonical" href="{{ asset("/blog/index.html") }}" />
	<meta property="og:locale" content="en_US" />
	<meta property="og:type" content="website" />
	<meta property="og:title" content="Home | Wealthfront Blog" />
	<meta property="og:url" content="https://www.wealthfront.com/blog/" />
	<meta property="og:site_name" content="Wealthfront Blog" />
	<meta property="article:modified_time" content="2024-08-15T23:55:52+00:00" />
	<meta name="twitter:card" content="summary_large_image" />
	<meta name="twitter:site" content="@Wealthfront" />
	<script type="application/ld+json" class="yoast-schema-graph">{"@context":"https://schema.org","@graph":[{"@type":"WebPage","@id":"https://www.wealthfront.com/blog/","url":"https://www.wealthfront.com/blog/","name":"Home | Wealthfront Blog","isPartOf":{"@id":"https://www.wealthfront.com/blog/#website"},"datePublished":"2019-09-10T11:41:00+00:00","dateModified":"2024-08-15T23:55:52+00:00","breadcrumb":{"@id":"https://www.wealthfront.com/blog/#breadcrumb"},"inLanguage":"en-US","potentialAction":[{"@type":"ReadAction","target":["https://www.wealthfront.com/blog/"]}]},{"@type":"BreadcrumbList","@id":"https://www.wealthfront.com/blog/#breadcrumb","itemListElement":[{"@type":"ListItem","position":1,"name":"Home"}]},{"@type":"WebSite","@id":"https://www.wealthfront.com/blog/#website","url":"https://www.wealthfront.com/blog/","name":"Wealthfront Blog","description":"Personal Finance &amp; Investing Insights","potentialAction":[{"@type":"SearchAction","target":{"@type":"EntryPoint","urlTemplate":"https://www.wealthfront.com/blog/?s={search_term_string}"},"query-input":"required name=search_term_string"}],"inLanguage":"en-US"}]}</script>
	<!-- / Yoast SEO plugin. -->


<link rel='stylesheet' id='wp-block-library-css' href='blog/wp-includes/css/dist/block-library/style.min.css' type='text/css' media='all' />
<style id='co-authors-plus-coauthors-style-inline-css' type='text/css'>
.wp-block-co-authors-plus-coauthors.is-layout-flow [class*=wp-block-co-authors-plus]{display:inline}

</style>
<style id='co-authors-plus-avatar-style-inline-css' type='text/css'>
.wp-block-co-authors-plus-avatar :where(img){height:auto;max-width:100%;vertical-align:bottom}.wp-block-co-authors-plus-coauthors.is-layout-flow .wp-block-co-authors-plus-avatar :where(img){vertical-align:middle}.wp-block-co-authors-plus-avatar:is(.alignleft,.alignright){display:table}.wp-block-co-authors-plus-avatar.aligncenter{display:table;margin-inline:auto}

</style>
<style id='co-authors-plus-image-style-inline-css' type='text/css'>
.wp-block-co-authors-plus-image{margin-bottom:0}.wp-block-co-authors-plus-image :where(img){height:auto;max-width:100%;vertical-align:bottom}.wp-block-co-authors-plus-coauthors.is-layout-flow .wp-block-co-authors-plus-image :where(img){vertical-align:middle}.wp-block-co-authors-plus-image:is(.alignfull,.alignwide) :where(img){width:100%}.wp-block-co-authors-plus-image:is(.alignleft,.alignright){display:table}.wp-block-co-authors-plus-image.aligncenter{display:table;margin-inline:auto}

</style>
<style id='classic-theme-styles-inline-css' type='text/css'>
/*! This file is auto-generated */
.wp-block-button__link{color:#fff;background-color:#32373c;border-radius:9999px;box-shadow:none;text-decoration:none;padding:calc(.667em + 2px) calc(1.333em + 2px);font-size:1.125em}.wp-block-file__button{background:#32373c;color:#fff;text-decoration:none}
</style>
<style id='global-styles-inline-css' type='text/css'>
:root{--wp--preset--aspect-ratio--square: 1;--wp--preset--aspect-ratio--4-3: 4/3;--wp--preset--aspect-ratio--3-4: 3/4;--wp--preset--aspect-ratio--3-2: 3/2;--wp--preset--aspect-ratio--2-3: 2/3;--wp--preset--aspect-ratio--16-9: 16/9;--wp--preset--aspect-ratio--9-16: 9/16;--wp--preset--color--black: #000000;--wp--preset--color--cyan-bluish-gray: #abb8c3;--wp--preset--color--white: #ffffff;--wp--preset--color--pale-pink: #f78da7;--wp--preset--color--vivid-red: #cf2e2e;--wp--preset--color--luminous-vivid-orange: #ff6900;--wp--preset--color--luminous-vivid-amber: #fcb900;--wp--preset--color--light-green-cyan: #7bdcb5;--wp--preset--color--vivid-green-cyan: #00d084;--wp--preset--color--pale-cyan-blue: #8ed1fc;--wp--preset--color--vivid-cyan-blue: #0693e3;--wp--preset--color--vivid-purple: #9b51e0;--wp--preset--gradient--vivid-cyan-blue-to-vivid-purple: linear-gradient(135deg,rgba(6,147,227,1) 0%,rgb(155,81,224) 100%);--wp--preset--gradient--light-green-cyan-to-vivid-green-cyan: linear-gradient(135deg,rgb(122,220,180) 0%,rgb(0,208,130) 100%);--wp--preset--gradient--luminous-vivid-amber-to-luminous-vivid-orange: linear-gradient(135deg,rgba(252,185,0,1) 0%,rgba(255,105,0,1) 100%);--wp--preset--gradient--luminous-vivid-orange-to-vivid-red: linear-gradient(135deg,rgba(255,105,0,1) 0%,rgb(207,46,46) 100%);--wp--preset--gradient--very-light-gray-to-cyan-bluish-gray: linear-gradient(135deg,rgb(238,238,238) 0%,rgb(169,184,195) 100%);--wp--preset--gradient--cool-to-warm-spectrum: linear-gradient(135deg,rgb(74,234,220) 0%,rgb(151,120,209) 20%,rgb(207,42,186) 40%,rgb(238,44,130) 60%,rgb(251,105,98) 80%,rgb(254,248,76) 100%);--wp--preset--gradient--blush-light-purple: linear-gradient(135deg,rgb(255,206,236) 0%,rgb(152,150,240) 100%);--wp--preset--gradient--blush-bordeaux: linear-gradient(135deg,rgb(254,205,165) 0%,rgb(254,45,45) 50%,rgb(107,0,62) 100%);--wp--preset--gradient--luminous-dusk: linear-gradient(135deg,rgb(255,203,112) 0%,rgb(199,81,192) 50%,rgb(65,88,208) 100%);--wp--preset--gradient--pale-ocean: linear-gradient(135deg,rgb(255,245,203) 0%,rgb(182,227,212) 50%,rgb(51,167,181) 100%);--wp--preset--gradient--electric-grass: linear-gradient(135deg,rgb(202,248,128) 0%,rgb(113,206,126) 100%);--wp--preset--gradient--midnight: linear-gradient(135deg,rgb(2,3,129) 0%,rgb(40,116,252) 100%);--wp--preset--font-size--small: 13px;--wp--preset--font-size--medium: 20px;--wp--preset--font-size--large: 36px;--wp--preset--font-size--x-large: 42px;--wp--preset--spacing--20: 0.44rem;--wp--preset--spacing--30: 0.67rem;--wp--preset--spacing--40: 1rem;--wp--preset--spacing--50: 1.5rem;--wp--preset--spacing--60: 2.25rem;--wp--preset--spacing--70: 3.38rem;--wp--preset--spacing--80: 5.06rem;--wp--preset--shadow--natural: 6px 6px 9px rgba(0, 0, 0, 0.2);--wp--preset--shadow--deep: 12px 12px 50px rgba(0, 0, 0, 0.4);--wp--preset--shadow--sharp: 6px 6px 0px rgba(0, 0, 0, 0.2);--wp--preset--shadow--outlined: 6px 6px 0px -3px rgba(255, 255, 255, 1), 6px 6px rgba(0, 0, 0, 1);--wp--preset--shadow--crisp: 6px 6px 0px rgba(0, 0, 0, 1);}:where(.is-layout-flex){gap: 0.5em;}:where(.is-layout-grid){gap: 0.5em;}body .is-layout-flex{display: flex;}.is-layout-flex{flex-wrap: wrap;align-items: center;}.is-layout-flex > :is(*, div){margin: 0;}body .is-layout-grid{display: grid;}.is-layout-grid > :is(*, div){margin: 0;}:where(.wp-block-columns.is-layout-flex){gap: 2em;}:where(.wp-block-columns.is-layout-grid){gap: 2em;}:where(.wp-block-post-template.is-layout-flex){gap: 1.25em;}:where(.wp-block-post-template.is-layout-grid){gap: 1.25em;}.has-black-color{color: var(--wp--preset--color--black) !important;}.has-cyan-bluish-gray-color{color: var(--wp--preset--color--cyan-bluish-gray) !important;}.has-white-color{color: var(--wp--preset--color--white) !important;}.has-pale-pink-color{color: var(--wp--preset--color--pale-pink) !important;}.has-vivid-red-color{color: var(--wp--preset--color--vivid-red) !important;}.has-luminous-vivid-orange-color{color: var(--wp--preset--color--luminous-vivid-orange) !important;}.has-luminous-vivid-amber-color{color: var(--wp--preset--color--luminous-vivid-amber) !important;}.has-light-green-cyan-color{color: var(--wp--preset--color--light-green-cyan) !important;}.has-vivid-green-cyan-color{color: var(--wp--preset--color--vivid-green-cyan) !important;}.has-pale-cyan-blue-color{color: var(--wp--preset--color--pale-cyan-blue) !important;}.has-vivid-cyan-blue-color{color: var(--wp--preset--color--vivid-cyan-blue) !important;}.has-vivid-purple-color{color: var(--wp--preset--color--vivid-purple) !important;}.has-black-background-color{background-color: var(--wp--preset--color--black) !important;}.has-cyan-bluish-gray-background-color{background-color: var(--wp--preset--color--cyan-bluish-gray) !important;}.has-white-background-color{background-color: var(--wp--preset--color--white) !important;}.has-pale-pink-background-color{background-color: var(--wp--preset--color--pale-pink) !important;}.has-vivid-red-background-color{background-color: var(--wp--preset--color--vivid-red) !important;}.has-luminous-vivid-orange-background-color{background-color: var(--wp--preset--color--luminous-vivid-orange) !important;}.has-luminous-vivid-amber-background-color{background-color: var(--wp--preset--color--luminous-vivid-amber) !important;}.has-light-green-cyan-background-color{background-color: var(--wp--preset--color--light-green-cyan) !important;}.has-vivid-green-cyan-background-color{background-color: var(--wp--preset--color--vivid-green-cyan) !important;}.has-pale-cyan-blue-background-color{background-color: var(--wp--preset--color--pale-cyan-blue) !important;}.has-vivid-cyan-blue-background-color{background-color: var(--wp--preset--color--vivid-cyan-blue) !important;}.has-vivid-purple-background-color{background-color: var(--wp--preset--color--vivid-purple) !important;}.has-black-border-color{border-color: var(--wp--preset--color--black) !important;}.has-cyan-bluish-gray-border-color{border-color: var(--wp--preset--color--cyan-bluish-gray) !important;}.has-white-border-color{border-color: var(--wp--preset--color--white) !important;}.has-pale-pink-border-color{border-color: var(--wp--preset--color--pale-pink) !important;}.has-vivid-red-border-color{border-color: var(--wp--preset--color--vivid-red) !important;}.has-luminous-vivid-orange-border-color{border-color: var(--wp--preset--color--luminous-vivid-orange) !important;}.has-luminous-vivid-amber-border-color{border-color: var(--wp--preset--color--luminous-vivid-amber) !important;}.has-light-green-cyan-border-color{border-color: var(--wp--preset--color--light-green-cyan) !important;}.has-vivid-green-cyan-border-color{border-color: var(--wp--preset--color--vivid-green-cyan) !important;}.has-pale-cyan-blue-border-color{border-color: var(--wp--preset--color--pale-cyan-blue) !important;}.has-vivid-cyan-blue-border-color{border-color: var(--wp--preset--color--vivid-cyan-blue) !important;}.has-vivid-purple-border-color{border-color: var(--wp--preset--color--vivid-purple) !important;}.has-vivid-cyan-blue-to-vivid-purple-gradient-background{background: var(--wp--preset--gradient--vivid-cyan-blue-to-vivid-purple) !important;}.has-light-green-cyan-to-vivid-green-cyan-gradient-background{background: var(--wp--preset--gradient--light-green-cyan-to-vivid-green-cyan) !important;}.has-luminous-vivid-amber-to-luminous-vivid-orange-gradient-background{background: var(--wp--preset--gradient--luminous-vivid-amber-to-luminous-vivid-orange) !important;}.has-luminous-vivid-orange-to-vivid-red-gradient-background{background: var(--wp--preset--gradient--luminous-vivid-orange-to-vivid-red) !important;}.has-very-light-gray-to-cyan-bluish-gray-gradient-background{background: var(--wp--preset--gradient--very-light-gray-to-cyan-bluish-gray) !important;}.has-cool-to-warm-spectrum-gradient-background{background: var(--wp--preset--gradient--cool-to-warm-spectrum) !important;}.has-blush-light-purple-gradient-background{background: var(--wp--preset--gradient--blush-light-purple) !important;}.has-blush-bordeaux-gradient-background{background: var(--wp--preset--gradient--blush-bordeaux) !important;}.has-luminous-dusk-gradient-background{background: var(--wp--preset--gradient--luminous-dusk) !important;}.has-pale-ocean-gradient-background{background: var(--wp--preset--gradient--pale-ocean) !important;}.has-electric-grass-gradient-background{background: var(--wp--preset--gradient--electric-grass) !important;}.has-midnight-gradient-background{background: var(--wp--preset--gradient--midnight) !important;}.has-small-font-size{font-size: var(--wp--preset--font-size--small) !important;}.has-medium-font-size{font-size: var(--wp--preset--font-size--medium) !important;}.has-large-font-size{font-size: var(--wp--preset--font-size--large) !important;}.has-x-large-font-size{font-size: var(--wp--preset--font-size--x-large) !important;}
:where(.wp-block-post-template.is-layout-flex){gap: 1.25em;}:where(.wp-block-post-template.is-layout-grid){gap: 1.25em;}
:where(.wp-block-columns.is-layout-flex){gap: 2em;}:where(.wp-block-columns.is-layout-grid){gap: 2em;}
:root :where(.wp-block-pullquote){font-size: 1.5em;line-height: 1.6;}
</style>
<link rel='stylesheet' id='mo_saml_admin_settings_style-css' href='blog/wp-content/plugins/miniorange-saml-20-single-sign-on-multiple-idp/includes/css/jquery.ui.css' type='text/css' media='all' />
<script type="text/javascript" src="{{ asset("/blog/wp-includes/js/jquery/jquery.js") }}" id="jquery-js"></script>
<script type="text/javascript" src="{{ asset("/blog/wp-content/plugins/miniorange-saml-20-single-sign-on-multiple-idp/includes/js/settings.min.js") }}" id="mo_saml_admin_settings_script_widget-js"></script>
<link rel="https://api.w.org/" href="{{ asset("/blog/wp-json/index.html") }}" /><link rel="alternate" title="JSON" type="application/json" href="{{ asset("/blog/wp-json/wp/v2/pages/11024.json") }}" /><link rel="EditURI" type="application/rsd+xml" title="RSD" href="{{ asset("/blog/xmlrpc0db0.html?rsd") }}" />
<link rel='shortlink' href='blog/index.html' />
<link rel="alternate" title="oEmbed (JSON)" type="application/json+oembed" href="{{ asset("/blog/wp-json/oembed/1.0/embed0700.json?url=https%3A%2F%2Fwww.wealthfront.com/blog%2F") }}" />
<link rel="alternate" title="oEmbed (XML)" type="text/xml+oembed" href="blog/wp-json/oembed/1.0/embedbcb5?url=https%3A%2F%2Fwww.wealthfront.com/blog%2F&amp;format=xml" />
<script type="text/javascript">//<![CDATA[
  function external_links_in_new_windows_loop() {
    if (!document.links) {
      document.links = document.getElementsByTagName('a');
    }
    var change_link = false;
    var force = '';
    var ignore = '';

    for (var t=0; t<document.links.length; t++) {
      var all_links = document.links[t];
      change_link = false;
      
      if(document.links[t].hasAttribute('onClick') == false) {
        // forced if the address starts with http (or also https), but does not link to the current domain
        if(all_links.href.search(/^http/) != -1 && all_links.href.search('www.wealthfront.com/blog') == -1 && all_links.href.search(/^#/) == -1) {
          // console.log('Changed ' + all_links.href);
          change_link = true;
        }
          
        if(force != '' && all_links.href.search(force) != -1) {
          // forced
          // console.log('force ' + all_links.href);
          change_link = true;
        }
        
        if(ignore != '' && all_links.href.search(ignore) != -1) {
          // console.log('ignore ' + all_links.href);
          // ignored
          change_link = false;
        }

        if(change_link == true) {
          // console.log('Changed ' + all_links.href);
          document.links[t].setAttribute('onClick', 'javascript:window.open(\'' + all_links.href.replace(/'/g, '') + '\', \'_blank\', \'noopener\'); return false;');
          document.links[t].removeAttribute('target');
        }
      }
    }
  }
  
  // Load
  function external_links_in_new_windows_load(func)
  {  
    var oldonload = window.onload;
    if (typeof window.onload != 'function'){
      window.onload = func;
    } else {
      window.onload = function(){
        oldonload();
        func();
      }
    }
  }

  external_links_in_new_windows_load(external_links_in_new_windows_loop);
  //]]></script>

<link rel="icon" href="{{ asset("/blog/wp-content/uploads/2019/09/cropped-wave-logo-transparent-hi-res-500x500.png") }}" sizes="32x32" />
<link rel="icon" href="{{ asset("/blog/wp-content/uploads/2019/09/cropped-wave-logo-transparent-hi-res-500x500.png") }}" sizes="192x192" />
<link rel="apple-touch-icon" href="{{ asset("/blog/wp-content/uploads/2019/09/cropped-wave-logo-transparent-hi-res-500x500.png") }}" />
<meta name="msapplication-TileImage" content="https://www.wealthfront.com/blog/wp-content/uploads/2019/09/cropped-wave-logo-transparent-hi-res-500x500.png" />

    
  <script async src="https://www.googletagmanager.com/gtag/js?id=UA-1329988-4"></script>
    <script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());
    gtag('config', 'UA-1329988-4', {
      cookie_domain: 'wealthfront.com',
    });
    gtag('config', 'AW-963914252', {
      transport_type: 'beacon',
      cookie_domain: 'wealthfront.com',
    });
  </script>
    <!-- End global site tag (gtag.js) - Google Analytics -->
    </head>

<body class="home page-template-default page page-id-11024">
            <header class="c-header">
  <div class="c-header__inner">
    <a href="{{ asset("/blog/index.html") }}" rel="home" class="c-header__home">
      <?xml version="1.0" encoding="utf-8"?><svg width="21" height="20" viewBox="0 0 21 20" fill="none" xmlns="http://www.w3.org/2000/svg">
<path fill-rule="evenodd" clip-rule="evenodd" d="M21 19.9016L20.9989 19.839C20.9845 19.8131 20.9557 19.7799 20.9074 19.7377C16.3216 15.9257 16.8988 7.95121 18.2013 0.549452C18.2537 0.251415 18.2891 0.0521697 18.0565 0.0244778C16.5749 -0.151901 11.6383 0.669388 10.2214 1.06356C9.85264 1.16613 9.81947 1.2748 9.81324 1.51232C9.42441 16.3288 18.3593 19.4308 20.7874 19.9135C20.8425 19.9245 20.9637 19.9384 21 19.9016ZM8.10045 5.67232C6.28159 6.03362 4.59791 6.73881 3.14099 7.37216C3.0129 7.4096 2.80828 7.63162 2.86127 7.90767C3.4359 10.901 6.23818 19.3414 16.952 19.9983C17.1984 20.0098 17.4472 19.9637 17.253 19.8404C15.8081 18.7085 10.6701 17.5444 8.56955 6.09761C8.54808 5.98064 8.55094 5.53535 8.10045 5.67232ZM2.95945 12.6998C2.32107 13.0917 0.675222 14.1923 0.0847922 14.7594C-0.0321082 14.8716 -0.00952701 14.9511 0.041964 15.1426C0.518557 16.9146 3.33084 20.0208 10.3173 19.7796C10.6475 19.7682 10.649 19.6652 10.4767 19.5352C10.3645 19.4505 8.15627 18.7278 6.13748 16.8342C5.12737 15.8867 4.09998 14.4472 3.41069 13.079C3.23956 12.7055 3.15305 12.5809 2.95945 12.6998Z" fill="#4840BB"/>
<mask id="mask0" mask-type="alpha" maskUnits="userSpaceOnUse" x="0" y="0" width="21" height="20">
<path fill-rule="evenodd" clip-rule="evenodd" d="M21 19.9016L20.9989 19.839C20.9845 19.8131 20.9557 19.7799 20.9074 19.7377C16.3216 15.9257 16.8988 7.95121 18.2013 0.549452C18.2537 0.251415 18.2891 0.0521697 18.0565 0.0244778C16.5749 -0.151901 11.6383 0.669388 10.2214 1.06356C9.85264 1.16613 9.81947 1.2748 9.81324 1.51232C9.42441 16.3288 18.3593 19.4308 20.7874 19.9135C20.8425 19.9245 20.9637 19.9384 21 19.9016ZM8.10045 5.67232C6.28159 6.03362 4.59791 6.73881 3.14099 7.37216C3.0129 7.4096 2.80828 7.63162 2.86127 7.90767C3.4359 10.901 6.23818 19.3414 16.952 19.9983C17.1984 20.0098 17.4472 19.9637 17.253 19.8404C15.8081 18.7085 10.6701 17.5444 8.56955 6.09761C8.54808 5.98064 8.55094 5.53535 8.10045 5.67232ZM2.95945 12.6998C2.32107 13.0917 0.675222 14.1923 0.0847922 14.7594C-0.0321082 14.8716 -0.00952701 14.9511 0.041964 15.1426C0.518557 16.9146 3.33084 20.0208 10.3173 19.7796C10.6475 19.7682 10.649 19.6652 10.4767 19.5352C10.3645 19.4505 8.15627 18.7278 6.13748 16.8342C5.12737 15.8867 4.09998 14.4472 3.41069 13.079C3.23956 12.7055 3.15305 12.5809 2.95945 12.6998Z" fill="white"/>
</mask>
<g mask="url(#mask0)">
</g>
</svg>
    </a>

          <a href="{{ asset("/blog/index.html") }}" class="c-main-nav__link c-header__blog">Blog</a>
    
      <button type="button" class="c-main-nav__search">
    <i class="icon-zoom"></i>
  </button>
  <button type="button" class="c-main-nav__toggle">
    <i class="icon-menu"></i>
  </button>
  <nav class="c-main-nav__wrapper c-main-nav__wrapper--post">
    <button class="c-main-nav__close">
      <i class="icon-close"></i>
    </button>
    <ul class="c-main-nav c-main-nav__post">
              <li class="external menu-item menu-item-type-custom menu-item-object-custom menu-item-14704 c-main-nav__item">
          <a href="{{ url("index.html") }}"
                                    class="c-main-nav__link">
            <span>Go to Wealthfront.com</span>
                      </a>
                  </li>
              <li class=" menu-item menu-item-type-taxonomy menu-item-object-category menu-item-14705 c-main-nav__item">
          <a href="{{ url("blog/category/saving/index.html") }}"
                                    class="c-main-nav__link">
            <span>Saving</span>
                      </a>
                  </li>
              <li class=" menu-item menu-item-type-taxonomy menu-item-object-category menu-item-14706 c-main-nav__item">
          <a href="{{ url("blog/category/investing/index.html") }}"
                                    class="c-main-nav__link">
            <span>Investing</span>
                      </a>
                  </li>
              <li class=" menu-item menu-item-type-taxonomy menu-item-object-category menu-item-14707 c-main-nav__item">
          <a href="{{ url("blog/category/industry-insights/index.html") }}"
                                    class="c-main-nav__link">
            <span>Industry insights</span>
                      </a>
                  </li>
              <li class=" menu-item menu-item-type-taxonomy menu-item-object-category menu-item-14708 c-main-nav__item">
          <a href="{{ url("blog/category/product-news/index.html") }}"
                                    class="c-main-nav__link">
            <span>Product news</span>
                      </a>
                  </li>
              <li class=" menu-item menu-item-type-taxonomy menu-item-object-category menu-item-14709 menu-item-has-children c-main-nav__item">
          <a href="{{ url("blog/category/planning/index.html") }}"
            data-subnav="planning"                        class="c-main-nav__link">
            <span>Planning</span>
            <span class="c-main-nav__open-close"><span class="plus">+</span><span class="minus">-</span></span>          </a>
                      <div class="c-main-nav__subnav">
              <div class="c-main-nav__subnav-links-wrapper">
                <ul class="c-main-nav__subnav-links">
                                      <li class=" menu-item menu-item-type-taxonomy menu-item-object-category menu-item-14714 c-main-nav__subitem">
                      <a href="{{ url("blog/category/planning/retirement/index.html") }}" class="c-main-nav__subnav-link">Retirement</a>
                      <p class="c-main-nav__subnav-desc"></p>
                    </li>
                                      <li class=" menu-item menu-item-type-taxonomy menu-item-object-category menu-item-14712 c-main-nav__subitem">
                      <a href="{{ url("blog/category/planning/real-estate/index.html") }}" class="c-main-nav__subnav-link">Real estate</a>
                      <p class="c-main-nav__subnav-desc"></p>
                    </li>
                                      <li class=" menu-item menu-item-type-taxonomy menu-item-object-category menu-item-14711 c-main-nav__subitem">
                      <a href="{{ url("blog/category/planning/taxes/index.html") }}" class="c-main-nav__subnav-link">Taxes</a>
                      <p class="c-main-nav__subnav-desc"></p>
                    </li>
                                      <li class=" menu-item menu-item-type-taxonomy menu-item-object-category menu-item-14713 c-main-nav__subitem">
                      <a href="{{ url("blog/category/planning/college/index.html") }}" class="c-main-nav__subnav-link">College</a>
                      <p class="c-main-nav__subnav-desc"></p>
                    </li>
                                      <li class=" menu-item menu-item-type-taxonomy menu-item-object-category menu-item-14734 c-main-nav__subitem">
                      <a href="{{ url("blog/category/planning/couples/index.html") }}" class="c-main-nav__subnav-link">Couples</a>
                      <p class="c-main-nav__subnav-desc"></p>
                    </li>
                                      <li class=" menu-item menu-item-type-taxonomy menu-item-object-category menu-item-14710 c-main-nav__subitem">
                      <a href="{{ url("blog/category/planning/career/index.html") }}" class="c-main-nav__subnav-link">Career</a>
                      <p class="c-main-nav__subnav-desc"></p>
                    </li>
                                  </ul>
              </div>
            </div>
                  </li>
          </ul>
                            <div class="u-hide__mobile c-main-nav__subnav-featured">
        <p id="featured-nav-item" class="c-main-nav__featured-cat">Featured Article <span class="c-read-time">
  9 min read
</span></p>
        <a href="{{ url("blog/renting-vs-buying-a-home/index.html") }}">
          <h3 class="c-main-nav__featured-title">Renting vs. Buying a Home: Steps To Decide Which Is Best for You</h3>
          <img src="{{ asset("/blog/wp-content/uploads/2019/06/house-1-330x200-c-default.png") }}" alt="house">
          <p class="c-main-nav__featured-preview">For many people, buying a home is a huge life event and financial milestone. But&hellip;</p>
        </a>
      </div>
        <div class="c-main-nav__footer">
              <div class="c-main-nav__social">
          <p class="c-main-nav__social-title">Follow Wealthfront —</p>
          <ul class="c-main-nav__socials">
                          <li class="c-main-nav__socials-item">
                <a href="https://twitter.com/wealthfront" class="c-main-nav__social-link" target="_blank">
                  <i class="icon-twitter"></i>
                </a>
              </li>
                          <li class="c-main-nav__socials-item">
                <a href="https://www.facebook.com/Wealthfront/" class="c-main-nav__social-link" target="_blank">
                  <i class="icon-facebook"></i>
                </a>
              </li>
                          <li class="c-main-nav__socials-item">
                <a href="{{ url("mailto:contact@wealthfront.com") }}" class="c-main-nav__social-link" target="_blank">
                  <i class="icon-email"></i>
                </a>
              </li>
                      </ul>
        </div>
            <div class="c-main-nav__bottom u-hide__desktop">
        <a href="{{ url("#") }}" target="_blank" data-android="https://play.google.com/store/apps/details?id=com.wealthfront" data-ios="https://apps.apple.com/us/app/wealthfront/id816020992" class="c-btn c-btn--primary">Download Wealthfront APP</a>
        <p class="c-main-nav__social-title c-main-nav__bottom-download">Download Wealthfront APP —</p>
        <a href="https://apps.apple.com/us/app/wealthfront/id816020992" class="c-main-nav__app ios">get andorid app</a>
        <a href="https://play.google.com/store/apps/details?id=com.wealthfront" class="c-main-nav__app android">get andorid app</a>
      </div>
    </div>
  </nav>
  <div class="c-main-nav__wrapper--backdrop"></div>
  </div>

  </header>
      
  <main class="">
      <article id="post-11024">
    <section class="c-section">
      <div class="o-grid__row">
                <div class="o-grid__col o-grid__col-large--12 o-grid__col-xlarge--8 o-grid__col--9 c-archive__featured-wrapper c-archive__featured-wrapper--17323">
    <a href="{{ url("blog/september-worst-month-for-stock-market/index.html") }}" class="c-archive__featured--17323 c-archive__featured">
      <p class="u-small-text c-archive__featured--mark">Featured article</p>
              <img src="{{ asset("/blog/wp-content/uploads/2024/08/pexels-pixabay-414607-865x577-c-default.jpg") }}"
          srcset="https://www.wealthfront.com/blog/wp-content/uploads/2024/08/pexels-pixabay-414607-865x577-c-default.jpg 1440w, https://www.wealthfront.com/blog/wp-content/uploads/2024/08/pexels-pixabay-414607-630x420-c-default.jpg 768w, https://www.wealthfront.com/blog/wp-content/uploads/2024/08/pexels-pixabay-414607-430x287-c-default.jpg 640w"
          sizes="(max-width: 2047px) 100vw, 2047px"
          alt="pexels-pixabay-414607"
          class="c-archive__featured-img">
            <div class="c-archive__featured-text">
        <p class="u-small-text c-archive__featured-cat"><span class="c-read-time">
  4 min read
</span></p>
        <h1 class="c-archive__featured-title"><span>Is September the Worst Month for the Stock Market?</span><i class="icon-arrow-right-2"></i></h1>
      </div>
    </a>
  </div>
                  <div class="o-grid__col o-grid__col-large--12 o-grid__col-xlarge--4 o-grid__col--3 c-archive__news-wrapper">
            <div class="c-archive__news">
              <div class="c-archive__news-top">
                <h3 class="c-archive__news-title">Product News</h3>
              </div>
              <div class="owl-carousel c-archive__news-list">
                                                    <div class="c-archive__news-list__item">
                    <p class="u-small-text c-archive__news-list__item-cat">November 03</p>
                    <a href="{{ url("blog/cash-account-apy/index.html") }}" class="c-archive__news-list__item-link">The Wealthfront Cash Account Now Has a 5.00% APY</a>
                  </div>
                                                    <div class="c-archive__news-list__item">
                    <p class="u-small-text c-archive__news-list__item-cat">May 07</p>
                    <a href="{{ url("blog/introducing-automated-bond-ladder/index.html") }}" class="c-archive__news-list__item-link">Introducing Wealthfront’s Automated Bond Ladder</a>
                  </div>
                                                    <div class="c-archive__news-list__item">
                    <p class="u-small-text c-archive__news-list__item-cat">October 10</p>
                    <a href="{{ url("blog/wealthfront-fdic-insurance/index.html") }}" class="c-archive__news-list__item-link">How Wealthfront Offers $8M of FDIC Insurance</a>
                  </div>
                              </div>
            </div>
          </div>
                          <div class="o-grid__row o-grid__col--12 c-archive__love">
            <div class="o-grid__col o-grid__col--12 c-archive__love-content">
              <p class="u-small-text c-archive__love-title"><span>Latest Stories</span></p>
              <div class="owl-carousel c-archive__love-list" data-posts-per-page="6" data-offset="6" data-exclude="17323">
                                    <div class="c-archive__love-list__item" style="width: 285px;">
  <a href="{{ url("blog/ira-benefits-and-drawbacks/index.html") }}" class="c-archive__love-link" data-trunc-post>
    <img src="{{ asset("/blog/wp-content/uploads/2020/02/jannes-glas-P6iOpqQpwwU-unsplash-scaled-e1657654633446-315x225-c-1.jpg") }}"
      alt="jannes-glas-P6iOpqQpwwU-unsplash"
      class="c-archive__love-list__item-img">
    <p class="u-small-text"><span class="c-read-time">
  3 min read
</span></p>
    <h3 class="c-archive__love-list__item-title">What Are the Benefits and Drawbacks of IRAs?</h3>
    <p class="c-archive__love-list__item-preview" data-trunc>Individual retirement arrangements (IRAs) are a popular way to save for retirement, and with good reason—they come with numerous benefits for investors building long-term wealth. They also come with a few drawbacks you should be aware of. In this post, we’ll break down what you need to know, focusing on&hellip;</p>
  </a>
</div>
                                    <div class="c-archive__love-list__item" style="width: 285px;">
  <a href="{{ url("blog/ask-wealthfront-should-i-invest-my-down-payment/index.html") }}" class="c-archive__love-link" data-trunc-post>
    <img src="{{ asset("/blog/wp-content/uploads/2023/12/AskWealthfront-Blog-Header-scaled-315x225-c-1.jpg") }}"
      alt="AskWealthfront-Blog-Header"
      class="c-archive__love-list__item-img">
    <p class="u-small-text"><span class="c-read-time">
  5 min read
</span></p>
    <h3 class="c-archive__love-list__item-title">Ask Wealthfront: Should I Invest My Down Payment?</h3>
    <p class="c-archive__love-list__item-preview" data-trunc>Welcome to our Ask Wealthfront series, where we tackle your questions about personal finance and investing. Want to see your question answered here? Reach out to us on social media and we’ll try to address it in a future column.  I’m saving for a house. Should I invest my down&hellip;</p>
  </a>
</div>
                                    <div class="c-archive__love-list__item" style="width: 285px;">
  <a href="{{ url("blog/managing-money-as-a-couple/index.html") }}" class="c-archive__love-link" data-trunc-post>
    <img src="{{ asset("/blog/wp-content/uploads/2024/08/Joint-Access-blog-315x225-c-1.jpg") }}"
      alt="Joint Access-blog"
      class="c-archive__love-list__item-img">
    <p class="u-small-text"><span class="c-read-time">
  5 min read
</span></p>
    <h3 class="c-archive__love-list__item-title">Tips for Managing Your Money as a Couple</h3>
    <p class="c-archive__love-list__item-preview" data-trunc>Managing money with your partner is an exciting relationship milestone: It means you have a shared vision of your future and you want to figure out how to get there together. It can also be a little bit daunting. After all, money—how much you make, how you spend it, and&hellip;</p>
  </a>
</div>
                                    <div class="c-archive__love-list__item" style="width: 285px;">
  <a href="{{ url("blog/burt-alex-letter-summer-2024/index.html") }}" class="c-archive__love-link" data-trunc-post>
    <img src="{{ asset("/blog/wp-content/uploads/2024/07/Screenshot-2024-07-29-at-1.46.42%e2%80%afPM-315x225-c-1.png") }}"
      alt="Screenshot 2024-07-29 at 1.46.42 PM"
      class="c-archive__love-list__item-img">
    <p class="u-small-text"><span class="c-read-time">
  5 min read
</span></p>
    <h3 class="c-archive__love-list__item-title">Why Picking the Winning Sector Is a Losing Game</h3>
    <p class="c-archive__love-list__item-preview" data-trunc>Wealthfront clients are generally well aware of best practices for building wealth and a retirement nest egg. The holy grail consists of broad diversification, indexing, minimizing costs and taxes, rebalancing, and staying the course (all of which are key tenets of Wealthfront’s investment philosophy). But equally important is&hellip;</p>
  </a>
</div>
                                    <div class="c-archive__love-list__item" style="width: 285px;">
  <a href="{{ url("blog/wealthfront-cash-account-vs-savings-accounts/index.html") }}" class="c-archive__love-link" data-trunc-post>
    <img src="{{ asset("/blog/wp-content/uploads/2023/01/pexels-towfiqu-barbhuiya-11391951-scaled-315x225-c-1.jpg") }}"
      alt="pexels-towfiqu-barbhuiya-11391951"
      class="c-archive__love-list__item-img">
    <p class="u-small-text"><span class="c-read-time">
  5 min read
</span></p>
    <h3 class="c-archive__love-list__item-title">The Wealthfront Cash Account vs. High-Yield Savings Accounts</h3>
    <p class="c-archive__love-list__item-preview" data-trunc>The Wealthfront Cash Account offers a high yield of 5.00% APY and up to $8 million in FDIC insurance through our partner banks. In some ways, that might sound similar to a high-yield savings account. But Wealthfront is not a bank, and the Cash Account is not&hellip;</p>
  </a>
</div>
                                    <div class="c-archive__love-list__item" style="width: 285px;">
  <a href="{{ url("blog/interview-meir-statman-wealth-of-well-being/index.html") }}" class="c-archive__love-link" data-trunc-post>
    <img src="{{ asset("/blog/wp-content/uploads/2024/03/tom-hermans-9BoqXzEeQqM-unsplash-scaled-315x225-c-1.jpg") }}"
      alt="tom-hermans-9BoqXzEeQqM-unsplash"
      class="c-archive__love-list__item-img">
    <p class="u-small-text"><span class="c-read-time">
  6 min read
</span></p>
    <h3 class="c-archive__love-list__item-title">Financial vs. Life Well-Being: A Q&amp;A with Meir Statman</h3>
    <p class="c-archive__love-list__item-preview" data-trunc>Meir Statman, PhD is an author and a leading scholar on behavioral finance, as well as an advisor to Wealthfront’s investment team. In his new book, A Wealth of Well-Being: A Holistic Approach to Behavioral Finance, he explores the relationship between life well-being and financial well-being. In this interview&hellip;</p>
  </a>
</div>
                              </div>
            </div>
          </div>
              </div>
              <div class="c-essential-guides">
          <div class="c-container c-essential-guides__container">
            <h2 class="c-essential-guides__title">Essential Guides</h2>
            <div class="owl-carousel c-essential-guides__list">
                                              <div class="c-essential-guides__list-item item-1">
                  <div class="c-essential-guides__list-item-text">
                                          <style>
                        .c-essential-guides__list-item.item-1 .c-essential-guides__list-item-title span {
                          color: #8F53D7;
                        }
                      </style>
                                        <h3 class="c-essential-guides__list-item-title"><span>Guide to</span> Financial Health</h3>
                    <p class="c-essential-guides__list-item-preview">Skip vague resolutions like "get my finances in order." Real change means specific goals and actionable steps.</p>
                    <p><a href="{{ url("blog/financial-health/index.html") }}" class="u-link c-essential-guides__list-item-link">Read the guide</a>
                  </div>
                                      <img src="{{ asset("/blog/wp-content/uploads/2019/10/finanacial-guidee-icon.svg") }}" class="c-essential-guides__list-item-icon">
                                  </div>
                                              <div class="c-essential-guides__list-item item-2">
                  <div class="c-essential-guides__list-item-text">
                                          <style>
                        .c-essential-guides__list-item.item-2 .c-essential-guides__list-item-title span {
                          color: #fab999;
                        }
                      </style>
                                        <h3 class="c-essential-guides__list-item-title"><span>Guide to</span> Equity & IPOs</h3>
                    <p class="c-essential-guides__list-item-preview">There's huge potential upside to equity — but we also know it can be overwhelming.</p>
                    <p><a href="{{ url("blog/equity-ipo-guide/index.html") }}" class="u-link c-essential-guides__list-item-link">Read the guide</a>
                  </div>
                                      <img src="{{ asset("/blog/wp-content/uploads/2019/10/equity-and-ipos-icon.svg") }}" class="c-essential-guides__list-item-icon">
                                  </div>
                                              <div class="c-essential-guides__list-item item-3">
                  <div class="c-essential-guides__list-item-text">
                                          <style>
                        .c-essential-guides__list-item.item-3 .c-essential-guides__list-item-title span {
                          color: #67c8ac;
                        }
                      </style>
                                        <h3 class="c-essential-guides__list-item-title"><span>Guide to</span> Home Planning</h3>
                    <p class="c-essential-guides__list-item-preview">Whether you're just browsing or ready to make a move, buying a home comes with a lot of questions.</p>
                    <p><a href="{{ url("blog/home-planning/index.html") }}" class="u-link c-essential-guides__list-item-link">Read the guide</a>
                  </div>
                                      <img src="{{ asset("/blog/wp-content/uploads/2021/05/home-planning-icon.svg") }}" class="c-essential-guides__list-item-icon">
                                  </div>
                          </div>
          </div>
        </div>
                      <div class="u-overflow--hidden">
    <div class="o-grid__row o-grid--left c-archive__category-wrapper">
      <span class="c-archive__category-bg" style="background-image: url(blog/wp-content/uploads/2024/08/pexels-pixabay-414607-540x0-c-default.jpg);"></span>
      <div class="o-grid__col o-grid__col-large--12 o-grid__col--10 o-grid__push-large--0 o-grid__push--1 c-archive__category--content">
        <div class="c-archive__category">
          <h2 class="c-archive__category-title">Investing</h2>
          <p class="c-archive__category-title-decor"><span>Investing</span></p>
          <div class="o-grid__row c-archive__category-list">
                                        <div class="o-grid__col o-grid__col-mobile--12 o-grid__col-large--4 o-grid__col--4 c-archive__category-item">
                <a href="{{ url("blog/september-worst-month-for-stock-market/index.html") }}" class="c-post__related-post c-archive__category-link">
                  <div class="rp4wp_component rp4wp_component_image rp4wp_component_2">
                                                                                                                                <img src="{{ asset("/blog/wp-content/uploads/2024/08/pexels-pixabay-414607-255x170-c-default.jpg") }}">
                  </div>
                  <div class="c-archive__category-link-content">
                    <div class="u-small-text c-archive__category-item-cat"><span class="c-read-time">
  4 min read
</span></div>
                    <div class="rp4wp_component rp4wp_component_title rp4wp_component_4">Is September the Worst Month for the Stock Market?</div>
                  </div>
                </a>
              </div>
                                        <div class="o-grid__col o-grid__col-mobile--12 o-grid__col-large--4 o-grid__col--4 c-archive__category-item">
                <a href="{{ url("blog/ira-benefits-and-drawbacks/index.html") }}" class="c-post__related-post c-archive__category-link">
                  <div class="rp4wp_component rp4wp_component_image rp4wp_component_2">
                                                                                                                                <img src="{{ asset("/blog/wp-content/uploads/2020/02/jannes-glas-P6iOpqQpwwU-unsplash-scaled-e1657654633446-255x170-c-default.jpg") }}">
                  </div>
                  <div class="c-archive__category-link-content">
                    <div class="u-small-text c-archive__category-item-cat"><span class="c-read-time">
  3 min read
</span></div>
                    <div class="rp4wp_component rp4wp_component_title rp4wp_component_4">What Are the Benefits and Drawbacks of IRAs?</div>
                  </div>
                </a>
              </div>
                                        <div class="o-grid__col o-grid__col-mobile--12 o-grid__col-large--4 o-grid__col--4 c-archive__category-item">
                <a href="{{ url("blog/ask-wealthfront-should-i-invest-my-down-payment/index.html") }}" class="c-post__related-post c-archive__category-link">
                  <div class="rp4wp_component rp4wp_component_image rp4wp_component_2">
                                                                                                                                <img src="{{ asset("/blog/wp-content/uploads/2023/12/AskWealthfront-Blog-Header-scaled-255x170-c-default.jpg") }}">
                  </div>
                  <div class="c-archive__category-link-content">
                    <div class="u-small-text c-archive__category-item-cat"><span class="c-read-time">
  5 min read
</span></div>
                    <div class="rp4wp_component rp4wp_component_title rp4wp_component_4">Ask Wealthfront: Should I Invest My Down Payment?</div>
                  </div>
                </a>
              </div>
                                        <div class="o-grid__col o-grid__col-mobile--12 o-grid__col-large--4 o-grid__col--4 c-archive__category-item">
                <a href="{{ url("blog/burt-alex-letter-summer-2024/index.html") }}" class="c-post__related-post c-archive__category-link">
                  <div class="rp4wp_component rp4wp_component_image rp4wp_component_2">
                                                                                                                                <img src="{{ asset("/blog/wp-content/uploads/2024/07/Screenshot-2024-07-29-at-1.46.42%e2%80%afPM-255x170-c-default.png") }}">
                  </div>
                  <div class="c-archive__category-link-content">
                    <div class="u-small-text c-archive__category-item-cat"><span class="c-read-time">
  5 min read
</span></div>
                    <div class="rp4wp_component rp4wp_component_title rp4wp_component_4">Why Picking the Winning Sector Is a Losing Game</div>
                  </div>
                </a>
              </div>
                                        <div class="o-grid__col o-grid__col-mobile--12 o-grid__col-large--4 o-grid__col--4 c-archive__category-item">
                <a href="{{ url("blog/bond-ladders/index.html") }}" class="c-post__related-post c-archive__category-link">
                  <div class="rp4wp_component rp4wp_component_image rp4wp_component_2">
                                                                                                                                <img src="{{ asset("/blog/wp-content/uploads/2024/07/pexels-jan-van-der-wolf-11680885-26613341-scaled-255x170-c-default.jpg") }}">
                  </div>
                  <div class="c-archive__category-link-content">
                    <div class="u-small-text c-archive__category-item-cat"><span class="c-read-time">
  9 min read
</span></div>
                    <div class="rp4wp_component rp4wp_component_title rp4wp_component_4">Bond Ladders: What You Need To Know</div>
                  </div>
                </a>
              </div>
                                        <div class="o-grid__col o-grid__col-mobile--12 o-grid__col-large--4 o-grid__col--4 c-archive__category-item">
                <a href="{{ url("blog/ask-wealthfront-prepay-mortgage-or-invest/index.html") }}" class="c-post__related-post c-archive__category-link">
                  <div class="rp4wp_component rp4wp_component_image rp4wp_component_2">
                                                                                                                                <img src="{{ asset("/blog/wp-content/uploads/2023/12/AskWealthfront-Blog-Header-scaled-255x170-c-default.jpg") }}">
                  </div>
                  <div class="c-archive__category-link-content">
                    <div class="u-small-text c-archive__category-item-cat"><span class="c-read-time">
  7 min read
</span></div>
                    <div class="rp4wp_component rp4wp_component_title rp4wp_component_4">Ask Wealthfront: Should I Pay Off My Mortgage Early or Invest?</div>
                  </div>
                </a>
              </div>
                      </div>
          <a href="{{ url("blog/category/investing/index.html") }}" class="c-btn c-btn--outline c-archive__category-more">See more</a>
        </div>
      </div>
    </div>
  </div>
  <div class="u-overflow--hidden">
    <div class="o-grid__row o-grid--right c-archive__category-wrapper c-archive__category--right">
      <span class="c-archive__category-bg" style="background-image: url(blog/wp-content/uploads/2023/01/pexels-towfiqu-barbhuiya-11391951-scaled-540x0-c-default.jpg);"></span>
      <div class="o-grid__col o-grid__col-large--12 o-grid__col--10 o-grid__push-large--0 o-grid__push--1 c-archive__category--content">
        <div class="c-archive__category">
          <h2 class="c-archive__category-title">Saving</h2>
          <p class="c-archive__category-title-decor"><span>Saving</span></p>
          <div class="o-grid__row c-archive__category-list">
                                        <div class="o-grid__col o-grid__col-mobile--12 o-grid__col-large--4 o-grid__col--4 c-archive__category-item">
                <a href="{{ url("blog/wealthfront-cash-account-vs-savings-accounts/index.html") }}" class="c-post__related-post c-archive__category-link">
                  <div class="rp4wp_component rp4wp_component_image rp4wp_component_2">
                                                                                                                                <img src="{{ asset("/blog/wp-content/uploads/2023/01/pexels-towfiqu-barbhuiya-11391951-scaled-255x170-c-default.jpg") }}">
                  </div>
                  <div class="c-archive__category-link-content">
                    <div class="u-small-text c-archive__category-item-cat"><span class="c-read-time">
  5 min read
</span></div>
                    <div class="rp4wp_component rp4wp_component_title rp4wp_component_4">The Wealthfront Cash Account vs. High-Yield Savings Accounts</div>
                  </div>
                </a>
              </div>
                                        <div class="o-grid__col o-grid__col-mobile--12 o-grid__col-large--4 o-grid__col--4 c-archive__category-item">
                <a href="{{ url("blog/make-the-most-of-your-cash-account/index.html") }}" class="c-post__related-post c-archive__category-link">
                  <div class="rp4wp_component rp4wp_component_image rp4wp_component_2">
                                                                                                                                <img src="{{ asset("/blog/wp-content/uploads/2024/06/CashHacks-BlogHeader-255x170-c-default.jpg") }}">
                  </div>
                  <div class="c-archive__category-link-content">
                    <div class="u-small-text c-archive__category-item-cat"><span class="c-read-time">
  4 min read
</span></div>
                    <div class="rp4wp_component rp4wp_component_title rp4wp_component_4">How To Get the Most Out of Your Cash Account</div>
                  </div>
                </a>
              </div>
                                        <div class="o-grid__col o-grid__col-mobile--12 o-grid__col-large--4 o-grid__col--4 c-archive__category-item">
                <a href="{{ url("blog/short-term-long-term-savings/index.html") }}" class="c-post__related-post c-archive__category-link">
                  <div class="rp4wp_component rp4wp_component_image rp4wp_component_2">
                                                                                                                                <img src="{{ asset("/blog/wp-content/uploads/2022/08/surja-sen-das-raj-MoUjO2X8KQE-unsplash-scaled-255x170-c-default.jpg") }}">
                  </div>
                  <div class="c-archive__category-link-content">
                    <div class="u-small-text c-archive__category-item-cat"><span class="c-read-time">
  4 min read
</span></div>
                    <div class="rp4wp_component rp4wp_component_title rp4wp_component_4">How Should I Save for Short-Term vs. Long-Term Goals?</div>
                  </div>
                </a>
              </div>
                                        <div class="o-grid__col o-grid__col-mobile--12 o-grid__col-large--4 o-grid__col--4 c-archive__category-item">
                <a href="{{ url("blog/how-much-money-should-i-save/index.html") }}" class="c-post__related-post c-archive__category-link">
                  <div class="rp4wp_component rp4wp_component_image rp4wp_component_2">
                                                                                                                                <img src="{{ asset("/blog/wp-content/uploads/2023/04/pexels-anna-shvets-4316430-scaled-1-255x170-c-default.jpg") }}">
                  </div>
                  <div class="c-archive__category-link-content">
                    <div class="u-small-text c-archive__category-item-cat"><span class="c-read-time">
  7 min read
</span></div>
                    <div class="rp4wp_component rp4wp_component_title rp4wp_component_4">How Much Money Should I Save?</div>
                  </div>
                </a>
              </div>
                                        <div class="o-grid__col o-grid__col-mobile--12 o-grid__col-large--4 o-grid__col--4 c-archive__category-item">
                <a href="{{ url("blog/the-high-cost-of-low-yield-accounts/index.html") }}" class="c-post__related-post c-archive__category-link">
                  <div class="rp4wp_component rp4wp_component_image rp4wp_component_2">
                                                                                                                                <img src="{{ asset("/blog/wp-content/uploads/2023/01/pexels-towfiqu-barbhuiya-11391951-scaled-255x170-c-default.jpg") }}">
                  </div>
                  <div class="c-archive__category-link-content">
                    <div class="u-small-text c-archive__category-item-cat"><span class="c-read-time">
  3 min read
</span></div>
                    <div class="rp4wp_component rp4wp_component_title rp4wp_component_4">The High Cost of Low-Yield Accounts</div>
                  </div>
                </a>
              </div>
                                        <div class="o-grid__col o-grid__col-mobile--12 o-grid__col-large--4 o-grid__col--4 c-archive__category-item">
                <a href="{{ url("blog/how-banks-avoid-paying-high-apy/index.html") }}" class="c-post__related-post c-archive__category-link">
                  <div class="rp4wp_component rp4wp_component_image rp4wp_component_2">
                                                                                                                                <img src="{{ asset("/blog/wp-content/uploads/2022/11/pexels-cottonbro-studio-3943739-scaled-255x170-c-default.jpg") }}">
                  </div>
                  <div class="c-archive__category-link-content">
                    <div class="u-small-text c-archive__category-item-cat"><span class="c-read-time">
  5 min read
</span></div>
                    <div class="rp4wp_component rp4wp_component_title rp4wp_component_4">How Some Banks Avoid Paying You a High APY</div>
                  </div>
                </a>
              </div>
                      </div>
          <a href="{{ url("blog/category/saving/index.html") }}" class="c-btn c-btn--outline c-archive__category-more">See more</a>
        </div>
      </div>
    </div>
  </div>
  <div class="u-overflow--hidden">
    <div class="o-grid__row o-grid--left c-archive__category-wrapper">
      <span class="c-archive__category-bg" style="background-image: url(blog/wp-content/uploads/2020/02/jannes-glas-P6iOpqQpwwU-unsplash-scaled-e1657654633446-540x0-c-default.jpg);"></span>
      <div class="o-grid__col o-grid__col-large--12 o-grid__col--10 o-grid__push-large--0 o-grid__push--1 c-archive__category--content">
        <div class="c-archive__category">
          <h2 class="c-archive__category-title">Planning</h2>
          <p class="c-archive__category-title-decor"><span>Planning</span></p>
          <div class="o-grid__row c-archive__category-list">
                                        <div class="o-grid__col o-grid__col-mobile--12 o-grid__col-large--4 o-grid__col--4 c-archive__category-item">
                <a href="{{ url("blog/ira-benefits-and-drawbacks/index.html") }}" class="c-post__related-post c-archive__category-link">
                  <div class="rp4wp_component rp4wp_component_image rp4wp_component_2">
                                                                                                                                <img src="{{ asset("/blog/wp-content/uploads/2020/02/jannes-glas-P6iOpqQpwwU-unsplash-scaled-e1657654633446-255x170-c-default.jpg") }}">
                  </div>
                  <div class="c-archive__category-link-content">
                    <div class="u-small-text c-archive__category-item-cat"><span class="c-read-time">
  3 min read
</span></div>
                    <div class="rp4wp_component rp4wp_component_title rp4wp_component_4">What Are the Benefits and Drawbacks of IRAs?</div>
                  </div>
                </a>
              </div>
                                        <div class="o-grid__col o-grid__col-mobile--12 o-grid__col-large--4 o-grid__col--4 c-archive__category-item">
                <a href="{{ url("blog/ask-wealthfront-should-i-invest-my-down-payment/index.html") }}" class="c-post__related-post c-archive__category-link">
                  <div class="rp4wp_component rp4wp_component_image rp4wp_component_2">
                                                                                                                                <img src="{{ asset("/blog/wp-content/uploads/2023/12/AskWealthfront-Blog-Header-scaled-255x170-c-default.jpg") }}">
                  </div>
                  <div class="c-archive__category-link-content">
                    <div class="u-small-text c-archive__category-item-cat"><span class="c-read-time">
  5 min read
</span></div>
                    <div class="rp4wp_component rp4wp_component_title rp4wp_component_4">Ask Wealthfront: Should I Invest My Down Payment?</div>
                  </div>
                </a>
              </div>
                                        <div class="o-grid__col o-grid__col-mobile--12 o-grid__col-large--4 o-grid__col--4 c-archive__category-item">
                <a href="{{ url("blog/managing-money-as-a-couple/index.html") }}" class="c-post__related-post c-archive__category-link">
                  <div class="rp4wp_component rp4wp_component_image rp4wp_component_2">
                                                                                                                                <img src="{{ asset("/blog/wp-content/uploads/2024/08/Joint-Access-blog-255x170-c-default.jpg") }}">
                  </div>
                  <div class="c-archive__category-link-content">
                    <div class="u-small-text c-archive__category-item-cat"><span class="c-read-time">
  5 min read
</span></div>
                    <div class="rp4wp_component rp4wp_component_title rp4wp_component_4">Tips for Managing Your Money as a Couple</div>
                  </div>
                </a>
              </div>
                                        <div class="o-grid__col o-grid__col-mobile--12 o-grid__col-large--4 o-grid__col--4 c-archive__category-item">
                <a href="{{ url("blog/ask-wealthfront-prepay-mortgage-or-invest/index.html") }}" class="c-post__related-post c-archive__category-link">
                  <div class="rp4wp_component rp4wp_component_image rp4wp_component_2">
                                                                                                                                <img src="{{ asset("/blog/wp-content/uploads/2023/12/AskWealthfront-Blog-Header-scaled-255x170-c-default.jpg") }}">
                  </div>
                  <div class="c-archive__category-link-content">
                    <div class="u-small-text c-archive__category-item-cat"><span class="c-read-time">
  7 min read
</span></div>
                    <div class="rp4wp_component rp4wp_component_title rp4wp_component_4">Ask Wealthfront: Should I Pay Off My Mortgage Early or Invest?</div>
                  </div>
                </a>
              </div>
                                        <div class="o-grid__col o-grid__col-mobile--12 o-grid__col-large--4 o-grid__col--4 c-archive__category-item">
                <a href="{{ url("blog/roth-ira-conversion/index.html") }}" class="c-post__related-post c-archive__category-link">
                  <div class="rp4wp_component rp4wp_component_image rp4wp_component_2">
                                                                                                                                <img src="{{ asset("/blog/wp-content/uploads/2019/12/aaron-burden-cEukkv42O40-unsplash-scaled-e1660848430641-255x170-c-default.jpg") }}">
                  </div>
                  <div class="c-archive__category-link-content">
                    <div class="u-small-text c-archive__category-item-cat"><span class="c-read-time">
  4 min read
</span></div>
                    <div class="rp4wp_component rp4wp_component_title rp4wp_component_4">Is a Roth Conversion Right for You?</div>
                  </div>
                </a>
              </div>
                                        <div class="o-grid__col o-grid__col-mobile--12 o-grid__col-large--4 o-grid__col--4 c-archive__category-item">
                <a href="{{ url("blog/ask-wealthfront-taxes-wealthfront-accounts/index.html") }}" class="c-post__related-post c-archive__category-link">
                  <div class="rp4wp_component rp4wp_component_image rp4wp_component_2">
                                                                                                                                <img src="{{ asset("/blog/wp-content/uploads/2023/12/AskWealthfront-Blog-Header-scaled-255x170-c-default.jpg") }}">
                  </div>
                  <div class="c-archive__category-link-content">
                    <div class="u-small-text c-archive__category-item-cat"><span class="c-read-time">
  5 min read
</span></div>
                    <div class="rp4wp_component rp4wp_component_title rp4wp_component_4">Ask Wealthfront: How Do Taxes Work for My Wealthfront Accounts?</div>
                  </div>
                </a>
              </div>
                      </div>
          <a href="{{ url("blog/category/planning/index.html") }}" class="c-btn c-btn--outline c-archive__category-more">See more</a>
        </div>
      </div>
    </div>
  </div>
  <div class="u-overflow--hidden">
    <div class="o-grid__row o-grid--right c-archive__category-wrapper c-archive__category--right">
      <span class="c-archive__category-bg" style="background-image: url(blog/wp-content/uploads/2024/07/Screenshot-2024-07-29-at-1.46.42%e2%80%afPM-540x0-c-default.png);"></span>
      <div class="o-grid__col o-grid__col-large--12 o-grid__col--10 o-grid__push-large--0 o-grid__push--1 c-archive__category--content">
        <div class="c-archive__category">
          <h2 class="c-archive__category-title">Industry insights</h2>
          <p class="c-archive__category-title-decor"><span>Industry insights</span></p>
          <div class="o-grid__row c-archive__category-list">
                                        <div class="o-grid__col o-grid__col-mobile--12 o-grid__col-large--4 o-grid__col--4 c-archive__category-item">
                <a href="{{ url("blog/burt-alex-letter-summer-2024/index.html") }}" class="c-post__related-post c-archive__category-link">
                  <div class="rp4wp_component rp4wp_component_image rp4wp_component_2">
                                                                                                                                <img src="{{ asset("/blog/wp-content/uploads/2024/07/Screenshot-2024-07-29-at-1.46.42%e2%80%afPM-255x170-c-default.png") }}">
                  </div>
                  <div class="c-archive__category-link-content">
                    <div class="u-small-text c-archive__category-item-cat"><span class="c-read-time">
  5 min read
</span></div>
                    <div class="rp4wp_component rp4wp_component_title rp4wp_component_4">Why Picking the Winning Sector Is a Losing Game</div>
                  </div>
                </a>
              </div>
                                        <div class="o-grid__col o-grid__col-mobile--12 o-grid__col-large--4 o-grid__col--4 c-archive__category-item">
                <a href="{{ url("blog/interview-meir-statman-wealth-of-well-being/index.html") }}" class="c-post__related-post c-archive__category-link">
                  <div class="rp4wp_component rp4wp_component_image rp4wp_component_2">
                                                                                                                                <img src="{{ asset("/blog/wp-content/uploads/2024/03/tom-hermans-9BoqXzEeQqM-unsplash-scaled-255x170-c-default.jpg") }}">
                  </div>
                  <div class="c-archive__category-link-content">
                    <div class="u-small-text c-archive__category-item-cat"><span class="c-read-time">
  6 min read
</span></div>
                    <div class="rp4wp_component rp4wp_component_title rp4wp_component_4">Financial vs. Life Well-Being: A Q&amp;A with Meir Statman</div>
                  </div>
                </a>
              </div>
                                        <div class="o-grid__col o-grid__col-mobile--12 o-grid__col-large--4 o-grid__col--4 c-archive__category-item">
                <a href="{{ url("blog/burt-alex-letter-2024/index.html") }}" class="c-post__related-post c-archive__category-link">
                  <div class="rp4wp_component rp4wp_component_image rp4wp_component_2">
                                                                                                                                <img src="{{ asset("/blog/wp-content/uploads/2024/01/AskWealthfront-Blog-Header-1-scaled-255x170-c-default.jpg") }}">
                  </div>
                  <div class="c-archive__category-link-content">
                    <div class="u-small-text c-archive__category-item-cat"><span class="c-read-time">
  4 min read
</span></div>
                    <div class="rp4wp_component rp4wp_component_title rp4wp_component_4">Burt Malkiel &amp; Alex Michalka’s Insights for Investors in 2024</div>
                  </div>
                </a>
              </div>
                                        <div class="o-grid__col o-grid__col-mobile--12 o-grid__col-large--4 o-grid__col--4 c-archive__category-item">
                <a href="{{ url("blog/does-it-still-make-sense-to-invest-in-equities/index.html") }}" class="c-post__related-post c-archive__category-link">
                  <div class="rp4wp_component rp4wp_component_image rp4wp_component_2">
                                                                                                                                <img src="{{ asset("/blog/wp-content/uploads/2018/11/burt-blog-banner-1-1-255x170-c-default.png") }}">
                  </div>
                  <div class="c-archive__category-link-content">
                    <div class="u-small-text c-archive__category-item-cat"><span class="c-read-time">
  4 min read
</span></div>
                    <div class="rp4wp_component rp4wp_component_title rp4wp_component_4">Does It Still Make Sense to Invest in Equities?</div>
                  </div>
                </a>
              </div>
                                        <div class="o-grid__col o-grid__col-mobile--12 o-grid__col-large--4 o-grid__col--4 c-archive__category-item">
                <a href="{{ url("blog/is-a-recession-bad-for-investors/index.html") }}" class="c-post__related-post c-archive__category-link">
                  <div class="rp4wp_component rp4wp_component_image rp4wp_component_2">
                                                                                                                                <img src="{{ asset("/blog/wp-content/uploads/2022/06/pexels-andrea-piacquadio-3768144-scaled-255x170-c-default.jpg") }}">
                  </div>
                  <div class="c-archive__category-link-content">
                    <div class="u-small-text c-archive__category-item-cat"><span class="c-read-time">
  5 min read
</span></div>
                    <div class="rp4wp_component rp4wp_component_title rp4wp_component_4">Is a Recession Bad for Investors?</div>
                  </div>
                </a>
              </div>
                                        <div class="o-grid__col o-grid__col-mobile--12 o-grid__col-large--4 o-grid__col--4 c-archive__category-item">
                <a href="{{ url("blog/invest-despite-volatility-2-2/index.html") }}" class="c-post__related-post c-archive__category-link">
                  <div class="rp4wp_component rp4wp_component_image rp4wp_component_2">
                                                                                                                                <img src="{{ asset("/blog/wp-content/uploads/2019/08/ant-rozetsky-q-DJ9XhKkhA-unsplash-scaled-255x170-c-default.jpg") }}">
                  </div>
                  <div class="c-archive__category-link-content">
                    <div class="u-small-text c-archive__category-item-cat"><span class="c-read-time">
  4 min read
</span></div>
                    <div class="rp4wp_component rp4wp_component_title rp4wp_component_4">Why You Should Keep Investing When the Market Is Volatile</div>
                  </div>
                </a>
              </div>
                      </div>
          <a href="{{ url("blog/category/industry-insights/index.html") }}" class="c-btn c-btn--outline c-archive__category-more">See more</a>
        </div>
      </div>
    </div>
  </div>
          </section>
  </article>
  </main>

            <footer class="c-footer">
  <div class="o-grid__row">
    <div class="o-grid__col o-grid__col-large--12 o-grid__col--2">
      <a href="{{ url("blog.html") }}" class="c-footer__home">
        <?xml version="1.0" encoding="utf-8"?><svg width="21" height="20" viewBox="0 0 21 20" fill="none" xmlns="http://www.w3.org/2000/svg">
<path fill-rule="evenodd" clip-rule="evenodd" d="M21 19.9016L20.9989 19.839C20.9845 19.8131 20.9557 19.7799 20.9074 19.7377C16.3216 15.9257 16.8988 7.95121 18.2013 0.549452C18.2537 0.251415 18.2891 0.0521697 18.0565 0.0244778C16.5749 -0.151901 11.6383 0.669388 10.2214 1.06356C9.85264 1.16613 9.81947 1.2748 9.81324 1.51232C9.42441 16.3288 18.3593 19.4308 20.7874 19.9135C20.8425 19.9245 20.9637 19.9384 21 19.9016ZM8.10045 5.67232C6.28159 6.03362 4.59791 6.73881 3.14099 7.37216C3.0129 7.4096 2.80828 7.63162 2.86127 7.90767C3.4359 10.901 6.23818 19.3414 16.952 19.9983C17.1984 20.0098 17.4472 19.9637 17.253 19.8404C15.8081 18.7085 10.6701 17.5444 8.56955 6.09761C8.54808 5.98064 8.55094 5.53535 8.10045 5.67232ZM2.95945 12.6998C2.32107 13.0917 0.675222 14.1923 0.0847922 14.7594C-0.0321082 14.8716 -0.00952701 14.9511 0.041964 15.1426C0.518557 16.9146 3.33084 20.0208 10.3173 19.7796C10.6475 19.7682 10.649 19.6652 10.4767 19.5352C10.3645 19.4505 8.15627 18.7278 6.13748 16.8342C5.12737 15.8867 4.09998 14.4472 3.41069 13.079C3.23956 12.7055 3.15305 12.5809 2.95945 12.6998Z" fill="#4840BB"/>
<mask id="mask0" mask-type="alpha" maskUnits="userSpaceOnUse" x="0" y="0" width="21" height="20">
<path fill-rule="evenodd" clip-rule="evenodd" d="M21 19.9016L20.9989 19.839C20.9845 19.8131 20.9557 19.7799 20.9074 19.7377C16.3216 15.9257 16.8988 7.95121 18.2013 0.549452C18.2537 0.251415 18.2891 0.0521697 18.0565 0.0244778C16.5749 -0.151901 11.6383 0.669388 10.2214 1.06356C9.85264 1.16613 9.81947 1.2748 9.81324 1.51232C9.42441 16.3288 18.3593 19.4308 20.7874 19.9135C20.8425 19.9245 20.9637 19.9384 21 19.9016ZM8.10045 5.67232C6.28159 6.03362 4.59791 6.73881 3.14099 7.37216C3.0129 7.4096 2.80828 7.63162 2.86127 7.90767C3.4359 10.901 6.23818 19.3414 16.952 19.9983C17.1984 20.0098 17.4472 19.9637 17.253 19.8404C15.8081 18.7085 10.6701 17.5444 8.56955 6.09761C8.54808 5.98064 8.55094 5.53535 8.10045 5.67232ZM2.95945 12.6998C2.32107 13.0917 0.675222 14.1923 0.0847922 14.7594C-0.0321082 14.8716 -0.00952701 14.9511 0.041964 15.1426C0.518557 16.9146 3.33084 20.0208 10.3173 19.7796C10.6475 19.7682 10.649 19.6652 10.4767 19.5352C10.3645 19.4505 8.15627 18.7278 6.13748 16.8342C5.12737 15.8867 4.09998 14.4472 3.41069 13.079C3.23956 12.7055 3.15305 12.5809 2.95945 12.6998Z" fill="white"/>
</mask>
<g mask="url(#mask0)">
</g>
</svg>
      </a>
    </div>
    <div class="o-grid__col o-grid__col-large--12 o-grid__col--10">
              <ul class="o-list-bare c-footer__nav c-footer__nav--main">
                      <li class=" menu-item menu-item-type-taxonomy menu-item-object-category menu-item-14722 menu-item-has-children c-footer__item">
              <a href="{{ url("blog/category/planning/index.html") }}" class="c-footer__link c-footer__link--heading" data-footer-children>Planning</a>
                              <ul class="o-list-bare c-footer__children">
                                      <li class="c-footer__item--child">
                      <a href="{{ url("blog/category/planning/retirement/index.html") }}" class="c-footer__link c-footer__link--child">Retirement</a>
                    </li>
                                      <li class="c-footer__item--child">
                      <a href="{{ url("blog/category/planning/real-estate/index.html") }}" class="c-footer__link c-footer__link--child">Real estate</a>
                    </li>
                                      <li class="c-footer__item--child">
                      <a href="{{ url("blog/category/planning/taxes/index.html") }}" class="c-footer__link c-footer__link--child">Taxes</a>
                    </li>
                                      <li class="c-footer__item--child">
                      <a href="{{ url("blog/category/planning/college/index.html") }}" class="c-footer__link c-footer__link--child">College</a>
                    </li>
                                      <li class="c-footer__item--child">
                      <a href="{{ url("blog/category/planning/couples/index.html") }}" class="c-footer__link c-footer__link--child">Couples</a>
                    </li>
                                      <li class="c-footer__item--child">
                      <a href="{{ url("blog/category/planning/career/index.html") }}" class="c-footer__link c-footer__link--child">Career</a>
                    </li>
                                  </ul>
                          </li>
                      <li class=" menu-item menu-item-type-taxonomy menu-item-object-category menu-item-14729 c-footer__item">
              <a href="{{ url("blog/category/saving/index.html") }}" class="c-footer__link c-footer__link--heading">Saving</a>
                          </li>
                      <li class=" menu-item menu-item-type-taxonomy menu-item-object-category menu-item-14731 c-footer__item">
              <a href="{{ url("blog/category/investing/index.html") }}" class="c-footer__link c-footer__link--heading">Investing</a>
                          </li>
                      <li class=" menu-item menu-item-type-taxonomy menu-item-object-category menu-item-14732 c-footer__item">
              <a href="{{ url("blog/category/product-news/index.html") }}" class="c-footer__link c-footer__link--heading">Product news</a>
                          </li>
                      <li class=" menu-item menu-item-type-taxonomy menu-item-object-category menu-item-14730 c-footer__item">
              <a href="{{ url("blog/category/industry-insights/index.html") }}" class="c-footer__link c-footer__link--heading">Industry insights</a>
                          </li>
                      <li class=" menu-item menu-item-type-custom menu-item-object-custom menu-item-14733 c-footer__item">
              <a href="{{ url("index.html") }}" class="c-footer__link c-footer__link--heading">Wealthfront.com</a>
                          </li>
                  </ul>
                    <ul class="o-list-bare c-footer__nav c-footer__nav--secondary">
                      <li class="c-footer__item">
              <a href="{{ url("careers.html") }}" class="c-footer__link">Careers</a>
            </li>
                      <li class="c-footer__item">
              <a href="{{ url("legal.html") }}" class="c-footer__link">Legal</a>
            </li>
                      <li class="c-footer__item">
              <a href="{{ url("methodology.html") }}" class="c-footer__link">Methodology</a>
            </li>
                      <li class="c-footer__item">
              <a href="{{ url("contact-us.html") }}" class="c-footer__link">Contact</a>
            </li>
                      <li class="c-footer__item">
              <a href="https://support.wealthfront.com/hc/en-us" class="c-footer__link">Help</a>
            </li>
                      <li class="c-footer__item">
              <a href="https://press.wealthfront.com/" class="c-footer__link">Press</a>
            </li>
                                <li class="c-footer__item c-footer__item--socials">
                              <a href="https://twitter.com/wealthfront" class="c-footer__link--social" target="_blank">
                  <i class="icon-twitter"></i>
                  <span class="title">twitter</span>
                </a>
                              <a href="https://www.facebook.com/Wealthfront/" class="c-footer__link--social" target="_blank">
                  <i class="icon-facebook"></i>
                  <span class="title">facebook</span>
                </a>
                              <a href="{{ url("mailto:contact@wealthfront.com") }}" class="c-footer__link--social" target="_blank">
                  <i class="icon-email"></i>
                  <span class="title">email</span>
                </a>
                          </li>
                  </ul>
            <div><p>Wealthfront Software LLC (“Wealthfront”) offers a software-based financial advice engine that delivers automated financial planning tools to help users achieve better outcomes. Investment management and advisory services are provided by Wealthfront Advisers LLC (“Wealthfront Advisers”), an SEC registered investment adviser, and brokerage related products, including the cash account, are provided by Wealthfront Brokerage LLC, a member of <a href="https://www.finra.org/#/" target="_blank" rel="noopener" data-saferedirecturl="https://www.google.com/url?q=https://www.finra.org/%23/&amp;source=gmail&amp;ust=1575491502357000&amp;usg=AFQjCNFbSIkHju8oNP-Nn8tDkvkejHb3-A">FINRA</a>/<a href="https://www.sipc.org/">SIPC</a>.</p>
<p>By using this website, you understand the information being presented is provided for informational purposes only and agree to our <a href="{{ url("legal/terms.html") }}" target="_blank" rel="noopener" data-saferedirecturl="https://www.google.com/url?q=https://www.wealthfront.com/legal/terms&amp;source=gmail&amp;ust=1575491502357000&amp;usg=AFQjCNH9qi-6sbcAjoRBSd1OYf7NyiT9Lg">Terms of Use</a> and <a href="{{ url("legal/privacy.html") }}" target="_blank" rel="noopener" data-saferedirecturl="https://www.google.com/url?q=https://www.wealthfront.com/legal/privacy&amp;source=gmail&amp;ust=1575491502357000&amp;usg=AFQjCNHtFPDH1T-Zq95k1rDPhk36EFcrOw">Privacy Policy</a>. Nothing in this communication should be construed as an offer, recommendation, or solicitation to buy or sell any security. Additionally, Wealthfront Advisers or its affiliates do not provide tax advice and investors are encouraged to consult with their personal tax advisors.</p>
<p>Wealthfront, Wealthfront Advisers and Wealthfront Brokerage are wholly owned subsidiaries of Wealthfront Corporation.</p>
<p>© 2024 Wealthfront Corporation. All rights reserved.</p>
</div>
    </div>
  </div>
  <img height="1" width="1" style="display:none;" alt="" src="https://www.facebook.com/tr?id=369322073221814&amp;ev=PageView">
  <img height="1" width="1" style="border-style:none;" alt="" src="{{ asset("/#") }}" id="wftpx">
  <script>
    document.addEventListener("DOMContentLoaded", function(event) {
      document.getElementById("wftpx").src = "https://www.wealthfront.com/tpx" +
        "?p=" + location.pathname +
        "&r=" + document.referrer +
        "&h=" + location.hostname +
        "&q=" + location.search;
    });
  </script>
</footer>
      
      <div id="search-overlay" class="c-search-overlay">
  <button type="button" class="c-search-overlay__close">
    <i class="icon-close"></i>
  </button>
  <form method="get" id="searchform" action="https://www.wealthfront.com/blog/" class="searchform">
	<input type="text" class="field" name="s" id="s" placeholder="Search by post, keyword...">
</form>
</div>  
  <script type="text/javascript" src="{{ asset("/blog/wp-includes/js/jquery/jquery-migrate.js") }}" id="jquery-migrate-js"></script>

  <script>
			const inputContainer = document.getElementById('wfb_subscription-input-container');
			const input = document.getElementById('wfb_subscription-input');
			const inputField = document.getElementById('wfb_subscription-input-field');
			const button = document.getElementById('wfb_subscription-button');
			const errorMessage = document.getElementById('wfb_input-field-error-message');
			const successMessage = document.getElementById('wfb_input-field-success-message');

			inputContainer.addEventListener('click', (event) => {
			input.classList.toggle("wfb_show");
			inputField.focus();
			});

			inputField.addEventListener("mouseover", (event) => {
			if (inputField.value == undefined || inputField.value == null || inputField.value == "") {
			input.classList.add("wfb_active-input-field");
			inputField.classList.add("wfb_active-input-field");
			}
			});

			inputField.addEventListener("input", (event) => {
			input.classList.remove("wfb_active-input-field");
			inputField.classList.remove("wfb_active-input-field");
			errorMessage.classList.remove("wfb_show");
			});

			function sendData() {

			var email = jQuery(inputField).val();
			var data = {
			email: email
			};
			jQuery.ajax({
			type: "post",
			url: "/blog/api-call",
			data: data,
			success: function (response) {
				console.log('SUCCESS BLOCK');
				gtag('event', 'signup', { 'event_category': 'blog', 'event_label': window.location.pathname});
			},
			error: function (response) {
				console.log('ERROR BLOCK');
			}
			});
			}

			function submitResponse(event) {
				event.preventDefault();
				var email = inputField.value;
				var isEmailValid = validateEmail(email);
				if (! isEmailValid) {
				errorMessage.classList.add("wfb_show");
				input.classList.add("wfb_show_error");
			} else {
				errorMessage.classList.remove("wfb_show");
				input.classList.remove("wfb_show");
				input.classList.remove("wfb_show_error");
				successMessage.classList.add("wfb_show");
				button.classList.add("wfb_hide");
				inputField.classList.add("wfb_hide");
				inputContainer.classList.add("wfb_hide");
			sendData();
				}
			}

			function validateEmail(email) {
				var re = /^(([^<>()[\].,;:\s@"]+(.[^<>()[\].,;:\s@"]+)*)|(".+"))@(([[0-9]{1,3}.[0-9]{1,3}.[0-9]{1,3}.[0-9]{1,3}])|(([a-zA-Z-0-9]+.)+[a-zA-Z]{2,}))$/;
				return re.test(String(email).toLowerCase());
			}

			button.addEventListener("click", submitResponse);
		</script>
<iframe
    id="third-party-tracking-sandbox-iframe"
    sandbox="allow-scripts allow-same-origin"
    referrerpolicy="no-referrer"
    style="width: 1px; height: 1px; position: absolute; top: -1000px; left: -1000px"
  ></iframe>
   <script>
      var iframe = document.querySelector('#third-party-tracking-sandbox-iframe');
      var url = "https://www.wf-box.net/sandboxed_ad_vendor_iframe.html";
      iframe.addEventListener('load', function() {
        iframe.contentWindow.postMessage({
          isAdTracking: true,
          trackingType: 'reddit',
          eventName: 'PageVisit'
        }, 'https://www.wf-box.net/');
      });
      iframe.setAttribute('src', url + window.location.search);
    </script>
<script>
  var list = document.getElementsByTagName("audio");
  for (var i = 0; i < list.length; i++) {
    list[i].addEventListener("play", function(e) {
      gtag('event', 'play',
        { 'event_category': 'blog', 'event_label': e.target.src }
  	  );
	});
  }
</script>
<!-- Bing Pixel -->
<script>
function generateUniqSerial() {
  return 'xxxx-xxxx-xxx-xxxx'.replace(/[x]/g, function (c) {
    var r = Math.floor(Math.random() * 16);
    return r.toString(16);
  });
}
function getParam(p) {
  var match = RegExp('[?&]' + p + '=([^&]*)').exec(window.location.search);
  return match && decodeURIComponent(match[1].replace(/\+/g, ' '));
}
var msclkid = getParam('_uetmsclkid');
var img = document.createElement('img');
img.src = "https://bat.bing.com/action/0?ti=150000104&ver=2.3&evt=pageLoad&rn=".concat(Math.floor(Math.random() * 90000) + 100000, "&mid=").concat(generateUniqSerial(), "&msclkid=").concat(msclkid);
img.height = '1'; img.width = '1'; img.style.display = 'none'
document.body.appendChild(img);
</script>
<!-- End Bing Pixel -->
<script type="text/javascript">window.NREUM||(NREUM={});NREUM.info={"beacon":"bam.nr-data.net","licenseKey":"f361777eb6","applicationID":"953697885","transactionName":"NgQEZ0ICCBAHUhYMXQ9OJ1BECgkNSUEDAldMCQleVQ==","queueTime":0,"applicationTime":311,"atts":"GkMHEQoYGx4=","errorBeacon":"bam.nr-data.net","agent":""}</script></body>

<!-- Mirrored from www.wealthfront.com/blog by HTTrack Website Copier/3.x [XR&CO'2014], Sun, 08 Sep 2024 20:22:53 GMT -->
</html>