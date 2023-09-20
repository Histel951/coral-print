<template>
  <div class="files-upload">
    <div class="files-upload design-upload__main">
      <input class="files-upload__inp" type="text" name="privileges-photo"
             id="privileges-photo">
      <div class="files-upload__dropzone-holder">
        <div class="files-upload__accepted files-upload__accepted_mob">Если вам нужно
          отправить нам макет. Максимальный объем одного файла — 100 МВ. Допустимые
          форматы файлов: jpg, png, tif, svg, pdf, ai, psd
        </div>
        <div v-bind="getRootProps()" class="dropzone files-upload__dropzone files-upload__dropzone_cart dz-clickable">
          <input v-bind="getInputProps()"/>
          <span class="hidden-md">Загрузить файлы</span>
          <div class="dz-default dz-message">
            <button class="dz-button" type="button"> Перетащите необходимые файлы в это поле или кликните для загрузки.
              Максимальный объем одного файла — 100 МВ
            </button>
          </div>
        </div>
        <div class="files-upload__accepted files-upload__accepted_dt">Допустимые
          форматы
          файлов: jpg, png, tif, svg, pdf, ai, psd
        </div>
      </div>
      <div class="files-upload__content">
        <div v-show="files.length !== 0" class="files-upload__title">
          Загруженные файлы:
        </div>
        <div v-show="files.length !== 0" class="files-upload__previews">
          <div class="dz-filename" v-for="file in files" :key="file.id">
            {{ file.file_name }}
            <button class="dz-remove" @click="deleteFile(file.id)"> Удалить</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import useFiles from "@/composables/useFiles";
import {useDropzone} from "vue3-dropzone";
import axios from "axios";
import {ref} from "vue";

export default {
  name: "DesignUpload",
  props: {
    filesList: Array
  },
  emits: ['filesChanged'],

  setup(props, context) {
    const files = ref(props.filesList);

    const {deleteFileRequest} = useFiles();
    const accept = ['image/*', '.pdf', '.ai', '.psd'];
    const maxSize = 104857600;

    const {getRootProps, getInputProps, ...rest} = useDropzone({onDrop, accept, maxSize});

    function onDrop(acceptFiles, rejectReasons) {
      saveFiles(acceptFiles, sessionStorage);
      if (rejectReasons.length !== 0) {
        console.error(rejectReasons);
      }
    }

    const saveFiles = async (uploadedFiles) => {
      for (let i = 0; i < uploadedFiles.length; i++) {
        const formData = new FormData();
        formData.append("file[0]", uploadedFiles[i]);
        await axios.post('/upload_files?type=temp-designs', formData, {
          headers: {
            "Content-Type": uploadedFiles[i].type,
          }
        })
          .then((response) => {
            files.value.push({
              id: response.data.file_id[0],
              file_name: uploadedFiles[i].name
            });

            context.emit('filesChanged');
          })
          .catch((err) => {
            console.error(err);
          });
      }
    };

    const deleteFile = (id) => {
      files.value.splice(files.value.findIndex((file) => file.id === id), 1);
      deleteFileRequest(id);

      context.emit('filesChanged');
    };

    return {
      files,
      deleteFile,
      getInputProps,
      getRootProps,
      ...rest
    };
  }
}
</script>

<style lang="scss" scoped>
.files-upload {
  display: flex;
  align-items: flex-start;
  flex-grow: 1;
}

@media all and (min-width: 1024px) {
  .files-upload {
    &__main {
      flex-basis: max-content;
    }
  }
}
</style>
