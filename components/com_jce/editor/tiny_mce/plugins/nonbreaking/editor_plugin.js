/* JCE Editor - 2.5.29 | 14 October 2016 | http://www.joomlacontenteditor.net | Copyright (C) 2006 - 2016 Ryan Demmer. All rights reserved | © Copyright, Moxiecode Systems AB | http://www.tinymce.com/license */
(function(){tinymce.create('tinymce.plugins.Nonbreaking',{init:function(ed,url){var t=this;t.editor=ed;ed.addCommand('mceNonBreaking',function(){ed.execCommand('mceInsertContent',false,(ed.plugins.visualchars&&ed.plugins.visualchars.state)?'<span data-mce-bogus="1" class="mceItemHidden mceItemNbsp">&nbsp;</span>':'&nbsp;');});ed.addButton('nonbreaking',{title:'nonbreaking.desc',cmd:'mceNonBreaking'});if(ed.getParam('nonbreaking_force_tab')){ed.onKeyDown.add(function(ed,e){if(e.keyCode==9){e.preventDefault();ed.execCommand('mceNonBreaking');ed.execCommand('mceNonBreaking');ed.execCommand('mceNonBreaking');}});}
ed.addShortcut('ctrl+shift+s','nonbreaking.desc','mceNonBreaking');},getInfo:function(){return{longname:'Nonbreaking space',author:'Moxiecode Systems AB',authorurl:'http://tinymce.moxiecode.com',infourl:'http://wiki.moxiecode.com/index.php/TinyMCE:Plugins/nonbreaking',version:tinymce.majorVersion+"."+tinymce.minorVersion};}});tinymce.PluginManager.add('nonbreaking',tinymce.plugins.Nonbreaking);})();