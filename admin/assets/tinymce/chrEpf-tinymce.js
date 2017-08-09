(function() {
    tinymce.create('tinymce.plugins.CHR.Epf', {
        init : function(ed, url) {
            ed.addButton('showEpf', {
                title : 'Easy Page Flip',
                image : url + '/icon-magazine.png',
                onclick : function() {
                    tb_show( "Insert Easy Page Flip", url+ "/../tinymce/chrEpf-tinymce-page.php?a=a&width=670&height=400");
                }
            });
        },
        createControl : function(n, cm) {
            return null;
        },
        getInfo : function() {
            return {
                longname : "Easy Page Flip",
                author : 'CHR Designer',
                authorurl : 'http://www.chrdesigner.com/',
                infourl : 'http://www.chrdesigner.com/demo/',
                version : "1.1.1"
            };
        }
    });
    tinymce.PluginManager.add('chrEpf', tinymce.plugins.CHR.Epf);
})();