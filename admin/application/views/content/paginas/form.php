<h1 class="ls-title-intro {icon_titulo}">{titulo}</h1>

<form id="postForm" action="{action}" method="post" class="ls-form row">
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
                <b class="ls-label-text">Língua</b>
                <div class="ls-custom-select">
                    <select name="lang" class="ls-select" required>
                        <option value="">Selecione...</option>
                        <option value="br" {selected_br}>Português</option>
                        <option value="es" {selected_es}>Espanhol</option>
                        <option value="en" {selected_en}>Inglês</option>
                    </select>
                </div>
            </label>
            <div class="ls-clearfix"></div>
            <br>
            <div align="center">
                <a href="{deletar}" {disabled} class="ls-float-left ls-btn-primary ls-btn-lg">Excluir</a>
                <button type="submit" class="ls-float-right ls-btn-success ls-btn-lg">Salvar</button>
            </div>
        </div>
    </div>
</form>