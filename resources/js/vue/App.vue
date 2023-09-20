<template>
  <div v-if="!isLoading && types.length">
    <Types v-if="types.length > 1 && !+onlyDefaultCalculatorId" :types="types"/>
    <Calc/>
  </div>
  <div v-if="isLoading" class="loader-holder">
    <Preloader/>
  </div>
</template>

<script>
import {onBeforeMount, ref, watch} from "vue";
import Types from "./components/Types";
import Calc from "./components/Calc";
import useTypes from "./composables/useTypes";
import useFormSchema from "./composables/useFormSchema";
import useInitData from "./composables/useInitData";
import Preloader from "./components/Preloader";
import useRoute from "./composables/useRoute";
import useTooltips from "@/composables/useTooltips";
import useDeps from "@/composables/useDeps";

export default {
  name: 'App',
  props: {
    calculator: String,
    onlyDefaultCalculatorId: String,
  },
  components: {
    Preloader,
    Types,
    Calc,
  },
  setup(props) {
    const {types, setTypes, activeType} = useTypes();
    const {setSchema, setSchemaLoading, page} = useFormSchema();
    const {tooltips} = useTooltips();
    const {setData} = useInitData();
    const {setOrigin, origin} = useRoute();
    const {setConfigDeps} = useDeps();
    const isLoading = ref(true);
    let configAbortController = null;

    onBeforeMount(async () => {
      try {
        setOrigin(window.location.origin);
        // const response = await fetch(props.types);
        // const data = await response.json();
        setTypes(JSON.parse(props.calculator));
        isLoading.value = false;
      } catch (err) {
        console.log(err)
      }
    });
    watch(activeType, async (newValue) => {
      try {
        setSchemaLoading();

        if (configAbortController) {
          configAbortController.abort();
        }

        configAbortController = new AbortController;

        const response = await fetch(`${origin.value}/api/calculator/config/${newValue.id}`, {
          signal: configAbortController.signal
        });
        const data = await response.json();
        setSchema(data.formSchema);
        tooltips.value = data.formSchema.tooltips;
        setData(data.data);
        page.value = data.page;

        if (data.formSchema.deps) {
          setConfigDeps(data.formSchema.deps);
        }

        configAbortController = null;
      } catch (err) {
        console.log(err)
      }
    })

    return {
      types,
      isLoading
    }
  }
}
</script>

<style>
#app {
  font-family: Inter, Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  margin-top: 60px;
}

.loader-holder {
  height: 400px;
  display: flex;
  align-items: center;
  justify-content: center;
}

.scroll-lock {
  overflow: hidden;
}
</style>
