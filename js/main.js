var pendingTask = false;
var addedFiles = Array();

 
myMarkdownSettings = {
    nameSpace:          'markdown',
    onShiftEnter:       {keepDefault:false, openWith:'\n\n'},
    markupSet: [
        {name:'Titre 1', key:"1", placeHolder:'Votre titre ici...', closeWith:function(markItUp) { return miu.markdownTitle(markItUp, '=') } },
        {name:'Titre 2', key:"2", placeHolder:'Votre titre ici...', closeWith:function(markItUp) { return miu.markdownTitle(markItUp, '-') } },
        {name:'Titre 3', key:"3", openWith:'### ', placeHolder:'Votre titre ici...' },
        {name:'Titre 4', key:"4", openWith:'#### ', placeHolder:'Votre titre ici...' },
        {name:'Titre 5', key:"5", openWith:'##### ', placeHolder:'Votre titre ici...' },
        {name:'Titre 6', key:"6", openWith:'###### ', placeHolder:'Votre titre ici...' },
        {separator:'---------------' },        
        {name:'Gras', key:"G", openWith:'**', closeWith:'**'},
        {name:'Italique', key:"I", openWith:'_', closeWith:'_'},
        {separator:'---------------' },
        {name:'Liste � bulles', openWith:'- ' },
        {name:'Liste num�rique', openWith:function(markItUp) {
            return markItUp.line+'. ';
        }},
        {name:'Image', key:"P", replaceWith:'![[![Alternative text]!]]([![Url:!:http://]!] "[![Title]!]")'},
        {name:'Lien', key:"L", openWith:'[', closeWith:']([![Url:!:http://]!] "[![Title]!]")', placeHolder:'Your text to link here...' },  
        {name:'Citation', openWith:'> '},
        {name:'Code', openWith:'(!(\t|!|`)!)', closeWith:'(!(`)!)'},
    ]
}

// mIu nameSpace to avoid conflict.
miu = {
    markdownTitle: function(markItUp, char) {
        heading = '';
        n = $.trim(markItUp.selection||markItUp.placeHolder).length;
        for(i = 0; i < n; i++) {
            heading += char;
        }
        return '\n'+heading+'\n';
    }
}


$(document).ready(function(){

    $(document).ajaxStop(function(){
        $('#global-preloader').fadeOut(200);
    });

    $(document).ajaxStart(function(){
        $('#global-preloader').show();
    });

	init();

    $.getJSON($("#UPDATE_URL").html(),function(data){
    });


	$('#uploadButton').fileupload({
        dataType: 'json',
        autoUpload: true,
        dropZone : '#uploadButton',
        maxFileSize: 5000000,
        sequentialUploads: true,
        add: function (e, data) {
			pendingTask = true;
        	data.submit();
			console.log('ajout de fichiers',data.files[0].name);
            var tpl = $('<li><img src="img/icon-file.png" align="absmiddle"> '+data.files[0].name+'<div class="progressBloc"><progress value="0" max="100"></progress></div></li>');
            $.data(data.files[0],tpl);
			$('#file-list').prepend(tpl);
            console.log('add');
        },
        done: function (e, data) {
			$.data(data.files[0]).find('.progressBloc').fadeOut(300);
            console.log(data.files[0].name+' fichier termin�');
        },
       	stop: function (e, data) {
			pendingTask = false;
			loadFiles();
			console.log('tous les uploads termines');
       	},
        progress: function (e, data) {
	       var progress = parseInt(data.loaded / data.total * 100, 10);
            $.data(data.files[0]).find('progress').val(progress);
			console.log('progression upload '+progress+'%');
    	}
    });

});


    function maj(data){
    server = data.maj;
        if(server.version!=null && server.version!=$("#APPLICATION_VERSION").html()){
            $('#logo span').addClass('label').attr('title','Version '+server.version+' disponible.');;
            if(server.link != null) $('#logo').attr('onclick','window.location="'+server.link+'";');
        }
    }

function init(){

    var zenMode = false;
    $(window).resize(function(){
        zenMode = $(window).width()<=540;
    });
    
        var deactivate;
        if(zenMode){
        $('#menu-container').hover(function(){
                clearInterval(deactivate);
                $('#menu-container').animate({opacity:1},100);  

        },function(){
                deactivate = setTimeout(function(){
                     $('#menu-container').animate({opacity:0},100);  
                },10000);
               

        });
    }

    loadMenu();
    loadFiles();
	loadLogin();
    $('#search-input').keyup(function(e){
        if(e.keyCode == 13)
        {
            loadFiles($('#search-input').val());
        }
    });
    $('code').litelighter({});
    $('code').litelighter('destroy');
    $('code').litelighter({style:'monokai'});



}

function appendText(text){
  /*  var oldText = $('#content').val();
    $('#content').val(oldText + text);*/
    insertAtCaret('content',text);
}

function login(){
	$.ajax({
        type: "POST",
        url: 'action.php',
        dataType:"json",
        data:{action:'login',login:$('#input-login').val(),password:$('#input-password').val()},
        success: function(result){
            if(result.success){
                loadLogin();
                init();
            }else{
                alert(result.message);
            }
        }});
}

function disconnect(){
    $.ajax({
        type: "POST",
        url: 'action.php',
        data:{action:'logout'},
        success: function(result){
            loadLogin();
            init();
        }});
}

function loadLogin(){
    $('#option-login').load('./action.php?action=loginBar',function(){
            $('#input-password').enter(login);
    });

}


function loadMenu(){
    $('#menu').load('./action.php?action=menu');
}
function loadFiles(keyword){
     $('#file-list').load('./action.php?action=files'+(keyword!=null?'&keyword='+keyword:''));
}

function addImage(filePath){
    insertAtCaret('content','![id]('+filePath+')');
    // $('#content').html($('#content').html()+'![id]('+filePath+')');
}
function addFile(filePath){
    insertAtCaret('content','['+filePath+']('+filePath+')');
     //$('#content').html($('#content').html()+'['+filePath+']('+filePath+')');
}

function save(page,elem,target){
        $.ajax({
        type: "POST",
        dataType: "json",
        url: 'action.php',
        data:{action:'save',page:page,content:$('#'+target).val()},
        success: function(result){
            if(result.success){
    			$('#'+target).markItUp('remove');
                $('#'+target).replaceWith('<div id="'+target+'"></div>')
                $('#'+target).html(result.content);
                $(elem).attr('onclick','edit(\''+page+'\',this,\''+target+'\');').html("Editer");
                $('#drop-container,#file-list,#search-zone').fadeOut(300);
                init();
            }else{
                message(result.message);
            }
        }});
}

function deleteFile(file,target){
    if(confirm('Vraiment ?')){
    $.ajax({
        type: "POST",
        dataType: 'json',
        url: 'action.php',
        data:{action:'deleteFile',file:file},
        success: function(result){
            if(result.success){
                $(target).parent().fadeOut(400);
            }else{
                alert(result.message);
            }
        }});
    }
}


function edit(page,elem,target){
        target = target==null?'content':target;
        $.ajax({
        type: "POST",
        dataType: "json",
        url: 'action.php?action=edit&page='+page,
        success: function(result){
            if(result.success){
                $('#'+target).replaceWith('<textarea id="'+target+'"></textarea>');
                $('#'+target).html(result.content);
                $(elem).attr('onclick','save(\''+page+'\',this,\''+target+'\');').html("Enregistrer");
    			if(target!='menu') $('#'+target).markItUp(myMarkdownSettings);
                $('#drop-container,#file-list,#search-zone').fadeIn(300);
                $('#content').keydown(function(event){
                if(event.keyCode == 9){
                    insertAtCaret('content','\t');
                    return false;
                }
                });
            }else{
                message(result.message);
            }
        }});
}


function message(msg){
    //TODO - remplacer par une dialog box plus sympa
    alert(msg);
}

function checkPendingTask(){
	console.log('fermeture navigateur');
}

function array2json(arr) {
    var parts = [];
    var is_list = (Object.prototype.toString.apply(arr) === '[object Array]');

    for(var key in arr) {
    	var value = arr[key];
        if(typeof value == "object") { //Custom handling for arrays
            if(is_list) parts.push(array2json(value)); /* :RECURSION: */
            else parts[key] = array2json(value); /* :RECURSION: */
        } else {
            var str = "";
            if(!is_list) str = '"' + key + '":';

            //Custom handling for multiple data types
            if(typeof value == "number") str += value; //Numbers
            else if(value === false) str += 'false'; //The booleans
            else if(value === true) str += 'true';
            else str += '"' + value + '"'; //All other things
            // :TODO: Is there any more datatype we should be in the lookout for? (Functions?)

            parts.push(str);
        }
    }
    var json = parts.join(",");
    
    if(is_list) return '[' + json + ']';//Return numerical JSON
    return '{' + json + '}';//Return associative JSON
}

function insertAtCaret(areaId,text) {
    var txtarea = document.getElementById(areaId);
    var scrollPos = txtarea.scrollTop;
    var strPos = 0;
    var br = ((txtarea.selectionStart || txtarea.selectionStart == '0') ? 
        "ff" : (document.selection ? "ie" : false ) );
    if (br == "ie") { 
        txtarea.focus();
        var range = document.selection.createRange();
        range.moveStart ('character', -txtarea.value.length);
        strPos = range.text.length;
    }
    else if (br == "ff") strPos = txtarea.selectionStart;

    var front = (txtarea.value).substring(0,strPos);  
    var back = (txtarea.value).substring(strPos,txtarea.value.length); 
    txtarea.value=front+text+back;
    strPos = strPos + text.length;
    if (br == "ie") { 
        txtarea.focus();
        var range = document.selection.createRange();
        range.moveStart ('character', -txtarea.value.length);
        range.moveStart ('character', strPos);
        range.moveEnd ('character', 0);
        range.select();
    }
    else if (br == "ff") {
        txtarea.selectionStart = strPos;
        txtarea.selectionEnd = strPos;
        txtarea.focus();
    }
    txtarea.scrollTop = scrollPos;
}