<input type="hidden" name="formid" value="remodalcontactform">
<input name="name" class="pure-input-1{{ $data['name.errorClass'] }}{{ $data['name.requiredClass'] }}" required="required" placeholder="Имя" title="Укажите Ваше имя. Поле обязательно для заполнения" type="text" value="{{ $data['name.value'] }}">
<input name="email" class="pure-input-1{{ $data['email.errorClass'] }}{{ $data['email.requiredClass'] }}" required="required" placeholder="E-mail" title="Укажите адрес Вашей электронной почты" type="text" value="{{ $data['email.value'] }}">
<input name="phone" class="phone-input pure-input-1{{ $data['phone.errorClass'] }}{{ $data['phone.requiredClass'] }}" placeholder="+7 (___)" title="Укажите Ваш контакнтый телефон. Поле обязательно для заполнения" type="text" value="{{ $data['phone.value'] }}">
<textarea name="comment" class="pure-input-1" rows="4" placeholder="Текст заказа" title="Текст заказа">{{ $data['comment.value'] }}</textarea>
<div class="dropzone okhide" id="contact-file">
    <div class="dz-default dz-message">
        <div>Файлы</div>
        Если Вам нужно отправить нам макет,<br>
        <span>загрузите файлы</span><br>
        или просто перетащите их в это поле
    </div>
</div>
<label class="privacy">
    <input name="privacy" class="{{ $data['privacy.errorClass'] }}{{ $data['privacy.requiredClass'] }}" type="checkbox" value="yes" required="required">
    <span>Настоящим подтверждаю, что я ознакомлен и согласен с условиями<br><a href="[~[*id*]~]#privacy-policy-modal">политики конфиденциальности</a></span>
</label>
<div class="form-group col-md-6 {{ $data['g-recaptcha-response.errorClass'] }} {{ $data['g-recaptcha-response.requiredClass'] }}" >
    {{ $data['captcha'] }}
    {{ $data['g-recaptcha-response.error'] }}
</div>