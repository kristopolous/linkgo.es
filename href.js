(function(){
  var 
    id = "rt2me$$" + parseInt(Math.random().toString().slice(2), 10).toString(36),
    anchorList,
    size,
    script,
    iframeList = [],
    offset = 0,
    compat = ((window.addEventListener) ?
      ['addEventListener', 'load'] :
      ['attachEvent', 'onload']);

  window[id] = function(obj) {
    var 
      title = obj[0],
      ix = obj[1];

    if(ix == -1) {
      // Give the final batch some time to close.
      setTimeout(function(){
        while(iframeList.length) {
          document.body.removeChild(iframeList[0]);
          iframeList.shift();
        }
        console.log("iframe(s) removed");
        document.body.removeChild(script);
      }, 2000);
      return;
    }

    var pretitle = anchorList[ix].getAttribute('title');

    console.log(title, ix, pretitle);

    if(!pretitle) {
      console.log("setting title", title);
      anchorList[ix].setAttribute('title', title);
    }
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
      'top:-100000px',
      'left:-100000px',
      'width:1px',
      'height:1px'
    ].join(';'));

    document.body.appendChild(iframe);

    var 
      batchurl = '//rt2.me/batch.php?offset=' + offset;
      doc = iframe.contentDocument || iframe.contentWindow.document,
      form = doc.body.appendChild(doc.createElement('form')),
      tarea = form.appendChild(doc.createElement('textarea')),
      func = form.appendChild(doc.createElement('input'));

    if(offset == 0) {
      batchurl += "&total=" + anchorList.length;
    } 

    form.setAttribute('action', batchurl);
    form.method = 'post';

    tarea.name = 'url';
    func.name = 'func';

    tarea.innerHTML = urlList.join("\n");
    func.value = id;

    form.submit();
  }

  window[compat[0]](compat[1], function(){
    script = document.createElement('script');
    script.setAttribute('type', 'text/javascript');
    script.src = '//rt2.me:8000/hrefresults.php?c=' + id;
    document.body.appendChild(script);

    anchorList = Array.prototype.slice.call(document.getElementsByTagName("a"));

    // parallelize it.
    size = Math.max(Math.floor(anchorList.length / 10), 5);

    var 
      ix = 0,
      ival = setInterval(function() {
        if(ix < anchorList.length) {
          process(ix);
          ix += size;
        } else {
          clearInterval(ival);
        }
      }, 500);
  }, false);

})();
