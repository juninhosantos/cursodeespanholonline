(function(App,$){

    App.methods = App.methods || {
        
        _init:function(){
            App.methods._click();
            App.methods._load();
                       
        },

        _click:function(){
            $(document).ready(function(){
                $(".delete").click(function(){
                    var con = confirm("Deseja realmente excluir este item?");
                    if(con){
                        return true;
                    }

                    return false;
                });

                $("#postForm").on('click','.removeDestaque',function(){
                    $("#inputFoto").val('');
                    $("#destacada_preview").attr('src','').addClass("ls-display-none");
                    var parent = $(this).parent();
                    $(this).remove();
                    $("#file_upload").show();
                });

                $('.delete-image').on('click',function() {
                    var id = $(this).attr('data-id');

                    $.ajax({
                        url: App.methods.base_url()+'slides/removeImagem',
                        data: 'id=' + id,
                        type: 'POST',
                        success: function (data) {
                            console.log(data);
                            $('#image-' + id).fadeOut(function () {
                                $(this).remove();
                            });
                        }
                    });

                    return false;
                }); 

            });

        },
        

        base_url:function(){
            var base = $("#base_url").html();
            return base;
        },

        site_url:function(){
            var base = $("#site_url").html();
            return base;
        },

        _load:function(){ 
            $(document).ready(function(){
                locastyle.datepicker.init();

                App.methods.configCkfinder();
                App.methods.toggleLang();
                App.methods.uploadify();
                App.methods.sortableSlides();

                $('.money').maskMoney({decimal:",",thousands:"."});
            })
        },

        configCkfinder:function(){
            if($("#editor").length ){
                var editor = CKEDITOR.replace( 'editor',{
                    customConfig: App.methods.base_url()+'assets/javascripts/config-ckeditor.js',
                    filebrowserBrowseUrl: App.methods.base_url()+'assets/javascripts/ckfinder/ckfinder.html',
                    filebrowserImageBrowseUrl: App.methods.base_url()+'assets/javascripts/ckfinder/ckfinder.html?Type=Images',
                    filebrowserUploadUrl: App.methods.base_url()+'assets/javascripts/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files',
                    filebrowserImageUploadUrl: App.methods.base_url()+'assets/javascripts/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images',
                    filebrowserWindowWidth : '1000',
                    filebrowserWindowHeight : '700'
                } );
            }
        },

        toggleLang:function(){
            if($('select[name=lang] option:selected').val() != ""){
                var _lang = $('select[name=lang] option:selected').val();
                $('select[name=lang]').change(function(){
                    
                    $("#postForm .ls-btn-lg").attr('disabled','disabled').attr('href','').addClass("ls-disabled");

                    var lang = $(this).val();
                    var url = window.location.href;
                    url = url.replace("/?lang="+_lang,"");
                    url += "/?lang="+lang;

                    location.href = url;
                })
            }
        },

        uploadify:function(){
                        
            $('#file_upload').uploadify({
                'swf': App.methods.base_url() + 'assets/javascripts/uploadify/uploadify.swf',
                'uploader': App.methods.base_url() + 'assets/javascripts/uploadify/uploadify.php?base_url='+App.methods.base_url(),
                'buttonImage': App.methods.base_url() + 'assets/javascripts/uploadify/bt.png',
                'onUploadComplete': function (file) {
                    //console.log('Complete file ' + file.name + ' finished processing.');
                },
                'onUploadSuccess': function (file, data, response) {
                    if(App.methods.site_url() != "slides"){
                        $("#destacada_preview").attr('src',App.methods.base_url()+"arquivos/"+data).removeClass("ls-display-none");
                        $("#inputFoto").val(data);
                        var parent = $("#file_upload").parent();
                        $("#file_upload").hide();
                        parent.append("<a href='#' class='removeDestaque'>Remover destaque</a>");
                    }else{
                        var lingua = App.methods._urlParam('lang');

                        if(!App.methods._urlParam('lang')){
                            lingua = 'br';
                        }

                        $.ajax({
                            url: App.methods.base_url() + 'slides/salvarFoto/'+lingua,
                            data: {foto:data},
                            type: 'POST',
                            success: function (data, textStatus, jqXHR) {
                                location.reload();
                            }
                        });
                        

                    }
                },
                'onUploadError': function (file, errorCode, errorMsg, errorString) {
                    //console.log('Não foi possível fazer o upload do arquivo:' + file.name + ' - ' + errorString);
                }
            });

            if(!$("#destacada_preview").hasClass('ls-display-none') && App.methods.site_url() != "slides" ){
                var parent = $("#file_upload").parent();
                $("#file_upload").hide();
                parent.append("<a href='#' class='removeDestaque'>Remover destaque</a>");
            }
        },

        sortableSlides:function(){
            var lingua = App.methods._urlParam('lang');

            if(!App.methods._urlParam('lang')){
                lingua = 'br';
            }
            
            $("#gallery-preview").sortable({
                update: function () {
                    var data = $('#slideshow').serialize();
                    
                    $.ajax({
                        url: App.methods.base_url() + 'slides/reorder/'+lingua,
                        data: data,
                        type: 'POST',
                        success: function (data, textStatus, jqXHR) {
                            console.log(data);
                        }
                    });
                }
            });
            $("#gallery-preview").disableSelection();
        },

        _urlParam:function(name){
            var results = new RegExp('[\?&]' + name + '=([^&#]*)').exec(window.location.href);
            if (results==null){
            return null;
            }
            else{
            return results[1] || 0;
            }
        },

        getCurso:function(curso){

            if(curso.value != 0){

                $.post(App.methods.base_url()+'alunos/getCurso/'+curso.value,{})
                .done(function(data){
                    data = JSON.parse(data);
                    $("input[name=horas]").val(data[0].horas);
                    $("select[name=tipo] option").removeAttr('selected');
                    $("select[name=tipo] option[value=pacote]").attr('selected','selected');
                })

            }else{
                $("select[name=tipo] option").removeAttr('selected');
                $("select[name=tipo] option[value=avulso]").attr('selected','selected');
            }
        }              

        
    };

    App.methods._init();

})(window.App = window.App || {},jQuery);