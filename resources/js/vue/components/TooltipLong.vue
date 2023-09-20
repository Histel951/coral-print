<template>
  <FieldModal :opened="opened" size="lg" :title="tooltip.header" class="title" typeModal="tooltip"
              headerCloseClasses="close-btn">
    <ModalContent size="lg">
      <div v-html="tooltip.content"></div>
    </ModalContent>
  </FieldModal>
</template>

<script>
import FieldModal from '@/components/modals/FieldModal';
import ModalContent from '@/components/modals/ModalContent';

export default {
  name: 'TooltipLong',
  components: {ModalContent, FieldModal},
  props: {
    tooltip: Object,
    tooltipOpened: Boolean,
    opened: Boolean,
  },
};
</script>

<style lang="scss">
#calc .header {
  font-style: normal;
  font-weight: 600;
  font-size: 18px;
  line-height: 21px;
  color: #00195A;
  padding-bottom: 10px;
  order: 1;
}

#calc .txt {
  font-style: normal;
  font-weight: 400;
  font-size: 14px;
  line-height: 21px;
  order: 3;

  &__svg {
    text-align: center;
    font-style: normal;
    font-weight: 400;
    font-size: 14px;
    line-height: 21px;
    order: 3;
  }
}

#calc .flex-container {
  display: flex;
  flex-direction: column;
  margin-top: 24px;
  padding-bottom: 24px;
  border-bottom: 1px solid #d6dee3;

  &__svg {
    display: flex;
    flex-direction: column;
    margin-top: 24px;
    padding-bottom: 24px;
    border-bottom: 1px solid #d6dee3;
    align-items: center;
  }
}

#calc .flex-container:last-child {
  border-bottom: none;
}

#calc .main-content {
  font-style: normal;
  font-weight: 400;
  font-size: 15px;
  line-height: 130%;
  color: #1E1E1E;
  margin-top: -15px;
}

#calc .img {
  display: block;
  order: 2;
  margin-bottom: 16px;
}

#calc .title {
  text-align: left;
  font-style: normal;
  font-weight: 600;
  font-size: 22px;
  line-height: 26px;
  color: #00195A;
}

#calc .close-btn {
  position: absolute;
  right: 10px;
  top: 10px;
}

@media all and (min-width: 425px) {
  #calc .flex-container {
    display: table;

    &__svg {
      display: table;
    }
  }

  #calc .img {
    width: 140px;
    height: 140px;
    margin-right: 28px;
    margin-left: 11px;
    margin-bottom: 0;
    float: left;
  }

  #calc .txt {
    display: flex;

    &__svg {
      display: flex;
      text-align: left;
    }
  }

  #calc .header {
    display: flex;
  }
}
</style>
