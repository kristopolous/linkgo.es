(function(){
  var 
    compat = ((window.addEventListener) ?
      ['addEventListener', 'load'] :
      ['attachEvent', 'onload']),
    anchorList,
    list,
    iframe;

  function cb(title, ix) {
    var pretitle = anchorList[ix].getAttribute('title');
    console.log(title, ix, pretitle);
    if(!pretitle) {
      console.log("setting title", title);
      anchorList[ix].setAttribute('title', title);
    }
    if(ix == anchorList.length) {
      console.log("iframe removed");
      document.body.removeChild(iframe);
    }
  }

  window[compat[0]](compat[1], function(){
    anchorList = document.getElementsByTagName("a");
    list = "rt2me$$" + parseInt(Math.random().toString().slice(2), 10).toString(36);
    iframe = document.createElement('iframe');
    ix;

    top[list] = {urlList:[], cb: cb};

    for(var ix = 0; ix < anchorList.length; ix++) {
      top[list].urlList.push(anchorList[ix].href);
    }

    iframe.setAttribute('style', [
      'position:absolute',
      'top:-100000px',
      'left:-100000px',
      'width:1px',
      'height:1px'
    ].join(';'));

    iframe.src="//rt2.me/batchload.html?" + list;

    document.body.appendChild(iframe);
  }, false);

})();
