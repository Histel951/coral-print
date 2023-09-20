<template>
  <div class="order__part">
    <h2 class="order__part-title">Оплата</h2>
    <div class="order__part-intro">
      <p>Вы можете оплатить заказ любым способом безналичной или онлайн оплаты.</p>
    </div>
    <div class="order__field order__field_box">
      <div class="custom-radio">
        <input @click="setPayment(2)" class="custom-radio__input" type="radio" name="pay" value="2" id="pay-2" checked>
        <label class="custom-radio__label" for="pay-2">
          <span class="custom-radio__selector"></span>
          <span>Оплатить как физическое лицо
            <span class="order__option-descr">После оформления заказа сайт переведет вас на сервис
              <a href="#">ЮKassa</a>, где вы сможете выбрать подходящий для вас способ оплаты.</span>
          </span>
        </label>
      </div>
    </div>
    <div class="order__field order__field_box">
      <div class="custom-radio">
        <input @click="setPayment(3)" class="custom-radio__input" type="radio" name="pay" value="3"
               id="pay-3">
        <label class="custom-radio__label" for="pay-3">
          <span class="custom-radio__selector"></span>
          <span>Заказать счет для оплаты юридическим лицом
            <span class="order__option-descr">Если вы уже заказывали наши услуги, просто введите название вашей компании в поле</span>
          </span>
        </label>
      </div>
    </div>
    <div v-show="payment === 3" class="order__field order__field_box">
      <div class="order__field order__field_box">
        <div class="order__company">
          <input @keydown.down.prevent="onKeyDown" @keydown.up.prevent="onKeyUp" @keydown.enter.prevent="onKeyEnter"
                 v-model="company" type="text" class="input input_wide" name="company" placeholder="Название компании"
                 id="input-company" autocomplete="off" :class="{error: isNotFound}" spellcheck="false">
          <div v-if="isNotFound" class="error-msg">
            <span>Компания не найдена!</span>
          </div>
          <ul v-if="companySuggest.length > 0 && company.length > 2" class="suggest-options" id="company-options">
            <li @click="chooseCompany(company)" v-for="(company, index) in companySuggest" :key="index"
                class="suggest-option" :class="{selected: selectedSuggest === index}">
              {{ company.value }}
            </li>
          </ul>
          <div class="order__option-descr">Или загрузите реквизиты вашей компании</div>
        </div>
        <div class="order-files">
          <div v-bind="getRootProps()" class="order-files__upload-input"
               :style="files.length === 0 ? 'max-width: fit-content;' : ''">
            <input v-bind="getInputProps()" class="order-files__input-invisible"/>
            <i class="icon-cp-upload"></i>Загрузить реквизиты
          </div>
          <div v-if="files.length > 0" class="order-files__uploaded-file">
            <div class="order-files__file-name">
              {{ files[0].file_name }}
            </div>
            <div @click="deleteRequisites(files[0].id)" class="order-files__delete-button">
              удалить&nbsp;<i class="icon-del" style="color: #EB444C; font-size: 9px;"></i>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="order__field order__field_box">
      <div class="custom-radio">
        <input @click="setPayment(1)" class="custom-radio__input" type="radio" name="pay" value="1" id="pay-1">
        <label class="custom-radio__label" for="pay-1">
          <span class="custom-radio__selector"></span>
          <span>Оформление без оплаты
            <span class="order__option-descr">Выберите этот пункт, если не конца уверены в деталях или технических параметрах заказа.
              После оформления мы свяжемся с вами и поможем во всем разобраться.</span>
          </span>
        </label>
      </div>
    </div>
  </div>
</template>

<script>
import axios from "axios";
import {ref, watch} from "vue";
import {useDropzone} from "vue3-dropzone";
import useFiles from "@/composables/useFiles";
import debounce from "lodash/debounce";

export default {
  name: "OrderPayment",

  setup(props, {expose}) {
    const payment = ref(1);
    const company = ref('');
    const companyInn = ref(null);
    const companySuggest = ref([]);
    const isNotFound = ref(false);
    const selectedSuggest = ref(null);

    const {files, saveFiles, deleteRequisites} = useFiles();

    const accept = [
      'application/msword',
      'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
      'application/vnd.oasis.opendocument.text',
      'application/pdf',
      'application/rtf',
      'application/vnd.oasis.opendocument.text',
      'text/plain',
    ];
    const maxSize = 33554432;
    const maxFiles = 1;
    const noDrag = true;
    const noDragEventsBubbling = true;
    const multiple = false;

    function onDrop(acceptFiles, rejectReasons) {
      if (files.value.length === 0) {
        saveFiles(acceptFiles);
      }
      if (rejectReasons.length !== 0) {
        console.error(rejectReasons);
      }
    }

    const {getRootProps, getInputProps, ...rest} = useDropzone(
      {
        onDrop,
        accept,
        maxSize,
        maxFiles,
        noDrag,
        noDragEventsBubbling,
        multiple
      });

    const setPayment = (id) => {
      payment.value = id;
    };

    const suggestSearch = debounce((query) => {
      axios
        .post('/api/suggest/companies', {
          query: query
        })
        .then((res) => {
          companySuggest.value = res.data;
          isNotFound.value = companySuggest.value.length === 0;
          selectedSuggest.value = null;
        })
        .catch(() => {
          companySuggest.value = [];
          selectedSuggest.value = null;
        });
    }, 500);

    const chooseCompany = (chosenCompany) => {
      companyInn.value = chosenCompany.inn;
      company.value = chosenCompany.value;
      companySuggest.value = [chosenCompany];
      selectedSuggest.value = null;
    };

    const onSuggestMoving = () => {
      company.value = companySuggest.value[selectedSuggest.value].value;
      companyInn.value = companySuggest.value[selectedSuggest.value].inn;
    }

    const onKeyDown = () => {
      if (companySuggest.value.length === 0) {
        return;
      }

      if (selectedSuggest.value === null) {
        selectedSuggest.value = 0;
        onSuggestMoving();

        return;
      }

      selectedSuggest.value !== companySuggest.value.length - 1 && selectedSuggest.value++;
      onSuggestMoving();
    };

    const onKeyUp = () => {
      if (companySuggest.value.length === 0 || selectedSuggest.value === null) {
        return;
      }

      selectedSuggest.value !== 0 && selectedSuggest.value--;
      onSuggestMoving();
    };

    const onKeyEnter = () => {
      const options = document.getElementById('company-options');

      selectedSuggest.value !== null && chooseCompany(companySuggest.value[selectedSuggest.value]);

      options.style.display = 'none';
    };

    setPayment(1);

    watch(
      company,
      (newCompany) => {
        if (newCompany.length < 3) {
          companySuggest.value = [];

          return;
        }

        if (companySuggest.value.findIndex((item) => item.value === newCompany) !== -1) {
          return;
        }

        companyInn.value = null;
        suggestSearch(newCompany);

        if (companySuggest.value.length > 0) {
          const options = document.getElementById('company-options');

          options.style.display = 'block';
        }
      });

    document.addEventListener('click', (event) => {
      if (payment.value === 3) {
        const input = document.getElementById('input-company');
        const options = document.getElementById('company-options');

        if (options !== null) {
          if (!input?.contains(event.target)) {
            options.style.display = 'none';
          } else if (input?.contains(event.target) && company.value.length > 2) {
            options.style.display = 'block';
          }
        }
      }
    });

    expose({payment, files, companyInn, company});

    return {
      payment,
      files,
      company,
      companyInn,
      companySuggest,
      isNotFound,
      selectedSuggest,
      saveFiles,
      deleteRequisites,
      setPayment,
      chooseCompany,
      suggestSearch,
      onKeyUp,
      onKeyDown,
      onKeyEnter,
      getRootProps,
      getInputProps,
      ...rest,
    };
  },
};
</script>

<style lang="scss" scoped>
.order-files {
  display: flex;
  flex-wrap: nowrap;
  align-items: center;
  justify-content: space-between;
  padding-top: 5px;
  max-width: 100%;
  min-width: 0;
  flex: 1;

  &__upload-input {
    cursor: pointer;
    font-style: normal;
    font-weight: 400;
    font-size: 16px;
    line-height: 23px;
    color: #007DEB;
    display: flex;
    align-items: center;
    padding-right: 24px;
    min-width: min-content;
    max-width: fit-content;
    width: 100%;
    flex: 1;
  }

  &__input-invisible {
    padding: 0;
    margin: 0;
    border: 0;
    width: 0;
    height: 0;
    position: absolute
  }

  &__uploaded-file {
    font-style: normal;
    font-weight: 400;
    font-size: 14px;
    line-height: 21px;
    display: flex;
    align-items: center;
    min-width: 0;
    flex: 1;
  }

  &__file-name {
    color: #1E1E1E;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
    padding-right: 1em;
    min-width: 0;
    max-width: fit-content;
    flex: 2 1 0;
  }

  &__delete-button {
    display: flex;
    cursor: pointer;
    color: #8E8E8E;
    align-items: baseline;
    max-width: fit-content;
    width: 100%;
    flex: 1;
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

.icon-cp-upload {
  padding-right: 10px;
  font-size: 25px;
}

.order {
  &__company {
    position: relative;
    opacity: 1;
  }

  &__option-descr {
    margin-top: 10px;
  }
}

.input_wide {
  margin: 0;
}

.selected {
  background-color: #eee;
}

@media all and (min-width: 768px) {
  .order-files {
    &__upload-input {
      padding-right: 12px;
      max-width: min-content;
    }
  }
}

@media all and (min-width: 1024px) {
  .order-files {
    padding-left: 36px;

    &__upload-input {
      padding-right: 24px;
      max-width: fit-content;
    }
  }
}
</style>
