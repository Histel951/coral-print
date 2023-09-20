<template>
  <div class="order__part">
    <h2 class="order__part-title">Доставка</h2>
    <div class="order__field">
      <div class="custom-select">
        <div class="custom-select__trigger">
          <input type="hidden" name="city" placeholder="" readonly
                 class="custom-select__input">
          <div class="custom-select__text"></div>
          <div class="custom-select__arrow"></div>
        </div>
        <ul class="custom-options">
          <li @click="onCityChanged(city)" v-for="city in cities" :key="city" class="custom-option" :data-value="city">
            г. {{ city }}
          </li>
        </ul>
      </div>
    </div>
    <div v-for="department in cityDepartments" :key="department.id" class="order__field order__field_box"
         :style="department.id === 2 && orderWeight > 5 ? 'display: none;' : ''">
      <div class="custom-radio">
        <input @click="setDeliveryPrice(department.id)" class="custom-radio__input" type="radio" name="delivery"
               :value="department.id"
               :id="'deliv-' + department.id" :checked="department.id === cityDepartments[0].id">
        <label class="custom-radio__label" :for="'deliv-' + department.id">
          <span class="custom-radio__selector"></span>
          <span>Самовывоз из <a :href="department.address_link">пункта выдачи</a> <span
            v-if="department.metro !== null">
              <i class="icon-metro"></i>
              {{ department.metro }}<span v-if="department.id !== 1">: <Price :price="pickupPrice" /></span>
            </span>
            <span v-else>
              ({{ getAddress(department.address) }})</span>
          </span>
        </label>
      </div>
    </div>
    <div class="order__field order__field_box">
      <div class="custom-radio">
        <input @click="setDeliveryPrice(moscowCourierId)" class="custom-radio__input" type="radio" name="delivery"
               :value="moscowCourierId" :id="'deliv-' + moscowCourierId" :checked="cityDepartments.length === 0">
        <label class="custom-radio__label" :for="'deliv-' + moscowCourierId">
          <span class="custom-radio__selector"></span>
          <span>Доставка курьером<span
            v-if="currentCity === 'Москва'"> в пределах МКАД</span>: <Price :price="standardDeliveryPrice" />,<br/> для тиражей весом больше {{
              weightIsHeavy
            }} кг — <Price :price="heavyDeliveryPrice" /></span>
        </label>
      </div>
      <input @keydown.down.prevent="onKeyDown" @keydown.up.prevent="onKeyUp" @keydown.enter.prevent="onKeyEnter"
             v-model="address" v-show="checkedId === -1" :class="{error: isNotFound}"
             type="text" class="input input_wide" spellcheck="false" name="moscow-address"
             placeholder="Начните вводить адрес..." id="moscow-address" autocomplete="off">
      <div v-if="isNotFound && checkedId === -1" class="error-msg">
        <span>Адрес не найден!</span>
      </div>
      <ul v-if="addressSuggest.length > 0 && checkedId === -1 && address.length > 2"
          class="suggest-options" id="moscow-address-options">
        <li @click="chooseAddress(address)" v-for="(address, index) in addressSuggest" :key="index"
            class="suggest-option" :class="{selected: selectedSuggest === index}">
          {{ address.value }}
        </li>
      </ul>
    </div>
    <div class="order__field order__field_box" :style="checkedId === -1 ? 'margin-top: 27px' : ''">
      <div class="custom-radio">
        <input @click="setDeliveryPrice(outsideMoscowCourierId)" class="custom-radio__input" type="radio"
               name="delivery" :value="outsideMoscowCourierId" :id="'deliv-' + outsideMoscowCourierId">
        <label class="custom-radio__label" :for="'deliv-' + outsideMoscowCourierId">
          <span class="custom-radio__selector"></span>
          <span>Доставка курьером за МКАД (Московская обл.)
            <span class="order__option-descr">
              Стоимость доставки оплачивается отдельно. Доставка рассчитывается менеджером и согласовывается с клиентом перед доставкой.
            </span>
          </span>
        </label>
      </div>
      <input @keydown.down.prevent="onKeyDown" @keydown.up.prevent="onKeyUp" @keydown.enter.prevent="onKeyEnter"
             v-model="address" v-show="checkedId === -2" :class="{error: isNotFound}"
             type="text" class="input input_wide" spellcheck="false" name="outside-moscow-address"
             placeholder="Начните вводить адрес..." id="outside-moscow-address" autocomplete="off">
      <div v-if="isNotFound && checkedId === -2" class="error-msg">
        <span>Адрес не найден!</span>
      </div>
      <ul v-if="addressSuggest.length > 0 && checkedId === -2 && address.length > 2"
          class="suggest-options" id="outside-moscow-options">
        <li @click="chooseAddress(address)" v-for="(address, index) in addressSuggest" :key="index"
            class="suggest-option" :class="{selected: selectedSuggest === index}">
          {{ address.value }}
        </li>
      </ul>
    </div>
  </div>
</template>

<script>
import {ref, watch} from "vue";
import axios from "axios";
import usePrice from "@/composables/usePrice";
import Price from "@/components/ui/Price.vue";
import debounce from "lodash/debounce";

export default {
  name: "OrderDelivery",
  props: {
    orderWeight: Number,
  },
  emits: ['setDelivery'],
  components: {Price},

  setup(props, context) {
    const departments = ref([]);
    const cities = ref([]);
    const cityDepartments = ref([]);
    const deliveryPrice = ref(0);
    const currentCity = ref('');

    const checkedId = ref(0);

    const address = ref('');
    const addressSuggest = ref([]);
    const isNotFound = ref(false);
    const selectedSuggest = ref(null);

    const {format} = usePrice();

    const pickupPrice = 90;
    const standardDeliveryPrice = 390;
    const heavyDeliveryPrice = 890;
    const weightIsHeavy = 5;

    const moscowCourierId = -1;
    const outsideMoscowCourierId = -2;
    const vodniyStadionPickupId = 1;

    axios
      .get('api/departments')
      .then(async (res) => {
        departments.value = res.data;
        await departments.value.forEach((department) => {
          if (cities.value.findIndex((city) => city === department.city) === -1) {
            cities.value.push(department.city);
          }
        });

        await onCityChanged(cities.value[0]);
        await setDeliveryPrice(typeof cityDepartments.value[0] !== 'undefined' ? cityDepartments.value[0].id : -1);

        document.dispatchEvent(new CustomEvent('departmentsLoaded'));
      })
      .catch((reason) => {
        console.error(reason);
      });

    const onCityChanged = (city) => {
      currentCity.value = city;
      cityDepartments.value = departments.value.filter((department) => department.city === city);
      setDeliveryPrice(typeof cityDepartments.value[0] !== 'undefined' ? cityDepartments.value[0].id : -1);
    };

    const getAddress = (fullAddress) => {
      const from = fullAddress.search(',');
      const to = fullAddress.length;

      return fullAddress.substr(from + 2, to);
    };

    const setDeliveryPrice = (id) => {
      if (id === checkedId.value) {
        return;
      }

      let typeId = 0;

      checkedId.value = id;

      if (currentCity.value === 'Москва') {
        if (id < 0) {
          clearSuggest();
        }

        if (id === moscowCourierId) {
          deliveryPrice.value = checkWeight();
          typeId = 1;
        } else {
          deliveryPrice.value = [outsideMoscowCourierId, vodniyStadionPickupId].includes(id) ? 0 : pickupPrice;
          typeId = id > 0 ? 2 : 3;
        }
      }

      const deliveryProps = {
        type: typeId,
        price: deliveryPrice.value,
        city: currentCity.value,
        city_department: id > 0 ? id : null,
        metro: departments.value.find((department) => department.id === id)?.metro ?? null,
      };

      context.emit('setDelivery', deliveryProps);
    };

    const clearSuggest = () => {
      address.value = '';
      addressSuggest.value = [];
      isNotFound.value = false;
      selectedSuggest.value = null;
    };

    const checkWeight = () => {
      return props.orderWeight <= weightIsHeavy ? standardDeliveryPrice : heavyDeliveryPrice;
    };

    const suggestAddressRequest = debounce((query, isMoscow) => {
      axios
        .post('/api/suggest/addresses', {
          query: query,
          region: isMoscow ? 'москва' : 'московская',
          restricted: true,
        })
        .then((res) => {
          addressSuggest.value = res.data;
          isNotFound.value = addressSuggest.value.length === 0;
          selectedSuggest.value = null;
        })
        .catch(() => {
          addressSuggest.value = [];
          selectedSuggest.value = null;
        });
    }, 500);

    const chooseAddress = (chosenAddress) => {
      address.value = chosenAddress.value;
      addressSuggest.value = [chosenAddress];
      selectedSuggest.value = null;
    };

    const onKeyDown = () => {
      if (addressSuggest.value.length === 0) {
        return;
      }

      if (selectedSuggest.value === null) {
        selectedSuggest.value = 0;
        address.value = addressSuggest.value[selectedSuggest.value].value;

        return;
      }

      selectedSuggest.value !== addressSuggest.value.length - 1 && selectedSuggest.value++;
      address.value = addressSuggest.value[selectedSuggest.value].value;
    };

    const onKeyUp = () => {
      if (addressSuggest.value.length === 0 || selectedSuggest.value === null) {
        return;
      }

      selectedSuggest.value !== 0 && selectedSuggest.value--;
      address.value = addressSuggest.value[selectedSuggest.value].value;
    };

    const onKeyEnter = () => {
      const options = document.getElementById('moscow-address-options')
        ?? document.getElementById('outside-moscow-options');

      selectedSuggest.value !== null && chooseAddress(addressSuggest.value[selectedSuggest.value]);

      options.style.display = 'none';
    };

    watch(
      address,
      (newAddress) => {
        if (newAddress.length < 3) {
          addressSuggest.value = [];

          return;
        }

        if (addressSuggest.value.findIndex((item) => item.value === newAddress) !== -1) {
          return;
        }

        suggestAddressRequest(newAddress, checkedId.value === -1);

        if (addressSuggest.value.length > 0) {
          const options = document.getElementById('moscow-address-options')
            ?? document.getElementById('outside-moscow-options');

          if (null !== options) {
            options.style.display = 'block';
          }
        }
      }
    );

    document.addEventListener('click', (event) => {
      if (checkedId.value < 0) {
        const input = document.getElementById('moscow-address')
          ?? document.getElementById('outside-moscow-address');
        const options = document.getElementById('moscow-address-options')
          ?? document.getElementById('outside-moscow-options');

        if (options !== null) {
          if (!input?.contains(event.target)) {
            options.style.display = 'none';
          } else if (input?.contains(event.target) && address.value.length > 2) {
            options.style.display = 'block';
          }
        }
      }
    });

    context.expose({address});

    return {
      departments,
      cities,
      cityDepartments,
      deliveryPrice,
      pickupPrice,
      standardDeliveryPrice,
      heavyDeliveryPrice,
      weightIsHeavy,
      currentCity,
      moscowCourierId,
      outsideMoscowCourierId,
      checkedId,
      address,
      addressSuggest,
      isNotFound,
      selectedSuggest,
      format,
      getAddress,
      onCityChanged,
      setDeliveryPrice,
      chooseAddress,
      onKeyDown,
      onKeyUp,
      onKeyEnter,
    };
  },
};
</script>

<style lang="scss" scoped>
.order {
  &__field_box {
    position: relative;
    opacity: 1;
  }
}

.input_wide {
  margin-top: 19px;
}

.selected {
  background-color: #eee;
}

.error-msg {
  font-size: 12px;
  line-height: 18px;
  color: #eb444c;
  position: inherit;
  margin-top: 2px;
  margin-bottom: 2px;
}
</style>
