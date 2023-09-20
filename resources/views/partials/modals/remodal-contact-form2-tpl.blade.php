<input type="hidden" name="formid" value="remodalcontactform2">
<input name="name" class="pure-input-1{{ $data['name.errorClass'] }}{{ $data['name.requiredClass'] }}" required="required" placeholder="Имя" title="Укажите Ваше имя. Поле обязательно для заполнения" type="text" value="{{ $data['name.value'] }}">
<input name="email" class="pure-input-1{{ $data['email.errorClass'] }}{{ $data['email.requiredClass'] }}" required="required" placeholder="E-mail" title="Укажите адрес Вашей электронной почты" type="text" value="{{ $data['email.value'] }}">
<input name="phone" class="phone-input pure-input-1{{ $data['phone.errorClass'] }}{{ $data['phone.requiredClass'] }}" placeholder="+7 (___)" title="Укажите Ваш контакнтый телефон. Поле обязательно для заполнения" type="text" value="{{ $data['phone.value'] }}">
<textarea name="comment" class="pure-input-1" rows="4" placeholder="Текст жалобы" title="Текст жалобы">{{ $data['comment.value'] }}</textarea>
<div style="margin: 0 0 15px 0;display: block;clear: both;">
    <input name="privacy" class="{{ $data['privacy.errorClass'] }}{{ $data['privacy.requiredClass'] }}" type="checkbox" value="yes" required="required">
    <span>Настоящим подтверждаю, что я ознакомлен и согласен с условиями <a href="[~[*id*]~]#privacy-policy-modal">политики конфиденциальности</a></span>
</div>
<div class="form-group col-md-6 {{ $data['g-recaptcha-response.errorClass'] }} {{ $data['g-recaptcha-response.requiredClass'] }}" >
    {{ $data['captcha'] }}
    {{ $data['g-recaptcha-response.error'] }}
</div>