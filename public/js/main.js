jQuery.fn.highlight=function(c){function e(b,c){var d=0;if(3==b.nodeType){var a=b.data.toUpperCase().indexOf(c),a=a-(b.data.substr(0,a).toUpperCase().length-b.data.substr(0,a).length);if(0<=a){d=document.createElement("span");d.className="highlight";a=b.splitText(a);a.splitText(c.length);var f=a.cloneNode(!0);d.appendChild(f);a.parentNode.replaceChild(d,a);d=1}}else if(1==b.nodeType&&b.childNodes&&!/(script|style)/i.test(b.tagName))for(a=0;a<b.childNodes.length;++a)a+=e(b.childNodes[a],c);return d} return this.length&&c&&c.length?this.each(function(){e(this,c.toUpperCase())}):this};jQuery.fn.removeHighlight=function(){return this.find("span.highlight").each(function(){this.parentNode.firstChild.nodeName;with(this.parentNode)replaceChild(this.firstChild,this),normalize()}).end()};
$(function(){

  $(document).scroll(function(){
      var top=$(this).scrollTop();
      if(top<180){
        var dif=1-top/180;
        $(".navbar-image").css({opacity:dif});
        $(".navbar-image").show();
        $(".navbar-material-blog .navbar-wrapper").css({'padding-top': '180px'});
        $(".navbar-material-blog").removeClass("navbar-fixed-top");
        $(".navbar-material-blog").addClass("navbar-absolute-top");
      }
      else {
        $(".navbar-image").css({opacity:0});
        $(".navbar-image").hide();
        $(".navbar-material-blog .navbar-wrapper").css({'padding-top': 0});
        $(".navbar-material-blog").removeClass("navbar-absolute-top");
        $(".navbar-material-blog").addClass("navbar-fixed-top");
      }
  });

  $("a[href*=#]").click(function(e) {
    e.preventDefault();
  });

  $("img").addClass('img-responsive');
});