function rt2(urlToConvert, /* function */ callback /* ( converted url ) */) {
  // if this is a string, then this is the result.
  if(!!(callback === '' || (callback && callback.charCodeAt && callback.substr)) {
    if (rt2.cb[urlToConvert])  {
      rt2.cb[urlToConvert](callback);
      delete rt2.cb[urlToConvert]);
    } 
  } else {

    // register this callback to be used for this conversion
    rt2.cb[urlToConvert] = callback;

    // otherwise this should be registered.
    if(rt2.scr) {
      document.body.removeChild(rt2.scr);
    }
    var scr = rt2.scr = document.createElement('script'); 
    scr.src = "http://js.rt2.me/" + escape(urlToConvert);
    document.body.insertChild(scr);
  }
}
rt2.cb = {};
