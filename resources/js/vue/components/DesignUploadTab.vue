<template>
  <div class="files-upload files-upload_vertical design-modal__main-content design-upload__main" data-type="design">
    <input class="files-upload__inp" type="text" name="privileges-photo" id="privileges-photo" value="ааа">
    <div class="files-upload__dropzone-holder design-upload__w-100">
      <div class="hidden-md"> Максимальный объем одного файла — 100 МВ. Допустимые форматы файлов:
        jpg, png, tif, svg, pdf, ai, psd
      </div>
      <div v-bind="getRootProps()" class="dropzone files-upload__dropzone">
        <div class="files-upload__accepted files-upload__accepted_mob design-upload__text no-mobile">
          <input class="no-mobile" v-bind="getInputProps()">
          Перетащите необходимые файлы в это поле или кликните для загрузки. Максимальный объем одного файла — 100 МВ
        </div>
        <span class="hidden-md">Загрузить файлы</span>
      </div>
      <div class="files-upload__accepted files-upload__accepted_dt">Допустимые форматы файлов: jpg,
        png, tif, svg, pdf, ai, psd
      </div>
    </div>
    <div class="files-upload__content">
      <div v-show="files.length !== 0" class="files-upload__title">
        Загруженные файлы:
      </div>
      <div class="files-upload__previews">
        <div class="dz-filename" v-for="file in files" :key="file.id">
          {{ file.file_name }}
          <button class="dz-remove" @click="deleteFile(file.id)"> Удалить</button>
        </div>
      </div>
    </div>
    <div class="modal-form__field design-upload__w-100 no-mobile">
      <textarea type="text" required class="input input_area input_wide" rows="3" id="comment" name="comment"
                placeholder="Комментарий к макетам — если необходимо, уточните, какие изменения нужно внести в ваши макеты"></textarea>
    </div>
  </div>
  <div class="modal-footer modal-footer_left modal-footer_lg">
    <div class="design-modal__footer">
      <div class="design-modal__footer__info">
      </div>
      <div class="design-modal__footer__btn">
        <CalcButton
          @click="onChoose"
          class="design-modal__footer__submit">
          Выбрать
        </CalcButton>
      </div>
    </div>
  </div>
</template>

<script>
import CalcButton from "@/components/CalcButton";
import {useDropzone} from "vue3-dropzone";
import useFiles from "@/composables/useFiles";

export default {
  name: "DesignUploadTab",
  components: {CalcButton},
  emits: ['chooseFiles'],

  setup(props, context) {
    const {files, setFiles, saveFiles, deleteFile} = useFiles();
    const accept = ['image/*', '.pdf', '.ai', '.psd'];
    const maxSize = 104857600;

    const {getRootProps, getInputProps, ...rest} = useDropzone({onDrop, accept, maxSize});

    setFiles();

    function onDrop(acceptFiles, rejectReasons) {
      saveFiles(acceptFiles);
      if (rejectReasons.length !== 0) {
        console.error(rejectReasons);
      }
    }

    const onChoose = () => {
      const textarea = document.querySelector("#comment");
      context.emit('chooseFiles', textarea.value.trim());
    }

    return {
      getRootProps,
      getInputProps,
      ...rest,
      files,
      deleteFile,
      onChoose
    };
  }
}
</script>

<style lang="scss" scoped>
.dropzone {
  cursor: pointer;
}

.design-upload {
  &__main {
    margin-top: 24px;
    padding-bottom: 16px;
  }

  &__w-100 {
    width: 100%;
  }

  &__text {
    position: absolute;
    display: block;
    z-index: 100;
    top: 10px;
    left: 10px;
  }
}

@media all and (max-width: 767px) {
  .no-mobile {
    display: none;
  }
}
</style>
