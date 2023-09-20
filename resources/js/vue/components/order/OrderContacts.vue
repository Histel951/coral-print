<template>
  <div class="order__part">
    <h2 class="order__part-title">Персональные данные</h2>
    <div class="order__part-intro">
      <p>Мы используем личные данные только для оформления доставки и на случай вопросов
        по вашему заказу</p>
    </div>
    <div class="order__field">
      <input @keydown.down.prevent="onKeyDown" @keydown.up.prevent="onKeyUp" @keydown.enter.prevent="onKeyEnter"
             v-model="fio" type="text" class="input input_wide" id="fio" :class="{error: v$.fio.$errors.length !== 0}"
             name="fio" placeholder="Ваше ФИО*" spellcheck="false" autocomplete="off">
      <ul v-if="fioSuggest.length > 0 && fio.length > 2"
          class="suggest-options" id="fio-options">
        <li @click="chooseFio(fio)" v-for="(fio, index) in fioSuggest" :key="index"
            class="suggest-option" :class="{selected: selectedSuggest === index}">
          {{ fio.value }}
        </li>
      </ul>
    </div>
    <div class="error-msg" v-for="error of v$.fio.$errors" :key="error.$uid">
      <span v-if="error.$uid === 'fio-fioRegExpHelper'">Неверный формат ФИО!</span>
      <span v-else>Поле обязательно для заполнения!</span>
    </div>
    <div class="order__field">
      <input v-model="phone" type="tel" class="input input_wide" :class="{error: v$.phone.$errors.length !== 0}"
             id="phone" name="phone" placeholder="Телефон*">
    </div>
    <div class="error-msg" v-for="error of v$.phone.$errors" :key="error.$uid">
      <span v-if="error.$uid === 'phone-phoneRegExpHelper'">Неверный формат номера телефона!</span>
      <span v-else>Поле обязательно для заполнения!</span>
    </div>
    <div class="order__field">
      <input v-model="eMail" class="input input_wide" :class="{error: v$.eMail.$errors.length !== 0}" id="email"
             name="email" placeholder="E-mail*">
    </div>
    <div class="error-msg" v-for="error of v$.eMail.$errors" :key="error.$uid">
      <span v-if="error.$uid === 'eMail-email'">Неверный формат адреса электронной почты!</span>
      <span v-else>Поле обязательно для заполнения!</span>
    </div>
    <div class="order__field">
      <div class="custom-checkbox">
        <input @change="$emit('personalDataChecked', personalDataChecked)"
               v-model="personalDataChecked" class="custom-checkbox__input" type="checkbox" name="agree-personal"
               value="" id="agree-personal">
        <label class="custom-checkbox__label" for="agree-personal">
          <span class="custom-checkbox__selector"></span>
          <span>Я согласен на обработку <a href="#">персональных данных</a></span>
        </label>
      </div>
    </div>
  </div>
</template>

<script>
import {ref, computed, watch} from "vue";
import {useVuelidate} from '@vuelidate/core';
import {email, required} from '@vuelidate/validators';
import {helpers} from '@vuelidate/validators'
import debounce from "lodash/debounce";
import axios from "axios";

export default {
  name: "OrderContacts",
  emits: ['personalDataChecked'],

  setup(props, {expose}) {
    const fio = ref('');
    const phone = ref('');
    const eMail = ref('');
    const personalDataChecked = ref(true);

    const fioSuggest = ref([]);
    const selectedSuggest = ref(null);

    const fioRegExpHelper = helpers.regex(/^[a-zA-Zа-яёА-ЯЁ\s\-]+$/); // eslint-disable-line no-useless-escape
    const phoneRegExpHelper = helpers.regex(/^((8|\+7)[\- ]?)?(\(?\d{3}\)?[\- ]?)?[\d\- ]{7,10}$/); // eslint-disable-line no-useless-escape

    const rules = computed(() => ({
      fio: {required, fioRegExpHelper},
      phone: {required, phoneRegExpHelper},
      eMail: {email, required}
    }));

    const v$ = useVuelidate(rules, {fio, phone, eMail});

    const validate = async () => {
      return await v$.value.$validate();
    };

    const suggestAddressRequest = debounce((query) => {
      axios
        .post('/api/suggest/names', {
          query: query,
        })
        .then((res) => {
          fioSuggest.value = res.data;
          selectedSuggest.value = null;
        })
        .catch(() => {
          fioSuggest.value = [];
          selectedSuggest.value = null;
        });
    }, 500);

    const chooseFio = (chosenFio) => {
      fio.value = chosenFio.value;
      fioSuggest.value = [chosenFio];
      selectedSuggest.value = null;
    };

    const onKeyDown = () => {
      if (fioSuggest.value.length === 0) {
        return;
      }

      if (selectedSuggest.value === null) {
        selectedSuggest.value = 0;
        fio.value = fioSuggest.value[selectedSuggest.value].value;

        return;
      }

      selectedSuggest.value !== fioSuggest.value.length - 1 && selectedSuggest.value++;
      fio.value = fioSuggest.value[selectedSuggest.value].value;
    };

    const onKeyUp = () => {
      if (fioSuggest.value.length === 0 || selectedSuggest.value === null) {
        return;
      }

      selectedSuggest.value !== 0 && selectedSuggest.value--;
      fio.value = fioSuggest.value[selectedSuggest.value].value;
    };

    const onKeyEnter = () => {
      const options = document.getElementById('fio-options');

      selectedSuggest.value !== null && chooseFio(fioSuggest.value[selectedSuggest.value]);

      options.style.display = 'none';
    };

    watch(
      fio,
      (newFio) => {
        if (newFio.length < 3) {
          fioSuggest.value = [];

          return;
        }

        if (fioSuggest.value.findIndex((item) => item.value === newFio) !== -1) {
          return;
        }

        suggestAddressRequest(newFio);

        if (fioSuggest.value.length > 0) {
          const options = document.getElementById('moscow-address-options')
            ?? document.getElementById('outside-moscow-options');

          if (null !== options) {
            options.style.display = 'block';
          }
        }
      }
    );

    document.addEventListener('click', (event) => {
      const input = document.getElementById('fio');
      const options = document.getElementById('fio-options');

      if (options !== null) {
        if (!input?.contains(event.target)) {
          options.style.display = 'none';
        } else if (input?.contains(event.target) && fio.value.length > 2) {
          options.style.display = 'block';
        }
      }
    });

    expose({validate, fio, phone, eMail});

    return {
      v$,
      fio,
      phone,
      eMail,
      personalDataChecked,
      fioSuggest,
      selectedSuggest,
      validate,
      onKeyUp,
      onKeyDown,
      onKeyEnter,
      chooseFio,
    };
  },
};
</script>

<style lang="scss" scoped>
.order {
  &__field {
    position: relative;
    max-width: 100%;
  }
}

.error-msg {
  font-size: 12px;
  line-height: 18px;
  color: #eb444c;
  position: inherit;
  margin-top: 2px;
  margin-bottom: 2px;
}

.selected {
  background-color: #eee;
}
</style>
