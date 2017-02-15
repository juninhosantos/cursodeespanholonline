<h1 class="ls-title-intro {icon_titulo}">{titulo}</h1>

<form id="postForm" action="{action}" method="post" class="ls-form row " data-ls-module="form" enctype="multipart/form-data">
    <div class="col-md-9">
        <fieldset>
            <label class="ls-label">
                <b class="ls-label-text">Título:</b>
                <input type="text" name="titulo" value="{titulo_txt}" required>
            </label>
            <label class="ls-label">
                <b class="ls-label-text">Texto:</b>
                <textarea name="texto" id="editor" rows="4">{texto_txt}</textarea>
            </label>
        </fieldset>        
    </div>
    <div class="col-md-3 ls-theme-green">
        <div class="ls-box ls-box-gray">
            <label class="ls-label">
                <b class="ls-label-text">Data:</b>
                <input type="text" name="data" class="ls-mask-date"  value="{data}" placeholder="dd/mm/yyyy">
            </label>
                        
            <div class="ls-clearfix"></div>
            <br>
            <div align="center">
                <a href="{deletar}" {disabled} class="ls-float-left ls-btn-primary ls-btn-lg">Excluir</a>
                <button type="submit" class="ls-float-right ls-btn-success ls-btn-lg">Salvar</button>
            </div>
        </div>
    </div>
    
     <div class="col-md-3 ls-theme-green" style="margin-top:20px">
        <div class="ls-box ls-box-gray">
            <label class="ls-label">
                <b class="ls-label-text">Imagem Destacada:</b>
                <br>
                <img src="{imagem}" id="destacada_preview" alt="" class="{imgClass}" style="max-width:100%">
                <input id="inputFoto" type="hidden" name="foto" value="">
                <br><br>
                
                <div align="center">
                    <div id="file_upload"></div>
                </div>
            </label>
        </div>
    </div>
</form>