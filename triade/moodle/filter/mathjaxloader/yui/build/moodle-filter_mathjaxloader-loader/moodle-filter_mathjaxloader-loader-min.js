YUI.add("moodle-filter_mathjaxloader-loader",function(n,e){M.filter_mathjaxloader=M.filter_mathjaxloader||{_lang:"",_configured:!1,configure:function(e){var t=document.createElement("script");t.type="text/x-mathjax-config",t[window.opera?"innerHTML":"text"]=e.mathjaxconfig,document.getElementsByTagName("head")[0].appendChild(t),this._lang=e.lang,n.on(M.core.event.FILTER_CONTENT_UPDATED,this.contentUpdated,this)},_setLocale:function(){var e;this._configured||(e=this._lang,"undefined"!=typeof window.MathJax&&(window.MathJax.Hub.Queue(function(){window.MathJax.Localization.setLocale(e)}),window.MathJax.Hub.Configured(),this._configured=!0))},typeset:function(){var e;this._configured||(e=this,n.use("mathjax",function(){e._setLocale(),n.all(".filter_mathjaxloader_equation").each(function(e){"undefined"!=typeof window.MathJax&&window.MathJax.Hub.Queue(["Typeset",window.MathJax.Hub,e.getDOMNode()])})}))},contentUpdated:function(t){var a=this;n.use("mathjax",function(){var e;"undefined"!=typeof window.MathJax&&(e=window.MathJax.Hub.processSectionDelay,window.MathJax.Hub.processSectionDelay=0,window.MathJax.Hub.Config({positionToHash:!1}),a._setLocale(),t.nodes.each(function(e){e.all(".filter_mathjaxloader_equation").each(function(e){window.MathJax.Hub.Queue(["Typeset",window.MathJax.Hub,e.getDOMNode()])})}),window.MathJax.Hub.processSectionDelay=e)})}}},"@VERSION@",{requires:["moodle-core-event"]});