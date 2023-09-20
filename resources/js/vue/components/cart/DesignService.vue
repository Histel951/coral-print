<template>
  <div class="custom-checkbox">
    <input
      class="custom-checkbox__input"
      type="checkbox"
      :id="id"
      :name="id"
      :checked="service.checked"
      v-model="checked" />
    <label class="custom-checkbox__label" :for="id">
      <span class="custom-checkbox__selector"></span> {{ service.label }}:&nbsp;<Price :price="service.value * count" />
    </label>
  </div>
  <div v-if="types_count > 1 && checked" class="c-item__count visible-lg"
       style="padding: 10px 0">
    <div class="input-count">
      <div class="input-count__item">
        <button @click="countMinus" class="input-count__btn minus" type="button"></button>
      </div>
      <div class="input-count__item">
        <input v-model="count" class="input-count__input" type="text" readonly>
      </div>
      <div class="input-count__item">
        <button @click="countPlus" class="input-count__btn plus" type="button"></button>
      </div>
    </div>
  </div>
</template>

<script>
import usePrice from "@/composables/usePrice";
import {ref, watch} from "vue";
import Price from "@/components/ui/Price.vue";

export default {
  name: "DesignService",
  components: {Price},
  props: {
    id: String,
    service: Object,
    types_count: Number,
  },
  emits: ['designChecked', 'countChanged'],

  setup(props, context) {
    const checked = ref(props.service.checked);
    const count = ref(props.service.count);

    const {format} = usePrice();

    const countMinus = () => {
      if (count.value > 1) {
        count.value--;
        context.emit('countChanged', props.service.id, -1);
      }
    };

    const countPlus = () => {
      if (count.value < props.types_count) {
        count.value++;
        context.emit('countChanged', props.service.id, 1);
      }
    }

    watch(
      checked,
      () => {
        if (!checked.value) {
          count.value = 1;
        }

        context.emit('designChecked', props.service.id);
      }
    );

    return {
      checked,
      count,
      format,
      countPlus,
      countMinus,
    };
  },
}
</script>

<style scoped>
@media all {

}
</style>
