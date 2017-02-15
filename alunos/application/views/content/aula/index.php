<h1 class="ls-title-intro">Agendamento</h1>

<div class="ls-list">
  <header class="ls-list-header">
    <div class="col-md-9">
      <div class="ls-list-title ">
        <a href="#"><?= @$curso ?></a>
      </div>
      <div class="ls-list-description">
        <br>
          <p>Qual melhor horário para você?</p>
          <p>Selecione aqui o melhor dia e horário para a sua aula. Após enviado, aguardar as informações do seu professor.</p>
          <br>
          <br>
          <form class="ls-form ls-form-horizontal row" method="post" action="" id="horario" data-ls-module="form">
            <fieldset>
                <label class="ls-label col-md-4">
                    <b class="ls-label-text">Dia:</b>
                    <div class="ls-custom-select">
                        <select class="ls-custom" name="dia">
                            <option value="1">Domingo</option>
                            <option value="1">Segunda</option>
                            <option value="1">Terla</option>
                            <option value="1">Quarta</option>
                            <option value="1">Quinta</option>
                            <option value="1">Sexta</option>
                            <option value="1">Sábado</option>
                        </select>
                    </div>
                </label>
                <label class="ls-label col-md-3">
                    <b class="ls-label-text">Início</b>
                    <input type="text" name="hora_inicio" class="ls-mask-time" required >
                </label>
                <label class="ls-label col-md-3">
                    <b class="ls-label-text">Final</b>
                    <input type="text" name="hora_final" class="ls-mask-time" required >
                </label>
                <label class="ls-label col-md-2">
                    <button id="" class="ls-btn">SALVAR</button>
                </label>
            </fieldset>
          </form>
      </div>
    </div>
</div>