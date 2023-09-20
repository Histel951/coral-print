<form action="" id="cart_form">
    <input type="hidden" name="formid" value="cartAjaxForm">
    <input type="hidden" name="evoShop_items_json" id="evoShop_items_json">
    <div class="layout-2-column border-bottom">
        <div class="delivery">
            <div class="cart-title">
                <p>Способ доставки</p>
            </div>
            <label>
                <input type="radio" name="delivery" id="deliv1" value="deliv1">
                <span><strong>Самовывоз</strong> м. Водный стадион, Кронштадтский бульвар, д. 14</span>
            </label>
            <label>
                <input type="radio" name="delivery" id="deliv2" value="deliv2">
                <span><strong>Самовывоз</strong> м. Белорусская, Ленинградский проспект, д. 2</span>
            </label>
            <label>
                <input type="radio" name="delivery" id="deliv3" value="deliv3">
                <span>Почтой России +90 руб</span>
            </label>
            <label>
                <input type="radio" name="delivery" id="deliv4" value="deliv4">
                <span>Доставка курьером в пределах МКАД <strong>+390 руб</strong></span>
            </label>
        </div>
        <div class="delivery">
            <div class="cart-title">
                <p>Адрес доставки</p>
            </div>
            <textarea class="" name="adress" id="simpleAdress" cols="30" rows="10"
                      placeholder="Улица, дом, квартира"></textarea>
            <div class="cart-form active" id="hardAddress">
                <div class="cart-form__item">
                    <input type="text" name="index" placeholder="Индекс">
                    <input type="text" name="city" placeholder="Город">
                </div>
                <div class="cart-form__item">
                    <input type="text" name="street" placeholder="Улица">
                    <input class="input-sm" type="text" name="house" placeholder="Дом">
                    <input class="input-sm" type="text" name="apartment" placeholder="Кв.">
                </div>
            </div>
        </div>
    </div>
    <div class="layout-3-column">
        <div class="column cart-form active">
            <div class="cart-title">
                <p>Контактные данные</p>
            </div>
            <div class="cart-form__item">
                <input type="text" name="name" placeholder="Фамилия Имя *" required>
            </div>
            <div class="cart-form__item">
                <input class="width-46" type="email" name="email" placeholder="E-mail*" required>
                <input class="width-46" type="tel" name="phone" placeholder="Телефон*" required>
            </div>
        </div>
        <div class="column offer-contract">
            <div class="checkbox">
                <input type="checkbox" name="ofert" id="ofert" >
                <label for="ofert">Я принимаю
                    <a href="">договор оферты</a> и согласен на обработку
                    <a href="">персональных данных</a>
                </label>
            </div>
        </div>
        <div class="column results-table">
            <p>К оплате: <strong class="evoShop_grandTotal"></strong> <strong>руб</strong></p>
            <span class="delivery_price"></span>
            <button disabled class="pure-button blue-btn" id="evoShop_ready" type="submit">Оформить заказ</button>
            <span id="evoShop_loading"></span>
        </div>
    </div>
</form>
