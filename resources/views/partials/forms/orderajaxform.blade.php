<form method="post" action="?page_action=send_form" >
    <input type="hidden" name="formid" value="remodalcontactform">
    <div class="form-group">
        <input type="text" name="name" placeholder="Имя" value="{{ $data['name.value'] }}">
        {!!   $data['name.error'] !!}
    </div>
    <div class="form-group">
        <input type="email" name="email" placeholder="E-mail" value="{{ $data['email.value'] }}">
        {!!   $data['email.error'] !!}
    </div>
    <div class="form-group">
        <input type="tel" name="phone" placeholder="+7 (___)" value="{{ $data['phone.value'] }}">
        {!!   $data['phone.error'] !!}
    </div>
    <div class="form-group">
        <textarea name="comment" placeholder="Комментарий к заказу">{{ $data['comment.value'] }}</textarea>
    </div>
{{--    <div class="form-group">--}}
{{--        <input type="file" name="file">--}}
{{--    </div>--}}
    <div class="dropzone okhide" id="contact-file">
        <div class="dz-default dz-message">
            <div>Файлы</div>
            Если Вам нужно отправить нам макет,<br>
            <span>загрузите файлы</span><br>
            или просто перетащите их в это поле
        </div>
    </div>
    <input class="btn" type="submit" value="Заказать печать {{ $prod_name }}">
</form>