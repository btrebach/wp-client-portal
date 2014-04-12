$('#searchfor').keyup(function(){
         var page = $('#all_text');
         var pageText = page.text().replace("<span>","").replace("</span>");
         var searchedText = $('#searchfor').val();
         var theRegEx = new RegExp("("+searchedText+")", "igm");    
         var newHtml = pageText.replace(theRegEx ,"<span>$1</span>");
         page.html(newHtml);
    });