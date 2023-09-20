<input type="hidden" name="formid" value="orderform">
<input type="hidden" name="evoShop_items_json" id="evoShop_items_json" value="{{ $data['evoShop_items_json'] }}"/>

<div class="field-holder">
    <div class="overflow">
        <input type="text" name="name" id="name" placeholder="Имя Фамилия" required="required" class="pure-input-1{{ $data['name.errorClass'] }}{{ $data['name.requiredClass'] }}" value="{{ $data['name.value'] }}">
    </div>
</div>
<div class="field-holder">
    <div class="overflow">
        <input type="text" name="email" id="email" placeholder="E-mail" required="required" class="pure-input-1{{ $data['email.errorClass'] }}{{ $data['email.requiredClass'] }}" value="{{ $data['email.value'] }}">
    </div>
</div>
<div class="field-holder">
    <div class="overflow">
        <input type="text" name="phone" id="tel" placeholder="+7(___) ___-__-__" required="required" class="phone-input pure-input-1{{ $data['phone.errorClass'] }}{{ $data['phone.requiredClass'] }}" value="{{ $data['phone.value'] }}">
    </div>
</div>
<div class="field-holder hidden">
    <div class="overflow">
        <input type="text" name="address" id="address" placeholder="Адрес" class="pure-input-1{{ $data['address.errorClass'] }}{{ $data['address.requiredClass'] }}" value="{{ $data['address.value'] }}">
    </div>
</div>
<div class="field-holder hidden">
    <div class="overflow">
        <input type="text" name="index" id="index" placeholder="Индекс" class="pure-input-1{{ $data['index.errorClass'] }}{{ $data['index.requiredClass'] }}" value="{{ $data['index.value'] }}">
    </div>
</div>
<div class="field-holder hidden">
    <div class="overflow">
        <input type="text" name="city" id="city" placeholder="Город" class="pure-input-1{{ $data['city.errorClass'] }}{{ $data['city.requiredClass'] }}" value="{{ $data['city.value'] }}">
    </div>
</div>

<div class="field-holder hidden">
    <div class="overflow">
        <input type="text" name="street" id="street" placeholder="Улица" class="pure-input-1{{ $data['street.errorClass'] }}{{ $data['street.requiredClass'] }}" value="{{ $data['street.value'] }}">
    </div>
</div>
<div class="field-holder hidden">
    <div class="overflow">
        <input type="text" name="house" id="house" placeholder="Дом" class="pure-input-1{{ $data['house.errorClass'] }}{{ $data['house.requiredClass'] }}" value="{{ $data['house.value'] }}">
    </div>
</div>