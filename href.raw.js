(function(){
  var 
    id = "rt2me$$" + Math.random(),
    anchorList,
    size,
    script,
    iframeList = [],
    compat = ((window.addEventListener) ?
      ['addEventListener', 'load'] :
      ['attachEvent', 'onload']);

  window[id] = function(obj) {
    while(obj.length) {
      var 
        entry = obj.pop(),
        title = entry[0],
        ix = entry[1];

      if(! anchorList[ix].getAttribute('title') ) {
        anchorList[ix].setAttribute('title', title);
      }
    }

    // Give the final batch some time to close.
    setTimeout(function(){
      while(iframeList.length) {
        document.body.removeChild(iframeList[0]);
        iframeList.shift();
      }
      document.body.removeChild(script);
    }, 2000);
  }

  function process(offset) {
    var 
      iframe = document.createElement('iframe'),
      urlList = [];

    iframeList.push(iframe);

    for(var ix = 0; ix < size && (ix + offset) < anchorList.length; ix++) {
      urlList.push(anchorList[ix + offset].href);
    }

    iframe.setAttribute('style', [
      'position:absolute',
      'top:-10000px',
      'left:-10000px'
    ].join(';'));

    document.body.appendChild(iframe);

    var 
      batchurl = 'http://rt2.me/batch.php?o=' + offset;
      doc = iframe.contentDocument || iframe.contentWindow.document,
      form = doc.body.appendChild(doc.createElement('form')),
      tarea = form.appendChild(doc.createElement('textarea')),
      func = form.appendChild(doc.createElement('input'));

    if(!offset) {
      batchurl += "&t=" + anchorList.length;
    } 

    form.action = batchurl;
    form.method = 'post';

    tarea.name = 'u';
    tarea.innerHTML = urlList.join("\n");

    func.name = 'f';
    func.value = id;

    form.submit();
  }

  window[compat[0]](compat[1], function(){
    script = document.createElement('script');
    script.setAttribute('type', 'text/javascript');
    script.src = 'http://rt2.me/hrefresults.php?c=' + id;
    document.body.appendChild(script);

    anchorList = document.getElementsByTagName("a");

    // parallelize it.
    size = Math.max(Math.floor(anchorList.length / 10), 15);

    for( var ix = 0; ix < anchorList.length; ix += size;) {
      process(ix);
    }
  }, false);

})();
