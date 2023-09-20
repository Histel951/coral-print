<template>
  <div class="c-item__text">
    <p>
      <span v-html="description"></span>
      <span v-if="weight !== null && weight !== 0">Примерный вес тиража: {{ `${weightFormat(weight)}.` }}</span>
      <span v-if="cartItem.client_designs.length === 0" class="design-error"> Дизайн-макеты не прикреплены!</span>
    </p>
  </div>
</template>

<script>
import {onBeforeMount, ref} from "vue";
import useTypesDeclinations from "@/composables/useTypesDeclinations";

export default {
  name: "CartItemText",
  props: {
    calculatorType: String,
    cartItem: Object,
    fieldsParams: Object,
    weight: Number
  },

  async setup(props) {
    const sticker = ref({});
    const catalog = ref({
      cover: {},
      block: {},
      substrate: {},
    });
    const businessCard = ref({
      face: {},
      back: {},
    });
    const booklet = ref({});
    const label = ref({});

    const {declination} = useTypesDeclinations();

    const description = ref('');

    const weightFormat = (value) => {
      const formatter = new Intl.NumberFormat('ru-RU', {
        style: 'unit',
        unit: 'kilogram',
        maximumSignificantDigits: 3,
      });

      return formatter.format(value).replace(' ', "\xA0");
    };

    const toLowerCase = (string) => string.substr(0, 1).toLowerCase() + string.substr(1);

    const appendDesc = (string) => {
      if (isEmpty(string)) {
        return;
      }

      description.value += isEmpty(description.value) ? `${string}, ` : `${toLowerCase(string)}, `;
    };

    const isEmpty = (string) =>
      typeof string === 'undefined'
      || string === null
      || string.includes('null')
      || string.includes('undefined')
      || string.length === 0;

    const endDesc = () => {
      description.value = `${description.value.substring(0, description.value.length - 2)}. `;
    };

    const descForStickers = () => {
      sticker.value.printType = getFieldByName('print_type');
      sticker.value.form = getFieldByName('form');
      sticker.value.material = getMaterial();
      sticker.value.lam = getLam();
      sticker.value.foiling = getFoiling();
      sticker.value.cutting = getFieldByName('cutting');
      sticker.value.quantityTypes = getQuantityTypes();

      if (props.cartItem.white_print === 1) {
        sticker.value.whitePrint = 'Печать белым';
      }

      if (props.cartItem.reverse_sticker === 1) {
        sticker.value.reverseSticker = 'Обратная наклейка';
      }

      if (props.cartItem.volume === 1) {
        sticker.value.volumeForm = 'Объемная наклейка';
      }

      if (props.cartItem.complex_form === 1) {
        sticker.value.complexForm = 'Сложная форма';
      }

      if (props.cartItem.mounting_film === 1) {
        sticker.value.mountingFilm = 'Монтажная пленка';
      }

      if (props.cartItem.small_objects === 1) {
        sticker.value.smallObjects = 'Сложная выборка';
      }

      if (props.cartItem.rounding_corner === 1) {
        sticker.value.roundingCorners = 'Скругление углов'
      }

      appendDesc(sticker.value.printType);
      appendDesc(sticker.value.form + ' форма');
      appendDesc(sticker.value.material);
      appendDesc('Ламинация ' + sticker.value.lam?.toLowerCase());
      appendDesc(sticker.value.foiling);
      appendDesc(sticker.value.cutting);
      appendDesc(sticker.value.whitePrint);
      appendDesc(sticker.value.reverseSticker);
      appendDesc(sticker.value.volumeForm);
      appendDesc(sticker.value.complexForm);
      appendDesc(sticker.value.mountingFilm);
      appendDesc(sticker.value.smallObjects);
      appendDesc(sticker.value.roundingCorners);
      appendDesc(sticker.value.quantityTypes);

      endDesc();
    };

    const descForCatalogs = () => {
      catalog.value.sprintPosition = getFieldByName('sprint_position');
      catalog.value.boltCoverSelect = getFieldByName('bolt_cover_select');

      if ([3855, 3860].includes(props.cartItem.calculator_id)) {
        catalog.value.pageCount = getFieldByName('page_count');
      } else {
        catalog.value.pageCount = props.cartItem.page_count + ' (не включая обложку и подложку)';
      }

      catalog.value.pageCount = props.cartItem.calculator_id !== 3859
        ? 'Страниц ' + catalog.value.pageCount
        : 'Листов ' + catalog.value.pageCount;

      appendDesc('Пружина ' + catalog.value.sprintPosition?.toLowerCase());
      appendDesc(catalog.value.boltCoverSelect);
      appendDesc(catalog.value.pageCount);

      description.value += "<b>обложка:</b> ";

      catalog.value.cover.color = getFieldByName('color_cover_select');
      catalog.value.cover.material = getMaterial('material_cover_select', 'material_cover_color');
      catalog.value.cover.lam = getLam('lam_cover_select');
      catalog.value.cover.foiling = getFoiling('foiling_cover_select', 'foiling_color_cover');

      if (props.cartItem.varnish_cover_select === 1) {
        catalog.value.cover.varnish = 'Выборочный лак, 1+0';
      }

      if (props.cartItem.plastic_cover_select === 1) {
        catalog.value.cover.plastic = 'Прозрачный пластик';
      }

      appendDesc(catalog.value.cover.color !== 'Без печати'
        ? 'Печать ' + catalog.value.cover.color?.toLowerCase()
        : catalog.value.cover.color);
      appendDesc(catalog.value.cover.material);
      appendDesc('Ламинация ' + catalog.value.cover.lam?.toLowerCase());
      appendDesc(catalog.value.cover.foiling);
      appendDesc(catalog.value.cover.plastic);
      appendDesc(catalog.value.cover.varnish);

      description.value += "<b>блок:</b> ";

      catalog.value.block.color = getFieldByName('color_block_select');
      catalog.value.block.material = getMaterial('material_block_select', 'material_block_color');

      appendDesc(catalog.value.block.color !== 'Без печати'
        ? 'Печать ' + catalog.value.block.color?.toLowerCase()
        : catalog.value.block.color);
      appendDesc(catalog.value.block.material);

      if (typeof props.cartItem.material_substrate_select !== 'undefined') {
        description.value += "<b>подложка:</b> ";

        catalog.value.substrate.color = getFieldByName('color_substrate_select');
        catalog.value.substrate.material = getMaterial('material_substrate_select', 'material_substrate_color');
        catalog.value.substrate.lam = getLam('lam_substrate_select');
        catalog.value.substrate.plastic = getFieldByName('plastic_substrate_select');

        appendDesc(catalog.value.substrate.color !== 'Без печати'
          ? 'Печать ' + catalog.value.substrate.color?.toLowerCase()
          : catalog.value.substrate.color);
        appendDesc(catalog.value.substrate.material);
        appendDesc('Ламинация ' + catalog.value.substrate.lam?.toLowerCase());
        appendDesc(catalog.value.substrate.plastic);
      }

      endDesc();
    };

    const descForBusinessCards = () => {
      businessCard.value.printType = getFieldByName('print_type');

      if (typeof businessCard.value.printType === 'undefined') {
        businessCard.value.printType = getFieldByName('color');
      }

      businessCard.value.form = getFieldByName('form');
      businessCard.value.material = getMaterial();
      businessCard.value.lam = getLam();
      businessCard.value.quantityTypes = getQuantityTypes(true);

      if (props.cartItem.rounding_corners === 1) {
        businessCard.value.roundingCorners = 'Скругление углов'
      }

      if (props.cartItem.cliche === 1) {
        businessCard.value.cliche = 'Заказать клише';
      }

      appendDesc('Печать ' + businessCard.value.printType?.toLowerCase());
      appendDesc(businessCard.value.form + ' форма');
      appendDesc(businessCard.value.material);
      appendDesc('Ламинация ' + businessCard.value.lam?.toLowerCase());
      appendDesc(businessCard.value.roundingCorners);
      appendDesc(businessCard.value.cliche);

      if (-1 !== Object.keys(props.cartItem).findIndex((key) => key.includes('face'))
        && props.cartItem.calculator_id !== 3832) {
        description.value += "<b>отделка лицо:</b> ";

        businessCard.value.face.color = getFieldByName('color_count_face_visitki_vip_face_select');
        businessCard.value.face.foiling = getFoiling('foiling_face');
        businessCard.value.face.embossing1 = getEmbossing('face', 1);
        businessCard.value.face.embossing2 = getEmbossing('face', 2);

        if (props.cartItem.thermal_rise_face_visitki_vip_face_select === 1) {
          businessCard.value.face.thermalRise = 'Объемный лак';
        }

        if (props.cartItem.varnish_face_visitki_vip_face_select === 1) {
          businessCard.value.face.varnish = 'Выборочный лак';
        }

        appendDesc(businessCard.value.face.color !== 'Без печати'
          ? 'Печать ' + businessCard.value.face.color?.toLowerCase()
          : businessCard.value.face.color);
        appendDesc(businessCard.value.face.foiling);
        appendDesc(businessCard.value.face.embossing1);
        appendDesc(businessCard.value.face.embossing2);
        appendDesc(businessCard.value.face.thermalRise);
        appendDesc(businessCard.value.face.varnish);
      } else if (props.cartItem.calculator_id === 3832) {
        businessCard.value.face.foiling = getFoiling('foiling_face');

        appendDesc(businessCard.value.face.foiling);
      }

      if (Object.keys(props.cartItem).findIndex((key) => key.includes('back')) !== -1) {
        description.value += "<b>отделка оборот:</b> ";

        businessCard.value.back.color = getFieldByName('color_count_back_visitki_vip_back_select');
        businessCard.value.back.foiling = getFoiling('foiling_back');
        businessCard.value.back.embossing1 = getEmbossing('back', 1);
        businessCard.value.back.embossing2 = getEmbossing('back', 2);

        if (props.cartItem.thermal_rise_back_visitki_vip_back_select === 1) {
          businessCard.value.back.thermalRise = 'Объемный лак';
        }

        if (props.cartItem.varnish_back_visitki_vip_back_select === 1) {
          businessCard.value.back.varnish = 'Выборочный лак';
        }

        appendDesc(businessCard.value.back.color !== 'Без печати'
          ? 'Печать ' + businessCard.value.back.color?.toLowerCase()
          : businessCard.value.back.color);
        appendDesc(businessCard.value.back.foiling);
        appendDesc(businessCard.value.back.embossing1);
        appendDesc(businessCard.value.back.embossing2);
        appendDesc(businessCard.value.back.thermalRise);
        appendDesc(businessCard.value.back.varnish);
      }

      appendDesc(businessCard.value.quantityTypes);

      endDesc();
    };

    const descForBooklets = () => {
      booklet.value.fold = `${props.cartItem.fold_count} сгиб${props.cartItem.fold_count !== 1 ? 'а' : ''}`;
      booklet.value.print = getFieldByName('print_select');
      booklet.value.material = getMaterial();
      booklet.value.lam = getLam();
      booklet.value.foiling = getFoiling();

      if (props.cartItem.varnish_face === 1) {
        booklet.value.varnishFace = 'Лак лицо';
      }

      if (props.cartItem.varnish_back === 1) {
        booklet.value.varnishBack = 'Лак оборот';
      }

      appendDesc(`Сложение ${booklet.value.fold}`);
      appendDesc(`Печать ${booklet.value.print?.toLowerCase()}`);
      appendDesc(booklet.value.material);
      appendDesc(`Ламинация ${booklet.value.lam?.toLowerCase()}`);
      appendDesc(booklet.value.foiling);
      appendDesc(booklet.value.varnishFace);
      appendDesc(booklet.value.varnishBack);

      endDesc();
    };

    const descForLabels = () => {
      label.value.color = getFieldByName('color');
      label.value.hole = getFieldByName('hole');
      label.value.material = getMaterial();
      label.value.lam = getLam();
      label.value.foiling = getFoiling('foiling_face');
      label.value.quantityTypes = getQuantityTypes();

      if (props.cartItem.rounding_corners === 1) {
        label.value.roundingCorners = 'Скругление углов';
      }

      if (props.cartItem.folded === 1) {
        label.value.folded = 'Изделие со сложением';
      }

      appendDesc(`Печать ${label.value.color?.toLowerCase()}`);
      appendDesc(label.value.material);
      appendDesc(`Ламинация ${label.value.lam?.toLowerCase()}`);
      appendDesc(label.value.hole);
      appendDesc(label.value.foiling);
      appendDesc(label.value.roundingCorners);
      appendDesc(label.value.folded);
      appendDesc(label.value.quantityTypes);

      endDesc();
    };

    onBeforeMount(() => {
      switch (props.calculatorType) {
        case 'stickers':
          descForStickers();
          break;
        case 'catalogs':
          descForCatalogs();
          break;
        case 'businessCards':
          descForBusinessCards();
          break;
        case 'booklets':
          descForBooklets();
          break;
        case 'labels':
          descForLabels();
          break;
      }
    });

    function getFieldByName(field) {
      return props.fieldsParams[field]?.find((item) => item.id === props.cartItem[field])?.name;
    }

    function getMaterial(materialField = 'material', colorField = `${materialField}_color`) {
      let material = '';

      props.fieldsParams[materialField]?.some((category) => {
        category.items?.some((item) => {
          if (item.id === props.cartItem[materialField]) {
            material = item.name;
            material += item.type_name?.length > 0 ? ' ' + item.type_name : '';

            item.types?.some((type) => {
              if (type.id === props.cartItem[colorField] && !material.includes(type.name)) {
                material += ' ' + type.name;

                return true;
              }
            });

            return true;
          }
        });

        return material.length > 0;
      });

      return material;
    }

    function getFoiling(foilingField = 'foiling', colorField = `${foilingField}_color`) {
      let foiling;

      foiling = props.fieldsParams[foilingField]?.data
        .find((type) => type.id === props.cartItem[foilingField])?.name;

      if (foiling?.includes('Без фольги, только печать')) {
        return null;
      }

      if (typeof props.cartItem[colorField] !== 'undefined') {
        foiling += ': ' + props.fieldsParams[foilingField].all_items
          .find((type) => type.id === props.cartItem[colorField])?.name.toLowerCase();
      }

      return foiling;
    }

    function getLam(fieldName = 'lam') {
      const lam = getFieldByName(fieldName);

      return lam !== 'Без ламинации' ? lam : null;
    }

    function getQuantityTypes(isSimple = false) {
      if (props.cartItem.quantity_types?.length < 2) {
        return null;
      }

      if (isSimple) {
        return `${declination(props.cartItem.quantity_types?.length)} по ${props.cartItem.quantity_types[0]} шт`;
      }

      let quantityTypes = '';

      quantityTypes = `${declination(props.cartItem.quantity_types?.length)} (`;

      let i = 1;
      props.cartItem.quantity_types.forEach((type) => {
        quantityTypes += `${i} вид - ${type} шт; `;
        i++;
      });

      quantityTypes = `${quantityTypes.substring(0, quantityTypes.length - 2)})`;

      return quantityTypes;
    }

    function getEmbossing(side, num) {
      let embossing;

      embossing = props.fieldsParams[`embossing_${side + num}_select_visitki_vip_${side}_select`]?.data
        .find((item) => item.id === props.cartItem[`embossing_${side + num}_select_visitki_vip_${side}_select`])?.name;

      if (embossing === 'Без тиснения') {
        return null;
      }

      if (typeof props.cartItem[`embossing_${side + num}_select_color`] !== 'undefined') {
        embossing += ': ' + props.fieldsParams[`embossing_${side + num}_select_visitki_vip_${side}_select`]
          .all_items.find((type) => type.id === props.cartItem[`embossing_${side + num}_select_color`])?.name.toLowerCase();
      }

      return embossing;
    }

    return {
      description,
      weightFormat,
    };
  },
}
</script>

<style lang="scss" scoped>
.c-item {
  &__text {
    max-width: 90%;
  }
}

.design-error {
  color: #eb444c;
}

@media all and (min-width: 768px) {
  .design-error {
    display: none;
  }
}
</style>
