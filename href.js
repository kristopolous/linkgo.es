(function(){var f="rt2me$$"+parseInt((""+Math.random()).slice(2),10).toString(36),b,k,a,g=[],h=window.addEventListener?["addEventListener","load"]:["attachEvent","onload"];window[f]=function(c){var f=c[0],d=c[1];-1==d?setTimeout(function(){for(;g.length;)document.body.removeChild(g[0]),g.shift();document.body.removeChild(a)},2E3):(c=b[d].getAttribute("title"))||b[d].setAttribute("title",f)};window[h[0]](h[1],function(){a=document.createElement("script");a.setAttribute("type","text/javascript");a.src=
"//rt2.me/hrefresults.php?c="+f;document.body.appendChild(a);b=Array.prototype.slice.call(document.getElementsByTagName("a"));k=Math.max(Math.floor(b.length/10),15);var c=0,h=setInterval(function(){if(c<b.length){var d=c,a=document.createElement("iframe"),l=[];g.push(a);for(var e=0;e<k&&e+d<b.length;e++)l.push(b[e+d].href);a.setAttribute("style","position:absolute;top:-10000px;left:-10000px");document.body.appendChild(a);e="//rt2.me/batch.php?o="+d;doc=a.contentDocument||a.contentWindow.document;
form=doc.body.appendChild(doc.createElement("form"));tarea=form.appendChild(doc.createElement("textarea"));func=form.appendChild(doc.createElement("input"));d||(e+="&t="+b.length);form.action=e;form.method="post";tarea.name="u";tarea.innerHTML=l.join("\n");func.name="f";func.value=f;form.submit();c+=k}else clearInterval(h)},500)},!1)})();