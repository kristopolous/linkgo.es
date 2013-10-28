(function(){
  var 
    id = "rt2me$" + Math.random(),
    anchorList = [],
    size,
    script,
    iframeList = [],
    ival;

  window[id] = function(obj) {
    for(var ix in obj) {
      var title = obj[ix];
      ix = parseInt(ix);
      anchorList[ix].title = anchorList[ix].title || title;
    }

    // Give the final batch some time to close.
    setTimeout(function(){
      while(iframeList.length) {
        document.body.removeChild(iframeList.shift());
      }
      document.body.removeChild(script);
    }, 2000);
  }

  function process(offset) {
    var 
      iframe = document.createElement('iframe'),
      urlList = [id];

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
      tarea = form.appendChild(doc.createElement('textarea'));

    if(!offset) {
      batchurl += "&t=" + anchorList.length;
    } 

    form.action = batchurl;
    form.method = 'post';

    tarea.name = 'u';
    tarea.innerHTML = urlList.join("\n");

    form.submit();
  }

  // this seems to work better than the onready like handlers
  ival = setInterval(function(){
    try {
      anchorList = document.getElementsByTagName("a");
    } catch(ex) { }

    if(anchorList.length) {
      clearInterval(ival);
      script = document.createElement('script');
      script.setAttribute('type', 'text/javascript');
      script.src = 'http://rt2.me/hrefresults.php?c=' + id;
      document.body.appendChild(script);

      // parallelize it.
      size = Math.max(Math.floor(anchorList.length / 10), 15);

      for( var ix = 0; ix < anchorList.length; ix += size) {
        process(ix);
      }
    }
  }, 100);

})();
